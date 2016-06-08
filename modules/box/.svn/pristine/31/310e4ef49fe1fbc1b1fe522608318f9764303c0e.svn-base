<?php
class box_block_info extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        // получаем заказ
        $order = $this->_getOrder();
        $process = $this->getValue('process');

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

        // режим box?
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        $workflowVisualEnable = Engine::Get()->getConfigFieldSecure('workflow-visual-enable');
        $this->setValue('workflowVisualEnable', $workflowVisualEnable);

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {
            // обновляем проект (это родительская задача)
            try {
                $projectID = $this->getArgument('projectid', 'int');
                $order->setParentid($projectID);
            } catch (Exception $e) {

            }

            // обновляем менеджера заказа
            try{
                $managerId = $this->getArgument('manager');
                try {
                    $manager = Shop::Get()->getUserService()->getUserByID($managerId);

                    Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), $manager);
                } catch (Exception $e) {
                    // убираем менеджера заказа
                    Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), false);
                }
            } catch (Exception $emanager) {

            }

            // обновляем информацию о клиенте
            try{
                $order->setClientname($this->getArgument('clientname'));
            } catch (Exception $eclientname) {

            }

            try{
                $order->setClientaddress($this->getArgument('clientaddress'));
            } catch (Exception $eclientaddress) {

            }

            try{
                $order->setClientphone($this->getArgument('clientphone'));
            } catch (Exception $eclientphone) {

            }

            try{
                $order->setClientemail($this->getArgument('clientemail'));
            } catch (Exception $eclientemail) {

            }


            try {
                $orderUser = $order->getClient();
                if (!$orderUser->getAddress()) {
                    try{
                        $orderUser->setAddress($this->getArgument('clientaddress'));
                    } catch (Exception $eclientaddress) {

                    }
                }
                if (!$orderUser->getPhone()) {
                    try{
                        $orderUser->setPhone($this->getArgument('clientphone'));
                    } catch (Exception $eclientphone) {

                    }
                }
                if (!$orderUser->getEmail()) {
                    try{
                        $orderUser->setEmail($this->getArgument('clientemail'));
                    } catch (Exception $eclientemail) {

                    }
                }
                if (!$orderUser->getName()) {
                    try{
                        $orderUser->setName($this->getArgument('clientname'));
                    } catch (Exception $eclientname) {

                    }
                }
                $orderUser->update();

            } catch (Exception $e) {

            }

            try{
                $newUserID = $this->getControlValue('changeuser');
                try {
                    $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);

                    Shop::Get()->getShopService()->updateOrderUser($order, $user, $newUser);

                    Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(true, 'lfm'));
                    Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                    Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                    Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
                } catch (Exception $e) {

                }
            } catch (Exception $echangeuser) {

            }


            if ($this->getArgumentSecure('updateUserInfo') && $user->isAllowed('users')) {
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
            try{
                $number = $this->getArgument('number');

            } catch (Exception $enumber) {
                $number = false;
            }

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
                Shop::Get()->getShopService()->updateOrderName($order, $this->getUser(), $name);
            } catch (Exception $ename) {

            }

            $updateCategory = false;

            // обновляем категорию
            try {
                $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                    $this->getArgument('categoryid')
                );

                $updateCategory = Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);
            } catch (Exception $ecategoryid) {
                //$order->setCategoryid(0);
                //$order->setIssue(0);
            }

            // обновляем статус
            try {
                $statusid = $this->getArgument('info_status');
            } catch (Exception $estatusid) {
                $statusid = false;
            }

            if ($statusid && !$updateCategory) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $this->getUser(),
                    $order,
                    $statusid
                );
            }

            // обновляем оплату заказа
            try{
                $order->setPaymentid($this->getArgument('payment'));
            } catch (Exception $e) {

            }

            // обвновляем доставку
            try{
                $order->setDeliveryid($this->getArgument('delivery'));
            } catch (Exception $e) {

            }

            // обновляем накладную доставки
            try{
                $order->setDeliverynote($this->getArgument('deliveryNote'));
            } catch (Exception $e) {

            }

            // обновляем юридическое лицо
            try {
                $contractorId = $this->getArgument('contractor');
                if ($contractorId) {
                    $contractor = Shop::Get()->getShopService()->getContractorByID(
                        $this->getArgument('contractor')
                    );
                    $order->setContractorid($contractor->getId());
                } else {
                    $order->setContractorid($contractorId);
                }

            } catch (Exception $e) {

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

            // обновляем дату оформления
            try{
                $cdate = $this->getArgument('cdate', 'datetime');
                if (!empty($cdate)) {
                    $order->setCdate($cdate);
                } else {
                    $order->setCdate('');
                }
            } catch (Exception $e) {

            }

            // обновляем источник
            try {
                $sourceId = $this->getArgument('sourceid');
                if ($sourceId) {
                    $source = Shop::Get()->getShopService()->getSourceByID(
                        $sourceId
                    );

                    $order->setSourceid($source->getId());
                } else {
                    $order->setSourceid(0);
                }

            } catch (Exception $e) {

            }

            // смена менеджера со стороны клиента
            try {
                $newClientManagerID = $this->getArgument('changeclientmanager');
                $newClientManager = Shop::Get()->getUserService()->getUserByID($newClientManagerID);

                $order->setClientmanagerid($newClientManager->getId());
            } catch (Exception $e) {

            }


            // обновляем дату выполнения
            try {
                $dateto = $this->getArgument('dateto', 'datetime');
                Shop::Get()->getShopService()->updateOrderDateto($order, $this->getUser(), $dateto);
            } catch (Exception $de) {

            }

            // считаем все суммы заказа
            Shop::Get()->getShopService()->recalculateOrderSums($order);

            // обновляем заказ
            $order->update();

            if ($order->getOutcoming() && ($order->getSum() > 0)) {
                $order->setSum($order->getSum() * (-1));
                $order->update();
            }

            // сохранение дополнительных полей
            foreach ($customFieldArray as $key => $x) {
                try{
                    $value = $this->getArgument('custom_'.$key);

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
                } catch (Exception $ecustom) {

                }

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

        try {
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

        // кто автор заказа
        try {
            $u = $order->getAuthor();
            $this->setValue('authorID', $u->getId());
            $this->setValue('authorName', $u->makeName(true, 'lfm'));
            $this->setValue('authorURL', $u->makeURLEdit());
        } catch (Exception $e) {

        }

        // проект
        try {
            $project = $order->getParent();
            $this->setValue('projectName', $project->makeName());
            $this->setValue('projectURL', $project->makeURLEdit());
        } catch (Exception $e) {

        }

        // источник заказа
        try {
            $this->setValue('sourceName', $order->getSource()->makeName());
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

        // источники
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        $this->setValue('currency', $order->getCurrency()->getSymbol());
        $this->setValue('orderid', $order->getId());
        $this->setValue('orderNumber', $order->getNumber());
        $this->setValue('orderName', $order->makeName());

        $this->setControlValue('sourceid', $order->getSourceid());
        $this->setControlValue('contractorid', $order->getContractorid());
        $this->setControlValue('info_status', $order->getStatusid());
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
            $this->setValue('workflowId', $order->getWorkflow()->getId());
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

        // кто менеджер заказа
        try {
            $u = $order->getManager();
            $this->setValue('managerID', $u->getId());
            $this->setValue('managerName', $u->makeName(true, 'lfm'));
            $this->setValue('managerURL', $u->makeURLEdit());
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

        try {
            $this->setValue('contractorName', $order->getContractor()->makeName());
        } catch (Exception $e) {

        }

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // клиент
        try {
            $u = $order->getUser();
            $this->setValue('orderClientCompany', $u->getTypesex() == 'company' ? true : false);
            $this->setValue('clientID', $u->getId());
            $this->setValue('clientName', $u->makeName(true, 'lfm'));
            $this->setValue('clientURL', $u->makeURLEdit());
        } catch (Exception $e) {

        }

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
                    'allClosed' => $subIssueCount ? $allClosed : false,
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

    }

}