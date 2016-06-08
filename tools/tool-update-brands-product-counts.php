<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$brands = Shop::Get()->getShopService()->getBrandsAll();

$transactions = 250;
$index = 0;

SQLObject::TransactionStart();

while ($brand = $brands->getNext()) {
    print 'brand#'.$brand->getId()."\n";

    try {
        Shop::Get()->getShopService()->updateBrandProductCount($brand->getId());
    } catch (Exception $e) {
        if (PackageLoader::Get()->getMode('debug')) {
        	print $e;
        }
    }

    $index ++;
    if ($index % $transactions == 0) {
        SQLObject::TransactionCommit();
        SQLObject::TransactionStart();
    }
}

SQLObject::TransactionCommit();

print "\n\ndone.\n\n";