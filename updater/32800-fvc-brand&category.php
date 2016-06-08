<?php
$filtes = new XShopProductFilterValue();
$filtes->addWhere('filterid', '0', '<');
while ($x = $filtes->getNext()) {
    $x->setFilteruse(1);
    $x->update();
}