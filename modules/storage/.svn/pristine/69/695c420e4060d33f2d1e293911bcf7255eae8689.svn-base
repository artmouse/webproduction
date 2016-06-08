<?php
class storage_sale_ajax_update extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-sale-message-block');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    $sales = StorageSaleService::Get()->getSalesByUser($cuser, true);
                    while ($sale = $sales->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$sale->getId());
                            StorageSaleService::Get()->deleteSaleQuick(
                            $sale,
                            $cuser
                            );

                            continue;
                        } catch (Exception $de) {

                        }

                        // попытка сохранить
                        StorageSaleService::Get()->updateSaleQuick(
                        $sale,
                        $cuser,
                        $this->getControlValue('count'.$sale->getId()),
                        $this->getControlValue('price'.$sale->getId()),
                        $this->getControlValue('currencyid'.$sale->getId())
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

            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-sale-table-block');

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