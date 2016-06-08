<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

$balances = new ShopStorageBalance();
while ($balance = $balances->getNext()) {
    $storages = new ShopStorage();
    $storages->setCode($balance->getCode());
    $storage = $storages->getNext();
    if ($storage) {
        $balance->setPrice($storage->getPrice());
        $balance->setCurrencyid($storage->getCurrencyid());
        $balance->setCurrencyrate($storage->getCurrencyrate());
        $balance->setTaxrate($storage->getTaxrate());
        $balance->update();
    }
}

print "\n\ndone.\n\n";