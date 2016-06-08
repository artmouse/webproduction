<?php
class issue_block_info extends Engine_Class {

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

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    // обновляем проект (это родительская задача)
                    try {
                        $projectID = $this->getArgument('projectid', 'int');
                        if ($projectID != $order->getParentid()) {
                            Shop::Get()->getShopService()->updateIssueParent(
                                $order,
                                $user,
                                Shop::Get()->getShopService()->getOrderByID($projectID)
                            );
                        }
                    } catch (Exception $e) {

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
                    $name = $this->getArgumentSecure('name');
                    if ($order->getName() && !$name) {
                        throw new ServiceUtils_Exception('name');
                    }
                    $order->setName($name);

                    // обновляем описанние
                    $order->setComments($this->getControlValue('comments'));

                    $newUserID = $this->getControlValue('changeuser');
                    if ($newUserID) {
                        try {
                            $newUser = Shop::Get()->getUserService()->getUserByID($newUserID);

                            Shop::Get()->getShopService()->updateOrderUser($order, $user, $newUser);

                            Engine::GetURLParser()->setArgument('clientname', $newUser->makeName(false));
                            Engine::GetURLParser()->setArgument('clientaddress', $newUser->getAddress());
                            Engine::GetURLParser()->setArgument('clientphone', $newUser->getPhone());
                            Engine::GetURLParser()->setArgument('clientemail', $newUser->getEmail());
                        } catch (Exception $userEx) {
                            Shop::Get()->getShopService()->updateOrderUser($order, $user, false);
                        }

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


                    $updateCategory = false;
                    // обновляем категорию
                    try {
                        $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                            $this->getControlValue('categoryid')
                        );

                        $updateCategory = Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);
                    } catch (Exception $e) {

                    }

                    // обновляем менеджера заказа
                    if (!$order->getStatus()->getJumpmanager()) {
                        try {
                            $manager = Shop::Get()->getUserService()->getUserByID(
                                $this->getControlValue('manager')
                            );

                            Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), $manager);
                        } catch (Exception $e) {
                            // убираем менеджера заказа
                            Shop::Get()->getShopService()->updateOrderManager($order, $this->getUser(), false);
                        }
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

                    // обновляем заказ
                    $order->update();

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

                    $this->setValue(
                        'errorText',
                        implode(
                            '<br />',
                            Shop_ContentErrorHandler::Get()->getErrorValueArray($te)
                        )
                    );
                }
            }

            $this->setControlValue('status', $order->getStatusid());
            $this->setControlValue('managerid', $order->getManagerid());
            $this->setControlValue('categoryid', $order->getCategoryid());
            $this->setControlValue('cdate', $order->getCdate());
            $this->setControlValue('dateto', $order->getDateto());
            $this->setControlValue('number', $order->getNumber());
            $this->setControlValue('name', $order->getName());
            $this->setControlValue('projectid', $order->getParentid());
            $this->setControlValue('comments', $order->getComments());

            $this->setValue('name', $order->getName());
            $this->setValue(
                'comments',
                Shop::Get()->getShopService()->formatComment(
                    $order->getComments(),
                    'order-'.$order->getId()
                )
            );
            $this->setValue('url', $order->makeURLEdit());

            try {
                $this->setValue('workflowName', $order->getWorkflow()->makeName());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('statusName', $order->getStatus()->makeName());
                $this->setValue('statusColor', $order->getStatus()->getColour());
                $this->setValue('statusContent', nl2br(htmlspecialchars($order->getStatus()->getContent())));
            } catch (Exception $e) {

            }

            // проект
            try {
                $project = $order->getParent();
                $this->setValue('projectName', $project->makeName());
                $this->setValue('projectURL', $project->makeURLEdit());
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

            // бизнес-процессы
            $workflows = Shop::Get()->getShopService()->getWorkflowsAll(
                $this->getUser(),
                $order->getWorkflowid()
            );
            $a = array();
            while ($x = $workflows->getNext()) {
                if ($x->getHidden() && $x->getId() != $order->getWorkflowid()) {
                    continue;
                }
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
                );
            }
            $this->setValue('workflowArray', $a);

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

            // список пройденых этапов
            $statusArray = array();
            $orderChange = new XShopOrderChange();
            $orderChange->setOrderid($order->getId());
            $orderChange->setKey('statusid');
            while ($x = $orderChange->getNext()) {
                try{
                    $status = Shop::Get()->getShopService()->getStatusByID($x->getValue());
                    $statusArray[] = array(
                        'name' => $status->getName(),
                        'color' => $status->getColour()
                    );
                } catch (Exception $estatus) {

                }

            }
            $this->setValue('statusedArray', $statusArray);

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