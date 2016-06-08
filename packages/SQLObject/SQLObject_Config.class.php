<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * SQLObject Global Configuration.
 * Глобальная конфигурация SQLObject.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   SQLObject
 */
class SQLObject_Config  {

    /**
     * Задать соединение для опеределенного класса
     * или соединение по умолчанию
     *
     * @param string $className
     * @param ConnectionManager_IConnection $connection
     */
    public function setConnectionDatabase(
    ConnectionManager_IConnection $connection, $className = 'default') {
        if (!$this->_checkClassName($className)) {
            throw new SQLObject_Exception('Invalid classname');
        }

        $this->_connectionArray[$className] = $connection;
    }

    /**
     * Получить соединение для опеределенного класса
     * или соединение по умолчанию если для класса не получилось
     * найди соединение
     *
     * @param string $className
     *
     * @return ConnectionManager_IConnection
     */
    public function getConnectionDatabase($className = 'default') {
        if (!$this->_checkClassName($className)) {
            throw new SQLObject_Exception('Invalid classname');
        }

        if (isset($this->_connectionArray[$className])) {
            return $this->_connectionArray[$className];
        }

        if (isset($this->_connectionArray['default'])) {
            return $this->_connectionArray['default'];
        }

        throw new SQLObject_Exception('No connection');
    }

    /**
     * Добавить таблицу и класс для нее.
     * Можно указать в каком соединении ее необходимо добавить.
     *
     * @param string $tablename
     * @param string $classname
     * @param ConnectionManager_IConnection $connection
     *
     * @return SQLObject_ConfigClass
     *
     * @deprecated
     *
     * @see addClass()
     */
    public function addTable($tableName, $className) {
        return $this->addClass($className, $tableName);
    }

    /**
     * Добавить класс и таблицу для него.
     * Можно указать в каком соединении ее необходимо добавить.
     *
     * @param string $tablename
     * @param string $classname
     * @param array $connectionArray
     * @param ConnectionManager_IConnection $connection
     *
     * @return SQLObject_ConfigClass
     */
    public function addClass($className, $tableName, $connectionArray = array()) {
        if (!$this->_checkClassName($className)) {
            throw new SQLObject_Exception('Invalid classname');
        }

        $tableName = trim($tableName);
        if (!$tableName) {
            throw new SQLObject_Exception('Tablename is empty');
        }

        if (empty($this->_classArray[$className])) {
            if (!$connectionArray) {
                $connectionArray = array(
                $this->getConnectionDatabase()
                );
            }

            $object = new SQLObject_ConfigClass(
                $tableName,
                $className,
                $connectionArray
            );

            $this->_classArray[$className] = $object;
        }

        // @todo
        return $this->_classArray[$className];
    }

    /**
     * Выполнить синхронизацию БД по конфигурации
     */
    public function process() {
        // бросаем событие перед обработкой.
        // оно соберет весь конфиг в себя.
        $event = Events::Get()->generateEvent('SQLObject.build.before');
        $event->notify();

        foreach ($this->_classArray as $table) {
            $table->process();
        }

        // бросаем событие после, как правило нужно для sync.
        $event = Events::Get()->generateEvent('SQLObject.build.after');
        $event->notify();
    }

    /**
     * Установить путь к директории для генерации классов
     *
     * @param string $path
     */
    public function setPathDatabaseClasses($path) {
        if (!file_exists($path) || !is_dir($path)) {
            throw new SQLObject_Exception('Invalid directory path: '.$path);
        }
        $this->_pathDatabaseClasses = $path;
    }

    /**
     * Получить путь к директории классов
     *
     * @return string
     */
    public function getPathDatabaseClasses() {
        return $this->_pathDatabaseClasses;
    }

    /**
     * Получить максимальное количество объектов,
     * которые могут быть закешированы в пуле SQLObject_Pool
     *
     * @param string $classname
     *
     * @return int
     *
     * @todo move to SQLObject
     *
     * @deprecated
     *
     * @see SQLObjectPool
     */
    public function getMaxPoolObjects($classname) {
        if (!empty($this->_maxPoolObjects[$classname])) {
            return $this->_maxPoolObjects[$classname];
        }

        // по умолчанию пул для 100 объектов
        return 100;
    }

    /**
     * Установить максимальное количество объектов для кеширования в пуле
     *
     * @param string $classname
     * @param int $maxObjectCount
     *
     * @deprecated
     *
     * @todo правильнее перенести в Pool!
     *
     * @see SQLObject_Pool
     */
    public function setMaxPoolObjects($classname, $maxObjectCount) {
        if (!$classname) {
            throw new SQLObject_Exception('Invalid classname');
        }

        if ($maxObjectCount < 0) {
            throw new SQLObject_Exception('Invalid max. object count');
        }

        $this->_maxPoolObjects[$classname] = $maxObjectCount;
    }

    /**
     * Очистить список таблиц
     */
    public function clearTableArray() {
        $this->_classArray = array();
    }

    /**
     * Проверить имя класса на валидность
     *
     * @param string $className
     *
     * @return bool
     */
    private function _checkClassName($className) {
        return (bool) preg_match('/^([a-z0-9_]+)$/ius', $className);
    }

    /**
     * Получить конфигурацию
     *
     * @static
     * @return SQLObject_Config
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {
        // do nothing. Singleton
    }

    private function __clone() {
        // do nothing. Singleton
    }

    private $_maxPoolObjects = array();

    private $_pathDatabaseClasses = false;

    /**
     * Текущая сущность
     *
     * @var SQLObject_Config
     */
    private static $_Instance = null;

    /**
     * Массив классов
     *
     * @var array
     */
    private $_classArray = array();

    /**
     * Ассоциативный массив соединений ConnectionManager_IConnection
     *
     * @var array
     */
    private $_connectionArray = array();

}