<?php

require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$connection = ConnectionManager::Get()->getConnectionDatabase();


for ($i = 1; $i < 50; $i++) {
    try {
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."id";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."value";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."actual";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."use";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."option";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN filter".$i."markup";
        $q = $connection->query($query);
        print "filter drop".$i."\n";
    } catch (Exception $ex) {

    }
}
for ($i = 1; $i < 50; $i++) {
    try {
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."id";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."code";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."price";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."article";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."discount";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."currencyid";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."avail";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."availtext";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."date";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."minretail";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."minretail_cur_id";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."recommretail";
        $q = $connection->query($query);
        $query = "ALTER TABLE shopproduct DROP COLUMN supplier".$i."recommretail_cur_id";
        $q = $connection->query($query);
        print "supplier drop".$i."\n";
    } catch (Exception $ex) {

    }
}

print "\n\nDone\n\n";