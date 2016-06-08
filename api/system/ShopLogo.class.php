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
class ShopLogo extends XShopLogo {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopLogo
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopLogo
     */
    public static function Get($key) {
        return self::GetObject('ShopLogo', $key);
    }

    public function makeImage() {
        $src = MEDIA_DIR.'/shop/'.$this->getFile();
        return $src;
    }

}