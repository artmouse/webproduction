<?php
/**
 * WebProduction
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Document_ContentField_LinkKey extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $rowIndex=$rowIndex;
        $assigns = array();

        $linkKey = @$cellsArray['linkkey'];

        if ($linkKey) {
            preg_match("/^ShopOrder-(\d+)$/ius", $linkKey, $r);

            if (isset($r[1])) {
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($r[1]);

                    $assigns['orderID'] = $r[1];
                    
                    if ($order->getName()) {
                        $assigns['orderName'] = $order->getName();
                    }
                    $assigns['orderURL'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-orders-control',
                        $order->getId(),
                        'id'
                    );

                } catch (ServiceUtils_Exception $se) {

                }
            } else {
                preg_match("/^User-(\d+)$/ius", $linkKey, $r);

                if (isset($r[1])) {
                    try {
                        $user = Shop::Get()->getUserService()->getUserByID($r[1]);

                        $assigns['userName'] = $user->makeName(true, true);
                        $assigns['userURL'] = $user->makeURLEdit();
                        $assigns['userID'] = $user->getId();

                    } catch (ServiceUtils_Exception $se) {

                    }
                }
            }

        }

        return $this->getContentView()->render($assigns);
    }

}