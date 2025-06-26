<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Pelanggan;
use App\Models\Kategori;
use App\Models\ArtisTato;
use App\Models\ArtisKategori;
use App\Models\Portfolio;
use App\Models\RuleSpk;
use App\Models\LokasiTato;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        Role::create(['name' => 'Admin']);
        Role::create(['name' => 'Pengelola']);
        Role::create(['name' => 'Pengguna']);

        // asign user admin
        $user = User::factory()->create([
            'name' => 'Administrator',
            'email' => 'admin@mail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('Admin');

        // create user pengelola
        $user = User::factory()->create([
            'name' => 'Pengelola',
            'email' => 'pengelola@mail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('Pengelola');

        // create user pelanggan
        $user = User::factory()->create([
            'name' => 'Pengguna',
            'email' => 'pengguna@mail.com',
            'password' => bcrypt('12345678'),
        ]);
        $user->assignRole('Pengguna');

        // create pelanggan
        Pelanggan::create([
            'id_pengguna' => 1,
            'nama_lengkap' => 'John Doe',
            'telepon' => '1234567890',
        ]);

        // create kategori
        Kategori::create([
            'nama_kategori' => 'Mesin',
            'deskripsi' => 'Melibatkan penggunaan alat elektronik untuk menusuk kulit dengan tinta',
        ]);
        Kategori::create([
            'nama_kategori' => 'Handpoke',
            'deskripsi' => 'Teknik tradisional tanpa mesin yang menggunakan jarum yang dipegang tangan',
        ]);
        Kategori::create([
            'nama_kategori' => 'Hand tap',
            'deskripsi' => 'Merujuk pada penggunaan alat manual untuk membuat ulir pada kulit dengan tinta',
        ]);

        // create artis tato
        ArtisTato::create([
            'nama_artis_tato' => 'Artis Tato 1',
            'tahun_menato' => 2015,
            'instagram' => 'artis1',
            'tiktok' => 'artis1',
            'gambar' => 'artis_tato/artist1.jpg',
        ]);
        ArtisTato::create([
            'nama_artis_tato' => 'Artis Tato 2',
            'tahun_menato' => 2018,
            'instagram' => 'artis2',
            'tiktok' => 'artis2',
            'gambar' => 'artis_tato/artist2.jpg',
        ]);
        ArtisTato::create([
            'nama_artis_tato' => 'Artis Tato 3',
            'tahun_menato' => 2023,
            'instagram' => 'artis3',
            'tiktok' => 'artis3',
            'gambar' => 'artis_tato/artist3.jpg',
        ]);

        // create artis kategori
        ArtisKategori::create([
            'id_artis_tato' => 1,
            'id_kategori' => 1, // Mesin
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 1,
            'id_kategori' => 2, // Handpoke
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 1,
            'id_kategori' => 3, // Hand tap
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 2,
            'id_kategori' => 1, // Mesin
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 2,
            'id_kategori' => 2, // Handpoke
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 2,
            'id_kategori' => 3, // Hand tap
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 3,
            'id_kategori' => 1, // Mesin
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 3,
            'id_kategori' => 2, // Handpoke
        ]);
        ArtisKategori::create([
            'id_artis_tato' => 3,
            'id_kategori' => 3, // Hand tap
        ]);

        // create portfolio
        Portfolio::create([
            'id_artis_tato' => 1,
            'judul' => 'Portfolio Artis Tato 1',
            'gambar' => 'portfolio/portfolio1.jpg',
            'deskripsi' => 'Portfolio Artis Tato 1',
        ]);
        Portfolio::create([
            'id_artis_tato' => 2,
            'judul' => 'Portfolio Artis Tato 2',
            'gambar' => 'portfolio/portfolio2.jpg',
            'deskripsi' => 'Portfolio Artis Tato 2',
        ]);
        Portfolio::create([
            'id_artis_tato' => 3,
            'judul' => 'Portfolio Artis Tato 3',
            'gambar' => 'portfolio/portfolio3.jpg',
            'deskripsi' => 'Portfolio Artis Tato 3',
        ]);

        // create lokasi tato
        LokasiTato::create([
            'nama_lokasi_tato' => 'Lengan Kiri',
        ]);

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
                'kondisi_if' => json_encode(['permintaan_khusus' => 'satu warna', 'kategori_kompleksitas' => 'rendah']),
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
