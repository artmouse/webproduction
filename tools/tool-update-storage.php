<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

try {
    SQLObject::TransactionStart();

    $storage = new ShopStorage();
    $storage->setGroupByQuery('`userid`, `cdate`');

    while ($x = $storage->getNext()) {
    	$orderID = 0;
    	try {
    	    $orderID = Shop::Get()->getShopService()->getOrderProductById($x->getOrderproductid())->getOrderid();
    	    $order = Shop::Get()->getShopService()->getOrderByID($orderID);
    	} catch (ServiceUtils_Exception $e) {

    	}

        $transaction = Shop::Get()->getStorageService()->addStorageTransaction(
    	$x->getUser(),
    	$x->getType(),
    	$x->getStorageNameFrom(),
    	$x->getStorageNameTo(),
    	$x->getReturn(),
    	$orderID
    	);

    	$transaction->setCdate($x->getCdate());
    	$transaction->update();

    	$storages = new ShopStorage();
    	$storages->setUserid($x->getUserid());
    	$storages->setCdate($x->getCdate());
    	while ($y = $storages->getNext()) {
    		$y->setTransactionid($transaction->getId());
    		$y->update();
    	}
    }

    SQLObject::TransactionCommit();
} catch (Exception $ge) {
    SQLObject::TransactionRollback();
    throw $ge;
}

print 'done.';