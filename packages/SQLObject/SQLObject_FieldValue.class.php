<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Поле, позволяющиее в getField/setField вставлять SQL-конструкции.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package SQLObject
 */
class SQLObject_FieldValue {

	public function __construct($value) {
	    $this->_value = $value;
	}

	public function __toString() {
	    return $this->_value;
	}

	private $_value;

}