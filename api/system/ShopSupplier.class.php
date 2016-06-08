<?php
/**
 * OneBox
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class ShopSupplier extends XShopSupplier {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopSupplier
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopSupplier
     */
    public static function Get($key) {
        return self::GetObject('ShopSupplier', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Получить контакт (компанию) поставщика,
     * с которой будут связаны все заказы
     *
     * @return User
     */
    public function getContact() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getContactid()
        );
    }

}