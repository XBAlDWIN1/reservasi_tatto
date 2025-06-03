<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ArtisTato extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_artis_tato';
    protected $fillable = [
        'nama_artis_tato',
        'tahun_menato',
        'instagram',
        'tiktok',
        'gambar',
    ];
    protected $table = 'artis_tatos';

    public function artisKategoris()
    {
        return $this->hasMany(ArtisKategori::class, 'id_artis_tato', 'id_artis_tato');
    }
}
