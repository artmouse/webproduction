<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductList extends XShopProductList {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductList
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProduct
     */
    public function getProducts() {
        return Shop::Get()->getShopService()->getProductsInList($this);
    }

    /**
     * @return string
     */
    public function makeName() {
        if ($this->getNameshort()) {
            return htmlspecialchars($this->getNameshort());
        }
        return htmlspecialchars($this->getName());
    }

    /**
     * Отрисовать список в HTML
     *
     * @uses Engine
     * @return string
     */
    public function render(ShopProduct $products = null) {
        // получаем товары списка
        if ($products == null) {
            $products = $this->getProducts();
            $products->setAvail(1);
        }

        $showtype = $this->getShowtype();
        if (!$showtype) {
            $showtype = 'carousel';
        }

        if ($showtype == 'carousel') {
            // показываем список каруселью
            $render = Engine::GetContentDriver()->getContent('shop-product-carousel');
            $render->setValue('products', $products);
            $render->setValue('autoplay', $this->getAutoplay());
            $render->setValue('name', $this->getName());
            $html = $render->render();
        } else {
            // показываем через shop-product-list
            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $render->setValue('nofilters', true);
            $render->setValue('nostepper', true);
            $render->setValue('showtype', $showtype);
            $html = $render->render();
        }

        return $html;
    }

}