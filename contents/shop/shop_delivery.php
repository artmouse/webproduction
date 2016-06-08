<?php
class shop_delivery extends Engine_Class {

    public function process() {
        $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
        $a = array();
        while ($x = $delivery->getNext()) {
            try {
                $currencyName = $x->getCurrency()->getName();
            } catch (Exception $e) {
                $currencyName = false;
            }

            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'description' => $x->getDescription(),
            'price' => $x->getPrice(),
            'currency' => $currencyName,
            'image' => $x->makeImageThumb(100),
            );
        }
        $this->setValue('deliveryArray', $a);
    }

}