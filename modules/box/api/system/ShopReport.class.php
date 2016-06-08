<?php
/**
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopReport extends XShopReport {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopReport
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopReport
     */
    public static function Get($key) {
        return self::GetObject('ShopReport', $key);
    }

    /**
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }
}