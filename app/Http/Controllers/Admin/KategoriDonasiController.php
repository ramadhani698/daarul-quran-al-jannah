<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\KategoriDonasiRequest;
use App\Models\KategoriDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class KategoriDonasiController extends Controller
{
    public function index()
    {
        $kategoris = KategoriDonasi::withCount('programs')
            ->orderBy('urutan')
            ->get();

        return view('backend.kategori-donasi.index', compact('kategoris'));
    }

    public function create()
    {
        return view('backend.kategori-donasi.create');
    }

    public function store(KategoriDonasiRequest $request)
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            $data['icon'] = $request->file('icon')->store('kategori-donasi', 'public');
        }

        if (empty($data['urutan'])) {
            $data['urutan'] = KategoriDonasi::max('urutan') + 1;
        }

        KategoriDonasi::create($data);

        return redirect()
            ->route('admin.kategori-donasi.index')
            ->with('success', 'Kategori donasi berhasil ditambahkan.');
    }

    public function edit(KategoriDonasi $kategori_donasi)
    {
        return view('backend.kategori-donasi.edit', ['kategori' => $kategori_donasi]);
    }

    public function update(KategoriDonasiRequest $request, KategoriDonasi $kategori_donasi)
    {
        $data = $request->validated();

        if ($request->hasFile('icon')) {
            if ($kategori_donasi->icon && Storage::disk('public')->exists($kategori_donasi->icon)) {
                Storage::disk('public')->delete($kategori_donasi->icon);
            }
            $data['icon'] = $request->file('icon')->store('kategori-donasi', 'public');
        }

        $kategori_donasi->update($data);

        return redirect()
            ->route('admin.kategori-donasi.index')
            ->with('success', 'Kategori donasi berhasil diperbarui.');
    }

    public function destroy(KategoriDonasi $kategori_donasi)
    {
        try {
            if ($kategori_donasi->icon && Storage::disk('public')->exists($kategori_donasi->icon)) {
                Storage::disk('public')->delete($kategori_donasi->icon);
            }

            $kategori_donasi->delete();

            return redirect()
                ->route('admin.kategori-donasi.index')
                ->with('success', 'Kategori donasi berhasil dihapus.');
        } catch (\Throwable $e) {
            // Menangkap exception dari guard di model (data masih dipakai program)
            // maupun error tak terduga lain (misal constraint FK level database)
            return redirect()
                ->route('admin.kategori-donasi.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki program donasi terkait.');
        }
    }

    public function toggleActive(KategoriDonasi $kategori_donasi)
    {
        $kategori_donasi->update(['is_active' => ! $kategori_donasi->is_active]);

        return response()->json([
            'success' => true,
            'is_active' => $kategori_donasi->is_active,
        ]);
    }

    public function updateUrutan(Request $request)
    {
        $request->validate([
            'urutan' => 'required|array',
            'urutan.*' => 'exists:kategori_donasis,id',
        ]);

        foreach ($request->urutan as $index => $id) {
            KategoriDonasi::where('id', $id)->update(['urutan' => $index]);
        }

        return response()->json(['success' => true]);
    }
}