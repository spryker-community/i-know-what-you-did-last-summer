<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Business\Sanitizer;

use Generated\Shared\Transfer\AuditLogTransfer;
use Pyz\Zed\AuditLog\AuditLogConfig;

class LogSanitizer
{
    private AuditLogConfig $config;

    /**
     * @param \Pyz\Zed\AuditLog\AuditLogConfig $config
     */
    public function __construct(AuditLogConfig $config)
    {
        $this->config = $config;
    }

    /**
     * @param \Generated\Shared\Transfer\AuditLogTransfer $auditLogTransfer
     *
     * @return \Generated\Shared\Transfer\AuditLogTransfer
     */
    public function sanitizeAuditLog(AuditLogTransfer $auditLogTransfer): AuditLogTransfer
    {
        foreach ($this->config->getSensitiveAuditLogKeys() as $sensitiveKey) {
            if ($auditLogTransfer->offsetExists($sensitiveKey)) {
                $auditLogTransfer->offsetSet($sensitiveKey, '[SANITIZED]');
            }
        }

        return $auditLogTransfer;
    }
}
