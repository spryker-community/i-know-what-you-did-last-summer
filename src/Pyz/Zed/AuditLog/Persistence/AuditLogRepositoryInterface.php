<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Persistence;

use Generated\Shared\Transfer\AuditLogTransfer;

interface AuditLogRepositoryInterface
{
    /**
     * @param int $idAuditLog
     *
     * @return \Generated\Shared\Transfer\AuditLogTransfer|null
     */
    public function findAuditLogById(int $idAuditLog): ?AuditLogTransfer;
}
