<?php
class shop_basket_makeorder extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryTabs.js');

        if (!$this->getUserSecure()) {
            // требуется ли наличие авторизации для оформления заказа
            if (Shop::Get()->getSettingsService()->getSettingValue('shop-auth-for-order')) {
                $this->setValue('userIsNotAuthorithed', true);
            }
        }

        $basketArray = Shop::Get()->getShopService()->getBasketProductsArray();
        $barray = array();
        $allSum = 0;
        $setSumArray = array(); // для суммы по наборам (на неё не накладывается общая скидка)
        if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
            // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
            $personalSum = array();
        }
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        foreach ($basketArray as $x) {
            try {
                $p = $x->getProduct();
                $item['id'] = $x->getId();
                $item['name'] = $p->getName();
                $item['productid'] = $p->getId();
                $item['pUrl'] = $p->makeURL();
                $item['image'] = $p->makeImageThumb(80, 56, 'prop');
                $item['count'] = (float) $p->getCountWithDivisibility($x->getProductcount());
                $item['price'] = $x->makePrice($currencyDefault, true);
                $item['currency'] = $currencyDefault->getSymbol();
                $item['unit'] = $p->getUnit();

                if ($x->getActionsetid()) { // позиция набора
                    $item['sum'] = 0;
                    @$setSumArray[$x->getActionsetid()]['total'] += $x->getActionsetprice()*$x->getActionsetcount();
                    @$setSumArray[$x->getActionsetid()]['one'] += $x->getActionsetprice();
                    @$setSumArray[$x->getActionsetid()]['count'] = $x->getActionsetcount();
                } else {
                    if (isset($personalSum)) {
                        $personalPrice = PersonalDiscountService::Get()->makePersonalPrice($p, $currencyDefault);
                        if ($personalPrice) {
                            $personalPrice = $personalPrice['price'];
                            $item['price'] = $personalPrice;
                            $item['sum'] = round($personalPrice * $x->getProductcount(), 2);
                            $personalSum[$p->getId()] = $item['sum'];
                        } else {
                            $item['sum'] = $x->makeSum($currencyDefault);
                            $allSum += $item['sum'];
                        }
                    } else {
                        $item['sum'] = $x->makeSum($currencyDefault);
                        $allSum += $item['sum'];
                    }
                }

                $barray[$x->getActionsetid()][] = $item;

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
                (($discount->getType() == 'value')?$currencyDefault->getSymbol():'%'). ")"
            );

            // пересчитываем общую стоимость заказа
            $allSum = $allSum - $discountSum;
        }

        // добавляем в общую сумму наборы
        foreach ($setSumArray as $sum) {
            $allSum += $sum['total'];
        }

        // добавляем в общую сумму товары с персональной скидкой
        if (!empty($personalSum)) {
            foreach ($personalSum as $sum) {
                $allSum += $sum;
            }
        }

        $this->setValue('setSumArray', $setSumArray);

        //============================================================//

        if ($allSum < 0) {
            $allSum = 0;
        }

        $this->setValue('allSum', round($allSum, 2));
        ksort($barray);
        $this->setValue('basketArray', $barray);

        $this->setValue('clientsearch', false);

        $needcity = false; // необходимо указать город
        $needaddress = false; // необходимо указать адрес
        $needCountry = false;

        // варианты доставки
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $a = array();
        try {
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            $count = 0;
            while ($d = $delivery->getNext()) {
                // если вариант доставки не выбран - выбираем первый
                if (empty($_SESSION['delivery'])) {
                    @$_SESSION['delivery'] = $d->getId();
                }

                $logicClassPrice = false;
                if ($logicclass = $d->getLogicclass()) {
                    try {
                        if (class_exists($logicclass)) {
                            $processor = new $logicclass($d);
                            $logicClassPrice = $processor->process($basketArray, $discount, $allSum);
                            
                        }

                    } catch (Exception $statusEx) {

                    }
                }

                if ($d->getDefault()) {
                    $this->setValue('deliveryDefault', $d->getId());
                }
                if (!$logicClassPrice) {
                    $logicClassPrice = $d->makePrice($currencyDefault);
                }
                $a[] = array(
                    'id' => $d->getId(),
                    'name' => $d->getName(),
                    'price' => $logicClassPrice,
                    'currency' => $currencyDefault->getSymbol(),
                    'needcity' => $d->getNeedcity(),
                    'needaddress' => $d->getNeedaddress(),
                    'paydelivery' => $d->getPaydelivery(),
                    'needcountry' => $d->getNeedcountry(),
                    'logic' => $d->getLogicclass(),
                    'selected' => $d->getDefault()
                );

                if ($count===0) {
                    if ($d->getNeedaddress()) {
                        $needaddress = true;
                    }
                    if ($d->getNeedcity()) {
                        $needcity = true;
                    }
                    if ($d->getNeedcountry()) {
                        $needCountry = true;
                    }
                }
                $count++;
            }

            $this->setValue('deliveryArray', $a);
            $this->setValue('needcity', $needcity);
            $this->setValue('needcountry', $needCountry);
            $this->setValue('needaddress', $needaddress);
        } catch(Exception $e) {

        }
        // варианты оплаты (в зависимости от доставки)
        try{
            $paymentArray = array();
            foreach ($a as $del) {
                try {
                    $payment = Shop::Get()->getShopService()->getPaymentByDeliveryID($del['id']);
                    $payment->setHidden(0);
                    $p = array();
                    while ($x = $payment->getNext()) {
                        $p[$x->getId()] = array(
                            'id' => $x->getId(),
                            'name' => $x->makeName(),
                            'selected' => $x->getDefault()
                        );
                    }
                    $paymentArray[$del['id']] = $p;

                } catch (Exception $e) {

                }
            }
            $this->setValue('paymentArray', $paymentArray);
        } catch (Exception $e) {

        }

        // если юзер админ - то давать возможность оформлять заказ на клиента
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

        if (!$this->getUserSecure()) {
            // требуется ли наличие авторизации для оформления заказа
            if (Shop::Get()->getSettingsService()->getSettingValue('shop-auth-for-order')) {
                $this->setValue('userIsNotAuthorithed', true);
            }
        }

        // оформляем заказ
        if ($this->getArgumentSecure('authorizedFail')) {
            $this->setValue('authorizedFail', true);
        } elseif ($this->getArgumentSecure('makeorder')) {
            try {
                SQLObject::TransactionStart();

                if ($this->getControlValue('ajs') != 'ready') {
                    throw new ServiceUtils_Exception('bot');
                }

                if ( !$this->getControlValue('phone')) {
                    throw new ServiceUtils_Exception('phone');
                }

                $address = '';
                $address .= trim($this->getControlValue('country'));

                if (trim($this->getControlValue('city')) && $address) {
                    $address .= ', ';
                }
                $address .= trim($this->getControlValue('city'));

                if (trim($this->getControlValue('address')) && $address) {
                    $address .= ', ';
                }
                $address .= trim($this->getControlValue('address'));

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
                            $this->getControlValue('namelast'),
                            $this->getControlValue('namemiddle'),
                            $this->getControlValue('typesex'), // typesex
                            false, // company
                            false, // post
                            $this->getControlValue('email'),
                            $this->getControlValue('phone'),
                            $address
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
                            $this->getControlValue('namelast'),
                            $this->getControlValue('namemiddle'),
                            $this->getControlValue('typesex'), // typesex
                            false, // company
                            false, // post
                            $this->getControlValue('email'),
                            $this->getControlValue('phone'),
                            $address
                        );
                        $client->setDistribution(1);
                        $client->update();
                    } catch (Exception $clientEx) {

                    }
                }

                // оформляем заказ
                $name = $this->getControlValue('namelast')
                    ." ".$this->getControlValue('name').
                    " ".$this->getControlValue('namemiddle');
                $order = Shop::Get()->getShopService()->makeOrder(
                    $name,
                    $this->getControlValue('phone'),
                    $this->getControlValue('email'),
                    $address,
                    false, // contacts (@deprecated @todo)
                    $this->getControlValue('comments'),
                    $client,
                    $this->getControlValue('delivery'),
                    $this->getControlValue('payment'),
                    $isAdmin,
                    $this->getArgumentSecure('gift')
                );

                $redirect = false;

                // если админ - то редирект на управление заказом
                try {
                    if ($this->getUser()->isAdmin()) {
                        header('Location: '.$order->makeURLEdit());
                        $redirect = true;
                    }
                } catch (Exception $ue) {

                }
                // если система оплаты автоматизирована -
                // переход на контент системы оплаты
                try {
                    $paymentContentID = $order->getPayment()->getContentid();
                    if ($paymentContentID) {
                        $redirect = true;
                        header(
                            'Location: '.
                            Engine::GetLinkMaker()->makeURLByContentIDParam(
                                $paymentContentID, $order->getId(), 'orderid'
                            )
                        );
                    }
                } catch (Exception $e) {

                }

                // если не админ, и нет системы оплаты переход в success
                if (!$redirect) {
                    $products = $order->getOrderProducts();
                    $ids = '?ids=';
                    while ($x = $products->getNext()) {
                        $ids .= $x->getProductid().',';
                    }
                    header(
                        'Location: '.
                        Engine::GetLinkMaker()->makeURLByContentID('shop-basket-success').
                        $ids.'&orderid='.$order->getId()
                    );
                }

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
                        if ($e == 'city') {
                            $this->setValue('errorCity', 'true');
                        }
                    } catch (Exception $e) {

                    }
                }
            }
        } else {
            // заполняем форму заказа текущими данными
            try {
                $lastorder = $this->getUser()->getOrders();
                $lastorder->setOrder('id', 'DESC');
                $lastorder->setLimitCount(1);
                $lastorder = $lastorder->getNext();

                if ($this->getUser()->getName()) {
                    $this->setControlValue('name', $this->getUser()->getName());
                } elseif ($lastorder) {
                    $this->setControlValue('name', $lastorder->getClient()->getName());
                }
                if ($this->getUser()->getNamelast()) {
                    $this->setControlValue('namelast', $this->getUser()->getNamelast());
                } elseif ($lastorder) {
                    $this->setControlValue('namelast', $lastorder->getClient()->getNamelast());
                }
                if ($this->getUser()->getNamemiddle()) {
                    $this->setControlValue('namemiddle', $this->getUser()->getNamemiddle());
                } elseif ($lastorder) {
                    $this->setControlValue('namemiddle', $lastorder->getClient()->getNamemiddle());
                }
                if ($this->getUser()->getPhone()) {
                    $this->setControlValue('phone', $this->getUser()->getPhone());
                } elseif ($lastorder) {
                    $this->setControlValue('phone', $lastorder->getClient()->getPhone());
                }
                if ($this->getUser()->getEmail()) {
                    $this->setControlValue('email', $this->getUser()->getEmail());
                } elseif ($lastorder) {
                    $this->setControlValue('email', $lastorder->getClient()->getEmail());
                }
            } catch (Exception $e) {

            }
        }

        // настройки
        $this->setValue(
            'used_user_info',
            Shop::Get()->getSettingsService()->getSettingValue('used-user-info')
        );
        $this->setValue(
            'requiredEmail',
            Shop::Get()->getSettingsService()->getSettingValue('shop-email-required-for-order')
        );

    }

}