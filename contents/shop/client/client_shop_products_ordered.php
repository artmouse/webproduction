<?php
class client_shop_products_ordered extends Engine_Class {

    public function process() {
        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->setUserid($this->getUser()->getId());
        $ordersIDArray = array(0);
        while ($order = $orders->getNext()) {
            $ordersIDArray[] = $order->getId();
        }

        $orderProducts = new ShopOrderProduct();
        $orderProducts->addWhereArray($ordersIDArray, 'orderid');
        $a = array(0);
        while ($op = $orderProducts->getNext()) {
            $a[] = $op->getProductid();
        }
        $a = array_unique($a);

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->addWhereArray($a);

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $this->setValue('products', $render->render());
    }

}