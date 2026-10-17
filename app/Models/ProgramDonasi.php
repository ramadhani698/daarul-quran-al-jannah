<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class ProgramDonasi extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'kategori_donasi_id', 'nama_program', 'slug', 'deskripsi', 'gambar',
        'target_donasi', 'tanggal_mulai', 'tanggal_selesai',
        'is_umum', 'is_active',
    ];

    protected $casts = [
        'target_donasi' => 'decimal:2',
        'tanggal_mulai' => 'date',
        'tanggal_selesai' => 'date',
        'is_umum' => 'boolean',
        'is_active' => 'boolean',
    ];

    public function kategori()
    {
        return $this->belongsTo(KategoriDonasi::class, 'kategori_donasi_id');
    }

    public function donasis()
    {
        return $this->hasMany(Donasi::class);
    }

    public function donasisVerified()
    {
        return $this->hasMany(Donasi::class)->where('status', 'verified');
    }

    public function getTerkumpulAttribute()
    {
        return $this->donasisVerified()->sum('nominal');
    }

    public function getPersentaseAttribute()
    {
        if (! $this->target_donasi || $this->target_donasi <= 0) {
            return null;
        }
        return min(100, round(($this->terkumpul / $this->target_donasi) * 100, 1));
    }

    public function getJumlahDonaturAttribute()
    {
        return $this->donasisVerified()->count();
    }

    public function getSudahBerakhirAttribute()
    {
        return $this->tanggal_selesai && now()->startOfDay()->gt($this->tanggal_selesai);
    }

    public function scopeTampilPublik($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('tanggal_selesai')
                ->orWhereDate('tanggal_selesai', '>=', now()->toDateString());
            });
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->nama_program) . '-' . Str::random(5);
            }
        });

        static::saving(function ($program) {
            if ($program->is_umum) {
                $bentrok = static::where('kategori_donasi_id', $program->kategori_donasi_id)
                    ->where('is_umum', true)
                    ->where('id', '!=', $program->id ?? 0)
                    ->exists();

                if ($bentrok) {
                    throw new \Exception('Kategori ini sudah punya program umum. Nonaktifkan yang lama dulu.');
                }
            }
        });

        // Guard ini HANYA berlaku pas force delete (musnahkan permanen),
        // bukan pas soft delete biasa — soft delete justru dirancang buat
        // tetap bisa "menghapus" program walau masih ada riwayat donasi,
        // karena datanya nggak beneran hilang, cuma disembunyikan.
        static::deleting(function ($program) {
            if (! $program->forceDeleting) {
                return;
            }

            // Program is_umum TIDAK BOLEH dimusnahkan permanen apa pun kondisinya,
            // bahkan kalau belum pernah ada donasi masuk sama sekali — soalnya
            // ini adalah "wadah" donasi umum wajib untuk kategorinya (dituju CTA
            // Sedekah/Zakat/Wakaf di landing page). Menghapusnya bikin CTA patah
            // dan KategoriDonasi::programUmum() jadi null selamanya untuk kategori itu.
            if ($program->is_umum) {
                throw new \Exception('Program umum tidak dapat dimusnahkan permanen. Hapus/nonaktifkan kategorinya jika ingin menghilangkan fitur ini.');
            }

            if ($program->donasis()->exists()) {
                throw new \Exception('Program tidak dapat dimusnahkan permanen karena masih memiliki riwayat donasi yang belum dibersihkan.');
            }
        });
    }
}