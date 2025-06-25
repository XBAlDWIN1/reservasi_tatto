<?php

namespace App\Helpers;

class HargaHelper
{
    public static function hitungHargaDasar($panjang, $lebar, $kategoriNama)
    {
        $luas = $panjang * $lebar;

        $kategoriNama = strtolower($kategoriNama ?? '');

        if (str_contains($kategoriNama, 'mesin')) {
            $hargaPerCm = 15000;
            $hargaMinimal = 800000;
        } elseif (str_contains($kategoriNama, 'handpoke') || str_contains($kategoriNama, 'hand tap')) {
            $hargaPerCm = 16000;
            $hargaMinimal = 900000;
        } else {
            $hargaPerCm = 15000;
            $hargaMinimal = 800000;
        }

        return max($luas * $hargaPerCm, $hargaMinimal);
    }
}
