<?php
$workflows = new ShopOrderCategory();
$workflows->setType('');
while ($workflow = $workflows->getNext()) {
    if ($workflow->getIssue()) {
        $workflow->setType('issue');
    } else {
        $workflow->setType('order');
    }
    $workflow->update();
}

$orders = new ShopOrder();
$orders->setType('');
$orders->setOrder('id', 'DESC');
while ($order = $orders->getNext()) {
    print $order->getId()."\n";

    try {
        $type = $order->getWorkflow()->getType();
    } catch (Exception $e) {
        $type = false;
    }

    if (!$type) {
        $type = 'order';
    }

    $order->setType($type);
    $order->update();
}

print "\n\ndone.\n\n";