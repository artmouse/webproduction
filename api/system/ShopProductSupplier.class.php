<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductSupplier extends XShopProductSupplier {
    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующий объект
     *
     * @return ShopProductSupplier
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить объект
     *
     * @return ShopProductSupplier
     */
    public static function Get($key) {
        return self::GetObject('ShopProductSupplier', $key);
    }
}