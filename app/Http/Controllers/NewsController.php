<?php

namespace App\Http\Controllers;

use App\Models\Kurikulum;
use App\Models\Evaluasi;
use App\Models\JadwalHarian;
use App\Models\Prestasi;
use App\Models\Agenda;
use App\Models\InfoSantri;
use App\Models\Alumni;

class NewsController extends Controller
{
    public function infoAkademik()
    {
        $kurikulum_kiri = Kurikulum::where('tipe', 'kolom_kiri')
            ->orderBy('urutan')
            ->get();

        $kurikulum_kanan = Kurikulum::where('tipe', 'kolom_kanan')
            ->orderBy('urutan')
            ->get();

        $evaluasi_kiri = Evaluasi::where('tipe', 'kolom_kiri')
            ->orderBy('urutan')
            ->get();

        $evaluasi_kanan = Evaluasi::where('tipe', 'kolom_kanan')
            ->orderBy('urutan')
            ->get();

        $jadwals  = JadwalHarian::orderBy('urutan')->get();
        $prestasis = Prestasi::ordered()->active()->get();
        $agendas  = Agenda::ordered()->active()->get();

        return view('frontend.news.akademik', compact(
            'kurikulum_kiri',
            'kurikulum_kanan',
            'evaluasi_kiri',
            'evaluasi_kanan',
            'jadwals',
            'prestasis',
            'agendas',
        ));
    }

    public function santri()
    {
        $infoSantris = InfoSantri::orderBy('tahun', 'desc')
            ->orderBy('created_at', 'desc')
            ->paginate(6);

        return view('frontend.news.santri', compact('infoSantris'));
    }

    public function alumni()
    {
        $sebaran = Alumni::sebaran()->aktif()
            ->paginate(6, ['*'], 'sebaran_page')
            ->withQueryString();

        $kiprah = Alumni::kiprah()->aktif()
            ->paginate(6, ['*'], 'kiprah_page')
            ->withQueryString();

        return view('frontend.news.alumni', compact('sebaran', 'kiprah'));
    }
}
