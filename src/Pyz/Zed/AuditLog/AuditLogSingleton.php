<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog;

use Generated\Shared\Transfer\AuditLogTransfer;
use Spryker\Zed\Kernel\Locator;

class AuditLogSingleton
{
    /**
     * @var self|null
     */
    private static ?AuditLogSingleton $instance = null;

    /**
     * @var list<\Generated\Shared\Transfer\AuditLogTransfer>
     */
    private array $auditLogs = [];

    /**
     * @return self
     */
    public static function getInstance(): self
    {
        if (self::$instance === null) {
            self::$instance = new self();
            register_shutdown_function(['Pyz\Zed\AuditLog\AuditLogSingleton', 'write']);
        }

        return self::$instance;
    }

    /**
     * @param \Generated\Shared\Transfer\AuditLogTransfer $auditLogTransfer
     *
     * @return void
     */
    public function collectAuditLogData(AuditLogTransfer $auditLogTransfer): void
    {
        $this->auditLogs[] = $auditLogTransfer;
    }

    /**
     * @return list<\Generated\Shared\Transfer\AuditLogTransfer>
     */
    public function getLogs(): array
    {
        return $this->auditLogs;
    }

    /**
     * @return void
     */
    public static function write(): void
    {
        Locator::getInstance()->event()->facade()->triggerBulk(
            AuditLogConfig::PUBLISH_AUDIT_LOG,
            static::getInstance()->getLogs(),
        );
    }
}
