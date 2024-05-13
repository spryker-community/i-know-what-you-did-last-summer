<?php

namespace Pyz\Zed\AuditLog;

trait AuditLogTrait
{
    public function getAuditLogger(): AuditLogSingleton
    {
        return AuditLogSingleton::getInstance();
    }
}
