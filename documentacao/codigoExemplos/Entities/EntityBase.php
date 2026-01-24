<?php

namespace App\Entities;

use CodeIgniter\Entity\Entity;

class EntityBase extends Entity {

    protected $datamap = [];
    protected $dates = [];
    protected $casts = [];
    
    protected $castHandlers = [
        'dateBR' => \App\Entities\Cast\CastDateBR::class,
        'currencyBR' => \App\Entities\Cast\CastCurrencyBR::class,
        'filePath' => \App\Entities\Cast\CastFilePath::class,
    ];
    
    public static function _op($variable, $index = null){
        $cl = get_called_class();
        $o = new $cl();
        $vn = 'op_'.$variable;
        $op =  $o->$vn ?? null;
        if($index == null && $op!=null){
            return $op;
        }
        if($op !== null && $index !== null){
            return $o->$vn[$index] ?? null;
        }
        return $op;
    }
    
    public static function _cl($variable, $index = null){
        $cl = get_called_class();
        $o = new $cl();
        $vn = 'color_'.$variable;
        $co =  $o->$vn ?? null;
        if($index == null && $co!=null){
            return $co;
        }
        if($co !== null && $index !== null){
            return $o->$vn[$index] ?? null;
        }
        return $co;
    }
}
