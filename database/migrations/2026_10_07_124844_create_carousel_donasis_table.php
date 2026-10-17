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
        Schema::create('carousel_donasis', function (Blueprint $table) {
            $table->id();
            $table->string('judul')->nullable();          // buat alt text & label di admin
            $table->string('gambar');                      // path di storage
            $table->foreignId('program_donasi_id')
                  ->nullable()
                  ->constrained('program_donasis')         // cek nama tabel program lu
                  ->cascadeOnDelete();
            $table->unsignedInteger('urutan')->default(0);
            $table->boolean('is_aktif')->default(true);
            $table->timestamps();

            $table->index(['is_aktif', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carousel_donasis');
    }
};
