<?php
namespace App\Helpers;
 
class AllHelper {

    public static function rupiah($rupiah) {
        $hasil = 'Rp'.number_format($rupiah, 0, ',', '.');

        return $hasil;
    }

    public static function rupiah_v2($rupiah) {
        $hasil = 'Rp'.number_format($rupiah, 2, ',', '.');

        return $hasil;
    }

}