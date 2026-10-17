<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class KategoriDonasi extends Model
{
    protected $fillable = ['nama', 'slug', 'icon', 'is_active', 'urutan'];

    protected $casts = ['is_active' => 'boolean'];

    public function programs()
    {
        return $this->hasMany(ProgramDonasi::class, 'kategori_donasi_id');
    }

    public function programUmum()
    {
        return $this->hasOne(ProgramDonasi::class, 'kategori_donasi_id')->where('is_umum', true);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($kategori) {
            if (empty($kategori->slug)) {
                $kategori->slug = Str::slug($kategori->nama);
            }
        });

        static::deleting(function ($kategori) {
            // withTrashed() penting: program yang sudah soft-deleted tetap dihitung,
            // karena datanya secara fisik masih ada dan masih terhubung FK ke kategori ini.
            if ($kategori->programs()->withTrashed()->exists()) {
                throw new \Exception('Kategori tidak dapat dihapus karena masih memiliki program donasi (termasuk yang sudah dihapus/nonaktif).');
            }
        });
    }
}