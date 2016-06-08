<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Проверить, есть ли заказы, 
 * которые прошли состояниие "отправлен", 
 * но ничего со склада не списалось
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$statusArray = array();

$statuses = Shop::Get()->getShopService()->getStatusAll();
$statuses->filterStorage_sale(1);
while ($status = $statuses->getNext()) {
    $statusArray[$status->getId()] = $status->getId();
}

/*for ($i = 0; $i < 5; $i++) {
$statuses = Shop::Get()->getShopService()->getStatusAll();
$x = new XShopOrderStatusChange();
$statuses->leftJoinTable($x->getTablename(), $statuses->getTablename().'.`id` = '.$x->getTablename().'.`elementtoid`');
$statuses->addWhereArray($statusArray, $x->getTablename().'.`elementfromid`');
while ($status = $statuses->getNext()) {
$statusArray[$status->getId()] = $status->getId();
}
}*/

$orders = Shop::Get()->getShopService()->getOrdersAll();
$x = new XShopOrderChange();
$orders->leftJoinTable($x->getTablename(), $orders->getTablename().'.`id` = '.$x->getTablename().'.`orderid`');
$orders->addWhere($x->getTablename().'.`key`', 'statusid');
$orders->addWhereArray($statusArray, $x->getTablename().'.`value`');
$orders->setGroupByQuery($orders->getTablename().'.`id`');

$orders = Shop::Get()->getShopService()->getOrdersAll();
$orders->addWhereArray($statusArray, 'statusid');

while ($order = $orders->getNext()) {
    $storageTransaction = StorageService::Get()->getStorageTransactionsAll();
    $storageTransaction->filterOrderid($order->getId());
    if (!$storageTransaction->getNext()) {
        print $order->getId()."\n";
    }
}