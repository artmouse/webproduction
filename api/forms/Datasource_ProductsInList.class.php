<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_ProductsInList extends Datasource_Products {

    public function __construct($list = false) {
        if ($list) {
            $this->_list = $list;
        }
    }

    /**
     * @return ShopProduct
     */
    public function getSQLObject() {
        if (isset($this->_list)) {
            return $this->_list->getProducts();
        } else {
            return Shop::Get()->getShopService()->getProductsAll();
        }
    }

    /**
     * @var ShopProductList
     */
    private $_list;

}