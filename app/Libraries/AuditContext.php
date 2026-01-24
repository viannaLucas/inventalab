<?php

namespace App\Libraries;

final class AuditContext
{
    private static ?AuditContext $instance = null;
    private ?string $requestId = null;

    private function __construct() {}
    private function __clone() {}

    public static function getInstance(): AuditContext
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function setRequestId(string $id): void
    {
        $this->requestId = $id;
    }

    public function getRequestId(): ?string
    {
        return $this->requestId;
    }

    public function clear(): void
    {
        $this->requestId = null;
    }
}
