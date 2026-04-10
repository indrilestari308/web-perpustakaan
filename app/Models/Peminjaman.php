<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Peminjaman extends Model
{
    protected $table = 'peminjaman';

    protected $fillable = [
        'user_id',
        'buku_id',
        'tanggal_pinjam',
        'batas_kembali',
        'tanggal_kembalikan',
        'denda',
        'status',
    ];

    protected $casts = [
        'tanggal_pinjam'     => 'date',
        'batas_kembali'      => 'date',
        'tanggal_kembalikan' => 'date',
    ];

    // ─── Relasi ───────────────────────────────────────────────

    public function buku()
    {
        return $this->belongsTo(Buku::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // ─── Accessor ─────────────────────────────────────────────

    /**
     * Alias: tanggal_jatuh_tempo → batas_kembali
     * (dipakai di view laporan kepala)
     */
    public function getTanggalJatuhTempoAttribute()
    {
        return $this->batas_kembali;
    }

    /**
     * Alias: tanggal_kembali → tanggal_kembalikan
     * (dipakai di view laporan kepala)
     */
    public function getTanggalKembaliAttribute()
    {
        return $this->tanggal_kembalikan;
    }

    /**
     * Hitung hari terlambat secara dinamis.
     */
    public function getHariTerlambatAttribute(): int
    {
        if (! $this->batas_kembali) return 0;

        $acuan = $this->tanggal_kembalikan ?? Carbon::today();
        $batas = Carbon::parse($this->batas_kembali);

        return $acuan->gt($batas) ? $acuan->diffInDays($batas) : 0;
    }

    /**
     * Estimasi denda (Rp 1.000 / hari).
     */
    public function getDendaHitungAttribute(): int
    {
        // Kalau denda sudah dikunci petugas, pakai nilai DB
        if ($this->denda > 0) return $this->denda;

        return $this->hari_terlambat * 1000;
    }
}
