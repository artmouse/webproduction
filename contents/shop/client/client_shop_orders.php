<?php
class client_shop_orders extends Engine_Class {

    public function process() {

        $orders = Shop::Get()->getShopService()->getOrdersAll();
        $orders->setUserid($this->getUser()->getId());
        $a = array();
        while ($x = $orders->getNext()) {
            try {
                $a[] = array(
                'id' => $x->getId(),
                'sum' => $x->getSum(),
                'currency' => $x->getCurrency()->getSymbol(),
                'status' => $x->getStatus()->getName(),
                'url' => $x->makeURL(),
                'datetime' => $x->makeDate(),
                'manager' => $x->getManagerid() ? $x->getManager()->getName() : '-'
                );
            } catch (Exception $e) {

            }
        }
        $this->setValue('ordersArray', $a);
    }

}