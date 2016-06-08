<?php
class box_block_workflow_visual extends Engine_Class {

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
        $user = $this->getUser();
        $process = $this->getValue('process');

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        // сохранение статуса
        if (!$process && $canEdit && $this->getArgumentSecure('ok')) {
            try {
                $statusid = $this->getArgument('workflow_visual_status');
            } catch (Exception $estatus) {
                $statusid = false;
            }

            if ($statusid && $order->getStatusid() != $statusid) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $this->getUser(),
                    $order,
                    $statusid
                );
            }
        }

        // сохранение настроек этапа
        if (!$process && $canEdit && $this->getArgumentSecure('setting-info-ok')) {
            try {
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
                            } else {
                                $worlflowId = $order->getCategoryid();
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
                            1;
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
                1;
            }

            // отлавливаем удаление и изменение
            foreach ($this->getArguments() as $key => $item) {
                if (strpos($key, 'issueClosed_') === 0) {
                    $orderId = str_replace('issueClosed_', '', $key);
                    try{
                        $orderDelete = Shop::Get()->getShopService()->getOrderByID($orderId);
                        Shop::Get()->getShopService()->deleteOrder($orderDelete);
                    } catch (Exception $e) {
                        1;
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
                        1;
                    }
                }
            }

        }

        // визуализатор BMPN
        PackageLoader::Get()->registerJSFile('/_js/jsPlumb.js');


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
            $category = false;
        }
        $this->setValue('statusNextArray', $statusNextArray);

        if (!$category) {
            return;
        }

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

        $this->setValue('status_id', $order->getStatusid());
        $this->setValue('orderid', $order->getId());

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

        $this->setValue('statusid', $order->getStatusid());

    }

}