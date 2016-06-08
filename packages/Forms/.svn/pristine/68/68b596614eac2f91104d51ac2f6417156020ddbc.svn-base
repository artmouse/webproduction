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
class Forms_ContentFieldHidden extends Forms_ContentField {

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
        return '';
    }

}