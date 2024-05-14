<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLogGui;

use Orm\Zed\AuditLog\Persistence\AuditLogsQuery;
use Spryker\Zed\Kernel\AbstractBundleDependencyProvider;
use Spryker\Zed\Kernel\Container;

/**
 * @method \Pyz\Zed\AuditLogGui\AuditLogGuiConfig getConfig()
 */
class AuditLogGuiDependencyProvider extends AbstractBundleDependencyProvider
{
    /**
     * @var string
     */
    public const PROPEL_QUERY_AUDIT_LOG = 'PROPEL_QUERY_AUDIT_LOG';

    /**
     * @var string
     */
    public const FACADE_AUDIT_LOG = 'FACADE_AUDIT_LOG';

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    public function provideCommunicationLayerDependencies(Container $container): Container
    {
        $container = parent::provideCommunicationLayerDependencies($container);

        $container = $this->addAuditLogPropelQuery($container);
        $container = $this->addAuditLogFacade($container);

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAuditLogPropelQuery(Container $container): Container
    {
        $container->set(static::PROPEL_QUERY_AUDIT_LOG, $container->factory(function () {
            return AuditLogsQuery::create();
        }));

        return $container;
    }

    /**
     * @param \Spryker\Zed\Kernel\Container $container
     *
     * @return \Spryker\Zed\Kernel\Container
     */
    protected function addAuditLogFacade(Container $container): Container
    {
        $container->set(static::FACADE_AUDIT_LOG, function (Container $container) {
            return $container->getLocator()->auditLog()->facade();
        });

        return $container;
    }
}
