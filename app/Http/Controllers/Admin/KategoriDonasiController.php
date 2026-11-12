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
        $iconLama = null;

        if ($request->hasFile('icon')) {
            $iconLama = $kategori_donasi->icon;
            $data['icon'] = $request->file('icon')->store('kategori-donasi', 'public');
        }

        $kategori_donasi->update($data);

        if ($iconLama && Storage::disk('public')->exists($iconLama)) {
            Storage::disk('public')->delete($iconLama);
        }

        return redirect()
            ->route('admin.kategori-donasi.index')
            ->with('success', 'Kategori donasi berhasil diperbarui.');
    }

    public function destroy(KategoriDonasi $kategori_donasi)
    {
        $icon = $kategori_donasi->icon;

        try {
            $kategori_donasi->delete();
        } catch (\Throwable $e) {
            // Guard di model (masih dipakai program) atau constraint FK database
            report($e);

            return redirect()
                ->route('admin.kategori-donasi.index')
                ->with('error', 'Kategori tidak dapat dihapus karena masih memiliki program donasi terkait.');
        }

        // File fisik baru dihapus setelah record benar-benar terhapus
        if ($icon && Storage::disk('public')->exists($icon)) {
            Storage::disk('public')->delete($icon);
        }

        return redirect()
            ->route('admin.kategori-donasi.index')
            ->with('success', 'Kategori donasi berhasil dihapus.');
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