<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopProductListLogicclassViewed12 {

    /**
     * GetProducts
     *
     * @return ShopProduct
     */
    public function getProducts() {
        $x = new XShopProductView();

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->leftJoinTable(
            $x->getTablename(),
            $products->getTablename().'.`id` = '.$x->getTablename().'.`productid`'
        );
        $products->addFieldQuery('COUNT('.$x->getTablename().'.`id`) AS product_viewed');
        $products->setOrder('`product_viewed`', 'DESC');
        $products->setLimitCount(12);
        $products->setHidden(0);
        $products->setDeleted(0);
        $products->setGroupByQuery($products->getTablename().'.`id`');
        return $products;
    }

}