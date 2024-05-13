<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog;

use Generated\Shared\Transfer\AuditLogTransfer;
use Spryker\Zed\Event\Business\EventFacade;

class AuditLogSingleton
{
    private static $instance = null;

    private $auditLogs = [];

    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
            register_shutdown_function(['Pyz\Zed\AuditLog\AuditLogSingleton', 'write']);
        }

        return self::$instance;
    }

    /**
     * @return void
     */
    public function collectAuditLogData(AuditLogTransfer $auditLogTransfer): void
    {
        $this->auditLogs[] = $auditLogTransfer;
    }

    public function getLogs(): array
    {
        return $this->auditLogs;
    }

    /**
     * @return void
     */
    public static function write(): void
    {
        foreach (static::getInstance()->getLogs() as $auditLogTransfer) {
            file_put_contents(APPLICATION_ROOT_DIR . '/data/audit.log', json_encode($auditLogTransfer->toArray()) . PHP_EOL, FILE_APPEND);
        }

        (new EventFacade())->triggerBulk(AuditLogConfig::PUBLISH_AUDIT_LOG, static::getInstance()->getLogs());
    }
}
