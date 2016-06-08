<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class StorageService extends ServiceUtils_AbstractService {

    /**
     * Получить складскую запись по ID
     *
     * @param int $storageID
     *
     * @return ShopStorage
     */
    public function getStorageByID($storageID) {
        return $this->getObjectByID($storageID, 'ShopStorage');
    }

    /**
     * Получить информацию о приходе товара
     *
     * @param User $cuser
     * @param string $code
     *
     * @return ShopStorage
     *
     * @throws ServiceUtils_Exception
     */
    public function getStorageByCode(User $cuser, $code) {
        $x = $this->getStoragesByUser($cuser);
        $x->addWhere('amount', 0, '>');
        $x->setCode($code);
        $x->setOrder('cdate', 'ASC');

        if ($x = $x->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить обратную запись данной
     *
     * @param ShopStorage $storage
     *
     * @return ShopStorage
     *
     * @throws ServiceUtils_Exception
     */
    public function getStorageReverseRecord(ShopStorage $storage) {
        $x = $this->getStoragesAll();
        $x->setCdate($storage->getCdate());
        $x->setUserid($storage->getUserid());
        $x->setCode($storage->getCode());
        $x->setAmount(-$storage->getAmount());
        $x->setStoragenamefromid($storage->getStoragenametoid());
        $x->setStoragenametoid($storage->getStoragenamefromid());

        if ($x = $x->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить все складские записи
     *
     * @return ShopStorage
     */
    public function getStoragesAll() {
        $x = new ShopStorage();
        $x->setOrder('date', 'DESC');
        return $x;
    }

    /**
     * Записи о товарах на складе, привязанные к данному складу
     *
     * @param ShopStorageName $storageName
     *
     * @return ShopStorage
     */
    public function getStoragesByStorageName(ShopStorageName $storageName) {
        $x = $this->getStoragesAll();
        $x->addWhereQuery(
            '(`storagenamefromid` = \''.$storageName->getId().'\' OR `storagenametoid` = \''.$storageName->getId().'\')'
        );
        return $x;
    }

    /**
     * Записи, которые разрешено видеть пользователю
     *
     * @param User $cuser
     *
     * @return ShopStorage
     */
    public function getStoragesByUser(User $cuser) {
        $x = $this->getStoragesAll();
        if ($cuser->getLevel() == 2) {
            $storageIDs = StorageNameService::Get()->getStorageNameIDsArrayByUser(
                $cuser,
                'motionlog'
            );

            $x->addWhereQuery(
                '(`shopstorage`.`storagenamefromid` IN ('.implode(', ', $storageIDs).') AND
                `shopstorage`.`storagenametoid` IN ('.implode(', ', $storageIDs).'))'
            );

            $typeArray = array('incoming', 'transfer', 'sale', 'production');
            $typeAllowed = array(-1);
            if ($cuser->isAllowed('storage-motionlog')) {
                $typeAllowed = $typeArray;
            } else {
                foreach ($typeArray as $t) {
                    if ($cuser->isAllowed('storage-motionlog-'.$t)) {
                        $typeAllowed[] = $t;
                    }
                }
            }

            $x->addWhereQuery('(`shopstorage`.`type` IN (\''.implode('\',\'', $typeAllowed).'\'))');
        }
        return $x;
    }

    /**
     * Получить записи о складе, которые разрешено видеть пользователю
     * с при-join-иной таблицей ShopProduct
     *
     * @param User $cuser
     *
     * @return ShopStorage
     */
    public function getStoragesByUserJoined(User $cuser) {
        $x = $this->getStoragesByUser($cuser);

        $products = new ShopProduct();

        $x->leftJoinTable(
            $products->getTablename(),
            $x->getTablename().'.`productid` = '.$products->getTablename().'.`id`'
        );

        $x->addFieldQuery($products->getTablename().'.name AS productname');
        $x->addWhereQuery($products->getTablename().'.deleted = 0 ');

        return $x;
    }

    /**
     * Получить записи для "истории товара"
     *
     * @param string $code
     *
     * @return ShopStorage
     */
    public function getStoragesByCode(User $cuser, $code) {
        $x = $this->getStoragesByUser($cuser);
        $x->setCode($code);

        // нас интересуют только "прямые" записи
        $x->addWhere('amount', 0, '>');
        return $x;
    }

    /**
     * Получить все товары транзакции
     *
     * @param ShopStorageTransaction $transaction
     *
     * @return ShopStorage
     */
    public function getStoragesByTransaction(ShopStorageTransaction $transaction) {
        $x = new ShopStorage();
        $x->setTransactionid($transaction->getId());
        return $x;
    }

    /**
     * Получить все перемещения (всех типов или только отдельный тип)
     * для отчета "Журнал перемеещний" (сгруппировано по перемещению)
     *
     * @param User $cuser
     * @param string $type
     * @param string $datefrom
     * @param string $dateto
     * @param ShopStorageName $storageName
     * @param array $storageNameFromIDArray
     * @param array $storageNameToIDArray
     * @param int $returnTransactionID
     * @param int $orderID
     * @param int $productID
     *
     * @return ShopStorage
     */
    public function getStorageMotionLog(User $cuser, $type, $datefrom, $dateto,
    $storageName, $storageNameFromIDArray = false, $storageNameToIDArray = false,
    $returnTransactionID = false, $orderID = false, $productID = false) {
        $transaction = $this->getStorageTransactionsAll();

        if ($cuser->getLevel() == 2) {
            $storageIDs = StorageNameService::Get()->getStorageNameIDsArrayByUser(
                $cuser,
                'motionlog'
            );

            $transaction->addWhereQuery(
                '('.$transaction->getTablename().'.`storagenamefromid` IN ('.
                implode(', ', $storageIDs).') AND '.$transaction->getTablename().'.`storagenamefromid` IN ('.
                implode(', ', $storageIDs).'))'
            );
        }

        // тип
        if ($type) {
            $transaction->setType($type);
        }

        // дата с
        if ($datefrom) {
            $transaction->addWhereQuery('( DATE('.$transaction->getTablename().'.`date`) >= \''.$datefrom.'\' )');
        }

        // дата по
        if ($dateto) {
            $transaction->addWhereQuery('( DATE('.$transaction->getTablename().'.`date`) <= \''.$dateto.'\' )');
        }

        // склад
        if ($storageName) {
            $transaction->addWhereQuery(
                '('.$transaction->getTablename().'.`storagenamefromid` = '.
                $storageName->getId().' OR '.$transaction->getTablename().
                '.`storagenametoid` = '.$storageName->getId().')'
            );
        }

        if ($storageNameFromIDArray) {
            $transaction->addWhereQuery(
                '('.$transaction->getTablename().'.`storagenamefromid` IN ('.implode(',', $storageNameFromIDArray).'))'
            );
        }

        if ($storageNameToIDArray) {
            $transaction->addWhereQuery(
                '('.$transaction->getTablename().'.`storagenametoid` IN ('.implode(',', $storageNameToIDArray).'))'
            );
        }

        // транзакции-возвраты
        if ($returnTransactionID) {
            $transaction->setReturntransactionid($returnTransactionID);
        }

        // заказ
        if ($orderID) {
            $transaction->setOrderid($orderID);
        }

        // товар
        if ($productID) {
            $storage = new ShopStorage();

            // нужно приджойнить все складские записи
            $transaction->leftJoinTable(
                $storage->getTablename(),
                $transaction->getTablename().'.`id` = '.$storage->getTablename().'.`transactionid`'
            );

            // пересчитать количество и сумму товара только для данного товара
            $transaction->addFieldQuery('SUM('.$storage->getTablename().'.`amount`) AS `amount`');

            $transaction->addFieldQuery(
                'SUM('.$storage->getTablename().'.`pricebase` * '.$storage->getTablename().'.`amount`) AS `cost`'
            );

            $transaction->addWhereQuery('('.$storage->getTablename().'.`productid` = '.$productID.')');
            $transaction->addWhereQuery('('.$storage->getTablename().'.`amount` > 0)');
            $transaction->setGroupByQuery($transaction->getTablename().'.`id`');
        }

        return $transaction;
    }

    /**
     * Получить все записи одного конкретного перемещения (все товары)
     *
     * @param User $cuser
     * @param int $transactionID
     * @param bool $onlyTarget
     * @param bool $onlyMaterial
     *
     * @return ShopStorage
     */
    public function getStorageMotion(User $cuser, $transactionID, $onlyTarget = false,
    $onlyMaterial = false) {

        // проверка прав todo

        $x = $this->getStoragesByUserJoined($cuser);

        // нас интересуют только "прямые" записи
        $x->addWhere('amount', 0, '>');

        $x->setTransactionid($transactionID);

        // только товары-цели (производство)
        if ($onlyTarget) {
            $transaction = $this->getStorageTransactionByID($transactionID);
            $x->setStoragenametoid($transaction->getStoragenametoid());
        }

        // только товары-материал (производство)
        if ($onlyMaterial) {
            $transaction = $this->getStorageTransactionByID($transactionID);
            $x->setStoragenamefromid($transaction->getStoragenamefromid());
        }

        return $x;
    }

    /**
     * Обновить запись
     *
     * @param ShopStorage $storage
     * @param User $cuser
     * @param float $price
     * @param float $amount
     * @param string $shipment
     */
    public function updateStorage(ShopStorage $storage, User $cuser, $price, $amount, $shipment) {
        try {
            SQLObject::TransactionStart();

            $storageOld = clone $storage;

            if ($storage->getType() == 'production') {
                $amount = $storage->getAmount();
            }

            // что обновляется?
            $changePrice = ($storage->getPrice() != $price);
            $changeAmount = ($storage->getAmount() != $amount);
            $changeShipment = ($storage->getShipment() != $shipment);

            // товар
            $product = Shop::Get()->getShopService()->getProductByID($storage->getProductid());

            // проверки
            if ($changeAmount) {
                $amount = str_replace(',', '.', $amount);
                $amount = (float) trim($amount);

                if ($amount <= 0) {
                    throw new ServiceUtils_Exception('amount');
                }

                if (!$product->testDivisibility($amount)) {
                    throw new ServiceUtils_Exception('divisibility');
                }

                if ($amount > 1 && $storage->getSerial()) {
                    throw new ServiceUtils_Exception('serial');
                }
            }

            if ($changePrice) {
                $price = str_replace(',', '.', $price);
                $price = (float) trim($price);

                if ($price < 0) {
                    throw new ServiceUtils_Exception('price');
                }
            }

            // системная валюта
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // проверка прав пользователя
            if (!$cuser->isAllowed('storage-motionlog-edit')) {
                throw new ServiceUtils_Exception('user');
            }

            // берем все записи с этим кодом
            $storageRecords = $this->getStoragesAll();
            $storageRecords->setCode($storage->getCode());

            if ($changePrice) {
                // обновляем цену везде (во всей цепочке)
                $storageRecordsPrice = clone $storageRecords;
                while ($storageRecord = $storageRecordsPrice->getNext()) {
                    $money = new ShopMoney($price, $storage->getCurrency(), $storage->getTaxrate());
                    $price = $money->getAmount();
                    $taxRate = $money->getTaxRate();
                    $priceBase = $money->changeCurrency($currencySystem)->getAmount();

                    $storageRecord->setPricebase($priceBase);
                    $storageRecord->setPrice($price);
                    $storageRecord->setCurrencyrate($storageRecord->getCurrency()->getRate());
                    $storageRecord->update();

                    StorageBalanceService::Get()->updateBalance(
                        $storageRecord->getStorageNameFrom(),
                        $storageRecord->getProduct(),
                        $storageRecord->getCode()
                    );

                    StorageBalanceService::Get()->updateBalance(
                        $storageRecord->getStorageNameTo(),
                        $storageRecord->getProduct(),
                        $storageRecord->getCode()
                    );
                }
            }

            if ($changeShipment) {
                // обновляем код партии везде (во всей цепочке)
                $storageRecordsShipment = clone $storageRecords;
                while ($storageRecord = $storageRecordsShipment->getNext()) {
                    $storageRecord->setShipment($shipment);
                    $storageRecord->update();

                    StorageBalanceService::Get()->updateBalance(
                        $storageRecord->getStorageNameFrom(),
                        $storageRecord->getProduct(),
                        $storageRecord->getCode()
                    );

                    StorageBalanceService::Get()->updateBalance(
                        $storageRecord->getStorageNameTo(),
                        $storageRecord->getProduct(),
                        $storageRecord->getCode()
                    );
                }
            }

            if ($changeAmount) {
                $storageRecord = clone $storage;

                $storageRecords->addWhere('amount', 0, '>');
                $storageRecords->addWhere('id', $storage->getId(), '<>');

                $storageRecords_test = clone $storageRecords;

                // если количество стало меньше
                if ($amount < $storage->getAmount()) {

                    // нас интересует, не нарушится ли баланс дальше по цепочке
                    // если же произошла продажа, то можно баланс не смотреть

                    // смотрим, есть ли записи с этим кодом старше по дате
                    $storageRecords->addWhere('cdate', $storage->getCdate(), '>=');

                    if (!$storageRecords->getNext() || $storage->getType() == 'sale') {
                        // если записей с таким кодом нет - спокойно обновляем количество
                        $storageRecord->setAmount($amount);
                        $storageRecord->update();

                        $storageRecord = $this->getStorageReverseRecord($storage);
                        $storageRecord->setAmount(-$amount);
                        $storageRecord->update();
                    } else {
                        // если записи с таким кодом есть

                        // проверка :
                        // нельзя редактировать количество, если после редактируемой
                        // транзакции были перемещения на storageto товара с данным кодом
                        // (тогда невозможно делать выводы на основании баланса)
                        $storageRecords_test->addWhere('cdate', $storage->getCdate(), '>=');
                        $storageRecords_test->setStoragenametoid($storage->getStoragenametoid());
                        if ($storageRecords_test->getNext()) {
                            throw new ServiceUtils_Exception('laterTransfer');
                        }

                        // текущий баланс товара на складе
                        $balance = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                            $cuser,
                            $storage->getStorageNameTo(),
                            $storage->getProduct(),
                            $storage->getCode(),
                            $storage->getSerial()
                        );

                        $balance = $balance->getNext();
                        $balanceAmount = $balance->getAmountAvailable();

                        // если количество уменьшится на количетсво большее, чем сейчас на балансе
                        // получится нестыковка - отрицательный баланс
                        if (($storage->getAmount() - $amount) > $balanceAmount) {
                            throw new ServiceUtils_Exception('amountTooSmall');
                        } else {
                            $storageRecord->setAmount($amount);
                            $storageRecord->update();

                            $storageRecord = $this->getStorageReverseRecord($storage);
                            $storageRecord->setAmount(-$amount);
                            $storageRecord->update();
                        }
                    }
                } else {
                    // если количество стало больше, нас интересует,
                    // не нарушится ли баланс ранее по цепочке
                    // если же это приход, то можно баланс не смотреть

                    // смотрим, есть ли записи с этим кодом раньше по дате
                    $storageRecords->addWhere('cdate', $storage->getCdate(), '<=');

                    if (!$storageRecords->getNext() || $storage->getType() == 'incoming') {
                        // если записей с таким кодом нет - спокойно обновляем количество
                        $storageRecord->setAmount($amount);
                        $storageRecord->update();

                        $storageRecord = $this->getStorageReverseRecord($storage);
                        $storageRecord->setAmount(-$amount);
                        $storageRecord->update();
                    } else {
                        // если записи с таким кодом есть

                        // проверка :
                        // нельзя редактировать количество, если после редактируемой
                        // транзакции были перемещения на storagefrom товара с данным кодом
                        // (тогда невозможно делать выводы на основании баланса)
                        $storageRecords_test->addWhere('cdate', $storage->getCdate(), '>=');
                        $storageRecords_test->setStoragenametoid($storage->getStoragenamefromid());
                        if ($storageRecords_test->getNext()) {
                            throw new ServiceUtils_Exception('laterTransfer');
                        }

                        // текущий баланс товара на складе
                        $balance = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                            $cuser,
                            $storage->getStorageNameFrom(),
                            $storage->getProduct(),
                            $storage->getCode(),
                            $storage->getSerial()
                        );

                        $balance = $balance->getNext();
                        $balanceAmount = $balance->getAmountAvailable();

                        // если количество увеличится на количетсво большее, чем сейчас на балансе
                        // получится нестыковка - отрицательный баланс
                        if (($amount - $storage->getAmount()) > $balanceAmount) {
                            throw new ServiceUtils_Exception('amountTooLarge');
                        } else {
                            $storageRecord->setAmount($amount);
                            $storageRecord->update();

                            $storageRecord = $this->getStorageReverseRecord($storage);
                            $storageRecord->setAmount(-$amount);
                            $storageRecord->update();
                        }
                    }
                }
            }

            // обновляем записи баланса
            StorageBalanceService::Get()->updateBalance(
                $storage->getStorageNameFrom(),
                $storage->getProduct()
            );

            StorageBalanceService::Get()->updateBalance(
                $storage->getStorageNameTo(),
                $storage->getProduct()
            );

            SQLObject::TransactionCommit();

            try {
                $storageNew = $this->getStorageByID($storageOld->getId());
                $this->_editXML($cuser, $storageOld, $storageNew);
            } catch (Exception $se) {

            }

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить складскую запись
     *
     * @param ShopStorage $storage
     * @param User $cuser
     * @param bool $transaction
     */
    public function deleteStorage(ShopStorage $storage, User $cuser, $transaction = false) {
        try {
            SQLObject::TransactionStart();

            $storageOldArray = array();

            // проверка прав пользователя
            if (!$cuser->isAllowed('storage-motionlog-delete')) {
                throw new ServiceUtils_Exception('user');
            }

            // берем все записи с этим кодом
            $storageRecords = $this->getStoragesAll();
            $storageRecords->setCode($storage->getCode());
            $storageRecords->addWhere('amount', 0, '>');
            $storageRecords->addWhere('cdate', $storage->getCdate(), '>=');

            while ($storageRecord = $storageRecords->getNext()) {
                // если это производство - можно удалить только если удаляется вся транзакция
                // и это запись именно из удаляемой транзкции
                if ($storageRecord->getType() == 'pack' &&
                (!$transaction || $storage->getId() != $storageRecord->getId())
                ) {
                    throw new ServiceUtils_Exception('production');
                }

                $oldStorageRecord = clone $storageRecord;
                $storageTransaction = $storageRecord->getStorageTransaction();

                $storageOldArray[] = $oldStorageRecord;

                $storageRecord->delete();

                $reverse = $this->getStorageReverseRecord($oldStorageRecord);
                $reverse->delete();

                // проверка, если удалены все записи из транзакции - удаляем и саму транзакцию
                $sts = $this->getStoragesByTransaction($storageTransaction);
                if (!$sts->getNext()) {
                    $storageTransaction->delete();
                }
                try {
                    // обновляем записи баланса
                    StorageBalanceService::Get()->updateBalance(
                        $oldStorageRecord->getStorageNameFrom(),
                        $oldStorageRecord->getProduct(),
                        $oldStorageRecord->getCode()
                    );

                    StorageBalanceService::Get()->updateBalance(
                        $oldStorageRecord->getStorageNameTo(),
                        $oldStorageRecord->getProduct(),
                        $oldStorageRecord->getCode()
                    );
                } catch (Exception $ex) {
                    
                }
                
            }

            SQLObject::TransactionCommit();

            try {
                foreach ($storageOldArray as $storageOld) {
                    $this->_deleteXML($cuser, $storageOld);
                }
            } catch (Exception $se) {

            }

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить складсукю транзакцию
     *
     * @param ShopStorageTransaction $storageTransaction
     * @param User $cuser
     */
    public function deleteStorageTransaction(ShopStorageTransaction $storageTransaction, User $cuser) {
        try {
            SQLObject::TransactionStart();

            $storages = $this->getStoragesAll();
            $storages->setTransactionid($storageTransaction->getId());
            while ($storage = $storages->getNext()) {
                $this->deleteStorage($storage, $cuser, true);
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить складскую транзакцию по ID
     *
     * @return ShopStorageTransaction
     */
    public function getStorageTransactionByID($id) {
        return $this->getObjectByID($id, 'ShopStorageTransaction');
    }

    /**
     * Получить все транзакции
     *
     * @return ShopStorageTransaction
     */
    public function getStorageTransactionsAll() {
        $x = new ShopStorageTransaction();
        $x->setOrder('date', 'DESC');
        return $x;
    }

    /**
     * Создать транзакцию
     *
     * @param User $user
     * @param string $type
     * @param string $date
     * @param ShopStorageName $storageNameFrom
     * @param ShopStorageName $storageNameTo
     * @param string $return
     * @param string $orderID
     * @param int $returnTransactionID
     *
     * @return ShopStorageTransaction
     */
    public function addStorageTransaction(User $user, $type, $date, $storageNameFrom,
    $storageNameTo, $return, $orderID, $returnTransactionID = false) {
        try {
            SQLObject::TransactionStart();

            $client = '';
            if ($orderID) {
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                $client = $order->getClientname();
                /*if ($order->getClientaddress()) {
                $client .= ', '.$order->getClientaddress();
                }
                if ($order->getClientemail()) {
                $client .= ', '.$order->getClientemail();
                }
                if ($order->getClientphone()) {
                $client .= ', '.$order->getClientphone();
                }*/
            }

            $date = DateTime_Corrector::CorrectDateTime($date);
            $cdate = date('Y-m-d H:i:s');

            $transaction = new ShopStorageTransaction();
            $transaction->setType($type);
            $transaction->setUserid($user->getId());
            $transaction->setCdate($cdate);
            $transaction->setDate($date);
            $transaction->setStoragenamefromid($storageNameFrom->getId());
            $transaction->setStoragenametoid($storageNameTo->getId());
            $transaction->setReturn($return);
            $transaction->setReturntransactionid($returnTransactionID);
            $transaction->setOrderid($orderID);
            $transaction->setClient($client);
            $transaction->insert();

            SQLObject::TransactionCommit();

            return $transaction;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * По каждому товару из транзакции, получить количество,
     * которое уже было возвращено (в виде массива)
     *
     * @param ShopStorageTransaction $transaction
     * @param User $cuser
     *
     * @return array
     */
    public function getStorageReturnedAmountArray(ShopStorageTransaction $transaction, User $cuser) {
        // если были возвраты по этой транзакции
        // получаем массив ид-шников этих транзакций-возвратов
        $transactions_return = StorageService::Get()->getStorageTransactionsAll();
        $transactions_return->setReturntransactionid($transaction->getId());
        $returnIDArray = array(-1);
        while ($x = $transactions_return->getNext()) {
            $returnIDArray[] = $x->getId();
        }

        $storageProducts = StorageService::Get()->getStorageMotion($cuser, $transaction->getId());
        $amountArray = array();
        while ($sp = $storageProducts->getNext()) {
            try {
                $amount_returned = 0;
                // получаем все записи со склада об этом товаре,
                // которые принадлежат транзакциям-возвратам по текущей транзакции
                $storages = StorageService::Get()->getStoragesAll();
                $storages->setCode($sp->getCode());
                $storages->addWhere('amount', 0, '>');
                $storages->addWhereQuery('(`transactionid` IN ('.implode(',', $returnIDArray).'))');
                while ($storage = $storages->getNext()) {
                    $amount_returned += $storage->getAmount();
                }

                $amountArray[$sp->getId()] = $amount_returned;
            } catch (ServiceUtils_Exception $se) {

            }
        }

        return $amountArray;
    }

    /**
     * Выполнить возврат
     *
     * @param ShopStorageTransaction $storageTransaction
     * @param User $cuser
     * @param array $amountArray
     */
    public function processReturn(ShopStorageTransaction $transaction, User $cuser,
    $amountArray) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            // если это транзакция-производства или транзакция-возврат
            // то возврат делать нельзя
            if ($transaction->getType() == 'production' || $transaction->getReturn()) {
                throw new ServiceUtils_Exception();
            }

            $storageID = false;

            $storageNameFrom = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenamefromid());
            $storageNameTo = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenametoid());

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $storageNameTo,
                'transferfrom'
            )) {
                throw new ServiceUtils_Exception('user');
            }

            if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $storageNameFrom,
                'returnto'
            )) {
                throw new ServiceUtils_Exception('user');
            }

            // если уже были возвраты по этой транзакции:
            // По каждому товару из транзакции, получаем количество,
            // которое уже было возвращено (в виде массива)
            $returnAmountArray = StorageService::Get()->getStorageReturnedAmountArray($transaction, $cuser);

            // создаем транзакцию возврата
            $return_transaction = StorageService::Get()->addStorageTransaction(
                $cuser,
                $transaction->getType(),
                date('Y-m-d H:i:s'),
                $storageNameTo,
                $storageNameFrom,
                1,
                $transaction->getOrderid(),
                $transaction->getId()
            );

            $amount_total = 0;
            $cost_total = 0;

            $storageProducts = StorageService::Get()->getStoragesAll();
            $storageProducts->setTransactionid($transaction->getId());
            $storageProducts->addWhere('amount', 0, '>');

            // делаем возврат каждого товара транзакции
            while ($sp = $storageProducts->getNext()) {
                try {
                    // проверяем товар
                    $product = $sp->getProduct();

                    // проверяем склад
                    $storageNameFrom = $sp->getStorageNameFrom();
                    $storageNameTo = $sp->getStorageNameTo();
                    // @todo проверка прав заново?
                } catch (ServiceUtils_Exception $ee) {
                    continue;
                }

                // проверки количества
                if (!isset($amountArray[$sp->getId()])) {
                    continue;
                }

                $amount = $amountArray[$sp->getId()];
                if ($amount <= 0) {
                    continue;
                }

                if ($amount > $sp->getAmount()) {
                    $ex->addError($sp->getId().':amount');
                }

                if (isset($returnAmountArray[$sp->getId()])) {
                    if ($amount > $sp->getAmount() - $returnAmountArray[$sp->getId()]) {
                        $ex->addError($sp->getId().':amount');
                    }
                }

                // смотрим остатки на складе
                $balances = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                    $cuser,
                    $storageNameTo,
                    $sp->getProduct(),
                    $sp->getCode(),
                    $sp->getSerial()
                );

                while ($balance = $balances->getNext()) {
                    if ($amount <= 0) {
                        break;
                    }

                    $balanceAmount = $balance->getAmountAvailable();
                    if ($balanceAmount > $amount) {
                        $balanceAmount = $amount;
                    }

                    // получаем запись со склада
                    $storage = new ShopStorage();
                    $storage->setProductid($balance->getProductid());
                    $storage->setCode($balance->getCode());
                    $storage->setSerial($balance->getSerial());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage = $storage->getNext();

                    if (!$storage) {
                        continue;
                    }

                    // вставка новой записи
                    $storage->setId(false);
                    $storage->setProductname($product->getName());
                    $storage->setTransactionid($return_transaction->getId());
                    $storage->setCdate($return_transaction->getCdate());
                    $storage->setDate($return_transaction->getCdate());
                    $storage->setStoragenamefromid($balance->getStoragenameid());
                    $storage->setStoragenametoid($storageNameFrom->getId());
                    $storage->setAmount($balanceAmount);
                    $storage->setUserid($cuser->getId());
                    $storage->setReturn(1);
                    $storage->setType($return_transaction->getType());
                    $storage->setOrderproductid($sp->getOrderproductid());
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();

                    $storageID = $storage->getId();

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageNameFrom->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $balanceAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $balanceAmount;
                }

                if ($amount > 0) {
                    // если товара на складе не хватило
                    $ex->addError($sp->getId().':lack');
                    continue;
                }

                // обновляем записи баланса
                StorageBalanceService::Get()->updateBalance(
                    $storageNameFrom,
                    $product
                );

                StorageBalanceService::Get()->updateBalance(
                    $storageNameTo,
                    $product
                );
            }

            $return_transaction->setAmount($amount_total);
            $return_transaction->setCost($cost_total);
            $return_transaction->update();

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();

            // запись в XML после успешной транзакции!
            StorageService::Get()->transferXML($cuser, $return_transaction->getCdate());

            return $return_transaction->getId();
        } catch (ServiceUtils_Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Разрешено ли юзеру делать возврат по транзакции
     *
     * @param User $cuser
     * @param ShopStorageTransaction $transaction
     *
     * @return bool
     */
    public function isReturnAllowed(User $cuser, ShopStorageTransaction $transaction) {
        $storageNameFrom = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenamefromid());
        $storageNameTo = StorageNameService::Get()->getStorageNameByID($transaction->getStoragenametoid());

        return ($cuser->isAllowed('storage-motionlog-return') &&
        StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageNameTo, 'transferfrom') &&
        StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageNameFrom, 'returnto') &&
        $transaction->getType() != 'production' &&
        !$transaction->getReturn()
        );
    }

    /**
     * Вернуть товар на склад автоматически
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function processReturnAuto(User $cuser, ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            // проверки заказа
            if (!$order->getIsshipped() || $order->getOutcoming()) {
                throw new ServiceUtils_Exception('storage-return-order');
            }

            // получаем все складские транзакции по заказу
            $motionlog = StorageService::Get()->getStorageMotionLog(
                $cuser,
                false,
                false,
                false,
                false,
                false,
                false,
                false,
                $order->getId()
            );

            // продажи со склада еще не было?
            $transaction = $motionlog->getNext();
            if (!$transaction) {
                throw new ServiceUtils_Exception('storage-return-sale-not-found');
            }

            // последняя транзакция по заказу - не продажа?
            if ($transaction->getType() != 'sale') {
                throw new ServiceUtils_Exception('storage-return-sale-not-last');
            }

            // получаем все записи по транзакции
            $storageProducts = StorageService::Get()->getStoragesAll();
            $storageProducts->setTransactionid($transaction->getId());
            $storageProducts->addWhere('amount', 0, '>');

            // получаем массив количества товара для возврата
            $amountArray = array();
            while ($storageProduct = $storageProducts->getNext()) {
                $amountArray[$storageProduct->getId()] = $storageProduct->getAmount();
            }

            // проводим возрат
            try {
                $this->processReturn($transaction, $cuser, $amountArray);
            } catch (ServiceUtils_Exception $se) {
                throw new ServiceUtils_Exception('storage-return-process');
            }

            // заказ считать не отргуженным
            $order->setIsshipped(0);
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить запись складской корзины по ID
     *
     * @return ShopStorageBasket
     */
    public function getStorageBasketByID($id) {
        return $this->getObjectByID($id, 'ShopStorageBasket');
    }

    /**
     * Получить складские корзины пользователя пользователя по типу
     *
     * @param User $user
     * @param string $type
     *
     * @return ShopStorageBasket
     */
    public function getStorageBasketsByUser(User $user, $type) {
        $x = new ShopStorageBasket();
        $x->setUserid($user->getId());
        $x->setType($type);
        return $x;
    }

    /**
     * Обновить дату транзакции
     *
     * @param User $user
     * @param ShopStorageTransaction $transaction
     * @param string $date
     *
     * @return ShopStorageTransaction
     */
    public function updateStorageTransactionDate(User $user,
    ShopStorageTransaction $transaction, $date) {
        try {
            SQLObject::TransactionStart();

            $date = DateTime_Corrector::CorrectDateTime($date);

            // проверка прав пользователя
            if (!$user->isAllowed('storage-motionlog-edit')) {
                throw new ServiceUtils_Exception('user');
            }

            $transaction->setDate($date);
            $transaction->update();

            $storage = $this->getStoragesAll();
            $storage->setTransactionid($transaction->getId());
            while ($s = $storage->getNext()) {
                $s->setDate($date);
                $s->update();

                StorageBalanceService::Get()->updateBalance(
                    $s->getStorageNameFrom(),
                    $s->getProduct(),
                    $s->getCode()
                );

                StorageBalanceService::Get()->updateBalance(
                    $s->getStorageNameTo(),
                    $s->getProduct(),
                    $s->getCode()
                );
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить сумму транзакции
     *
     * @param User $user
     * @param ShopStorageTransaction $transaction
     * @param string $date
     *
     * @return ShopStorageTransaction
     */
    public function updateStorageTransactionProduct(User $user, ShopStorageTransaction $transaction) {
        try {
            SQLObject::TransactionStart();

            // проверка прав пользователя
            if (!$user->isAllowed('storage-motionlog-edit')) {
                throw new ServiceUtils_Exception('user');
            }

            // список товаров перемещения
            $storage = StorageService::Get()->getStorageMotion(
                $user,
                $transaction->getId()
            );

            $sum = 0;
            $amount = 0;
            while ($x = $storage->getNext()) {
                $sum += $x->getAmount() * $x->getPricebase();
                $amount+= $x->getAmount();
            }

            $transaction->setCost($sum);
            $transaction->setAmount($amount);
            $transaction->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить название транзакции по ключу
     *
     * @param string $key
     *
     * @return string
     */
    public function getTransactionTypeNameByKey($key) {
        if ($key == 'incoming') {
            return Shop::Get()->getTranslateService()->getTranslateSecure('translate_incoming');
        } elseif ($key == 'transfer') {
            return Shop::Get()->getTranslateService()->getTranslateSecure('translate_transfer');
        } elseif ($key == 'sale') {
            return Shop::Get()->getTranslateService()->getTranslateSecure('translate_sale');
        } elseif ($key == 'production') {
            return Shop::Get()->getTranslateService()->getTranslateSecure('translate_production');
        } elseif ($key == 'outcoming') {
            return Shop::Get()->getTranslateService()->getTranslateSecure('translate_outcoming');
        }
    }

    /**
     * Выгрузить перемещение в XML
     *
     * @param User $user
     * @param string $date
     */
    public function transferXML(User $user, $date) {
        PackageLoader::Get()->import('XML');

        $info = array();
        $info['userid'] = $user->getId();
        $info['username'] = $user->getName();
        $info['datetime'] = $date;

        // сохраняем информацию о транзакции
        $transaction = new ShopStorageTransaction();
        $transaction->setUserid($user->getId());
        $transaction->setCdate($date);

        if (!$transaction = $transaction->getNext()) {
            return false;
        }

        $type = $transaction->getType();
        $info['transactionid'] = $transaction->getId();
        $info['transactiontype'] = $type;

        if ($type == 'sale') {
            $info['orderid'] = $transaction->getOrderid();

            try {
                $order = Shop::Get()->getShopService()->getOrderByID($transaction->getOrderid());

                $info['clientname'] = $order->getClientname();
                $info['clientphone'] = $order->getClientphone();
                $info['clientemail'] = $order->getClientemail();
                $info['clientcontacts'] = $order->getClientcontacts();
                $info['clientaddress'] = $order->getClientaddress();
            } catch (ServiceUtils_Exception $se) {

            }
        } elseif ($type == 'transfer') {
            if ($transaction->getReturn()) {
                $info['return'] = 1;
            }

            if ($transaction->getRequest()) {
                $info['request'] = $transaction->getRequest();
            }
        } elseif ($type == 'incoming') {
            if ($transaction->getDocument()) {
                $info['document'] = $transaction->getDocument();
            }
        }

        // сохраняем информацию о товарах
        $storages = new ShopStorage();
        $storages->setUserid($user->getId());
        $storages->setCdate($date);
        $storages->addWhere('amount', 0, '>');

        $a = $b = array();
        while ($s = $storages->getNext()) {

            $b['productid'] = $s->getProductid();

            try {
                $b['code1c'] = $s->getProduct()->getCode1c();
            } catch (Exception $e) {
                $b['code1c'] = '';
            }

            try {
                $b['productname'] = $s->getProduct()->getName();
            } catch (Exception $e) {

            }

            $b['serial'] = $s->getSerial();
            if ($type == 'incoming') {
                $b['shipment'] = $s->getShipment();
                $b['warranty'] = $s->getWarranty();
            }

            $b['amount'] = $s->getAmount();
            $b['price'] = $s->getPrice();
            $b['currencyid'] = $s->getCurrencyid();
            $b['taxrate'] = $s->getTaxrate();

            $b['pricebase'] = $s->getPricebase();
            $b['currencybaseid'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
            $b['currencybase'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol();

            try {
                $b['currency'] = $s->getCurrency()->getSymbol();
            } catch (Exception $e) {

            }

            $b['currencyrate'] = $s->getCurrencyrate();

            $b['storagenamefromid'] = $s->getStoragenamefromid();
            $b['storagenametoid'] = $s->getStoragenametoid();

            try {
                $b['storagenamefromname'] = $s->getStoragenamefrom()->getName();
                $b['storagenametoname'] = $s->getStoragenameto()->getName();
            } catch (Exception $e) {

            }

            if ($type == 'sale') {
                try {
                    $orderProduct = Shop::Get()->getShopService()->getOrderProductById($s->getOrderproductid());
                    $b['orderprice'] = $orderProduct->getProductprice();
                    $b['ordercurrencyid'] = $orderProduct->getCurrencyid();
                    $b['ordercurrency'] = $orderProduct->getCurrency()->getSymbol();
                } catch (Exception $e) {

                }
            }

            $a[] = $b;
        }

        $info['products'] = $a;

        // сохранение xml в файл
        $xml = XML_Creator::CreateFromArray(array('transfer' => $info));

        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/export/storage/'.$type.'s/'.
            str_replace(array(' ', '-', ':'), '', $date).$user->getId().'.xml',
            $xml->__toString(),
            LOCK_EX
        );
    }

    /**
     * Выгрузить редактирование в XML
     *
     * @param User $user
     * @param ShopStorage $storageOld
     * @param ShopStorage $storageNew
     */
    private function _editXML(User $user, ShopStorage $storageOld, ShopStorage $storageNew) {
        PackageLoader::Get()->import('XML');

        $date = date('Y-m-d H:i:s');

        $info = array();
        $info['edit'] = 1;
        $info['edituserid'] = $user->getId();
        $info['editusername'] = $user->getName();
        $info['editdatetime'] = $date;

        $info['transactionid'] = $storageNew->getTransactionid();
        $info['transactiontype'] = $storageNew->getType();
        $info['storageid'] = $storageNew->getId();
        $info['userid'] = $storageNew->getUserid();
        $info['username'] = $storageNew->getUser()->getName();
        $info['datetime'] = $storageNew->getCdate();

        $info['productid'] = $storageNew->getProductid();

        try {
            $info['code1c'] = $storageNew->getProduct()->getCode1c();
        } catch (Exception $e) {
            $info['code1c'] = '';
        }

        try {
            $info['productname'] = $storageNew->getProduct()->getName();
        } catch (Exception $e) {

        }

        $info['serial'] = $storageNew->getSerial();

        $info['amountold'] = $storageOld->getAmount();
        $info['amountnew'] = $storageNew->getAmount();

        $info['priceold'] = $storageOld->getPrice();
        $info['pricenew'] = $storageNew->getPrice();

        $info['pricebaseold'] = $storageOld->getPricebase();
        $info['pricebasenew'] = $storageNew->getPricebase();

        $info['currencyid'] = $storageNew->getCurrencyid();
        $info['taxrate'] = $storageNew->getTaxrate();
        $info['currencybaseid'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
        $info['currencybase'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol();

        try {
            $info['currency'] = $storageNew->getCurrency()->getSymbol();
        } catch (Exception $e) {

        }

        $info['currencyrateold'] = $storageOld->getCurrencyrate();
        $info['currencyratenew'] = $storageNew->getCurrencyrate();

        $info['storagenamefromid'] = $storageNew->getStoragenamefromid();
        $info['storagenametoid'] = $storageNew->getStoragenametoid();

        try {
            $info['storagenamefromname'] = $storageNew->getStoragenamefrom()->getName();
            $info['storagenametoname'] = $storageNew->getStoragenameto()->getName();
        } catch (Exception $e) {

        }

        // сохранение xml в файл
        $xml = XML_Creator::CreateFromArray(array('transfer' => $info));

        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/1c/storage/edits/'.
            str_replace(array(' ', '-', ':'), '', $date).$user->getId().'.xml',
            $xml->__toString(),
            LOCK_EX
        );
    }

    /**
     * Выгрузить удаление в XML
     *
     * @param User $user
     * @param ShopStorage $storage
     */
    private function _deleteXML(User $user, ShopStorage $storage) {
        PackageLoader::Get()->import('XML');

        $date = date('Y-m-d H:i:s');

        $info = array();
        $info['delete'] = 1;
        $info['deleteuserid'] = $user->getId();
        $info['deleteusername'] = $user->getName();
        $info['deletedatetime'] = $date;

        $info['transactionid'] = $storage->getTransactionid();
        $info['transactiontype'] = $storage->getType();
        $info['storageid'] = $storage->getId();
        $info['userid'] = $storage->getUserid();
        $info['username'] = $storage->getUser()->getName();
        $info['datetime'] = $storage->getCdate();

        $info['productid'] = $storage->getProductid();

        try {
            $info['code1c'] = $storage->getProduct()->getCode1c();
        } catch (Exception $e) {
            $info['code1c'] = '';
        }

        try {
            $info['productname'] = $storage->getProduct()->getName();
        } catch (Exception $e) {

        }

        $info['serial'] = $storage->getSerial();
        $info['amount'] = $storage->getAmount();
        $info['price'] = $storage->getPrice();
        $info['pricebase'] = $storage->getPricebase();
        $info['currencyid'] = $storage->getCurrencyid();
        $info['taxrate'] = $storage->getTaxrate();
        $info['currencybaseid'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
        $info['currencybase'] = Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol();

        try {
            $info['currency'] = $storage->getCurrency()->getSymbol();
        } catch (Exception $e) {

        }

        $info['currencyrate'] = $storage->getCurrencyrate();

        $info['storagenamefromid'] = $storage->getStoragenamefromid();
        $info['storagenametoid'] = $storage->getStoragenametoid();

        try {
            $info['storagenamefromname'] = $storage->getStoragenamefrom()->getName();
            $info['storagenametoname'] = $storage->getStoragenameto()->getName();
        } catch (Exception $e) {

        }

        // сохранение xml в файл
        $xml = XML_Creator::CreateFromArray(array('transfer' => $info));

        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/export/storage/edits/'.
            str_replace(array(' ', '-', ':'), '', $date).$user->getId().'_'.$storage->getId().'.xml',
            $xml->__toString(),
            LOCK_EX
        );
    }

    /**
     * Получить класс
     *
     * @return StorageService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private static $_Instance = null;

}