<?php
class action_block_notification_client_no_link_phone extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $this->setValue('noCommunicationCall', $this->getValue('data'));

    }

    public function processData() {
        $index = $this->getValue('index');

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            $this->getArgumentSecure($index.'_noCommunicationCall')
        );
    }

    public function processCronHour(Events_Event $event) {
        $event;

        $status = $this->_getStatus();

        $noCommCall = (int) $this->getValue('data');
        $termNoCommCall = DateTime_Object::Now()->addHour(-$noCommCall)->__toString();

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
            // не было связи по телефону
            if ($noCommCall && $termNoCommCall > $cdate) {
                try {
                    IssueService::Get()->checkClientCommunication($client, $termNoCommCall, 'call');
                } catch (Exception $e) {
                    $comment =
                        Shop::Get()->getTranslateService()->getTranslateSecure(
                            'translate_ne_bilo_svyazi_s_klientom_cherez_zvonki_bolee_nocommcall_chasov'
                        );
                    try {
                        $notifyTerm = DateTime_Object::Now()->addDay(-$noCommCall)->__toString();
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