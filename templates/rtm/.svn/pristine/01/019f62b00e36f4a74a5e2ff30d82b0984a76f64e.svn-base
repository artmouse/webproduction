<?php

set_time_limit(0);
include dirname(__FILE__)."/../../../packages/Engine/include.2.6.php";

$products = Shop::Get()->getShopService()->getProductsAll();
$products->setOrder('id');
while($p = $products->getNext()) {
    echo $p->getId()."\n";
    if (substr_count($p->getDescriptionshort(),'Артикул:')) {
        $x = preg_replace('#(Артикул: (.+?))\|#u','<span class="artikul">${1}</span>|',$p->getDescriptionshort());
        $p->setDescriptionshort($x);
        $p->update();
    }
    if (substr_count($p->getDescriptionshort(),'г.')) {
        $p->setDescriptionshort(mb_str_replace('г.','г',$p->getDescriptionshort()));
        $p->update();
    }
}

function mb_str_replace($needle, $replacement, $haystack) {
    return implode($replacement, mb_split($needle, $haystack));
}