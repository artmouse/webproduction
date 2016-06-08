<?php
class storage_order_ajax_add extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            
            $order = StorageOrderService::Get()->getStorageOrderByID(
            $this->getArgumentSecure('orderid')
            );

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-order-message-block');

            // добавляем в приход товар
            if ($this->getControlValue('ok')) {
                try {
                    StorageOrderService::Get()->addOrderProduct(
                    $cuser,
                    $order,
                    $this->getControlValue('productid'),
                    $this->getControlValue('count'),
                    $this->getControlValue('price'),
                    $this->getControlValue('currencyid')
                    );

                    $product = Shop::Get()->getShopService()->getProductByID(
                    $this->getControlValue('productid')
                    );

                    $message->setValue('message', 'ok');
                    $message->setValue('id', $product->getId());
                    $message->setValue('name', $product->getName());
                } catch (ServiceUtils_Exception $e) {
                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $e->getErrorsArray());
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
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}