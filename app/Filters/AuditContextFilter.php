<?php

namespace App\Filters;

use App\Libraries\AuditContext;
use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

class AuditContextFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $context = AuditContext::getInstance();
        $context->setRequestId($this->uuidv4());
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
        $context = AuditContext::getInstance();
        $rid = $context->getRequestId();

        if (!empty($rid)) {
            $response->setHeader('X-Request-ID', $rid);
        }

        $context->clear();
    }

    private function uuidv4(): string
    {
        $data = random_bytes(16);
        $data[6] = chr((ord($data[6]) & 0x0f) | 0x40);
        $data[8] = chr((ord($data[8]) & 0x3f) | 0x80);
        return vsprintf('%s%s-%s-%s-%s-%s%s%s', str_split(bin2hex($data), 4));
    }
}
