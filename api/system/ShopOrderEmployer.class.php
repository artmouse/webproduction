<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class ShopOrderEmployer extends XShopOrderEmployer {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopOrderEmployer
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopOrderEmployer
     */
    public static function Get($key) {
        return self::GetObject('ShopOrderEmployer', $key);
    }
    
    /**
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID($this->getManagerid());
    }

}