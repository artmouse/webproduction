<?php
class storage_sale_quick extends Engine_Class {

    public function process() {
        $cuser = $this->getUser();

        // определяем, выбран ли склад, с которого будут перемещаться товары
        $storageName = false;

        try {
            $storageName = StorageNameService::Get()->getStorageNameByID(
            $this->getControlValue('storagefromid')
            );
        } catch (Exception $e) {}

        // товары в корзине
        $sales = StorageSaleService::Get()->getSalesByUser($cuser, true);
        while ($sale = $sales->getNext()) {
            try {
                $storageName = $sale->getStorageName();
            } catch (Exception $e) {}
        }

        // проводим быструю продажу
        if ($this->getControlValue('process')) {
            try {
                SQLObject::TransactionStart();

                // получаем клиента
                $client = false;
                try {
                    $client = Shop::Get()->getUserService()->getUserByID(
                    $this->getControlValue('userid')
                    );
                } catch (ServiceUtils_Exception $ce) {

                }

                // оформляем заказ
                $order = StorageSaleService::Get()->makeOrder(
                $cuser,
                $this->getControlValue('contractorid'),
                $client?$client->getId():false,
                $this->getControlValue('name'),
                $this->getControlValue('comments')
                );

                // оформляем отгрузку
                $transactionID = StorageSaleService::Get()->processSale(
                $cuser,
                $this->getControlValue('date'),
                true, // quick
                $order->getId()
                );

                // оформляем платеж
                if (Shop_ModuleLoader::Get()->isImported('finance') && $this->getControlValue('paymentamount')) {
                    $linkkey = 'order-'.$order->getId();

                    $payment = PaymentService::Get()->addPayment(
                    $cuser,
                    $this->getControlValue('paymentaccountid'),
                    $this->getControlValue('paymentamount'),
                    'fromclient',
                    'proceed',
                    $this->getControlValue('paymentpdate'),
                    $order->getUserid(),
                    false,
                    false,
                    $this->getControlValue('paymentcategoryid'),
                    $this->getControlValue('paymentcode'),
                    $this->getControlValue('paymentbankdetail'),
                    $this->getControlValue('paymentcomment'),
                    $this->getControlValue('paymentinvoiceid'),
                    $this->getControlValue('paymentfile'),
                    $linkkey
                    );
                }

                SQLObject::TransactionCommit();

                if ($transactionID) {
                    $this->setValue('messageprocess', 'ok');

                    // если товары были оприходованы, редиректимся
                    // на страницу просмотра прихода
                    $this->setValue('urlredirect',
                    Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-motion-view',
                    $transactionID
                    ));
                } else {
                    $this->setValue('messageinfo', 'nosale');
                }
            } catch (ServiceUtils_Exception $e) {
                SQLObject::TransactionRollback();

                $this->setValue('messageprocess', 'error');

                $errorArray = array();
                $exArray = $e->getErrorsArray();

                foreach ($exArray as $error) {
                    if (preg_match("/^(\d+):(\w+)$/uis", $error, $r)) {
                        try {
                            $basket = StorageService::Get()->getStorageBasketByID($r[1]);
                            $product = $basket->getProduct();

                            $errorArray[] = array(
                            'product' => '#'.$product->getId().' - '.$product->getName().' ('.$basket->getAmount().' '.$product->getUnit().')',
                            'error' => $r[2]
                            );
                        } catch (ServiceUtils_Exception $re) {}
                    } else {
                        $errorArray[] = array(
                        'error' => $error
                        );
                    }
                }

                $this->setValue('errorsArray', $errorArray);

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        if ($storageName) {
            $this->setControlValue('storagefromid', $storageName->getId());
            $this->setValue('storagefromname', $storageName->getName());

            // форма добавления товара
            $block = Engine::GetContentDriver()->getContent('shop-admin-storage-ajax-product-form-block');
            $block->setValue('formID', 'id-form-sale-add');
            $parameterArray = array();
            $parameterArray[] = array('name' => 'storagefromid', 'value' => $storageName->getId());
            $block->setValue('parameterArray', $parameterArray);
            $block->setValue('isSale', true);
            $this->setValue('addForm', $block->render());
        }

        // таблица товаров в корзине
        $block = Engine::GetContentDriver()->getContent('shop-admin-storage-sale-table-block');
        $this->setValue('productTable', $block->render());

        // все склады с которых можно продавать
        $storageNames = StorageNameService::Get()->getStorageNamesForSaleByUser(
        $cuser
        );
        $this->setValue('storagesfromArray', $storageNames->toArray());

        // юр лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        //
        try {
            $client = Shop::Get()->getUserService()->getUserByID(
            $this->getControlValue('userid')
            );

            $this->setValue('clientName', $client->makeName());
        } catch (Exception $e) {

        }

        $this->setControlValue('date', date('Y-m-d H:i:s'));

        // для создания платежа
        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            
            // Аккаунты
            $accounts = FinanceService::Get()->getAccountsActive();
            $a = array();
            while ($x = $accounts->getNext()) {
                if ($cuser->isDenied('finance-account-'.$x->getId().'-control')) {
                    continue;
                }

                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }
            $this->setValue('accountArray', $a);

            // Категория
            $categories = FinanceService::Get()->getCategoryAll();
            $a = array();
            while ($x = $categories->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
                );
            }
            $this->setValue('categoryArray', $a);
        }

    }

}