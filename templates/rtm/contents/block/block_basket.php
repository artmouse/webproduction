<?php
class block_basket extends Engine_Class {

    public function process() {
        try {
            // передаем содержимое корзины
            $baskets = Shop::Get()->getShopService()->getBasketProducts();
            $a = array();
            $allSum = 0;
            $cnt = 0;
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();
            while ($x = $baskets->getNext()) {
                try {
                    $p = $x->getProduct();

                    $item['id'] = $x->getId();
                    $item['productId'] = $p->getId();
                    $item['name'] = $p->getName();
                    $item['buyOrEx'] = $x->getBuyOrExchange();
                    $item['count'] = $x->getProductcount();
                    $item['url'] = $p->makeURL();
                    $item['image'] = $p->makeImageThumb(67, 140, 'prop');
                    $item['count'] = (float) $x->getProductcount();
                    $price = $x->getBuyOrExchange() == 'buy' ? $p->makePriceProduct($currencyDefault) : $p->makePrice($currencyDefault);
                    $item['price'] = number_format($price, 0, '.', ' ');
                    $item['discount'] = $p->getDiscount();
                    if ($x->getBuyOrExchange() == 'exchange') {
                        $sum =  $p->makePrice($currencyDefault);
                    } else {
                        $sum = $p->makePriceProduct($currencyDefault);
                    }
                    $productSum = $sum * $x->getProductcount();
                    $item['sum'] = number_format($productSum, 0, '.', ' ');
                    $item['currency'] =  $currencyDefault->getSymbol();
                    $item['unit'] = $p->getUnit() ? $p->getUnit() : 'шт.';
                    $item['articul'] = $p->getCode1c() ? $p->getCode1c() : $p->getId();

                    for ($i = 1; $i <= 10; $i++) {
                        if ($x->getField('filter'.$i.'id')) {
                            $item['option'][] = array(
                                'name' => Shop::Get()->getShopService()->getProductFilterByID($x->getField('filter'.$i.'id'))->getName(),
                                'value' => $x->getField('filter'.$i.'value')
                            );
                        }
                    }

                    $a[] = $item;
                    unset($item['option']);
                    $allSum += $productSum;
                    $cnt += $x->getProductcount();
                } catch (Exception $e) {

                }
            }


            //=================== автоопределение скидки ==================//

            $value = 0;
            $discount = false;
            $discounts = Shop::Get()->getShopService()->getDiscountAll();
            while ($x = $discounts->getNext()) {
                // если скидка может применятся автоматически
                if ($x->getMinstartsum() > 0) {
                    // конвертируем сумму заказа в валюту скидки
                    $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                        $allSum,
                        $currencyDefault,
                        $x->getCurrency());

                    if ($x->getMinstartsum() <= $sumDiscount){
                        // ищем максимально возможную скидку
                        $x_value = $x->makeDiscountValue($allSum, $currencyDefault);
                        if ($x_value > $value){
                            $value = $x_value;
                            $discount = clone $x;
                        }
                    }
                }
            }


            if ($discount) {
                // сумма нашей скидки
                $discountSum = round($discount->makeDiscountValue($allSum, $currencyDefault), 2);
                $this->setValue('discountSum', $discountSum);
                $this->setValue('discountName', $discount->getName() . "(" . $discount->getValue() .
                    (($discount->getType() == 'value')?$currencyDefault->getSymbol():'%'). ")");

                // пересчитываем общую стоимость заказа
                $allSum = $allSum - $discountSum;
            }

            //============================================================//
//print_r($a); exit;

            $this->setValue('basketArray', $a);
            $this->setValue('cnt', $cnt);
            $this->setValue('allSum', number_format(round($allSum), 0, '.', ' '));
            $this->setValue('currency', $currencyDefault->getSymbol());
        } catch (Exception $ge) {

        }
    }

}