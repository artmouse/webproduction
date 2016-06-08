<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko
 * @copyright WebProduction
 * @package SQLObjectSync
 */
class SQLObjectSync_Field {

    /**
     * Заявить в таблице поле
     *
     * @param string $name
     * @param string $type
     * @param array $addons
     */
    public function __construct($name, $type, $addons = false) {
        if (!preg_match("/^([a-z0-9_]+)$/ius", $name)) {
            throw new SQLObjectSync_Exception('Field name is empty');
        }
        if (!$type) {
            throw new SQLObjectSync_Exception('Field type is empty');
        }

        $this->_name = $name;
        $this->_type = $type;
        $this->_addons = $addons;
    }

    public function setComment($comment) {
    	$this->_comment = trim($comment);
    }

    public function getComment() {
        return $this->_comment;
    }

    public function getName() {
    	return $this->_name;
    }

    public function getType() {
    	return $this->_type;
    }

    public function getAddons() {
    	return $this->_addons;
    }

    private $_name;

    private $_type;

    private $_addons;

    private $_comment;

}