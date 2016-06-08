<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductListLogicclassOrdered12 {

    /**
     * @return ShopProduct
     */
    public function getProducts() {
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrder('ordered', 'DESC');
        $products->setLimitCount(12);
        $products->setDeleted(0);
        $products->setHidden(0);
        return $products;
    }


}