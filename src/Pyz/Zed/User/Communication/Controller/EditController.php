<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\User\Communication\Controller;

use Generated\Shared\Transfer\AuditLogTransfer;
use Pyz\Zed\AuditLog\AuditLogTrait;
use Spryker\Zed\User\Communication\Controller\EditController as SprykerEditController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Spryker\Zed\User\Business\UserFacadeInterface getFacade()
 * @method \Spryker\Zed\User\Communication\UserCommunicationFactory getFactory()
 * @method \Spryker\Zed\User\Persistence\UserRepositoryInterface getRepository()
 */
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
                    ->setUserId($this->getFacade()->getCurrentUser()->getIdUser())
                    ->setEntityType('user')
                    ->setEntityId($this->castId($request->get(static::PARAM_ID_USER)))
                    ->setTimestamp(time()),
            );

        return parent::updateAction($request);
    }
}
