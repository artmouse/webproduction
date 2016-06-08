<?php
class storage_basket_add_ajax extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-message');

            // добавляем товар в корзину
            try {
                $product = Shop::Get()->getShopService()->getProductByID(
                $this->getControlValue('productid')
                );

                StorageBasketService::Get()->addStorageBasket(
                $cuser,
                $this->getControlValue('type'),
                $product,
                $this->getControlValue('storagenameid')
                );

                $message->setValue('message', 'ok');
                $message->setValue('id', $product->getId());
                $message->setValue('name', $product->getName());
            } catch (ServiceUtils_Exception $e) {
                $message->setValue('message', 'error');
                $message->setValue('errorsArray', $e->getErrorsArray());
            }

            $block_table = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-table');
            $block_table->setValue('type', $this->getControlValue('type'));

            print json_encode(array(
            'content' => $block_table->render(),
            'message' => $message->render()
            ));
            exit();

        } catch (Exception $e) {
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}