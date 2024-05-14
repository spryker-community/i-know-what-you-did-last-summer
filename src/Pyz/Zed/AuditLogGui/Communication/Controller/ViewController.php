<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLogGui\Communication\Controller;

use Pyz\Zed\AuditLogGui\AuditLogGuiConfig;
use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

/**
 * @method \Pyz\Zed\AuditLogGui\Communication\AuditLogGuiCommunicationFactory getFactory()
 */
class ViewController extends AbstractController
{
 /**
  * @var string
  */
    protected const REQUEST_ID_AUDIT_LOG = 'id-audit-log';

    /**
     * @var string
     */
    protected const MESSAGE_ERROR_AUDIT_LOG_NOT_EXIST = 'Audit log with id `%s` does not exist';

    /**
     * @var string
     */
    protected const MESSAGE_ID_PLACEHOLDER = '%s';

    /**
     * @param \Symfony\Component\HttpFoundation\Request $request
     *
     * @return \Symfony\Component\HttpFoundation\RedirectResponse|array
     */
    public function indexAction(Request $request)
    {
        $idAuditLog = $request->get(static::REQUEST_ID_AUDIT_LOG);
        if (!$idAuditLog) {
            return $this->redirectResponse(AuditLogGuiConfig::URL_AUDIT_LOG_LIST);
        }

        $idAuditLog = $this->castId($idAuditLog);
        $auditLogTransfer = $this->getFactory()
            ->getAuditLogFacade()
            ->findAuditLogById($idAuditLog);

        if ($auditLogTransfer === null) {
            $this->addErrorMessage(static::MESSAGE_ERROR_AUDIT_LOG_NOT_EXIST, [
                static::MESSAGE_ID_PLACEHOLDER => $idAuditLog,
            ]);

            return $this->redirectResponse(AuditLogGuiConfig::URL_AUDIT_LOG_LIST);
        }

        return $this->viewResponse([
            'auditLog' => $auditLogTransfer,
        ]);
    }
}
