<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Синхронизатор данных в таблицах SQLObject'a
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package SQLObjectSync
 */
class SQLObjectSync_Data {

    public function __construct(SQLObject $sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    /**
	 * Добавить данные на синхронизацию.
	 *
	 * @param array $keyArray Массив ключей для идентификации записи
	 * @param array $dataArray Массив данных (не обязателен)
	 * @param bool $overrideArrat Массив данных к обновлению (не обязателен)
	 */
    public function addData($keyArray, $dataArray, $overrideArray = false) {
        if (!$keyArray || !is_array($keyArray)) {
            throw new SQLObjectException(); // @todo
        }

        if (!is_array($dataArray)) {
            $dataArray = array();
        }

        if (!$overrideArray) {
        	$overrideArray = array();
        }

        // если просто true - то обновляем все
        if ($overrideArray === true) {
        	$overrideArray = $dataArray;
        }

        $this->_dataArray[] = array(
        'keyArray' => $keyArray,
        'dataArray' => $dataArray,
        'overrideArray' => $overrideArray,
        );
    }

    /**
     * Выполнить синхронизацию данных
     */
    public function sync() {
        foreach ($this->_dataArray as $data) {
            $keyArray = $data['keyArray'];
            $dataArray = $data['dataArray'];
            $overrideArray = $data['overrideArray'];

            try {
                SQLObject::TransactionStart();

                // пытаемся найти запись по ключам
                $object = clone $this->_sqlobject;
                foreach ($keyArray as $k => $v) {
                    $object->setField($k, $v);
                }

                // если нет записи - вставляем ее
                if (!$object->select()) {
                    foreach ($dataArray as $k => $v) {
                        $object->setField($k, $v);
                    }
                    $object->insert();
                }

                // обновляем запись, если есть данные и overrideArray
                if ($overrideArray) {
                    foreach ($overrideArray as $k => $v) {
                        $object->setField($k, $v);
                    }
                    $object->update();
                }

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
            }
        }
    }

    /**
	 * @var SQLObject
	 */
    private $_sqlobject;

    private $_dataArray = array();

}