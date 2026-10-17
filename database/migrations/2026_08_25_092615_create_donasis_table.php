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
        Schema::create('donasis', function (Blueprint $table) {
            $table->id();
            $table->foreignId('program_donasi_id')->constrained('program_donasis')->restrictOnDelete();
            $table->string('kode_donasi')->unique();
            $table->string('nama_donatur');
            $table->string('no_hp')->nullable();
            $table->boolean('is_anonim')->default(false);
            $table->decimal('nominal', 15, 2);
            $table->string('metode_pembayaran', 10)->default('bank'); // bank | qris
            $table->string('bukti_transfer')->nullable();
            $table->string('pesan_doa', 500)->nullable();
            $table->enum('status', ['pending', 'verified', 'rejected'])->default('pending');
            $table->text('catatan_admin')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('donasis');
    }
};
