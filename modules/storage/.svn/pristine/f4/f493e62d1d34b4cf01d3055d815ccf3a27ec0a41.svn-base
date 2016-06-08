<?php
class storage_basket_update_ajax extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-message');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    $baskets = StorageBasketService::Get()->getStorageBasketsByUser(
                        $cuser,
                        $this->getControlValue('type')
                    );

                    while ($basket = $baskets->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$basket->getId());

                            StorageBasketService::Get()->deleteStorageBasket(
                                $basket,
                                $cuser
                            );

                            continue;
                        } catch (Exception $de) {
                            // попытка сохранить
                            StorageBasketService::Get()->updateStorageBasket(
                                $basket,
                                $cuser,
                                $this->getControlValue('serial'.$basket->getId()),
                                $this->getControlValue('count'.$basket->getId()),
                                $this->getControlValue('price'.$basket->getId()),
                                $this->getControlValue('currencyid'.$basket->getId()),
                                $this->getControlValue('tax'.$basket->getId()),
                                $this->getControlValue('shipment'.$basket->getId()),
                                $this->getControlValue('warranty'.$basket->getId())
                            );
                        }



                    }
                    $message->setValue('messagesave', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $se) {

                    SQLObject::TransactionRollback();

                    $message->setValue('message', 'error');
                    $message->setValue('errorsArray', $se->getErrorsArray());
                }
            }

            $block_table = Engine::GetContentDriver()->getContent('shop-admin-storage-basket-block-table');
            $block_table->setValue('type', $this->getControlValue('type'));

            print json_encode(
                array(
                    'content' => $block_table->render(),
                    'message' => $message->render()
                )
            );
            exit();

        } catch (Exception $e) {
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}