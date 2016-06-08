<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Редактируемое поле для таблицы
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldEditable extends Forms_ContentField {

    public function __construct($key) {
	    parent::__construct($key);

	    $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
	}

    public function renderView($rowIndex, $cellsArray) {
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $assigns = array();
        $assigns['key'] = $key;
        $assigns['value'] = @$cellsArray[$key];
        $assigns['primary_key'] = $keyPrimary;
        $assigns['primary_value'] = @$cellsArray[$keyPrimary];

        return $this->getContentView()->render($assigns);
    }

}