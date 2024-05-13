<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Business;

interface AuditLogFacadeInterface
{
    /**
     * @param list<\Generated\Shared\Transfer\EventEntityTransfer|\Generated\Shared\Transfer\AuditLogTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeAuditLogCollection(array $eventEntityTransfers): void;
}
