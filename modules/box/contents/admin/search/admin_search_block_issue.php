<?php
class admin_search_block_issue extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $query = $this->getValue('query');
            $limit = $this->getValue('limit');

            // поиск открытых задач
            $issues = Shop::Get()->getShopService()->searchOrders($query, $cuser, 'issue');
            $issues->setLimitCount($limit);
            $issues->setDateclosed('0000-00-00 00-00');
            $issues->setType('issue');

            $issueArray = array();
            $issueArray = $this->_addIssuesToArray($issues, $issueArray);

            // поиск закрытых задач
            $issues = Shop::Get()->getShopService()->searchOrders($query, $cuser, 'issue');
            $issues->setLimitCount($limit);
            $issues->addWhere('dateclosed', '0000-00-00 00-00', '<>');
            $issues->setType('issue');

            $issueArray = $this->_addIssuesToArray($issues, $issueArray);

            $this->setValue('issueArray', $issueArray);
        } catch (Exception $e) {

        }
    }

    /**
     * Добавить задачи в массив
     *
     * @param ShopOrder $issues
     * @param array $a
     *
     * @return array
     */
    private function _addIssuesToArray(ShopOrder $issues, $a) {
        while ($issue = $issues->getNext()) {
            try {
                $managerName = $issue->getManager()->makeName();
                $managerURL = $issue->getManager()->makeURLEdit();
            } catch (ServiceUtils_Exception $se) {
                $managerName = false;
                $managerURL = false;
            }

            try {
                $clientName = $issue->getClient()->makeName();
                $clientURL = $issue->getClient()->makeURLEdit();
            } catch (ServiceUtils_Exception $se) {
                $clientName = false;
                $clientURL = false;
            }

            try {
                $projectName = $issue->getParent()->makeName();
                $projectURL = $issue->getParent()->makeURLEdit();
            } catch (ServiceUtils_Exception $se) {
                $projectName = false;
                $projectURL = false;
            }

            try {
                $color = $issue->getStatus()->getColour();
            } catch (Exception $e) {
                $color = false;
            }

            $a[] = array(
                'id' => $issue->getNumber(),
                'name' => $issue->getName(),
                'url' => $issue->makeURLEdit(),
                'managerName' => $managerName,
                'managerURL' => $managerURL,
                'clientName' => $clientName,
                'clientURL' => $clientURL,
                'projectName' => $projectName,
                'projectURL' => $projectURL,
                'color' => $color,
                'closed' => ($issue->getDateclosed() != '0000-00-00 00:00:00')
            );
        }

        return $a;
    }

}