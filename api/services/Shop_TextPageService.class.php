<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Сервис управления текстовыми страницами
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_TextPageService extends ServiceUtils_AbstractService {

    /**
     * Получить все текстовые страницы
     *
     * @return ShopTextPage
     */
    public function getTextPageAll() {
        $x = new ShopTextPage();
        $x->setOrder('sort', 'ASC');
        return $x;
    }

    /**
     * Получить массив всех активных страниц
     *
     * @return array
     */
    public function getTextPageArray() {
        if ($this->_textpageArray === false) {
            $this->_textpageArray = array();
            $textpage = $this->getTextPageAll();
            while ($x = $textpage->getNext()) {
                $this->_textpageArray[] = $x;
            }
        }
        return $this->_textpageArray;
    }

    /**
     * Получить текстовую страницу по ID
     *
     * @return ShopTextPage
     */
    public function getTextPageByID($id) {
        return $this->getObjectByID($id, 'ShopTextPage');
    }

    /**
     * Получить все текстовые страницы по parentID
     *
     * @return ShopTextPage
     */
    public function getTextPageByParentID($parentid) {
        return $this->getObjectByField('parentid', $parentid, 'ShopTextPage');
    }

    /**
     * Получить тестовую страницу по ключу
     *
     * @return ShopTextPage
     */
    public function getTextPageByKey($key) {
        $a = $this->getTextPageArray();

        foreach ($a as $x) {
            if ($x->getKey() == $key) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить текстовую страницу по обработчику (логик-классу)
     *
     * @param string $logicclass
     *
     * @return ShopTextPage
     */
    public function getTextPageByLogicclass($logicclass) {
        $a = $this->getTextPageArray();

        foreach ($a as $x) {
            if ($x->getLogicclass() == $logicclass) {
                return $x;
            }
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Найти станицу по URL-префиксу
     *
     * @param string $url
     *
     * @return ShopTextPage
     */
    public function getTextPageByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopTextPage', false);
    }

    private $_textpageArray = false;

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_TextPageService
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
     * @var Shop_TextPageService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}