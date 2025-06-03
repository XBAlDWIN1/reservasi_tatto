<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use App\Models\Pelanggan;
use App\Models\Kategori;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
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
            'deskripsi' => 'Deskripsi Kategori 1',
        ]);
        Kategori::create([
            'nama_kategori' => 'Handpoke',
            'deskripsi' => 'Deskripsi Kategori 2',
        ]);
        Kategori::create([
            'nama_kategori' => 'Hand tap',
            'deskripsi' => 'Deskripsi Kategori 3',
        ]);
    }
}
