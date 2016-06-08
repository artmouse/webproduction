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
class Shop_ContentField_StorageMotion_Actions extends Forms_ContentField {

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
                $storage = StorageService::Get()->getStorageByID($id);
                $code = $storage->getCode();

                $assigns['urlProductHistory'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-storage-motion-product',
                $code,
                'code'
                );

                $assigns['urlProductHistoryName'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_motion_product_history');

                $cuser = Shop::Get()->getUserService()->getUser();

                if ($cuser->isAllowed('storage-motionlog-edit')) {
                    $assigns['urlEdit'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-motion-edit',
                    $id
                    );

                    $assigns['urlEditName'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_edit');
                }

                if ($cuser->isAllowed('storage-motionlog-delete')) {
                    $assigns['urlDelete'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-motion-delete',
                    $id
                    );

                    $assigns['urlDeleteName'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_delete');
                }
            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}