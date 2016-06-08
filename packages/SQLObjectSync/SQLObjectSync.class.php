<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Синхронизатор таблиц со структурой в БД.
 * Класс занимается только синхронизацией таблиц и данных в базах данных,
 * он не строит классы.
 *
 * SQLObject использует SQLObjectSync как внутренюю библиотеку.
 * (аггрегация)
 *
 * @see SQLObjectSync фактически оболочка-массив над SQlObjectSync_Table
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package SQLObjectSync
 */
class SQLObjectSync {

    /**
     * Добавить таблицу
     *
     * @param string $tablename
     * @return SQLObjectSync_Table
     */
    public function addTable($tableName) {
        $tableName = trim($tableName);
        if (!$tableName) {
            throw new SQLObjectSync_Exception("Tablename is empty");
        }
        if (empty($this->_tableArray[$tableName])) {
            $this->_tableArray[$tableName] = new SQLObjectSync_Table($tableName);
        }
        return $this->_tableArray[$tableName];
    }

    /**
     * Выполнить синхронизацию
     *
     * @param bool $rebuildIndexes Перестроить все индексы
     */
    public function process($rebuildIndexes = false) {
        foreach ($this->_tableArray as $table) {
            $table->process($rebuildIndexes);
        }
    }

    /**
     * Получить соеденение с базой данных.
     *
     * @return ConnectionManager_IConnection
     */
    public function getConnectionDatabase() {
        if ($this->_connection) {
            return $this->_connection;
        }

        throw new SQLObjectSync_Exception('No connection');
    }

    /**
     * Установить соеденение с базой данных.
     * На данный момент поддерживается только MySQL.
     *
     * @param ConnectionManager_IConnection $connection
     */
    public function setConnectionDatabase(ConnectionManager_IConnection $connection) {
        $this->_connection = $connection;
    }

    public function __construct() {
        $this->_tableArray = array();
    }

    /**
     * @var ConnectionManager_IConnection
     */
    private $_connection = null;

    /**
     * @var array
     */
    private $_tableArray = array();

}