<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Контрол чек-бокса, который создает чекбоксы вида primarykey[id]
 *
 * У компонента нет отображения для редактирования и возможности
 * сортировки по нему.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldCheckboxKey extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);
        $this->setSortable(false);
        $this->setEditable(false);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getDataSourceGroup()->getFieldPrimary()->getKey();
        $assigns['key'] = $key;
        $assigns['value'] = @$cellsArray[$key];
        return $this->getContentView()->render($assigns);
    }

}