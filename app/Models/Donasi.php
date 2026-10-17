<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Donasi extends Model
{
    protected $fillable = [
        'program_donasi_id', 'kode_donasi', 'nama_donatur', 'no_hp',
        'is_anonim', 'nominal', 'metode_pembayaran', 'bukti_transfer', 'pesan_doa',
        'status', 'catatan_admin',
    ];

    protected $casts = [
        'is_anonim' => 'boolean',
        'nominal' => 'decimal:2',
    ];

    public function program()
    {
        // withTrashed() WAJIB di sini — ProgramDonasi pakai SoftDeletes, dan
        // Eloquent otomatis nge-filter model yang sudah di-soft-delete dari
        // SEMUA relasi (termasuk arah belongsTo ini dan whereHas() di controller
        // verifikasi). Tanpa ini, begitu sebuah program diarsipkan (hapus 3-lapis)
        // padahal masih punya riwayat donasi, relasi ini bakal ngembaliin null —
        // bikin halaman cek status donatur error 500, dan donasinya "ilang" dari
        // tab Donasi Program/Non Program di admin meskipun datanya masih ada
        // utuh di database.
        return $this->belongsTo(ProgramDonasi::class, 'program_donasi_id')->withTrashed();
    }

    public function getNamaTampilAttribute()
    {
        return $this->is_anonim ? 'Hamba Allah' : $this->nama_donatur;
    }

    public function getWaLinkAttribute(): ?string
    {
        $hp = preg_replace('/\D/', '', $this->no_hp ?? '');
        if ($hp === '') return null;

        if (str_starts_with($hp, '0')) {
            $hp = '62' . substr($hp, 1);
        } elseif (str_starts_with($hp, '8')) {
            $hp = '62' . $hp;
        }

        $pesan = "Assalamu'alaikum {$this->nama_donatur}, alhamdulillah donasi Anda "
            . "dengan kode {$this->kode_donasi} sebesar Rp"
            . number_format($this->nominal, 0, ',', '.')
            . " untuk program {$this->program->nama_program} sudah kami verifikasi. "
            . "Jazakumullahu khairan, semoga menjadi amal jariyah yang berkah.";

        return 'https://wa.me/' . $hp . '?text=' . rawurlencode($pesan);
    }

    public function getNominalTersamarAttribute(): string
    {
        $angka = (string) (int) $this->nominal;

        return 'Rp' . substr($angka, 0, 1) . str_repeat('*', strlen($angka) - 1);
    }

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($donasi) {
            if (empty($donasi->kode_donasi)) {
                do {
                    $kode = 'DNS-' . now()->format('Ymd') . '-' . strtoupper(Str::random(5));
                } while (static::where('kode_donasi', $kode)->exists());

                $donasi->kode_donasi = $kode;
            }
        });
    }

    protected function metodeLabel(): Attribute
    {
        return Attribute::get(fn () => $this->metode_pembayaran === 'qris' ? 'QRIS' : 'Transfer Bank');
    }

    protected function metodeBadge(): Attribute
    {
        return Attribute::get(fn () => $this->metode_pembayaran === 'qris' ? 'bg-info' : 'bg-primary');
    }

    protected function metodeIcon(): Attribute
    {
        return Attribute::get(fn () => $this->metode_pembayaran === 'qris' ? 'fa-qrcode' : 'fa-building-columns');
    }

    public function scopeMenungguVerifikasi($query)
    {
        return $query->where('status', 'pending')->whereNotNull('bukti_transfer');
    }

    public function scopeSudahMasukAntrean($query)
    {
        // donasi pending hanya dihitung kalau bukti transfer sudah diupload;
        // status lain (verified/rejected) selalu lolos
        return $query->where(function ($q) {
            $q->where('status', '!=', 'pending')
            ->orWhereNotNull('bukti_transfer');
        });
    }
    
}