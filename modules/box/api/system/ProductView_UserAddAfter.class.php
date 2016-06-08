<?php

class ProductView_UserAddAfter implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $user = $this->_getUser($event);

        $sessionId = Shop::Get()->getUserService()->getSessionID();
        if ($sessionId) {
            $productView = new XShopProductView();
            $productView->setSessionid($sessionId);
            while ($x = $productView->getNext()) {
                $x->setUserid($user->getId());
                $x->update();
            }
        }
    }

    /**
     * Получить клиента. Метод обертка для типизации.
     *
     * @param Events_Event $event
     *
     * @return User
     */
    private function _getUser(Events_Event $event) {
        return $event->getUser();
    }

}