<?php
class block_basket extends Engine_Class {

    public function process() {
        try {
            // передаем содержимое корзины
            $baskets = Shop::Get()->getShopService()->getBasketProducts();
            $a = array();
            $allSum = 0;
            $setSumArray = array();
            $cnt = 0;
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $productIdArray = array(); // для поиска рекомендованных товаров
            while ($x = $baskets->getNext()) {
                try {
                    $p = $x->getProduct();
                    $productIdArray[] = $p->getId();


                    $item['id'] = $x->getId();
                    $item['name'] = $p->getName();
                    $item['url'] = $p->makeURL();
                    $item['image'] = $p->makeImageThumb(56, 56, 'prop');
                    $filter_quantity = false;


                    for ($i = 1; $i <= 10; $i++) {

                        // 10 фильтров в shopbasket
                        // если id=0, а значение !=0, то это фильтр количества
                        if ($x->getField('filter'.$i.'id') == 0 && $x->getField('filter'.$i.'value') != 0) {
                            $filter_quantity = $x->getField('filter' . $i . 'value');
                            continue;
                        }

                        if ($x->getField('filter'.$i.'id')) {

                            try {

                                $name = Shop::Get()->getShopService()->
                                getProductFilterByID($x->getField('filter'.$i.'id'))->getName();

                            } catch (Exception $e) {
                                
                               
                            }


                            $item['option'][] = array(
                                'name' => $name,
                                'value' => $x->getField('filter'.$i.'value')
                            );
                        }
                    }


                    if ($filter_quantity) {
                        $item['count'] =$filter_quantity;
                        $x = new ShopBasket($x->getId());
                        $x->setProductcount($filter_quantity);
                        $x->update();
                    } else {
                        $item['count'] = (float) $x->getProductcount();
                    }

                    $item['price'] = $x->makePrice($currencyDefault);
                    $item['discount'] = $p->getDiscount();
                    $item['currency'] =  $currencyDefault->getSymbol();
                    $item['unit'] = $p->getUnit();


                    if ($x->getActionsetid()) {
                        @$setSumArray[$x->getActionsetid()]['total'] += $x->getActionsetprice()*$x->getActionsetcount();
                        @$setSumArray[$x->getActionsetid()]['one'] += $x->getActionsetprice();
                        @$setSumArray[$x->getActionsetid()]['count'] = $x->getActionsetcount();
                    } else {
                        if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                            if ($personalPrice = PersonalDiscountService::Get()->
                            makePersonalPrice($p, $currencyDefault)) {
                                $personalPrice = $personalPrice['price'];
                                $item['price'] = $personalPrice;
                                $item['sum'] = round($personalPrice * $x->getProductcount(), 2);
                            } else {
                                $item['sum'] = $x->makeSum($currencyDefault);
                            }
                        } else {
                            $item['sum'] = $x->makeSum($currencyDefault);
                        }
                        $allSum += $item['sum'];
                        $cnt += $x->getProductcount();
                    }
                    
                    $a[$x->getActionsetid()][] = $item;
                    unset($item['option']);

                } catch (Exception $e) {

                }

            }




            // добавляем в общую сумму наборы
            foreach ($setSumArray as $sum) {
                $allSum += $sum['total'];
                $cnt += $sum['count'];
            }
            $this->setValue('setSumArray', $setSumArray);
            ksort($a);
            $this->setValue('basketArray', $a);
            $a = Shop::Get()->getShopService()->getRecommendedProductByProductIDArray($productIdArray);
            $this->setValue('recommendedArray', $a);
            $this->setValue('cnt', $cnt);

            // доставка по умолчанию
            $deliveryPrice = 0;
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            $delivery->setDefault(1);
            $delivery = $delivery->getNext();
            if ($delivery) {
                $this->setValue('deliveryName', $delivery->makeName());
                $deliveryPrice = $delivery->makePrice(Shop::Get()->getCurrencyService()->getCurrencySystem());
                $this->setValue('deliveryPrice', round($deliveryPrice, 2));
                if (!$delivery->getPaydelivery()) {
                    $deliveryPrice = 0;
                }
            }

            if ($allSum > 0) {
                $this->setValue('allSum', $allSum + $deliveryPrice);
            } else {
                $this->setValue('allSum', $allSum);
            }

            $this->setValue('currency', $currencyDefault->getSymbol());
        } catch (Exception $ge) {

        }
    }

}