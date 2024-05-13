<?php

namespace Pyz\Zed\User\Communication\Controller;

use Generated\Shared\Transfer\AuditLogTransfer;
use Pyz\Zed\AuditLog\AuditLogTrait;
use Spryker\Zed\User\Communication\Controller\EditController as SprykerEditController;
use Symfony\Component\HttpFoundation\Request;

class EditController extends SprykerEditController
{
    use AuditLogTrait;

    public function updateAction(Request $request)
    {
        $this
            ->getAuditLogger()
            ->collectAuditLogData(
                (new AuditLogTransfer())
                    ->setAction('update')
            );

        return parent::updateAction($request);
    }
}
