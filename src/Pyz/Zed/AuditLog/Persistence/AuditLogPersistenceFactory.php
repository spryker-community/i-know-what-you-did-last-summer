<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Persistence;

use Orm\Zed\AuditLog\Persistence\AuditLogsQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \Pyz\Zed\AuditLog\AuditLogConfig getConfig()
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogRepositoryInterface getRepository()
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogEntityManagerInterface getEntityManager()
 */
class AuditLogPersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\AuditLog\Persistence\AuditLogsQuery
     */
    public function createAuditLogQuery(): AuditLogsQuery
    {
        return AuditLogsQuery::create();
    }
}
