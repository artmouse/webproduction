<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopContractor extends XShopContractor {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopContractor
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopContractor
     */
    public static function Get($key) {return self::GetObject('ShopContractor', $key);}

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

}