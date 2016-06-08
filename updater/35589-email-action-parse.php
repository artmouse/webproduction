<?php
require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-notice-manager-email');
while ($x = $actionBlock->getNext()) {
    if (gettype(json_decode($x->getData())) == 'NULL') {
        $data = array(
            'type' => '',
            'signature' => '',
            'subject' => '',
            'email' => '',
            'html' => '',
            'text' => $x->getData(),
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-notice-client-email');
while ($x = $actionBlock->getNext()) {
    if (gettype(json_decode($x->getData())) == 'NULL') {
        $data = array(
            'type' => '',
            'signature' => '',
            'subject' => '',
            'email' => '',
            'text' => $x->getData(),
            'html' => '',
            'ordercomment' => ''
        );

        $x->setData(json_encode($data));
        $x->update();
    }

}

print "\n\ndone\n\n";