<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Produk extends Model
{
    use HasFactory;

    protected $fillable = [
        'kategori',
        'nama',
        'deskripsi',
        'harga',
        'gambar',
        'badge',
        'urutan',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    // Accessor untuk format harga, dipakai di Blade: {{ $produk->harga_format }}
    public function getHargaFormatAttribute(): string
    {
        return 'Rp ' . number_format($this->harga, 0, ',', '.');
    }

    // Generate link Whatsapp otomatis berdasarkan nama produk
    public function getWaLinkAttribute(): string
    {
        $nomor = config('services.whatsapp.admin_number', '6285885428128');
        $pesan = "Halo Admin Daqu Store, saya ingin memesan {$this->nama}";

        return "https://wa.me/{$nomor}?text=" . urlencode($pesan);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrder($query)
    {
        return $query->orderBy('urutan');
    }
}
