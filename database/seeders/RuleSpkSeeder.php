<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\RuleSpk;

class RuleSpkSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        RuleSpk::insert([
            [
                'nama' => 'R01',
                'kondisi_if' => json_encode(['desain' => 'flat', 'ukuran' => 'besar']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'tinggi', 'durasi_estimasi' => '8 jam']),
            ],
            [
                'nama' => 'R02',
                'kondisi_if' => json_encode(['lokasi_tubuh' => 'lengan kanan', 'kategori_kompleksitas' => 'tinggi']),
                'hasil_then' => json_encode(['biaya_tambahan' => 500000]),
            ],
            [
                'nama' => 'R03',
                'kondisi_if' => json_encode(['permintaan_khusus' => 'warna', 'kategori_kompleksitas' => 'tinggi']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'Senior']),
            ],
        ]);
    }
}
