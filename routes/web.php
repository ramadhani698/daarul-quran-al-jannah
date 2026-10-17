<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CarouselController as AdminCarouselController;
use App\Http\Controllers\HomeController as FrontendHomeController;
use App\Http\Controllers\Admin\BenefitController as AdminBenefitController;
use App\Http\Controllers\Admin\BenefitImageController;
use App\Http\Controllers\Admin\CuriculumSectionController;
use App\Http\Controllers\Admin\CuriculumItemController;
use App\Http\Controllers\Admin\ExtracurricularController;
use App\Http\Controllers\Admin\ExtracurricularCategoryController;
use App\Http\Controllers\Admin\ExtracurricularGalleryController;
use App\Http\Controllers\Admin\CharacterSectionController;
use App\Http\Controllers\Admin\CharacterCarouselController;
use App\Http\Controllers\Admin\StatController;
use App\Http\Controllers\Admin\BeritaController;
use App\Http\Controllers\BeritaController as FrontendBeritaController;
use App\Http\Controllers\Admin\OrganisasiSantriController;
use App\Http\Controllers\Admin\OstdaquPositionController;
use App\Http\Controllers\Admin\MudabbirController;
use App\Http\Controllers\Admin\KetuaKelasController;
use App\Http\Controllers\Admin\KetuaAsramaController;
use App\Http\Controllers\OrganisasiController;
use App\Http\Controllers\Admin\SejarahController;
use App\Http\Controllers\Admin\SejarahImageController;
use App\Http\Controllers\SejarahController as FrontendSejarahController;
use App\Http\Controllers\Admin\KurikulumController;
use App\Http\Controllers\Admin\EvaluasiController;
use App\Http\Controllers\Admin\InfoAkademikController;
use App\Http\Controllers\Admin\JadwalHarianController;
use App\Http\Controllers\Admin\PrestasiController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\NewsController;
use App\Http\Controllers\Admin\InfoSantriController;
use App\Http\Controllers\Admin\AlumniController;
use App\Http\Controllers\Admin\GaleriController as AdminGaleriController;
use App\Http\Controllers\GaleriController as FrontendGaleriController;
use App\Http\Controllers\Admin\ProdukController as AdminProdukController;
use App\Http\Controllers\ProdukController as FrontendProdukController;
use App\Http\Controllers\Admin\PendaftaranController;
use App\Http\Controllers\Admin\KategoriDonasiController;
use App\Http\Controllers\Admin\ProgramDonasiController;
use App\Http\Controllers\Admin\VerifikasiDonasiController;
use App\Http\Controllers\DonasiController;
use App\Http\Controllers\Admin\CarouselDonasiController;



Route::get('/', [FrontendHomeController::class, 'index']);

Route::get('/sejarah', [FrontendSejarahController::class, 'index'])->name('sejarah');

Route::get('/visi-misi', function () {
    return view('frontend.profil.visi-misi');
});

Route::get('/daqu-method', function () {
    return view('frontend.profil.daqu-method');
});

// Route::get('/berita', function () {
//     return view('frontend.news.berita');
// });

// Route::get('/info-akademik', function () {
//     return view('frontend.news.akademik');
// });

Route::get('/info-akademik', [NewsController::class, 'infoAkademik'])
    ->name('news.info-akademik');

// Route::get('/info-santri', function () {
//     return view('frontend.news.santri');
// });

Route::get('/info-santri', [NewsController::class, 'santri'])
    ->name('news.info-santri');

// Route::get('/info-alumni', function () {
//     return view('frontend.news.alumni');
// });

Route::get('/info-alumni', [NewsController::class, 'alumni'])
    ->name('news.alumni');

// Route::get('/galeri', function () {
//     return view('frontend.galeri');
// });

Route::get('/galeri', [FrontendGaleriController::class, 'index'])->name('galeri.index');

// Route::get('/produk', function () {
//     return view('frontend.produk');
// });

Route::get('/produk', [FrontendProdukController::class, 'index'])->name('produk.index');

Route::view('/pendaftaran', 'frontend.pendaftaran')->name('pendaftaran');

// Route::get('/organisasi', function () {
//     return view('frontend.organisasi');
// });

// Halaman Organisasi
Route::get('/organisasi', [OrganisasiController::class, 'index']);

// Halaman "Berita Lainnya" — tombol di homepage
Route::get('/berita', [FrontendBeritaController::class, 'index'])->name('berita.index');
 
// Halaman detail berita — "Baca Selengkapnya"
Route::get('/berita/{slug}', [FrontendBeritaController::class, 'show'])->name('berita.show');

// Halaman donasi (publik)
// Ganti 'amal-jariyah' di sini aja kalau mau ganti nama URL lagi.
// Nama route tetep 'donasi.*' jadi route('donasi.xxx') di Blade nggak perlu diubah.
Route::prefix('amal-jariyah')->name('donasi.')->group(function () {

    Route::get('/', [DonasiController::class, 'index'])->name('index');
    Route::get('/cek', [DonasiController::class, 'cekForm'])->name('cek-form');

    // throttle:5,1 → maks 5x percobaan per 1 menit per IP, nyegah brute-force
    // nebak kode donasi
    Route::post('/cek', [DonasiController::class, 'cekStatus'])
        ->middleware('throttle:5,1,donasi-cek')
        ->name('cek-status');

    Route::middleware('throttle:15,1,donasi-status')->group(function () {
        Route::get('/status/{donasi:kode_donasi}', [DonasiController::class, 'status'])->name('status');
        Route::get('/{donasi:kode_donasi}/upload-bukti', [DonasiController::class, 'uploadBuktiForm'])->name('upload-bukti');
    });

    Route::get('/riwayat', [DonasiController::class, 'riwayat'])->name('riwayat');

    // throttle:20,10 → maks 20x resubmit per 10 menit per IP
    Route::post('/status/{donasi:kode_donasi}/resubmit', [DonasiController::class, 'resubmit'])
        ->middleware('throttle:20,10,donasi-resubmit')
        ->name('resubmit');

    // WAJIB paling bawah, biar /cek, /riwayat dst nggak ketangkep sebagai slug
    Route::get('/{program:slug}', [DonasiController::class, 'show'])->name('show');

    // throttle:20,10 → maks 20x submit donasi per 10 menit per IP
    Route::post('/', [DonasiController::class, 'store'])
        ->middleware('throttle:20,10,donasi-store')
        ->name('store');
});

// Redirect URL lama /donasi/... → /amal-jariyah/... (GET doang)
Route::get('/donasi/{path?}', function (Request $request, ?string $path = null) {
    $url = '/amal-jariyah' . ($path ? '/' . $path : '');
    return redirect($url . ($request->getQueryString() ? '?' . $request->getQueryString() : ''), 301);
})->where('path', '.*');


Route::middleware('auth')
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        // crud carousel
        Route::resource('carousel', AdminCarouselController::class);

        // crud benefit
        Route::resource('benefit', AdminBenefitController::class);

        // crud benefit image
        Route::get(
            'benefit-images',
            [BenefitImageController::class, 'index']
        )->name('benefit-image.index');

        Route::get(
            'benefit-images/manage',
            [BenefitImageController::class, 'manage']
        )->name('benefit-image.manage');

        Route::post(
            'benefit-images/manage',
            [BenefitImageController::class, 'storeOrUpdate']
        )->name('benefit-image.store-or-update');

        // crud curiculum section
        Route::resource('curiculum-section', CuriculumSectionController::class)
            ->except(['show', 'destroy']);

        Route::resource('curiculum-item', CuriculumItemController::class)->except(['index', 'show']);

        // crud ekskul
        Route::resource('extracurricular-categories', ExtracurricularCategoryController::class)
            ->parameters(['extracurricular-categories' => 'category']);

        Route::resource('extracurriculars', ExtracurricularController::class);

        Route::post('extracurriculars/{extracurricular}/galleries', [ExtracurricularGalleryController::class, 'store'])
            ->name('extracurriculars.galleries.store');

        Route::delete('extracurriculars/galleries/{gallery}', [ExtracurricularGalleryController::class, 'destroy'])
            ->name('extracurriculars.galleries.destroy');

        // crud character section
        Route::resource('character-section', CharacterSectionController::class)
            ->except(['show', 'destroy']);

        // crud character carousel
        Route::resource('character-carousel', CharacterCarouselController::class);

        // crud stat
        Route::post('stats/update-order', [StatController::class, 'updateOrder'])->name('stats.update-order');
        
        Route::resource('stats', StatController::class);

        // crud berita
        Route::resource('berita', BeritaController::class)
            ->parameters(['berita' => 'beritum']); // pakai 'beritum' karena plural "beritas" -> singular "beritum"

        // crud organisasi santri
        Route::get('organisasi-santri', [OrganisasiSantriController::class, 'index'])
            ->name('organisasi-santri.index');

        Route::resource('organisasi-santri/ostdaqu', OstdaquPositionController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['ostdaqu' => 'ostdaqu'])
            ->names('organisasi-santri.ostdaqu');

        Route::resource('organisasi-santri/mudabbir', MudabbirController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->names('organisasi-santri.mudabbir');

        Route::resource('organisasi-santri/ketua-kelas', KetuaKelasController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->parameters(['ketua-kelas' => 'ketuaKela'])
            ->names('organisasi-santri.ketua-kelas');

        Route::resource('organisasi-santri/ketua-asrama', KetuaAsramaController::class)
            ->only(['create', 'store', 'edit', 'update', 'destroy'])
            ->names('organisasi-santri.ketua-asrama');

        // crud sejarah
        Route::resource('sejarah', SejarahController::class)
            ->only(['index', 'create', 'store', 'edit', 'update']);

        Route::resource('sejarah.images', SejarahImageController::class)
            ->shallow()
            ->only(['store', 'update', 'destroy']);

        Route::prefix('info-akademik')
            ->name('info-akademik.')
            ->group(function () {

                Route::get('/', [InfoAkademikController::class, 'index'])
                    ->name('index');

                Route::resource('kurikulum', KurikulumController::class)
                    ->only(['create', 'store', 'edit', 'update', 'destroy']);

                Route::resource('evaluasi', EvaluasiController::class)
                    ->only(['create', 'store', 'edit', 'update', 'destroy']);

                // Jadwal Harian
                Route::post('jadwal-harian/order', [JadwalHarianController::class, 'updateOrder'])
                    ->name('jadwal-harian.order');

                Route::resource('jadwal-harian', JadwalHarianController::class)
                    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

                // Prestasi
                Route::resource('prestasi', PrestasiController::class)
                    ->only(['create', 'store', 'edit', 'update', 'destroy']);

                // Agenda
                Route::resource('agenda', AgendaController::class)
                    ->only(['create', 'store', 'edit', 'update', 'destroy']);

            });

        // crud info santri
        Route::resource('info-santri', InfoSantriController::class)
            ->except(['show'])
            ->names('info-santri');

        Route::post('info-santri/reorder', [InfoSantriController::class, 'reorder'])
            ->name('info-santri.reorder');
        
        // crud alumni
        Route::post('alumni/{alumni}/toggle-active', [AlumniController::class, 'toggleActive'])
            ->name('alumni.toggle-active');

        Route::post('alumni/reorder', [AlumniController::class, 'reorder'])
            ->name('alumni.reorder');

        Route::resource('alumni', AlumniController::class)
            ->names('alumni')
            ->parameters(['alumni' => 'alumni'])
            ->except(['show']);

        // crud galeri
        Route::post('galeri/update-order', [AdminGaleriController::class, 'updateOrder'])->name('galeri.update-order');
        Route::post('galeri/{galeri}/toggle-active', [AdminGaleriController::class, 'toggleActive'])->name('galeri.toggle-active');
        Route::resource('galeri', AdminGaleriController::class)->except(['show']);

        // crud produk
        Route::post('produk/update-order', [AdminProdukController::class, 'updateOrder'])->name('produk.update-order');
        Route::post('produk/{produk}/toggle-active', [AdminProdukController::class, 'toggleActive'])->name('produk.toggle-active');
        Route::resource('produk', AdminProdukController::class);

        // crud pendaftaran
        Route::get('/pendaftaran', [PendaftaranController::class, 'index'])->name('pendaftaran.index');
        Route::get('/pendaftaran/export', [PendaftaranController::class, 'export'])->name('pendaftaran.export');
        Route::get('/pendaftaran/refresh', [PendaftaranController::class, 'refresh'])->name('pendaftaran.refresh');

        // ============================================================
        // Kategori Donasi
        // ============================================================
        // Route custom WAJIB di atas Route::resource, biar ga ketabrak
        // pattern {kategori_donasi} dari resource controller (show/edit).
        Route::patch('kategori-donasi/urutan', [KategoriDonasiController::class, 'updateUrutan'])
            ->name('kategori-donasi.urutan');
        Route::patch('kategori-donasi/{kategori_donasi}/toggle-active', [KategoriDonasiController::class, 'toggleActive'])
            ->name('kategori-donasi.toggle-active');
        Route::resource('kategori-donasi', KategoriDonasiController::class);

        // ============================================================
        // Program Donasi
        // ============================================================
        Route::patch('program-donasi/{program_donasi}/toggle-active', [ProgramDonasiController::class, 'toggleActive'])
            ->name('program-donasi.toggle-active');
        Route::get('program-donasi/{program_donasi}/hapus', [ProgramDonasiController::class, 'confirmHapus'])
            ->name('program-donasi.confirm-hapus');
        Route::get('program-donasi/{program_donasi}/export-rekap', [ProgramDonasiController::class, 'exportRekap'])
            ->name('program-donasi.export-rekap');
        // restore pakai {id} biasa, bukan route-model-binding {program_donasi},
        // karena default binding cuma nyari data yang belum di-soft-delete —
        // padahal restore justru butuh yang sudah ke-soft-delete (di controller
        // dicari manual pakai ProgramDonasi::onlyTrashed()->findOrFail($id)).
        Route::patch('program-donasi/{id}/restore', [ProgramDonasiController::class, 'restore'])
            ->name('program-donasi.restore');
        Route::resource('program-donasi', ProgramDonasiController::class);

        // ============================================================
        // Verifikasi Donasi — dipecah 2 tab: Donasi Program (is_umum=false)
        // dan Donasi Non Program (is_umum=true), sesuai menu di sidebar
        // ============================================================
        Route::get('donasi/program', [VerifikasiDonasiController::class, 'program'])
            ->name('donasi.program');
        Route::get('donasi/non-program', [VerifikasiDonasiController::class, 'nonProgram'])
            ->name('donasi.non-program');
        Route::get('donasi/{donasi}/verifikasi', [VerifikasiDonasiController::class, 'show'])
            ->name('donasi.verifikasi');
        Route::patch('donasi/{donasi}', [VerifikasiDonasiController::class, 'update'])
            ->name('donasi.update');

        // CAROUSEL DONASI
        Route::resource('carousel-donasi', CarouselDonasiController::class)
            ->except('show')
            ->parameters(['carousel-donasi' => 'carousel_donasi']);

        Route::patch('carousel-donasi/{carousel_donasi}/toggle', [CarouselDonasiController::class, 'toggle'])
            ->name('carousel-donasi.toggle');

});

Route::get('/dashboard', [DashboardController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';