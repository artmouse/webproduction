<?php
/**
 * WebProduction Shop (wpshop)
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Rtm_URLParser
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Rtm_URLParser extends Shop_URLParser {

    /**
     * Возвращает URL, на основании которого Engine будет искать необходимый контент
     *
     * @return string
     */
    public function getMatchURL() {
        // проверяем редиректы
        $url = Engine_URLParser::Get()->getTotalURL();
        $getStr = Engine_URLParser::Get()->getGETString();

        $urlLowCase = strtolower($url);
        if (strcmp($urlLowCase, $url)) {
            if ($getStr) {
                $urlLowCase .= '?' . $getStr;
            }
            header('Location: ' . $urlLowCase, true, 301);
            exit();
        }


        // модуль редиректов
        try {
            if (strpos($url, '/', strlen($url) - 1) === false) {
                if ($getStr) {
                    $fromUrl = $url . '/?' . Engine_URLParser::Get()->getGETString();
                } else {
                    $fromUrl = $url;
                }
            } else {
                $fromUrl = Engine_URLParser::Get()->getCurrentURL();
            }

            $redirect = new XShopRedirect();
            $redirect->setUrlfrom($fromUrl);
            if ($redirect->select()) {
                $code = $redirect->getCode();
                if (!$code) {
                    $code = 302;
                }
                header('Location: ' . $redirect->getUrlto(), true, $redirect->getCode());
                exit();
            }
        } catch (Exception $connectionException) {
            // заключен в try-catch, так как инсталлятор работает
            // без SQL соединения, а система роутинга ему нужна.
        }


        $noSlashArray = array(
            '/api/product/search',
            '/api/product/add',
            '/api/user/search',
            '/api/user/add',
        );

        try {
            $urlLenght = strlen($url);
            if ($urlLenght > 1 && !in_array($url, $noSlashArray) && !$getStr && strpos($url, '/', $urlLenght - 1) !==
            false && !substr_count($url, 'admin/') && !substr_count($url, 'image')) {
                header('Location: ' . rtrim($url, '/'), true, 301);
                exit();
            }
        } catch (Exception $e) {

        }

        try {
            // Редирект с пагинации /?p=1 на /filter_p=1
            if (preg_match("/p=(\d+)/ius", $getStr, $r)) {
                if (isset($r[1])) {
                    if ($r[1] != 0) {
                        $url .= 'filter_p=' . $r[1];
                    }
                    header('Location: ' . $url, true, 301);
                    exit();
                }
            }

            if (strpos($url, '/filter_p=0') !== false && strpos($url, '/filter_p=0_') === false) {
                header('Location: ' . str_replace('/filter_p=0', '', $url), true, 301);
                exit();
            }
        } catch (Exception $e) {

        }

        // получаем и проверяем валюту
        try {
            $this->getArgument('currency');
            Shop::Get()->getCurrencyService()->getCurrencyDefault();
            $this->_replaceUrl('currency');
        } catch (Exception $currencyEx) {

        }

        try {
            $_SESSION['shopshow'] = $this->getArgument('show');
            $this->_replaceUrl('show');
        } catch (Exception $e) {

        }

        if (!empty($_SESSION['shopshow'])) {
            $this->setArgument('show', $_SESSION['shopshow']);
        }

        // проверяем URL на категорию
        $url = Engine_URLParser::Get()->getTotalURL();
        $url_md5 = md5($url);

        if (isset($this->_matchArray[$url_md5])) {
            return $this->_matchArray[$url_md5];
        }


        // ловим в URL категорию
        if (preg_match_all("/category=(.+?)\//ius", $url, $r)) {
            $categoryArray = array();
            foreach ($r[0] as $index => $urlSuffix) {
                $url = str_replace($urlSuffix, '', $url);
                $categoryArray[] = $r[1][$index];
            }
            if ($categoryArray) {
                $this->setArgument('category', $categoryArray);
            }
        }

        $urlOriginal = $url;


        // убираем слэши
        $urlLast = trim($url, '/');

        if (!substr_count($urlOriginal, 'admin/')) {

            // ищем категорию
            try {
                $currentUrl = Engine_URLParser::Get()->getCurrentURL();
                if (strpos($currentUrl, '/filter') !== false && !substr_count($currentUrl, '/search')) {
                    $a = explode('/', $currentUrl);
                    $urlLast = $a[1];
                }

                $category = Shop::Get()->getShopService()->getCategoryByURL($urlLast);
                $result = $category->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }
            // потом товар
            try {

                @list($categoryUrl, $productUrl) = explode('/', $urlLast);

                if ($categoryUrl && $productUrl) {
                    $category = Shop::Get()->getShopService()->getCategoryByURL($categoryUrl);
                    $product = Shop::Get()->getShopService()->getProductByURL($productUrl);
                    $product->setCategoryid($category->getId());
                    if ($product->select()) {
                        $result = $product->makeURL(false);
                        $this->_matchArray[$url_md5] = $result;
                        return $result;
                    }
                } else {
                    $product = Shop::Get()->getShopService()->getProductByURL($urlLast);
                    $result = $product->makeURL(false);
                    $this->_matchArray[$url_md5] = $result;
                    return $result;
                }


            } catch (Exception $e) {

            }

            // потом бренд
            try {
                $brand = Shop::Get()->getShopService()->getBrandByURL($urlLast);
                $result = $brand->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }

            // потом страницы
            try {
                $page = Shop::Get()->getTextPageService()->getTextPageByURL($urlLast);
                $result = $page->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }

            // потом новости
            try {
                $news = Shop::Get()->getNewsService()->getNewsByURL($urlLast);
                $result = $news->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }

            // потом галерею
            try {
                $gallery = GalleryService::Get()->getGalleryByURL($urlLast);
                $result = $gallery->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }
        }

        // Для контентов ищем урлы со слешами
        if (!in_array($url, $noSlashArray)) {
            $urlOriginal .= '/';
        }
        $urlOriginal = str_replace('//', '/', $urlOriginal);
        $this->_matchArray[$url_md5] = $urlOriginal;
        return $urlOriginal;
    }

    /**
     * Rtm_URLParser
     *
     * @return Rtm_URLParser
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

    /**
     * Кеш отработанных URLов
     *
     * @var array
     */
    private $_matchArray = array();

}