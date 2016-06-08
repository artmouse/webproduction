<?php
class shop_basket extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');

        // если юзер админ - то давать возможность оформлять заказ на клиента
        $this->setValue('clientsearch', false);
        $isAdmin = false;
        try {
            if ($this->getUser()) {
                $this->setValue('userlevel', $this->getUser()->getLevel());
            }

            if ($this->getUser()->isAdmin()) {
                $isAdmin = true;

                $this->setValue('clientsearch', true);
            }
        } catch (Exception $e) {

        }

        if ($this->getUserSecure()) {
            try {
                $phone = $this->getUser()->getManager()->getPhone();
            } catch (Exception $e) {

            }
        } else {
            // требуется ли наличие авторизации для оформления заказа
            if (Shop::Get()->getSettingsService()->getSettingValue('shop-auth-for-order')) {
                $this->setValue('userIsNotAuthorithed', true);
            }
        }

        if (empty($phone)) {
            $phone = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
        }

        if ($phone) {
            $this->setValue('phone', $phone);
        }

        // очистка корзины
        if ($this->getArgumentSecure('clear')) {
            try {
                Shop::Get()->getShopService()->clearBasket();
                header('Location: .');
            } catch (Exception $ge) {

            }
        }

        // удаляем из корзины массово
        $pdelede = $this->getArgumentSecure('pdelede');
        $selProducts = $this->getArgumentSecure('selproducts');
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
                    $pcount = 1; // Может быть только 1 товар
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

        // если выбран вариант доставки - записываем его в сессию
        $deliveryID = $this->getControlValue('delivery');
        if ($deliveryID) {
            @session_start();
            $_SESSION['delivery'] = $deliveryID;
        }

        // содержимое корзины
        $basketArray = Shop::Get()->getShopService()->getBasketProductsArray();
        $barray = array();
        $allSum = 0;
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();
        $promocode = trim($this->getArgumentSecure('promocode'));
        $this->setValue('promocode', $promocode);
        $discountByPromocode = 0;
        $notAvailProduct = false;
        foreach ($basketArray as $x) {
            try {
                $p = $x->getProduct();
                if (!$p->getAvail()) {
                    $notAvailProduct = true;
                }
                if ($p->getDescriptionshort()) {
                    $description = $p->getDescriptionshort();
                } else {
                    $description = strip_tags($p->getDescription());
                    $description = StringUtils_Limiter::LimitLength($description, 130);
                }
                // если есть промокод то делаем скидку только для первого товара
                if ($promocode and !$discountByPromocode) {

                    try {
                        $discountByPromocode =
                        Shop::Get()->getShopService()->makeDiscountByPromocode($promocode, $p, false);
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
                if ($x->getBuyOrExchange() == 'exchange') {
                    $byuOrExchange = 'Обмен';
                    $sum = $p->makePrice($currencyDefault);
                } else {
                    $byuOrExchange = 'Покупка';
                    $sum = $p->makePriceProduct($currencyDefault);
                }
                $item['price'] = $sum;
                $item['byuOrExchange'] = $byuOrExchange;
                $item['sum'] = $sum * $x->getProductcount();
                $item['urldelete'] = $this->makeURL(array('delete' => $x->getId()));
                $item['currency'] = $currencyDefault->getSymbol();
                $item['unit'] = $p->getUnit();
                $item['articul'] = $p->getCode1c() ? $p->getCode1c() : $p->getId();

                // опции заказа данного товара
                $optionArray = array();
                for ($j = 1; $j <= 10; $j++) {
                    try {
                        $filter = Shop::Get()->getShopService()->getProductFilterByID(
                            $x->getField('filter' . $j . 'id')
                        );

                        $optionArray[] = array(
                            'id' => $filter->getId(),
                            'name' => $filter->getName(),
                            'value' => $x->getField('filter' . $j . 'value'),
                        );
                    } catch (Exception $filterEx) {

                    }
                }
                $item['optionArray'] = $optionArray;

                $barray[] = $item;

                $allSum += $item['sum'];
            } catch (Exception $e) {

            }
        }

        // если есть скидка по промокоду
        if ($discountByPromocode) {
            $this->setValue('discountByPromocode', $discountByPromocode);
            $allSum = $allSum + $discountByPromocode;
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
                'discountName', $discount->getName() . "(" . $discount->getValue() .
                (($discount->getType() == 'value') ? $currencyDefault->getSymbol() : '%') . ")"
            );

            // пересчитываем общую стоимость заказа
            $allSum = $allSum - $discountSum;
        }

        //============================================================//


        $this->setValue('urlclear', $this->makeURL(array('clear' => '1')));

        // варианты доставки
        try {
            $deliveryID = @$_SESSION['delivery'];
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            $a = array();
            while ($d = $delivery->getNext()) {
                // если вариант доставки не выбран - выбираем первый
                if (empty($_SESSION['delivery'])) {
                    @$_SESSION['delivery'] = $d->getId();
                }

                $a[] = array(
                    'id' => $d->getId(),
                    'name' => $d->getName(),
                    'price' => $d->makePrice($currencyDefault),
                    'currency' => $currencyDefault->getSymbol(),
                );
            }
            $this->setValue('deliveryArray', $a);
        } catch (Exception $e) {

        }

        // варианты оплаты (в зависимости от доставки)
        try {
            $payment = Shop::Get()->getShopService()->getPaymentByDeliveryID(
                @@$_SESSION['delivery']
            );
            $payment->setHidden(0);
            $a = array();
            while ($x = $payment->getNext()) {
                if ($notAvailProduct && !$x->getDefault()) {
                    continue;
                }
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'description' => strip_tags($x->getDescription()),
                    'selected' => $x->getDefault()
                );
            }

            // print_r($a);exit;

            $this->setValue('paymentArray', $a);
        } catch (Exception $e) {

        }

        $needcity = true; // необходимо указать город
        $needaddress = true; // необходимо указать адрес

        // увеличиваем стоимость корзины на стоимость доставки
        try {
            $deliveryID = @$_SESSION['delivery'];

            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID(
                $deliveryID
            );

            $deliveryPrice = $delivery->makePrice($currencyDefault);

            $allSum += $deliveryPrice;

            $this->setValue('dprice', $deliveryPrice);
            $needcity = $delivery->getNeedcity();
            $needaddress = $delivery->getNeedaddress();
        } catch (Exception $e) {
            // если юзер еще не опеределился с доставкой - то она 0.00
            $this->setValue('dprice', '0.00');
        }

        $this->setValue('basketArray', $barray);
        $this->setValue('allSum', $allSum);
        $this->setValue('currency', $currencyDefault->getSymbol());
        $this->setValue('needcity', $needcity);
        $this->setValue('needaddress', $needaddress);

        // выбранный по умолчанию вариант доставки
        $this->setControlValue('delivery', @$_SESSION['delivery']);

        // оформляем заказ
        if ($this->getArgumentSecure('authorizedFail')) {
            $this->setValue('authorizedFail', true);
        } elseif ($this->getArgumentSecure('makeorder')) {
            try {
                SQLObject::TransactionStart();

                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                if (!$this->getControlValue('phone')) {
                    throw new ServiceUtils_Exception('phone');
                }

                $address = '';

                if ($needcity) {
                    $address .= trim($this->getControlValue('city'));
                    if ($needaddress && $this->getControlValue('address')) $address .= ', ';
                }

                if ($needaddress) {
                    $address .= trim($this->getControlValue('address'));
                }

                // создаем нового клиента если нужно
                $clientID = false;
                $clientAdd = false;
                try {
                    if ($this->getUser()->isAdmin()) {
                        $clientID = $this->getControlValue('client');
                        $clientAdd = $this->getControlValue('addnewuser');
                    }
                } catch (Exception $ue) {

                }

                // по умолчанию - заказ на себя
                $client = $this->getUserSecure();

                // если сказано создавать нового клиента
                if ($clientAdd) {
                    try {
                        // создаем нового клиента
                        $client = Shop::Get()->getUserService()->addUserClient(
                            $this->getControlValue('name'),
                            $this->getControlValue('login'),
                            $this->getControlValue('pass'),
                            $this->getControlValue('email'),
                            $this->getControlValue('phone'),
                            $address,
                            false, // company
                            false, // time
                            false, // comment admin
                            'checkout', // group type
                            $this->getControlValue('namelast'),
                            $this->getControlValue('namemiddle')
                        );
                        $client->setDistribution(1);
                        $client->update();
                    } catch (ServiceUtils_Exception $e) {
                        $this->setValue('message', 'error');
                        $this->setValue('errorsUserArray', $e->getErrorsArray());
                    }
                } elseif ($clientID) {
                    // если указан ID - то на клиента
                    try {
                        $client = Shop::Get()->getUserService()->getUserByID($clientID);
                    } catch (ServiceUtils_Exception $e) {
                        $this->setValue('message', 'error');
                        $this->setValue('errorsUserArray', $e->getErrorsArray());
                    }
                }

                // issue #35282
                // если клиента нет - все равно его создавать
                if (!$client) {
                    try {
                        $client = Shop::Get()->getUserService()->addUserClient(
                            $this->getControlValue('name'),
                            false, // no login
                            false, // no password
                            $this->getControlValue('email'),
                            $this->getControlValue('phone'),
                            $address,
                            false, // company
                            false, // time
                            false, // comment admin
                            'checkout', // group type
                            $this->getControlValue('namelast'),
                            $this->getControlValue('namemiddle')
                        );
                        $client->setDistribution(1);
                        $client->update();
                    } catch (Exception $clientEx) {

                    }
                }

                // оформляем заказ
                $name = $this->getControlValue('namelast') . " " . $this->getControlValue('name') . " " .
                $this->getControlValue('namemiddle');
                $order = Shop::Get()->getShopService()->makeOrder(
                    $name,
                    $this->getControlValue('phone'),
                    $this->getControlValue('email'),
                    $address,
                    false,
                    $this->getControlValue('comments'),
                    $client,
                    $this->getControlValue('delivery'),
                    $this->getControlValue('payment'),
                    $isAdmin,
                    $promocode
                );

                $this->setValue('basketsum', $order->getSum());
                $this->setValue('basketid', $order->getId());

                $this->setValue('okmessage', true);
                try {
                    $this->setValue(
                        'goodmessage',
                        Shop::Get()->getSettingsService()->getSettingValue('order-good-message')
                    );
                } catch (Exception $gme) {

                }

                try {
                    $paymantid = $this->getControlValue('payment');
                    if ($paymantid) { // если есть способ оплаты
                        $payment = Shop::Get()->getShopService()->getPaymentByID($paymantid);
                        if ($payment->getShowinfo()) {
                            $this->setValue('paymentInfo', $payment->getAdditionalinfo());
                        }
                    }
                } catch (Exception $e) {

                }

                header(
                    'Location: ' .
                    Engine::GetLinkMaker()->makeURLByContentIDParam('shop-thankyou-page', $order->getId(), 'orderid')
                );


                SQLObject::TransactionCommit();
            } catch (ServiceUtils_Exception $se) {
                SQLObject::TransactionRollback();
                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }

                $this->setValue('message', 'error');

                foreach ($se->getErrorsArray() as $e) {
                    try {
                        if ($e == 'name') {
                            $this->setValue('errorName', 'true');
                        }
                        if ($e == 'email') {
                            $this->setValue('errorEmail', 'true');
                        }
                        if ($e == 'phone') {
                            $this->setValue('errorPhone', 'true');
                        }
                        if ($e == 'address') {
                            $this->setValue('errorAddress', 'true');
                        }
                    } catch (Exception $e) {

                    }
                }
            }
        } else {
            // заполняем форму заказа текущими данными
            try {
                if ($this->getUser()->getOrders()) {
                    $lastorder = $this->getUser()->getOrders();
                    $lastorder->setOrder('id', 'DESC');
                    $lastorder = $lastorder->getNext();
                }

                if (is_object($lastorder)) {
                    if ($this->getUser()->getName()) {
                        $this->setControlValue('name', $this->getUser()->getName());
                    } else {
                        $this->setControlValue('name', $lastorder->getClient()->getName());
                    }
                    if ($this->getUser()->getNamelast()) {
                        $this->setControlValue('namelast', $this->getUser()->getNamelast());
                    } else {
                        $this->setControlValue('namelast', $lastorder->getClient()->getNamelast());
                    }
                    if ($this->getUser()->getNamemiddle()) {
                        $this->setControlValue('namemiddle', $this->getUser()->getNamemiddle());
                    } else {
                        $this->setControlValue('namemiddle', $lastorder->getClient()->getNamemiddle());
                    }
                    if ($this->getUser()->getPhone()) {
                        $this->setControlValue('phone', $this->getUser()->getPhone());
                    } else {
                        $this->setControlValue('phone', $lastorder->getClient()->getPhone());
                    }
                    if ($this->getUser()->getEmail()) {
                        $this->setControlValue('email', $this->getUser()->getEmail());
                    } else {
                        $this->setControlValue('email', $lastorder->getClient()->getEmail());
                    }
                }

            } catch (Exception $e) {

            }
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