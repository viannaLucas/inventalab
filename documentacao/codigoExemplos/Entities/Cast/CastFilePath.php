<?php

namespace App\Entities\Cast;

use CodeIgniter\Entity\Cast\BaseCast;

class CastFilePath extends BaseCast
{
    public static function get($value, array $params = []) {
        if($value == '') return $value;
        $folder = isset($params[0]) ? $params[0] : '';
        $folder = !str_ends_with($folder, '/') && $folder != '' ? $folder.'/' : $folder;
        return $folder.$value;
    }

    public static function set($value, array $params = []) {
        $sepator = str_contains($value, '/') ? '/' : '\\';
        $e = explode($sepator, $value);
        return end($e);
    }
}