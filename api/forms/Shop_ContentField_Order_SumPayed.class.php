<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentField_Order_SumPayed extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $orderID = $cellsArray[$keyPrimary];

        try {
            // валюта заказа
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(@$cellsArray['currencyid']);
        } catch (Exception $e) {
            // показываем в валюте которую выбрал пользователь
            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        }

        try {
            $order = Shop::Get()->getShopService()->getOrderByID($orderID);
            return $order->makeSumPaid();
        } catch (Exception $e) {
            return false;
        }
    }

}