<?php
/**
 * @copyright WebProduction
 * @package Document
 */
class Document_OrderDeleteHandler implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        try {
            SQLObject::TransactionStart();

            $order = $this->_getOrder($event);

            // удаление документов
            $docs = DocumentService::Get()->getDocumentsByLinkKey('ShopOrder-'.$order->getId());
            $docs->setDeleted(1, true);
            $docs->update(true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @param Shop_Event_Order $event
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

}