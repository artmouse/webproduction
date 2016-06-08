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
class Shop_ContentField_Paid extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        try {
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(@$cellsArray['currencyid']);
        } catch (Exception $e) {
            // показываем в валюте которую выбрал пользователь
            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        }

        $result = -Shop::Get()->getCashService()->calculateCash($this->_pLinkKey.@$cellsArray[$keyPrimary], $currency);
        $result .= '&nbsp;';
        $result .= $currency->getName();

        return $result;
    }

    public function setPaylinkkey($key) {
        $this->_pLinkKey = $key;
    }

    private $_pLinkKey;

}