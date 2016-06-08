<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * На основе товаров, которые есть на складе, проставить RRC.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$storageNames = StorageNameService::Get()->getStorageNamesForTransfers();
$storageNameIDArray = array(-1);
while ($storageName = $storageNames->getNext()) {
    $storageNameIDArray[] = $storageName->getId();
}

$balances = new ShopStorageBalance();
$balances->addWhereArray($storageNameIDArray, 'storagenameid');
$balances->addWhere('amount', 0, '>');
$balances->setGroupByQuery('`storagenameid`, `productid`');

while ($balance = $balances->getNext()) {
    try {
        $product = $balance->getProduct();

        if ($product->getRrc()) {
            try {
                $r = StorageBalanceService::Get()->getStorageReserve(
                $balance->getStoragenameid(),
                $product->getId()
                );

                StorageBalanceService::Get()->updateStorageReserve(
                $balance->getStoragenameid(),
                $product->getId(),
                $r->getAmount(),
                $product->getPrice(),
                $product->getCurrencyid()
                );
            } catch (ServiceUtils_Exception $rrce) {
                StorageBalanceService::Get()->updateStorageReserve(
                $balance->getStoragenameid(),
                $product->getId(),
                false,
                $product->getPrice(),
                $product->getCurrencyid()
                );
            }
        }
    } catch (ServiceUtils_Exception $se) {

    }
}

print "\n\ndone.\n\n";