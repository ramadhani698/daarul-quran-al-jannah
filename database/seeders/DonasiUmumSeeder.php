<?php

namespace Database\Seeders;

use App\Models\KategoriDonasi;
use App\Models\ProgramDonasi;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class DonasiUmumSeeder extends Seeder
{
    public function run(): void
    {
        $data = [
            [
                'nama' => 'Zakat',
                'icon_file' => 'icon-zakat.png',
                'deskripsi_umum' => 'Penyaluran zakat sesuai syariat untuk santri yatim dan dhuafa.',
            ],
            [
                'nama' => 'Infaq',
                'icon_file' => 'icon-infaq.png',
                'deskripsi_umum' => 'Infaq tanpa program khusus, disalurkan untuk kebutuhan santri dan pesantren.',
            ],
            [
                'nama' => 'Sedekah',
                'icon_file' => 'icon-sedekah.png',
                'deskripsi_umum' => 'Sedekah tanpa program khusus, disalurkan untuk kebutuhan operasional pesantren.',
            ],
            [
                'nama' => 'Wakaf',
                'icon_file' => 'icon-wakaf.png',
                'deskripsi_umum' => 'Wakaf tanpa program khusus, dikelola untuk pengembangan fasilitas pesantren.',
            ],
        ];

        foreach ($data as $i => $item) {
            // Path DB dibuat SAMA formatnya kayak hasil upload lewat form,
            // yaitu "kategori-donasi/{nama_file}" — biar konsisten mau data
            // datang dari seeder atau dari admin yang upload manual.
            $iconPath = 'kategori-donasi/' . $item['icon_file'];

            // Sumber file asli disimpan di folder git-tracked, BUKAN langsung
            // di storage/app/public, supaya filenya ikut ke-commit dan nggak
            // hilang pas server baru / fresh deploy belum pernah upload manual.
            $sourcePath = database_path('seeders/assets/kategori-donasi/' . $item['icon_file']);
            $iconTersedia = file_exists($sourcePath);

            // Kalau file icon-nya belum ada (misal belum sempat didesain),
            // biarkan kolom icon null — nanti tampilan admin & frontend
            // otomatis fallback ke huruf inisial, bukan gambar rusak.
            if ($iconTersedia && ! Storage::disk('public')->exists($iconPath)) {
                Storage::disk('public')->put($iconPath, file_get_contents($sourcePath));
            }

            $kategori = KategoriDonasi::firstOrCreate(
                ['slug' => Str::slug($item['nama'])],
                [
                    'nama' => $item['nama'],
                    'icon' => $iconTersedia ? $iconPath : null,
                    'is_active' => true,
                    'urutan' => $i,
                ]
            );

            ProgramDonasi::firstOrCreate(
                ['kategori_donasi_id' => $kategori->id, 'is_umum' => true],
                [
                    'nama_program' => $item['nama'] . ' Umum',
                    'deskripsi' => $item['deskripsi_umum'],
                    'target_donasi' => null,
                    'tanggal_mulai' => now(),
                    'tanggal_selesai' => null,
                    'is_active' => true,
                ]
            );
        }

        $this->command->info(count($data) . ' kategori donasi beserta program umum-nya berhasil di-seed.');
    }
}
