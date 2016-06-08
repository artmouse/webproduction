<?php
class storage_order_ajax_update extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            
            $order = StorageOrderService::Get()->getStorageOrderByID(
            $this->getArgument('orderid')
            );

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-order-message-block');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    $orderProducts = StorageOrderService::Get()->getStorageOrderProducts($order);
                    while ($orderProduct = $orderProducts->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$orderProduct->getId());
                            StorageOrderService::Get()->deleteOrderProduct(
                            $orderProduct,
                            $cuser
                            );

                            continue;
                        } catch (Exception $de) {

                        }

                        // попытка сохранить
                        $amount = $this->getControlValue('count'.$orderProduct->getId());
                        $price = $this->getControlValue('price'.$orderProduct->getId());
                        $currencyid = $this->getControlValue('currencyid'.$orderProduct->getId());

                        StorageOrderService::Get()->updateOrderProduct(
                        $orderProduct,
                        $cuser,
                        $amount,
                        $price,
                        $currencyid
                        );

                    }
                    $message->setValue('messagesave', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $se) {

                    SQLObject::TransactionRollback();

                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $se->getErrorsArray());
                }
            }

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-order-table-block');
            $block->setValue('orderid', $order->getId());

            print json_encode(array(
            'content' => $block->render(),
            'message' => $message->render()
            ));
            exit();

        } catch (Exception $e) {
            print $e;
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}