<?php
class issue_status_index extends Engine_Class {

    /**
     * @return ShopOrder
     */
    private function _getIssues() {
        try {
            $issues = $this->getValue('issue');
            $issues->addWhere('managerid', '0', '<>');
            return $issues;
        } catch (Exception $e) {}
    }

    public function process() {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');
        if (!$isBox) {
            return;
        }
        try {
            $this->setValue('issueArray', $this->_getIssuesArray());
        } catch (Exception $e) {
            print $e;
        }

    }

    /**
     * @return array
     */
    private function _getIssuesArray() {
        $issues = $this->_getIssues();
        $issuesArray = array();

        while ($issue = $issues->getNext()) {

            $managerName = '';
            $managerId = '';
            try {
                $manager = $issue->getManager();
                $managerName = $manager->makeName();
                $managerId = $manager->getId();
            } catch( Exception $e) { }

            $issuesArray[] = array(
            'id' => $issue->getId(),
            'url' => $issue->makeURLEdit(),
            'name' => $issue->makeName(),
            'balance' => $issue->makeSumBalance(),
            'currency' => $issue->getCurrency()->getSymbol(),
            'financeUrl' => Shop_ModuleLoader::Get()->isImported('finance')?Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-finance-tab-order', $issue->getId()):'',
            'managerId' => $managerId,
            'managerName' => $managerName,
            'employerUrl' =>
            Engine::GetLinkMaker()->makeURLByContentIDParams('shop-admin-orders-employer', array('id' => $issue->getId())),
            'employerArray' => $this->_getEmployersArray($issue->getId()),
            'status' => $this->_getLastComment($issue->getId()),
            );
        }
        return $issuesArray;
    }

    /**
     * Возвращает последний комментарий заказа (без автора, просто текст)
     * @param $issueId
     * @return string
     */
    private function _getLastComment($issueId) {
        $commentKey = 'shop-order-'.$issueId;
        $comment = CommentsAPI::Get()->getComments($commentKey);
        $comment->setOrder('cdate', 'DESC');
        $comment->setLimitCount(1);

        if ($x = $comment->getNext()) {
            return $x->getContent();
        }
        return '';

    }

    /**
     * Возвращает массив исполнителей
     * @param $issueId
     * @return array
     */
    private function _getEmployersArray($issueId) {
        $oes = new XShopOrderEmployer();
        $oes->setOrderid($issueId);
        $a = array();

        while ($x = $oes->getNext()) {
            try {
                $employer = $this->_getEmployer($x->getManagerid());
                $a[] = array(
                'managerId' => $x->getManagerid(),
                'managerName' => $employer->makeName(),
                );
            } catch (Exception $e) {

            }
        }
        return $a;
    }

    /**
     * Возвращает исполнителя
     * @param $id
     * @return User
     */
    private function _getEmployer($id) {
        return Shop::Get()->getUserService()->getUserByID(
        $id
        );
    }

}