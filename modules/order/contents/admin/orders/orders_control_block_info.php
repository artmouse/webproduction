<?php
class orders_control_block_info extends Engine_Class {

    public function process() {
        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $canEdit = $this->getValue('canEdit');
            if (!$canEdit) {
                $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
            }

            $this->setValue('canEdit', $canEdit);

            // custom fields
            try {
                $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-order');

                foreach ($customFieldArray as $index => $x) {
                    if (!empty($x['workflowid'])) {
                        if ($x['workflowid'] != $order->getCategoryid()) {
                            unset($customFieldArray[$index]);
                        }
                    }
                }
            } catch (Exception $e) {
                $customFieldArray = array();
            }

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $workflowVisualEnable = Engine::Get()->getConfigFieldSecure('workflow-visual-enable');
            $this->setValue('workflowVisualEnable', $workflowVisualEnable);

            // сохранение настроек этапа
            if ($this->getArgumentSecure('setting-info-ok')) {
                try{
                    $status = Shop::Get()->getShopService()->getStatusByID(
                        $this->getArgument('setting-status-id')
                    );

                    if ($new_issue = $this->getArgumentSecure('new_issue')) {
                        $new_issue = explode("\n", $new_issue);
                        foreach ($new_issue as $issueName) {
                            if (!$issueName) {
                                continue;
                            }
                            $worlflowId = 0;
                            try {
                                // Бизнесс-процесс по умолчанию.
                                $default = Shop::Get()->getShopService()->getOrderCategoryAll();
                                $default->setDefault(1);
                                $default->setType('issue');
                                if ($default->select()) {
                                    $worlflowId = $default->getId();
                                }
                                // создаем задачу
                                $issue = IssueService::Get()->addIssue(
                                    $this->getUser(),
                                    $issueName,
                                    false,
                                    $this->getArgumentSecure('manager_status'),
                                    $worlflowId,
                                    false,
                                    false,
                                    $order->getId()
                                );

                                $issue->setParentstatusid($status->getId());
                                $issue->update();
                            } catch (Exception $e) {

                            }

                        }
                    }

                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($order->getId());
                    $employer->setStatusid($status->getId());
                    if ($employer->select()) {
                        $employer->setTerm($this->getArgumentSecure('statusTerm'));
                        $employer->setManagerid($this->getArgumentSecure('manager_status'));
                        $employer->update();
                    } else {
                        $employer = new XShopOrderEmployer();
                        $employer->setOrderid($order->getId());
                        $employer->setStatusid($status->getId());
                        $employer->setTerm($this->getArgumentSecure('statusTerm'));
                        $employer->setManagerid($this->getArgumentSecure('manager_status'));
                        $employer->insert();
                    }
                } catch (Exception $e) {

                }
                // отлавливаем удаление и изменение
                foreach ($this->getArguments() as $key => $item) {
                    if (strpos($key, 'issueClosed_') === 0) {
                        $orderId = str_replace('issueClosed_', '', $key);
                        try{
                            $orderDelete = Shop::Get()->getShopService()->getOrderByID($orderId);
                            Shop::Get()->getShopService()->deleteOrder($orderDelete);
                        } catch (Exception $e) {

                        }

                    }

                    if (strpos($key, 'manager_') === 0) {
                        $orderId = str_replace('manager_', '', $key);
                        try{
                            $order = Shop::Get()->getShopService()->getOrderByID($orderId);
                            $order->setDateto($this->getArgumentSecure('date_to_'.$orderId));
                            $order->setManagerid($this->getArgumentSecure('manager_'.$orderId));
                            $order->update();
                        } catch (Exception $e2) {

                        }
                    }
                }

            }

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    // обновляем менеджера заказа
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                            $this->getControlValue('manager')
                        );

                        Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), $manager);
                    } catch (Exception $e) {
                        // убираем менеджера заказа
                        Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), false);
                    }

                    // обновляем информацию о клиенте
                    $order->setClientname($this->getControlValue('clientname'));
                    $order->setClientaddress($this->getControlValue('clientaddress'));
                    $order->setClientphone($this->getControlValue('clientphone'));
                    $order->setClientemail($this->getControlValue('clientemail'));
                    $order->setComments($this->getControlValue('comments'));

                    try {
                        $orderUser = $order->getClient();
                        if ($this->getControlValue('clientaddress') && !$orderUser->getAddress()) {
                            $orderUser->setAddress($this->getControlValue('clientaddress'));
                        }
                        if ($this->getControlValue('clientphone') && !$orderUser->getPhone()) {
                            $orderUser->setPhone($this->getControlValue('clientphone'));
                        }
                        if ($this->getControlValue('clientemail') && !$orderUser->getEmail()) {
                            $orderUser->setEmail($this->getControlValue('clientemail'));
                        }
                        if ($this->getControlValue('clientname') && !$orderUser->getName()) {
                            $orderUser->setName($this->getControlValue('clientname'));
                        }
                        $orderUser->update();

                    } catch (Exception $e) {

                    }

                    $newUserID = $this->getControlValue('changeuser');
                    try {
                        $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);

                        Shop::Get()->getShopService()->updateOrderUser($order, $user, $newUser);

                        Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(false));
                        Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                        Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                        Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
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
                                    false,
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

                    // обновляем номер заказа
                    $number = $this->getArgumentSecure('number');
                    if ($number) {
                        $tmp = new XShopOrder();
                        $tmp->setNumber($number);
                        $tmp->addWhere('id', $order->getId(), '<>');
                        $tmp->setLimitCount(1);
                        if ($tmp->getNext()) {
                            $this->setValue('IdBusy', 'ok');
                            throw new ServiceUtils_Exception();
                        } else {
                            $order->setNumber($number);

                        }
                    }

                    // обновляем имя заказа
                    try {
                        $name = $this->getArgument('name');
                        $order->setName($name);
                    } catch (Exception $e) {

                    }

                    $updateCategory = false;

                    // обновляем категорию
                    try {
                        $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                            $this->getArgument('categoryid')
                        );

                        $updateCategory = Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);
                    } catch (Exception $e) {
                        //$order->setCategoryid(0);
                        //$order->setIssue(0);
                    }

                    // обновляем статус
                    if (!$isBox) {
                        if ($this->getControlValue('status') && !$updateCategory) {
                            Shop::Get()->getShopService()->updateOrderStatus(
                                $this->getUser(),
                                $order,
                                $this->getControlValue('status')
                            );
                        }
                    }

                    // обновляем оплату заказа
                    $order->setPaymentid($this->getControlValue('payment'));

                    // обвновляем доставку
                    $order->setDeliveryid($this->getControlValue('delivery'));

                    // обновляем накладную доставки
                    $order->setDeliverynote($this->getControlValue('deliveryNote'));

                    // автоматически ставим менеджером себя, если менеджера нет
                    if (!$order->getManagerid()) {
                        $order->setManagerid($this->getUser()->getId());
                    }

                    // обновляем дату оформления
                    $cdate = $this->getArgumentSecure('cdate', 'datetime');
                    if (!empty($cdate)) {
                        $order->setCdate($cdate);
                    } else {
                        $order->setCdate('');
                    }

                    // обновляем дату выполнения
                    try {
                        $dateto = $this->getArgument('dateto', 'datetime');
                        Shop::Get()->getShopService()->updateOrderDateto($order, $this->getUser(), $dateto);
                    } catch (Exception $de) {

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

                    if ($order->getOutcoming() && ($order->getSum() > 0)) {
                        $order->setSum($order->getSum()*(-1));
                        $order->update();
                    }

                    // сохранение дополнительных полей
                    foreach ($customFieldArray as $key => $x) {
                        $value = $this->getArgumentSecure('custom_'.$key);

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

                    $event = Events::Get()->generateEvent('shopOrderEditAfter');
                    $event->setOrder($order);
                    $event->notify();

                    SQLObject::TransactionCommit();

                    if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                        Engine::GetURLParser()->setArgument('message', 'ok');
                    }

                } catch (ServiceUtils_Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    Engine::GetURLParser()->setArgument('message', 'error');

                    $errorsArray = $te->getErrorsArray();
                    foreach ($errorsArray as $error) {
                        if (substr_count($error, ':lack')) {
                            $errorsArray['lack'] = 'lack';
                        }
                    }
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $errorsArray);

                    $this->setValue(
                        'errorText',
                        implode('<br />', Shop_ContentErrorHandler::Get()->getErrorValueArray($te))
                    );
                }
            }

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
                } catch(Exception $e) {
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
            } catch(Exception $de) {

            }

            try{
                $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID(
                    $order->getDeliveryid()
                );

                // если доставка новой почты, то делаем ссылку на состояние посылки
                if ($order->getDeliverynote()
                    && $delivery->getLogicclass() == 'ShopDelivery_NovaPoshta'
                    && class_exists('ShopDelivery_NovaPoshta')
                ) {
                    $novaPoshta = new ShopDelivery_NovaPoshta();
                    $this->setValue('deliveryNoteUrl', $novaPoshta->getDeliveryNoteUrl($order->getDeliverynote()));
                }
            } catch (Exception $de) {

            }

            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue('orderNumber', $order->getNumber());
            $this->setValue('orderName', $order->makeName());
            $this->setValue('orderComment', $this->_formatComment($order->getComments()));

            $this->setControlValue('status', $order->getStatusid());
            $this->setControlValue('managerid', $order->getManagerid());
            $this->setControlValue('cdate', $order->getCdate());
            $this->setControlValue('clientname', $order->getClientname());
            $this->setControlValue('clientemail', $order->getClientemail());
            $this->setControlValue('clientphone', $order->getClientphone());
            $this->setControlValue('clientaddress', $order->getClientaddress());
            $this->setControlValue('dateto', $order->getDateto());
            $this->setControlValue('deliveryNote', $order->getDeliverynote());
            $this->setControlValue('number', $order->getNumber());
            $this->setControlValue('name', $order->getName());
            $this->setControlValue('direction', $order->getOutcoming());
            $this->setControlValue('projectid', $order->getParentid());
            $this->setControlValue('comments', $order->getComments());
            $this->setControlValue('estimatetime', $order->getEstimate());
            $this->setControlValue('estimatemoney', $order->getMoney());
            $this->setControlValue('parentid', $order->getParentid());
            if ($order->getNextid()) {
                $this->setValue(
                    'next_order',
                    array(
                        'id' => $order->getNextid(),
                        'urlEdit' => Engine_LinkMaker::Get()->makeURLByContentIDParam(
                            'shop-admin-orders-control',
                            $order->getNextid()
                        )
                    )
                );
            }

            if ($order->getPrevid()) {
                $this->setValue(
                    'prev_order',
                    array(
                        'id' => $order->getPrevid(),
                        'urlEdit' => Engine_LinkMaker::Get()->makeURLByContentIDParam(
                            'shop-admin-orders-control',
                            $order->getPrevid()
                        )
                    )
                );
            }

            try {
                $this->setValue('workflowName', $order->getWorkflow()->makeName());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('statusName', $order->getStatus()->makeName());
                $this->setValue('statusColor', $order->getStatus()->getColour());
            } catch (Exception $e) {

            }

            if ($isBox) {
                try {
                    $this->setValue('clientEmail', $order->getClient()->getEmail());
                    $this->setValue('clientSMSArray', $order->getClient()->getPhoneArrayForSMS());
                } catch (Exception $e) {

                }
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

            $a = array();
            $customFieldViewArray = Engine::Get()->getConfigFieldSecure('order-view-custom-field-block-info');
            foreach ($customFieldViewArray as $customField) {
                if ($order->getField($customField['field'])) {
                    $a[] = array(
                        'name' => $customField['name'],
                        'value' => $order->getField($customField['field']),
                        'text' => $customField['text']
                    );
                }
            }
            $this->setValue('customFieldViewArray', $a);


            // кто менеджер заказа
            try {
                $u = $order->getManager();
                $this->setValue('managerID', $u->getId());
                $this->setValue('managerName', $u->makeName(true, 'lfm'));
                $this->setValue('managerURL', $u->makeURLEdit());
            } catch (Exception $e) {

            }

            // клиент
            try {
                $client = $order->getUser();
                $this->setValue('orderClientCompany', $client->getTypesex() == 'company' ? true : false);
                $this->setValue('clientID', $client->getId());
                $this->setValue('clientName', $client->makeName());
                $this->setValue('clientURL', $client->makeURLEdit());

                // дополнительные поля контактов
                $groups = $client->getGroups();
                $groupIDArray = array(0);
                while ($x = $groups->getNext()) {
                    $groupIDArray[] = $x->getId();
                }

                $contactType = 'company';
                if ($client->getTypesex() == 'man' || $client->getTypesex() == 'woman' || !$client->getTypesex()) {
                    $contactType = 'person';
                }

                $contactTypeArray = array(
                    '',
                    'all',
                    $contactType
                );
                if (Shop_ModuleLoader::Get()->isImported('contact')) {
                    $userField = new XShopContactField();
                    $userField->setShowinorder(1);
                    $userField->setHidden(0);
                    $userField->setGroupByQuery('idkey');
                    $userField->addWhereArray($groupIDArray, 'groupid');
                    $userField->addWhereArray($contactTypeArray, 'typecontact');
                    $userField->filterType('system', '!=');

                    $userFieldArray = array();
                    while ($u = $userField->getNext()) {

                        $userCustom = new XShopCustomField();
                        $userCustom->setObjecttype(get_class($client));
                        $userCustom->setObjectid($client->getId());
                        $userCustom->setKey($u->getIdkey());
                        $userCustom = $userCustom->getNext();
                        if ($userCustom && $userCustom->getValue()) {
                            $userFieldArray[] = array(
                                'name' => $u->getName(),
                                'key' => $u->getIdkey(),
                                'value' => $userCustom->getValue()
                            );
                        }

                    }
                    $this->setValue('customFieldArray', $userFieldArray);
                }
                
            } catch (Exception $e) {

            }

            // источник заказа
            try {
                $this->setValue('sourceName', $order->getSource()->makeName());
            } catch (Exception $e) {

            }

            // источники
            $sources = Shop::Get()->getShopService()->getSourceAll();
            $this->setValue('sourceArray', $sources->toArray());

            // статусы заказа по workflow
            $statusNextArray = array();
            try {
                $category = $order->getWorkflow();

                $statuses = WorkflowService::Get()->getStatusNextByWorkflow($category, $order->getStatus());
                while ($s = $statuses->getNext()) {
                    $statusNextArray[] = array(
                       'id' => $s->getId(),
                       'name' => $s->makeName(),
                    );
                }
            } catch (Exception $e) {

            }
            $this->setValue('statusNextArray', $statusNextArray);


            // статусы заказа
            $statusArray = array();
            try {
                // статусы на основе категории
                $category = $order->getCategory();

                $status = $category->getStatuses();
                while ($s = $status->getNext()) {
                    // есть ли открытые задачи?
                    $subIssue = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                    $subIssue->setParentid($order->getId());
                    $subIssue->setParentstatusid($s->getId());

                    $allClosed = true;
                    $subIssueCount = 0;
                    while ($sub = $subIssue->getNext()) {
                        $subIssueCount++;
                        if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                            $allClosed = false;
                            break;
                        }
                    }

                    $fire = Shop::Get()->getShopService()->isFireOrderStatus($order, $s);

                    $statusArray[] = array(
                    'id' => $s->getId(),
                    'name' => $s->getName(),
                    'colour' => $s->getColour(),
                    'positionx' => $s->getX(),
                    'positiony' => $s->getY(),
                    'width' => $s->getWidth(),
                    'height' => $s->getHeight(),
                    'statusAllow' => !$s->getOnlyauto(),
                    'allClosed' => $subIssueCount ? $allClosed:false,
                    'fireIssue' => $fire,
                    'next' => array_key_exists($s->getId(), $statusNextArray)
                    );
                }

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

            $this->setValue('fireIssue', Shop::Get()->getShopService()->isFireOrder($order));

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

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    private function _formatComment($text) {
        PackageLoader::Get()->import('TextProcessor');
        $processor = new TextProcessor_ActionTextToHTML();
        return $processor->process($text);
    }


}