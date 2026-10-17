<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use App\Models\Alumni;
use App\Models\Berita;
use App\Models\Evaluasi;
use App\Models\InfoSantri;
use App\Models\JadwalHarian;
use App\Models\Kurikulum;
use App\Models\Prestasi;
use App\Models\Galeri;
use App\Models\Produk;
use App\Models\Donasi;
use App\Models\ProgramDonasi;
use Illuminate\Support\Facades\DB;
use App\Services\GoogleSheetService;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index(GoogleSheetService $sheet)
    {
        $now = now();

        // ================= PENDAFTARAN (Google Sheets) =================
        $pendaftarError = false;
        $pendaftarStats = [
            'total'          => 0,
            'hari_ini'       => 0,
            'bulan_ini'      => 0,
            'provinsi_top'   => '-',
            'provinsi_total' => 0,
        ];

        try {
            $pendaftar = collect($sheet->getPendaftarForTable())->map(function ($row) {
                $row['tgl'] = $this->parseTanggal($row['tanggal_daftar'] ?? null);
                return $row;
            });

            $pendaftarStats['total'] = $pendaftar->count();

            $pendaftarStats['hari_ini'] = $pendaftar
                ->filter(fn ($r) => $r['tgl'] && $r['tgl']->isSameDay($now))
                ->count();

            $pendaftarStats['bulan_ini'] = $pendaftar
                ->filter(fn ($r) => $r['tgl'] && $r['tgl']->isSameMonth($now))
                ->count();

            $perProvinsi = $pendaftar
                ->map(fn ($r) => mb_convert_case(trim($r['provinsi'] ?? ''), MB_CASE_TITLE))
                ->filter()
                ->countBy()
                ->sortDesc();

            if ($perProvinsi->isNotEmpty()) {
                $pendaftarStats['provinsi_top']   = $perProvinsi->keys()->first();
                $pendaftarStats['provinsi_total'] = $perProvinsi->first();
            }
        } catch (\Throwable $e) {
            report($e);
            $pendaftarError = true;
        }

        // ================= KONTEN WEBSITE =================
        $stats = [
            'berita' => [
                'total'  => Berita::count(),
                'terbit' => Berita::where('status', 'terbit')->count(),
                'draf'   => Berita::where('status', 'draf')->count(),
            ],

            'akademik' => Kurikulum::count()
                + JadwalHarian::count()
                + Evaluasi::count()
                + Prestasi::count()
                + Agenda::count(),

            'santri' => InfoSantri::count(),

            'alumni' => [
                'total'   => Alumni::count(),
                'sebaran' => Alumni::where('tipe', 'sebaran')->count(),
                'kiprah'  => Alumni::where('tipe', 'kiprah')->count(),
            ],

            'galeri' => Galeri::count(),

            'produk' => Produk::count(),
        ];

        // ================= DONASI =================
        // Pending yang udah upload bukti = perlu aksi admin. Dipecah program / umum.
        $pending = DB::table('donasis')
            ->join('program_donasis', 'program_donasis.id', '=', 'donasis.program_donasi_id')
            ->where('donasis.status', 'pending')
            ->whereNotNull('donasis.bukti_transfer')
            ->groupBy('program_donasis.is_umum')
            ->selectRaw('program_donasis.is_umum as umum, COUNT(*) as total')
            ->pluck('total', 'umum');

        $pendingProgram = (int) ($pending[0] ?? 0);
        $pendingUmum    = (int) ($pending[1] ?? 0);

        $donasiStats = [
            'pending_program' => $pendingProgram,
            'pending_umum'    => $pendingUmum,
            'pending'         => $pendingProgram + $pendingUmum,
            'terkumpul'       => (int) Donasi::where('status', 'verified')->sum('nominal'),
            'program_aktif'   => ProgramDonasi::where('is_active', true)
                                    ->where('is_umum', false)
                                    ->count(),
        ];

        // Grafik per bulan: 6 bulan terakhir, bulan kosong tetap tampil 0
        $perBulan = Donasi::where('status', 'verified')
            ->where('created_at', '>=', $now->copy()->subMonths(5)->startOfMonth())
            ->get(['nominal', 'created_at'])
            ->groupBy(fn ($d) => $d->created_at->format('Y-m'))
            ->map(fn ($g) => (int) $g->sum('nominal'));

        $chartBulan = ['labels' => [], 'data' => []];
        for ($i = 5; $i >= 0; $i--) {
            $m = $now->copy()->subMonths($i);
            $chartBulan['labels'][] = $m->translatedFormat('M Y');
            $chartBulan['data'][]   = $perBulan[$m->format('Y-m')] ?? 0;
        }

        // Grafik per kategori (join manual, jadi program yang ke-arsip tetap kehitung)
        $perKategori = DB::table('donasis')
            ->join('program_donasis', 'program_donasis.id', '=', 'donasis.program_donasi_id')
            ->join('kategori_donasis', 'kategori_donasis.id', '=', 'program_donasis.kategori_donasi_id')
            ->where('donasis.status', 'verified')
            ->groupBy('kategori_donasis.nama')
            ->select('kategori_donasis.nama', DB::raw('SUM(donasis.nominal) as total'))
            ->pluck('total', 'nama');

        $chartKategori = [
            'labels' => $perKategori->keys()->values(),
            'data'   => $perKategori->values()->map(fn ($v) => (int) $v),
        ];

        return view('backend.dashboard', compact(
            'pendaftarStats', 'pendaftarError', 'stats',
            'donasiStats', 'chartBulan', 'chartKategori'
        ));
    }

    /**
     * Timestamp dari Google Sheet formatnya bisa beda-beda, jadi dicoba beberapa format.
     * Kalau semua gagal, return null (baris dilewati di hitungan hari ini/bulan ini).
     */
    private function parseTanggal(?string $value): ?Carbon
    {
        if (! $value) {
            return null;
        }

        foreach (['d/m/Y H:i:s', 'd/m/Y', 'Y-m-d H:i:s', 'Y-m-d'] as $format) {
            try {
                $date = Carbon::createFromFormat($format, trim($value));
                if ($date !== false) {
                    return $date;
                }
            } catch (\Throwable $e) {
                // coba format berikutnya
            }
        }

        return null;
    }
}