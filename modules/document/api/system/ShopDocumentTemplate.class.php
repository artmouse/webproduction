<?php
/**
 * OneBox
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopDocumentTemplate extends XShopDocumentTemplate {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopDocumentTemplate
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopDocumentTemplate
     */
    public static function Get($key) {
        return self::GetObject('ShopDocumentTemplate', $key);
    }

}