<?php

class Shop_Event_OrderStatusDeleteAfter extends Events_Event {

    public function notify(Events_Event $event) {
        $status = $this->_getStatus($event);
        $statusId = $status->getId();

        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->setStatusid($statusId);
        $blocks->delete(true);
    }

    /**
     * Обертка
     *
     * @param $event
     *
     * @return ShopOrderStatus
     */
    private function _getStatus ($event) {
        return $event->getObject();
    }

}