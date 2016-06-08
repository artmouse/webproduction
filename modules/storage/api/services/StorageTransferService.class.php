<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class StorageTransferService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return ShopStorageBasket
     */
    public function getTransferByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageBasket');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Transfer by id not found');
    }

    /**
     * Получить записи из текущей корзины перемещений пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getTransfersByUser(User $cuser) {
        return StorageService::Get()->getStorageBasketsByUser($cuser, 'transfer');
    }

    /**
     * Получить запись из текущей корзины перемещений пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getTransferCurrentByUser(User $cuser) {
        $transfer = $this->getTransfersByUser($cuser);
        if ($t = $transfer->getNext()) {
            return $t;
        }
        throw new ServiceUtils_Exception('No current transfer');
    }

    /**
     * Очистить корзину перемещений
     *
     * @param User $user
     */
    public function clearTransfers(User $user) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getTransfersByUser($user);
            while ($y = $x->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($y, $user);

                $y->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в "перемещение между складами"
     *
     * @param User $user
     * @param ShopProduct $product
     * @param int $serial
     * @param float $count
     * @param ShopStorageName $storageName
     * @return ShopStorageBasket
     */
    public function addTransfer(User $cuser, $storageNameID, $productID, $serial,
    $count, $storageOrderProductID = false) {
        try {
            SQLObject::TransactionStart();

            // получение склада
            try {
                $transfers = $this->getTransfersByUser($cuser);
                if ($transfer = $transfers->getNext()) {
                    $storageNameID = $transfer->getStoragenamefromid();
                }

                $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('storagefrom');
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'transferfrom')) {
                throw new ServiceUtils_Exception('user');
            }

            // получение товара
            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('product');
            }

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count <= 0) {
                throw new ServiceUtils_Exception('count');
            }

            if (!$product->testDivisibility($count)) {
                throw new ServiceUtils_Exception('divisibility');
            }

            if ($count > 1 && $serial) {
                throw new ServiceUtils_Exception('serial');
            }

            // есть ли уже такой товар в накладной
            $sum_count = $count;
            $transfer = $this->getTransfersByUser($cuser);
            $transfer->setProductid($product->getId());
            $transfer->setStoragenamefromid($storageName->getId());
            if ($serial) {
                $transfer->setSerial($serial);
            }
            if ($transfer->select() && !$storageOrderProductID) {
                $sum_count += $transfer->getAmount();
                $transfer->setAmount($sum_count);
                $transfer->update();
            } else {
                $transfer = new ShopStorageBasket();
                $transfer->setType('transfer');
                $transfer->setUserid($cuser->getId());
                $transfer->setProductid($product->getId());
                $transfer->setAmount($count);
                $transfer->setStoragenamefromid($storageName->getId());
                $transfer->setStorageorderproductid($storageOrderProductID);
                $transfer->setStorageordersync(1);
                $transfer->insert();
            }
            SQLObject::TransactionCommit();

            return $transfer;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в корзине
     *
     * @throws ServiceUtils_Exception
     *
     * @param ShopStorageBasket $transfer
     * @param User $cuser
     * @param float $amount
     * @return ShopStorageBasket
     */
    public function updateTransfer(ShopStorageBasket $transfer, User $cuser, $amount, $sync) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if ($transfer->getUserid() != $cuser->getId()) {
                $ex->addError('permission');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            if (!$transfer->getProduct()->testDivisibility($amount)) {
                $ex->addError('divisibility');
            }

            if ($amount > 1 && $transfer->getSerial()) {
                $ex->addError('serial');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $amountOld = $transfer->getAmount();

            $transfer->setAmount($amount);
            $transfer->setStorageordersync($sync);
            $transfer->update();

            if ($amount != $amountOld) {
                StorageLinkService::Get()->deleteBasketLinks($transfer, $cuser);
            }

            SQLObject::TransactionCommit();

            return $transfer;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Удалить товар из накладной
     *
     * @param ShopStorageBasket $transfer
     * @param User $cuser
     * @throws ServiceUtils_Exception
     */
    public function deleteTransfer(ShopStorageBasket $transfer, User $cuser) {
        try {
            SQLObject::TransactionStart();

            if ($transfer->getUserid() != $cuser->getId()) {
                throw new ServiceUtils_Exception('Access denied');
            }

            StorageLinkService::Get()->deleteBasketLinks($transfer, $cuser);
            $transfer->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Провести перемещение
     *
     * @param User $cuser
     * @param int $storageToID
     * @param string $request
     * @param boolean $return
     * @param string $date
     * @return int
     */
    public function processTransfer(User $cuser, $storageToID, $request, $return, $date) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $date = DateTime_Corrector::CorrectDateTime($date);

            // проверка склада to
            try {
                $storageTo = StorageNameService::Get()->getStorageNameByID($storageToID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('storageto');
            }

            // получение товаров для перемещения
            $transfers = $this->getTransfersByUser($cuser);

            // проверка перемещения
            $transfer_test = clone $transfers;
            if (!$transfer = $transfer_test->getNext()) {
                throw new ServiceUtils_Exception();
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed(
            $cuser,
            $transfer->getStorageName(),
            'transferfrom')
            ) {
                throw new ServiceUtils_Exception('user');
            }

            if ($return) {
                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $storageTo,
                'returnto')
                ) {
                    throw new ServiceUtils_Exception('user');
                }
            } else {
                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $storageTo,
                'transferto')
                ) {
                    throw new ServiceUtils_Exception('user');
                }
            }

            // системная валюта
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $storageID = false;

            // создаем транзакцию
            $transaction = StorageService::Get()->addStorageTransaction(
            $cuser,
            'transfer',
            $date,
            $transfer->getStorageName(),
            $storageTo,
            $return,
            false
            );

            $amount_total = 0;
            $cost_total = 0;

            while ($x = $transfers->getNext()) {
                try {
                    // проверяем товар
                    $product = $x->getProduct();

                    // проверяем склад from
                    $storageFrom = $x->getStorageName();
                } catch (ServiceUtils_Exception $ee) {

                    $x->delete();
                    continue;
                }

                if ($storageFrom->getId() == $storageToID) {
                    $x->delete();
                    continue;
                }

                // проверка совпадения склада в перемещениях
                if ($storageFrom->getId() != $transfer->getStoragenamefromid()) {
                    throw new ServiceUtils_Exception();
                }

                // какое количество товара всего надо переместить
                $amount = $x->getAmount();

                // сначала смотрим привязки
                $links = StorageLinkService::Get()->getLinksByBasket($x);
                while ($link = $links->getNext()) {
                    if ($amount <= 0) {
                        break;
                    }

                    $balance = $link->getBalance();

                    // проверка совпадения товара и склада
                    if ($balance->getProductid() != $x->getProductid() ||
                    $balance->getStoragenameid() != $x->getStoragenamefromid()) {
                        StorageLinkService::Get()->deleteLink(
                        $link,
                        $cuser
                        );
                        continue;
                    }

                    // поправляем количество (если привязано больше чем надо)
                    $linkedAmount = $link->getAmount();
                    if ($linkedAmount > $amount) {
                        $linkedAmount = $amount;
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
                    $storage->setTransactionid($transaction->getId());
                    $storage->setCdate($transaction->getCdate());
                    $storage->setDate($transaction->getDate());
                    $storage->setStoragenamefromid($balance->getStoragenameid());
                    $storage->setStoragenametoid($storageTo->getId());
                    $storage->setAmount($linkedAmount);
                    $storage->setUserid($cuser->getId());
                    if ($return) $storage->setReturn(1);
                    $storage->setRequest($request);
                    $storage->setType('transfer');
                    $storage->setStorageorderproductid($x->getStorageorderproductid());
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();


                    $storageID = $storage->getId();

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageTo->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $linkedAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $linkedAmount;
                }

                // если не товар не был привязан
                // смотрим остатки на складе
                $balances = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                $cuser,
                $storageFrom,
                $product,
                false,
                $x->getSerial()
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
                    $storage->setTransactionid($transaction->getId());
                    $storage->setCdate($transaction->getCdate());
                    $storage->setDate($transaction->getDate());
                    $storage->setStoragenamefromid($balance->getStoragenameid());
                    $storage->setStoragenametoid($storageTo->getId());
                    $storage->setAmount($balanceAmount);
                    $storage->setUserid($cuser->getId());
                    if ($return) $storage->setReturn(1);
                    $storage->setRequest($request);
                    $storage->setType('transfer');
                    $storage->setStorageorderproductid($x->getStorageorderproductid());
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();


                    $storageID = $storage->getId();

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageTo->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $balanceAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $balanceAmount;
                }

                if ($amount > 0) {
                    // если товара на складе не хватило
                    $ex->addError($x->getId().':lack');
                    continue;
                }

                // удаляем все привязки
                StorageLinkService::Get()->deleteBasketLinks(
                $x,
                $cuser
                );

                // обновляем записи баланса
                StorageBalanceService::Get()->updateBalance(
                $storageFrom,
                $product
                );

                StorageBalanceService::Get()->updateBalance(
                $storageTo,
                $product
                );

                // если был заказ, помечаем его как отгруженный
                $orderProduct = false;

                try {
                    $orderProduct = $x->getStorageOrderProduct();
                } catch (ServiceUtils_Exception $sope) {}

                if ($orderProduct) {
                    try {
                        StorageOrderService::Get()->shipOrderProduct(
                        $x->getStorageOrderProduct(),
                        $cuser,
                        $transaction,
                        $x->getAmount(),
                        false,
                        false,
                        false,
                        $storageFrom->getId(),
                        $storageTo->getId(),
                        $x->getStorageordersync()
                        );

                    } catch (ServiceUtils_Exception $e) {
                        $errorArray = $e->getErrorsArray();
                        foreach ($errorArray as $error) {
                            $ex->addError($x->getId().':'.$error);
                        }
                    }
                }

                // удаляем строку из накладной
                $x->delete();
            }

            $transaction->setAmount($amount_total);
            $transaction->setCost($cost_total);
            $transaction->update();

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();

            // запись в XML после успешной транзакции!
            StorageService::Get()->transferXML($cuser, $transaction->getCdate());

            return $transaction->getId();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить записи из текущей корзины перемещений пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getOutcomingsByUser(User $cuser) {
        return StorageService::Get()->getStorageBasketsByUser($cuser, 'outcoming');
    }

    /**
     * Получить запись из текущей корзины перемещений пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getOutcomingCurrentByUser(User $cuser) {
        $outcoming = $this->getOutcomingsByUser($cuser);
        if ($t = $outcoming->getNext()) {
            return $t;
        }
        throw new ServiceUtils_Exception('No current outcoming');
    }

    /**
     * Очистить корзину перемещений
     *
     * @param User $user
     */
    public function clearOutcomings(User $user) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getOutcomingsByUser($user);
            while ($y = $x->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($y, $user);

                $y->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в "корзину списания"
     *
     * @param User $user
     * @param ShopProduct $product
     * @param int $serial
     * @param float $count
     * @param ShopStorageName $storageName
     * @return ShopStorageBasket
     */
    public function addOutcoming(User $cuser, $storageNameID, $productID, $serial, $count) {
        try {
            SQLObject::TransactionStart();

            // получение склада
            try {
                $outcomings = $this->getOutcomingsByUser($cuser);
                if ($outcoming = $outcomings->getNext()) {
                    $storageNameID = $outcoming->getStoragenamefromid();
                }

                $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('storagefrom');
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'transferfrom')) {
                throw new ServiceUtils_Exception('user');
            }

            // получение товара
            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('product');
            }

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count <= 0) {
                throw new ServiceUtils_Exception('count');
            }

            if (!$product->testDivisibility($count)) {
                throw new ServiceUtils_Exception('divisibility');
            }

            if ($count > 1 && $serial) {
                throw new ServiceUtils_Exception('serial');
            }

            // есть ли уже такой товар в накладной
            $sum_count = $count;
            $outcoming = $this->getOutcomingsByUser($cuser);
            $outcoming->setProductid($product->getId());
            $outcoming->setStoragenamefromid($storageName->getId());
            if ($serial) {
                $outcoming->setSerial($serial);
            }
            if ($outcoming->select()) {
                $sum_count += $outcoming->getAmount();
                $outcoming->setAmount($sum_count);
                $outcoming->update();
            } else {
                $outcoming = new ShopStorageBasket();
                $outcoming->setType('outcoming');
                $outcoming->setUserid($cuser->getId());
                $outcoming->setProductid($product->getId());
                $outcoming->setAmount($count);
                $outcoming->setStoragenamefromid($storageName->getId());
                $outcoming->insert();
            }
            SQLObject::TransactionCommit();

            return $outcoming;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в корзине
     *
     * @throws ServiceUtils_Exception
     *
     * @param ShopStorageBasket $outcoming
     * @param User $cuser
     * @param float $amount
     * @return ShopStorageBasket
     */
    public function updateOutcoming(ShopStorageBasket $outcoming, User $cuser, $amount) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if ($outcoming->getUserid() != $cuser->getId()) {
                $ex->addError('permission');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            if (!$outcoming->getProduct()->testDivisibility($amount)) {
                $ex->addError('divisibility');
            }

            if ($amount > 1 && $outcoming->getSerial()) {
                $ex->addError('serial');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $amountOld = $outcoming->getAmount();

            $outcoming->setAmount($amount);
            $outcoming->update();

            if ($amount != $amountOld) {
                StorageLinkService::Get()->deleteBasketLinks($outcoming, $cuser);
            }

            SQLObject::TransactionCommit();

            return $outcoming;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Удалить товар из накладной
     *
     * @param ShopStorageBasket $outcoming
     * @param User $cuser
     * @throws ServiceUtils_Exception
     */
    public function deleteOutcoming(ShopStorageBasket $outcoming, User $cuser) {
        try {
            SQLObject::TransactionStart();

            if ($outcoming->getUserid() != $cuser->getId()) {
                throw new ServiceUtils_Exception('Access denied');
            }

            StorageLinkService::Get()->deleteBasketLinks($outcoming, $cuser);
            $outcoming->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Списать товар
     *
     * @param User $cuser
     * @param string $date
     * @return int
     */
    public function processOutcoming(User $cuser, $date) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $date = DateTime_Corrector::CorrectDateTime($date);

            // получение товаров для перемещения
            $outcomings = $this->getOutcomingsByUser($cuser);

            // проверка перемещения
            $outcoming_test = clone $outcomings;
            if (!$outcoming = $outcoming_test->getNext()) {
                throw new ServiceUtils_Exception();
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed(
            $cuser,
            $outcoming->getStorageName(),
            'transferfrom')
            ) {
                throw new ServiceUtils_Exception('user');
            }

            // склад "расход"
            $storageTo = StorageNameService::Get()->getStorageNameOutcoming();
            $storageToID = $storageTo->getId();

            // системная валюта
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $storageID = false;

            // создаем транзакцию
            $transaction = StorageService::Get()->addStorageTransaction(
            $cuser,
            'outcoming',
            $date,
            $outcoming->getStorageName(),
            $storageTo,
            false,
            false
            );

            $amount_total = 0;
            $cost_total = 0;

            while ($x = $outcomings->getNext()) {
                try {
                    // проверяем товар
                    $product = $x->getProduct();

                    // проверяем склад from
                    $storageFrom = $x->getStorageName();
                } catch (ServiceUtils_Exception $ee) {

                    $x->delete();
                    continue;
                }

                if ($storageFrom->getId() == $storageToID) {
                    $x->delete();
                    continue;
                }

                // проверка совпадения склада в перемещениях
                if ($storageFrom->getId() != $outcoming->getStoragenamefromid()) {
                    throw new ServiceUtils_Exception();
                }

                // какое количество товара всего надо переместить
                $amount = $x->getAmount();

                // сначала смотрим привязки
                $links = StorageLinkService::Get()->getLinksByBasket($x);
                while ($link = $links->getNext()) {
                    if ($amount <= 0) {
                        break;
                    }

                    $balance = $link->getBalance();

                    // проверка совпадения товара и склада
                    if ($balance->getProductid() != $x->getProductid() ||
                    $balance->getStoragenameid() != $x->getStoragenamefromid()) {
                        StorageLinkService::Get()->deleteLink(
                        $link,
                        $cuser
                        );
                        continue;
                    }

                    // поправляем количество (если привязано больше чем надо)
                    $linkedAmount = $link->getAmount();
                    if ($linkedAmount > $amount) {
                        $linkedAmount = $amount;
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
                    $storage->setTransactionid($transaction->getId());
                    $storage->setCdate($transaction->getCdate());
                    $storage->setDate($transaction->getDate());
                    $storage->setStoragenamefromid($balance->getStoragenameid());
                    $storage->setStoragenametoid($storageTo->getId());
                    $storage->setAmount($linkedAmount);
                    $storage->setUserid($cuser->getId());
                    $storage->setType('outcoming');
                    $storage->setStorageorderproductid($x->getStorageorderproductid());
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();


                    $storageID = $storage->getId();

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageTo->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $linkedAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $linkedAmount;
                }

                // если не товар не был привязан
                // смотрим остатки на складе
                $balances = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                $cuser,
                $storageFrom,
                $product,
                false,
                $x->getSerial()
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
                    $storage->setTransactionid($transaction->getId());
                    $storage->setCdate($transaction->getCdate());
                    $storage->setDate($transaction->getDate());
                    $storage->setStoragenamefromid($balance->getStoragenameid());
                    $storage->setStoragenametoid($storageTo->getId());
                    $storage->setAmount($balanceAmount);
                    $storage->setUserid($cuser->getId());
                    $storage->setType('outcoming');
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();


                    $storageID = $storage->getId();

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageTo->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $balanceAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $balanceAmount;
                }

                if ($amount > 0) {
                    // если товара на складе не хватило
                    $ex->addError($x->getId().':lack');
                    continue;
                }

                // удаляем все привязки
                StorageLinkService::Get()->deleteBasketLinks(
                $x,
                $cuser
                );

                // обновляем записи баланса
                StorageBalanceService::Get()->updateBalance(
                $storageFrom,
                $product
                );

                StorageBalanceService::Get()->updateBalance(
                $storageTo,
                $product
                );

                // удаляем строку из накладной
                $x->delete();
            }

            $transaction->setAmount($amount_total);
            $transaction->setCost($cost_total);
            $transaction->update();

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();

            // запись в XML после успешной транзакции!
            StorageService::Get()->transferXML($cuser, $transaction->getCdate());

            return $transaction->getId();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return StorageTransferService
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