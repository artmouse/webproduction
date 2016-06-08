<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Extends ShopSource
 * @copyright WebProduction
 * @package Shop
 */
class ShopSource extends XShopSource {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующий объект
     *
     * @return ShopSource
     */
    public function getNext($exception = false) {
        $exception = false;
        return parent::getNext($exception);
    }

    /**
     * Получить объект по ID
     *
     * @return ShopSource
     */
    public static function Get($key) {
        return self::GetObject('ShopSource', $key);
    }

    /**
     * Построить имя
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

}