<?php
$obj = new XShopCommentTemplate();
if ($obj->getNext()) {
    print 'table not empty';
} else {
    try {
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = "INSERT INTO `shopcommenttemplate` SELECT * FROM `shocommenttemplate`";
        $q = $connection->query($query);
    } catch (Exception $e) {

    }
}