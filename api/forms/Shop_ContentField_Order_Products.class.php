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
class Shop_ContentField_Order_Products extends Forms_ContentField {

    public function renderView($rowIndex, $cellsArray) {
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $orderID = $cellsArray[$keyPrimary];

        $a = array();

        try {
            $order = Shop::Get()->getShopService()->getOrderByID($orderID);
            $ops = $order->getOrderProducts();

            $index = 1;

            while ($x = $ops->getNext()) {
                $serial = '';
                if ($x->getSerial()) {
                    $serial .= ' (';
                    $serial .= $x->getSerial();
                    $serial .= ')';
                }

                $a[] = $index.'. '.$x->getCategoryname().' '.$x->getProductname().$serial;
                $index ++;
            }
        } catch (Exception $e) {

        }

        return implode(nl2br("\n"), $a);
    }

}