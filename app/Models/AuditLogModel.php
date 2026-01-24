<?php

namespace App\Models;

use CodeIgniter\Model;

class AuditLogModel extends Model
{
    protected $table = 'audit_logs';
    protected $primaryKey = 'id';

    protected $allowedFields = [
        'request_id',
        'user_id',
        'action',
        'table_name',
        'record_id',
        'controller',
        'method',
        'changes',
        'ip_address', 
        'user_agent',   
        'created_at',
    ];

    protected $useTimestamps = false; // vamos setar created_at manualmente
}
