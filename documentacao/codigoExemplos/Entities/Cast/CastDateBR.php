<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class CastDateBR extends BaseCast
{
    public static function get($value, array $params = []) {
        $dt = \DateTime::createFromFormat('Y-m-d', $value);
        return $dt != false ? $dt->format('d/m/Y') : $value;
    }

    public static function set($value, array $params = []) {
        $dt = \DateTime::createFromFormat('d/m/Y', $value);
        return $dt != false ? $dt->format('Y-m-d') : $value;
    }
}