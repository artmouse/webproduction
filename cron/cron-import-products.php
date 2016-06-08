<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

// @deprecated
exit();

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

// ставим всем товарам sync=1
$connection = ConnectionManager::Get()->getConnectionMySQL();
$products = Shop::Get()->getShopService()->getProductsAll();
$connection->query("UPDATE `{$products->getTablename()}` SET `sync`=1 WHERE unsyncable=0");

$xml = file_get_contents(PackageLoader::Get()->getProjectPath().'/media/import/products.xml');
$xml = simplexml_load_string($xml);
foreach ($xml as $item) {
    $id = trim($item->code.'');
    $parentCode = trim($item->parrentcode.'');
    $name = trim($item->name.'');
    $price = $item->price.'';
    $avail = (bool) $item->avail.'';
    $price = str_replace(',', '.', $price);

    try {
        SQLObject::TransactionStart();

        try {
            $product = Shop::Get()->getShopService()->getProductByID($id);
        } catch (Exception $e) {
            $product = Shop::Get()->getShopService()->addProduct($name, $id);
            $product->setCategoryid($parentCode);
        }

        $product->setPrice($price);
        $product->setSync(0); // снимаем галочку sync
        $product->setHidden(0); // показываем товар
        $product->setAvail($avail); // наличие товара
        $product->update();

        // строим цепочку
        Shop::Get()->getShopService()->buildProductCategories($product);

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
    }
}

// скрываем все товары с sync=1
$products = Shop::Get()->getShopService()->getProductsAll();
$connection->query("UPDATE `{$products->getTablename()}` SET `sync`=0, `hidden`=1 WHERE `sync`=1");

print "\n\ndone.\n\n";