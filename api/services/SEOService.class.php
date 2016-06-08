<?php

/**
 * SEOService отвечает за SEO-возможности проекта.
 * Например, генерация sitemap, переопределение title, meta keywords,
 * и тд.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Package
 */
class SEOService {

    /**
     * Получить все объекты SEO, которые переопределяют
     * заголовки, h1, meta, ...
     *
     * @return XShopSEO
     */
    public function getSEOAll() {
        $x = new XShopSEO();
        $x->setOrder('url', 'ASC');
        return $x;
    }

    /**
     * Получить SEO для заданного URL.
     * URL передавать как есть, включая начальный слэш
     *
     * @param string $url
     *
     * @return XShopSEO
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
            $protocol = (
                !empty($_SERVER['HTTPS'])
                && $_SERVER['HTTPS'] !== 'off'
                || $_SERVER['SERVER_PORT'] == 443
            ) ? "https://" : "http://";

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
    public function generateSitemap($path = false) {
        PackageLoader::Get()->import('Sitemap');

        // количество товаров на странице категорий/брендов
        $onpage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
        if (!$onpage) {
            $onpage = 50;
        }

        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        $lastWeek = DateTime_Object::Now()->addDay(-7)->__toString();
        $lastMonth = DateTime_Object::Now()->addMonth(-1)->__toString();
        $lastYear = DateTime_Object::Now()->addYear(-1)->__toString();

        // Соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        // создаем генератор sitemaps'a
        $sitemap = new Sitemap(Engine::Get()->getProjectHost());

        // Главная страница сайта
        $sitemap->addURL(Engine::Get()->getProjectURL(), 1, 'always');

        // все товары
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setHidden(0);
        $products->setDeleted(0);
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

            $freq = 'daily';
            if ($x->getUdate() < $lastWeek) {
                $freq = 'weekly';
            }
            if ($x->getUdate() < $lastMonth) {
                $freq = 'monthly';
            }
            if ($x->getUdate() < $lastYear) {
                $freq = 'yearly';
            }

            $sitemap->addURL($x->makeURL(), $priority, $freq, $x->getUdate());
        }

        // все категории
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        while ($x = $category->getNext()) {
            if ($x->isHidden()) {
                continue;
            }

            /*// все страницы категорий
            $count = $x->getProducts()->getCount();
            for ($j = 0; $j <= $count / $onpage; $j++) {
                $sitemap->addURL($x->makeURL(true, $j), 1, 'daily');
            }*/

            // все доступные фильтры в этой категории
            $filtersArray = array();

            $products = $x->getProducts();

            /*for ($j = 1; $j <= $filter_count; $j++) {
                $sqlAll = $products->__toString();
                $sql = str_replace(
                    "`shopproduct`.*",
                    'DISTINCT(filter' . $j . 'id) AS filterid,
                    filter' . $j . 'value AS filtervalue,
                    filter' . $j . 'use AS filteruse',
                    $sqlAll
                );
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

                    $filterValuesArray = array_unique($filterValuesArray);

                    // определение фильтров
                    foreach ($filterValuesArray as $index => $filterValue) {
                        // строим ссылку
                        $url = $x->makeURL(true)."filter{$filterID}=".urlencode($filterValue).'/';

                        $sitemap->addURL($url, 0.9, 'daily');
                    }
                } catch (Exception $e) {

                }
            }*/

            $sqlAll = $products->__toString();
            $sqlAll = str_replace("`shopproduct`.*", 'DISTINCT(brandid) AS brandid', $sqlAll);
            $q = $connection->query($sqlAll);
            while ($p = $connection->fetch($q)) {
                try {
                    $brandID = $p['brandid'];
                    $brand = Shop::Get()->getShopService()->getBrandByID($brandID);

                    if ($brand->getHidden()) {
                        continue;
                    }

                    // строим ссылку
                    $url = $x->makeURL(true)."brand=".$brandID.'-'.$brand->getUrl().'/';

                    $sitemap->addURL($url, 0.9, 'daily');
                } catch (Exception $e) {

                }
            }
        }

        // все бренды
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $brands->setHidden(0);
        while ($x = $brands->getNext()) {
            $products = $x->getProducts();
            $count = $products->getCount();
            for ($j = 0; $j <= $count / $onpage; $j++) {
                $sitemap->addURL($x->makeURL(true, $j), 0.7, 'daily');
            }

            // получаем список всех категорий
            $sqlAll = $products->__toString();
            $sqlAll = str_replace("`shopproduct`.*", 'DISTINCT(categoryid) AS categoryid', $sqlAll);
            $q = $connection->query($sqlAll);
            $a = array();
            while ($p = $connection->fetch($q)) {
                try {
                    $categoryID = $p['categoryid'];
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);

                    if ($category->getHidden()) {
                        continue;
                    }

                    // строим ссылку
                    $url = $x->makeURL(true)."category=".$categoryID.'/';

                    $sitemap->addURL($url, 0.5, 'daily');
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

        // все теги товаров
        $tags = new ShopProductTag();
        while ($x = $tags->getNext()) {
            // публикуем URL в sitemap
            $url = $x->makeURL();
            $sitemap->addURL($url, 1, 'daily');
        }

        if (!$path) {
            $path = PackageLoader::Get()->getProjectPath().'media/sitemap/'.Engine::Get()->getProjectHost().'/';
            if (!file_exists($path)) {
                mkdir($path, 0755, true);
            }
        }
        $sitemap->render($path);
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
                $name = $x->getName();
                //если есть артикул у продукта - добавить его при формировании URL
                if ($x->getArticul()) {
                    $name .=' '.$x->getArticul();
                }
                $url = Shop::Get()->getShopService()->buildURL(trim($name));
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

        // строим ЧПУ для всех текстовых страницы
        $pages = Shop::Get()->getTextPageService()->getTextPageAll();
        $pages->setUrl('');
        while ($x = $pages->getNext()) {
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

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return SEOService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var SEOService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}