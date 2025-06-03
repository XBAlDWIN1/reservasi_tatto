<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LokasiTato extends Model
{
    protected $table = 'lokasi_tatos';
    protected $primaryKey = 'id_lokasi_tato';
    public $timestamps = true;

    protected $fillable = [
        'nama_lokasi_tato',
    ];
}
