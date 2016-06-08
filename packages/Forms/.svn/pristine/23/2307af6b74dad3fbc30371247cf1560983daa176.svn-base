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
class Forms_ContentFieldCheckbox extends Forms_ContentField {

    public function __construct($key) {
        parent::__construct($key);

        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    /**
	 * Отрисовать поле для просмотра (в табличном выводе, например).
	 *
	 * @param int $rowIndex
	 * @param array $cellsArray
	 * @return string
	 */
    public function renderView($rowIndex, $cellsArray) {
        $value = @$cellsArray[$this->getKey()];
        if ($value) {
            $value = '+';
        } else {
            $value = '-';
        }
        return $value;
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

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['value'] = $value;
        $assigns['disabled'] = $this->getDisabled();

        return $this->getContentControl()->render($assigns);
    }

    /**
     * Получить значение во введенный элемент
     *
     * @return string
     */
    public function getValue() {
        try {
            return Engine::GetURLParser()->getArgument($this->getKey());
        } catch (Exception $e) {
            return 0;
        }
    }

}