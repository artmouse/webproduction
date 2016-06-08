<?php
class project_block_info extends Engine_Class {

    public function process() {
        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $user = $this->getUser();

            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
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
                            try{
                                // Бизнесс-процесс по умолчанию.
                                $default = Shop::Get()->getShopService()->getOrderCategoryAll();
                                $default->setDefault(1);
                                $default->setType('project');
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

                    Shop::Get()->getShopService()->updateOrderEmployer(
                        $order,
                        $status,
                        $user,
                        $this->getArgumentSecure('statusTerm'),
                        $this->getArgumentSecure('manager_status')
                    );

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

                    // если у пользователя не прописаны данные, записываем их из заказа(при oneclick-enable=true)
                    if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                        try{
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

                    }

                    // @todo: в метод updateOrderUser/Client
                    // с транзакциями
                    // возможно с уведомлениями юзеру
                    $newUserID = $this->getControlValue('changeuser');
                    if ($newUserID) {
                        try {
                            $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);

                            Shop::Get()->getShopService()->updateOrderUser($order, $user, $newUser);

                            Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(false));
                            Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                            Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                            Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
                        } catch (Exception $e) {
                            Shop::Get()->getShopService()->updateOrderUser($order, $user, false);
                        }
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

                    // обновляем проект (это родительская задача)
                    try {
                        $projectID = $this->getArgument('projectid', 'int');
                        $order->setParentid($projectID);
                    } catch (Exception $e) {

                    }

                    // обновляем направление заказа
                    try {
                        $direction = $this->getArgument('direction', 'int');
                        $order->setOutcoming($direction);
                    } catch (Exception $e) {

                    }

                    /*// обновляем родительскую задачу
                    try {
                    $parentID = $this->getArgument('parentid', 'int');
                    $order->setParentid($parentID);
                    } catch (Exception $e) {

                    }*/

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

                    // обновляем описанние
                    $order->setComments($this->getControlValue('comments'));

                    $updateCategory = false;
                    // обновляем категорию
                    try {
                        $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                            $this->getControlValue('categoryid')
                        );

                        $updateCategory = Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);
                    } catch (Exception $e) {

                    }

                    // обновляем статус
                    if ($this->getControlValue('status') && !$updateCategory) {
                        Shop::Get()->getShopService()->updateOrderStatus(
                            $this->getUser(),
                            $order,
                            $this->getControlValue('status')
                        );
                    }

                    try {
                        $newCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                            $this->getArgument('ordercurrencyid')
                        );

                        $order->setCurrencyid($newCurrency->getId());
                    } catch (Exception $currencyEx) {

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

                    // обновляем оплату заказа
                    $order->setPaymentid($this->getControlValue('payment'));

                    // обвновляем доставку
                    $order->setDeliveryid($this->getControlValue('delivery'));

                    // обновляем накладную доставки
                    $order->setDeliverynote($this->getControlValue('deliveryNote'));

                    // обновляем менеджера заказа
                    try {
                        $manager = Shop::Get()->getUserService()->getUserByID(
                            $this->getControlValue('manager')
                        );

                        Shop::Get()->getShopService()->updateOrderManager(
                            $order,
                            $this->getUser(),
                            $manager
                        );
                    } catch (Exception $e) {
                        // убираем менеджера заказа
                        Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), 0);
                    }

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
                        IssueService::Get()->updateIssueDateto($order, $this->getUser(), $dateto);
                    } catch (Exception $de) {

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

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());

                    $errorArray = Shop_ContentErrorHandler::Get()->getErrorValueArray($te);
                    $this->setValue('errorText', implode('<br />', $errorArray));
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

                    if (!$payment->getCount()) {
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

            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue('orderNumber', $order->getNumber());
            $this->setValue('orderName', $order->makeName());
            $this->setValue('orderComment', $this->_formatComment($order->getComments()));

            $this->setControlValue('status', $order->getStatusid());
            $this->setValue('status_id', $order->getStatusid());
            $this->setControlValue('managerid', $order->getManagerid());
            $this->setControlValue('categoryid', $order->getCategoryid());
            $this->setControlValue('sourceid', $order->getSourceid());
            $this->setControlValue('cdate', $order->getCdate());
            $this->setControlValue('clientname', $order->getClientname());
            $this->setControlValue('clientemail', $order->getClientemail());
            $this->setControlValue('clientphone', $order->getClientphone());
            $this->setControlValue('clientaddress', $order->getClientaddress());
            $this->setControlValue('dateto', $order->getDateto());
            $this->setControlValue('contractorid', $order->getContractorid());
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
                $a = array(
                    'id' => $order->getNextid(),
                    'urlEdit' => Engine_LinkMaker::Get()->makeURLByContentIDParam(
                        'shop-admin-orders-control',
                        $order->getNextid()
                    )
                );
                $this->setValue('next_order', $a);
            }
            if ($order->getPrevid()) {
                $a = array(
                    'id' => $order->getPrevid(),
                    'urlEdit' => Engine_LinkMaker::Get()->makeURLByContentIDParam(
                        'shop-admin-orders-control',
                        $order->getPrevid()
                    )
                );
                $this->setValue('prev_order', $a);
            }

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
                $this->setValue('statusColor', $order->getStatus()->getColour());
            } catch (Exception $e) {

            }

            $this->setValue('estimateTime', $order->makeEstimateTime());
            $this->setValue('estimateMoney', $order->makeEstimateMoney());

            try {
                $this->setValue('clientEmail', $order->getClient()->getEmail());
                $this->setValue('clientSMSArray', $order->getClient()->getPhoneArrayForSMS());
            } catch (Exception $e) {

            }

            // проект
            try {
                $project = $order->getParent();
                $this->setValue('projectName', $project->makeName());
                $this->setValue('projectURL', $project->makeURLEdit());
            } catch (Exception $e) {

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
                $this->setValue('authorID', $u->getId());
                $this->setValue('authorName', $u->makeName(true, 'lfm'));
                $this->setValue('authorURL', $u->makeURLEdit());
            } catch (Exception $e) {

            }

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
            } catch (Exception $e) {

            }

            // менеджер на стороне клиента
            try {
                $u = Shop::Get()->getUserService()->getUserByID($order->getClientmanagerid());
                $this->setValue('clientManagerID', $u->getId());
                $this->setValue('clientManagerName', $u->makeName(true, 'lfm'));
                $this->setValue('clientManagerURL', $u->makeURLEdit());
            } catch (Exception $e) {

            }

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

                $position_y_max = 0;

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

                    // горит ли задача?
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

            // бизнес-процессы
            $workflows = Shop::Get()->getShopService()->getWorkflowsAll(
                $this->getUser(),
                $order->getWorkflowid()
            );

            $a = array();
            while ($x = $workflows->getNext()) {
                if ($x->getHidden() && $x->getId() != $order->getId()) {
                    continue;
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
                );
            }
            $this->setValue('workflowArray', $a);

            // источники
            $sources = Shop::Get()->getShopService()->getSourceAll();
            $this->setValue('sourceArray', $sources->toArray());

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());

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

            // визуализатор BMPN
            PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

            $this->setValue('oneclickEnable', Engine::Get()->getConfigFieldSecure('oneclick-enable'));
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