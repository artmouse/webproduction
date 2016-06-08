<?php
/**
 * OneBox
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class ShopCompare extends XShopCompare {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopCompare
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * Получить товар
     *
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID(
        $this->getProductid()
        );
    }

}