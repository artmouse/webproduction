<?php
class storage_order_control extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        try {
            // получаем заказ
            $order = StorageOrderService::Get()->getStorageOrderByID(
            $this->getArgument('id')
            );

            // текущий авторизированный пользователь
            $cuser = $this->getUser();

            if (!$cuser->isAllowed('storage-'.$order->getType()) ||
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                throw new ServiceUtils_Exception();
            }

            if ($this->getControlValue('ok')) {
                try {
                    // обновляем информацию
                    StorageOrderService::Get()->updateStorageOrder(
                    $order,
                    $cuser,
                    $this->getControlValue('cdate'),
                    $this->getControlValue('storagenamefromid'),
                    $this->getControlValue('storagenametoid')
                    );

                    $this->setValue('message', 'ok');
                } catch (ServiceUtils_Exception $te) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $te->getErrorsArray());
                }
            }

            // получаем системную валюту
            $defaultCurrency = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // форма добавления товара
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-order-product-add');
            $block->setValue('isOrderIncoming', ($order->getType() == 'incoming'));
            $parameterArray = array();
            $parameterArray[] = array('name' => 'orderid', 'value' => $order->getId());
            $block->setValue('parameterArray', $parameterArray);
            $this->setValue('addForm', $block->render());

            // таблица товаров
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-order-table-block');
            $block->setValue('orderid', $order->getId());
            $this->setValue('productTable', $block->render());

            $this->setValue('sum', $order->getSum());
            $this->setValue('currency', $defaultCurrency->getSymbol());
            $this->setValue('orderid', $order->getId());
            $this->setValue('ordertype', $order->getType());
            $this->setValue('isshipped', $order->getIsshipped());
            $this->setValue('canAction', StorageOrderService::Get()->hasStorageOrderProducts($order));

            $this->setControlValue('cdate', $order->getCdate());
            $this->setControlValue('storagenamefromid', $order->getStoragenamefromid());
            $this->setControlValue('storagenametoid', $order->getStoragenametoid());

            // склады, в зависимости от типа заказа
            if ($order->getType() == 'incoming') {
                // поставщики
                $suppliers = StorageNameService::Get()->getStorageNamesForIncomingFromByUser($cuser);
                $this->setValue('storagenamefromArray', $suppliers->toArray());

                // склады
                $storageNames = StorageNameService::Get()->getStorageNamesForIncomingToByUser($cuser);
                $this->setValue('storagenametoArray', $storageNames->toArray());

            } elseif ($order->getType() == 'transfer') {
                // все склады с которых можно перемещать
                $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
                $cuser
                );
                $this->setValue('storagenamefromArray', $storageNames->toArray());

                // все склады на которые можно перемещать
                $storageNames = StorageNameService::Get()->getStorageNamesForTransfers($cuser);
                $storageNamesArray = array();
                while ($storageName = $storageNames->getNext()) {
                    $operations = array();
                    if ($cuser->isAllowed('storagename-'.$storageName->getId().'-transferto')) {
                        $operations[] = 'Перемещение';
                    }
                    if ($cuser->isAllowed('storagename-'.$storageName->getId().'-returnto')) {
                        $operations[] = 'Возврат';
                    }
                    if (!empty($operations)) {
                        $action = '('.implode(', ', $operations).')';
                        $storageNamesArray[] = array(
                        'id' => $storageName->getId(),
                        'name' => $storageName->getName().' '.$action
                        );
                    }
                }
                $this->setValue('storagenametoArray', $storageNamesArray);

            } elseif ($order->getType() == 'production') {
                // все склады с которых можно перемещать
                $storageNames = StorageNameService::Get()->getStorageNamesForTransferFromByUser(
                $cuser
                );
                $this->setValue('storagenamefromArray', $storageNames->toArray());

                // все склады на которые можно перемещать
                $storageNames = StorageNameService::Get()->getStorageNamesForTransferToByUser(
                $cuser
                );
                $this->setValue('storagenametoArray', $storageNames->toArray());
            }

            if (Shop_ModuleLoader::Get()->isImported('document')) {
                // блок документов
                $block_documents = Engine::Get()->GetContentDriver()->getContent('shop-admin-document-list-block');
                $block_documents->setValue('linkkey', $order->getClassname().'-'.$order->getId());
                $this->setValue('block_documents', $block_documents->render());
            }

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}