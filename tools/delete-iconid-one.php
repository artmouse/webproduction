<?php

// удаляет все иконки "бесплатная доставка"
require(dirname(__FILE__) . '/../packages/Engine/include.2.6.php');

$icon = new XShopProduct();
$icon->filterIconid('1');
while ($x = $icon->getNext()) {
    $x->setIconid('0');
    $x->update();
}

print "\n\ndone\n\n";