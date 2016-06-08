<?php
class order_workflow_setting_info extends Engine_Class {

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

            $employerId = false;
            try {
                $employer = new XShopOrderEmployer();
                $employer->setOrderid($order->getId());
                $employer->setStatusid($status->getId());
                while ($tmp = $employer->getNext()) {
                    $employerId = $tmp->getManagerid();
                    if ($tmp->getTerm() != '0000-00-00 00:00:00') {
                        $this->setValue('statusTerm', $tmp->getTerm());
                    }
                    break;

                }
            } catch (Exception $roleEx) {

            }

            // список менеджеров
            $managers = Shop::Get()->getUserService()->getUsersManagers($this->getUser());
            $a = array();
            while ($x = $managers->getNext()) {
                $a[] = array(
                    'id' => $x->getId(),
                    'name' => $x->makeName(true, false),
                    'selected' => $x->getId() == $employerId ? true:false
                );
            }
            $this->setValue('managerArray', $a);

            $a = array();
            $a2 = array();
            $subIssue = IssueService::Get()->getIssuesAll($this->getUser());
            $subIssue->setParentid($order->getId());
            $subIssue->setParentstatusid($status->getId());
            while ($x = $subIssue->getNext()) {
                try {
                    $managerName = $x->getManager()->makeName(true, 'lfm');
                } catch (Exception $e) {
                    $managerName = '-';
                }

                if ($x->isClosed()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'url' => $x->makeURLEdit(),
                        'manager' => $managerName,
                    );
                } else {
                    $a2[] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'url' => $x->makeURLEdit(),
                        'manager' => $managerName,
                        'managerId' => $x->getManagerid(),
                        'dateTo' => $x->getDateto()
                    );
                }

            }
            $this->setValue('issueArray', $a2);
            $this->setValue('issueArrayClosed', $a);

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