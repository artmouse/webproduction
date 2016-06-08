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
class Shop_ContentFieldToTransfer extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();
        $key = $this->getKey();
        $keyPrimary = $this->getDataSourceGroup()->getFieldPrimary()->getKey();

        $id = @$cellsArray[$keyPrimary];
        if ($id) {
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $storage = Shop::Get()->getStorageService()->getStorageByID($id);

                $transfer = new ShopStorageTransfer();
                $transfer->setUserid($user->getId());
                if ($transfer = $transfer->getNext()) {
                    if ($transfer->getStoragenameid() != $storage->getStoragenameid()) {
                        throw new ServiceUtils_Exception();
                    }
                }

                $assigns['url'] = Engine::GetLinkMaker()->makeURLByContentIDParams(
                'shop-admin-storage-transfer',
                array(
                'id' => $id
                ));
            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}