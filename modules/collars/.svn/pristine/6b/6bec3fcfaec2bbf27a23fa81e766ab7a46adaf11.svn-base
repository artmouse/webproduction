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

                if (trim($this->getControlValue('street')) && $address) {
                    $address .= ', ';
                }
                $address .= trim($this->getControlValue('street'));

                if (trim($this->getControlValue('postal')) && $address) {
                    $address .= ', ';
                }
                $address .= trim($this->getControlValue('postal'));

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
                          echo $clientEx->getMessage();
                    }
                }



                // оформляем заказ
                $name = $this->getControlValue('namelast')
                    ." ".$this->getControlValue('name').
                    " ".$this->getControlValue('namemiddle');
                $order = $this->_makeOrder(
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

                    // если есть доставка
                    $deliveryPrice = 0;
                    if ($this->getControlValue('delivery')) {
                        try {
                            $delivery = Shop::Get()->getDeliveryService()->
                            getDeliveryByID($this->getControlValue('delivery'));
                            $deliveryPrice = $delivery->makePrice($currencyDefault);
                        } catch(Exception $ge) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $ge;
                            }
                        }
                    }

                    $amount = round($allSum, 2);
                    $delivery_price = round($deliveryPrice, 2);

                    $products = $order->getOrderProducts();
                    $ids = '?ids=';
                    while ($x = $products->getNext()) {
                        $ids .= $x->getProductid().',';
                    }
                    /*header(
                        'Location: '.
                        Engine::GetLinkMaker()->makeURLByContentID('shop-basket-success').
                        $ids.'&orderid='.$order->getId()
                     );*/
                    $url1 = "https://www.paypal.com/cgibin/webscr?cmd=_xclick&business=payment@westernbid.com&";
                    $back =  Engine::GetLinkMaker()->
                        makeURLByContentID('shop-basket-success').
                        $ids.
                        '&orderid='.
                        $order->getId();
                    $url2 = "item_name={$order->getId()}&item_number=rus-market&amount={$amount}&";
                    $url3 = "shipping={$delivery_price}&currency_code=USD&return={$back}";
                    $paypalurl = $url1.$url2.$url3;

                    header("Location: {$paypalurl}");


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



    /**
     * Оформить заказ.
     * Все суммы заказа фиксируются в системной валюте.
     * То есть, Order и все OrderProduct изначально будут в одной валюте.
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $address
     * @param string $contacts
     * @param string $comments
     * @param User $user
     * @param int $deliveryID
     * @param int $paymentID
     * @param boolean $isAdmin
     *
     * @return ShopOrder
     */
    private function _makeOrder($name, $phone, $email, $address, $contacts, $comments, $user,
                              $deliveryID, $paymentID, $isAdmin = false, $gift = false) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $phone = trim($phone);
            $email = trim($email);
            $address = trim($address);
            $contacts = trim($contacts);
            $comments = trim($comments);

            $ex = new ServiceUtils_Exception();

            if (empty($name)) {
                $ex->addError('name');
            }

            if ($phone) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if ($email) {
                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }
            }

            if (!$email && !$phone && !$isAdmin) {
                $ex->addError('email');
                $ex->addError('phone');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $categoryID = 0;
            $outcoming = false;
            $orderType = false;

            try {
                // поиск категории по умолчанию
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }



            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // поиск активного юридического лица
            try {
                $contractor = Shop_ShopService::Get()->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // если указан пользователь - оформляем заказ на него
            if ($user) {
                $order->setUserid($user->getId());
                $user->getPhone() ? false : $user->setPhone($phone);
                $user->getAddress() ? false : $user->setAddress($address);
                $user->getEmail() ? false : $user->setEmail($email);
                $user->update();
            }

            // параметры юзера из формы
            $order->setClientname($name);
            $order->setClientphone($phone);
            $order->setClientemail($email);
            $order->setClientaddress($address);
            $order->setClientcontacts($contacts);
            //$order->setStatusid($statusDefault->getId());
            $order->setType($orderType);
            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);
            $order->setComments($comments);
            // юрлицо (контрактор)
            $order->setContractorid($contractorID);
            // подарок
            if ($gift) {
                $order->setForgift(1);
                $order->setComments($comments.' Это для подарка.');
            }

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                // иначе автор - это клиент
                $order->setAuthorid($order->getUserid());
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            // если способ оплаты
            if ($paymentID) {
                try {
                    $payment = Shop_ShopService::Get()->getPaymentByID($paymentID);
                    $order->setPaymentid($payment->getId());
                } catch(Exception $ge){
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $ge;
                    }
                }
            }

            $needaddress = true;

            // если есть доставка
            $deliveryPrice = 0;
            if ($deliveryID) {
                try {
                    $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($deliveryID);
                    $deliveryPrice = $delivery->makePrice($currencyDefault);
                    $order->setDeliveryid($delivery->getId());
                    $order->setDeliveryprice($deliveryPrice);

                    $needaddress = ($delivery->getNeedaddress() || $delivery->getNeedcity());
                } catch(Exception $ge) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $ge;
                    }
                }
            }

            if (!$address && $needaddress && $deliveryID && !$isAdmin) {
                $ex->addError('address');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();

            // сумма заказа
            $sum = 0;
            $setSumArray = array();
            if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
                $personalSum = array();
            }
            $baskets = Shop_ShopService::Get()->getBasketProducts();
            $count = 0;
            $dateFrom = false;
            $dateTo = false;
            while ($x = $baskets->getNext()) {
                try {
                    $product = $x->getProduct();

                    // вставляем запись
                    $op = new ShopOrderProduct();

                    // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа
                    if (isset($personalSum)) {
                        $personalPrice = PersonalDiscountService::Get()->makePersonalPrice(
                            $product,
                            $currencyDefault
                        );
                        if ($personalPrice) {
                            $price = $personalPrice['price'];
                            $personalSum[$product->getId()] = $personalPrice;
                            $op->setPersonal_discountid($personalPrice['discountID']);
                        } else {
                            //теперь определяем стоимость товара используя метод корзины
                            $price = $x->makePrice($currencyDefault);
                        }
                    } else {
                        //теперь определяем стоимость товара используя метод корзины
                        $price = $x->makePrice($currencyDefault);
                    }


                    $op->setOrderid($order->getId());
                    $op->setProductid($x->getProductid());
                    $op->setProductcount($x->getProductcount());
                    $op->setDatefrom($x->getDatefrom());
                    $op->setDateto($x->getDateto());
                    $op->setStartprice($price);
                    $op->setSupplierid($product->getSupplierid());

                    if ($x->getDatefrom() < $dateFrom) {
                        $dateFrom = $x->getDatefrom();
                    }

                    if ($x->getDateto() > $dateTo) {
                        $dateTo = $x->getDateto();
                    }

                    if (strpos($product->getCode1c(), 'discountCoupon-') === 0 && !$x->getActionsetid()) {
                        // купон, используем
                        try{
                            $couponId = str_replace('discountCoupon-', '', $product->getCode1c());
                            $coupon = new XShopCoupon($couponId);

                            $couponCode = $coupon->getCode();
                            $couponCode = substr_replace($couponCode, '-', 4, 0);
                            $couponCode = substr_replace($couponCode, '-', 9, 0);
                            $couponCode = substr_replace($couponCode, '-', 14, 0);
                            $couponCode = strtoupper($couponCode);

                            $op->setProductname($product->getName().' '.$couponCode);
                            $op->setLinkkey('coupon');
                            $coupon->setDateused(DateTime_Object::Now());
                            $coupon->setOrderid($order->getId());
                            $coupon->update();

                        } catch (Exception $e) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $e;
                            }
                        }

                    } else {
                        // продукт
                        $op->setProductname($product->getName());
                    }
                    try {
                        $op->setCategoryname($product->getCategory()->makePathName());
                    } catch (Exception $categoryEx) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $categoryEx;
                        }
                    }
                    if ($x->getActionsetid()) { // позиция набора
                        @$setSumArray[$x->getActionsetid()]['total'] += $x->getActionsetprice()*$x->getActionsetcount();
                        @$setSumArray[$x->getActionsetid()]['one'] += $x->getActionsetprice();
                        @$setSumArray[$x->getActionsetid()]['count'] = $x->getActionsetcount();

                        $op->setProductprice($x->getActionsetprice());

                        $op->setComment(
                            'На товар установлена цена из набора (код '.$x->getActionsetid().
                            '), поэтому сумма товара не участвует в расчёте возможной накопительной скидки'
                        );
                    } else {
                        $op->setProductprice($price);
                        $op->setProducttax($product->getTax());
                        // устанавливаем комментарий согласно опций заказа
                        $productCommentArray = array();
                        if (isset($personalSum[$product->getId()])) {
                            $productCommentArray[] = 'Товар приобретён по персональной скидке "'.
                                $personalSum[$product->getId()]['discountName'].
                                '(№'.$personalSum[$product->getId()]['discountID'].
                                ')", накопительная скидка на товар не насчитывается';
                        }
                        try {
                            try {
                                $filter_count = Engine::Get()->getConfigField('filter_count');
                            } catch (Exception $e) {
                                $filter_count = 10;
                            }
                            for ($j = 1; $j <= $filter_count; $j++) {
                                $filter = Shop::Get()->getShopService()->getProductFilterByID(
                                    $x->getField('filter'.$j.'id')
                                );

                                $productCommentArray[] = $filter->getName().': '.$x->getField('filter'.$j.'value');
                            }
                        } catch (Exception $optionEx) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $optionEx;
                            }
                        }
                        $op->setComment(implode(', ', $productCommentArray));
                        $op->setParams($x->getParams());
                    }

                    $op->setCurrencyid($currencyDefault->getId());

                    $op->insert();

                    $count ++;

                    // считаем сумму заказа.
                    if (!$x->getActionsetid()) {
                        // при подсчете приводим цену к округлению НДС контрактора
                        $priceWithoutTax = Shop_ShopService::Get()->calculateSum(
                            $price,
                            $contractorTax,
                            0,
                            0,
                            true, // return sum
                            false, // + vat tax
                            false // without discount
                        );

                        $tmpSum = round($priceWithoutTax * $x->getProductcount(), 2);
                        $sum += $tmpSum;
                        if (isset($personalSum[$product->getId()])) {
                            $personalSum[$product->getId()]['sum'] = $tmpSum;
                        }
                    }

                    // увеличиваем счетчик заказа товаров на +1
                    $product->setOrdered($product->getOrdered() + 1);
                    $product->setLastordered(date('Y-m-d H:i:s'));
                    $product->update();

                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }

            }

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }

            if (isset($personalSum)) { // посчитаем сумму по всем товарам с персональной скидкой
                $personalSumValue = 0;
                foreach ($personalSum as $s) {
                    $personalSumValue += $s['sum'];
                }
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
                if (isset($personalSumValue)) {
                    $personalSumValue *= (1 + $contractorTax / 100);
                }
            }

            if (isset($personalSumValue)) { // не насчитываем скидку на товары с персональной скидкой
                $sum -= $personalSumValue;
            }

            // автоопределение скидки
            $value = 0;
            $discount = false;
            $discounts = Shop_ShopService::Get()->getDiscountAll();
            while ($x = $discounts->getNext()) {
                // если скидка может применятся автоматически
                if ($x->getMinstartsum() > 0) {
                    // конвертируем сумму заказа в валюту скидки
                    $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                        $sum,
                        $currencyDefault,
                        $x->getCurrency()
                    );

                    if ($x->getMinstartsum() <= $sumDiscount) {
                        // ищем максимально возможную скидку
                        $x_value = $x->makeDiscountValue($sum, $currencyDefault);
                        if ($x_value > $value) {
                            $value = $x_value;
                            $discount = clone $x;
                        }
                    }
                }
            }

            if ($user && $user->getDiscountid()) {
                try{
                    $discount = Shop::Get()->getShopService()->getDiscountByID($user->getDiscountid());
                } catch (Exception $edu) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $edu;
                    }
                }
            }

            if ($discount) {
                $order->setDiscountid($discount->getId());
                $order->setDiscountsum($discount->makeDiscountValue($sum, $currencyDefault));
                $sum = $discount->applyDiscount($sum, $currencyDefault);
                $sum = round($sum, 2);
            }

            // увеличиваем сумму на стоимость товаров с персональной скидкой
            if (isset($personalSumValue)) {
                $sum += $personalSumValue;
            }

            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // добавляем в общую сумму наборы
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            foreach ($setSumArray as $setid => $s) {
                $sum += $s['total'];
            }

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            // сумма заказа в системной валюте
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getClientname().$order->getClientphone().$order->getCdate()));

            /*if ($dateFrom) {
                $order->getCdate($dateFrom);
            }*/
            if ($dateTo) {
                $order->setDateto($dateTo);
            }
            if (Shop_ModuleLoader::Get()->isImported('utm-label')) {
                $order->setUtm_campaign($_COOKIE['utm_campaign']);
                $order->setUtm_content($_COOKIE['utm_content']);
                $order->setUtm_term($_COOKIE['utm_term']);
                if ($_COOKIE['utm_date']) {
                    $order->setUtm_date(DateTime_Object::FromString($_COOKIE['utm_date'])->setFormat('Y-m-d'));
                }
                $order->setUtm_referrer($_COOKIE['utm_referrer']);
                $order->setUtm_medium($_COOKIE['utm_medium']);
                $order->setUtm_source($_COOKIE['utm_source']);
            }
            // обновляем заказ
            $order->update();

            $orderManager = false;
            try{
                $orderManager = $order->getManagerOrAuthor();
            } catch (Exception $eordermanager) {
                try{
                    $orderManager = $order->getClient();
                } catch (Exception $eclient) {

                }
            }

            if ($orderManager) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $orderManager,
                    $order,
                    $statusDefault->getId()
                );
            } else {
                $order->setStatusid($statusDefault->getId());
                $order->update();

                // вставляем историю
                $change = new XShopOrderChange();
                if ($user) {
                    $change->setUserid($user->getId());
                }
                $change->setOrderid($order->getId());
                $change->setCdate($order->getCdate());
                $change->setKey('statusid');
                $change->setValue($order->getStatusid());
                $change->insert();
            }


            // событие после добавления заказа
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($user);
            $event->notify();

            // очищаем корзину
            Shop_ShopService::Get()->clearBasket();

            try {
                Shop::Get()->getShopService()->updateUserInfoByOrder($order->getClient(), $order);

            } catch (Exception $euserInfo) {

            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш корзины
            $this->_basketArray = false;

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

}