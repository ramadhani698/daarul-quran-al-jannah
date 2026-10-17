<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\VerifikasiDonasiRequest;
use App\Models\Donasi;
use Illuminate\Http\Request;

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

    public function update(VerifikasiDonasiRequest $request, Donasi $donasi)
    {
        if ($request->status === 'verified' && blank($donasi->bukti_transfer)) {
            return back()->withErrors([
                'status' => 'Donasi belum bisa diverifikasi karena donatur belum upload bukti transfer.',
            ]);
        }
        $donasi->update($request->validated());

        $routeTujuan = $donasi->program->is_umum
            ? 'admin.donasi.non-program'
            : 'admin.donasi.program';

        $pesan = $donasi->status === 'verified'
            ? 'Donasi berhasil diverifikasi.'
            : 'Donasi ditolak.';

        return redirect()->route($routeTujuan)->with('success', $pesan);
    }
}