<?php
exit();

require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$products = Shop::Get()->getShopService()->getProductsAll();
$products->setOrder('id', 'DESC');
while ($x = $products->getNext()) {
    print $x->getId()."\n";

    $name = $x->getName();
    //если есть артикул у продукта - добавить его при формировании URL
    if ($x->getArticul()) {
        $name .=' '.$x->getArticul();
    }
    $url = Shop::Get()->getShopService()->buildURL(trim($name));
    if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
        $url .= '-'.$x->getId();
    }

    if ($url != $x->getUrl()) {
        if ($x->getUrl()) {
            $redirect = new XShopRedirect();
            $redirect->setUrlfrom($x->getUrl());
            $redirect->setUrlto($url);
            $redirect->insert();
        }

        print "New URL = {$url}\n";
        $x->setUrl($url);
        $x->update();
    }
}

print "\n\ndone.\n\n";