<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_URLParser implements Engine_IURLParser {

    /**
     * Возвращает URL, на основании которого Engine будет искать необходимый контент
     *
     * @return string
     */
    public function getMatchURL() {
        // проверяем редиректы
        $url = Engine_URLParser::Get()->getTotalURL();

        // модуль редиректов
        try {
            if (class_exists('XShopRedirect')) {
                $redirect = new XShopRedirect();
                $redirect->setUrlfrom($url);
                if ($redirect->select()) {
                    $code = $redirect->getCode();
                    if (!$code) {
                        $code = 301;
                    }
                    header('Location: '.$redirect->getUrlto(), true, $redirect->getCode());
                    exit();
                }
            }
        } catch (Exception $connectionException) {
            // заключен в try-catch, так как инсталлятор работает
            // без SQL соединения, а система роутинга ему нужна.
        }

        // если передан параметр ?p=X
        try {
            $p = $this->getArgument('p');

            header('Location: '.$url, true, 301);
            exit();
        } catch (Exception $e) {

        }

        // получаем и проверяем валюту
        try {
            $this->getArgument('currency');
            Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->_replaceUrl('currency');
        } catch (Exception $currencyEx) {

        }

        // проверяем URL на категорию
        $url = Engine_URLParser::Get()->getTotalURL();
        $url_md5 = md5($url);

        if (isset($this->_matchArray[$url_md5])) {
            return $this->_matchArray[$url_md5];
        }

        // в URL ловим фильтры
        if (preg_match_all("/filter(\d+)=(.+?)\//ius", $url, $r)) {
            $filterArray = array();
            foreach ($r[0] as $index => $urlSuffix) {
                $url = str_replace($urlSuffix, '', $url);
                $filterArray[$r[1][$index]][] = urldecode($r[2][$index]);
            }
            foreach ($filterArray as $filterID => $filterValueArray) {
                $this->setArgument('filter'.$filterID.'value', $filterValueArray);
            }
        }

        // ловим в URL бренд
        if (preg_match_all("/brand=(\d+)-(.*?)\//ius", $url, $r)) {
            $brandArray = array();
            foreach ($r[0] as $index => $urlSuffix) {
                $url = str_replace($urlSuffix, '', $url);
                $brandArray[] = $r[1][$index];
            }
            if ($brandArray) {
                $this->setArgument('brand', $brandArray);
            }
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

        // ловим пагинацию
        if (preg_match("/\/p-(\d+?)\//ius", $url, $r)) {
            $p = $r[1];
            $url = str_replace('/p-'.$p.'/', '/', $url);
            if ($p > 0) {
                $this->setArgument('p', $p);
            }
        }

        $urlOriginal = $url;

        // убираем слэши
        $urlLast = trim($url, '/');

        $url = explode('.', Engine::GetURLParser()->getHost());

        if (!substr_count($urlOriginal, 'admin/') && $urlOriginal != '/install/') {

            // ищем категорию
            try {
                $category = Shop::Get()->getShopService()->getCategoryByURL($urlLast);
                $result = $category->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
            } catch (Exception $e) {

            }

            // потом товар
            try {
                $product = Shop::Get()->getShopService()->getProductByURL($urlLast);
                $result = $product->makeURL(false);
                $this->_matchArray[$url_md5] = $result;
                return $result;
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

            // потом тег
            try {
                $tag = Shop::Get()->getShopService()->getProductTagByURL($urlLast);
                $result = $tag->makeURL(false);
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

        $this->_matchArray[$url_md5] = $urlOriginal;
        return $urlOriginal;
    }

    /**
     * Для текущей открытой страницы получить идентификатор, который
     * с большой степенью вероятности будет ее однозначно идентифицировать
     *
     * Необходим для системы кеширования контентов.
     *
     * @return string
     */
    public function makeURLID() {
        return Engine_URLParser::Get()->makeURLID();
    }

    /**
     * Возвращает "чистый" URL запрос
     *
     * @author Ramm
     * @return string
     */
    public function getTotalURL() {
        return Engine_URLParser::Get()->getTotalURL();
    }

    /**
     * Возвращает часть URL запроса, которая содержит содержит GET параметры
     *
     * @return string
     */
    public function getGETString() {
        return Engine_URLParser::Get()->getGETString();
    }

    /**
     * Возвращает хост
     *
     * @return string
     */
    public function getHost() {
        return Engine_URLParser::Get()->getHost();
    }

    /**
     * Возвращает аргументы передаваемые странице
     *
     * @return array
     */
    public function getArguments() {
        return Engine_URLParser::Get()->getArguments();
    }

    /**
     * Возвращает аргумент по ключу
     *
     * @throws Engine_Exception
     * @param string $key
     * @return mixed
     */
    public function getArgument($key) {
        return Engine_URLParser::Get()->getArgument($key);
    }

    /**
     * Добавить агрумент.
     * Метод добавлен по инициативе.
     *
     * @author Max
     * @param string $key
     * @param mixed $value
     */
    public function setArgument($key, $value) {
        return Engine_URLParser::Get()->setArgument($key, $value);
    }

    /**
     * Возвращает аргумент по ключу (без генерации исключения в случае его отсутствия - тогда вернет false)
     *
     * @param string $key
     * @return mixed
     */
    public function getArgumentSecure($key) {
        return Engine_URLParser::Get()->getArgumentSecure($key);
    }

    /**
     * Возвращает ПОЛНЫЙ URL с гет параметрами, если они были переданы
     *
     * @return string
     */
    public function getCurrentURL() {
        return Engine_URLParser::Get()->getCurrentURL();
    }

    /**
     * @return Shop_URLParser
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    /**
     * Удалить GET-параметр с URL, короый не нужен для отображения.
     *
     * @param  string $param
     */
    public function _replaceUrl($param) {
        // парсим URL
        $pars = parse_url(Engine::GetURLParser()->getCurrentURL());

        if (empty($pars['query'])) {
            return;
        }

        // если найдено символ & - это означает что пол-во параметро != 1
        if (strstr($pars['query'], '&')) {
            $queryArray = explode('&', $pars['query']);
            $new_url = '?';
            foreach ($queryArray as $val) {
                if (strstr($val, $param)) {
                    continue;
                }
                $new_url .= $val.'&';
            }
            $new_url = $pars['path'].preg_replace("/(.*).$/", "\\1", $new_url);
        }
        else {
            // если кол-во параметров 1, то этот параметро обязательно == $param
            $new_url = $pars['path'];
        }

        // перезагружаем страницу с новым URL
        header('HTTP/1.1 303 See Other');
        header('Location: '.$new_url);
        exit();
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