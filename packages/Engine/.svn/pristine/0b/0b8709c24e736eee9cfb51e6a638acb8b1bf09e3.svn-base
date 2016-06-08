<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Default-Engine класс-анализатор URL-адреса и аргументов
 *
 * @copyright WebProduction
 * @package Engine
 * @author Ramm
 * @author Max
 * @subpackage URLParser
 */
class Engine_URLParser implements Engine_IURLParser {

    /**
     * Создание парсера
     */
    protected function __construct() {
        $this->_setArguments();
        $this->_setTotalUrl(@$_SERVER['REQUEST_URI']);
        $this->_setHost();
    }

    /**
     * Устанавливает GET параметры
     * при создании парсера путем передачи URL строки
     *
     * @author Ramm
     * @param string $getstring
     */
    protected function _stringGETParser($getstring) {
        $temp = explode('&', $getstring);
        foreach ($temp as $param) {
            $p = explode('=', $param);
            if (isset($p[1])) {
                $_GET[$p[0]] = $p[1];
            } else {
                $_GET[$p[0]] = '';
            }
        }
    }

    /**
     * Для текущей открытой страницы получить идентификатор, который
     * с большой степенью вероятности будет ее однозначно идентифицировать
     *
     * @return string
     */
    public function makeURLID() {
        return @md5($this->getTotalURL().serialize($this->getArguments()));
    }

    /**
     * Снять экранирование с массива, рекурсивно
     *
     * @param array $a
     * @return array
     */
    protected function _unescapeArray($a) {
        foreach ($a as $k => $v) {
            if (is_array($v)) {
                $a[$k] = $this->_unescapeArray($v);
            } else {
                $a[$k] = stripslashes($v);
            }
        }
        return $a;
    }

    /**
     * Установка аргументов передаваемых странице посредством суперглобальных массивов
     * Здесь происходит очистка суперглобальных массивов
     * Должен вызываться при старте
     *
     * @author Ramm
     * @author Max
     * @author Vova (found bugs)
     */
    protected function _setArguments() {
        $a = array_merge(array_merge($_FILES, $_GET), $_POST);

        if (get_magic_quotes_gpc()) {
            // если включены magic quotes - вручную снимаем экранирование
            $a = $this->_unescapeArray($a);
        }

        $this->_arguments = $a;

        // очищаем массивы GET/POST/FILES,
        // чтобы не повадно было с ними работать :-)
        $_FILES = array();
        $_GET = array();
        $_POST = array();
        $_SERVER['argv'] = array();
        $_SERVER['QUERY_STRING'] = '';
        $_SERVER['REDIRECT_QUERY_STRING'] = '';
    }

    /**
     * Устанавливает "чистый" URL-запрос и GET строку
     * Должен вызываться при старте
     *
     * @param string $url
     */
    protected function _setTotalUrl($url) {
        $temp = explode('?', $url);
        $this->_totalURL = $temp[0];
        while (substr_count($this->_totalURL, '//')) {
            $this->_totalURL = str_replace('//', '/', $this->_totalURL);
        }
        if (isset($temp[1])) {
            $this->_stringGET = $temp[1];
        }
    }

    /**
     * Установить хост
     * Должен вызываться при старте
     *
     * @author Ramm
     */
    protected function _setHost() {
        $this->_host = @$_SERVER['HTTP_HOST'];
    }

    /**
     * Получить локальную часть URL
     *
     * @return string
     */
    public function getLocal() {
        return $this->_local;
    }

    /**
     * @return string
     */
    public function getMatchURL() {
        $url = $this->_totalURL;

        if ($this->_local) {
            $url = preg_replace("/^".str_replace('/', '\/', preg_quote($this->_local))."/", '', $url);
        }

        return $url;
    }

    /**
     * Возвращает "чистый" URL запрос
     *
     * @author Ramm
     * @return string
     */
    public function getTotalURL() {
        return $this->_totalURL;
    }

    /**
     * Возвращает часть URL запроса, которая содержит содержит GET параметры
     *
     * @return string
     */
    public function getGETString() {
        return $this->_stringGET;
    }

    /**
     * Возвращает хост
     *
     * @return string
     */
    public function getHost() {
        return $this->_host;
    }

    /**
     * Возвращает аргументы передаваемые странице
     *
     * @return array
     */
    public function getArguments() {
        return $this->_arguments;
    }

    /**
     * Возвращает аргумент по ключу
     *
     * @throws Engine_Exception
     * @param string $key
     * @return mixed
     */
    public function getArgument($key) {
        if (!isset($this->_arguments[$key])) {
            throw new Engine_Exception("Аргумент {$key} отсутствует");
        }
        return $this->_arguments[$key];
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
        $this->_arguments[$key] = $value;
    }

    /**
     * Возвращает аргумент по ключу.
     * Без генерации исключения.
     * В случае его отсутствия - тогда вернет false.
     *
     * @param string $key
     * @return mixed
     */
    public function getArgumentSecure($key) {
        if (!isset($this->_arguments[$key])) {
            return false;
        } else {
            return $this->_arguments[$key];
        }
    }

    /**
     * Метод убиения непокорного рукотворения
     * великого Ramm'а руками призренного программера
     */
    public static function KillParser() {
        self::$_Instance = null;
    }

    /**
     * Возвращает ПОЛНЫЙ URL с GET параметрами (если они были переданы)
     *
     * @return string
     */
    public function getCurrentURL() {
        $url = $this->getTotalURL();
        if ($this->getGETString()) {
            $url .= '?' . $this->getGETString();
        }
        return $url;
    }

    /**
     * Задать локальную часть URL'a, которую необходимо отбрасывать при анализе
     *
     * @param string $local
     */
    public function setLocal($local) {
        $this->_local = $local;
    }

    /**
     * Получение парсера (реализация шаблона singleton)
     *
     * @static
     * @return Engine_URLParser
     */
    public static function Get() {
        if (self::$_Instance === null) {
            self::$_Instance = new Engine_URLParser();
        }
        return self::$_Instance;
    }

    /**
     * Указатель на экземпляр объекта в системе (шаблон Singleton)
     *
     * @var Engine_URLParser
     */
    protected static $_Instance = null;

    protected $_host;

    /**
     * "Чистый" URL, без get'a
     *
     * @author Ramm
     * @var string
     */
    protected $_totalURL = '';

    /**
     * Часть URL запроса содержащая GET параметры
     *
     * @author Ramm
     * @var string
     */
    protected $_stringGET = '';

    /**
     * Массив аргументов страници
     * Фактически это объединение POST и GET параметров с преимуществом первых
     *
     * @author Ramm
     * @var array
     */
    protected $_arguments = array();

    /**
     * Локальная часть URL
     *
     * @var string
     */
    protected $_local = false;

}