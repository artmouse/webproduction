<?php
/**
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Finance_ContentField_Payment_Link extends Forms_ContentField {

    public function __construct($keyValue) {
        parent::__construct($keyValue);
        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $linkKey = @$cellsArray['linkkey'];

        try {
            $payment = PaymentService::Get()->getPaymentByID($cellsArray['id']);

            $orderID = $payment->getOrderid();
            $clientID = $payment->getClientid();
        } catch (Exception $e) {
            $orderID = false;
            $clientID = false;
        }

        if ($linkKey) {
            try {
                if (preg_match("/^transfer-(\d+)$/ius", $linkKey, $r)) {

                    $payment = PaymentService::Get()->getPaymentByID($r[1]);

                    $accountArray = FinanceService::Get()->getAccountArray();

                    $assigns['accountname'] = @$accountArray[$payment->getAccountid()]['name'];

                    $assigns['accountURL'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-finance-index',
                    $payment->getAccountid(),
                    'accountid'
                    );

                    $assigns['paymentID'] = $r[1];
                    $assigns['paymentURL'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-finance-payment-control',
                    $payment->getId(),
                    'key'
                    );
                }
            } catch (ServiceUtils_Exception $se) {

            }
        }

        if ($orderID) {
        	try {
        	    $order = Shop::Get()->getShopService()->getOrderByID($orderID);

                $assigns['orderID'] = $order->makeName();
                $assigns['orderURL'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-orders-control',
                $order->getId()
                );
        	} catch (Exception $e) {

        	}
        }

        if ($clientID) {
            try {
                $client = Shop::Get()->getUserService()->getUserByID($clientID);
                $assigns['clientName'] = $client->makeName(true, false);
                $assigns['clientURL'] = $client->makeURLEdit();
                $assigns['clientID'] = $client->getId();
            } catch (ServiceUtils_Exception $se) {

            }
        }

        return $this->getContentView()->render($assigns);
    }

}