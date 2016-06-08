<?php
class shop_basket extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');

        try {
            if ($this->getUser()) {
                $this->setValue('userlevel', $this->getUser()->getLevel());
            }
        } catch (Exception $e) {

        }
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // очистка корзины
        if ($this->getArgumentSecure('clear')) {
            try {
                Shop::Get()->getShopService()->clearBasket();
                header('Location: .');
            } catch(Exception $ge) {

            }
        }

        // удаляем из корзины массово
        $pdelede = $this->getArgumentSecure('pdelede');
        $selProducts = $this->getArgumentSecure('selproducts');
        $setProducts = $this->getArgumentSecure('setproducts');
        if ($pdelede && $selProducts) {
            $deletepr = false;
            foreach ($selProducts as $val) {
                try {
                    Shop::Get()->getShopService()->deleteFromBasket($val);
                    $deletepr = true;
                } catch (Exception $e) {
                    
                }
            }
        }

        if ($pdelede && $setProducts) {
            foreach ($setProducts as $val) {
                try {
                    Shop::Get()->getShopService()->deleteSetFromBasket($val);
                } catch (Exception $e) {

                }
            }
        }

        // добавляем в корзину
        if ($this->getControlValue('addproduct') && !$this->getControlValue('refresh')) {
            $addproduct = $this->getControlValue('addproduct');

            if ($addproduct) {
                $addProductCount = $this->getArgumentSecure('addproductcount');
                $addProductCount = str_replace(',', '.', $addProductCount);
                $addProductCount = (float) $addProductCount;

                try {
                    // добавляем обычный товар
                    Shop::Get()->getShopService()->addToBasket($addproduct, $addProductCount);
                } catch (Exception $e) {

                }
            }

        }

        // удаляем из корзины поштучно
        $deleteID = $this->getArgumentSecure('delete');
        if ($deleteID) {
            try {
                Shop::Get()->getShopService()->deleteFromBasket($deleteID);
                header("Location: .");
            } catch (Exception $e) {

            }
        }

        // удаляем набор
        $deleteSetID = $this->getArgumentSecure('deleteset');
        if ($deleteSetID) {
            try {
                Shop::Get()->getShopService()->deleteSetFromBasket($deleteSetID);
                header("Location: .");
            } catch (Exception $e) {

            }
        }

        // пересчитываем корзину (количество и опции товара)
        $pchcount = $this->getArgumentSecure('pchcount');
        if ($pchcount && $selProducts) {

            foreach ($selProducts as $basketID) {
                // количество
                try {
                    $pcount = $this->getArgumentSecure('pcount_' . $basketID);
                    Shop::Get()->getShopService()->changeBasketCount($basketID, $pcount);
                } catch (Exception $e) {

                }

                // опции товара
                $argumentArray = $this->getArguments();
                foreach ($argumentArray as $key => $value) {
                    if (preg_match("/^option-{$basketID}-(\d+)$/ius", $key, $r)) {
                        Shop::Get()->getShopService()->changeBasketOption($basketID, $r[1], $value);
                    }
                }
            }
        }

        // пересчёт наборов
        if ($pchcount && $setProducts) {
            foreach ($setProducts as $setID) {
                // количество
                try {
                    $pcount = $this->getArgumentSecure('setcount_' . $setID);
                    Shop::Get()->getShopService()->changeSetBasketCount($setID, $pcount);
                } catch (Exception $e) {

                }

                // опции товара
                $argumentArray = $this->getArguments();
                foreach ($argumentArray as $key => $value) {
                    if (preg_match("/^option-{$basketID}-(\d+)$/ius", $key, $r)) {
                        Shop::Get()->getShopService()->changeBasketOption($basketID, $r[1], $value);
                    }
                }
            }
        }

        // ловим купон
        $couponCode = trim($this->getArgumentSecure('coupon'));
        if ($couponCode) {
            $couponReturn = Shop::Get()->getShopService()->addCouponToBasket($couponCode);
            if ($couponReturn == 'couponUse') {
                // использован
                $this->setValue('couponUse', true);
            } elseif ($couponReturn == 'couponCodeFalse') {
                // не верный код
                $this->setValue('couponCodeFalse', true);
            }
        }

        // содержимое корзины
        $basketArray = Shop::Get()->getShopService()->getBasketProductsArray();
        $barray = array();
        $allSum = 0;
        $setSumArray = array();
        if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
            // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
            $personalSum = array();
        }
        $productIdArray = array(); // для поиска рекомендованных товаров
        foreach ($basketArray as $x) {
            try {
                $p = $x->getProduct();
                $productIdArray[] = $p->getId();
                if ($p->getDescriptionshort()) {
                    $description = $p->getDescriptionshort();
                } else {
                    $description = strip_tags($p->getDescription());
                    $description = StringUtils_Limiter::LimitLength($description, 130);
                }

                $couponCode = false;
                if (strpos($p->getCode1c(), 'discountCoupon-') === 0 && !$x->getActionsetid()) {
                    $couponID = $x->getId();
                    Shop::Get()->getShopService()->deleteFromBasket($couponID);
                    try{
                        $couponId = str_replace('discountCoupon-', '', $p->getCode1c());
                        if ($couponId > 0) {
                            $coupon = new XShopCoupon($couponId);
                            if ($coupon && $coupon->getCode()) {
                                $couponCode = $coupon->getCode();
                                $couponCode = substr_replace($couponCode, '-', 4, 0);
                                $couponCode = substr_replace($couponCode, '-', 9, 0);
                                $couponCode = substr_replace($couponCode, '-', 14, 0);
                                $couponCode = strtoupper($couponCode);
                            }
                            if (!$coupon->getCurrencyid()) {
                                $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
                                $couponPrice = Shop::Get()->getShopService()->getBasketSum()*$coupon->getAmount() / 100;
                                $p->setPrice($couponPrice * (-1));
                                $p->setCurrencyid($currencyDefault->getId());
                                $p->update();
                            }
                            Shop::Get()->getShopService()->addToBasket($p->getId(), 1);

                            $this->setValue('couponCode', $couponCode);
                        }

                        $this->setValue('couponCode', $couponCode);
                    } catch (Exception $e) {

                    }

                }

                $item['id'] = $x->getId();
                $item['name'] = $p->getName();
                $item['productid'] = $p->getId();
                $item['description'] = $description;
                $item['pUrl'] = $p->makeURL();
                $item['image'] = $p->makeImageThumb(80, 56, 'prop');
                $item['count'] = (float) $p->getCountWithDivisibility($x->getProductcount());
                $item['price'] = $x->makePrice($currencyDefault, true);
                $item['urldelete'] = $this->makeURL(array('delete' => $x->getId()));
                $item['currency'] = $currencyDefault->getSymbol();
                $item['unit'] = $p->getUnit();
                $item['articul'] = $p->getCode1c() ? $p->getCode1c() : $p->getId();

                if ($x->getActionsetid()) { // позиция набора
                    $item['sum'] = 0;
                    $item['urldelete'] = $this->makeURL(array('deleteset' => $x->getActionsetid()));
                    @$setSumArray[$x->getActionsetid()]['total'] += $x->getActionsetprice()*$x->getActionsetcount();
                    @$setSumArray[$x->getActionsetid()]['one'] += $x->getActionsetprice();
                    @$setSumArray[$x->getActionsetid()]['count'] = $x->getActionsetcount();
                } else {
                    if (isset($personalSum)) {
                        if ($personalPrice = PersonalDiscountService::Get()->makePersonalPrice($p, $currencyDefault)) {
                            $personalPrice = $personalPrice['price'];
                            $item['price'] = $personalPrice;
                            $item['sum'] = round($personalPrice * $x->getProductcount(), 2);
                            $personalSum[$p->getId()] = $item['sum'];
                        } else {
                            $item['sum'] = $x->makeSum($currencyDefault);
                        }
                    } else {
                        $item['sum'] = $x->makeSum($currencyDefault);
                    }
                    $item['coupon'] = strpos($p->getCode1c(), 'discountCoupon-') === 0 ? true : false;

                    // опции заказа данного товара
                    $optionArray = array();
                    for ($j = 1; $j <= 10; $j++) {
                        try {
                            $filter = Shop::Get()->getShopService()->getProductFilterByID(
                                $x->getField('filter'.$j.'id')
                            );

                            $valueArray = array();
                            
                            // допустимые значения для данного товара
                            $filterValue = new XShopProductFilterValue();
                            $filterValue->setFilterid($filter->getId());
                            $filterValue->setProductid($p->getId());
                            $filterValue->setFilteroption(1);
                            while ($tmpFilterValue = $filterValue->getNext()) {
                                if (!$tmpFilterValue->getFiltervalue()) {
                                    continue;
                                }

                                $valueArray[] = $tmpFilterValue->getFiltervalue();
                            }

                            $optionArray[] = array(
                                'id' => $filter->getId(),
                                'name' => $filter->getName(),
                                'valueArray' => $valueArray,
                                'selectedValue' => $x->getField('filter'.$j.'value'),
                            );
                        } catch (Exception $filterEx) {

                        }
                    }

                    $item['optionArray'] = $optionArray;
                }

                $barray[$x->getActionsetid()][] = $item;
                if (!$x->getActionsetid() && empty($personalSum[$p->getId()])) {
                    $allSum += $item['sum'];
                }

            } catch (Exception $e) {

            }
        }

        $this->setValue(
            'recommendedArray',
            Shop::Get()->getShopService()->getRecommendedProductByProductIDArray($productIdArray)
        );

        // доставка по умолчанию
        $deliveryPrice = 0;
        $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
        $delivery->setDefault(1);
        $delivery = $delivery->getNext();
        if ($delivery) {
            $this->setValue('deliveryName', $delivery->makeName());
            $deliveryPrice = $delivery->makePrice(Shop::Get()->getCurrencyService()->getCurrencySystem());
            $this->setValue('deliveryPrice', $deliveryPrice);
            if (!$delivery->getPaydelivery()) {
                $deliveryPrice = 0;
            }
        }

        // сумма стоимости всех товаров (без скидок)
        $allSumTotal = $allSum;

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
                    $x->getCurrency()
                );

                if ($x->getMinstartsum() <= $sumDiscount) {
                    // ищем максимально возможную скидку
                    $x_value = $x->makeDiscountValue($allSum, $currencyDefault);
                    if ($x_value > $value) {
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
            $this->setValue(
                'discountName',
                $discount->getName() . "(" . $discount->getValue() .
                (($discount->getType() == 'value')?$currencyDefault->getSymbol():'%'). ")"
            );

            // пересчитываем общую стоимость заказа
            $allSum = $allSum - $discountSum;
        }
        //============================================================//

        // добавляем в общую сумму наборы
        foreach ($setSumArray as $sum) {
            $allSum += $sum['total'];
            $allSumTotal += $sum['total'];
        }

        // добавляем в общую сумму товары с персональной скидкой
        if (!empty($personalSum)) {
            foreach ($personalSum as $sum) {
                $allSum += $sum;
                $allSumTotal += $sum;
            }
        }

        $this->setValue('allSumTotal', $allSumTotal);
        $this->setValue('setSumArray', $setSumArray);

        $this->setValue('urlclear', $this->makeURL(array('clear' => '1')));

        if ($allSum < 0) {
            $allSum = 0;
        }

        ksort($barray);
        $this->setValue('basketArray', $barray);
        if ($allSum > 0) {
            $this->setValue('allSum', $allSum + $deliveryPrice);
        } else {
            $this->setValue('allSum', $allSum);
        }

        $this->setValue('currency', $currencyDefault->getSymbol());

        if ($this->getArgumentSecure('makeOrder')) {
            header('Location: makeorder/');
        }
        // настройки
        $this->setValue('used_user_info', Shop::Get()->getSettingsService()->getSettingValue('used-user-info'));

        if (empty($barray)) {
            // списки товаров
            $this->_makeListsArray();
        }

    }

    /**
     * Построить списки товаров как на главной
     *
     * @return array
     */
    private function _makeListsArray() {
        // получаем все списки для главной страницы
        $lists = Shop::Get()->getShopService()->getProductsListAll();
        $lists->setHidden(0);
        $lists->setShowinmain(1);

        $a = array(); // carousel
        $b = array(); // tabs
        while ($x = $lists->getNext()) {
            try {
                $showtype = $x->getShowtype();
                if (!$showtype) {
                    $showtype = 'carousel';
                }

                $l['id'] = $x->getId();
                $l['name'] = $x->makeName();
                $l['html'] = $x->render();

                if ($showtype == 'carousel') {
                    $a[] = $l;
                } else {
                    $b[] = $l;
                }

            } catch (Exception $e) {

            }
        }

        $this->setValue('carouselArray', $a);
        $this->setValue('tabsArray', $b);
    }

}