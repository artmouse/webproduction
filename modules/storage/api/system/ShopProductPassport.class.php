<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductPassport extends XShopProductPassport {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductPassport
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProductPassport
     */
    public static function Get($key) {
        return self::GetObject('ShopProductPassport', $key);
    }

    /**
     * @return ShopProductPassportItem
     */
    public function getItems() {
        return StorageProductionService::Get()->getProductPassportItemsByPassport($this);
    }

}