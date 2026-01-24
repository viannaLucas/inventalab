<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class CastCurrencyBR extends BaseCast
{
    public static function get($value, array $params = []) {
        return number_format($value, 2, ',', '.');
    }

    public static function set($value, array $params = []) {
        if(str_contains($value, ',')){
            $value = str_replace(array('.', ','), array('', '.'), $value);
        }
        return $value;
    }
}