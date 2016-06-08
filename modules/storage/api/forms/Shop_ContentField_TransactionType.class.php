<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Shop_ContentField_TransactionType extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $assigns['return'] = @$cellsArray['return'];

        $type = @$cellsArray['type'];
        $typeName = StorageService::Get()->getTransactionTypeNameByKey($type);
        $assigns['type'] = $typeName;

        $assigns['translate_return'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_return_small');

        return $this->getContentView()->render($assigns);
    }

}