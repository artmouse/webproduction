<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Shop_ContentField_LinkProduct extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();
        $key = $this->getKey();
        
        $assigns['value'] = @$cellsArray[$key];
        $assigns['valueExists'] = (@$cellsArray[$key] !== false);
        $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-products-edit',
        @$cellsArray[$key]
        );

        return $this->getContentView()->render($assigns);
    }

}