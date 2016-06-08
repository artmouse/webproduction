<?php
class action_block_notification_client_no_link extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $this->setValue('noCommunication', $this->getValue('data'));

    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            $this->getArgumentSecure($index.'_noCommunication')
        );
    }

    public function processCronHour(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $noComm = (int) $this->getValue('data');
        $termNoComm = DateTime_Object::Now()->addHour(-$noComm)->__toString();

        // получить задачи с контролируемым этапом
        $issues = IssueService::Get()->getIssuesAll();
        $issues->filterDateclosed('0000-00-00 00:00:00');
        $issues->filterStatusid($status->getId());

        while ($issue = $issues->getNext()) {
            $cdate = $issue->getCdate();
            try {
                $client = Shop::Get()->getUserService()->getUserByID($issue->getUserid());
            } catch (Exception $e) {
                continue;
            }
            // не было связи с клиентом
            if ($noComm && $termNoComm > $cdate) {
                try {
                    IssueService::Get()->checkClientCommunication($client, $termNoComm);
                } catch (Exception $e) {
                    $comment = Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_ne_bilo_svyazi_s_klientom_bolee_nocomm_chasov'
                    );
                    try {
                        $notifyTerm = DateTime_Object::Now()->addDay(-$noComm)->__toString();
                        Shop::Get()->getShopService()->addOrderNotify($issue, false, $comment, $notifyTerm);
                    } catch (Exception $e) {

                    }
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