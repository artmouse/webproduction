<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Конфигурация класса
 *
 * @author    Maxim Miroshnichenko
 * @copyright WebProduction
 * @package   SQLObject
 *
 * @todo rename to ConfigClass
 */
class SQLObject_ConfigClass {

    public function __construct($tableName, $className, $connectionArray) {
        if (!preg_match('/^([a-z0-9_]+)$/ius', $className)) {
            throw new SQLObject_Exception('Invalid classname');
        }

        if (empty($connectionArray)) {
            throw new SQLObject_Exception('Invalid connection array');
        }

        // запоминаем имя класса
        $this->_className = $className;

        // запоминаем имя таблицы
        $this->_tableName = $tableName;

        // создаем синхронизатор
        $this->_sync = new SQLObjectSync_Table($tableName);

        // запоминаем массив соединений
        $this->_connectionArray = $connectionArray;
    }

    /**
     * Добавить поле в таблицу
     *
     * @param string $name
     * @param string $type
     * @param mixed $addons
     *
     * @return SQLObjectSync_Field
     */
    public function addField($name, $type, $addons = false) {
        return $this->_sync->addField($name, $type, $addons);
    }

    public function addIndex($indexFieldArray, $indexName = false) {
        $this->_sync->addIndex($indexFieldArray, $indexName);
    }

    public function addIndexUnique($indexFieldArray, $indexName = false) {
        $this->_sync->addIndexUnique($indexFieldArray, $indexName);
    }

    public function addIndexFulltext($indexFieldArray, $indexName = false) {
        $this->_sync->addIndexFulltext($indexFieldArray, $indexName);
    }

    public function addIndexPrimary($indexFieldArray, $indexName = false) {
        $this->_sync->addIndexPrimary($indexFieldArray, $indexName);
    }

    public function setTableEngine($engine) {
        $this->_sync->setTableEngine($engine);
    }

    /**
     * Обработать таблицу и построить xclass если надо
     */
    public function process() {
        // определяем primaryKey
        $primaryKey = $this->_sync->getPrimaryKey();

        // для каждого соединения
        foreach ($this->_connectionArray as $connection) {
            // задаем соединение
            $this->_sync->setConnectionDatabase($connection);

            // запускаем синхронизатор
            $this->_sync->process(true); // true - это перестроить индексы тоже
        }

        // генерируем файл с классом
        $fdata = '<?php'."\n";
        $fdata .= "/**\n";
        $fdata .= " * Class {$this->_className} is ORM to table {$this->_tableName}\n";
        $fdata .= " * @author SQLObject\n";
        $fdata .= " * @package SQLObject\n";
        $fdata .= " */\n";
        $fdata .= "class {$this->_className} extends SQLObject {\n";
        $fdata .= "\n";

        $iteratableFields = $this->_sync->getFieldArray();

        // если в таблице только одно поле - то X генерим
        // по всей таблице ни смотря на то что заявлено в конфигах
        if (count($iteratableFields) == 1) {
            // очищаем поля
            $iteratableFields = array();

            // @todo: adapter
            $q = $this->_sync->getConnectionDatabase()->query(
                "DESCRIBE `{$this->_getTableName()}`"
            );

            while ($x = $this->_sync->getConnectionDatabase()->fetch($q)) {
                $this->addField($x['Field'], $x['Type']);
            }
        }

        $iteratableFields = $this->_sync->getFieldArray();

        $fieldArray = array();
        foreach ($iteratableFields as $field) {
            $type = 'string';
            if (substr_count($field->getType(), 'int')) {
                $type = 'int';
            }
            if (substr_count($field->getType(), 'float')) {
                $type = 'float';
            }
            if (substr_count($field->getType(), 'decimal')) {
                $type = 'float';
            }

            $fieldName = $field->getName();
            $m = $fieldName;

            $fieldArray[] = "'$fieldName'";

            $comment = $field->getComment();
            if ($comment) {
                $comment = ": {$comment}";
            }

            $m[0] = strtoupper($m[0]);
            $fdata .= "    /**\n";
            $fdata .= "     * Get {$fieldName}{$comment}\n";
            $fdata .= "     * @return $type\n";
            $fdata .= "     */\n";
            $fdata .= "    public function get{$m}() { return \$this->getField('{$fieldName}');}\n";
            $fdata .= "\n";
            $fdata .= "    /**\n";
            $fdata .= "     * Set {$fieldName}{$comment}\n";
            $fdata .= "     * @param $type $$fieldName\n";
            $fdata .= "     */\n";
            $fdata .= "    public function set{$m}($$fieldName, \$update = false) {";
            $fdata .= "\$this->setField('$fieldName', $$fieldName, \$update);}\n";
            $fdata .= "\n";
            $fdata .= "    /**\n";
            $fdata .= "     * Filter {$fieldName}{$comment}\n";
            $fdata .= "     * @param $type $$fieldName\n";
            $fdata .= "     * @param string \$operation\n";
            $fdata .= "     */\n";
            $fdata .= "    public function filter{$m}($$fieldName, \$operation = false)";
            $fdata .= " {\$this->filterField('$fieldName', $$fieldName, \$operation);}\n";
            $fdata .= "\n";
        }

        $fdata .= "    /**\n";
        $fdata .= "     * Create an object\n";
        $fdata .= '     * @param int $id'."\n";
        $fdata .= "     */\n";
        $fdata .= '    public function __construct($id = 0) {'."\n";
        $fdata .= '        $this->setTablename(\''.$this->_tableName.'\');'."\n";
        $fdata .= '        $this->setClassname(__CLASS__);'."\n";
        //$fdata .= '        $this->setPrimaryKey(\''.$primaryKey.'\');'."\n";
        //$fdata .= '        $this->setFields(array('.implode(', ', $fieldArray).'));'."\n";
        $fdata .= '        parent::__construct($id);'."\n";
        $fdata .= '    }'."\n";
        $fdata .= "\n";
        $fdata .= '    /**'."\n";
        $fdata .= '     * @return '.$this->_className."\n";
        $fdata .= '     */'."\n";
        $fdata .= '    public function getNext($exception = false) {return parent::getNext($exception); }'."\n";
        $fdata .= "\n";
        $fdata .= '    /**'."\n";
        $fdata .= '     * @return '.$this->_className."\n";
        $fdata .= '     */'."\n";
        $fdata .= '    public static function Get($key) {return self::GetObject("'.$this->_className.'", $key);}'."\n";
        $fdata .= "\n";
        $fdata .= "}\n";

        $fdata .= "\n";
        $fdata .= 'SQLObject::SetFieldArray(\''.$this->_tableName.'\', array('.implode(', ', $fieldArray).'));'."\n";
        $fdata .= 'SQLObject::SetPrimaryKey(\''.$this->_tableName.'\', \''.$primaryKey.'\');'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'InsertBefore\', new SQLObject_Event());'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'InsertAfter\', new SQLObject_Event());'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'UpdateBefore\', new SQLObject_Event());'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'UpdateAfter\', new SQLObject_Event());'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'DeleteBefore\', new SQLObject_Event());'."\n";
        //$fdata .= 'Events::Get()->addEvent(\''.$this->_className.'DeleteAfter\', new SQLObject_Event());'."\n";

        // записываем класс в файл
        file_put_contents(
            SQLObject_Config::Get()->getPathDatabaseClasses().$this->_className.'.class.php',
            $fdata,
            LOCK_EX
        );

        // дописываем в index.php
        file_put_contents(
            SQLObject_Config::Get()->getPathDatabaseClasses().'index.php',
            "PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/".$this->_className.".class.php');\n",
            FILE_APPEND | LOCK_EX
        );
        // возвращаем название имя файла-класса
        return $this->_className.'.class.php';
    }

    private $_className;

    private $_tableName;

    /**
     * Array of ConnectionManager_IConnection
     *
     * @var array
     */
    private $_connectionArray = array();

    /**
     * Объект сихронизатор
     *
     * @var SQLObjectSync_Table
     */
    private $_sync;

}