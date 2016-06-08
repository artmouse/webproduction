<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$product = Shop::Get()->getShopService()->getProductsAll();
while ($x = $product->getNext()) {
    if (substr_count($x->getName(), '&nbsp;')) {
        print 'NBSP '.$x->getId()."\n";

        $x->setName(str_replace('&nbsp;', '', $x->getName()));
        $x->update();
    }

    if (substr_count($x->getName(), '&quot;')) {
        print 'QUOT '.$x->getId()."\n";

        $x->setName(str_replace('&quot;', '', $x->getName()));
        $x->update();
    }

    if (strip_tags($x->getName()) != $x->getName()) {
        print 'TAGS '.$x->getId()."\n";
    }
}

print "\n\ndone\n\n";