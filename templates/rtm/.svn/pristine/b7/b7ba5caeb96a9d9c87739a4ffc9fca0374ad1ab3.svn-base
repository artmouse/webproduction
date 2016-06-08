<?php
class orders_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception();
            }

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            $this->setValue('canEdit', $canEdit);

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'view');
            $this->setValue('block_menu', $menu->render());

            $commentKey = 'shop-order-' . $order->getId();

            // записываем в лог, что я посмотрел задачу
            try {
                $log = new XShopOrderLogView();
                $log->setOrderid($order->getId());
                $log->setUserid($user->getId());
                $log->setCdate(date('Y-m-d H:i:s'));
                $log->insert();
            } catch (Exception $logEx) {

            }

            // custom fields
            try {
                $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-order');
            } catch (Exception $e) {
                $customFieldArray = array();
            }

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');

            // определяем процент налогообложения (ПДВ) у текущего юрлица этого заказа
            try {
                $contractorTax = $order->getContractor()->getTax();
            } catch (Exception $cce) {
                $contractorTax = 0;
            }

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    // обновляем информацию о клиенте
                    $order->setClientname($this->getControlValue('clientname'));
                    $order->setClientcontacts($this->getControlValue('clientcontacts'));
                    $order->setClientaddress($this->getControlValue('clientaddress'));
                    $order->setClientphone($this->getControlValue('clientphone'));
                    $order->setClientemail($this->getControlValue('clientemail'));
                    $order->setComments($this->getControlValue('comments'));

                    // @todo: в метод updateOrderUser/Client
                    // с транзакциями
                    // возможно с уведомлениями юзеру
                    $newUserID = $this->getControlValue('changeuser');

                    try {
                        $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);
                        $order->setUserid($newUser->getId());

                        // issue #48522 - source from user
                        if (!$order->getSourceid()) {
                            $order->setSourceid($newUser->getSourceid());
                        }

                        // issue #48710 - обновляем поля
                        if ($newUser->getContractorid()) {
                            $order->setContractorid($newUser->getContractorid());
                        }
                        if ($newUser->getManagerid()) {
                            $order->setManagerid($newUser->getManagerid());
                        }

                        // issue #37125
                        $order->setClientname($newUser->makeName(false));
                        $order->setClientaddress($newUser->getAddress());
                        $order->setClientphone($newUser->getPhone());
                        $order->setClientemail($newUser->getEmail());

                        Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(false));
                        Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                        Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                        Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
                    } catch (Exception $e) {

                    }

                    // смена менеджера со стороны клиента
                    try {
                        $newClientManagerID = $this->getControlValue('changeclientmanager');
                        $newClientManager = Shop::Get()->getUserService()->getUserByID($newClientManagerID);

                        $order->setClientmanagerid($newClientManager->getId());
                    } catch (Exception $e) {

                    }

                    if ($this->getControlValue('updateUserInfo') && $user->isAllowed('users')) {
                        try {
                            $ou = $order->getUser();

                            Shop::Get()->getUserService()->updateUserProfile(
                                $ou,
                                $order->getClientemail(),
                                false,
                                $order->getClientname(),
                                $order->getClientphone(),
                                $order->getClientaddress(),
                                $ou->getBdate(),
                                $ou->getPhones(),
                                $ou->getEmails(),
                                $ou->getUrls(),
                                $ou->getTime(),
                                $ou->getParentid()
                            );
                        } catch (ServiceUtils_Exception $use) {
                            try {
                                $ou = Shop::Get()->getUserService()->addUserClient(
                                    $order->getClientname(),
                                    false,
                                    false,
                                    $order->getClientemail(),
                                    $order->getClientphone(),
                                    $order->getClientaddress()
                                );

                                $order->setUserid($ou->getId());
                            } catch (ServiceUtils_Exception $use2) {

                            }
                        }
                    }

                    // обновляем проект
                    try {
                        $projectID = $this->getArgument('projectid', 'int');
                        $order->setProjectid($projectID);
                    } catch (Exception $e) {

                    }

                    // обновляем направление заказа
                    try {
                        $direction = $this->getArgument('direction', 'int');
                        $order->setOutcoming($direction);
                    } catch (Exception $e) {

                    }

                    // обновляем родительскую задачу
                    try {
                        $parentID = $this->getArgument('parentid', 'int');
                        $order->setParentid($parentID);
                    } catch (Exception $e) {

                    }

                    // обновляем номер заказа
                    try {
                        $number = $this->getArgument('number');
                        if ($number) {
                            $tmp = new XShopOrder();
                            $tmp->setNumber($number);
                            $tmp->addWhere('id', $order->getId(), '<>');
                            $tmp->setLimitCount(1);
                            if ($tmp->getNext()) {
                                throw new ServiceUtils_Exception();
                            }
                        }

                        $order->setNumber($number);
                    } catch (Exception $e) {

                    }

                    // обновляем имя заказа
                    try {
                        $name = $this->getArgument('name');
                        $order->setName($name);
                    } catch (Exception $e) {

                    }

                    try {
                        $newCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                            $this->getArgument('ordercurrencyid')
                        );

                        $order->setCurrencyid($newCurrency->getId());
                    } catch (Exception $currencyEx) {

                    }

                    // добавляем товар в заказ
                    $this->_addOrderProduct($order);

                    // удаляем отмеченные товары из заказа
                    // обновляем цены и содержимое заказа
                    $orderproducts = $order->getOrderProducts();
                    while ($op = $orderproducts->getNext()) {

                        // удаление orderproduct'a
                        if ($this->_deleteOrderProduct($op)) {
                            // дальше продолжать не нужно
                            continue;
                        }

                        // обновляем данные заказа
                        $this->_updateOrderProduct($op);

                        // обновляем доставку
                        Shop::Get()->getShopService()->updateOrderDelivery(
                            $order,
                            $this->getControlValue('delivery')
                        );

                        // обновляем способ оплаты
                        Shop::Get()->getShopService()->updateOrderPayment(
                            $order,
                            $this->getControlValue('payment')
                        );
                    }

                    // обновляем скидку
                    try {
                        $discount = Shop::Get()->getShopService()->getDiscountByID(
                            $this->getControlValue('discount')
                        );
                        $order->setDiscountid($discount->getId());
                    } catch (Exception $e) {
                        $order->setDiscountid(0);
                    }

                    // обновляем юридическое лицо
                    try {
                        $contractor = Shop::Get()->getShopService()->getContractorByID(
                            $this->getControlValue('contractor')
                        );
                        $order->setContractorid($contractor->getId());
                    } catch (Exception $e) {
                        $order->setContractorid(0);
                    }

                    // обновляем накладную доставки
                    $order->setDeliverynote($this->getControlValue('deliveryNote'));

                    // обновляем менеджера заказа
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                            $this->getControlValue('manager')
                        );

                        Shop::Get()->getShopService()->updateOrderManager($order, $manager);
                    } catch (Exception $e) {
                        // убираем менеджера заказа
                        $order->setManagerid(0);
                    }

                    // обновляем дату оформления
                    $cdate = $this->getArgumentSecure('cdate', 'datetime');
                    if (!empty($cdate)) {
                        $order->setCdate($cdate);
                    } else {
                        $order->setCdate('');
                    }


                    // обновляем дату выполнения
                    $dateto = $this->getArgumentSecure('dateto', 'datetime');
                    if (!empty($dateto)) {
                        $order->setDateto($dateto);
                    } else {
                        $order->setDateto('');
                    }

                    try {
                        $estimateTime = $this->getArgument('estimatetime', 'float');
                        $order->setEstimate($estimateTime);
                    } catch (Exception $estimateEx) {

                    }

                    try {
                        $estimateMoney = $this->getArgument('estimatemoney', 'float');
                        $order->setMoney($estimateMoney);
                    } catch (Exception $estimateEx) {

                    }

                    // обновляем категорию
                    try {
                        $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                            $this->getControlValue('categoryid')
                        );

                        if ($order->getCategoryid() != $category->getId()) {
                            // ставим первый статус из этого workflow'a
                            $status1 = $category->getStatuses();
                            $status1->setDefault(1);
                            if ($status1->select()) {
                                $this->setControlValue('status', $status1->getId());
                            }
                        }

                        $order->setCategoryid($category->getId());
                        $order->setIssue($category->getIssue());

                        // обновляем срок
                        if ($category->getTerm() > 0) {
                            $order->setDateto(
                                DateTime_Object::FromString($order->getCdate())->addDay(
                                    (int) $category->getTerm()
                                )->__toString()
                            );
                        }
                    } catch (Exception $e) {
                        $order->setCategoryid(0);
                        $order->setIssue(0);
                    }

                    // обновляем источник
                    try {
                        $source = Shop::Get()->getShopService()->getSourceByID(
                            $this->getControlValue('sourceid')
                        );

                        $order->setSourceid($source->getId());
                    } catch (Exception $e) {
                        $order->setSourceid(0);
                    }

                    // считаем все суммы заказа
                    Shop::Get()->getShopService()->recalculateOrderSums($order);

                    // обновляем заказ
                    $order->update();

                    $hiddenProducts = false;
                    // обновляем статус
                    if ($this->getControlValue('status')) {

                        if ($this->getControlValue('status') == 2 && $order->getStatusid() != 2) {
                            $hiddenProducts = true;
                        }
                        Shop::Get()->getShopService()->updateOrderStatus(
                            $this->getUser(),
                            $order,
                            $this->getControlValue('status')
                        );
                        

                    }





                    // сохранение дополнительных полей
                    foreach ($customFieldArray as $key => $x) {
                        $value = $this->getArgumentSecure('custom_' . $key);

                        $tmp = new XShopCustomField();
                        $tmp->setObjecttype(get_class($order));
                        $tmp->setObjectid($order->getId());
                        $tmp->setKey($key);
                        if ($tmp->select()) {
                            $tmp->setValue($value);
                            $tmp->update();
                        } else {
                            $tmp->setValue($value);
                            $tmp->insert();
                        }
                    }

                    // добавления комментария/файла
                    $comment = $this->getControlValue('postcomment');

                    $fileAttachedArray = array();
                    $fileArgumentArray = $this->getArgumentSecure('file');
                    if ($fileArgumentArray) {
                        foreach ($fileArgumentArray['tmp_name'] as $index => $path) {
                            if (!file_exists($path)) {
                                continue;
                            }

                            $name = trim($fileArgumentArray['name'][$index]);
                            $type = $fileArgumentArray['type'][$index];

                            $fileAttachedArray[] = array(
                                'name' => $name,
                                'type' => $type,
                                'tmp_name' => $path, // дубликат нужен
                                'path' => $path, // дубликат нужен
                            );
                        }
                    }

                    if ($this->getArgumentSecure('sendclientemail')) {
                        $comment .= "\n\n";
                        $comment .= "Комментарий отправлен клиенту на " . $order->getClient()->getEmail();
                        $comment .= "\n";
                    }

                    if ($this->getArgumentSecure('sendclientsms')
                    && $this->getControlValue('sendclientsmsphone')
                    ) {
                        $comment .= "\n\n";
                        $comment .= "Комментарий отправлен клиенту по SMS " .
                        $this->getControlValue('sendclientsmsphone');
                        $comment .= "\n";
                    }

                    $comment = trim($comment);
                    if ($comment || $fileAttachedArray) {
                        try {
                            Shop::Get()->getShopService()->addOrderComment(
                                $order,
                                $this->getUser(),
                                $comment,
                                $fileAttachedArray
                            );

                            $this->setValue('message', 'commentok');
                        } catch (Exception $commentException) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $commentException;
                            }

                            $this->setValue('message', 'commenterror');
                        }
                    }


                    $event = Events::Get()->generateEvent('shopOrderEditAfter');
                    $event->setOrder($order);
                    $event->notify();

                    if ($this->getArgumentSecure('sendclientemail')) {
                        $comment = $this->getControlValue('postcomment');
                        if ($comment || $fileAttachedArray) {
                            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('box-parser-email');
                            if (!$emailFrom) {
                                $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                            }

                            $subject = $this->getArgumentSecure('sendclientemailsubject');
                            $subject .= ' #' . $order->getId();
                            $subject = trim($subject);
                            Shop::Get()->getUserService()->sendEmail(
                                $emailFrom,
                                $order->getClient()->getEmail(),
                                $subject,
                                $comment,
                                $fileAttachedArray
                            );
                            Shop::Get()->getUserService()->sendEmail(
                                $emailFrom,
                                $order->getClient()->getEmail(),
                                $subject,
                                $comment,
                                false
                            );
                        }
                    }

                    // отправка SMS
                    if ($this->getArgumentSecure('sendclientsms')) {
                        Shop::Get()->getUserService()->sendSMS(
                            $this->getControlValue('sendclientsmsphone'),
                            $this->getControlValue('postcomment')
                        );
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');

                    // редирект
                    header('Location: ' . $order->makeURLEdit() . '?message=ok');
                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());
                }
            }

            // удаление файла
            // @todo: to transaction up?
            try {
                $file = new ShopFile(
                    $this->getArgument('filedelete')
                );

                $file->setDeleted(1);
                $file->update();
            } catch (Exception $e) {

            }

            // ----------
            // отображение данных
            // ----------

            // все варианты доставки
            $a = array();
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            while ($d = $delivery->getNext()) {
                $a[] = array(
                    'id' => $d->getId(),
                    'name' => $d->getName(),
                    'currency' => $d->getCurrency()->getSymbol(),
                    'price' => $d->makePrice($order->getCurrency()),
                );
            }
            $this->setControlValue('delivery', $order->getDeliveryid());
            $this->setValue('deliveryArray', $a);

            // @todo: total refactoring, что это за ахтунг?
            try {
                try {
                    Shop::Get()->getDeliveryService()->getDeliveryByID(
                        $order->getDeliveryid()
                    );

                    $payment = Shop::Get()->getShopService()->getPaymentByDeliveryID(
                        $order->getDeliveryid()
                    );

                    if ($payment->getCount() == 0) {
                        throw new ServiceUtils_Exception();
                    }
                } catch (Exception $e) {
                    $payment = Shop::Get()->getShopService()->getPaymentAll();
                    $payment->setDeliveryid(0);
                }

                $payment->setHidden(0);
                $a = array();
                while ($pay = $payment->getNext()) {
                    $a[] = array(
                        'id' => $pay->getId(),
                        'name' => $pay->getName()
                    );
                }
                $this->setControlValue('payment', $order->getPaymentid());
                $this->setValue('paymentArray', $a);
            } catch (Exception $de) {

            }

            // получаем системную валюту
            $defaultCurrency = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // получаем все товары в заказе
            $orderproducts = $order->getOrderProducts();


            $a = array();
            $canSale = true;
            $storageSum = 0;
            $serviceSum = 0; // сумма услуг
            $orderLinked = true;

            while ($x = $orderproducts->getNext()) {
                // информация о наличии в поставщиках
                $supplierArray = array();

                try {
                    // productid может быть не действительный,
                    // поэтому заключаем в try-catch

                    $product = $x->getProduct();

                    if ($hiddenProducts) {
                        $product->setHidden(1);
                        $product->update();
                    }
                    for ($j = 1; $j <= 5; $j++) {
                        $supplierID = $product->getField('supplier' . $j . 'id');

                        if (!$supplierID) {
                            continue;
                        }

                        $supplierCode = $product->getField('supplier' . $j . 'code');
                        $supplierPrice = $product->getField('supplier' . $j . 'price');
                        $supplierCurrencyID = $product->getField('supplier' . $j . 'currencyid');
                        $supplierAvailtext = $product->getField('supplier' . $j . 'availtext');

                        try {
                            $supplierName = Shop::Get()->getShopService()->getSupplierByID(
                                $supplierID
                            )->getName();
                        } catch (Exception $supplierEx) {
                            continue;
                        }

                        try {
                            $supplierCurrencyName = Shop::Get()->getCurrencyService()->getCurrencyByID(
                                $supplierCurrencyID
                            )->getName();
                        } catch (Exception $supplierEx) {
                            $supplierCurrencyName = false;
                        }

                        $supplierArray[] = array(
                            'id' => $supplierID,
                            'name' => $supplierName,
                            'code' => $supplierCode,
                            'price' => $supplierPrice,
                            'currency' => $supplierCurrencyName,
                            'availtext' => $supplierAvailtext,
                        );
                    }

                    $productURLEdit = $product->makeURLEdit();
                    $productCount = $product->getCountWithDivisibility($x->getProductcount());
                    $productSource = $product->getSource();
                    $productUnit = $product->getUnit();

                    if ($product->getSource() == 'service'
                    || $product->getSource() == 'servicebusy'
                    ) {
                        $priceBase = $product->getPricebase();
                        $priceBase = Shop::Get()->getCurrencyService()->convertCurrency(
                            $priceBase,
                            $product->getCurrency(),
                            $order->getCurrency()
                        );

                        $serviceSum += round($priceBase * $x->getProductcount(), 2);
                    }

                    if ($x->getProduct()->getImage()) {
                        $src = MEDIA_PATH . '/shop/' . $x->getProduct()->getImage();
                        if (file_exists($src)) {
                            $image = $x->getProduct()->makeImageThumb('250', '200');
                        }
                    }

                    $storageArray = array();
                    if (Shop_ModuleLoader::Get()->isImported('storage')) {
                        // считаем количество на складе

                        $balance = StorageBalanceService::Get()->getBalanceByProductAndStoragesForSale(
                            $this->getUser(),
                            $product
                        );

                        while ($s = $balance->getNext()) {
                            try {
                                $storageArray[] = array(
                                    'name' => $s->getStorageName()->getName(),
                                    'count' => round($s->getAmount(), 3),
                                );
                            } catch (Exception $balanceEx) {

                            }
                        }
                    }

                } catch (Exception $e) {
                    $productCount = $x->getProductcount();
                    $productSource = '';
                    $productUnit = '';
                    $image = false;
                    $storageArray = array();
                }

                $linkOrderName = false;
                $linkOrderURL = false;
                if (preg_match("/^orderproduct-(\d+)$/ius", $x->getLinkkey(), $r)) {
                    try {
                        $linkOrder = Shop::Get()->getShopService()->getOrderProductById($r[1])->getOrder();

                        $linkOrderName = $linkOrder->makeName();
                        $linkOrderURL = $linkOrder->makeURLEdit();
                    } catch (Exception $e) {

                    }
                }

                try {
                    $sum = $x->makeSum($order->getCurrency());
                } catch (Exception $priceEx) {
                    $sum = 0;
                }

                // товары
                @$a[] = array(
                    'id' => $x->getId(),
                    'name' => htmlspecialchars($x->getProductname()),
                    'productid' => $x->getProductid(),
                    'url' => $productURLEdit,
                    'count' => (float) $productCount,
                    'avail' => $product->getAvail(),
                    'price' => $x->getProductprice(),
                    'sum' => $sum,
                    'currencyid' => $x->getCurrencyid(),
                    'comment' => htmlspecialchars($x->getComment()),
                    'statusid' => $x->getStatusid(),
                    'supplierArray' => $supplierArray,
                    'supplierid' => $x->getSupplierid(),
                    'categoryname' => htmlspecialchars($x->getCategoryname()),
                    'serial' => htmlspecialchars($x->getSerial()),
                    'warranty' => htmlspecialchars($x->getWarranty()),
                    'source' => $productSource,
                    'datefrom' => $this->_formatDate($x->getDatefrom()),
                    'dateto' => $this->_formatDate($x->getDateto()),
                    'unit' => htmlspecialchars($productUnit),
                    'image' => $image,
                    'linkOrderName' => $linkOrderName,
                    'linkOrderURL' => $linkOrderURL,
                    'storageCountArray' => $storageArray,
                );
            }

            $this->setValue('productsArray', $a);
            $this->setValue('cansale', $canSale);

            // заголовок страницы
            Engine::GetHTMLHead()->setTitle($order->makeName());

            // сумма заказа
            $this->setValue('sum', $order->getSum()); // без доставки
            $this->setValue('totalSum', $order->getSum() + $order->getDeliveryprice()); // с доставкой
            $this->setValue('deliveryPrice', $order->getDeliveryprice()); // стоимость доставки
            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue('orderNumber', $order->getNumber());
            $this->setValue('orderName', $order->makeName());
            $this->setValue('orderComment', $this->_formatComment($order->getComments()));

            $this->setControlValue('status', $order->getStatusid());
            $this->setControlValue('managerid', $order->getManagerid());
            $this->setControlValue('categoryid', $order->getCategoryid());
            $this->setControlValue('sourceid', $order->getSourceid());
            $this->setControlValue('discount', $order->getDiscountid());
            $this->setControlValue('cdate', $order->getCdate());
            $this->setControlValue('clientname', $order->getClientname());
            $this->setControlValue('clientemail', $order->getClientemail());
            $this->setControlValue('clientphone', $order->getClientphone());
            $this->setControlValue('clientcontacts', $order->getClientcontacts());
            $this->setControlValue('clientaddress', htmlspecialchars($order->getClientaddress()));
            $this->setControlValue('dateto', $order->getDateto());
            $this->setControlValue('contractorid', $order->getContractorid());
            $this->setControlValue('deliveryNote', $order->getDeliverynote());
            $this->setControlValue('ordercurrencyid', $order->getCurrencyid());
            $this->setControlValue('number', $order->getNumber());
            $this->setControlValue('name', $order->getName());
            $this->setControlValue('direction', $order->getOutcoming());
            $this->setControlValue('projectid', $order->getProjectid());
            $this->setControlValue('comments', $order->getComments());
            $this->setControlValue('estimatetime', $order->getEstimate());
            $this->setControlValue('estimatemoney', $order->getMoney());
            $this->setControlValue('parentid', $order->getParentid());

            $this->setValue('isIssue', $order->getIssue());

            try {
                $this->setValue('contractorName', $order->getContractor()->makeName());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('workflowName', $order->getWorkflow()->makeName());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('statusName', $order->getStatus()->makeName());
            } catch (Exception $e) {

            }

            if ($isBox) {
                $this->setValue('estimateTime', $order->makeEstimateTime());
                $this->setValue('estimateMoney', $order->makeEstimateMoney());

                try {
                    $this->setValue('clientEmail', $order->getClient()->getEmail());
                    $this->setValue('clientSMSArray', $order->getClient()->getPhoneArrayForSMS());
                } catch (Exception $e) {

                }

                // проект
                try {
                    $project = $order->getProject();
                    $this->setValue('projectName', $project->makeName());
                    $this->setValue('projectURL', $project->makeURL());
                } catch (Exception $e) {

                }

                // список проблем notify
                $notify = Engine::GetContentDriver()->getContent('notify-block');
                $notify->setValue('key', 'order-' . $order->getId());
                $this->setValue('block_notify', $notify->render());
            }

            // дополнительные поля
            $a = array();
            foreach ($customFieldArray as $key => $x) {
                $tmp = new XShopCustomField();
                $tmp->setObjecttype(get_class($order));
                $tmp->setObjectid($order->getId());
                $tmp->setKey($key);
                $tmp->select();
                $value = $tmp->getValue();

                $a[$key] = array(
                    'name' => $x['name'],
                    'value' => htmlspecialchars($value),
                    'type' => $x['type'],
                );
            }
            $this->setValue('customFieldArray', $a);

            // источник заказа
            try {
                $this->setValue('sourceName', $order->getSource()->makeName());
            } catch (Exception $e) {

            }

            // кто автор заказа
            try {
                $u = $order->getAuthor();
                $this->setValue('authorName', $u->makeName(true, 'lfm'));
                $this->setValue('authorURL', $u->makeURLEdit());
                $this->setValue('authorID', $u->getId());
            } catch (Exception $e) {

            }

            // кто менеджер заказа
            try {
                $u = $order->getManager();
                $this->setValue('managerName', $u->makeName(true, 'lfm'));
                $this->setValue('managerURL', $u->makeURLEdit());
                $this->setValue('managerID', $u->getId());
            } catch (Exception $e) {

            }

            // клиент
            try {
                $u = $order->getUser();
                $this->setValue('clientName', $u->makeName());
                $this->setValue('clientID', $u->getId());
                $this->setValue('clientURL', $u->makeURLEdit());

                // дата последней коммуникации с клиентом
                if ($u->getActivitydate() && $u->getActivitydate() != '0000-00-00 00:00:00') {
                    $this->setValue('clientactivitydate', $u->getActivitydate());

                    try {
                        // если now - term >= event, то выделяем зеленым, иначе красным
                        $status = $order->getStatus();
                        $term = $status->getTerm();
                        $termperiod = $status->getTermperiod();

                        $date = false;
                        if ($term > 0) {
                            if ($termperiod == 'hour') {
                                $date = DateTime_Object::Now()->addHour(-$term);
                            } elseif ($termperiod == 'day') {
                                $date = DateTime_Object::Now()->addDay(-$term);
                            } elseif ($termperiod == 'week') {
                                $date = DateTime_Object::Now()->addDay(-$term * 7);
                            } elseif ($termperiod == 'month') {
                                $date = DateTime_Object::Now()->addMonth(-$term);
                            } elseif ($termperiod == 'year') {
                                $date = DateTime_Object::Now()->addYear(-$term);
                            }
                        }

                        if (DateTime_Differ::DiffDay($date, $u->getActivitydate()) > 0) {
                            $this->setValue('clientactivitydateColor', 'red');
                        } elseif ($date) {
                            $this->setValue('clientactivitydateColor', 'green');
                        }
                    } catch (ServiceUtils_Exception $ses) {

                    }
                }

                $this->setValue('userCommentAdmin', nl2br(htmlspecialchars($u->getCommentadmin())));
            } catch (Exception $e) {

            }

            // менеджер на стороне клиента
            try {
                $u = Shop::Get()->getUserService()->getUserByID($order->getClientmanagerid());
                $this->setValue('clientManagerName', $u->makeName(true, 'lfm'));
                $this->setValue('clientManagerURL', $u->makeURLEdit());
                $this->setValue('clientManagerID', $u->getId());
            } catch (Exception $e) {

            }

            // родительская задача
            if ($isBox) {
                try {
                    $parentIssue = IssueService::Get()->getIssueByID(
                        $order->getParentid()
                    );

                    $this->setValue('parentIssueName', $parentIssue->makeName());
                    $this->setValue('parentIssueURL', $parentIssue->makeURLEdit());
                } catch (Exception $parentEx) {

                }
            }

            // информация о ПДВ
            $taxSum = $order->makeTaxSum();
            $this->setValue('taxSum', $taxSum, 2);
            $this->setValue('sumWithoutTax', $order->makeSumWithoutTax());

            // информация о прибыли
            if ($orderLinked) {
                $this->setValue('profit', round($order->getSum() - $serviceSum - $storageSum - $taxSum, 2));
            }
            $this->setValue('discountSum', $order->getDiscountsum());

            // статусы заказа
            $statusArray = array();
            try {
                // статусы на основе категории
                $category = $order->getCategory();

                $position_y_max = 0;

                $status = $category->getStatuses();
                while ($s = $status->getNext()) {
                    $statusDone = false;

                    if ($isBox) {
                        // была ли задача в этом статусе?
                        try {

                            $tmp = new XShopOrderChange();
                            $tmp->setOrderid($order->getId());
                            $tmp->setKey('statusid');
                            $tmp->setValue($s->getId());
                            $statusDone = $tmp->select();
                        } catch (Exception $e) {

                        }
                    }

                    $statusArray[] = array(
                        'id' => $s->getId(),
                        'name' => $s->getName(),
                        'colour' => $s->getColour(),
                        'positionx' => $s->getX(),
                        'positiony' => $s->getY(),
                        'width' => $s->getWidth(),
                        'height' => $s->getHeight(),
                        'statusAllow' => !$s->getOnlyauto(),
                        'statusDone' => $statusDone,
                    );

                    // максимальная высота workflow'a
                    if ($position_y_max < $s->getY() + $s->getHeight()) {
                        $position_y_max = $s->getY() + $s->getHeight();
                    }
                }

                if ($position_y_max > 0) {
                    $position_y_max += 50;
                }
                $this->setValue('position_y_max', $position_y_max);

                $changeArray = array();
                $changes = new XShopOrderStatusChange();
                $changes->setCategoryid($category->getId());
                while ($x = $changes->getNext()) {
                    if ($x->getElementfromid() == $x->getElementtoid()) {
                        continue;
                    }
                    $changeArray[$x->getElementfromid()][$x->getElementtoid()] = 1;
                }
                $this->setValue('changeArray', $changeArray);

            } catch (Exception $wfEx) {
                // статусы списком
                $status = Shop::Get()->getShopService()->getStatusAll();
                while ($s = $status->getNext()) {
                    $statusArray[] = array(
                        'id' => $s->getId(),
                        'name' => $s->getName(),
                    );
                }
            }
            $this->setValue('statusArray', $statusArray);

            // бизнес-процессы заказа
            $workflows = Shop::Get()->getShopService()->getWorkflowsAll(
                $this->getUser(),
                $order->getWorkflowid()
            );
            $a = array();
            while ($x = $workflows->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'hidden' => $x->getHidden(),
                );
            }
            $this->setValue('workflowArray', $a);

            if ($isBox) {
                // проекты
                $a = IssueService::Get()->getProjectsTreeArray($this->getUser());
                $this->setValue('projectArray', $a);
            }

            // источники
            $sources = Shop::Get()->getShopService()->getSourceAll();
            $this->setValue('sourceArray', $sources->toArray());

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());

            if (!$order->getOutcoming()) {
                // статусы товаров в заказах
                $orderproductstatus = new XShopOrderProductStatus();
                $orderproductstatus->setOrder('sort');
                $this->setValue('productStatusArray', $orderproductstatus->toArray());
            }

            // менеджеры
            $managers = Shop::Get()->getUserService()->getUsersManagers();
            $a = array();
            while ($x = $managers->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(true, 'lfm'),
                );
            }
            $this->setValue('managerArray', $a);

            // если подключен модуль Финансы
            // добавляем счета
            if (Shop_ModuleLoader::Get()->isImported('finance')) {
                $this->setValue('finance', true);

                // сколько оплачено и баланс
                $paymentSum = $order->makeSumPaid();
                $this->setValue('paymentSum', $paymentSum);

                $paymentBalance = $order->makeSumBalance();
                $this->setValue('paymentBalance', $paymentBalance);
            }

            // список скидок
            $discounts = Shop::Get()->getShopService()->getDiscountAll();
            $discountArray = array();
            while ($discount = $discounts->getNext()) {
                try {
                    $discountArray[] = array(
                        'id' => $discount->getId(),
                        'name' => $discount->getName(),
                        'value' => $discount->getValue(),
                        'type' => $discount->getType(),
                        'currency' => $discount->getCurrency()->getName()
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }
            $this->setValue('discountArray', $discountArray);

            // валюты
            $currencies = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $a = array();
            while ($x = $currencies->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'rate' => $x->getRate(),
                );
            }
            $this->setValue('orderCurrencyArray', $a);

            // вывод комментариев
            $comments = CommentsAPI::Get()->getComments($commentKey);
            $block = Engine::GetContentDriver()->getContent('comment-block');
            $block->setValue('comments', $comments);
            $this->setValue('block_comment', $block->render());

            if ($isBox) {
                $this->setValue('box', true);

                // визуализатор BMPN
                PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

                // чек-лист
                $block = Engine::GetContentDriver()->getContent('issue-checklist-block');
                $block->setValue('issue', $order);
                $this->setValue('block_checklist', $block->render());

                // файлы-вложения
                $files = new ShopFile();
                $files->setKey('order-' . $order->getId());
                $files->setDeleted(0);
                $a = array();
                while ($x = $files->getNext()) {
                    try {
                        $username = Shop::Get()->getUserService()->getUserByID($x->getUserid())->makeName(true, 'lfm');
                    } catch (Exception $e) {
                        $username = false;
                    }

                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(),
                        'url' => $x->makeURL(),
                        'username' => $username,
                        'urlDelete' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                            array('filedelete' => $x->getId())
                        ),
                    );
                }
                $this->setValue('fileArray', $a);

                // подзадачи
                $this->setValue('subIssueArray', $this->_makeSubIssueArray($order->getId()));
            }

            // разрешить менять клиента только на компанию
            $this->setValue('orderCompanyOnly', Shop::Get()->getSettingsService()->getSettingValue('order-company'));

            // кнопка "следить"
            $cuser = $this->getUser();

            if ($this->getArgumentSecure('watch')) {
                try {
                    if ($this->getArgumentSecure('watchvalue')) {
                        Shop::Get()->getShopService()->addOrderEmployer($order, $cuser);
                    } else {
                        Shop::Get()->getShopService()->deleteOrderEmployer($order, $cuser);
                    }
                } catch (ServiceUtils_Exception $se) {

                }
            }

            // исполнители
            $oes = Shop::Get()->getShopService()->getEmployersByOrder($order);
            $a = array();
            while ($x = $oes->getNext()) {
                try {
                    $user = $x->getUser();

                    $a[$user->getId()] = array(
                        'id' => $user->getId(),
                        'name' => $user->makeName(true, 'lfm'),
                        'url' => $user->makeURLEdit(),
                    );
                } catch (Exception $e) {

                }
            }
            try {
                $user = $order->getAuthor();

                $a[$user->getId()] = array(
                    'id' => $user->getId(),
                    'name' => $user->makeName(true, 'lfm'),
                    'url' => $user->makeURLEdit(),
                );
            } catch (Exception $e) {

            }
            try {
                $user = $order->getManager();

                $a[$user->getId()] = array(
                    'id' => $user->getId(),
                    'name' => $user->makeName(true, 'lfm'),
                    'url' => $user->makeURLEdit(),
                );
            } catch (Exception $e) {

            }
            $this->setValue('watcherArray', $a);

            $isWatcher = Shop::Get()->getShopService()->isEmployer($order, $cuser);
            $this->setValue('isWatcher', $isWatcher);
            $this->setValue(
                'urlWatch',
                Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('watch' => 1, 'watchvalue' => !$isWatcher))
            );


        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Обработчик добавления нового товара в заказ.
     * При добавлении товара в заказ цена товара приводится по правилам:
     * (product.price + product.tax%)
     * и это все конвертируется в валюту заказа.
     *
     * @param ShopOrder $order
     */
    private function _addOrderProduct(ShopOrder $order) {
        $addProductID = $this->getArgumentSecure('addproduct');
        $addProductCount = trim($this->getArgumentSecure('addproductcount'));

        if (!$addProductID) {
            return;
        }

        Shop::Get()->getShopService()->addOrderProduct($order, $addProductID, $addProductCount);
    }

    /**
     * Обработчик удаления товара из заказа
     *
     * @param ShopOrderProduct $op
     */
    private function _deleteOrderProduct(ShopOrderProduct $op) {
        try {
            $deleteID = $this->getArgument('delete' . $op->getId());
            $op->delete();

            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Обработчик обновления товара в заказе
     *
     * @param ShopOrderProduct $op
     */
    private function _updateOrderProduct(ShopOrderProduct $op) {
        try {
            $price = $this->getArgument('price' . $op->getId());
            $price = str_replace(',', '.', $price);

            $statusID = $this->getArgumentSecure('status' . $op->getId());
            $supplierID = $this->getArgumentSecure('supplier' . $op->getId());

            $currencyID = $this->getArgument('currency' . $op->getId());

            // проверяем валюту на валидность
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            $count = $this->getArgument('count' . $op->getId());
            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);
            $count = $op->getProduct()->getCountWithDivisibility($count);

            $comment = $this->getArgument('comment' . $op->getId());
            $name = $this->getArgument('name' . $op->getId());
            $serial = $this->getArgument('serial' . $op->getId());
            $warranty = $this->getArgument('warranty' . $op->getId());
            $categoryName = $this->getArgument('category' . $op->getId());

            $dateFrom = $this->getArgumentSecure('datefrom' . $op->getId(), 'date');
            $dateTo = $this->getArgumentSecure('dateto' . $op->getId(), 'date');

            if ($dateFrom && $dateTo && $op->getProduct()->getSource() == 'servicebusy') {
                // это товар с месячной сеткой занятости
                // (цена - за месяц)

                $term = $op->getProduct()->getTerm();
                if ($term == 'month') {
                    $count = DateTime_Differ::DiffMonth($dateFrom, $dateTo, false);
                } elseif ($term == 'day') {
                    $count = DateTime_Differ::DiffDay($dateTo, $dateFrom) + 1;
                } elseif ($term == 'year') {
                    $count = DateTime_Differ::DiffYear($dateTo, $dateFrom);
                }

            }

            // нельзя ставить цену ниже себестоимости
            $minProductPrice = $op->getProduct()->getPricebase();
            if ($minProductPrice > $price) {
                $price = $minProductPrice;
            }

            // сохраняем цену и валюту как указано
            $op->setProductprice($price);
            $op->setCurrencyid($currencyID);
            $op->setProductname($name);
            $op->setCategoryname($categoryName);
            $op->setSerial($serial);
            $op->setWarranty($warranty);

            $op->setProductcount($count);
            $op->setComment($comment);

            $op->setStatusid($statusID);
            $op->setSupplierid($supplierID);

            $op->setDatefrom($dateFrom);
            $op->setDateto($dateTo);

            $op->update();

            try {
                $status = new XShopOrderProductStatus($op->getStatusid());
                $logicclass = $status->getLogicclass();
                $logicclassparams = $status->getLogicclassparams();
                if ($logicclass) {
                    $tmp = explode(',', $logicclassparams);
                    $a = array();
                    foreach ($tmp as $x) {
                        $x = explode('=', $x, 2);
                        if (count($x) == 2) {
                            $a[$x[0]] = $x[1];
                        }
                    }

                    $processor = new $logicclass();
                    $processor->process($op, $a);
                }
            } catch (Exception $statusEx) {

            }
        } catch (Exception $e) {

        }
    }

    private function _formatDate($date) {
        if (Checker::CheckDate($date)) {
            return DateTime_Formatter::DateISO9075($date);
        }

        return '';
    }

    private function _formatComment($text) {
        PackageLoader::Get()->import('TextProcessor');
        $processor = new TextProcessor_ActionTextToHTML();
        return $processor->process($text);
    }

    /**
     * SubIssueArray
     *
     * @param int $issueID
     *
     * @return array
     */
    private function _makeSubIssueArray($issueID, $level = 0, $currentIssueArray = array()) {
        // issue #56515
        // суммарный due date
        $duedate = false;

        $a = array();
        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        $issues->setParentid($issueID);
        if ($level > 3) {
            $issues->setId(-1);
        }
        while ($x = $issues->getNext()) {
            // пропускаем задачи на случай цикла
            if (in_array($x->getId(), $currentIssueArray)) {
                continue;
            }

            if (!$duedate || $duedate < $x->getDateto()) {
                $duedate = $x->getDateto();
            }

            try {
                $managerName = $x->getManager()->makeName(true, 'lfm');
            } catch (Exception $managerEx) {
                $managerName = false;
            }

            $a[$x->getId()] = array(
                'name' => $x->makeName(false),
                'url' => $x->makeURLEdit(),
                'closed' => Checker::CheckDate($x->getDateclosed()),
                'managerName' => $managerName,
                'level' => $level,
            );

            $tmp = $this->_makeSubIssueArray($x->getId(), $level + 1, $a);
            $a = array_merge($a, $tmp);
        }

        if ($duedate) {
            $this->setControlValue('dateto', $duedate);
        }

        return $a;
    }

}