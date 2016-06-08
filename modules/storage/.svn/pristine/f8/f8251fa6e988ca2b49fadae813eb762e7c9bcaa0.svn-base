<?php
class storage_production_ajax_update extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            $message = Engine::GetContentDriver()->getContent('shop-admin-storage-production-message-block');

            // сохранение изменений списка товаров
            if ($this->getControlValue('saveok')) {
                try {
                    SQLObject::TransactionStart();

                    $productions = StorageProductionService::Get()->getProductionsByUser($cuser);
                    while ($production = $productions->getNext()) {

                        // попытка удалить
                        try {
                            $deleteID = $this->getArgument('delete'.$production->getId());

                            $x = StorageProductionService::Get()->getProductionsByUser($cuser);
                            $x->setPassportid($production->getPassportid());
                            $x->setStorageorderproductid($production->getStorageorderproductid());
                            while ($y = $x->getNext()) {
                                $y->delete();
                            }

                            continue;
                        } catch (Exception $de) {

                        }

                        // попытка сохранить
                        try {
                            $amount = $this->getArgument('count'.$production->getId());
                            if ($amount != $production->getAmount()) {
                                $passport = StorageProductionService::Get()->getProductPassportByID(
                                $production->getPassportid()
                                );

                                $pi = $passport->getItems();
                                $pi->setProductid($production->getProductid());
                                $pi = $pi->getNext();
                                
                                if (!$pi) {
                                    throw new ServiceUtils_Exception();
                                }

                                $passportAmount = round($production->getAmount() / $pi->getAmount());

                                $x = StorageProductionService::Get()->getProductionsByUser($cuser);
                                $x->setPassportid($production->getPassportid());
                                $x->setStorageorderproductid($production->getStorageorderproductid());
                                while ($y = $x->getNext()) {
                                    $y->setAmount($y->getAmount() / $passportAmount * $amount);
                                    $y->update();
                                }
                            }
                        } catch (Exception $see) {

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

            $block_content_products = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-table-block'
            );
            $block_content_products->setValue('istarget', true);
            $block_content_products = $block_content_products->render();
            
            $block_content_materials = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-table-block'
            );
            $block_content_materials->setValue('istarget', false);
            $block_content_materials = $block_content_materials->render();
            
            $block_content_passports = Engine::GetContentDriver()->getContent(
            'shop-admin-storage-production-passport-table-block'
            );
            $block_content_passports = $block_content_passports->render();

            print json_encode(array(
            'content_products' => $block_content_products,
            'content_materials' => $block_content_materials,
            'content_passports' => $block_content_passports,
            'message' => $message->render()
            ));
                        
            exit();

        } catch (Exception $e) {
            echo json_encode(array('error' => 'error'));
            exit();
        }
    }

}