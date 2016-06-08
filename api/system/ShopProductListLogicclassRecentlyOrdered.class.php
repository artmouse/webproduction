<?php

/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Egor Gerasimchuk <milhous@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class ShopProductListLogicclassRecentlyOrdered extends XShopProduct{
    /**
     * @return ShopProduct
     */
    public function getProducts() {
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrder('lastordered', 'DESC');
        $products->setLimitCount(12);
        $products->setHidden(0);
        $products->setDeleted(0);
        return $products;
    }
}