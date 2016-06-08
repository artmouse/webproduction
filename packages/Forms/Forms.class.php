<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @deprecated не используется?!!
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms {

    /**
     * @return Forms
     */
    public static function Get() {
        if (!self::$_Instance) {
        	self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    /**
     * Зарегистрировать источник данных
     *
     * @param string $classname
     */
    public function registerDataSource($classname) {
        // @todo: checks
        $this->_dataSourceArray[$classname] = false;
    }

    /**
     * Получить источник данных
     *
     * @param string $classname
     * @return Forms_IDataSource
     */
    public function getDataSource($classname) {
        if (isset($this->_dataSourceArray[$classname])) {
        	$object = $this->_dataSourceArray[$classname];
        	if ($object) {
        		return $object;
        	} else {
        	    $object = new $classname();
        	    $this->_dataSourceArray[$classname] = $object;
        	    return $object;
        	}
        }
        throw new Forms_Exception("DataSource with name (classname) '{$classname}' not found");
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

    private $_dataSourceArray = array();

}