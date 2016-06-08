<?php
class project_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {
            // получаем заказ
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );
            try {

                if (!Engine::Get()->getConfigFieldSecure('static-shop-menu')) {
                    $urlRedirect = $order->makeURLEdit();
                    header('Location: '.$urlRedirect);
                    exit();
                }

                // текущий авторизированный пользователь
                $user = $this->getUser();

                // проверка прав пользователя на просмотр/управление этим заказом
                if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                    throw new ServiceUtils_Exception('access');
                }

                // referer url
                $referer = @$_SERVER['HTTP_REFERER'];
                if (!preg_match('#admin/shop/orders/[\d]+#iusD', $referer, $r)) {
                    @session_start();
                    @$_SESSION['order-referer'] = $referer;
                }

                $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
                $this->setValue('canEdit', $canEdit);

                // записываем в лог, что я посмотрел задачу
                Shop::Get()->getShopService()->addOrderLogView($order, $user);

                if ($canEdit && $this->getArgumentSecure('ok')) {
                    try {
                        SQLObject::TransactionStart();

                        $event = Events::Get()->generateEvent('shopOrderEditBefore');
                        $event->setOrder($order);
                        $event->notify();

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

                        } else {

                            // обновляем информацию о клиенте
                            $order->setClientname($this->getControlValue('clientname'));
                            $order->setClientaddress($this->getControlValue('clientaddress'));
                            $order->setClientphone($this->getControlValue('clientphone'));
                            $order->setClientemail($this->getControlValue('clientemail'));
                            // если у пользователя не прописаны данные записываем их из заказа(при oneclick-enable=true)
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
                        }

                        // обновляем менеджера заказа
                        try {
                            $manager = Shop::Get()->getUserService()->getUserByID(
                                $this->getControlValue('manager')
                            );

                            Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), $manager);
                        } catch (Exception $e) {
                            // убираем менеджера заказа
                            Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), 0);
                        }

                        // смена менеджера со стороны клиента
                        try {
                            $newClientManagerID = $this->getControlValue('changeclientmanager');
                            $newClientManager = Shop::Get()->getUserService()->getUserByID($newClientManagerID);

                            $order->setClientmanagerid($newClientManager->getId());
                        } catch (Exception $e) {

                        }

                        $order->update();

                        // обновляем статус
                        if ($this->getControlValue('status') || $this->getControlValue('status_menu')) {
                            if ($this->getControlValue('status_menu')) {
                                Shop::Get()->getShopService()->updateOrderStatus(
                                    $this->getUser(),
                                    $order,
                                    $this->getControlValue('status_menu')
                                );
                            } else {
                                Shop::Get()->getShopService()->updateOrderStatus(
                                    $this->getUser(),
                                    $order,
                                    $this->getControlValue('status')
                                );
                            }

                        }

                        // обновляем категорию
                        try {
                            $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                                $this->getControlValue('categoryid')
                            );

                            Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);
                        } catch (Exception $e) {

                        }

                        Shop::Get()->getShopService()->updateOrderEmployer(
                            $order,
                            $order->getStatus(),
                            $user,
                            $this->getControlValue('termEmployer'),
                            $this->getControlValue('managerEmployer')
                        );

                        $event = Events::Get()->generateEvent('shopOrderEditAfter');
                        $event->setOrder($order);
                        $event->notify();

                        SQLObject::TransactionCommit();

                        if (Engine::GetURLParser()->getArgumentSecure('message') != 'error') {
                            Engine::GetURLParser()->setArgument('message', 'ok');
                        }
                    } catch (Exception $te) {
                        SQLObject::TransactionRollback();

                        if (PackageLoader::Get()->getMode('debug')) {
                            print $te;
                        }

                        Engine::GetURLParser()->setArgument('message', 'error');

                        $this->setValue('message', 'error');
                        $this->setValue('errorsArray', $te->getErrorsArray());

                        $this->setValue(
                            'errorText',
                            implode(
                                '<br />',
                                Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                            )
                        );
                    }
                }

                $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
                $block_comment->setValue('order', $order);
                $block_comment->setValue('canEdit', $canEdit);
                $this->setValue('block_comment', $block_comment->render());

                $block_processorform = Engine::GetContentDriver()->getContent(
                    'shop-admin-orders-control-block-processorform'
                );
                $block_processorform->setValue('order', $order);
                $block_processorform->setValue('canEdit', $canEdit);
                $this->setValue('block_processorform', $block_processorform->render());

                $block_statistics = Engine::GetContentDriver()->getContent('admin-project-block-statistics');
                $block_statistics->setValue('project', $order);
                $block_statistics->setValue('canEdit', $canEdit);
                $this->setValue('block_statistics', $block_statistics->render());

                $block_managers = Engine::GetContentDriver()->getContent('admin-project-block-managers');
                $block_managers->setValue('project', $order);
                $block_managers->setValue('canEdit', $canEdit);
                $this->setValue('block_managers', $block_managers->render());

                $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                $menu->setValue('order', $order);
                $menu->setValue('selected', 'view');
                $menu->setValue('canEdit', $canEdit);
                $this->setValue('block_menu', $menu->render());

                if ($this->getArgumentSecure('message' == 'ok')) {
                    $this->setValue('message', 'ok');

                    // редирект
                    header('Location: '.$order->makeURLEdit().'?message=ok');
                }

                // получаем заказ
                $order = Shop::Get()->getShopService()->getOrderByID(
                    $this->getArgument('id')
                );

                if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                    $this->setValue('oneclickEnable', true);
                }

                // получаем все товары в заказе
                $orderproducts = $order->getOrderProducts();

                $a = array();
                $countProductAll = 0;
                while ($x = $orderproducts->getNext()) {
                    $product = false;
                    try {
                        // productid может быть не действительный,
                        // поэтому заключаем в try-catch
                        $product = $x->getProduct();
                    } catch (Exception $e) {

                    }

                    $productCount = $x->getProductcount();

                    try {
                        $sum = $x->makeSum($order->getCurrency());
                    } catch (Exception $priceEx) {
                        $sum = 0;
                    }

                    $countProductAll += $productCount;

                    // товары
                    @$a[] = array(
                        'id' => $x->getId(),
                        'name' => htmlspecialchars($x->getProductname()),
                        'productid' => $x->getProductid(),
                        'productUrl' => $product ? $product->makeURLEdit():false,
                        'count' => (float) $productCount,
                        'price' => $x->getProductprice(),
                        'sum' => $sum,
                        'currencySym' => $x->getCurrency()->getSymbol(),
                        'unit' => $product ? $product->getUnit() : false
                    );
                }

                $this->setValue('productsArray', $a);
                $this->setValue('allSum', $order->getSum());
                $this->setValue('countProductAll', $countProductAll);

                // заголовок страницы
                Engine::GetHTMLHead()->setTitle($order->makeName());

                $delivery2 = false;
                try {
                    $delivery2 = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
                } catch (Exception $e) {

                }

                // сумма заказа
                if ($delivery2 && $delivery2->getPaydelivery()) {
                    $this->setValue('totalSum', $order->getSum() + $order->getDeliveryprice());
                } else {
                    $this->setValue('totalSum', $order->getSum());
                    $this->setValue('payDelivery', true);
                }

                $this->setValue('deliveryPrice', $order->getDeliveryprice()); // стоимость доставки
                $this->setValue('currency', $order->getCurrency()->getSymbol());
                $this->setValue('orderName', $order->makeName());
                $this->setValue('discountSum', $order->getDiscountsum());


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

                // статусы заказа по workflow
                $statusNextArray = array();
                try {
                    $category = $order->getWorkflow();

                    $statusChanges = new XShopOrderStatusChange();
                    $statusChanges->filterCategoryid($category->getId());
                    $statusChanges->filterElementfromid($order->getStatusid());
                    $statusesArray = array();
                    while ($x = $statusChanges->getNext()) {
                        if ($x->getElementtoid() != $order->getStatusid()) {
                            try {
                                $orderStatus = Shop::Get()->getShopService()->getStatusByID($x->getElementtoid());

                                $statusNextArray[$orderStatus->getId()] = array(
                                    'id' => $orderStatus->getId(),
                                    'name' => $orderStatus->getName(),
                                    'colour' => $orderStatus->getColour()
                                );
                            } catch (ServiceUtils_Exception $sse) {

                            }
                        }
                    }
                } catch (Exception $e) {

                }
                $this->setValue('statusNext2Array', $statusNextArray);

                // статусы заказа
                $statusArray = array();
                try {
                    // статусы на основе категории
                    $category = $order->getWorkflow();

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
                $this->setControlValue('status', $order->getStatusid());

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

                try {
                    $this->setValue('statusName', $order->getStatus()->makeName());
                    $this->setValue('statusColor', $order->getStatus()->getColour());
                } catch (Exception $e) {

                }

                try {
                    $this->setValue('workflowName', $order->getWorkflow()->makeName());
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

                // менеджер на стороне клиента
                try {
                    $u = Shop::Get()->getUserService()->getUserByID($order->getClientmanagerid());
                    $this->setValue('clientManagerID', $u->getId());
                    $this->setValue('clientManagerName', $u->makeName(true, 'lfm'));
                    $this->setValue('clientManagerURL', $u->makeURLEdit());
                } catch (Exception $e) {

                }

                // менеджеры
                $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
                $a = array();
                while ($x = $managers->getNext()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->makeName(true, 'lfm'),
                    );
                }
                $this->setValue('managerArray', $a);

                $this->setControlValue('categoryid', $order->getCategoryid());
                $this->setControlValue('clientname', $order->getClientname());
                $this->setControlValue('clientemail', $order->getClientemail());
                $this->setControlValue('clientphone', $order->getClientphone());
                $this->setControlValue('clientaddress', htmlspecialchars($order->getClientaddress()));
                $this->setControlValue('managerid', $order->getManagerid());

                $this->setValue(
                    'comments',
                    Shop::Get()->getShopService()->formatComment($order->getComments(), 'order-'.$order->getId())
                );

                // этап
                try{
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($order->getId());
                    $employer->setStatusid($order->getStatus()->getId());
                    $employer = $employer->getNext();
                    if ($employer) {
                        $term = false;
                        if ($employer->getTerm() != '0000-00-00 00:00:00') {
                            $term = $employer->getTerm();
                        }
                        $this->setControlValue('termEmployer', $term);

                        $this->setControlValue('managerEmployer', $employer->getManagerid());

                        $this->setValue(
                            'managerNameEmployer',
                            Shop::Get()->getUserService()->getUserByID($employer->getManagerid())
                                ->makeName(false, 'lfm')
                        );
                        $this->setValue(
                            'managerUrlEmployer',
                            Shop::Get()->getUserService()->getUserByID($employer->getManagerid())->makeURLEdit()
                        );
                        $this->setValue('managerIdEmployer', $employer->getManagerid());
                    }
                } catch (Exception $ee2) {

                }

                // клиент
                try {
                    $client = $order->getClient();
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

                $this->setValue('sum', $order->makeSum());

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

                $this->setValue('subIssueArray', $this->_makeIssueTree($order->getId()));

                // есть ли открытые задачи?
                $allClosed = false;
                $subIssueCount = 0;
                if ($order->getStatusid()) {
                    $subIssue = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                    $subIssue->setParentid($order->getId());
                    $subIssue->setParentstatusid($order->getStatusid());
                    $allClosed = true;
                    while ($sub = $subIssue->getNext()) {
                        $subIssueCount++;
                        if ($sub->getDateclosed() == '0000-00-00 00:00:00') {
                            $allClosed = false;
                            break;
                        }
                    }
                }

                $this->setValue('allClosed', $subIssueCount ? $allClosed:false);

                $fire = Shop::Get()->getShopService()->isFireOrder($order);
                $this->setValue('fireIssue', $fire);

                $fire = Shop::Get()->getShopService()->isFireOrderStatus($order);
                $this->setValue('fireIssueStatus', $fire);

                // исполнители
                $watchers = Shop::Get()->getShopService()->getOrderUserNotifyArray($order, '');
                $a = array();
                foreach ($watchers as $x) {
                    try {
                        $a[] = array(
                            'id' => $x->getId(),
                            'name' => $x->makeName(true, 'lfm'),
                            'url' => $x->makeURLEdit(),
                        );
                    } catch (Exception $e) {

                    }
                }
                $this->setValue('watcherArray', $a);

                // файлы-вложения
                $files = new ShopFile();
                $files->setKey('order-'.$order->getId());
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
                        'cdate' => $x->getCdate(),
                        'size' => $x->makeSize(),
                        'urlDelete' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                            array(
                                'filedelete' => $x->getId()
                            )
                        ),
                    );
                }
                $this->setValue('fileArray', $a);

                $this->setValue('commentTemplateArray', Shop::Get()->getShopService()->getCommentTemplatesArray());

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


            } catch (ServiceUtils_Exception $ge) {

                if ($ge->getMessage() == 'access') {

                    throw new ServiceUtils_Exception('403', 403);

                } else {

                    throw new ServiceUtils_Exception('500 Internal Server Error', 500);
                }

            }

        } catch (ServiceUtils_Exception $ge) {

            if ($ge->getCode() == 500) {

                LogService::Get()->add();
                Engine::Get()->getRequest()->setContentServerError();
                return;

            }

            if ($ge->getCode() == 403) {

                Engine::Get()->getRequest()->setContentID(403);
                return;

            }

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }


            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Построить структуру проекта
     *
     * @param int $parentID
     * @param array $issueArray
     * @param array $issueIDArray
     * @param int $level
     *
     * @return array
     */
    private function _makeIssueTree(
        $parentID, $issueArray = array(), $issueIDArray = array(), $level = 0, $subIssues = false
    ) {
        if (!$subIssues) {
            $subIssues = IssueService::Get()->getIssuesAll($this->getUser());
        }

        $subIssuesRecursion = clone $subIssues;

        $subIssues->setParentid($parentID);
        $subIssues->setDateclosed('0000-00-00 00:00:00');
        $subIssues->setOrder('cdate', 'DESC');
        $subIssues->setLimitCount(100);
        while ($sub = $subIssues->getNext()) {
            if (in_array($sub->getId(), $issueIDArray)) {
                continue;
            }

            $issueIDArray[] = $sub->getId();

            $a = $this->_makeIssueArray($sub);
            $a['level'] = $level;
            $issueArray[] = $a;

            if ($sub->getId() != $parentID) {
                $issueArray = $this->_makeIssueTree(
                    $sub->getId(),
                    $issueArray,
                    $issueIDArray,
                    $level+1,
                    clone $subIssuesRecursion
                );
            }
        }

        $subIssues = clone $subIssuesRecursion;
        $subIssues->setParentid($parentID);
        $subIssues->addWhere('dateclosed', '0000-00-00 00:00:00', '<>');
        $subIssues->addWhere(
            'dateclosed',
            DateTime_Object::Now()->addDay(-7)->setFormat('Y-m-d H:i:s')->__toString(),
            '>='
        );
        $subIssues->setOrder('cdate', 'DESC');

        while ($sub = $subIssues->getNext()) {
            if (in_array($sub->getId(), $issueIDArray)) {
                continue;
            }

            $issueIDArray[] = $sub->getId();

            $a = $this->_makeIssueArray($sub);
            $a['level'] = $level;
            $a['closed'] = 1;
            $issueArray[] = $a;

            if ($sub->getId() != $parentID) {
                $issueArray = $this->_makeIssueTree(
                    $sub->getId(),
                    $issueArray,
                    $issueIDArray,
                    $level+1,
                    clone $subIssuesRecursion
                );
            }
        }

        return $issueArray;
    }

    /**
     * Получить массив информации о задаче
     *
     * @param ShopOrder $issue
     *
     * @return array
     */
    private function _makeIssueArray(ShopOrder $issue) {
        $a = array();

        $managerName = false;
        $managerUrl = false;
        try {
            $managerName = $issue->getManager()->makeName(true, 'lfm');
            $managerUrl = $issue->makeURLEdit();
        } catch (Exception $ee) {

        }

        $dateto = false;
        $fire = Shop::Get()->getShopService()->isFireOrder($issue);
        if (!$fire && $issue->getType() != 'issue') {
            $fire = Shop::Get()->getShopService()->isFireOrderStatus($issue);
        }

        if ($issue->getDateto()) {
            $dateto = $issue->getDateto();
            $dateto = DateTime_Formatter::DatePhoneticMonthRus(
                DateTime_Object::FromString($dateto)->setFormat('d-m-Y')
            );
        }

        $a = array(
            'id' => $issue->getId(),
            'name' => $issue->getName(),
            'url' => $issue->makeURLEdit(),
            'managerName' => $managerName,
            'managerUrl' => $managerUrl,
            'dateto' => $dateto,
            'fire' => $fire
        );

        return $a;
    }

}