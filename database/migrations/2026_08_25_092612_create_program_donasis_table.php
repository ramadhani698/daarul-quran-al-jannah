<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('program_donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('kategori_donasi_id')->constrained('kategori_donasis')->restrictOnDelete();
            $table->string('nama_program');
            $table->string('slug')->unique();
            $table->text('deskripsi');
            $table->string('gambar')->nullable();
            $table->decimal('target_donasi', 15, 2)->nullable(); // null = program umum, tanpa target
            $table->date('tanggal_mulai');
            $table->date('tanggal_selesai')->nullable(); // null = tanpa batas waktu
            $table->boolean('is_umum')->default(false); // program default per kategori, dituju CTA
            $table->boolean('is_active')->default(true);
            $table->softDeletes(); // untuk flow hapus 3-lapis
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_donasis');
    }
};
