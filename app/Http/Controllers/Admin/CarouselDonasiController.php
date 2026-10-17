<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CarouselDonasiRequest;
use App\Models\CarouselDonasi;
use App\Models\ProgramDonasi;
use Illuminate\Support\Facades\Storage;

class CarouselDonasiController extends Controller
{
    public function index()
    {
        $carousels = CarouselDonasi::with('program')
            ->orderBy('urutan')
            ->orderBy('id')
            ->get();

        return view('backend.carousel-donasi.index', compact('carousels'));
    }

    public function create()
    {
        return view('backend.carousel-donasi.create', [
            'programs' => $this->daftarProgram(),
        ]);
    }

    public function store(CarouselDonasiRequest $request)
    {
        $data = $request->validated();

        $data['gambar'] = $request->file('gambar')->store('carousel-donasi', 'public');
        $data['urutan'] = $request->filled('urutan')
            ? $request->integer('urutan')
            : (CarouselDonasi::max('urutan') + 1);

        CarouselDonasi::create($data);

        return redirect()
            ->route('admin.carousel-donasi.index')
            ->with('success', 'Banner carousel berhasil ditambahkan.');
    }

    public function edit(CarouselDonasi $carousel_donasi)
    {
        return view('backend.carousel-donasi.edit', [
            'carousel' => $carousel_donasi,
            'programs' => $this->daftarProgram(),
        ]);
    }

    public function update(CarouselDonasiRequest $request, CarouselDonasi $carousel_donasi)
    {
        $data = $request->validated();

        if ($request->hasFile('gambar')) {
            Storage::disk('public')->delete($carousel_donasi->gambar);
            $data['gambar'] = $request->file('gambar')->store('carousel-donasi', 'public');
        } else {
            unset($data['gambar']); // nggak diganti, pakai gambar lama
        }

        if (!$request->filled('urutan')) {
            unset($data['urutan']); // kosong, pertahankan urutan lama
        }

        $carousel_donasi->update($data);

        return redirect()
            ->route('admin.carousel-donasi.index')
            ->with('success', 'Banner carousel berhasil diperbarui.');
    }

    public function destroy(CarouselDonasi $carousel_donasi)
    {
        Storage::disk('public')->delete($carousel_donasi->gambar);
        $carousel_donasi->delete();

        return redirect()
            ->route('admin.carousel-donasi.index')
            ->with('success', 'Banner carousel berhasil dihapus.');
    }

    public function toggle(CarouselDonasi $carousel_donasi)
    {
        $carousel_donasi->update(['is_aktif' => !$carousel_donasi->is_aktif]);

        return back()->with('success', 'Status banner diperbarui.');
    }

    // Dropdown program di form: cuma yg aktif & belum diarsip
    private function daftarProgram()
    {
        return ProgramDonasi::where('is_active', true)
            ->orderBy('nama_program')
            ->get(['id', 'nama_program']);
    }
}