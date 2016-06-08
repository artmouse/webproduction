<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentField_Sum_with_Currency extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->_keyValue = $keyValue;
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $assigns['sum'] = number_format(@$cellsArray[$this->_keyValue], 2);
        $assigns['currency'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol();

        return $this->getContentView()->render($assigns);
    }
    
    private $_keyValue = '';

}