<?php
class box_block_project_tree extends Engine_Class {

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

        $this->setValue('subIssueArray', $this->_makeIssueTree($order->getId()));

    }

    /**
     * Построить структуру проекта
     *
     * @param int $parentID
     * @param array $issueArray
     * @param array $issueIDArray
     * @param int $level
     *
     * @return array
     */
    private function _makeIssueTree(
        $parentID, $issueArray = array(), $issueIDArray = array(), $level = 0, $subIssues = false
    ) {
        if (!$subIssues) {
            $subIssues = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        }
        $subIssuesClone = clone $subIssues;

        $subIssues->setParentid($parentID);
        $subIssues->setDateclosed('0000-00-00 00:00:00');
        $subIssues->setOrder('cdate', 'DESC');
        $subIssues->setLimitCount(100);

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
                    $sub->getId(), $issueArray, $issueIDArray, $level+1, clone $subIssuesClone
                );
            }
        }

        $subIssues = clone $subIssuesClone;
        $subIssues->setParentid($parentID);
        $subIssues->addWhere('dateclosed', '0000-00-00 00:00:00', '<>');
        $subIssues->addWhere(
            'dateclosed',
            DateTime_Object::Now()->addDay(-7)->setFormat('Y-m-d H:i:s')->__toString(),
            '>='
        );
        $subIssues->setOrder('cdate', 'DESC');

        $subIssues->setLimitCount(100);

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
                    $sub->getId(), $issueArray, $issueIDArray, $level+1, clone $subIssuesClone
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
        
        try{
            $status = $issue->getStatus();
            $color = $status->getColour();
            $statusName = $status->getName();
        } catch (Exception $ex) {
            $color = false;
            $statusName = false;
        }

        $a = array(
            'id' => $issue->getId(),
            'name' => $issue->getName(),
            'url' => $issue->makeURLEdit(),
            'managerName' => $managerName,
            'managerUrl' => $managerUrl,
            'dateto' => $dateto,
            'fire' => $fire,
            'color' => $color,
            'statusName' => $statusName
        );

        return $a;
    }

}