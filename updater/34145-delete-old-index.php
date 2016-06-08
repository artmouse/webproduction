<?php
$connection = ConnectionManager::Get()->getConnectionDatabase();
try {
    $query = "ALTER TABLE users DROP INDEX `LoginAndEmail`";
    $q = $connection->query($query);
} catch (Exception $ex) {

}