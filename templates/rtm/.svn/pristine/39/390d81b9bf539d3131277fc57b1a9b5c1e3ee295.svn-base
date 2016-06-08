<?php
/**
 *  @author Andrii A.
 *  @copyright WebProduction
 */

set_time_limit(0);
include dirname(__FILE__)."/../../../packages/Engine/include.2.6.php";

$generator = new ProductRedirectGenerator(true);
$generator->generate();

class ProductRedirectGenerator {

    /**
     * @param bool $debugMode - вывод информации о работе скрипта
     */
    public function __construct($debugMode) {
        $this->_debugMode = $debugMode;
    }

    /**
     *  Создание редиректов с урлов вида /product-url на урлы вида '/category-url/product-url'
     */
    public function generate() {
        $products = Shop::Get()->getShopService()->getProductsAll();

        while ($x = $products->getNext()) {
            if (!$x->getUrl()) {
                continue;
            }
            $toUrl = trim(str_replace($this->_getProjectHost(), '', $x->makeURL()), '/');
            $fromUrl = trim($x->getUrl(), '/');
            $this->_setRedirect("/{$fromUrl}", "/{$toUrl}");

            if ($this->_debugMode) {
                print "from /{$fromUrl} to /{$toUrl}\n";
            }

        }


        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        // Соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        // все категории
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        while ($x = $category->getNext()) {
            if ($x->isHidden()) {
                continue;
            }
            $products = $x->getProducts(false);

            $count = $products->getCount();

            if (!$count) {
                continue;
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
                        $urlFrom = $x->makeURL(true)."/filter{$filterID}=".urlencode($filterValue).'/';
                        $urlFrom = $this->_replaceHost($urlFrom);
                        $val = RtmService::Get()->buildFilterURL($filterValue, $filterID);
                        // строим ссылку
                        $urlTo = $x->makeURL(true)."/filter_{$filterUrl}={$val}";
                        $urlTo = $this->_replaceHost($urlTo);
                        $this->_setRedirect($urlFrom, $urlTo);

                        if ($this->_debugMode) {
                            print "from /{$urlFrom} to /{$urlTo}\n";
                        }

                    }
                } catch (Exception $e) {

                }
            }
        }
    }

    /**
     * @return string
     */
    private function _getProjectHost() {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }

        $fullurl = '';
        if (Engine::Get()->getProjectHost()) {
            $fullurl = $h.Engine::Get()->getProjectHost();
        }
        return $fullurl;
    }

    /**
     * @param $urlFrom
     * @param $urlTo
     */
    private function _setRedirect($urlFrom, $urlTo) {
        try {
            $redirect = new XShopRedirect();
            $redirect->setUrlfrom($urlFrom);
            if (!$redirect->select()) {
                $redirect->setUrlto($urlTo);
                $redirect->setCode(301);
                $redirect->insert();
            }
        } catch (Exception $e) {

        }
    }

    private function _replaceHost($url) {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }
        $search = $h.Engine::Get()->getProjectHost();
        return trim(str_replace($search, '', $url));
    }

    private $_debugMode = true;

}



