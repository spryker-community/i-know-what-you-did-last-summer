<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace Pyz\Zed\AuditLog\Communication;

use Pyz\Zed\AuditLog\AuditLogDependencyProvider;
use Pyz\Zed\AuditLog\Communication\EventSubscriber\AuditLogBackOfficeEventSubscriber;
use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use Spryker\Zed\User\Business\UserFacadeInterface;

/**
 * @method \Pyz\Zed\AuditLog\AuditLogConfig getConfig()
 * @method \Pyz\Zed\AuditLog\Business\AuditLogFacadeInterface getFacade()
 */
class AuditLogCommunicationFactory extends AbstractCommunicationFactory
{
    public function createAuditLogBackOfficeEventSubscriber(): AuditLogBackOfficeEventSubscriber
    {
        return new AuditLogBackOfficeEventSubscriber(
            $this->getUserFacade(),
        );
    }

    /**
     * @return \Spryker\Zed\User\Business\UserFacadeInterface
     */
    public function getUserFacade(): UserFacadeInterface
    {
        return $this->getProvidedDependency(AuditLogDependencyProvider::FACADE_USER);
    }
}
