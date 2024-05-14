<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLog\Business;

use Pyz\Zed\AuditLog\Business\Sanitizer\LogSanitizer;
use Pyz\Zed\AuditLog\Business\Writer\AuditLogWriter;
use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;

/**
 * @method \Pyz\Zed\AuditLog\AuditLogConfig getConfig()
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogEntityManagerInterface getEntityManager()
 * @method \Pyz\Zed\AuditLog\Persistence\AuditLogRepositoryInterface getRepository()
 */
class AuditLogBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \Pyz\Zed\AuditLog\Business\Writer\AuditLogWriter
     */
    public function createAuditLogWriter(): AuditLogWriter
    {
        return new AuditLogWriter($this->getEntityManager());
    }

    /**
     * @return \Pyz\Zed\AuditLog\Business\Sanitizer\LogSanitizer
     */
    public function createAuditLogSanitizer(): LogSanitizer
    {
        return new LogSanitizer($this->getConfig());
    }
}
