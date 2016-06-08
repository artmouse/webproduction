<?php
class storage_production_table_block extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // корзина накладной
            $productions = StorageProductionService::Get()->getProductionsByUser($cuser);
            if ($this->getValue('istarget')) {
                $productions->setIstarget(1);
            } else {
                $productions->setIstarget(0);
            }

            $basketArray = array();
            while ($production = $productions->getNext()) {
                try {
                    $product = $production->getProduct();

                    // получаем данные о заказе, если они есть
                    $orderid = false;
                    $orderURL = false;
                    if ($production->getStorageorderproductid()) {
                        try {
                            $orderproduct = StorageOrderService::Get()->getStorageOrderProductByID(
                            $production->getStorageorderproductid()
                            );

                            $order = $orderproduct->getOrder();
                            $orderid = $order->getId();
                            $orderURL = $order->makeURLEdit();

                        } catch (ServiceUtils_Exception $ose) {

                        }
                    }

                    $basketArray[] = array(
                    'id' => $production->getId(),
                    'count' => $production->getAmount(),
                    'name' => $product->getName(),
                    'productid' => $product->getId(),
                    'unit' => $product->getUnit(),
                    'orderid' => $orderid,
                    'orderURL' => $orderURL,
                    'linkedAmount' => StorageLinkService::Get()->getLinkedProductAmount($cuser, $production)
                    );
                } catch (Exception $e) {

                }
            }

            // массив товаров в корзине прихода
            $this->setValue('basketArray', $basketArray);

        } catch (Exception $ge) {

        }
    }

}