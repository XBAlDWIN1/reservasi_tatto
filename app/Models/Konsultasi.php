<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Konsultasi extends Model
{
    protected $table = 'konsultasis';
    protected $primaryKey = 'id_konsultasi';
    public $timestamps = true;
    protected $fillable = [
        'id_pengguna',
        'id_artis_tato',
        'id_lokasi_tato',
        'id_kategori',
        'panjang',
        'lebar',
        'jadwal_konsultasi',
        'gambar',
        'status',
        'kompleksitas',
        'durasi_estimasi',
        'biaya_tambahan',
    ];

    public function pengguna()
    {
        return $this->belongsTo(User::class, 'id_pengguna', 'id');
    }

    public function artisTato()
    {
        return $this->belongsTo(ArtisTato::class, 'id_artis_tato', 'id_artis_tato');
    }

    public function lokasiTato()
    {
        return $this->belongsTo(LokasiTato::class, 'id_lokasi_tato', 'id_lokasi_tato');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
    public function reservasi()
    {
        return $this->hasOne(Reservasi::class, 'id_konsultasi', 'id_konsultasi');
    }

    protected $casts = [
        'kondisi_if' => 'array',
        'hasil_then' => 'array',
    ];
}
