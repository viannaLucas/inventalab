<?php

namespace App\Services;

use App\Models\AuditLogModel;
use App\Libraries\AuditContext;

class AuditLogService
{
    public static function write(
        string $action,
        string $tableName,
        $recordId = null,
        array $changes = []
    ): void {
        $requestId = AuditContext::getInstance()->getRequestId();

        // user_id: ajuste conforme seu login (aqui assume session()->get('user_id'))
        $userId = \App\Models\UsuarioModel::getSessao()?->id;

        $controller = null;
        $method = null;

        // Em alguns contextos (CLI) pode não existir router
        try {
            $router = service('router');
            $controller = method_exists($router, 'controllerName') ? $router->controllerName() : null;
            $method     = method_exists($router, 'methodName') ? $router->methodName() : null;
        } catch (\Throwable $e) {
            // ignora
        }
        
        $payload = [
            'request_id' => $requestId,
            'user_id'    => $userId,
            'action'     => $action,
            'table_name' => $tableName,
            'record_id'  => $recordId !== null ? (string) $recordId : null,
            'controller' => $controller,
            'method'     => $method,
            'changes'    => !empty($changes) ? json_encode($changes, JSON_UNESCAPED_UNICODE) : null,
            'ip_address' => service('request')->getIPAddress(),
            'user_agent' => service('request')->getHeaderLine('User-Agent'),
            'created_at' => date('Y-m-d H:i:s'),
        ];

        model(AuditLogModel::class)->insert($payload);
    }
}
