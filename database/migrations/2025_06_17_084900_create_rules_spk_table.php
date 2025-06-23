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
        Schema::create('rules_spk', function (Blueprint $table) {
            $table->id();
            $table->string('nama'); // Contoh: R01, R02, dst
            $table->json('kondisi_if'); // JSON format: {"desain":"sleeve","ukuran":"besar"}
            $table->json('hasil_then'); // JSON format: {"kategori_kompleksitas":"tinggi","durasi_estimasi":"8 jam"}
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rules_spk');
    }
};
