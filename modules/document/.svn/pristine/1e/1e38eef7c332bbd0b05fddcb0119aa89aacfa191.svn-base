<?php
/**
 * Ссылка на удаление документа
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Document_ContentField_Delete extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $rowIndex;

        $assigns['id'] = @$cellsArray['id'];

        return $this->getContentView()->render($assigns);
    }

}