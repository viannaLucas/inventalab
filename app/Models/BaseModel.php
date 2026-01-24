<?php

namespace App\Models;

use App\Services\AuditLogService;
use CodeIgniter\Model;
use CodeIgniter\HTTP\Files\UploadedFile;
use App\Libraries\HtmlSanitizer;

class BaseModel extends Model {
    
    protected $cleanValidationRules = false;
    protected $validationRulesFiles = [];
    protected $allowCallbacks = true;
    protected array $sanitizeHtmlFields = [];
    // Campos que você NÃO quer auditar
    protected array $auditIgnoreFields = [
        'password',
        'senha',
        'token',
        'remember_token',
        'updated_at',
        'created_at',
        'deleted_at',
    ];

    // Guarda o "antes" para comparar no afterUpdate/afterDelete
    protected array $auditOriginal = [];

    protected $beforeUpdate = ['auditCaptureBeforeUpdate'];
    protected $afterUpdate  = ['auditAfterUpdate'];

    protected $afterInsert  = ['auditAfterInsert'];

    protected $beforeDelete = ['auditCaptureBeforeDelete'];
    protected $afterDelete  = ['auditAfterDelete'];

    protected function auditAfterInsert(array $data)
    {
        $id = $data['id'] ?? null;

        $newData = $data['data'] ?? [];
        $newData = $this->filterAuditData($newData);

        AuditLogService::write('insert', $this->table, $id, $this->buildAuditPayload('criado', $newData));

        return $data;
    }

    protected function sanitizeHtmlFields(array $data): array
    {
        if (empty($this->sanitizeHtmlFields)) {
            return $data;
        }

        if (!isset($data['data']) || !is_array($data['data'])) {
            return $data;
        }

        $sanitizer = new HtmlSanitizer();
        foreach ($this->sanitizeHtmlFields as $field) {
            if (array_key_exists($field, $data['data'])) {
                $data['data'][$field] = $sanitizer->limpar($data['data'][$field]);
            }
        }

        return $data;
    }

    protected function auditCaptureBeforeUpdate(array $data)
    {
        $id = $this->extractSingleId($data['id'] ?? null);
        $this->auditOriginal = [];

        if ($id !== null) {
            // pega o registro antes da alteração
            $this->auditOriginal = (array) $this->asArray()->find($id);
        }

        return $data;
    }

    protected function auditAfterUpdate(array $data)
    {
        $id = $this->extractSingleId($data['id'] ?? null);

        $newData = $data['data'] ?? [];
        $newData = $this->filterAuditData($newData);

        $old = $this->filterAuditData($this->auditOriginal);

        $changes = $this->diffChanges($old, $newData);

        // Se não mudou nada relevante, não grava
        if (!empty($changes)) {
            AuditLogService::write('update', $this->table, $id, $this->buildAuditPayload('alterado', $changes));
        }

        // limpa cache
        $this->auditOriginal = [];

        return $data;
    }

    protected function auditCaptureBeforeDelete(array $data)
    {
        $id = $this->extractSingleId($data['id'] ?? null);
        $this->auditOriginal = [];

        if ($id !== null) {
            $this->auditOriginal = (array) $this->asArray()->find($id);
        }

        return $data;
    }

    protected function auditAfterDelete(array $data)
    {
        $id = $this->extractSingleId($data['id'] ?? null);

        $old = $this->filterAuditData($this->auditOriginal);

        AuditLogService::write('delete', $this->table, $id, $this->buildAuditPayload('excluido', $old));

        $this->auditOriginal = [];

        return $data;
    }

    private function diffChanges(array $old, array $new): array
    {
        $changes = [];

        foreach ($new as $field => $newValue) {
            $oldValue = $old[$field] ?? null;

            // compara sem ser “chato” com tipos
            if ($oldValue != $newValue) {
                $changes[$field] = [
                    'from' => $oldValue,
                    'to'   => $newValue,
                ];
            }
        }

        return $changes;
    }

    private function filterAuditData(array $data): array
    {
        foreach ($this->auditIgnoreFields as $field) {
            unset($data[$field]);
        }
        return $data;
    }

    private function extractSingleId($id)
    {
        // CI4 geralmente manda array de ids: [1]
        if (is_array($id)) {
            return $id[0] ?? null;
        }
        return $id;
    }
    
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

    protected function initialize()
    {
        parent::initialize();

        // GARANTE que os callbacks de auditoria estejam registrados,
        // mesmo quando o model filho define $beforeUpdate/$afterUpdate etc.

        // beforeUpdate: queremos capturar o "antes" o mais cedo possível
        $this->beforeUpdate = $this->prependCallback($this->beforeUpdate ?? [], 'auditCaptureBeforeUpdate');

        // afterUpdate: gravar diff
        $this->afterUpdate  = $this->appendCallback($this->afterUpdate ?? [], 'auditAfterUpdate');

        // afterInsert: gravar insert
        $this->afterInsert  = $this->appendCallback($this->afterInsert ?? [], 'auditAfterInsert');

        // beforeDelete: capturar snapshot antes de apagar
        $this->beforeDelete = $this->prependCallback($this->beforeDelete ?? [], 'auditCaptureBeforeDelete');

        // afterDelete: gravar delete
        $this->afterDelete  = $this->appendCallback($this->afterDelete ?? [], 'auditAfterDelete');
    }

    private function prependCallback(array $list, string $callback): array
    {
        // evita duplicar
        $list = array_values(array_filter($list, fn($c) => $c !== $callback));
        array_unshift($list, $callback);
        return $list;
    }

    private function appendCallback(array $list, string $callback): array
    {
        if (!in_array($callback, $list, true)) {
            $list[] = $callback;
        }
        return $list;
    }

    private function buildAuditPayload(string $acao, array $data): array
    {
        return [
            'acao' => $acao,
            'data' => $data,
        ];
    }
}
