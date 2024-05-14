<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog;

trait AuditLogTrait
{
    /**
     * @return \Pyz\Zed\AuditLog\AuditLogSingleton
     */
    public function getAuditLogger(): AuditLogSingleton
    {
        return AuditLogSingleton::getInstance();
    }
}
