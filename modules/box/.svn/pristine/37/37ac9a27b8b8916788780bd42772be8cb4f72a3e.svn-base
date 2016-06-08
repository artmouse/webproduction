<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package OneBox
 */
class Box_Event_OrderCommentAdd implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $order = $event->getOrder();
        $user = $event->getUser();
        $comment = $event->getComment();

        if ($order->getParentid()) {
            try {
                // записываем комментарий в проект
                $orderComment = "Обновлена задача #".$order->getId();
                if ($order->getName()) {
                    $orderComment .= ' - '.$order->getName();
                }
                $orderComment.= "\n".$comment;

                Shop::Get()->getShopService()->addOrderChange(
                $order->getParent(),
                $user,
                $orderComment
                );
            } catch (Exception $e2) {

            }
        }
    }

}