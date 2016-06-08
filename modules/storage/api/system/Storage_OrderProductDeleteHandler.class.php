<?php
/**
 * @copyright WebProduction
 * @package Storage
 */
class Storage_OrderProductDeleteHandler implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        try {
            SQLObject::TransactionStart();

            $orderProduct = $this->_getOrderProduct($event);
            
            StorageReserveService::Get()->deleteLinksReserve($orderProduct);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
    
    /**
     * @param Shop_Event_OrderProduct $event
     * @return ShopOrderProduct
     */
    private function _getOrderProduct($event) {
        return $event->getOrderProduct();
    }

}