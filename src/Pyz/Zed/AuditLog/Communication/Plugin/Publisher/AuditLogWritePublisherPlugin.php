<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Communication\Plugin\Publisher;

use Pyz\Zed\AuditLog\AuditLogConfig;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;

/**
 * @method \Pyz\Zed\AuditLog\AuditLogConfig getConfig()
 * @method \Pyz\Zed\AuditLog\Business\AuditLogFacadeInterface getFacade()
 */
class AuditLogWritePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * {@inheritDoc}
     * - Stores data in the audit_log database table.
     *
     * @api
     *
     * @param list<\Generated\Shared\Transfer\EventEntityTransfer|\Generated\Shared\Transfer\AuditLogTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $this->getFacade()->writeAuditLogCollection($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return list<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            AuditLogConfig::PUBLISH_AUDIT_LOG,
        ];
    }
}
