<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Менеджер DataSouce.
 * Контроллирует, чтобы все DS в системе были в единственном экземляре,
 * иначе начнется аццкая рекурсия.
 *
 * OOP - singleton + registry.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_DataSourceManager {

    /**
     * Получить DataSource.
     * Причем менеджер проконтроллирует единственный экземпляр класса.
     *
     * @param string $classname
     * @return Forms_ADataSource
     */
    public function getDataSource($classname) {
        if (!$classname) {
        	throw new Forms_Exception();
        }

        if (empty($this->_datasourceArray[$classname])) {
        	$this->_datasourceArray[$classname] = new $classname();
        }
        return $this->_datasourceArray[$classname];
    }

    /**
     * @return Forms_DataSourceManager
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

    private $_datasourceArray = array();

}