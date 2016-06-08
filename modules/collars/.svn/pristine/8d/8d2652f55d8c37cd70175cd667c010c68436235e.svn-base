<?php
class block_delivery_default extends Engine_Class {

    public function process() {
        try {
            $deliveryID = $this->getValue('id');
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($deliveryID);
            $this->setValue('needaddress', $delivery->getNeedaddress());
            $this->setValue('needcountry', $delivery->getNeedcountry());
            $this->setValue('needcity', $delivery->getNeedcity());
        } catch (Exception $e) {

        }
    }

}