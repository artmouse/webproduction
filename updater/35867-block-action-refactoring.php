<?php
require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

// склад
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('storage-order-status-action-block-product-reserve-auto');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'storageId' => $x->getData(),
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

// закза поставщику
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-supplier-order');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'choise' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

// нова почта
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-admin-action-block-novaposhta-status');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'status' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

// финансы
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('finance-expected-percent-amount');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'percent' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

//box
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-timelog-add');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'minute' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-switch-status');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'status' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-status-change-auto');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'status' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-role');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'role' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-order-closed-by-dateto');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'payment' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-notify-overdue');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'time' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-manager-change');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'manager' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-change-status-overdue-dateto');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'status' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('box-order-status-action-block-auto-transfer');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'nextdate' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

// shop
$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-notification-sms-clients-all');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'text' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-notice-manager-sms');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'text' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-order-status-action-block-notice-client-sms');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'text' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}


$actionBlock = new XShopOrderStatusActionBlockStructure();
$actionBlock->setContentid('shop-issue-status-action-day-move');
while ($x = $actionBlock->getNext()) {
    $getType = gettype(json_decode($x->getData()));
    if (gettype(json_decode($x->getData())) != 'object') {
        print "\nchange ".$x->getContentid();
        $data = array(
            'dateto' => $x->getData()
        );

        $x->setData(json_encode($data));
        $x->update();
    }
}

print "\n\ndone\n\n";