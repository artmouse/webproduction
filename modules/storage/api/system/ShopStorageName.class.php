<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopStorageName extends XShopStorageName {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopStorageName
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopStorageName
     */
    public static function Get($key) {
        return self::GetObject('ShopStorageName', $key);
    }

    /**
     * @return ShopStorage
     */
    public function getStorageRecords() {
        return StorageService::Get()->getStoragesByStorageName($this);
    }

    public function makeURLMotionlog() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-storage-motion-list',
        $this->getId(),
        'storagenameid'
        );
    }

}