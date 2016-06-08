<?php
class issue_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->import('CommentsAPI');

        try {

            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('id')
            );

            try {

                if (!Engine::Get()->getConfigFieldSecure('static-shop-menu')) {
                    $urlRedirect = $order->makeURLEdit();
                    header('Location: '.$urlRedirect);
                    exit();
                }
                // получаем заказ

                $this->setValue('orderId', $order->getId());

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

                if ($canEdit && $this->getControlValue('ok') && $this->getControlValue('statusid')) {
                    try {
                        SQLObject::TransactionStart();

                        $event = Events::Get()->generateEvent('shopOrderEditBefore');
                        $event->setOrder($order);
                        $event->notify();

                        // обновляем статус
                        Shop::Get()->getShopService()->updateOrderStatus(
                            $user,
                            $order,
                            $this->getControlValue('statusid')
                        );

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

                // сохраняем комментарий
                $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
                $block_comment->setValue('order', $order);
                $block_comment->render();

                $block_info = Engine::GetContentDriver()->getContent('admin-issue-block-info');
                $this->setValue('block_info', $block_info->render());

                // отображаем комментарии
                $block_comment = Engine::GetContentDriver()->getContent('shop-admin-orders-control-block-comment');
                $block_comment->setValue('order', $order);
                $block_comment->setValue('view', true);
                $this->setValue('block_comment', $block_comment->render());

                $block_processorform = Engine::GetContentDriver()->getContent(
                    'shop-admin-orders-control-block-processorform'
                );
                $block_processorform->setValue('order', $order);
                $this->setValue('block_processorform', $block_processorform->render());

                $parentArray = array();
                try {
                    $parent = $order->getParent();
                    while ($parent->getType() == 'issue') {
                        $parentArray[] = array(
                            'name' => ($parent->getName()) ? $parent->getName() : $parent->getNumber(),
                            'url' => $parent->makeURLEdit()
                        );

                        if ($parent->getId() == $parent->getParentid()) {
                            throw new ServiceUtils_Exception();
                        }

                        $parent = $parent->getParent();
                    }

                    $menu = Engine::GetContentDriver()->getContent('shop-admin-order-menu');
                    $menu->setValue('order', $parent);
                    $menu->setValue('issue', $order);
                    $menu->setValue('selected', 'issue');
                    $this->setValue('block_menu', $menu->render());
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('name', ($order->getName()) ? $order->getName() : $order->getNumber());
                    $this->setValue('url', $order->makeURLEdit());
                }
                $this->setValue('parentArray', array_reverse($parentArray));

                if ($this->getArgumentSecure('message' == 'ok')) {
                    $this->setValue('message', 'ok');

                    // редирект
                    header('Location: '.$order->makeURLEdit().'?message=ok');
                }

                $this->setValue(
                    'comments',
                    Shop::Get()->getShopService()->formatComment($order->getComments(), 'order-'.$order->getId())
                );

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
                $this->setValue('statusNextArray', $statusNextArray);

                // структура
                try {
                    $parent = $order->getParent();
                    $this->setValue('subIssueArray', $this->_makeIssueTree($parent->getId()));
                } catch (ServiceUtils_Exception $se) {
                    $this->setValue('subIssueArray', $this->_makeIssueTree(0, array(), array(), 0, true));
                }

                if (Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
                    $this->setValue('oneclickEnable', true);
                }

                // заголовок страницы
                Engine::GetHTMLHead()->setTitle($order->makeName());


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
     * Получить структуру задач в виде дерева
     *
     * @param int $parentID
     * @param array $issueArray
     * @param array $issueIDArray
     * @param int $level
     *
     * @return array
     */
    private function _makeIssueTree($parentID, $issueArray = array(), $issueIDArray = array(),
    $level = 0, $onlyIssues = false, $subIssues = false) {
        if (!$subIssues) {
            $subIssues = IssueService::Get()->getIssuesAll($this->getUser());
        }
        $subIssueClone = clone $subIssues;

        $subIssues->setParentid($parentID);
        $subIssues->setDateclosed('0000-00-00 00:00:00');
        $subIssues->setOrder('cdate', 'DESC');
        if ($onlyIssues && !$parentID) {
            $subIssues->setType('issue');
        }
        if (!$parentID) {
            $subIssues->setLimitCount(50);
        } else {
            $subIssues->setLimitCount(100);
        }

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
                    $sub->getId(), $issueArray, $issueIDArray, $level + 1, false, clone $subIssueClone
                );
            }
        }

        $subIssues = clone $subIssueClone;
        $subIssues->setParentid($parentID);
        $subIssues->addWhere('dateclosed', '0000-00-00 00:00:00', '<>');
        $subIssues->addWhere(
            'dateclosed',
            DateTime_Object::Now()->addDay(-7)->setFormat('Y-m-d H:i:s')->__toString(),
            '>='
        );
        $subIssues->setOrder('cdate', 'DESC');
        if ($onlyIssues && !$parentID) {
            $subIssues->setType('issue');
        }
        if (!$parentID) {
            $subIssues->setLimitCount(20);
        }

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
                    $sub->getId(), $issueArray, $issueIDArray, $level + 1, false, clone $subIssueClone
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