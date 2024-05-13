<?php

namespace Pyz\Zed\AuditLog;

use Generated\Shared\Transfer\AuditLogTransfer;

class AuditLogSingleton
{
    private static $instance = null;
    private $auditLogs = [];

    public static function getInstance(): AuditLogSingleton
    {
        if (self::$instance === null) {
            self::$instance = new AuditLogSingleton();
            register_shutdown_function(['Pyz\Zed\AuditLog\AuditLogSingleton', 'write']);
        }

        return self::$instance;
    }

    public function collectAuditLogData(AuditLogTransfer $auditLogTransfer): void
    {
        $this->auditLogs[] = $auditLogTransfer;
    }

    public function getLogs(): array
    {
        return $this->auditLogs;
    }

    public static function write(): void
    {
        foreach (static::getInstance()->getLogs() as $auditLogTransfer) {
            file_put_contents(APPLICATION_ROOT_DIR . '/data/audit.log', json_encode($auditLogTransfer->toArray()) . PHP_EOL, FILE_APPEND);
        }
    }
}
