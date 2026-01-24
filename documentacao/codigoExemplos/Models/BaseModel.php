<?php

namespace App\Models;

use CodeIgniter\Model;
use CodeIgniter\HTTP\Files\UploadedFile;

class BaseModel extends Model {
    
    protected $cleanValidationRules = false;
    protected $validationRulesFiles = [];
    protected $allowCallbacks = true;

    public function uploadFile(UploadedFile $file, $name=null, $folder = ''): bool|string {
        if ($file->isValid() && !$file->hasMoved()) {
            if($folder != '') {
                $folder = rtrim($folder, '/').'/';
            }
            $name = $name ?? $file->getRandomName();
            $file->move(WRITEPATH.$folder, $name);
            return WRITEPATH.$folder.$name;
        }
        return false;
    }

    public function uploadImage(UploadedFile $file,
            $name=null, $folder = '', $max_width = 1000, $max_height = 1000):bool|string {
        if ($file->isValid() && !$file->hasMoved()) {
            if($folder != '') {
                $folder = rtrim($folder, '/').'/';
            }
            $name = $name ?? $file->getRandomName();
            $path = WRITEPATH.$folder . $name;
            \Config\Services::image('imagick')
                    ->withFile($file->getRealPath())
                    ->resize($max_width, $max_height, true)
                    ->save($path);
            return $path;
        }
        return false;
    }
    
    public function deleteFiles(array $pathsURI){
        foreach($pathsURI as $p){
            $this->deleteFile($p);
        }
    }
    
    public function deleteFile($pathURI){
        if(is_file(WRITEPATH.$pathURI)){
            return unlink(WRITEPATH.$pathURI);
        }
        return false;
    }
    
    public function getValidationRulesFiles(){
        return $this->validationRulesFiles;
    }
}
