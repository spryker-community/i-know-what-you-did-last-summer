<?php

namespace Pyz\Zed\AuditLog\Persistence\Propel\Behavior;

use Propel\Generator\Model\Behavior;

class AuditBehavior extends Behavior
{
    /**
     * @return string
     */
    public function objectMethods(): string
    {
        $script = '';
        $script .= $this->addShouldAuditAllModificationsMethod();
        $script .= $this->addGetAuditableModifiedColumnsMethod();
        $script .= $this->addPreSaveMethod();
        $script .= $this->addAddAuditLogMethod();

        return $script;
    }

    /**
     * @param array<string, mixed> $parameter
     *
     * @return void
     */
    public function addParameter(array $parameter): void
    {
        $this->parameters[$parameter['name']]['column'] = $this->table->getOriginCommonName() . '.' . $parameter['column'];
    }

//    private function addGetPreSaveMethod(): string
//    {
//        return "
//        ";
//    }

    /**
     * @return string
     */
    private function addShouldAuditAllModificationsMethod(): string
    {
        $columns = array_map(
            static fn ($parameter) => $parameter['column'],
            $this->getParameters(),
        );

        $auditAllModificationsMethod = in_array('*', $columns, true) ? 'true' : 'false';

        return "
public function shouldAuditAllModifications(): bool
{
    return $auditAllModificationsMethod;
}
        ";
    }

    /**
     * @return string
     */
    private function addGetAuditableModifiedColumnsMethod(): string
    {
        $columns = array_map(
            static fn ($parameter) => $parameter['column'],
            $this->getParameters(),
        );

        return "
public function getAuditableModifiedColumns(): array
{
    return array_intersect(\$this->getModifiedColumns(), ['" . implode("', '", $columns) . "']);
}
        ";
    }

    /**
     * @return string
     */
    private function addPreSaveMethod(): string
    {
        return "

public function preSave(?ConnectionInterface \$con = null): bool
{
    if (\$this->shouldAuditAllModifications()) {
        \$this->addAuditLog(\$this->isNew() ? 'create' : 'update', json_encode(\$this->toArray(), JSON_THROW_ON_ERROR));
        return true;
    }

    \$auditableModifiedColumns = \$this->getAuditableModifiedColumns();

    if (empty(\$auditableModifiedColumns)) {
        return true;
    }

//    array_combine(\$auditableModifiedColumns, \$auditableModifiedColumns);
//    \$this->toArray()

    \$this->addAuditLog('modified: ' . implode(', ', \$auditableModifiedColumns), json_encode(\$this->toArray(), JSON_THROW_ON_ERROR));

    return true;
}
";
    }

    /**
     * @return string
     */
    private function addAddAuditLogMethod(): string
    {
        return "
/**
 * @return void
 */
protected function addAuditLog(string \$action, string \$details = ''): void
{
    \$auditLogTransfer = (new \\Generated\\Shared\\Transfer\\AuditLogTransfer())
        ->setAction(\$action)
        ->setUserId(1)
        ->setEntityType(self::class)
        ->setEntityId(\$this->getPrimaryKey())
        ->setTimestamp(time())
        ->setDetails(\$details)
        ;

    \\Pyz\\Zed\\AuditLog\\AuditLogSingleton::getInstance()->collectAuditLogData(\$auditLogTransfer);
}
        ";
    }
}
