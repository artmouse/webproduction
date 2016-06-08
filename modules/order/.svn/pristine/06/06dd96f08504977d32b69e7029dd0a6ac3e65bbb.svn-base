<?php
class order_workflow_info extends Engine_Class {

    public function process() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID(
                $this->getArgument('orderid')
            );

            $status = Shop::Get()->getShopService()->getStatusByID(
                $this->getArgument('statusid')
            );

            $user = $this->getUser();

            // проверка прав пользователя на просмотр/управление этим заказом
            if (!Shop::Get()->getShopService()->isOrderViewAllowed($order, $user)) {
                throw new ServiceUtils_Exception('access');
            }

            $workflow = $order->getWorkflow();

            $this->setValue('statusId', $status->getId());
            $this->setValue('orderId', $order->getId());
            $this->setValue('statusName', $status->makeName());

            // роль
            try {
                $role = RoleService::Get()->getRoleByID($status->getRoleid());
                $this->setValue('statusRole', $role->getName());
            } catch (Exception $e) {

            }

            $this->setValue('statusContent', nl2br(htmlspecialchars($status->getContent())));
            if ($status->getTerm()) {
                $this->setValue('statusTerm', trim($status->getTerm().' '.$status->getTermperiod()));
            }

            $employerArray = array();
            try {
                $employer = new XShopOrderEmployer();
                $employer->setOrderid($order->getId());
                $employer->setStatusid($status->getId());
                while ($tmp = $employer->getNext()) {
                    if ($tmp->getManagerid()) {
                        $x = Shop::Get()->getUserService()->getUserByID($tmp->getManagerid());
                        $employerArray[] = array(
                            'id' => $x->getId(),
                            'name' => $x->makeName(true, 'lfm'),
                            'url' => $x->makeURLEdit(),
                        );
                    }
                    $orderDateTo =  $order->getDateto();
                    $employerDateTo = $tmp->getTerm();

                    if ($orderDateTo && $orderDateTo <  $employerDateTo) {
                        $this->setValue('orderEmployerTerm', $orderDateTo);
                    } elseif ($employerDateTo) {
                        $this->setValue('orderEmployerTerm', $employerDateTo);
                    }

                }
            } catch (Exception $roleEx) {

            }
            $this->setValue('employerArray', $employerArray);

            $a = array();
            $subIssue = IssueService::Get()->getIssuesAll($this->getUser());
            $subIssue->setParentid($order->getId());
            $subIssue->setParentstatusid($status->getId());
            while ($x = $subIssue->getNext()) {
                try {
                    $managerName = $x->getManager()->makeName(true, 'lfm');
                } catch (Exception $e) {
                    $managerName = '-';
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => $x->makeURLEdit(),
                'manager' => $managerName,
                'closed' => $x->isClosed(),
                );
            }
            $this->setValue('issueArray', $a);

            $url = Engine::GetLinkMaker()->makeURLByContentID('issue-add');
            $url .= '?parentid='.$order->getId();
            $url .= '&managerid='.$order->getManagerid();
            $url .= '&categoryid='.$order->getWorkflowid();
            $this->setValue('urlAddSubIssue', $url);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            if ($ge->getMessage() == 'access') {
                Engine::Get()->getRequest()->setContentID(403);
            } else {
                Engine::Get()->getRequest()->setContentNotFound();
            }
        }
    }

}