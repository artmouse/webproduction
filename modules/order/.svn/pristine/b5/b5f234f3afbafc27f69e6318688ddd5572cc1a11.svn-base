<?php
class orders_info extends Engine_Class {

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

            $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
            $menu->setValue('order', $order);
            $menu->setValue('selected', 'info');
            $this->setValue('block_menu', $menu->render());

            // записываем в лог, что я посмотрел заказ
            Shop::Get()->getShopService()->addOrderLogView($order, $user);

            // режим box?
            $isBox = Engine::Get()->getConfigFieldSecure('project-box');
            $this->setValue('box', $isBox);

            $workflowVisualEnable = Engine::Get()->getConfigFieldSecure('workflow-visual-enable');
            $this->setValue('workflowVisualEnable', $workflowVisualEnable);

            // когда нажата кнопка Сохранить
            if ($canEdit && $this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $event = Events::Get()->generateEvent('shopOrderEditBefore');
                    $event->setOrder($order);
                    $event->notify();

                    if ($isBox) {
                        // обновляем проект (это родительская задача)
                        try {
                            $projectID = $this->getArgument('projectid', 'int');
                            $order->setParentid($projectID);
                        } catch (Exception $e) {

                        }
                    }

                    // смена менеджера со стороны клиента
                    try {
                        $newClientManagerID = $this->getControlValue('changeclientmanager');
                        $newClientManager = Shop::Get()->getUserService()->getUserByID($newClientManagerID);

                        $order->setClientmanagerid($newClientManager->getId());
                    } catch (Exception $e) {

                    }

                    // обновляем направление заказа
                    try {
                        $direction = $this->getArgument('direction', 'int');
                        $order->setOutcoming($direction);
                    } catch (Exception $e) {

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

                    // обновляем юридическое лицо
                    try {
                        $contractor = Shop::Get()->getShopService()->getContractorByID(
                            $this->getControlValue('contractor')
                        );
                        $order->setContractorid($contractor->getId());
                    } catch (Exception $e) {
                        $order->setContractorid(0);
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
                        implode('<br />', Shop_ContentErrorHandler::Get()->getErrorValueArray($te))
                    );
                }

            }

            $this->setValue('currency', $order->getCurrency()->getSymbol());
            $this->setValue('orderid', $order->getId());

            $this->setControlValue('categoryid', $order->getCategoryid());
            $this->setControlValue('sourceid', $order->getSourceid());
            $this->setControlValue('contractorid', $order->getContractorid());
            $this->setControlValue('direction', $order->getOutcoming());
            $this->setControlValue('estimatetime', $order->getEstimate());
            $this->setControlValue('estimatemoney', $order->getMoney());

            try {
                $this->setValue('contractorName', $order->getContractor()->makeName());
            } catch (Exception $e) {

            }

            try {
                $this->setValue('workflowName', $order->getWorkflow()->makeName());
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
            }

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

            // клиент
            try {
                $u = $order->getUser();
                $this->setValue('orderClientCompany', $u->getTypesex() == 'company' ? true : false);
                $this->setValue('clientID', $u->getId());
                $this->setValue('clientName', $u->makeName());
                $this->setValue('clientURL', $u->makeURLEdit());
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

            $this->setValue('oneclickEnable', Engine::Get()->getConfigFieldSecure('oneclick-enable'));

            if ($isBox) {
                $this->setControlValue('projectid', $order->getParentid());

                // проект
                try {
                    $project = $order->getParent();
                    $this->setValue('projectName', $project->makeName());
                    $this->setValue('projectURL', $project->makeURLEdit());
                } catch (Exception $e) {

                }
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }
}