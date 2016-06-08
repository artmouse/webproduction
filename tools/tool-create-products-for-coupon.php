<?php
// создает товары для купонов, у которых их нету
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$coupons = new XShopCoupon();
$coupons->setOrderid(0);
while ($x = $coupons->getNext()) {
    try {
        // ишем продукт
        $product = Shop::Get()->getShopService()->getProductByCode1c('discountCoupon-'.$x->getId());

    } catch (Exception $e) {
        // создаем продукт
        $couponProduct = Shop::Get()->getShopService()->addProduct('Использование скидочного купона');
        $couponProduct->setCode1c('discountCoupon-'.$x->getId());
        if ($x->getCurrencyid()) {
            $couponProduct->setCurrencyid($x->getCurrencyid());
            $couponProduct->setPrice($x->getAmount()*(-1));
        }

        $code = substr_replace($x->getCode(), '-', 4, 0);
        $code = substr_replace($code, '-', 9, 0);
        $code = substr_replace($code, '-', 14, 0);
        $code = strtoupper($code);
        $couponProduct->setLinkkey($code);
        $couponProduct->setHidden(1);
        $couponProduct->update();
        print('new product #'.$couponProduct->getId()." for coupon #".$x->getId()."\n");
    }

}