<?php
class Box_Event_UserNotifyObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $contact = $this->_getUser($event);

        // пропускаем бесполезные действия
        $a = $contact->getValueUpdateArray();

        if ($a) {
            if (empty($a['email']) && empty($a['emails'])
            && empty($a['phone']) && empty($a['phones'])
            && empty($a['skype'])
            ) {
                return;
            }
        }

        // проверка всех notify
        // по email
        $a = $contact->getEmailArray();
        foreach ($a as $x) {
            $notify = new ShopOrder();
            $notify->setLinkkey('email-'.md5($x));
            if ($notify->select()) {
                try {
                    IssueService::Get()->closeIssue($notify);
                } catch (Exception $closeEx) {

                }
            }
        }

        // по email
        $a = $contact->getPhoneArray();
        foreach ($a as $x) {
            $notify = new ShopOrder();
            $notify->setLinkkey('call-'.md5($x));
            if ($notify->select()) {
                try {
                    IssueService::Get()->closeIssue($notify);
                } catch (Exception $closeEx) {

                }
            }
        }

        // по skype
        $a = $contact->getSkypeArray();
        foreach ($a as $x) {
            $notify = new ShopOrder();
            $notify->setLinkkey('skype-'.md5($x));
            if ($notify->select()) {
                try {
                    IssueService::Get()->closeIssue($notify);
                } catch (Exception $closeEx) {

                }
            }
        }
    }

    /**
     * Метод-обертка для типизации
     *
     * @param Events_Event $event
     *
     * @return User
     */
    private function _getUser(Events_Event $event) {
        return $event->getObject();
    }

}