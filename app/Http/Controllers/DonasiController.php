<?php

namespace App\Http\Controllers;

use App\Http\Requests\ResubmitDonasiRequest;
use App\Http\Requests\StoreDonasiRequest;
use App\Models\Donasi;
use App\Models\KategoriDonasi;
use App\Models\ProgramDonasi;
use App\Models\CarouselDonasi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DonasiController extends Controller
{
    // Landing page donasi: 3 CTA kategori + list program yang lagi berjalan
    public function index()
    {
        $kategoris = KategoriDonasi::with('programUmum')
            ->where('is_active', true)
            ->orderBy('urutan')
            ->get();

        $programs = ProgramDonasi::tampilPublik()
            ->where('is_umum', false)
            ->with('kategori')
            ->latest()
            ->get();

        // Banner carousel (promosi + program), udah disaring & diurutkan di scope tampil()
        $carousels = CarouselDonasi::tampil()->with('program')->get();

        return view('frontend.donasi.index', compact('kategoris', 'programs', 'carousels'));
    }

    // Halaman detail program + form isi donasi
    public function show(ProgramDonasi $program)
    {
        // Route model binding cuma nyocokin slug, belum ngecek scope publik —
        // jadi program yang nonaktif/udah lewat tanggal_selesai tetap ke-load
        // di sini. Kita tolak manual biar link lama/nonaktif nggak bisa diakses.
        abort_unless($program->is_active && ! $program->sudah_berakhir, 404);

        $program->load('kategori');

        // Riwayat donatur publik untuk program ini (verified saja, urutan terbaru dulu)
        $donaturTerbaru = $program->donasisVerified()
            ->latest()
            ->take(10)
            ->get();

        return view('frontend.donasi.show', compact('program', 'donaturTerbaru'));
    }

    // Proses submit form donasi dari donor.
    // CATATAN ALUR BARU: bukti_transfer sekarang BOLEH kosong di sini. Kalau belum
    // ada bukti, donatur diarahkan ke halaman upload-bukti (bukan status), biar
    // flow-nya jelas: halaman upload buat AKSI, halaman status buat INFO doang.
    public function store(StoreDonasiRequest $request)
    {
        $data = $request->validated();
        unset($data['website']); // honeypot, jangan ikut disimpan

        if ($request->hasFile('bukti_transfer')) {
            $data['bukti_transfer'] = $request->file('bukti_transfer')->store('bukti-transfer', 'public');
        }

        $donasi = Donasi::create($data);

        if (! $donasi->bukti_transfer) {
            return redirect()
                ->route('donasi.upload-bukti', $donasi->kode_donasi)
                ->with('success', 'Kode donasi Anda: ' . $donasi->kode_donasi . '. Silakan transfer sesuai instruksi, lalu unggah bukti transfer di bawah.');
        }

        return redirect()
            ->route('donasi.status', $donasi->kode_donasi)
            ->with('success', 'Terima kasih! Donasi Anda tercatat. Tim kami akan memverifikasi bukti transfer Anda secepatnya.');
    }

    // Form input kode donasi buat cek status
    public function cekForm()
    {
        return view('frontend.donasi.cek');
    }

    // Proses pencarian berdasarkan kode donasi yang diinput
    public function cekStatus(Request $request)
    {
        $request->validate([
            'kode_donasi' => ['required', 'string'],
        ], [
            'kode_donasi.required' => 'Masukkan kode donasi Anda.',
        ]);

        $donasi = Donasi::where('kode_donasi', trim($request->kode_donasi))->first();

        if (! $donasi) {
            return back()
                ->withInput()
                ->withErrors(['kode_donasi' => 'Kode donasi tidak ditemukan. Periksa kembali kode Anda.']);
        }

        return redirect()->route('donasi.status', $donasi->kode_donasi);
    }

    // Halaman khusus buat upload bukti transfer PERTAMA KALI (belum pernah upload
    // sama sekali). Kasus "rejected" TETAP di halaman status seperti sebelumnya,
    // sesuai keputusan — cuma kasus belum-pernah-upload yang dipisah ke sini.
    public function uploadBuktiForm(Donasi $donasi)
    {
        abort_unless($donasi->status === 'pending' && is_null($donasi->bukti_transfer), 404);

        $donasi->load('program.kategori');

        return view('frontend.donasi.upload-bukti', compact('donasi'));
    }

    // Halaman status donasi — sekarang murni informasi. Kalau ada yang nyasar ke
    // sini padahal belum pernah upload bukti (misal buka link lama/hasil cek kode),
    // langsung dialihkan ke halaman upload-bukti biar gak ada jalan buat "lewatin"
    // upload. Kasus rejected tetap ditangani di sini (form resubmit-nya nempel
    // di halaman ini, bukan di upload-bukti).
    public function status(Donasi $donasi)
    {
        if ($donasi->status === 'pending' && is_null($donasi->bukti_transfer)) {
            return redirect()->route('donasi.upload-bukti', $donasi->kode_donasi);
        }

        $donasi->load('program.kategori');

        return view('frontend.donasi.status', compact('donasi'));
    }

    // Proses upload bukti transfer — sekarang menangani 2 kondisi:
    // 1. status rejected: upload ULANG bukti yang sebelumnya ditolak admin
    // 2. status pending TAPI bukti_transfer masih null: upload PERTAMA KALI,
    //    ini kondisi baru hasil dari alur "submit dulu, transfer belakangan"
    // Donasi yang sudah verified, atau pending yang sudah ada buktinya (lagi
    // ditinjau admin), nggak boleh diutak-atik lewat jalur ini.
    public function resubmit(ResubmitDonasiRequest $request, Donasi $donasi)
    {
        $belumPernahUpload = $donasi->status === 'pending' && is_null($donasi->bukti_transfer);

        abort_unless($donasi->status === 'rejected' || $belumPernahUpload, 403);

        // Hapus file bukti transfer lama biar storage nggak numpuk file nggak kepake
        // (khusus kasus rejected — kasus belum-pernah-upload otomatis skip karena null)
        if ($donasi->bukti_transfer && Storage::disk('public')->exists($donasi->bukti_transfer)) {
            Storage::disk('public')->delete($donasi->bukti_transfer);
        }

        $donasi->update([
            'bukti_transfer' => $request->file('bukti_transfer')->store('bukti-transfer', 'public'),
            'status' => 'pending',
            'catatan_admin' => null, // reset catatan penolakan lama, siap diverifikasi ulang
        ]);

        return redirect()
            ->route('donasi.status', $donasi->kode_donasi)
            ->with('success', 'Bukti transfer berhasil dikirim. Tim kami akan memverifikasi secepatnya.');
    }

    public function riwayat()
    {
        $donasis = Donasi::with('program')
            ->where('status', 'verified')
            ->latest()
            ->orderByDesc('id')
            ->simplePaginate(15);

        return view('frontend.donasi.riwayat', compact('donasis'));
    }
}