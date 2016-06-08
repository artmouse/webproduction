<?php
class order_add extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');

        $type = $this->getArgumentSecure('type');
        $this->setValue('type', $type);
        $this->setValue('typeName', Shop::Get()->getShopService()->getTypeName($type));

        $user = $this->getUser();

        if ($user->isDenied($type)) {
            // вычисляем путь к шаблону
            $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
            $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

            $this->setField('filehtml', $templatePath.'/error/error_deny.html');
            $this->setField('filephp', false);
            return;
        }

        try {
            if ($this->getArgumentSecure('ok')
            || $this->getArgumentSecure('oknext')
            ) {
                try {
                    SQLObject::TransactionStart();

                    // контактная информация клиента
                    if ($clientId = $this->getControlValue('clientid')) {
                        try {
                            $client = Shop::Get()->getUserService()->getUserByID($clientId);
                            $client->setPhone($this->getArgumentSecure('contact_phone'));
                            $client->setEmail($this->getArgumentSecure('contact_email'));
                            $client->setSkype($this->getArgumentSecure('contact_skype'));
                            $client->setWhatsapp($this->getArgumentSecure('contact_whatsapp'));
                            $client->update();

                            // кастомные поля
                            $arguments = $this->getArguments();
                            foreach ($arguments as $argKey => $argument) {
                                if (strpos($argKey, 'contact_custom_') === 0) {
                                    $customField = new XShopCustomField();
                                    $customField->setObjecttype(get_class($client));
                                    $customField->setObjectid($client->getId());
                                    $customField->setKey(str_replace('contact_custom_', '', $argKey));
                                    $customField = $customField->getNext();
                                    if ($customField) {
                                        $customField->setValue($argument);
                                        $customField->update();
                                    }

                                }
                            }
                        } catch (Exception $e2) {

                        }
                    }

                    // собираем описание
                    $content = '';

                    if ($this->getControlValue('content')) {
                        $content .= $this->getControlValue('content')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('result')) {
                        $content .= "Результат:\n";
                        $content .= $this->getControlValue('result')."\n";
                        $content .= "\n";
                    }

                    if ($this->getControlValue('resource')) {
                        $content .= "Доступные ресурсы:\n";
                        $content .= $this->getControlValue('resource')."\n";
                        $content .= "\n";
                    }

                    $parentid = false;
                    if (preg_match('/^#?([\d]+)/iusD', trim($this->getControlValue('parentid')), $r)) {
                        $parentid = $r[1];
                    }

                    // продукты из таблицы в заказ
                    $productArray = array();
                    foreach ($this->getArguments() as $key => $item) {
                        if (preg_match('#add_product_([\d]+)#uisD', $key, $r)) {
                            $count = $r[1];
                            $productArray[] = array(
                                'id' => $item,
                                'count' => $this->getArgumentSecure('count_product_'.$count),
                                'serial' => $this->getArgumentSecure('serial_product_'.$count),
                                'price' => $this->getArgumentSecure('price_product_'.$count)
                            );
                        }
                    }

                    // создаем заказ
                    $issue = Shop::Get()->getShopService()->addOrder(
                        $this->getUser(),
                        $this->getControlValue('name'),
                        $content,
                        $this->getControlValue('managerid'),
                        $this->getControlValue('workflowid'),
                        $this->getControlValue('dateto'),
                        $this->getControlValue('clientid'),
                        $parentid,
                        $productArray
                    );

                    // устанавливаем валюту от бизнес-процесса
                    try {
                        if ($this->getControlValue('workflowid')) {
                            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                                $this->getControlValue('workflowid')
                            );
                            if ($workflow->getCurrencyid()) {
                                $issue->setCurrencyid($workflow->getCurrencyid());
                                $issue->update();
                            }

                        }
                    } catch (Exception $e) {

                    }

                    // Устанавливаем источник.
                    if ($sourceId = $this->getArgument('source')) {
                        $issue->setSourceid($sourceId);
                        $issue->update();
                    }

                    $cdate = $this->getArgumentSecure('datefrom', 'datetime');
                    if ($cdate) {
                        $issue->setCdate($cdate);
                        $issue->update();
                    }

                    $estimateTime = $this->getArgumentSecure('estimatetime', 'float');
                    if ($estimateTime) {
                        $issue->setEstimate($estimateTime);
                        $issue->update();
                    }

                    $estimateMoney = $this->getArgumentSecure('estimatemoney', 'float');
                    if ($estimateMoney) {
                        $issue->setMoney($estimateMoney);
                        $issue->update();
                    }

                    // устанавливаем статус
                    if ($this->getArgumentSecure('statusid')) {
                        Shop::Get()->getShopService()->updateOrderStatus(
                            $this->getUser(),
                            $issue,
                            $this->getArgumentSecure('statusid')
                        );
                    }

                    // скидка
                    $issue->setDiscountid($this->getArgumentSecure('discount'));
                    // доставка
                    $issue->setDeliveryid($this->getArgumentSecure('delivery'));
                    $issue->setDeliveryprice($this->getArgumentSecure('deliveryPrice'));
                    $deliveryAddress = false;

                    if ($this->getArgumentSecure('country')) {
                        $deliveryAddress = $this->getArgumentSecure('country').', ';
                    }

                    if ($this->getArgumentSecure('city')) {
                        $deliveryAddress.= $this->getArgumentSecure('city').', ';
                    }

                    if ($this->getArgumentSecure('address')) {
                        $deliveryAddress.= $this->getArgumentSecure('address').', ';
                    }

                    if ($deliveryAddress) {
                        $deliveryAddress = substr($deliveryAddress, 0, strlen($deliveryAddress)-2);
                        $issue->setClientaddress($deliveryAddress);
                    }

                    // оплата
                    $issue->setPaymentid($this->getArgumentSecure('payment'));

                    // контактная инф.
                    $issue->setClientemail($this->getArgumentSecure('contact_email'));
                    $issue->setClientphone($this->getArgumentSecure('contact_phone'));

                    $issue->update();
                    Shop::Get()->getShopService()->recalculateOrderSums($issue);

                    // назначаем исполнителей
                    $workflow = $issue->getCategory();
                    $status = $workflow->getStatuses();
                    while ($s = $status->getNext()) {
                        $statusID = $s->getId();
                        $employerID = $this->getArgumentSecure('manager_status_'.$statusID);
                        $term = $this->getArgumentSecure('status_term_'.$statusID);
                        if (!$term && $s->getTerm()) {
                            if ($s->getTermperiod()=='hour') {
                                $term = DateTime_Object::Now()->addHour($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='day') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm())->__toString();
                            } elseif ($s->getTermperiod()=='week') {
                                $term = DateTime_Object::Now()->addDay($s->getTerm()*7)->__toString();
                            } elseif ($s->getTermperiod()=='month') {
                                $term = DateTime_Object::Now()->addMonth($s->getTerm())->__toString();
                            }

                        }

                        if ($statusID && ($employerID || $term)) {
                            $oes = new XShopOrderEmployer();
                            $oes->setOrderid($issue->getId());
                            $oes->setManagerid($employerID);
                            $oes->setStatusid($statusID);
                            $oes->setTerm($term);
                            $oes->insert();
                        }
                    }

                    // custom fields
                    try {
                        $customFieldArray = Engine::Get()->getConfigField('project-box-customfield-order');

                        foreach ($customFieldArray as $index => $x) {
                            if (empty($x['workflowid'])) {
                                continue;
                            }

                            if ($x['workflowid'] != $workflow->getId()) {
                                unset($customFieldArray[$index]);
                            }
                        }
                    } catch (Exception $e) {
                        $customFieldArray = array();
                    }

                    // сохранение дополнительных полей
                    foreach ($customFieldArray as $key => $x) {
                        try {
                            $value = $this->getArgument('custom_'.$key);

                            $tmp = new XShopCustomField();
                            $tmp->setObjecttype(get_class($issue));
                            $tmp->setObjectid($issue->getId());
                            $tmp->setKey($key);
                            if ($tmp->select()) {
                                $tmp->setValue($value);
                                $tmp->update();
                            } else {
                                $tmp->setValue($value);
                                $tmp->insert();
                            }
                        } catch (Exception $fieldEx) {

                        }
                    }

                    SQLObject::TransactionCommit();

                    // очищаем корзину
                    Shop::Get()->getShopService()->clearBasket();

                    // создание документов
                    if (Shop_ModuleLoader::Get()->isImported('document')) {
                        $this->setValue('documentsArray', $this->_addDocuments($issue));
                    }

                    $this->setValue('message', 'ok');
                    $this->setValue('messageIssueInfo', array('id' => $issue->getId(), 'url' => $issue->makeURLEdit()));

                    if ($this->getArgumentSecure('ok')) {
                        $this->setValue('urlredirect', $issue->makeURLEdit());
                    } else {
                        $this->setValue('clearFields', true);
                    }
                } catch (Exception $ge) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue(
                        'errorText',
                        implode(
                            '<br />',
                            Shop_ContentErrorHandler::Get()->getErrorValueArray($ge)
                        )
                    );
                }
            }

            $dedaultUserId = $this->getArgumentSecure('clientid');
            $defaultUser = false;
            if ($dedaultUserId) {
                try {
                    $defaultUser = Shop::Get()->getUserService()->getUserByID($dedaultUserId);
                    $this->setValue('clientname', $defaultUser->makeName());
                    $this->setValue('contact_phone', $defaultUser->getPhone());
                    $this->setValue('contact_email', $defaultUser->getEmail());
                    $this->setValue('contact_skype', $defaultUser->getSkype());
                    $this->setValue('contact_whatsapp', $defaultUser->getWhatsapp());
                } catch (Exception $ue) {

                }
            }

            try {
                $eventID = $this->getArgument('eventid');
                $events = EventService::Get()->getEventsAll();
                $events->setId($eventID);

                $block = Engine::GetContentDriver()->getContent('event-list-block');
                $block->setValue('events', $events);
                $block->setValue('showhidden', true);
                $block->setValue('noFilter', true);
                $this->setValue('block_event', $block->render());
            } catch (Exception $eventEx) {

            }

            // менеджеры
            $user = $this->getUser();
            $this->setValue('userId', $user->getId());
            $managers = Shop::Get()->getUserService()->getUsersManagers($user);
            $a = array();
            if ($this->getControlValue('managerid')) {
                $selectedManagerId = $this->getControlValue('managerid');
            } else {
                $selectedManagerId = $user->getId();
            }

            while ($x = $managers->getNext()) {
                $selected = false;
                if ($selectedManagerId == $x->getId()) {
                    $selected = true;
                }
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'selected' => $selected
                );
            }
            $this->setValue('managerArray', $a);

            // список источников
            $source = Shop::Get()->getShopService()->getSourceAll();
            $a = array();
            while ($x = $source->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                );
            }
            $this->setValue('sourceArray', $a);

            // какой таб?
            if ($this->getArgumentSecure('workflowid')) {
                $this->setValue('workflowid', $this->getArgumentSecure('workflowid'));
                try{
                    $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                        $this->getArgumentSecure('workflowid')
                    );
                    $this->setValue('tabIssueSelected', $workflow->getType());
                } catch (Exception $e2) {
                    $this->setValue('tabIssueSelected', @$_COOKIE['issue-add-tab']);
                }

            } else {
                $this->setValue('tabIssueSelected', @$_COOKIE['issue-add-tab']);
            }

            // список шаблонов
            if (Shop_ModuleLoader::Get()->isImported('document')) {
                $templates = DocumentService::Get()->getDocumentTemplatesByClassname('ShopOrder');
                $templateArray = array();
                while ($x = $templates->getNext()) {
                    if ($this->getUser()->isAllowed('document-print-'.$x->getId())) {
                        $templateArray[] = array(
                            'id' => $x->getId(),
                            'name' => htmlspecialchars($x->getName()),
                        );
                    }
                }
                $this->setValue('templateArray', $templateArray);
            }

            // способы доставки
            $deliveryArray = array();
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            while ($x = $delivery->getNext()) {
                $price = 0;
                if ($x->getPrice() > 0) {
                    $price = Shop::Get()->getCurrencyService()->convertCurrency(
                        $x->getPrice(),
                        $x->getCurrency(),
                        Shop::Get()->getCurrencyService()->getCurrencySystem()
                    );
                }
                $deliveryArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'price' => $price,
                    'class' => $x->getLogicclass()
                );
            }
            $this->setValue('deliveryArray', $deliveryArray);

            // способы оплаты
            $paymentArray = array();
            $payment = Shop::Get()->getShopService()->getPaymentAll();
            $payment->filterHidden(0);
            while ($x = $payment->getNext()) {
                $paymentArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                );
            }
            $this->setValue('paymentArray', $paymentArray);

            // скидки
            $discountArray = array();
            $discount = Shop::Get()->getShopService()->getDiscountAll();
            while ($x = $discount->getNext()) {
                if ($x->getType() == 'percent') {
                    $currencyType = '%';
                } else {
                    try{
                        $currencyType = $x->getCurrency()->getSymbol();
                    } catch (Exception $e2) {
                        $currencyType = false;
                    }
                }

                $discountArray[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'type' => $currencyType,
                    'amount' => $x->getValue(),
                    'started' => $x->getMinstartsum()
                );
            }
            $this->setValue('discountArray', $discountArray);

            $this->setValue('docsListCookie', @$_COOKIE['docs-list']);

            // бизнес-процессы
            $workflows = Shop::Get()->getShopService()->getWorkflowsActive($this->getUser());
            $workflows->setType($type);
            $a = array();
            while ($x = $workflows->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(),
                    'default' => $x->getDefault()
                );
            }
            $this->setValue('workflowArray', $a);

            // дополнительные поля контактов
            $userField = new XShopContactField();
            $userField->setFilterable(1);
            $userField->setHidden(0);
            $userField->setGroupByQuery('idkey');

            $userFieldArray = array();
            while ($u = $userField->getNext()) {
                $defaultValue = false;
                if ($defaultUser) {
                    $userCustom = new XShopCustomField();
                    $userCustom->setObjecttype(get_class($defaultUser));
                    $userCustom->setObjectid($defaultUser->getId());
                    $userCustom->setKey($u->getIdkey());
                    $userCustom = $userCustom->getNext();
                    if ($userCustom) {
                        $defaultValue = $userCustom->getValue();
                    }
                }
                $userFieldArray[] = array(
                    'name' => $u->getName(),
                    'key' => $u->getIdkey(),
                    'value' => $defaultValue
                );
            }

            $this->setValue('userFieldArray', $userFieldArray);

            // блок поиска продуктов
            $showContainer = Engine::GetContentDriver()->getContent('shop-admin-orders-add-product-list');
            $this->setValue('block_product_list', $showContainer->render());

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    private function _makeCategoryArray() {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->setHidden(0);
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        return $this->_makeCategoryTree(0, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();

        if (empty($categoryArray[$parentID])) {
            return $a;
        }

        foreach ($categoryArray[$parentID] as $x) {
            $b = array();
            $x['level'] = $level;

            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);

            foreach ($childs as $y) {
                $b[] = $y;
            }

            $x['childsArray'] = $b;

            $a[] = $x;
        }
        return $a;
    }

    private function _addDocuments($issue) {
        $documentsArray = array();

        foreach ($this->getArguments() as $key => $item) {
            if (preg_match('/document_([\d]+)/iusD', $key, $res)) {
                try {
                    $object = DocumentService::Get()->getObjectByID(
                        $issue->getId(),
                        $issue->getClassname()
                    );

                    if (!method_exists($object, 'makeAssignArrayForDocument')) {
                        throw new ServiceUtils_Exception();
                    }

                    $document = DocumentService::Get()->addDocument(
                        $this->getUser(),
                        false,
                        $res[1],
                        $issue->getClassname().'-'.$issue->getId(),
                        false,
                        false,
                        false,
                        false,
                        false,
                        $object->makeAssignArrayForDocument()
                    );
                    $documentsArray[] = $document->getId();
                } catch (ServiceUtils_Exception $ee) {

                }
            }
        }

        return $documentsArray;
    }

}