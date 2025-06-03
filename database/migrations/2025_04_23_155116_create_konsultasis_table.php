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
            $table->unsignedBigInteger('id_artis_tato');
            $table->unsignedBigInteger('id_lokasi_tato');
            $table->unsignedBigInteger('id_kategori');
            $table->integer('panjang')->nullable();
            $table->integer('lebar')->nullable();
            $table->datetime('jadwal_konsultasi');
            $table->string('gambar')->nullable();
            $table->text('catatan')->nullable();
            $table->enum('status', ['menunggu', 'diterima', 'ditolak'])->default('menunggu');
            $table->timestamps();
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
