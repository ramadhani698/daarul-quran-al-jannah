<?php

namespace App\Console\Commands;

use App\Models\ProgramDonasi;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class MusnahkanProgramDonasi extends Command
{
    protected $signature = 'program:musnahkan {id : ID program donasi yang mau dimusnahkan permanen}';

    protected $description = 'Menghapus permanen (force delete) program donasi yang sudah diarsipkan. Aksi ini tidak bisa dibatalkan.';

    public function handle(): int
    {
        $id = $this->argument('id');

        $program = ProgramDonasi::withTrashed()->with('kategori')->find($id);

        if (! $program) {
            $this->error("Program donasi dengan ID {$id} tidak ditemukan.");

            return self::FAILURE;
        }

        // Cuma boleh musnahin program yang UDAH diarsipkan (soft-deleted) lewat
        // flow 3-lapis di admin. Command ini bukan jalan pintas buat skip flow itu —
        // dia cuma buat "pembersihan akhir" program yang emang udah lama nganggur di arsip.
        if (! $program->trashed()) {
            $this->error("Program \"{$program->nama_program}\" masih aktif (belum diarsipkan). Arsipkan dulu lewat halaman admin sebelum bisa dimusnahkan permanen.");

            return self::FAILURE;
        }

        $this->warn('=== DETAIL PROGRAM ===');
        $this->line("Nama          : {$program->nama_program}");
        $this->line('Kategori      : ' . ($program->kategori->nama ?? '-'));
        $this->line('Status Umum   : ' . ($program->is_umum ? 'Ya (program umum — biasanya TIDAK BOLEH dimusnahkan)' : 'Tidak'));
        $this->line('Diarsipkan    : ' . $program->deleted_at->format('d/m/Y H:i'));
        $this->line("Total Donasi  : {$program->donasis()->count()} transaksi");
        $this->newLine();

        $this->error('PERINGATAN: Aksi ini PERMANEN dan TIDAK BISA DIBATALKAN.');
        $this->error('Data program beserta gambarnya akan hilang selamanya dari server.');
        $this->newLine();

        if (! $this->confirm('Apakah Anda yakin ingin memusnahkan program ini secara permanen?', false)) {
            $this->info('Dibatalkan.');

            return self::SUCCESS;
        }

        // Konfirmasi kedua — ketik ulang nama persis, sama kayak pola di flow
        // hapus 3-lapis via web, biar konsisten dan nggak kepencet nggak sengaja
        $konfirmasi = $this->ask('Ketik ulang nama program persis untuk konfirmasi terakhir');

        if ($konfirmasi !== $program->nama_program) {
            $this->error('Nama yang diketik tidak sesuai. Dibatalkan demi keamanan.');

            return self::FAILURE;
        }

        try {
            $namaProgram = $program->nama_program;
            $gambarLama = $program->gambar;

            // forceDelete() ini yang bakal nge-trigger guard di model ProgramDonasi
            // (static::deleting()) — otomatis ketolak kalau is_umum atau masih
            // punya riwayat donasi, exception-nya ketangkep di catch bawah
            $program->forceDelete();

            if ($gambarLama && Storage::disk('public')->exists($gambarLama)) {
                Storage::disk('public')->delete($gambarLama);
            }

            $this->info("Program \"{$namaProgram}\" berhasil dimusnahkan permanen.");

            return self::SUCCESS;
        } catch (\Throwable $e) {
            $this->error('Gagal memusnahkan program: ' . $e->getMessage());

            return self::FAILURE;
        }
    }
}