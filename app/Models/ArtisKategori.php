<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtisKategori extends Model
{
    use HasFactory;

    protected $primaryKey = 'id_artis_kategori';
    protected $table = 'artis_kategoris';

    protected $fillable = [
        'id_artis_tato',
        'id_kategori',
    ];

    public function artisTato()
    {
        return $this->belongsTo(ArtisTato::class, 'id_artis_tato', 'id_artis_tato');
    }

    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'id_kategori', 'id_kategori');
    }
}
