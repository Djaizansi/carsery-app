<?php

namespace App\Helpers;

class RandomNumberSize {
    public static function getNumberRandom(int $size): string
    {
        $number = '';
        for($i=0;$i<$size;$i++){
            $number .= rand($i === 0 ? 1 : 0,9);
        }
        return $number;
    }
}