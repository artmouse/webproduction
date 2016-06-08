<?php
$orders = new ShopOrder();
$orders->setType('');
$orders->setOrder('id', 'DESC');
while ($x = $orders->getNext()) {
    $x->setType('order');
    $x->update();
    print "update order #".$x->getId()."\n";
}

print "\n\ndone\n\n";