<?php
class storage_passport_ajax_update extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $passport = StorageProductionService::Get()->getProductPassportByID(
            $this->getArgument('passportid')
            );

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-message-block');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    if ($this->getValue('istarget')) {
                        $items = StorageProductionService::Get()->getProductPassportItemsTargetByPassport(
                        $passport
                        );
                    } else {
                        $items = StorageProductionService::Get()->getProductPassportItemsMaterialByPassport(
                        $passport
                        );
                    }

                    while ($item = $items->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$item->getId());
                            StorageProductionService::Get()->deleteProductPassportItem($item);

                            continue;
                        } catch (Exception $de) {

                        }

                        // попытка сохранить
                        StorageProductionService::Get()->updateProductPassportItem(
                        $item,
                        $this->getControlValue('count'.$item->getId())
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

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-passport-table-block');
            $block->setValue('passportid', $passport->getId());
            $block->setValue('istarget', $this->getControlValue('istarget'));

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