<?php
$orders = new ShopOrder();
$orders->filterLinkkey('box-sync-%', 'LIKE');
while ($x = $orders->getNext()) {
    $x->setLinkkey('');
    $x->update();
}