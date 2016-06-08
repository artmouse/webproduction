<?php
// во всех заказах проставить дефолтный статус в таблице shoporderchange
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$order = new ShopOrder();
$order->addWhere('categoryid', '0', '!=');
while ($x = $order->getNext()) {
    try{
        if ($x->getWorkflow()->getStatusDefault()->getId()) {
            $change = new XShopOrderChange();
            $change->setOrderid($x->getId());
            $change->setCdate($x->getCdate());
            $change->setKey('statusid');
            $change->setValue($x->getWorkflow()->getStatusDefault()->getId());
            $change->insert();
            print "order #".$x->getId()."\n";

        }
    } catch (Exception $e) {
        print "order #".$x->getId()."catch \n";
    }

}

print "\n\ndone\n\n";