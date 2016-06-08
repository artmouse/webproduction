<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Построитель cache1
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */

// @deprecated
// временно отказались от этого решения
exit();

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$cacheDir = PackageLoader::Get()->getProjectPath().'/cache1/';
$host = Engine::Get()->getProjectHost();

if (!$host) {
    print 'No project host'."\n";
    exit();
}

// количество товаров на странице категорий/брендов
$onpage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
if (!$onpage) {
    $onpage = 50;
}

function _buildCache($url, $host, $cacheDir) {
    $url = trim($url, '/');
    print $url."\n";

    $tmp = parse_url($url);
    $tmp = @$tmp['path'];

    if (!$tmp) {
        $tmp = 'index';
    }

    @unlink($cacheDir.$tmp.'.html');

    $data = file_get_contents($url);
    if (!$data) {
        return;
    }

    file_put_contents($cacheDir.$tmp.'.html', $data, LOCK_EX);
}

// index
_buildCache('http://'.$host.'/', $host, $cacheDir);

// все товары
$products = Shop::Get()->getShopService()->getProductsAll();
$products->setHidden(0);
$products->addWhere('url', '', '!=');
while ($x = $products->getNext()) {
    try {
        $url = $x->makeURL();
        _buildCache($url, $host, $cacheDir);
    } catch (Exception $e) {

    }
}

// все категории
$category = Shop::Get()->getShopService()->getCategoryAll();
$category->setHidden(0);
$category->addWhere('url', '', '!=');
while ($x = $category->getNext()) {
    $count = $x->getProducts()->getCount();
    for ($j = 0; $j <= $count / $onpage; $j++) {
        try {
            $url = $x->makeURL(true, $j);
            _buildCache($url, $host, $cacheDir);
        } catch (Exception $e) {

        }

    }
}

// все бренды
$brands = Shop::Get()->getShopService()->getBrandsAll();
$brands->setHidden(0);
$brands->addWhere('url', '', '!=');
while ($x = $brands->getNext()) {
    $count = $x->getProducts()->getCount();
    for ($j = 0; $j <= $count / $onpage; $j++) {
        try {
            $url = $x->makeURL(true, $j);
            _buildCache($url, $host, $cacheDir);
        } catch (Exception $e) {

        }
    }
}

// все текстовые страницы
$pages = Shop::Get()->getTextPageService()->getTextPageAll();
$pages->setHidden(0);
$pages->addWhere('url', '', '!=');
while ($x = $pages->getNext()) {
    try {
        $url = $x->makeURL(true);
        _buildCache($url, $host, $cacheDir);
    } catch (Exception $e) {

    }
}

// все новости
$news = Shop::Get()->getNewsService()->getNewsAll();
$news->setHidden(0);
$news->addWhere('url', '', '!=');
while ($x = $news->getNext()) {
    try {
        $url = $x->makeURL();
        _buildCache($url, $host, $cacheDir);
    } catch (Exception $e) {

    }
}

// все галерея
$gallery = GalleryService::Get()->getGalleryActive();
$gallery->setHidden(0);
$gallery->addWhere('url', '', '!=');
while ($x = $gallery->getNext()) {
    try {
        $url = $x->makeURL();
        _buildCache($url, $host, $cacheDir);
    } catch (Exception $e) {

    }
}


print "\n\ndone.\n\n";