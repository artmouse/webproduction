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
class Shop_ContentField_StorageOrder_Actions extends Forms_ContentField {

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
                $order = StorageOrderService::Get()->getStorageOrderByID($id);
                $cuser = Shop::Get()->getUserService()->getUser();

                if (StorageOrderService::Get()->hasStorageOrderProducts($order)) {
                    if ($order->getType() == 'incoming' && $cuser->isAllowed('storage-incoming')) {
                        $assigns['urlShip'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-storage-order-toincoming',
                        $id
                        );

                        $assigns['actionType'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_incoming_do_short');

                    } elseif ($order->getType() == 'transfer' && $cuser->isAllowed('storage-transfer')) {
                        $assigns['urlShip'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-storage-transfer',
                        $id,
                        'orderid'
                        );

                        $assigns['actionType'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_transfer_post');

                    } elseif ($order->getType() == 'production' && $cuser->isAllowed('storage-production')) {
                        $assigns['urlShip'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-storage-production',
                        $id,
                        'orderid'
                        );

                        $assigns['actionType'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_production');

                    }
                }

                if ($order->getUserid() == $cuser->getId() || $cuser->isAllowed('storage-orders-edit')) {
                    $assigns['urlControl'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-order-control',
                    $id
                    );
                }

                $assigns['urlControlName'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_order_goto');

            } catch (Exception $e) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}