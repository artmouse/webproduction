<?php
/**
 * Действия box'a после добавления задач/заказа/проекта.
 * Попытка создать подзадачи и запись change-комментария.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_OrderAddAfter implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $order = $this->_getOrder($event);
        $user = $this->_getUser($event);

        // добавляем продукты, если это необходимо
        try {
            $productString = $order->getWorkflow()->getProductsDefault();
            $productString = explode(',', $productString);
            foreach ($productString as $productID) {
                $productID = (int) trim($productID);

                try {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    // проверяем, есть ли такой товар в заказе или нет,
                    // и если нет - добавляем его
                    $ops = $order->getOrderProducts();
                    $ops->setProductid($product->getId());
                    $ops->setLimitCount(1);
                    if (!$ops->getNext()) {
                        Shop::Get()->getShopService()->addOrderProduct(
                            $order,
                            $product->getId(),
                            1 // count
                        );
                    }
                } catch (Exception $productEx) {

                }
            }
        } catch (Exception $e) {

        }

        // пишем комментарий в историю
        try {
            $orderComment = "Создана задача #".$order->getId();
            try {
                $orderComment .= ' для '.$order->getManager()->makeName(false, 'lfm');
            } catch (Exception $managerEx) {

            }

            if ($order->getName()) {
                $orderComment.= " - ".$order->getName();
            }
            if ($order->getComments()) {
                $orderComment.= "\n".$order->getComments();
            }

            Shop::Get()->getShopService()->addOrderChange(
                $order,
                $user,
                $orderComment
            );
        } catch (Exception $e) {

        }
    }

    /**
     * Метод-обертка для получения заказа.
     *
     * @return ShopOrder
     */
    private function _getOrder(Events_Event $event) {
        return $event->getOrder();
    }

    /**
     * Метод-обертка для получения юзера.
     *
     * @return User
     */
    private function _getUser(Events_Event $event) {
        return $event->getUser();
    }

}