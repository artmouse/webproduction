<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Exception for SQLObject
 *
 * @copyright WebProduction
 * @package   SQLObject
 */
class SQLObject_Exception extends Exception {

    public function setQuery($query) {
        $this->_query = $query;
    }

    public function getQuery() {
        return $this->_query;
    }

    private $_query;

}