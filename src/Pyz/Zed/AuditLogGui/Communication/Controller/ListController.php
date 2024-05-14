<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLogGui\Communication\Controller;

use Spryker\Zed\Kernel\Communication\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

/**
 * @method \Pyz\Zed\AuditLogGui\Communication\AuditLogGuiCommunicationFactory getFactory()
 */
class ListController extends AbstractController
{
    /**
     * @return array
     */
    public function indexAction(): array
    {
        $auditLogTable = $this->getFactory()->auditLogTable();

        return $this->viewResponse([
            'auditLogTable' => $auditLogTable->render(),
        ]);
    }

    /**
     * @return \Symfony\Component\HttpFoundation\JsonResponse
     */
    public function tableAction(): JsonResponse
    {
        $auditLogTable = $this->getFactory()->auditLogTable();

        return $this->jsonResponse(
            $auditLogTable->fetchData(),
        );
    }
}
