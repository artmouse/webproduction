<?php
class storage_stocktaking_ajax_update extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-stocktaking-message-block');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    $baskets = StorageStocktakingService::Get()->getStocktakingBaskets();
                    while ($basket = $baskets->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$basket->getId());
                            StorageStocktakingService::Get()->deleteStocktaking(
                            $basket,
                            $cuser
                            );

                            continue;
                        } catch (Exception $de) {

                        }

                        // попытка сохранить
                        $amount = $this->getControlValue('count'.$basket->getId());

                        StorageStocktakingService::Get()->updateStocktaking(
                        $basket,
                        $cuser,
                        $amount
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