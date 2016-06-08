<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProject extends XShopProject {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProject
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProject
     */
    public static function Get($key) {
        return self::GetObject('ShopProject', $key);
    }

    public function makeName($escape = true) {
        if ($escape) {
            return htmlspecialchars($this->getName());
        } else {
            return $this->getName();
        }
    }

    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'issue-index',
        $this->getId(),
        'projectid'
        );
    }

}