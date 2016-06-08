<?php
class storage_stocktaking_ajax_load extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-stocktaking-message-block');

            // добавляем товары корзину переучета
            if ($this->getControlValue('ok')) {
                try {
                    $category = false;
                    try {
                        $category = Shop::Get()->getShopService()->getCategoryByID(
                        $this->getControlValue('categoryid')
                        );
                    } catch (ServiceUtils_Exception $ce) {

                    }

                    $balance = StorageBalanceService::Get()->getBalanceByStorage(
                    $cuser,
                    array($this->getControlValue('storagefromid')),
                    false,
                    $category
                    );

                    while ($x = $balance->getNext()) {
                        try {
                            StorageStocktakingService::Get()->addStocktaking(
                            $cuser,
                            $this->getControlValue('storagefromid'),
                            $x->getProductid(),
                            0
                            );
                        } catch (ServiceUtils_Exception $see) {

                        }
                    }

                    $message->setValue('message', 'loadok');
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