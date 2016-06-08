<?php
require_once(dirname(__FILE__).'/../packages/Engine/include.2.6.php');
// количество фильтров
try {
    $filter_count = Engine::Get()->getConfigField('filter_count');
} catch (Exception $e) {
    $filter_count = 10;
}

$products = Shop::Get()->getShopService()->getProductsAll();
$products->setOrder('id', 'DESC');
while ($x = $products->getNext()) {
    print $x->getId()."\n";

    try {
        Shop::Get()->getShopService()->updateProductFVC($x);
    } catch (Exception $e) {
        print $e;
    }
}