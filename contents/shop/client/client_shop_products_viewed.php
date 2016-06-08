<?php
class client_shop_products_viewed extends Engine_Class {

    public function process() {
        $views = new XShopProductView(); // @todo: service
        $views->setOrder('cdate', 'DESC');
        $views->setUserid($this->getUser()->getId());
        $views->setLimitCount(100);
        $productsIDArray = array(0);
        while ($x = $views->getNext()) {
            $productsIDArray[] = $x->getProductid();
        }
        $productsIDArray = array_unique($productsIDArray);

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->addWhereArray($productsIDArray);

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $this->setValue('products', $render->render());
    }

}