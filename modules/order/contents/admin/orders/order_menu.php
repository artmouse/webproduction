<?php
class order_menu extends Engine_Class {

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

        $menucolor = false;
        try {
            $menucolor = $order->getWorkflow()->getColorMenu();
        } catch (Exception $eworkflow) {

        }

        if (!$menucolor) {
            $menucolor = Shop::Get()->getSettingsService()->getSettingValue('color-menu');
        }
        $this->setValue('menuColor', $menucolor);

        // проверка прав пользователя на просмотр/управление этим заказом
        if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
            throw new ServiceUtils_Exception();
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

        $canEdit = $this->getValue('canEdit');
        if (!$canEdit) {
            $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        }

        $this->setValue('canEdit', $canEdit);
        $this->setValue('canDelete', $user->isAllowed('order-delete') || $user->isAllowed('project-delete'));

        $this->setValue('orderUrl', $order->makeURLEdit());

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
                    $description .=
                        Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_dolg_'
                        ).$balance.' '.$order->getCurrency()->getSymbol().' ';
                } elseif ($balance > 0) {
                    $description .=
                        Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_pereplata_'
                        ).$balance.' '.$order->getCurrency()->getSymbol().' ';
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

        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        $this->setValue('box', $isBox);
        if ($isBox) {
            // количество открытых задач
            $issues = IssueService::Get()->getIssuesAll($this->getUser());
            $issues->setParentid($order->getId());
            $issues->setDateclosed('0000-00-00 00:00:00');
            if ($order->getType() == 'project') {
                $issues->setType('issue');
            }
            $this->setValue('issueCount', $issues->getCount());

            if ($order->getType() == 'project') {
                // количество открытых заказов
                $issues = IssueService::Get()->getIssuesAll($this->getUser());
                $issues->setParentid($order->getId());
                $issues->setDateclosed('0000-00-00 00:00:00');
                $issues->unsetField('type');
                $issues->addWhereArray(array('', 'order'), 'type');
                $this->setValue('orderCount', $issues->getCount());
            }
        }

        // дополнительные табы от модулей
        $moduleTabArray = Shop_ModuleLoader::Get()->getOrderTabArray($user);
        foreach ($moduleTabArray as $k => $moduleTabInfo) {
            $moduleTabArray[$k]['url'] = Engine::GetLinkMaker()->makeURLByContentIDParam(
                $moduleTabInfo['contentID'],
                $order->getId()
            );
        }
        $this->setValue('moduleTabArray', $moduleTabArray);

        try {
            $status = $order->getStatus();

            $this->setValue('statusName', $status->getName());
            $this->setValue('statusColor', $status->getColour() ? $status->getColour() : '#dbe6f4');
        } catch (Exception $estatus) {

        }
    }

}