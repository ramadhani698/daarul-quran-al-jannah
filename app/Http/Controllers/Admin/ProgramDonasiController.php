<?php

namespace App\Http\Controllers\Admin;

use App\Exports\RekapDonasiExport;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProgramDonasiRequest;
use App\Models\KategoriDonasi;
use App\Models\ProgramDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Facades\Excel;

class ProgramDonasiController extends Controller
{
    // Tab: aktif (default), berakhir (lewat tanggal_selesai), arsip (soft-deleted)
    public function index(Request $request)
    {
        $tab = $request->get('tab', 'aktif');

        $query = ProgramDonasi::with('kategori')->withCount('donasis');

        match ($tab) {
            'berakhir' => $query->whereNotNull('tanggal_selesai')->where('tanggal_selesai', '<', now()),
            'arsip' => $query->onlyTrashed(),
            default => $query->where(function ($q) {
                $q->whereNull('tanggal_selesai')->orWhere('tanggal_selesai', '>=', now());
            }),
        };

        $programs = $query->latest()->paginate(10)->withQueryString();

        return view('backend.program-donasi.index', compact('programs', 'tab'));
    }

    public function create()
    {
        $kategoris = KategoriDonasi::where('is_active', true)->orderBy('urutan')->get();

        return view('backend.program-donasi.create', compact('kategoris'));
    }

    public function store(ProgramDonasiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            $data['gambar'] = $request->file('gambar')->store('program-donasi', 'public');
        }

        ProgramDonasi::create($data);

        return redirect()
            ->route('admin.program-donasi.index')
            ->with('success', 'Program donasi berhasil ditambahkan.');
    }

    public function edit(ProgramDonasi $program_donasi)
    {
        $kategoris = KategoriDonasi::where('is_active', true)->orderBy('urutan')->get();

        return view('backend.program-donasi.edit', [
            'program' => $program_donasi,
            'kategoris' => $kategoris,
        ]);
    }

    public function update(ProgramDonasiRequest $request, ProgramDonasi $program_donasi)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            if ($program_donasi->gambar && Storage::disk('public')->exists($program_donasi->gambar)) {
                Storage::disk('public')->delete($program_donasi->gambar);
            }
            $data['gambar'] = $request->file('gambar')->store('program-donasi', 'public');
        }

        $program_donasi->update($data);

        return redirect()
            ->route('admin.program-donasi.index')
            ->with('success', 'Program donasi berhasil diperbarui.');
    }

    public function toggleActive(ProgramDonasi $program_donasi)
    {
        $program_donasi->update(['is_active' => ! $program_donasi->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $program_donasi->is_active,
        ]);
    }

    // ============================================================
    // FLOW HAPUS 3-LAPIS
    // ============================================================

    // Lapis persiapan: tampilkan ringkasan + wajibkan unduh rekap dulu
    public function confirmHapus(ProgramDonasi $program_donasi)
    {
        if ($program_donasi->is_umum) {
            return redirect()
                ->route('admin.program-donasi.index')
                ->with('error', 'Program umum tidak dapat dihapus. Nonaktifkan kategorinya jika ingin menutup fitur ini.');
        }

        $totalDonasi = $program_donasi->donasis()->count();
        $totalVerified = $program_donasi->donasisVerified()->sum('nominal');

        return view('backend.program-donasi.konfirmasi-hapus', [
            'program' => $program_donasi,
            'totalDonasi' => $totalDonasi,
            'totalVerified' => $totalVerified,
            'sudahUnduhRekap' => session()->has("rekap_diunduh_{$program_donasi->id}"),
        ]);
    }

    // Lapis 1: unduh rekap Excel, tandai di sesi bahwa rekap sudah diunduh
    public function exportRekap(ProgramDonasi $program_donasi)
    {
        session(["rekap_diunduh_{$program_donasi->id}" => true]);

        return Excel::download(
            new RekapDonasiExport($program_donasi),
            "rekap-{$program_donasi->slug}.xlsx"
        );
    }

    // Lapis 2 & 3: validasi checklist + ketik ulang nama, baru soft delete
    public function destroy(Request $request, ProgramDonasi $program_donasi)
    {
        if ($program_donasi->is_umum) {
            return redirect()
                ->route('admin.program-donasi.index')
                ->with('error', 'Program umum tidak dapat dihapus.');
        }

        $request->validate([
            'sudah_direkap' => ['required', 'accepted'],
            'konfirmasi_nama' => ['required', 'string'],
        ], [
            'sudah_direkap.accepted' => 'Anda harus menyatakan data sudah direkap.',
            'konfirmasi_nama.required' => 'Nama program wajib diketik ulang untuk konfirmasi.',
        ]);

        // Lapis 1: pastikan rekap benar-benar sudah diunduh di sesi ini,
        // bukan cuma dicentang tanpa benar-benar diunduh
        if (! session()->has("rekap_diunduh_{$program_donasi->id}")) {
            return back()->withErrors([
                'rekap' => 'Silakan unduh rekap donasi terlebih dahulu sebelum menghapus.',
            ]);
        }

        // Lapis 2: nama harus diketik ulang persis
        if ($request->konfirmasi_nama !== $program_donasi->nama_program) {
            return back()->withErrors([
                'konfirmasi_nama' => 'Nama program yang diketik tidak sesuai.',
            ]);
        }

        // Lapis 3: soft delete, bukan hapus permanen
        $program_donasi->delete();
        session()->forget("rekap_diunduh_{$program_donasi->id}");

        return redirect()
            ->route('admin.program-donasi.index')
            ->with('success', 'Program berhasil dihapus. Data dapat dipulihkan dari tab Arsip jika diperlukan.');
    }

    // Pulihkan dari tab Arsip
    public function restore(int $id)
    {
        $program = ProgramDonasi::onlyTrashed()->findOrFail($id);
        $program->restore();

        return redirect()
            ->route('admin.program-donasi.index', ['tab' => 'arsip'])
            ->with('success', "Program '{$program->nama_program}' berhasil dipulihkan.");
    }
}