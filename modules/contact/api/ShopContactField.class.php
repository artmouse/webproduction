<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopContactField extends XShopContactField {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Get
     *
     * @return ShopContactField
     */
    public static function Get($key) {
        return self::GetObject("User", $key);
    }

    /**
     * Next
     *
     * @return ShopContactField
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    public function insert() {
        // если ключа нет - автоматически его заполняем
        if (!$this->getIdkey()) {
            $key = StringUtils_Transliterate::TransliterateRuToEn($this->getName());
            $key = str_replace(' ', '', $key);
            $this->setIdkey($key);
        }
        return parent::insert();
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

}