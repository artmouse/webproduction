<?php

$connection = ConnectionManager::Get()->getConnectionDatabase();

for ($j = 1; $j <= 5; $j++) {
    try {
        $connection->query("ALTER TABLE shopproduct DROP INDEX `index_supplier{$j}id`");
    } catch (Exception $e) {
        print $e;
    }

    try {
        $connection->query("ALTER TABLE shopproduct DROP INDEX `index_supplier{$j}code`");
    } catch (Exception $e) {
        print $e;
    }
}