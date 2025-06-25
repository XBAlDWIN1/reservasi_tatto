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
                'kondisi_if' => json_encode(['desain' => 'flat', 'ukuran' => 'kecil']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'rendah', 'durasi_estimasi' => '1 jam']),
            ],
            [
                'nama' => 'R02',
                'kondisi_if' => json_encode(['desain' => 'flat', 'ukuran' => 'sedang']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'sedang', 'durasi_estimasi' => '2 jam']),
            ],
            [
                'nama' => 'R03',
                'kondisi_if' => json_encode(['desain' => 'flat', 'ukuran' => 'besar']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'tinggi', 'durasi_estimasi' => '3 jam']),
            ],
            [
                'nama' => 'R04',
                'kondisi_if' => json_encode(['desain' => 'realistic', 'ukuran' => 'kecil']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'rendah', 'durasi_estimasi' => '2 jam']),
            ],
            [
                'nama' => 'R05',
                'kondisi_if' => json_encode(['desain' => 'realistic', 'ukuran' => 'sedang']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'sedang', 'durasi_estimasi' => '3 jam']),
            ],
            [
                'nama' => 'R06',
                'kondisi_if' => json_encode(['desain' => 'realistic', 'ukuran' => 'besar']),
                'hasil_then' => json_encode(['kategori_kompleksitas' => 'tinggi', 'durasi_estimasi' => '5 jam']),
            ],
            [
                'nama' => 'R07',
                'kondisi_if' => json_encode(['lokasi_tubuh' => 'lengan kiri', 'kategori_kompleksitas' => 'rendah']),
                'hasil_then' => json_encode(['biaya_tambahan' => 200000]),
            ],
            [
                'nama' => 'R08',
                'kondisi_if' => json_encode(['lokasi_tubuh' => 'lengan kiri', 'kategori_kompleksitas' => 'sedang']),
                'hasil_then' => json_encode(['biaya_tambahan' => 400000]),
            ],
            [
                'nama' => 'R09',
                'kondisi_if' => json_encode(['lokasi_tubuh' => 'lengan kiri', 'kategori_kompleksitas' => 'tinggi']),
                'hasil_then' => json_encode(['biaya_tambahan' => 600000]),
            ],
            [
                'nama' => 'R10',
                'kondisi_if' => json_encode(['permintaan_khusus' => 'satu warna', 'kategori_kompleksitas' => 'rentah']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'junior']),
            ],
            [
                'nama' => 'R11',
                'kondisi_if' => json_encode(['permintaan_khusus' => 'satu warna', 'kategori_kompleksitas' => 'sedang']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'junior']),
            ],
            [
                'nama' => 'R12',
                'kondisi_if' => json_encode(['permintaan_khusus' => ' warna', 'kategori_kompleksitas' => 'rendah']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'junior']),
            ],
            [
                'nama' => 'R13',
                'kondisi_if' => json_encode(['permintaan_khusus' => 'satu warna', 'kategori_kompleksitas' => 'tinggi']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'senior']),
            ],
            [
                'nama' => 'R14',
                'kondisi_if' => json_encode(['permintaan_khusus' => ' warna', 'kategori_kompleksitas' => 'sedang']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'senior']),
            ],
            [
                'nama' => 'R15',
                'kondisi_if' => json_encode(['permintaan_khusus' => 'warna', 'kategori_kompleksitas' => 'tinggi']),
                'hasil_then' => json_encode(['artist_rekomendasi' => 'senior']),
            ],
        ]);
    }
}
