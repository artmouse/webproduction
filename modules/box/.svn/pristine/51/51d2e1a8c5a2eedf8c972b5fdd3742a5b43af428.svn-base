<?php
class box_block_issues_add extends Engine_Class {

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

        $this->setValue('orderid', $order->getId());

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);
        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {

            $issueNameArray = $this->getArgumentSecure('issuename', 'array');
            $issueManagerArray = $this->getArgumentSecure('issuemanager', 'array');
            $issueTextArray = $this->getArgumentSecure('issuetext', 'array');
            $issueDateArray = $this->getArgumentSecure('issuedate', 'array');
            $issueWorkflowArray = $this->getArgumentSecure('issueworkflow', 'array');
            $issueParentArray = $this->getArgumentSecure('issueparent', 'array');

            foreach ($issueNameArray as $keyIssueName => $issueName) {
                if (!$issueName) {
                    continue;
                }

                $text = $issueTextArray[$keyIssueName];
                $manager = $issueManagerArray[$keyIssueName];
                $workflow = $issueWorkflowArray[$keyIssueName];
                $dateto = $issueDateArray[$keyIssueName];
                $parent = $issueParentArray[$keyIssueName];

                if (!$manager) {
                    // ответственный этапа
                    try{
                        $employer = new XShopOrderEmployer();
                        $employer->setOrderid($order->getId());
                        $employer->setStatusid($order->getStatusid());
                        $employer = $employer->getNext();
                        if ($employer) {
                            $employerManager = Shop::Get()->getUserService()->getUserByID(
                                $employer->getManagerid()
                            );

                            $manager = $employerManager->getId();
                        }

                    } catch (Exception $eproject) {

                    }

                    if (!$manager) {
                        // ответственный проекта
                        try{
                            $projectManager = $order->getParent()->getManager();
                            $manager = $projectManager->getId();
                        } catch (Exception $eproject) {

                        }
                    }

                }

                $parentId = $order->getId();

                if ($parent == 'project') {
                    try{
                        $order->getParent();
                        $parentId = $order->getParentid();
                    } catch (Exception $e) {
                        throw new ServiceUtils_Exception('parent-empty');
                    }
                } elseif ($parent == 'issue') {
                    $parentId = $order->getId();
                }

                try {
                    $issue = IssueService::Get()->addIssue(
                        $user,
                        $issueName,
                        $text,
                        $manager,
                        $workflow,
                        $dateto,
                        false,
                        $parentId
                    );
                } catch (Exception $issueAddEx) {

                }

            }

        }

    }

}