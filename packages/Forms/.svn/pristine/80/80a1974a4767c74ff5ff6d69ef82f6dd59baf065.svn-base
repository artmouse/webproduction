<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldInt extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    /**
     * Отрисовать контрол поля
     * для форм редактирования / добавления
     *
     * @param mixed $value
     * @return string
     */
    public function renderControl($value = false) {
        $assigns = array();

        if (!$value) {
            $value = 0;
        }

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = htmlspecialchars($value);
        $assigns['disabled'] = $this->getDisabled();

        return $this->getContentControl()->render($assigns);
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $assigns['value'] = htmlspecialchars(@$cellsArray[$this->getKey()]);
        return $this->getContentView()->render($assigns);
    }

    public function getValue() {
        $x = parent::getValue();
        $x = str_replace(',', '.', $x);
        $x = str_replace(' ', '', $x);
        return $x;
    }

}