<?php

require_once(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$orders = new XShopOrder();
$orders->setOrder('id', 'DESC');
$orders->addWhere('dateto', '0000-00-00 00:00:00', '<>');
while ($x = $orders->getNext()) {
    print "update order #".$x->getId()."\n";

    $x->setDatetoday(DateTime_Object::FromString($x->getDateto())->setFormat('d'));
    $x->setDatetomonth(DateTime_Object::FromString($x->getDateto())->setFormat('m'));
    $x->setDatetoyear(DateTime_Object::FromString($x->getDateto())->setFormat('Y'));

    $x->update();
}