<?php

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Package
 */
class SEOService {

    /**
     * @return XShopSEO
     */
    public function getSEOAll() {
        $x = new XShopSEO();
        $x->setOrder('url', 'ASC');
        return $x;
    }

    /**
     * @return XShopSEO
     * @param string $url
     */
    public function getSEOByURL($url) {
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        $x = new XShopSEO();
        $x->setUrl($url);
        if ($x->select()) {
            return $x;
        } else {
            //порверка какой протокол
            $protocol = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";

            $url = $protocol.Engine::Get()->getConfigField('project-host').Engine::GetURLParser()->getTotalURL();
            $x = new XShopSEO();
            $x->setUrl($url);
            if ($x->select()) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Построить sitemap для всего проекта
     */
    public function genetateSitemap() {
        PackageLoader::Get()->import('Sitemap');

        // количество товаров на странице категорий/брендов
        $onpage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
        if (!$onpage) {
            $onpage = 9;
        }

        $showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        // Соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        // создаем генератор sitemaps'a
        $sitemap = new SitemapRtm($this->_getProjectUrl());

        // все товары
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setDeleted(0);
        $products = Shop::Get()->getShopService()->setProductsDateLifeFilter($products);
        while ($x = $products->getNext()) {
            try {
                if ($x->getCategory()->isHidden()) {
                    continue;
                }
            } catch (Exception $categoryEx) {

            }

            $priority = 1;
            if (!$x->getAvail()) {
                $priority = 0.5;
            }
            $sitemap->addURL($x->makeURL(), $priority, 'daily', false, $x->makeBigImagesArray(true));
        }

        // все категории
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        while ($x = $category->getNext()) {
            if ($x->isHidden()) {
                continue;
            }
            $products = $x->getProducts(false);
            $products->setHidden(0);
            $products->setDeleted(0);
            $products = Shop::Get()->getShopService()->setProductsDateLifeFilter($products);
            if (!$showNoImageProducts) {
                $products->addWhere('image', '', '<>');
            }
            $products->addWhere('showincategory', '1', '=');

            $count = $products->getCount();

            if (!$count) {
                continue;
            }

            // все страницы категорий
            $resultOnPage = $count / $onpage;

            for ($j = 0; $j <= $resultOnPage; $j++) {
                $sitemap->addURL($x->makeURL(true, $j), 1, 'daily');
            }

            // все доступные фильтры в этой категории
            $filtersArray = array();

            $sqlAll = $products->__toString();

            for ($j = 1; $j <= $filter_count; $j++) {
                $sql = str_replace("`shopproduct`.*", 'DISTINCT(filter' . $j . 'id) AS filterid, filter' . $j . 'value AS filtervalue, filter' . $j . 'use AS filteruse', $sqlAll);
                $q = $connection->query($sql);
                while ($p = $connection->fetch($q)) {
                    if ($p['filteruse']) {
                        if (!isset($filtersArray[$p['filterid']])) {
                            $filtersArray[$p['filterid']] = array();
                        }
                        if ($p['filtervalue'] !== '') {
                            $filtersArray[$p['filterid']][] = $p['filtervalue'];
                        }
                    }
                }
            }

            foreach ($filtersArray as $filterID => $filterValuesArray) {
                try {
                    $filter = Shop::Get()->getShopService()->getProductFilterByID(
                    $filterID
                    );

                    if ($filter->getHidden()) {
                        continue;
                    }

                    $filterUrl = SEOService::Get()->getFilterUrl($filter->getName());
                    if (!$filterUrl) {
                        continue;
                    }

                    $filterValuesArray = array_unique($filterValuesArray);
                    // определение цветный фильтров
                    foreach ($filterValuesArray as $index => $filterValue) {

                        $val = RtmService::Get()->buildFilterURL($filterValue, $filterID);
                        // строим ссылку
                        $url = $x->makeURL(true)."/filter_{$filterUrl}={$val}";

                        $sitemap->addURL($url, 0.9, 'daily');
                    }
                } catch (Exception $e) {

                }
            }
        }

        // все текстовые страницы
        $pages = Shop::Get()->getTextPageService()->getTextPageAll();
        $pages->setHidden(0);
        while ($x = $pages->getNext()) {
            $sitemap->addURL($x->makeURL(), 0.3, 'monthly');
        }

        // все новости
        $news = Shop::Get()->getNewsService()->getNewsAll();
        $news->setHidden(0);
        while ($x = $news->getNext()) {
            $sitemap->addURL($x->makeURL(), 0.5, 'monthly', $x->getCdate());
        }

        // все галерея
        $gallery = GalleryService::Get()->getGalleryActive();
        $gallery->setHidden(0);
        while ($x = $gallery->getNext()) {
            $sitemap->addURL($x->makeURL());
        }

        // все результаты поиска
//        $search = new XShopSearchLog();
//        $q = $connection->query("SELECT DISTINCT TRIM(query) AS qx FROM ".$search->getTablename()." WHERE countresult > 0 AND query <> ''");
//        while ($x = $connection->fetch($q)) {
//            $query = $x['qx'];
//            if (!$query) {
//                continue;
//            }
//
//            // убираем все кроме букв, цифр и пробелов
//            $query = preg_replace("/[^a-zA-ZА-Яа-я0-9\-\s]/ius"    , '', $query);
//
//            // публикуем URL в sitemap
//            $url = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-search', urlencode($query), 'queryfixed');
//            $sitemap->addURL($url, 0.5, 'monthly');
//        }

        $sitemap->render(PackageLoader::Get()->getProjectPath());
    }


    /**
     * @param $filterName
     * @return bool|string
     */
    public function getFilterUrl($filterName) {
        $filterName = htmlspecialchars($filterName);
        switch ($filterName) {
            case 'Вид изделия' :
                return 'category';
            case 'Размер' :
                return 'sizes';
            case 'Тип изделия' :
                return 'types';
            case 'Цвет камня' :
                return 'colors';
        }
        return false;
    }

    /**
     * Построить URL всем товарам, категориям, страницам, у которых еще нет
     * URL.
     */
    public function buildFriendlyURLs() {
        // строим ЧПУ для всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setUrl('');
        while ($x = $category->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }

        // строим ЧПУ для всех брендов
        $brand = Shop::Get()->getShopService()->getBrandsAll();
        $brand->setUrl('');
        while ($x = $brand->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }

        // строим ЧПУ для всех товаров
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setUrl('');
        while ($x = $products->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }

        // строим ЧПУ для всех новостей
        $news = Shop::Get()->getNewsService()->getNewsAll();
        $news->setUrl('');
        while ($x = $news->getNext()) {
            try {
                $url = Shop::Get()->getShopService()->buildURL($x->getName());
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$x->getId();
                }

                $x->setUrl($url);
                $x->update();
            } catch (Exception $e) {

            }
        }
    }


    private function _getProjectUrl() {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }
        return $h.Engine::Get()->getProjectHost();
    }

    /**
     * @return SEOService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}