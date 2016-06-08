<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Finance_ContentField_Invoice_Link extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $linkKey = @$cellsArray['linkkey'];

        if ($linkKey) {
            try {
                preg_match("/^order-(\d+)$/ius", $linkKey, $r);

                if (!isset($r[1])) {
                    throw new ServiceUtils_Exception();
                }
                
                $order = Shop::Get()->getShopService()->getOrderByID($r[1]);
                
                $assigns['orderID'] = $r[1];
                $assigns['orderURL'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-orders-control',
                $order->getId(),
                'id'
                );
            } catch (ServiceUtils_Exception $se) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}