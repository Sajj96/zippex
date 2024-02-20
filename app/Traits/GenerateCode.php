<?php

namespace App\Traits;

trait GenerateCode
{
    public static function getToken($len)
    {
        $characters = '123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $string = '';
        $max = strlen($characters) - 1;
        for ($i = 0; $i < $len; $i++) {
            $string .= $characters[mt_rand(0, $max)];
        }
        return $string;
    }
}
