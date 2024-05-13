<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Persistence;

use Generated\Shared\Transfer\AuditLogTransfer;
use Orm\Zed\AuditLog\Persistence\AuditLogs;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogPersistenceFactory getFactory()
 */
class AuditLogEntityManager extends AbstractEntityManager implements AuditLogEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\AuditLogTransfer $auditLogTransfer
     *
     * @return void
     */
    public function saveAuditLog(AuditLogTransfer $auditLogTransfer): void
    {
        $auditLogEntity = new AuditLogs();
        $auditLogEntity->fromArray($auditLogTransfer->modifiedToArray());
        $auditLogEntity->save();
    }
}
