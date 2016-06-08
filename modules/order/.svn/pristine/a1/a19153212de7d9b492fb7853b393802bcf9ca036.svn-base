<?php
class ajax_orders_products_sort extends Engine_Class {

    public function process() {
        $orderId = $this->getArgumentSecure('orderId');
        $productsIdArray = $this->getArgumentSecure('productsIdArray', 'array');

        try {
            $i = 1;
            SQLObject::TransactionStart();
            foreach ($productsIdArray as $productId) {
                $orderProduct = new ShopOrderProduct();

                $orderProduct->setOrderid($orderId);
                $orderProduct->setProductid($productId);
                if ($orderProduct->select()) {
                    $orderProduct->setSortable($i);
                    $orderProduct->update();
                    $i++;
                }
            }
            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
        }

    }

}