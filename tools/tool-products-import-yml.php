<?php

/**
 * Импорт товаров из YML-файла
 */
require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$file = @$argv[1];
$xml = @file_get_contents($file);
if (!$xml) {
    throw new ServiceUtils_Exception();
} else {
    $xml = simplexml_load_string($xml);
    set_time_limit(10 * 60); // устанавливаем время работы скрипта
    $transactionlength = 300;
    $icategory = 0;
    $iproduct = 0;

    $currencyArray = array();
    foreach ($xml as $item) {
        $categories = $item->categories->category;
        $products = $item->offers->offer;
        $currencies = $item->currencies->currency;

        foreach ($currencies as $currency) {
            $name = @trim($currency['id']);
            $rate = @trim($currency['rate']);
            try {
                $c = Shop::Get()->getCurrencyService()->getCurrencyByName($name);
            } catch (Exception $e) {
                $c = Shop::Get()->getCurrencyService()->getCurrencyAll();
                $c->setName($name);
                $c->setRate($rate);

                $c->insert();
            }
            $currencyArray[$name] = array(
                'id' => $c->getId()
            );
        }

        // разбор xml категорий
        foreach ($categories as $c) {
            $id = @trim($c['id']);
            $parentId = @trim($c['parentId']);
            $name = @trim($c);
            if (!$id || !$name) {
                continue;
            }
            try {
                SQLObject::TransactionStart();

                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($id);
                    $category->setParentid($parentId);
                    $category->setName($name);

                    $category->update();
                } catch (Exception $e) {
                    $category = new ShopCategory();
                    $category->setId($id);
                    $category->setParentid($parentId);
                    $category->setName($name);

                    $category->insert();
                }

                SQLObject::TransactionCommit();

                if ($icategory % $transactionlength == 0) {
                    sleep(1);
                }
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
            }
        }

        // разбор xml с продуктами
        foreach ($products as $p) {
            $id = @trim($p['id']);
            $avail = (bool) @trim($p['available']);
            $price = $p->price . '';
            $price = str_replace(' ', '', $price);
            $price = str_replace(',', '.', $price);
            $categoryId = @trim($p->categoryId);
            $currencyId = @trim($p->currencyId);
            $currency = $currencyArray[$currencyId];
            $image = @trim($p->picture);
            $name = @trim($p->name);
            $description = @trim($p->description);
            if ($image) {
                $img = file_get_contents($image);
                $image = array_reverse(explode('/', $image));
                $image = $image[0];
                $path = MEDIA_PATH . '/shop/' . $image;
                if (!file_exists($path)) {
                    file_put_contents($path, $img);
                }
                unset($img);
            }
            if (!$id || !$name) {
                continue;
            }
            try {
                SQLObject::TransactionStart();

                try {
                    $product = Shop::Get()->getShopService()->getProductByID($id);
                    $product->setAvail($avail);
                    $product->setPrice($price);
                    $product->setDescription($description);
                    $product->setCategoryid($categoryId);
                    $product->setImage($image);
                    $product->setCurrencyid($currency['id']);

                    $product->update();
                } catch (Exception $e) {
                    $product = new ShopProduct();
                    $product->setId($id);
                    $product->setAvail($avail);
                    $product->setName($name);
                    $product->setPrice($price);
                    $product->setCurrencyid($currency['id']);
                    $product->setDescription($description);
                    $product->setCategoryid($categoryId);
                    $product->setImage($image);

                    $product->insert();
                }

                Shop::Get()->getShopService()->buildProductCategories($product);

                SQLObject::TransactionCommit();

                if ($iproduct % $transactionlength == 0) {
                    sleep(1);
                }
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
            }
        }
    }
}

print "\n\ndone.\n\n";