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
class Forms_ContentTableRow extends Forms_Content {

    public function __construct() {
        $this->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function render(Forms_ContentTable $table, $rowIndex, $cellsArray) {
        $assigns = array();

        $a = array();
        $b = array();

        foreach ($table->getFieldsArray() as $field) {
            $a[$field->getKey()] = $field->renderView($rowIndex, $cellsArray);
            $b[$field->getKey()] = @$cellsArray[$field->getKey()];
        }

        $assigns['cellsArray'] = $a;
        $assigns['cellsDataArray'] = $b;

        return parent::render($assigns);
    }

}