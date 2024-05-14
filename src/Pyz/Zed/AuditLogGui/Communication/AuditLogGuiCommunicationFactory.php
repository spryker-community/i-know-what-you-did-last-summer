<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLogGui\Communication;

use Orm\Zed\AuditLog\Persistence\AuditLogsQuery;
use Pyz\Zed\AuditLog\Business\AuditLogFacadeInterface;
use Pyz\Zed\AuditLogGui\AuditLogGuiDependencyProvider;
use Pyz\Zed\AuditLogGui\Communication\Table\AuditLogTable;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;

/**
 * @method \Pyz\Zed\AuditLogGui\AuditLogGuiConfig getConfig()
 */
class AuditLogGuiCommunicationFactory extends AbstractCommunicationFactory
{
    /**
     * @return \Pyz\Zed\AuditLogGui\Communication\Table\AuditLogTable
     */
    public function auditLogTable(): AuditLogTable
    {
        return new AuditLogTable(
            $this->getAuditLogPropelQuery(),
        );
    }

    /**
     * @return \Orm\Zed\AuditLog\Persistence\AuditLogsQuery
     */
    public function getAuditLogPropelQuery(): AuditLogsQuery
    {
        return $this->getProvidedDependency(AuditLogGuiDependencyProvider::PROPEL_QUERY_AUDIT_LOG);
    }

    /**
     * @return \Pyz\Zed\AuditLog\Business\AuditLogFacadeInterface
     */
    public function getAuditLogFacade(): AuditLogFacadeInterface
    {
        return $this->getProvidedDependency(AuditLogGuiDependencyProvider::FACADE_AUDIT_LOG);
    }
}
