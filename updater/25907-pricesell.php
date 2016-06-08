<?php
require_once(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
$currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

$product = new ShopProduct();
$product->addWhere('price', '0', '>');
$product->setOrder('id', 'DESC');
while ($x = $product->getNext()) {
    print "update price sell for product #".$x->getId()."\n";
    $x->setPricesell(
        $x->makePrice($currencyDefault, true)
    );
    $x->update();
}

print "\n\ndone\n\n";