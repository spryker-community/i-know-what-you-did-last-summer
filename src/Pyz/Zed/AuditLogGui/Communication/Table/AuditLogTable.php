<?php

/**
 * This file is part of the Spryker Commerce OS.
 * For full license information, please view the LICENSE file that was distributed with this source code.
 */

namespace Pyz\Zed\AuditLogGui\Communication\Table;

use Orm\Zed\AuditLog\Persistence\AuditLogs;
use Orm\Zed\AuditLog\Persistence\AuditLogsQuery;
use Spryker\Service\UtilText\Model\Url\Url;
use Spryker\Zed\Gui\Communication\Table\AbstractTable;
use Spryker\Zed\Gui\Communication\Table\TableConfiguration;

class AuditLogTable extends AbstractTable
{
    /**
     * @var string
     */
    protected const COL_ID = 'id';

    /**
     * @var string
     */
    protected const COL_ACTION = 'action';

    /**
     * @var string
     */
    protected const COL_ENTITY_TYPE = 'entity_type';

    /**
     * @var string
     */
    protected const COL_ENTITY_ID = 'entity_id';

    /**
     * @var string
     */
    protected const COL_USER_ID = 'user_id';

    /**
     * @var string
     */
    protected const COL_TIMESTAMP = 'timestamp';

    /**
     * @var string
     */
    protected const COL_ACTIONS = 'actions';

    /**
     * @var string
     */
    protected const VALUE_COL_ACTIONS = 'Actions';

    /**
     * @var string
     */
    protected const IDENTIFIER = 'audit_log_data_table';

    /**
     * @var string
     */
    protected const BUTTON_LABEL_VIEW = 'View Audit Log';

    /**
     * @uses \Pyz\Zed\AuditLogGui\Communication\Controller\ViewController::indexAction()
     *
     * @var string
     */
    protected const URL_AUDIT_LOG_VIEW = '/audit-log-gui/view';

    /**
     * @use \Pyz\Zed\AuditLogGui\Communication\Controller\ViewController::REQUEST_ID_AUDIT_LOG
     *
     * @var string
     */
    protected const REQUEST_ID_AUDIT_LOG = 'id-audit-log';

    /**
     * @var \Orm\Zed\AuditLog\Persistence\AuditLogsQuery
     */
    protected AuditLogsQuery $auditLogsQuery;

    /**
     * @param \Orm\Zed\AuditLog\Persistence\AuditLogsQuery $auditLogsQuery
     */
    public function __construct(AuditLogsQuery $auditLogsQuery)
    {
        $this->auditLogsQuery = $auditLogsQuery;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return \Spryker\Zed\Gui\Communication\Table\TableConfiguration
     */
    protected function configure(TableConfiguration $config): TableConfiguration
    {
        $config->setDefaultSortField(static::COL_ACTION);
        $config->setRawColumns([
            static::COL_ACTIONS,
        ]);

        $config->setHeader([
            static::COL_ID => 'ID',
            static::COL_ACTION => 'Action',
            static::COL_ENTITY_TYPE => 'Entity Type',
            static::COL_ENTITY_ID => 'Entity ID',
            static::COL_USER_ID => 'User ID',
            static::COL_TIMESTAMP => 'Timestamp',
        ]);

        $config->setSortable([
            static::COL_ID,
            static::COL_ACTION,
            static::COL_ENTITY_TYPE,
            static::COL_ENTITY_ID,
            static::COL_USER_ID,
            static::COL_TIMESTAMP,
        ]);

        $config->setSearchable([
            static::COL_ID,
            static::COL_ACTION,
            static::COL_ENTITY_TYPE,
            static::COL_ENTITY_ID,
            static::COL_USER_ID,
            static::COL_TIMESTAMP,
        ]);

        $this->setTableIdentifier(static::IDENTIFIER);

        $this->addActionsHeader($config);

        return $config;
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return array
     */
    protected function prepareData(TableConfiguration $config): array
    {
        $queryResults = $this->runQuery($this->auditLogsQuery, $config, true);

        $auditLogCollection = [];
        foreach ($queryResults as $auditLogEntity) {
            $auditLogCollection[] = $this->generateItem($auditLogEntity);
        }

        return $auditLogCollection;
    }

    /**
     * @param \Orm\Zed\AuditLog\Persistence\AuditLogs $auditLogEntity
     *
     * @return array<string, mixed>
     */
    protected function generateItem(AuditLogs $auditLogEntity): array
    {
        return [
            static::COL_ID => $auditLogEntity->getId(),
            static::COL_ACTION => $auditLogEntity->getAction(),
            static::COL_ENTITY_TYPE => $auditLogEntity->getEntityType(),
            static::COL_ENTITY_ID => $auditLogEntity->getEntityId(),
            static::COL_USER_ID => $auditLogEntity->getUserId(),
            static::COL_TIMESTAMP => $auditLogEntity->getTimestamp('Y-m-d H:i:s'),
            static::COL_ACTIONS => $this->buildLinks($auditLogEntity),
        ];
    }

    /**
     * @param \Orm\Zed\AuditLog\Persistence\AuditLogs $auditLogEntity
     *
     * @return string
     */
    protected function buildLinks(AuditLogs $auditLogEntity): string
    {
        $buttons = [];
        $buttons[] = $this->createViewButton($auditLogEntity);

        return implode(' ', $buttons);
    }

    /**
     * @param \Orm\Zed\AuditLog\Persistence\AuditLogs $auditLogEntity
     *
     * @return string
     */
    protected function createViewButton(AuditLogs $auditLogEntity): string
    {
        return $this->generateButton(
            Url::generate(static::URL_AUDIT_LOG_VIEW, [
                static::REQUEST_ID_AUDIT_LOG => $auditLogEntity->getId(),
            ]),
            static::BUTTON_LABEL_VIEW,
            [
                'class' => 'btn-view',
                'icon' => 'fa-search',
            ],
        );
    }

    /**
     * @param \Spryker\Zed\Gui\Communication\Table\TableConfiguration $config
     *
     * @return void
     */
    protected function addActionsHeader(TableConfiguration $config): void
    {
        $config->setHeader($config->getHeader() + [static::COL_ACTIONS => static::VALUE_COL_ACTIONS]);
    }
}
