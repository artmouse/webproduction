<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2015 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Пул, в который мы помещаем изменения объектов во время транзакций.
 * Когда выполняется commit транзакции - pool по этому уровню транзакции очищается.
 * Когда выполняется revert транзакции - данные из pool обратно переносятся в объект
 *
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @package SQLObject
 */
class SQLObject_RevertPool {

    /**
     * Поместить объект в transaction pool
     *
     * @param SQLObject $object
     * @param int $transactionLevel
     */
    public function add(SQLObject $object, $transactionLevel, $field, $value) {
        if (!$object) {
            throw new SQLObject_Exception('Cannot put an empty object to pool');
        }

        if ($field == $object->getPrimaryKey()) {
            return;
        }

        $classname = $object->getClassname();
        $key = $object->getField($object->getPrimaryKey());

        $this->_poolObjectArray[$transactionLevel][$classname.'-'.$key] = $object;
        $this->_poolFieldArray[$transactionLevel][$classname.'-'.$key][$field] = $value;
    }

    /**
     * Очистить pool для данного уровня транзакции
     *
     * @param int $transactionLevel
     */
    public function clear($transactionLevel) {
        unset($this->_poolObjectArray[$transactionLevel]);
        unset($this->_poolFieldArray[$transactionLevel]);
    }

    /**
     * Откатить pool для данного уровня транзакции: все поля объектов будут восстановлены
     *
     * @param int $transactionLevel
     */
    public function revert($transactionLevel) {
        if (!empty($this->_poolObjectArray[$transactionLevel])) {
            foreach ($this->_poolObjectArray[$transactionLevel] as $key => $object) {
                foreach ($this->_poolFieldArray[$transactionLevel][$key] as $field => $value) {
                    $object->revertField($field, $value);
                }
            }
        }
        $this->clear($transactionLevel);
    }

    /**
     * Получить pool
     *
     * @return SQLObject_RevertPool
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

    private $_poolFieldArray = array();

    private $_poolObjectArray = array();

}