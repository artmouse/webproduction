<?php
/**
 * Событие при изменении статуса задачи
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_UpdateOrderStatus implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $user = $this->_getUser($event);
        $order = $this->_getOrder($event);
        $status = $this->_getStatus($event);
        if (!$status) {
            $status = $order->getStatus();
        }

        try {
            // в историю заказа
            $comment = 'Статус обновлен на: '.$status->getName()."\n";
            if ($status->getClosed()) {
                // записываем комментарий
                Shop::Get()->getShopService()->addOrderResult(
                    $order,
                    $user,
                    $comment
                );
            } else {
                // записываем комментарий
                Shop::Get()->getShopService()->addOrderChange(
                    $order,
                    $user,
                    $comment
                );
            }

        } catch (Exception $userEx) {

        }
    }

    /**
     * Метод-обертка для типизации
     *
     * @param Events_Event $event
     *
     * @return ShopOrder
     */
    private function _getOrder(Events_Event $event) {
        return $event->getOrder();
    }

    /**
     * Метод-обертка для типизации
     *
     * @param Events_Event $event
     *
     * @return User
     */
    private function _getUser(Events_Event $event) {
        return $event->getUser();
    }

    /**
     * Метод-обертка для типизации
     *
     * @param Events_Event $event
     *
     * @return ShopOrderStatus
     */
    private function _getStatus(Events_Event $event) {
        return $event->getStatus();
    }

}