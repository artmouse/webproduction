<?php
try {
    $connection = ConnectionManager::Get()->getConnectionDatabase();

    $connection->query("ALTER TABLE shopprocessorque DROP INDEX `index_logicclass`");

    ModeService::Get()->verbose('Drop old index from processorque...');
} catch (Exception $ex) {
    ModeService::Get()->debug($ex);
}