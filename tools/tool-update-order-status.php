<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * если statusid не принадлежит workflowid - то переключать задачу в default status workflow'a
 */

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

try {
    $orders = new ShopOrder();
    $orders->addWhere('statusid', '0', '<>');
    $orders->addWhere('categoryid', '0', '<>');
    $orders->setDateclosed('0000-00-00 00:00:00');
    while ($x = $orders->getNext()) {
        print "order #".$x->getId()."\n";
        try{
            if ($x->getStatus()->getWorkflow()->getId() != $x->getCategoryid()) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    Shop::Get()->getUserService()->getUser(),
                    $x,
                    $x->getWorkflow()->getStatusDefault()->getId()
                );
                print "update #".$x->getId()."\n";

            }
        } catch (Exception $e) {
            // нету статуса
            try{
                Shop::Get()->getShopService()->updateOrderStatus(
                    Shop::Get()->getUserService()->getUser(),
                    $x,
                    $x->getWorkflow()->getStatusDefault()->getId()
                );
                print "update2 #".$x->getId()."\n";
            } catch (Exception $e2) {
                try{
                    $x->setStatusid($x->getWorkflow()->getStatusDefault()->getId());
                    $x->update();
                    print "update3 #".$x->getId()."\n";
                } catch (Exception $e3) {

                }
            }
        }
    }
} catch (Exception $ge) {
    throw $ge;
}

print 'done.';