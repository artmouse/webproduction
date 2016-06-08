<?php
/**
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_OrderProduct extends Events_Event {

    /**
     * @param ShopOrderProduct $orderProduct
     */
    public function setOrderProduct(ShopOrderProduct $orderProduct) {
        $this->_orderProduct = $orderProduct;
    }

    /**
     * @return ShopOrderProduct
     */
    public function getOrderProduct() {
        return $this->_orderProduct;
    }

    private $_orderProduct;

}