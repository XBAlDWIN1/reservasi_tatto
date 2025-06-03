<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Portfolio extends Model
{
    use HasFactory;
    protected $primaryKey = 'id_portfolio';
    protected $fillable = [
        'id_artis_tato',
        'judul',
        'deskripsi',
        'gambar',
    ];
    protected $table = 'portfolios';
    public function artisTato()
    {
        return $this->belongsTo(ArtisTato::class, 'id_artis_tato', 'id_artis_tato');
    }
}
