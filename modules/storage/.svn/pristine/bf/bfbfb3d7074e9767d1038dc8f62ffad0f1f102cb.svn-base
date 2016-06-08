<?php
/**
 * @copyright WebProduction
 * @package Storage
 */
class Storage_CronDayDefault implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // пересчет количества товара на складе
        try {
            SQLObject::TransactionStart();

            $products = Shop::Get()->getShopService()->getProductsAll();
            while ($product = $products->getNext()) {
                $balance = StorageBalanceService::Get()->getBalanceByProductForReserve($product)->getNext();
                
                $amount = 0;
                if ($balance) {
                    $amount = $balance->getAmount();
                }
                
                if ($product->getStoraged() != $amount) {
                    $product->setStoraged($amount);
                    $product->update();
                }
                
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            print $ge;
        }

    }

}