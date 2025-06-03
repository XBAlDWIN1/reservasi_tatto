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
        Schema::create('artis_tatos', function (Blueprint $table) {
            $table->id('id_artis_tato');
            $table->string('nama_artis_tato')->unique();
            $table->string('tahun_menato');
            $table->string('instagram')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('gambar')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artis_tatos');
    }
};
