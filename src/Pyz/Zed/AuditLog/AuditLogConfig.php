<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class AuditLogConfig extends AbstractBundleConfig
{
    /**
     * @var string
     */
    public const PUBLISH_AUDIT_LOG = 'publish.audit_log';

    /**
     * @var array<string>
     */
    protected const SENSITIVE_AUDIT_LOG_KEYS = [
        'password',
    ];

    /**
     * @return array<string>
     */
    public function getSensitiveAuditLogKeys(): array
    {
        return static::SENSITIVE_AUDIT_LOG_KEYS;
    }
}
