<?php
$connection = ConnectionManager::Get()->getConnectionDatabase();

for ($j = 1; $j <= 10; $j++) {
    try {
        $connection->query("ALTER TABLE shopproduct DROP INDEX filter{$j}id");
    } catch (Exception $e) {
        print $e;
    }

    try {
        $connection->query("ALTER TABLE shopproduct DROP INDEX filter{$j}value");
    } catch (Exception $e) {
        print $e;
    }

    try {
        $connection->query("ALTER TABLE shopproduct DROP INDEX `filter{$j}id-actual`");
    } catch (Exception $e) {
        print $e;
    }
}