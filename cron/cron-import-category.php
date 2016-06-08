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

$xml = file_get_contents(PackageLoader::Get()->getProjectPath().'/media/import/category.xml');
$xml = simplexml_load_string($xml);
foreach ($xml as $item) {
    // print_r($item);

    $code = trim($item->code.'');
    $name = trim($item->name.'');
    $parentCode = @trim($item->parrentcode.'');

    if (!$code || !$name) {
        continue;
    }

    try {
        SQLObject::TransactionStart();

        try {
            $category = Shop::Get()->getShopService()->getCategoryByID($code);
        } catch (Exception $e) {
            $category = new ShopCategory();
            $category->setId($code);
            $category->setParentid($parentCode);
            $category->setName($name);
            $category->setHidden(1); // по умолчанию скрыто
            $category->insert();
        }

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        // throw $ge;
    }
}

print "\n\ndone.\n\n";