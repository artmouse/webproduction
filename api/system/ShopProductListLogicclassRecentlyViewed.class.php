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
class ShopProductListLogicclassRecentlyViewed {

    /**
     * @return ShopProduct
     */
    public function getProducts() {
        $productviwed = new XShopProductView();
        $productviwed->setOrder('cdate', 'DESC');
        // ставим лимит 50 записей, в таблице хранятся не уникальные значения,
        $productviwed->setLimit(0,50);

        $a = $this->_makeProductsIdArray($productviwed);
        // Проверим, если товаров меньше 12, попробуем добавить еще.
        if (count($a) < $this->_maxCount) {
            $productviwed->setLimit(50,100);
            $a = $this->_makeProductsIdArray($productviwed, $a);
        }

        $str = implode(',', $a);
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setDeleted(0);
        $products->setHidden(0);
        $products->addWhereArray($a);
        $products->setOrderBy("FIELD (`id`,$str)");
        $products->setOrderType('');
        return $products;
    }

    /**
     * @param XShopProductView $productviwed
     * @param array $a
     * @return array
     */
    private function _makeProductsIdArray(XShopProductView $productviwed, $a = array()){
        while ($x = $productviwed->getNext()) {
            $a[$x->getProductid()] = $x->getProductid();
            if (count($a) >= $this->_maxCount) {
                break;
            }
        }
        return $a;
    }

    /**
     * в списке по умолчанию выводим только 12 товаров
     * @var int
     */
    private $_maxCount = 12;
}
