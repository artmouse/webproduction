<?php

class Action_Status_OrderStatusUpdateAfter implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $order = $this->_getOrder($event);
        try{
            $status = $this->_getStatus($event);

            if (!$status) {
                $status = $order->getStatus();
            }
        } catch (Exception $estatus) {
            return;
        }

        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->setStatusid($order->getStatusid());
        $blocks->setOrder('sort', 'ASC');

        while ($x = $blocks->getNext()) {
            if (!Engine::GetContentDataSource()->getDataByID($x->getContentid())) {
                continue;
            }

            $block = Engine::GetContentDriver()->getContent($x->getContentid());

            if (method_exists($block, 'processStatus')) {
                $block->setValue('data', $x->getData());
                $block->setValue('status', $status);
                $block->processStatus($event);
            }

        }
    }


    /**
     * Получить заказ. Метод обертка для типизации.
     *
     * @param Events_Event $event
     *
     * @return ShopOrder
     */
    private function _getOrder(Events_Event $event) {
        return $event->getOrder();
    }

    /**
     * Получить статус. Метод обертка для типизации.
     *
     * @param Events_Event $event
     *
     * @return ShopOrderStatus
     */
    private function _getStatus(Events_Event $event) {
        return $event->getStatus();
    }

}