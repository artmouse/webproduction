<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Скрипт написан для того что-бы всем товарам, у которых нету валюты, проставить ее автоматически (валюта по умолчанию)
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

// Получаем все товары
$products = Shop::Get()->getShopService()->getProductsAll();
$products->setCurrencyid(0);

// Получаем ID'шник валюты по умолчанию
$defaultCurrencyId = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();

while ($product = $products->getNext()) {
    print 'product #'.$product->getId()."\n";

    $product->setCurrencyid($defaultCurrencyId);
    $product->update();
}

print "\n\ndone.\n\n";