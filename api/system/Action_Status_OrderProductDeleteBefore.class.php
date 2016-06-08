<?php

class Action_Status_OrderProductDeleteBefore implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $order = $this->_getOrder($event);

        $blocks = new XShopOrderStatusActionBlockStructure();
        $blocks->setStatusid($order->getStatusid());
        $blocks->setOrder('sort', 'ASC');

        while ($x = $blocks->getNext()) {
            if (!Engine::GetContentDataSource()->getDataByID($x->getContentid())) {
                continue;
            }

            $block = Engine::GetContentDriver()->getContent($x->getContentid());

            if (method_exists($block, 'processOrderProductDeleteBefore')) {
                $block->setValue('data', $x->getData());

                $block->processOrderProductDeleteBefore($event);
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
        return $event->getOrderProduct()->getOrder();
    }

}