<?php
class shop_payment extends Engine_Class {

    public function process() {
        $payments = new ShopPayment();
        $a = array();
        while ($x = $payments->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'description' => $x->getDescription(),
            'image' => $x->makeImageThumb(100),
            );
        }
        $this->setValue('paymentArray', $a);
    }

}