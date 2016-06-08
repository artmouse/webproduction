<?php
class storage_motion_view extends Engine_Class {

    public function process() {
        try {
            $transaction = StorageService::Get()->getStorageTransactionByID(
                $this->getArgument('id')
            );

            // один из товаров в перемещении
            $storageProduct = StorageService::Get()->getStoragesByTransaction($transaction)->getNext();
            if (!$storageProduct) {
                throw new ServiceUtils_Exception('storage');
            }

            $cuser = $this->getUser();

            // проверка прав
            if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser, $storageProduct->getStorageNameFrom(), 'motionlog'
            )
            ) {
                throw new ServiceUtils_Exception('user');
            }

            if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser, $storageProduct->getStorageNameTo(), 'motionlog'
            )
            ) {
                throw new ServiceUtils_Exception('user');
            }

            if ($this->getControlValue('dateok')) {
                try {
                    StorageService::Get()->updateStorageTransactionDate(
                        $cuser,
                        $transaction,
                        $this->getControlValue('date')
                    );

                    $storageProduct = StorageService::Get()->getStorageByID($storageProduct->getId());
                    $transaction = StorageService::Get()->getStorageTransactionByID($transaction->getId());

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            if ($transaction->getType() == 'production') {

                // таблица товаров-целей
                $tableTarget = new Shop_ContentTable(
                    new Datasource_Storage_Motion(
                        $transaction->getId(),
                        true
                    )
                );

                // таблица товаров-материала
                $tableMaterial = new Shop_ContentTable(
                    new Datasource_Storage_Motion(
                        $transaction->getId(),
                        false,
                        true
                    )
                );

                $tableTarget->removeField('id');
                $this->setValue('tableTarget', $tableTarget->render());

                $tableMaterial->removeField('id');
                $this->setValue('tableMaterial', $tableMaterial->render());

            } else {

                // таблица товаров в перемещении
                $table = new Shop_ContentTable(
                    new Datasource_Storage_Motion(
                        $transaction->getId()
                    )
                );

                $field = new Shop_ContentField_LinkProduct('productid');
                $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_item_code'));
                $table->addField($field);

                $table->removeField('id');
                $this->setValue('table', $table->render());
            }

            // список товаров перемещения
            $storage = StorageService::Get()->getStorageMotion(
                $cuser,
                $transaction->getId()
            );

            $sum = 0;
            while ($x = $storage->getNext()) {
                $sum += $x->getAmount() * $x->getPricebase();
            }

            $this->setValue('sum', $sum);

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencyDefault->getSymbol());

            $this->setValue('date', DateTime_Formatter::DateTimeRussianGOST($storageProduct->getDate()));
            $this->setValue('type', $storageProduct->makeType());

            $storageNameFrom = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenamefromid());
            $storageNameTo = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenametoid());

            $this->setValue('storagenamefrom', $storageNameFrom->getName());
            $this->setValue('storagenamefromURL', $storageNameFrom->makeURLMotionlog());
            $this->setValue('storagenameto', $storageNameTo->getName());
            $this->setValue('storagenametoURL', $storageNameTo->makeURLMotionlog());

            try {
                $this->setValue('username', $storageProduct->getUser()->getName());
                $this->setValue(
                    'userURL',
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-users-control',
                        $storageProduct->getUserid()
                    )
                );
                $this->setValue('userID', $storageProduct->getUserid());
            } catch (ServiceUtils_Exception $se) {

            }

            // если продажа
            if ($transaction->getType() == 'sale' || $transaction->getType() == 'incoming') {
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($transaction->getOrderid());

                    $this->setValue('orderid', $order->getId());
                    $this->setValue('orderURL', $order->makeURLEdit());
                    $this->setValue('client', $order->getClientname());
                    $this->setValue('clientphone', $order->getClientphone());
                    $this->setValue('clientaddress', $order->getClientaddress());
                    $this->setValue('clientemail', $order->getClientemail());
                } catch (ServiceUtils_Exception $se) {

                }
            }


            // если оприходование
            if ($storageProduct->getType() == 'incoming') {
                try {
                    $contractor = Shop::Get()->getShopService()->getContractorByID(
                        $storageProduct->getContractorid()
                    );

                    $this->setValue('contractor', $contractor->getName());
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('isEditAllowed', $cuser->isAllowed('storage-motionlog-edit'));
            $this->setValue('isDeleteAllowed', $cuser->isAllowed('storage-motionlog-delete'));

            $urlDeleteTransaction = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-storage-motion-delete-transaction',
                $storageProduct->getId()
            );
            $this->setValue('urlDeleteTransaction', $urlDeleteTransaction);

            // возврат ли это?
            $isReturn = $transaction->getReturn();
            $this->setValue('isReturn', $isReturn);

            if ($isReturn) {
                try {
                    $storage = StorageService::Get()->getStorageMotion(
                        $cuser,
                        $transaction->getReturntransactionid()
                    );

                    if ($storage = $storage->getNext()) {
                        $this->setValue(
                            'urlReturnTransaction',
                            Engine::GetLinkMaker()->makeURLByContentIDParam(
                                'shop-admin-storage-motion-view',
                                $storage->getId()
                            )
                        );
                    }
                } catch (ServiceUtils_Exception $te) {

                }
            }

            // разрешено ли делать возврат
            $this->setValue('isReturnAllowed', StorageService::Get()->isReturnAllowed($cuser, $transaction));
            // ссылка на возврат
            $urlReturn = Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-storage-motion-return',
                $storageProduct->getId()
            );
            $this->setValue('urlReturn', $urlReturn);

            if (Shop_ModuleLoader::Get()->isImported('document')) {
                // блок документов
                $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
                $block_documents->setValue('linkkey', $transaction->getClassname().'-'.$transaction->getId());
                $this->setValue('block_documents', $block_documents->render());
            }

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}