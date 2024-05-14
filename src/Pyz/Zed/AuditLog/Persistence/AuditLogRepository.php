<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Persistence;

use Generated\Shared\Transfer\AuditLogTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogPersistenceFactory getFactory()
 */
class AuditLogRepository extends AbstractRepository implements AuditLogRepositoryInterface
{
    /**
     * @param int $idAuditLog
     *
     * @return \Generated\Shared\Transfer\AuditLogTransfer|null
     */
    public function findAuditLogById(int $idAuditLog): ?AuditLogTransfer
    {
        $auditLogEntity = $this->getFactory()
            ->createAuditLogQuery()
            ->filterById($idAuditLog)
            ->findOne();

        if (!$auditLogEntity) {
            return null;
        }

        return (new AuditLogTransfer())->fromArray($auditLogEntity->toArray(), true);
    }
}
