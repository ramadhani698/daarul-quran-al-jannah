<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CarouselDonasi extends Model
{
    protected $fillable = [
        'judul',
        'gambar',
        'program_donasi_id',
        'urutan',
        'is_aktif',
    ];

    protected $casts = [
        'is_aktif' => 'boolean',
    ];

    // withTrashed: admin tetap bisa liat banner yg program-nya udah ke-arsip
    public function program(): BelongsTo
    {
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id')->withTrashed();
    }

    // Banner yg tampil di publik: aktif; kalau banner program, program-nya harus
    // belum ke-arsip, aktif, sudah mulai, dan belum lewat tanggal selesai
    public function scopeTampil(Builder $query): Builder
    {
        return $query->where('is_aktif', true)
            ->where(function ($q) {
                $q->whereNull('program_donasi_id')
                ->orWhereHas('program', function ($p) {
                    $p->withoutTrashed()
                        ->tampilPublik()
                        ->whereDate('tanggal_mulai', '<=', now()->toDateString());
                });
            })
            ->orderBy('urutan')
            ->orderBy('id');
    }

    public function isProgram(): bool
    {
        return !is_null($this->program_donasi_id);
    }
}