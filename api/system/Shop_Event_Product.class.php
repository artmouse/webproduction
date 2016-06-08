<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_Event_Product extends Events_Event {

    /**
     * @param ShopProduct $product
     */
    public function setProduct(ShopProduct $product) {
        $this->_product = $product;
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return $this->_product;
    }

    private $_product;

}