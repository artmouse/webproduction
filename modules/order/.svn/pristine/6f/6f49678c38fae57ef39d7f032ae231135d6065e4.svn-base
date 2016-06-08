<?php
class custom_order_menu extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        $order = $this->_getOrder();
        $this->setValue('typeName', $order->getTypeName());
        try {
            $type = $this->getArgument('type');
            $this->setValue('type', $type);
        } catch (Exception $etype) {
            $type = $order->getWorkflow()->getType();
            $this->setValue('type', $type);
        }

        $menucolor = false;
        try {
            $menucolor = $order->getWorkflow()->getColorMenu();
        } catch (Exception $eworkflow) {

        }

        if (!$menucolor) {
            $menucolor = Shop::Get()->getSettingsService()->getSettingValue('color-menu');
        }
        $this->setValue('menuColor', $menucolor);

        $urlFrom = @$_SERVER['HTTP_REFERER'];
        if ($urlFrom && @$_SESSION['orderRefererID'] != $order->getId()) {
            $_SESSION['orderRefererURL'] = $urlFrom;
            $_SESSION['orderRefererID'] = $order->getId();
        }
        $this->setValue('urlBack', @$_SESSION['orderRefererURL']);

        if (@$_SESSION['orderMenu'.$order->getId()]) {
            $this->setValue('menuAnimation', false);
        } else {
            $_SESSION['orderMenu'.$order->getId()] = 1;
            $this->setValue('menuAnimation', true);
        }
        // текущий авторизированный пользователь
        $user = $this->getUser();

        // проверка прав пользователя на просмотр/управление этим заказом
        if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
            throw new ServiceUtils_Exception('access');
        }

        if ($this->getArgumentSecure('watch')) {
            try {
                if ($this->getArgumentSecure('watchvalue')) {
                    Shop::Get()->getShopService()->addOrderEmployer($order, $user);
                } else {
                    Shop::Get()->getShopService()->deleteOrderEmployer($order, $user);
                }
            } catch (ServiceUtils_Exception $se) {

            }
        }

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);
        $this->setValue('canDelete', $user->isAllowed('order-delete') || $user->isAllowed('project-delete'));

        $this->setValue('isDeleted', $order->getDeleted());

        $this->setValue('isProject', ($order->getType() == 'project'));

        if ($issue = $this->getValue('issue')) {
            $this->setValue('issueName', ($issue->getName())?$issue->getName():$issue->getNumber());
            $this->setValue('issueURL', $issue->makeURLEdit());
            $parentID = $issue->getParentid();
        } else {
            $parentID = $order->getId();
        }

        $parentArray = array();
        while ($parentID) {
            try {
                $parent = Shop::Get()->getShopService()->getOrderByID($parentID);

                $parentArray[] = array(
                    'id' => $parent->getId(),
                    'name' => ($parent->getName()) ? $parent->getName() : $parent->getNumber(),
                    'url' => $parent->makeURLEdit()
                );

                if ($parentID == $parent->getParentid()) {
                    $parentID = false;
                } else {
                    $parentID = $parent->getParentid();
                }
            } catch (ServiceUtils_Exception $se) {
                $parentID = false;
            }
        }
        $this->setValue('parentArray', array_reverse($parentArray));

        $this->setValue('fireIssue', Shop::Get()->getShopService()->isFireOrder($order));

        $this->setValue('orderid', $order->getId());
        $this->setValue('orderNumber', $order->getNumber());
        $name = htmlspecialchars($order->getName());
        if (!$name) {
            $name = $order->getNumber();
        }
        $this->setValue('orderName', $name);
        $this->setValue('number', $order->getNumber());

        $description = '';

        // последний комментарий
        $commentKey = 'shop-order-'.$order->getId();
        $comments = CommentsAPI::Get()->getComments($commentKey);
        $comments->setLimitCount(1);
        $comments->setOrder('id', 'DESC');
        if ($x = $comments->getNext()) {
            try {
                $description .= Shop::Get()->getUserService()->getUserByID($x->getId_user())->makeName(true, 'lfm');
                $description .= ': ';
            } catch (Exception $commentEx) {

            }
            try {
                $description .= StringUtils_Limiter::LimitWordsSmart(strip_tags($x->getContent()), 50);
                if ($description) {
                    $description .= nl2br("\n");
                }
            } catch (Exception $commentEx) {

            }
        }

        try {
            $client = $order->getClient();

            if ($client->getImage()) {
                $this->setValue('image', $client->makeImageThumb());
                $this->setValue('bigImage', '/media/shop/'.$client->getImage());
            }

            $description .= $client->makeName().'. ';
        } catch (Exception $e) {

        }

        try {
            if ($order->getStatus()->getPrepayed() || $order->getStatus()->getPayed()) {
                $balance = $order->makeSumBalance();
                if ($balance < 0) {
                    $description .= 'Долг: '.$balance.' '.$order->getCurrency()->getSymbol().' ';
                } elseif ($balance > 0) {
                    $description .= 'Переплата: '.$balance.' '.$order->getCurrency()->getSymbol().' ';
                }
            }
        } catch (Exception $e) {

        }

        $this->setValue('description', $description);

        $isWatcher = Shop::Get()->getShopService()->isEmployer($order, $user);
        $this->setValue('isWatcher', $isWatcher);
        $this->setValue(
            'urlWatch',
            Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                array(
                    'watch' => 1,
                    'watchvalue' => !$isWatcher
                )
            )
        );

        // проект
        try {
            $project = $order->getParent();
            $this->setValue('projectUrl', $project->makeURLEdit());
            $projectName = new XShopWorkflowType();
            $this->setValue('projectName', $project->getTypeName());
        } catch (Exception $eproject) {

        }

        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);

        try{
            $workflow = $order->getWorkflow();
            $tabMenuWorkflow = new XShopWorkflowMenu();
            $tabMenuWorkflow->setWorkflowid($workflow->getId());

            $tabMenuArray = array();
            $parent = false;
            while ($x = $tabMenuWorkflow->getNext()) {
                if ($x->getName() == 'parent') {
                    $parent = true;
                }
                $tabMenuArray[$x->getName()] = $x->getName();
            }

            if ($parent) {
                try{
                    $workflow =  $this->getWorkflowParentOrderWithMenu($order);
                    $tabMenuWorkflow = new XShopWorkflowMenu();
                    $tabMenuWorkflow->setWorkflowid($workflow->getId());

                    $tabMenuArray = array();
                    while ($x = $tabMenuWorkflow->getNext()) {
                        $tabMenuArray[$x->getName()] = $x->getName();
                    }

                    $this->setValue('typeName', $order->getTypeName());
                } catch (Exception $eparent) {

                }
            }
            $this->setValue('tabMenuArray', $tabMenuArray);
            // дополнительные табы от модулей
            $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray($user);
            foreach ($moduleTabArray as $k => $moduleTabInfo) {
                if (!in_array($moduleTabInfo['contentID'], $tabMenuArray)) {
                    unset($moduleTabArray[$k]);
                    continue;
                }

                $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParams(
                    $moduleTabInfo['contentID'],
                    array(
                        'type' => $type,
                        'id' => $order->getId()
                    )
                );
            }
            $this->setValue('moduleTabArray', $moduleTabArray);

        } catch (Exception $eworkflow) {
            // дополнительные табы от модулей
            $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray($user);
            foreach ($moduleTabArray as $k => $moduleTabInfo) {
                $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParams(
                    $moduleTabInfo['contentID'],
                    array(
                        'type' => $type,
                        'id' => $order->getId()
                    )
                );
            }
            $this->setValue('moduleTabArray', $moduleTabArray);
        }

        $issues = IssueService::Get()->getIssuesAll($this->getUser());
        $issues->setParentid($order->getId());
        $issues->setDateclosed('0000-00-00 00:00:00');
        $issues->unsetField('type');


        $typeWorkflow = new XShopWorkflowType();
        $typeWorkflowArray = array();
        while ($w = $typeWorkflow->getNext()) {
            $cloneIssues = clone $issues;
            $cloneIssues->setType($w->getType());
            $count = $cloneIssues->getCount();

            $typeWorkflowArray[] = array(
                'id' => $w->getId(),
                'type' => $w->getType(),
                'name' => $w->getMultiplename() ? $w->getMultiplename() : $w->getName(),
                'count' => $count
            );
        }

        $this->setValue('typeWorkflowArray', $typeWorkflowArray);

        try {
            $status = $order->getStatus();

            $this->setValue('statusName', $status->getName());
            $this->setValue('statusColor', $status->getColour() ? $status->getColour() : '#dbe6f4');
        } catch (Exception $estatus) {

        }
    }

    public function getWorkflowParentOrderWithMenu (ShopOrder $order) {
        $parent = $order->getParent();
        $parentWorkflow = $parent->getWorkflow();
        $tabMenuWorkflow = new XShopWorkflowMenu();
        $tabMenuWorkflow->setWorkflowid($parentWorkflow->getId());
        $count = 0;
        while ($x = $tabMenuWorkflow->getNext()) {
            if ($x->getName() == 'parent') {
                return $this->getWorkflowParentOrderWithMenu($parent);
            } elseif ($x->getName() != 'closed') {
                $count++;
            }
        }

        if ($count) {
            return $parentWorkflow;
        }

        throw new ServiceUtils_Exception();
    }

}