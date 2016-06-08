<?php
class box_block_status_info extends Engine_Class {

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

        if (!$process && $canEdit && $this->getArgumentSecure('ok')) {
            // обновляем статус

            $statusId= false;
            try{
                $statusId = $this->getArgument('status');
            } catch (Exception $status) {

            }

            if ($statusId) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $this->getUser(),
                    $order,
                    $this->getArgument('status')
                );
            }

            // обновляем категорию

            $category = false;
            try{
                $category = Shop::Get()->getShopService()->getOrderCategoryByID(
                    $this->getArgument('categoryid')
                );
            } catch (Exception $ecategory) {

            }

            if ($category) {
                Shop::Get()->getShopService()->updateOrderCategory($order, $user, $category);

            }

            Shop::Get()->getShopService()->updateOrderEmployer(
                $order,
                $order->getStatus(),
                $user,
                $this->getControlValue('termEmployer'),
                $this->getControlValue('managerEmployer')
            );

        }

        try {
            $link = Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                'shop-workflow-status-edit', 
                $order->getStatusid()
            );
            $this->setValue('statusName', $order->getStatus()->makeName());
            $this->setValue('statusURL', $link);
            $this->setValue('statusColor', $order->getStatus()->getColour());
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
                    Shop::Get()->getUserService()->getUserByID($employer->getManagerid())->makeName(false, 'lfm')
                );
                $this->setValue(
                    'managerUrlEmployer',
                    Shop::Get()->getUserService()->getUserByID($employer->getManagerid())->makeURLEdit()
                );
                $this->setValue('managerIdEmployer', $employer->getManagerid());
            }
        } catch (Exception $ee2) {

        }

        try {
            $link = Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                'shop-workflow-edit', 
                $order->getWorkflowid()
            );
            $this->setValue('workflowName', $order->getWorkflow()->makeName());
            $this->setValue('workflowURL', $link);
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

        $this->setControlValue('categoryid', $order->getCategoryid());

        $fire = Shop::Get()->getShopService()->isFireOrderStatus($order);
        $this->setValue('fireIssueStatus', $fire);

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

        $this->setControlValue('status', $order->getStatusid());

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
    }

}