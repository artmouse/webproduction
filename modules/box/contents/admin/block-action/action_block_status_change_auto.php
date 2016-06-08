<?php
class action_block_status_change_auto extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $status = $this->_getStatus();

        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->setCategoryid($status->getCategoryid());
        $statuses->addWhere('id', $status->getId(), '<>');
        $statusArray = array();
        while ($s = $statuses->getNext()) {
            $statusArray[] = array(
                'id' => $s->getId(),
                'name' => $s->getName()
            );
        }
        $this->setValue('statusArray', $statusArray);

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('autonextstatusid', $data['status']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $data = array(
            'status' => $this->getArgumentSecure($index.'_autonextstatusid')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processCronHour(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $data = (Array) json_decode($this->getValue('data'));
        $nextstatusid = $data['status'];

        if (!$nextstatusid) {
            return false;
        }

        // получаем все задачи с нашим статусом
        $issue = IssueService::Get()->getIssuesAll();
        $issue->setDateclosed('0000-00-00 00:00:00');
        $issue->setStatusid($status->getId());
        $issue->unsetField('type');

        while ($x = $issue->getNext()) {
            // для каждой задачи делаем проверку срока
            $tmp = new XShopOrderChange();
            $tmp->setOrderid($x->getId());
            $tmp->setOrder('id', 'DESC');
            $tmp->setLimitCount(1);
            $tmp->setKey('statusid');
            $tmp->setValue($status->getId());
            if ($xtmp = $tmp->getNext()) {
                try {
                    $employer = new XShopOrderEmployer();
                    $employer->setOrderid($x->getId());
                    $employer->setStatusid($status->getId());
                    $employer = $employer->getNext();

                    $statusDate = false;
                    if ($employer && $employer->getTerm() && $employer->getTerm() != '0000-00-00 00:00:00') {
                        $statusDate = $employer->getTerm();
                    } elseif ($status->getTerm()) {
                        $statusDate = DateTime_Object::FromString($xtmp->getCdate());

                        $term = $status->getTerm();
                        $period = $status->getTermperiod();

                        if ($period == 'hour') {
                            $statusDate->addHour($term);
                        } elseif ($period == 'day') {
                            $statusDate->addDay($term);
                        } elseif ($period == 'week') {
                            $statusDate->addDay($term * 7);
                        } elseif ($period == 'month') {
                            $statusDate->addMonth($term);
                        } elseif ($period == 'year') {
                            $statusDate->addYear($term);
                        } else {
                            // иначе дни
                            $statusDate->addDay($term);
                        }

                        $statusDate = $statusDate->__toString();
                    }

                    // автоматический переход на следующий этап
                    if ($statusDate && ($statusDate <= date('Y-m-d H:i:s'))) {
                        try {
                            if ($x->getManagerid()) {
                                $user = $x->getManager();
                            } else {
                                $user = $x->getAuthor();
                            }

                            Shop::Get()->getShopService()->updateOrderStatus(
                                $user,
                                $x,
                                $nextstatusid
                            );
                        } catch (ServiceUtils_Exception $nse) {

                        }
                    }
                } catch (Exception $statusEx) {
                    print $statusEx;
                }
            }
        }
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return User
     */
    private function _getUser($event) {
        return $event->getUser();
    }

}