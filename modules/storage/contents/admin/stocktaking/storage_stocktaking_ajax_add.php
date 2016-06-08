<?php
class storage_stocktaking_ajax_add extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-stocktaking-message-block');

            // добавляем в товар корзину переучета
            if ($this->getControlValue('ok')) {
                try {
                    StorageStocktakingService::Get()->addStocktaking(
                    $cuser,
                    $this->getControlValue('storagefromid'),
                    $this->getControlValue('productid'),
                    $this->getControlValue('count')
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

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-stocktaking-table-block');

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