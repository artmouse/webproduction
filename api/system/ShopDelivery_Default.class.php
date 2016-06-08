<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class ShopDelivery_Default {

    public function __construct(ShopDelivery $delivery) {
        $this->_delivery = $delivery;
    }

    public function process() {

    }

    public function getDeliveryContentId () {
        return 'block-delivery-default';
    }

    private $_delivery = 0;

}
