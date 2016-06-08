<?php
/**
 * WebProduction Packages
 *
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Синхронизатор таблиц
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package SQLObjectSync
 */
class SQLObjectSync_Table {

    /**
     * Получить соеденение с базой данных
     *
     * @return ConnectionManager_IConnection
     */
    public function getConnectionDatabase() {
        if (!$this->_connection) {
            throw new SQLObject_Exception('No connection');
        }
        return $this->_connection;
    }

    /**
     * Установить соединение с базой данных
     *
     * @param ConnectionManager_IConnection $connection
     */
    public function setConnectionDatabase(ConnectionManager_IConnection $connection) {
        $this->_connection = $connection;
    }

    /**
     * Получить массив объектов SQLObjectSync_Field
     *
     * @return array
     */
    public function getFieldArray() {
        return $this->_fieldArray;
    }

    /**
     * Добавить поле в таблицу
     *
     * @param string $name
     * @param string $type
     * @param array $addons
     *
     * @return SQLObjectSync_Field
     */
    public function addField($name, $type, $addons = false) {
        // @todo: проверка и нормализация имен полей

        // @todo: вот такая тупая защита от повторения полей
        $x = new SQLObjectSync_Field($name, $type, $addons);
        $this->_fieldArray[$name] = $x;

        return $x;
    }

    /**
     * Добавить индекс, ключ, первичный ключ, уникальный ключ.
     * INDEX, PRIMARY, UNIQUE, FULLTEXT
     *
     * @param mixed $fields Поля для индекса (строка или массив)
     * @param string $indexname Имя индекса
     * @param string $type Тип индекса
     */
    private function _addKey($fields, $indexType = false, $indexName = false) {
        if (is_array($fields) && !$indexName) {
            // если указано несколько полей и не указано имя индекса - ошибка
            throw new SQLObjectSync_Exception("Cannot add multiple index without indexname!");
        } elseif (!$indexName) {
            // имя индекса = имя поля
            $indexName = $fields;

        }

        if (!is_array($fields)) {
            $fields = array($fields);
        }
        if (!$indexType) {
            $indexType = 'INDEX';
        }

        $this->_indexArray[$indexName] = array(
        'name' => $indexName,
        'fields' => $fields,
        'type' => $indexType,
        );
    }

    /**
     * Добавить индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndex($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'index', $indexName);
    }

    /**
     * Добавить уникальный индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexUnique($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'unique', $indexName);
    }

    /**
     * Добавить fulltext индекс на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexFulltext($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'fulltext', $indexName);
    }

    /**
     * Добавить перввичный ключ на поле/поля
     *
     * @param mixed $indexFields string or array
     * @param string $indexName
     */
    public function addIndexPrimary($indexFields, $indexName = false) {
        $this->_addKey($indexFields, 'primary', $indexName);
    }

    /**
     * Получить имя таблицы
     *
     * @return string
     */
    public function getTableName() {
        return $this->_tablename;
    }

    public function __construct($tableName) {
        if (!$tableName) {
            throw new SQLObjectSync_Exception('Invalid tablename');
        }
        $this->_tablename = $tableName;
    }

    /**
     * Получить движок MySQL
     *
     * @return string
     */
    public function getTableEngine() {
        return $this->_tableEngine;
    }

    /**
     * Задать движок MySQL
     *
     * @param unknown_type $engine
     */
    public function setTableEngine($engine) {
        $this->_tableEngine = $engine;
    }

    /**
     * Обработать таблицу, построить xclass если надо
     *
     * @param bool $rebuildIndexes
     */
    public function process($rebuildIndexes = false) {
        try {
            $debug = PackageLoader::Get()->getMode('debug');
            $verbose = PackageLoader::Get()->getMode('verbose');

            if ($debug) {
                print "SQLObjectSync ".$this->getTableName()."...\n";
            }

            $q = $this->getConnectionDatabase()->query("DESCRIBE `{$this->_tablename}`");

            // такая таблица есть, выполняем проверки на поля: добавляем/убираем/апдейтим

            // строим массив текущих полей в таблице
            $originalFields = array();
            while ($x = $this->getConnectionDatabase()->fetch($q)) {
                $originalFields[$x['Field']] = array(
                'name' => $x['Field'],
                'type' => $x['Type'],
                );
            }

            // проверяем каких полей не хватает:
            // проходимся по заявленным полям и смотрим какие есть
            foreach ($this->_fieldArray as $currentField) {
                $currentName = $currentField->getName();
                if (empty($originalFields[$currentName])) {
                    // такого поля нет в реальной таблице, добавляем его
                    if ($debug) {
                        print "debug: SQLObjectSync adding field ".$this->getTableName().".{$currentName} ... ";
                    }

                    if ($verbose) {
                        print "verbose: SQLObjectSync: syncing table ".
                        $this->getTableName()." add fields ".$currentName."\n";
                    }
                    $query = "ALTER TABLE `{$this->_tablename}` ADD `{$currentName}` {$currentField->getType()}
                    NOT NULL {$currentField->getAddons()} NOT NULL";
                    $this->getConnectionDatabase()->query($query);

                    if ($debug) {
                        print "ok\n";
                    }
                } else {
                    // такое поле есть в реальной таблице, обновляем его
                    if (strtolower($currentField->getType()) != strtolower($originalFields[$currentName]['type'])) {
                        if ($debug) {
                            print "debug: SQLObjectSync change field ".$this->getTableName().".{$currentName} ... ";
                        }
                        if ($verbose) {
                            print "verbose: SQLObjectSync: syncing table ".
                            $this->getTableName()." update fields ".$currentName.": new ".
                            $currentField->getType().' was '.
                            $originalFields[$currentName]['type'].
                            "\n";
                        }
                        $query = "ALTER TABLE `{$this->_tablename}` CHANGE `{$currentName}`
                        `{$currentName}` {$currentField->getType()} NOT NULL";
                        $this->getConnectionDatabase()->query($query);

                        if ($debug) {
                            print "ok\n";
                        }
                    }
                }
            }

            // перестройка индексов
            if ($rebuildIndexes) {

                if ($debug) {
                    print "debug: SQLObjectSync ".$this->getTableName()." indexes ...\n";
                }

                if ($verbose && count($this->_indexArray) < 2) {
                    print "verbose: Warning! No indexes for ".$this->getTableName()."\n";
                }

                // получаем текущие индексы
                $currentIndexArray = array();
                $q = $this->getConnectionDatabase()->query("SHOW INDEX FROM `{$this->_tablename}`");
                while ($x = $this->getConnectionDatabase()->fetch($q)) {
                    $indexName = $x['Key_name'];
                    if (!isset($currentIndexArray[$indexName])) {
                        $indexType = $x['Non_unique'] ? 'index' : 'unique';
                        if ($x['Index_type'] == 'FULLTEXT') {
                            $indexType = 'fulltext';
                        }

                        $currentIndexArray[$indexName] = array(
                        'fieldArray' => array($x['Column_name']),
                        'type' => $indexType,
                        );
                    } else {
                        $currentIndexArray[$indexName]['fieldArray'][] = $x['Column_name'];
                    }

                }

                foreach ($this->_indexArray as $index) {
                    $indextype = $index['type'];
                    $indexname = $index['name'];
                    $indexfields = $index['fields'];

                    $indextype = strtolower($indextype);
                    if ($indextype == 'primary') {
                        // primary ключи убивать нельзя!
                        continue;
                    }
                    if ($verbose) {
                        print "verbose: SQLObjectSync: syncing table ".
                        $this->getTableName()." check index ".$indexname."\n";
                    }
                    if (isset($currentIndexArray[$indexname])) {
                        // индекс уже есть
                        // если он отличается - перестраиваем
                        if (implode(',', $indexfields) != implode(',', $currentIndexArray[$indexname]['fieldArray'])
                        || $indextype != $currentIndexArray[$indexname]['type']) {
                            foreach ($indexfields as &$if) {
                                $if = "`{$if}`";
                            }
                            try {
                                if ($debug || $verbose) {
                                    print "debug: verbose: SQLObjectSync ".$this->getTableName().
                                    " index drop-n-add {$indexname} ...\n";
                                }

                                $this->getConnectionDatabase()->query(
                                    "ALTER TABLE `$this->_tablename` DROP INDEX `{$indexname}`"
                                );
                                $this->getConnectionDatabase()->query(
                                    "ALTER TABLE `$this->_tablename` ADD {$indextype} `{$indexname}`
                                    (".implode(', ', $indexfields).")"
                                );

                                if ($debug) {
                                    print "ok\n";
                                }
                            } catch (Exception $indexEx) {
                                print_r($indexEx);
                            }
                        }
                    } else {
                        // индекса еще нет
                        foreach ($indexfields as &$if) {
                            $if = "`{$if}`";
                        }
                        try {
                            if ($debug || $verbose) {
                                print "debug: verbose: SQLObjectSync ".$this->getTableName().
                                " index add {$indexname} ...\n";
                            }

                            $this->getConnectionDatabase()->query(
                                "ALTER TABLE `$this->_tablename` ADD {$indextype} `{$indexname}`
                                (".implode(', ', $indexfields).")"
                            );

                            if ($debug) {
                                print "ok\n";
                            }
                        } catch (Exception $indexEx) {
                            print_r($indexEx);
                        }
                    }
                }
            }
        } catch (Exception $e) {
            // такой таблицы нету, создаем ее

            $tmp = array();
            foreach ($this->_fieldArray as $f) {
                $tmp[] = "`{$f->getName()}` {$f->getType()} NOT NULL {$f->getAddons()}";
            }

            foreach ($this->_indexArray as $index) {
                $indextype = $index['type'];
                $indexname = $index['name'];
                $indexfields = $index['fields'];
                foreach ($indexfields as &$if) {
                    $if = "`{$if}`";
                }
                if ($indextype == 'index') {
                    $indextype = '';
                }
                $tmp[] = "{$indextype} KEY `{$indexname}` (".implode(', ', $indexfields).")";
            }

            // создаем таблицу
            // @todo: аналогично tableEngine можно вынести charset
            $this->getConnectionDatabase()->query(
                "CREATE TABLE `{$this->_tablename}` (".implode(",\n", $tmp).")
                ENGINE={$this->getTableEngine()} DEFAULT CHARSET=utf8 AUTO_INCREMENT=1"
            );
        }
    }

    /**
     * Получить имя первичного ключа (поля)
     *
     * @return string
     */
    public function getPrimaryKey() {
        foreach ($this->_indexArray as $index) {
            if (strtolower($index['type']) == 'primary') {
                return $index['fields'][0];
            }
        }
        throw new SQLObjectSync_Exception('No primary key found for table '.$this->getTableName());
    }

    /**
     * Поля таблицы
     *
     * @var array
     */
    private $_fieldArray = array();

    /**
     * Индексы таблицы
     *
     * @var array
     */
    private $_indexArray = array();

    /**
     * Имя таблицы
     *
     * @var string
     */
    private $_tablename = false;

    /**
     * Тип таблицы
     *
     * @var string
     */
    private $_tableEngine = 'innoDB';

    /**
     * Соеденение
     *
     * @var ConnectionManager_IConnection
     */
    private $_connection = null;

}