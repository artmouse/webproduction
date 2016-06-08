<?php

class storage_motion_return extends Engine_Class {

    public function process() {
        try {
            // один из товаров в перемещении
            $storageProduct = StorageService::Get()->getStorageByID(
                $this->getArgument('id')
            );

            $cuser = $this->getUser();

            // транзакция
            $transaction = StorageService::Get()->getStorageTransactionByID($storageProduct->getTransactionid());

            // если это транзакция-производства или транзакция-возврат
            // то возврат делать нельзя
            if ($transaction->getType() == 'production' || $transaction->getReturn()) {
                $this->setValue('message', 'noreturn');
            }

            // склады
            $storageNameFrom = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenametoid());
            $storageNameTo = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenamefromid());

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageNameTo, 'transferfrom')) {
                $this->setValue('message', 'noreturn');
            }

            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageNameFrom, 'returnto')) {
                $this->setValue('message', 'noreturn');
            }

            // проведение возврата
            if ($this->getControlValue('ok')) {
                try {
                    // получаем товары транзакции
                    $storageProducts = StorageService::Get()->getStoragesAll();
                    $storageProducts->setTransactionid($transaction->getId());
                    $storageProducts->addWhere('amount', 0, '>');

                    // получаем возвращаемые количества
                    $amountArray = array();
                    while ($sp = $storageProducts->getNext()) {
                        $amountArray[$sp->getId()] = $this->getControlValue('amount' . $sp->getId());
                    }

                    // проводим возврат
                    $storageID = StorageService::Get()->processReturn(
                        $transaction, $cuser, $amountArray
                    );

                    $this->setValue('message', 'ok');

                    if ($storageID) {

                        // если товары были возвращены, редиректимся
                        // на страницу просмотра возврата
                        $this->setValue(
                            'urlredirect', Engine::GetLinkMaker()->makeURLByContentIDParam(
                                'shop-admin-storage-motion-view', $storageID
                            )
                        );
                    } else {
                        $this->setValue('messageinfo', 'notransfer');
                    }
                } catch (ServiceUtils_Exception $e) {
                    $this->setValue('message', 'error');

                    $errorArray = array();
                    $exArray = $e->getErrorsArray();

                    foreach ($exArray as $error) {
                        if (preg_match("/^(\d+):(\w+)$/uis", $error, $r)) {
                            try {
                                $s = StorageService::Get()->getStorageByID($r[1]);
                                $product = $s->getProduct();

                                $errorArray[] = array(
                                    'product' => 
                                    $product->getName() . ' (' . $s->getAmount() . ' ' . $product->getUnit() . ')',
                                    'error' => $r[2]
                                );
                            } catch (ServiceUtils_Exception $re) {
                                
                            }
                        } else {
                            $errorArray[] = array(
                                'error' => $error
                            );
                        }
                    }

                    $this->setValue('errorArray', $errorArray);

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            // валюта по умолчанию
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencyDefault->getSymbol());

            // данные о транзакции
            $this->setValue('date', DateTime_Formatter::DateTimeRussianGOST($storageProduct->getDate()));
            $this->setValue('type', $storageProduct->makeType());
            $this->setValue('storagenamefrom', $storageNameFrom->getName());
            $this->setValue('storagenamefromURL', $storageNameFrom->makeURLMotionlog());
            $this->setValue('storagenameto', $storageNameTo->getName());
            $this->setValue('storagenametoURL', $storageNameTo->makeURLMotionlog());

            try {
                $this->setValue('username', $storageProduct->getUser()->getName());
            } catch (ServiceUtils_Exception $se) {
                
            }

            // если продажа
            if ($storageProduct->getType() == 'sale') {
                try {
                    $orderProduct = Shop::Get()->getShopService()->getOrderProductById(
                        $storageProduct->getOrderproductid()
                    );
                    $order = Shop::Get()->getShopService()->getOrderByID($orderProduct->getOrderid());

                    $this->setValue('orderid', $order->getId());
                    $this->setValue('orderURL', $order->makeURLEdit());
                    $this->setValue('client', $order->getClientname());
                    $this->setValue('clientphone', $order->getClientphone());
                    $this->setValue('clientaddress', $order->getClientaddress());
                    $this->setValue('clientemail', $order->getClientemail());
                } catch (ServiceUtils_Exception $se) {
                    
                }
            }

            // список всех товаров транзакции
            $sum = 0;
            $storageProducts = StorageService::Get()->getStorageMotion($cuser, $transaction->getId());
            $storageArray = array();

            // если уже были возвраты по этой транзакции:
            // По каждому товару из транзакции, получаем количество,
            // которое уже было возвращено (в виде массива)
            $returnAmountArray = StorageService::Get()->getStorageReturnedAmountArray($transaction, $cuser);

            while ($sp = $storageProducts->getNext()) {
                try {
                    $product = $sp->getProduct();

                    $storageArray[] = array(
                        'id' => $sp->getId(),
                        'productid' => $sp->getProductid(),
                        'name' => $product->getName(),
                        'serial' => $sp->getSerial(),
                        'price' => $sp->getPricebase(),
                        'unit' => $product->getUnit(),
                        'amount' => $sp->getAmount(),
                        'amount_returned' => @$returnAmountArray[$sp->getId()],
                        'amount_toreturn' => $sp->getAmount() - @$returnAmountArray[$sp->getId()]
                    );

                    $sum += $sp->getAmount() * $sp->getPricebase();
                } catch (ServiceUtils_Exception $se) {
                    
                }
            }

            $this->setValue('storageArray', $storageArray);
            $this->setValue('sum', $sum);

            // ссылка на журнал
            $this->setValue(
                'urlMotion', Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-storage-motion-view', $storageProduct->getId()
                )
            );

            // таблица уже проведенных возвратов
            $table = new Shop_ContentTable(
                new Datasource_Storage_Motionlog(
                    false, false, false, false, false, false, $transaction->getId()
                )
            );

            $table->removeField('id');
            $table->removeField('return');
            $this->setValue('table', $table->render());
        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}