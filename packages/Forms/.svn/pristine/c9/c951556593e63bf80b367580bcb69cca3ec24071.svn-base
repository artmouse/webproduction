<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_FilterObject {

    /**
     * Создать объект фильтра
     *
     * @param string $key
     * @param string $value
     * @param bool $expression
     */
	public function __construct($key, $value, $expression = false) {
        $this->_key = $key;
        $this->_value = $value;
        $this->_expression = (bool) $expression;
	}

	public function getKey() {
	    return $this->_key;
	}

	public function getValue() {
	    return $this->_value;
	}

	/**
	 * @return bool
	 */
	public function getExpression() {
	    return $this->_expression;
	}

	private $_key;

	private $_value;

	private $_expression;

}