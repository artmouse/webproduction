<?php
/**
 * *
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Finance_ContentField_Payment_Sum extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $rowIndex = $rowIndex;
        $accountID = @$cellsArray['accountid'];
        
        $assigns['amount'] = number_format(@$cellsArray['amount'], 2);
        
        $accountArray = FinanceService::Get()->getAccountArray();
        
        $assigns['currency'] = @$accountArray[$accountID]['currencyname'];

        return $this->getContentView()->render($assigns);
    }

}