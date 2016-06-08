<?php
/**
 * @copyright WebProduction
 * @package Storage
 */
class Storage_OrderDeleteHandler implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        try {
            SQLObject::TransactionStart();

            $order = $this->_getOrder($event);
            
            StorageReserveService::Get()->deleteLinksReserveAuto($order);

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