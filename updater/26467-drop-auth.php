<?php
$connection = ConnectionManager::Get()->getConnectionDatabase();

try {
    $connection->query("ALTER TABLE `users` DROP `sudoid`");
} catch (Exception $e) {
    print $e;
}

try {
    $connection->query("ALTER TABLE `users` DROP `adate`, DROP `sdate`, DROP `ip`, DROP `sid`");
} catch (Exception $e) {
    print $e;
}