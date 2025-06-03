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
        Schema::create('artis_kategoris', function (Blueprint $table) {
            $table->id('id_artis_kategori');
            $table->unsignedBigInteger('id_artis_tato');
            $table->unsignedBigInteger('id_kategori');
            $table->timestamps();

            $table->foreign('id_artis_tato')
                ->references('id_artis_tato')
                ->on('artis_tatos')
                ->onDelete('cascade');

            $table->foreign('id_kategori')
                ->references('id_kategori')
                ->on('kategoris')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artis_kategoris');
    }
};
