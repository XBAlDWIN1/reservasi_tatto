<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('konsultasis', function (Blueprint $table) {
            $table->id('id_konsultasi');
            $table->unsignedBigInteger('id_pengguna');
            $table->unsignedBigInteger('id_artis_tato')->nullable();
            $table->unsignedBigInteger('id_lokasi_tato');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('panjang')->nullable();
            $table->integer('lebar')->nullable();
            $table->datetime('jadwal_konsultasi');
            $table->string('gambar')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->enum('kompleksitas', ['tinggi', 'sedang', 'rendah'])->nullable();
            $table->time('durasi_estimasi')->nullable();
            $table->unsignedInteger('biaya_tambahan')->nullable();
            $table->timestamps();

            // Optional: tambahkan foreign key constraint
            // $table->foreign('id_pengguna')->references('id')->on('users');
            // $table->foreign('id_artis_tato')->references('id')->on('artis_tatos');
            // $table->foreign('id_lokasi_tato')->references('id')->on('lokasi_tatos');
            // $table->foreign('id_kategori')->references('id')->on('kategoris');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konsultasis');
    }
};
