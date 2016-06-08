<?php

class Shop_ContentField_Price_with_Currency extends Forms_ContentField {

    public function __construct() {
        parent::__construct('');
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $rowIndex;

        $assigns = array();
        $assigns['sum'] = number_format(@$cellsArray['cost'] / $cellsArray['amount'], 2);
        $assigns['currency'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol();

        return $this->getContentView()->render($assigns);
    }

}