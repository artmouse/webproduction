<?php
class storage_production_passport_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // корзина накладной
            $basketProducts = StorageProductionService::Get()->getProductionsByUser($cuser);
            $basketProducts->setIstarget(1);
            $basketProducts->setGroupByQuery('passportid, storageorderproductid');

            $passportArray = array();
            while ($basketProduct = $basketProducts->getNext()) {
                try {
                    $passport = StorageProductionService::Get()->getProductPassportByID(
                    $basketProduct->getPassportid()
                    );
                    
                    $item = $passport->getItems();
                    $item->setProductid($basketProduct->getProductid());
                    $item = $item->getNext();
                    
                    if (!$item) {
                        throw new ServiceUtils_Exception();
                    }
                    
                    // получаем данные о заказе, если они есть
                    $orderid = false;
                    $orderURL = false;
                    if ($basketProduct->getStorageorderproductid()) {
                        try {
                            $orderproduct = StorageOrderService::Get()->getStorageOrderProductByID(
                            $basketProduct->getStorageorderproductid()
                            );

                            $order = $orderproduct->getOrder();
                            $orderid = $order->getId();
                            $orderURL = $order->makeURLEdit();

                        } catch (ServiceUtils_Exception $ose) {

                        }
                    }
                    
                    $amount = round($basketProduct->getAmount() / $item->getAmount());

                    $passportArray[] = array(
                    'id' => $basketProduct->getId(),
                    'count' => $amount,
                    'name' => $passport->getName(),
                    'orderid' => $orderid,
                    'orderURL' => $orderURL
                    );
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине прихода
            $this->setValue('passportArray', $passportArray);

        } catch (Exception $ge) {

        }
    }

}