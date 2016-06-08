<?php

require(dirname(__FILE__).'/../../../packages/Engine/include.2.6.php');

$type = @$argv[1];
$id = (int) @$argv[2];

if (!$type) {
    print "\ntype empty\n";
    exit;
}

if ($type != 'order' && $type != 'user' && $type != 'storage') {
    print "\nsupported type: order / user / storage\n";
    exit;
}

if (!$id) {
    print "\nid empty\n";
    exit;
}

try{
    if ($type == 'order') {
        $order = Shop::Get()->getShopService()->getOrderByID($id);
        print_r($order->makeAssignArrayForDocument());
        exit;
    } elseif ($type == 'user') {
        $user = Shop::Get()->getUserService()->getUserByID($id);
        print_r($user->makeAssignArrayForDocument());
        exit;
    } elseif ($type == 'storage') {
        $storage = new ShopStorageTransaction($id);
        print_r($storage->makeAssignArrayForDocument(true));
        exit;
    }
} catch (Exception $e) {
    print "\n\nFATAL (\n\n";
    exit;
}

print "\n\ndone.\n\n";