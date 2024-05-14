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
    /**
     * @var string
     */
    protected const SANITIZED_VALUE = '[SANITIZED]';

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
                $auditLogTransfer->offsetSet($sensitiveKey, static::SANITIZED_VALUE);
            }

            if ($auditLogTransfer->getDetails()) {
                $this->sanitizeDetails($auditLogTransfer);
            }
        }

        return $auditLogTransfer;
    }

    /**
     * @param array<mixed, mixed> $data
     *
     * @return <mixed,mixed>
     */
    private function sanitizeArray(array $data): array
    {
        foreach ($data as $key => $value) {
            if (is_array($value)) {
                $data[$key] = $this->sanitizeArray($value);
            } elseif (in_array($key, $this->config->getSensitiveAuditLogKeys(), true)) {
                $data[$key] = static::SANITIZED_VALUE;
            }
        }

        return $data;
    }

    /**
     * @param \Generated\Shared\Transfer\AuditLogTransfer $auditLogTransfer
     *
     * @return void
     */
    public function sanitizeDetails(AuditLogTransfer $auditLogTransfer): void
    {
        $details = json_decode($auditLogTransfer->getDetails(), true);
        $sanitizedDetails = $this->sanitizeArray($details);
        $auditLogTransfer->setDetails(json_encode($sanitizedDetails));
    }
}
