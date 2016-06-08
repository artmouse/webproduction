<?php

class sale_page extends Engine_Class {

    public function process() {

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setSale(1);
        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $this->setValue('products', $render->render());

    }
}