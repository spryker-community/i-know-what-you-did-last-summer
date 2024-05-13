<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Business\Writer;

use Pyz\Zed\AuditLog\Persistence\AuditLogEntityManagerInterface;

class AuditLogWriter
{
    /**
     * @var \Pyz\Zed\AuditLog\Persistence\AuditLogEntityManagerInterface
     */
    protected $auditLogEntityManager;

    /**
     * @param \Pyz\Zed\AuditLog\Persistence\AuditLogEntityManagerInterface $auditLogEntityManager
     */
    public function __construct(AuditLogEntityManagerInterface $auditLogEntityManager)
    {
        $this->auditLogEntityManager = $auditLogEntityManager;
    }

    /**
     * @param list<\Generated\Shared\Transfer\AuditLogTransfer> $auditLogTransfers
     *
     * @return void
     */
    public function writeAuditLogCollection(array $auditLogTransfers): void
    {
        foreach ($auditLogTransfers as $auditLogTransfer) {
            $this->auditLogEntityManager->saveAuditLog($auditLogTransfer);
        }
    }
}
