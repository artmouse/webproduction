<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$orders = new ShopOrder();
$orders->setAuthorid(0);
while ($x = $orders->getNext()) {
	$x->setAuthorid(1);
	$x->update();
}

print "\n\ndone.\n\n";