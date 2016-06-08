<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$orders = new ShopOrder();
$orders->setOutcoming(1);
$orders->addWhere('sum', 0, '>');

while ($order = $orders->getNext()) {
    $order->setSum($order->getSum() * (-1));
    $order->update();
    print "update order #".$order->getId()."\n";
}

print "\n\ndone.\n\n";