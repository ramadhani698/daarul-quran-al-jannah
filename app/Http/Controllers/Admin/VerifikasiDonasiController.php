<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiDonasiRequest;
use App\Models\Donasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class VerifikasiDonasiController extends Controller
{
    // "Donasi Program" — donasi yang masuk ke program spesifik (is_umum = false)
    public function program(Request $request)
    {
        return $this->renderIndex($request, false, 'Donasi Program', 'admin.donasi.program');
    }

    // "Donasi Non Program" — donasi yang masuk ke program umum (Sedekah/Zakat/Wakaf umum)
    public function nonProgram(Request $request)
    {
        return $this->renderIndex($request, true, 'Donasi Non Program', 'admin.donasi.non-program');
    }

    private function renderIndex(Request $request, bool $isUmum, string $title, string $routeName)
    {
        $status = $request->get('status', 'pending');

        $donasis = Donasi::sudahMasukAntrean()
            ->whereHas('program', fn ($q) => $q->where('is_umum', $isUmum))
            ->when($status !== 'semua', fn ($q) => $q->where('status', $status))
            ->with('program')
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('backend.donasi.index', compact('donasis', 'status', 'title', 'routeName'));
    }

    // Halaman detail donasi + form verifikasi (dipakai bareng dari kedua tab)
    public function show(Donasi $donasi)
    {
        $donasi->load('program.kategori');
        $title = 'Verifikasi Donasi — ' . $donasi->kode_donasi;

        return view('backend.donasi.verifikasi', compact('donasi', 'title'));
    }

    public function bukti(Donasi $donasi)
    {
        abort_unless($donasi->bukti_transfer, 404);

        if (Storage::disk('local')->exists($donasi->bukti_transfer)) {
            return Storage::disk('local')->response($donasi->bukti_transfer);
        }

        if (Storage::disk('public')->exists($donasi->bukti_transfer)) {
            return Storage::disk('public')->response($donasi->bukti_transfer);
        }

        abort(404);
    }

    public function update(VerifikasiDonasiRequest $request, Donasi $donasi)
    {
        return DB::transaction(function () use ($request, $donasi) {
            $lockedDonasi = Donasi::where('id', $donasi->id)->lockForUpdate()->firstOrFail();

            // status guard: tolak kalau status berubah sejak halaman dibuka
            if ($lockedDonasi->status !== $request->input('status_awal')) {
                return back()->withErrors([
                    'status' => 'Status donasi ini sudah berubah (diproses admin lain atau donatur kirim ulang bukti). Muat ulang halaman untuk melihat status terbaru.',
                ]);
            }

            if ($request->status === 'verified' && blank($lockedDonasi->bukti_transfer)) {
                return back()->withErrors([
                    'status' => 'Donasi belum bisa diverifikasi karena donatur belum upload bukti transfer.',
                ]);
            }

            $lockedDonasi->forceFill([
                'status' => $request->validated('status'),
                'catatan_admin' => $request->validated('catatan_admin'),
            ])->save();

            $routeTujuan = $lockedDonasi->program && $lockedDonasi->program->is_umum
                ? 'admin.donasi.non-program'
                : 'admin.donasi.program';

            $pesan = $lockedDonasi->status === 'verified'
                ? 'Donasi berhasil diverifikasi.'
                : 'Donasi ditolak.';

            return redirect()->route($routeTujuan)->with('success', $pesan);
        });
    }
}
