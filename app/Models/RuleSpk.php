<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RuleSpk extends Model
{
    protected $table = 'rules_spk';

    protected $fillable = [
        'nama',
        'kondisi_if',
        'hasil_then',
    ];

    protected $casts = [
        'kondisi_if' => 'array',
        'hasil_then' => 'array',
    ];
}
