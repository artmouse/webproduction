<?php
/**
 * WebProduction Packages. SQLObject.
 *
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Объектный пул SQLObject'a.
 * В него помещаются только часто используемые объекты.
 * Пул требует ОЗУ.
 *
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @package SQLObject
 */
class SQLObject_Pool {

    /**
     * Добавить объект в пул
     *
     * @param SQLObject $object
     *
     * @throws SQLObject_Exception
     * @return bool
     */
    public function add(SQLObject $object) {
        if (!$object) {
            throw new SQLObject_Exception('Cannot put an empty object to pool');
        }

        // получаем параметры обхекта
        $classname = $object->getClassname();
        $key = $object->getField($object->getPrimaryKey());

        // сколько максимально объектов данного класса можно хранить в пуле
        $maxClassObjects = SQLObject_Config::Get()->getMaxPoolObjects($classname);

        // если вдруг ничего нельзя кешировать - то выходим
        if (!$maxClassObjects) {
            return false;
        }

        // объект уже есть в пуле
        if (isset($this->_pool[$classname][$key])) {
            return true;
        }

        // объекта еще нет в пуле, но места хватает
        // или пула еще нет вообще
        if (empty($this->_pool[$classname])
        || count($this->_pool[$classname]) < $maxClassObjects) {
            // просто добавляем объект
            $this->_pool[$classname][$key] = $object;
        } else {
            // места нет - выбрасываем первый
            reset($this->_pool[$classname]);
            $tmp = key($this->_pool[$classname]);
            unset($this->_pool[$classname][$tmp]);

            // и просто добавляем объект
            $this->_pool[$classname][$key] = $object;
        }

        return true;
    }

    /**
     * Получить объект из пула
     *
     * @param string $classname
     * @param int $key
     *
     * @return SQLObject
     */
    public function get($classname, $key) {
        $key = (int) $key;
        if (!empty($this->_pool[$classname][$key])) {
            return $this->_pool[$classname][$key];
        }

        return false;
    }

    /**
     * Удалить объект из пула
     *
     * @param string $classname
     * @param int $key
     *
     * @return bool
     */
    public function delete($classname, $key) {
        if (!empty($this->_pool[$classname][$key])) {
            unset($this->_pool[$classname][$key]);
            return true;
        }
        return false;
    }

    /**
     * Удалить все объекты из пула заданного класса
     *
     * @param string $classname
     *
     * @return bool
     */
    public function clear($classname) {
        if (!empty($this->_pool[$classname])) {
            unset($this->_pool[$classname]);
            return true;
        }
        return false;
    }

    /**
     * Удалить все объекты из пула
     */
    public function clearAll() {
        $this->_pool = array();
    }

    /**
     * Получить объекты SQLObjectPool'a
     *
     * @return SQLObject_Pool
     */
    public static function GetPool() {
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

    private $_pool = array();

}