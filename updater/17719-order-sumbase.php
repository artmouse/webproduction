<?php
// во всех заказах посчитать сумму в системной валюте
$currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

$order = new ShopOrder();
$order->setOrder('id', 'DESC');
$order->addWhere('sum', '0', '!=');
$order->setSumbase(0);
while ($x = $order->getNext()) {
    print "order #".$x->getId()."\n";

    $x->setSumbase(
        Shop::Get()->getCurrencyService()->convertCurrency(
            $x->getSum(),
            $x->getCurrency(),
            $currencyDefault
        )
    );

    $x->update();
}