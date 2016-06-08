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
class StorageProductionService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return ShopStorageBasket
     */
    public function getProductionByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageBasket');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Production by id not found');
    }

    /**
     * Получить записи из текущей корзины производства пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getProductionsByUser(User $cuser) {
        return StorageService::Get()->getStorageBasketsByUser($cuser, 'production');
    }

    /**
     * Получить запись из текущей корзины перемещений пользователя
     *
     * @param User $cuser
     * @return ShopStorageBasket
     */
    public function getProductionCurrentByUser(User $cuser) {
        $production = $this->getProductionsByUser($cuser);
        if ($t = $production->getNext()) {
            return $t;
        }
        throw new ServiceUtils_Exception('No current production');
    }

    /**
     * Очистить корзину перемещений
     *
     * @param User $user
     */
    public function clearProductions(User $user) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getProductionsByUser($user);
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
     * Добавить товар в корзину производства
     *
     * @param User $cuser
     * @param int $storageNameID
     * @param int $passportID
     * @param int $productID
     * @param float $count
     * @param bool $isTarget
     * @param int $storageOrderProductID
     * @return ShopStorageBasket
     */
    public function addProduction(User $cuser, $storageNameID, $passportID, $productID, $count,
    $isTarget, $storageOrderProductID = false) {
        try {
            SQLObject::TransactionStart();

            // получение склада
            try {
                $productions = $this->getProductionsByUser($cuser);
                if ($production = $productions->getNext()) {
                    $storageNameID = $production->getStoragenamefromid();
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

            $production = new ShopStorageBasket();
            $production->setType('production');
            $production->setPassportid($passportID);
            $production->setUserid($cuser->getId());
            $production->setProductid($product->getId());
            $production->setStoragenamefromid($storageName->getId());
            $production->setStorageorderproductid($storageOrderProductID);
            $production->setStorageordersync(0);
            $production->setIstarget($isTarget);
            if ($production->select()) {
                if ($storageOrderProductID) {
                    throw new ServiceUtils_Exception();
                }
                $production->setAmount($count + $production->getAmount());
                $production->update();
            } else {
                $production->setAmount($count);
                $production->insert();
            }

            SQLObject::TransactionCommit();

            return $production;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить в корзину производства товары по паспорту
     *
     * @param User $cuser
     * @param int $storageNameID
     * @param int $passportID
     * @param int $amount
     * @param int $storageOrderProductID
     */
    public function addPassportToProduction(User $cuser, $storageNameID, $passportID, $amount,
    $storageOrderProductID = false) {
        try {
            SQLObject::TransactionStart();

            // получение паспорта
            try {
                $passport = $this->getProductPassportByID($passportID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('passport');
            }

            if (!$passport->getValid()) {
                throw new ServiceUtils_Exception('passportNotValid');
            }

            $amount = (int) trim($amount);

            if ($amount <= 0) {
                throw new ServiceUtils_Exception('count');
            }

            $items = $passport->getItems();
            while ($item = $items->getNext()) {
                $this->addProduction(
                $cuser,
                $storageNameID,
                $passport->getId(),
                $item->getProductid(),
                $item->getAmount() * $amount,
                $item->getIstarget(),
                $storageOrderProductID
                );
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить в корзину производства все товары заказа
     *
     * @param User $cuser
     * @param ShopStorageOrder $order
     */
    public function addOrderProductsToProduction(User $cuser, ShopStorageOrder $order) {
        try {
            SQLObject::TransactionStart();

            $storageName = false;
            try {
                $storageName = $order->getStorageNameFrom();
            } catch (ServiceUtils_Exception $se) {
                throw new ServiceUtils_Exception('storagename');
            }

            $productLeftIDArray = array();
            $passportArray = array();

            $orderProducts = StorageOrderService::Get()->getStorageOrderProductsNotShipped($order);

            // ищем паспорта для всех товаров заказа
            while ($op = $orderProducts->getNext()) {
                $product = $op->getProduct();
                $amount = $op->getAmount();

                while ($amount > 0) {
                    // проверка в "оставшихся" товарах
                    if (isset($productLeftIDArray[$product->getId()]) && $productLeftIDArray[$product->getId()] > 0) {
                        // данный товар уже есть в тех паспортах,
                        // которые были выбраны ранее
                        $amount = $amount - $productLeftIDArray[$product->getId()];
                        $productLeftIDArray[$product->getId()] = $productLeftIDArray[$product->getId()] - $amount;
                        continue;
                    }

                    // ищем подходящие товары-цели в паспортах
                    $passportItems = $this->getProductPassportItemsAll();
                    $passportItems->setProductid($product->getId());
                    $passportItems->setIstarget(1);
                    $p = new ShopProductPassport();
                    $passportItems->leftJoinTable($p->getTablename(), 'passportid='.$p->getTablename().'.id');
                    $passportItems->addWhereQuery($p->getTablename().'.valid = 1');
                    $passportItems->setOrder('amount', 'DESC');

                    // выбираем товар-цель по количеству,
                    // которое должно максимально совпадать с требуемым
                    $tmp = false;
                    $min = 0;
                    while ($pi = $passportItems->getNext()) {
                        if (!$tmp) {
                            $tmp = clone $pi;
                            $min = abs($pi->getAmount() - $amount);
                        } else {
                            if (abs($pi->getAmount() - $amount) < $min) {
                                $min = abs($pi->getAmount() - $amount);
                                $tmp = clone $pi;
                            }
                        }

                    }

                    // если ничего не выбрано - ошибка
                    if (!$tmp) {
                        throw new ServiceUtils_Exception($product->getId().':nopassport');
                    }

                    // количество паспортов, которое необходимо
                    $passportAmount = floor($amount / $tmp->getAmount());
                    if ($passportAmount < 1) {
                        $passportAmount = 1;
                    }

                    // сохраняем паспорт выбранного товара в массив
                    $passport = $tmp->getPassport();
                    if (isset($passportArray[$passport->getId()])) {
                        $passportArray[$passport->getId()]['amount'] = $passportArray[$passport->getId()]['amount'] + $passportAmount;
                    } else {
                        $passportArray[$passport->getId()] = array(
                        'amount' => $passportAmount,
                        'orderproductID' => $op->getId()
                        );
                    }

                    // смотрим все товары паспорта
                    $passportItems = $passport->getItems();
                    while ($pi = $passportItems->getNext()) {
                        if ($pi->getProductid() == $product->getId()) {
                            // если это нужный товар
                            // смотрим количество
                            $amount = $amount - ($pi->getAmount() * $passportAmount);
                        } else {
                            // ненужный товар сохраняем на всякий случай в массив
                            if (isset($productLeftIDArray[$pi->getProductid()])) {
                                $productLeftIDArray[$pi->getProductid()] = $productLeftIDArray[$pi->getProductid()] + ($pi->getAmount() * $passportAmount);
                            } else {
                                $productLeftIDArray[$pi->getProductid()] = $pi->getAmount() * $passportAmount;
                            }
                        }
                    }

                }
            }

            // добавляем паспорта в корзину производства
            foreach ($passportArray as $passportID => $passport) {
                $this->addPassportToProduction(
                $cuser,
                $storageName->getId(),
                $passportID,
                $passport['amount'],
                $passport['orderproductID']
                );
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Провести производство
     *
     * @param User $cuser
     * @param int $storageToID
     * @param string $date
     * @return int
     */
    public function processProduction(User $cuser, $storageToID, $date) {
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

            // получение товаров для производства
            $productions = $this->getProductionsByUser($cuser);

            // проверка товаров
            $test = clone $productions;
            if (!$production = $test->getNext()) {
                throw new ServiceUtils_Exception();
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed(
            $cuser,
            $production->getStorageName(),
            'transferfrom')
            ) {
                throw new ServiceUtils_Exception('user');
            }

            if (!StorageNameService::Get()->isStorageOperationAllowed(
            $cuser,
            $storageTo,
            'transferto')
            ) {
                throw new ServiceUtils_Exception('user');
            }

            // получение склада для производства
            $storageProduction = StorageNameService::Get()->getStorageNameProduction();

            // системная валюта
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $storageID = false;

            // создаем транзакцию
            $transaction = StorageService::Get()->addStorageTransaction(
            $cuser,
            'production',
            $date,
            $production->getStorageName(),
            $storageTo,
            false,
            false
            );

            $amount_total = 0;
            $cost_total = 0;

            $materials = clone $productions;
            $materials->setIstarget(0);

            $sumArray = array();

            // перемещаем все товары-материалы на склад "производство"
            while ($x = $materials->getNext()) {

                try {
                    // проверяем товар
                    $product = $x->getProduct();

                    // проверяем склад from
                    $storageFrom = $x->getStorageName();
                } catch (ServiceUtils_Exception $ee) {

                    $x->delete();
                    continue;
                }

                // проверка совпадения склада в перемещениях
                if ($storageFrom->getId() != $production->getStoragenamefromid()) {
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
                    $storage->setStoragenametoid($storageProduction->getId());
                    $storage->setAmount($linkedAmount);
                    $storage->setUserid($cuser->getId());
                    $storage->setType('production');
                    $storage->insert();

                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();

                    $storageID = $storage->getId();

                    if (isset($sumArray[$x->getPassportid()][$x->getStorageorderproductid()])) {
                        $sumArray[$x->getPassportid()][$x->getStorageorderproductid()] += $storage->getPricebase() * $linkedAmount;
                    } else {
                        $sumArray[$x->getPassportid()][$x->getStorageorderproductid()] = $storage->getPricebase() * $linkedAmount;
                    }

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageProduction->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $linkedAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $linkedAmount;
                }

                // если товар не был привязан
                // смотрим остатки на складе
                $balances = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                $cuser,
                $storageFrom,
                $product
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
                    $storage->setStoragenametoid($storageProduction->getId());
                    $storage->setAmount($balanceAmount);
                    $storage->setUserid($cuser->getId());
                    $storage->setType('production');
                    $storage->insert();
                    
                    $amount_total += $storage->getAmount();
                    $cost_total += $storage->getPricebase() * $storage->getAmount();

                    $storageID = $storage->getId();
                    if (isset($sumArray[$x->getPassportid()][$x->getStorageorderproductid()])) {
                        $sumArray[$x->getPassportid()][$x->getStorageorderproductid()] += $storage->getPricebase() * $balanceAmount;
                    } else {
                        $sumArray[$x->getPassportid()][$x->getStorageorderproductid()] = $storage->getPricebase() * $balanceAmount;
                    }

                    $storage->setId(false);
                    $storage->setStoragenamefromid($storageProduction->getId());
                    $storage->setStoragenametoid($balance->getStoragenameid());
                    $storage->setAmount((-1) * $balanceAmount);
                    $storage->insert();

                    // пересчет количества
                    $amount = $amount - $balanceAmount;
                }

                if ($amount > 0) {

                    // если товара на складе не хватило
                    $ex->addError($x->getId().':lack');
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
                $storageProduction,
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

            $productions->setIstarget(1);

            $k = 0;

            // перемещаем все товары-цели со склада "производство"
            while ($x = $productions->getNext()) {
                $k++;

                try {
                    // проверяем товар
                    $product = $x->getProduct();
                } catch (ServiceUtils_Exception $ee) {
                    $x->delete();
                    continue;
                }

                // какое количество товара всего надо переместить
                $amount = $x->getAmount();
                $price = $sumArray[$x->getPassportid()][$x->getStorageorderproductid()] / $amount;

                // со склада производста волшебным способом перемещается "целевой" товар
                $storage = new ShopStorage();
                $storage->setTransactionid($transaction->getId());
                $storage->setCdate($transaction->getCdate());
                $storage->setDate($transaction->getCdate());
                $storage->setStoragenamefromid($storageProduction->getId());
                $storage->setStoragenametoid($storageTo->getId());
                $storage->setProductid($x->getProductid());
                $storage->setAmount($amount);
                $storage->setUserid($cuser->getId());
                $storage->setCode(md5($storage->getCdate().$cuser->getId().$x->getProductid().$k));
                $storage->setType('production');
                $storage->setPrice($price);
                $storage->setPricebase($price);
                $storage->setCurrencyid($currencySystem->getId());
                $storage->insert();

                $storageID = $storage->getId();

                $storage->setId(false);
                $storage->setStoragenamefromid($storageTo->getId());
                $storage->setStoragenametoid($storageProduction->getId());
                $storage->setAmount((-1) * $amount);
                $storage->insert();

                // обновляем записи баланса
                StorageBalanceService::Get()->updateBalance(
                $storageTo,
                $product
                );

                StorageBalanceService::Get()->updateBalance(
                $storageProduction,
                $product
                );

                // если был заказ поставщику, помечаем его как отгруженный
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
                        $production->getStorageName(),
                        $storageTo,
                        false // no sync
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
     * @return ShopProductPassport
     */
    public function getProductPassportsAll() {
        return $this->getObjectsAll('ShopProductPassport');
    }

    /**
     * @return ShopProductPassport
     */
    public function getProductPassportsValid() {
        $x = $this->getProductPassportsAll();
        $x->setValid(1);
        return $x;
    }

    /**
     * @return ShopProductPassport
     * @param int $id
     */
    public function getProductPassportByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProductPassport');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Добавить паспорт
     * 
     * @return ShopProductPassport
     */
    public function addProductPassport() {
        try {
            SQLObject::TransactionStart();

            $x = new ShopProductPassport();
            $x->insert();

            SQLObject::TransactionCommit();

            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Редактировать паспорт
     * 
     * @param ShopProductPassport $passport
     * @param string $name
     */
    public function updateProductPassport(ShopProductPassport $passport, $name) {
        try {
            SQLObject::TransactionStart();

            $passport->setName($name);
            $passport->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить паспорт
     * 
     * @param ShopProductPassport $passport
     */
    public function deleteProductPassport(ShopProductPassport $passport) {
        try {
            SQLObject::TransactionStart();

            $items = $passport->getItems();
            while ($item = $items->getNext()) {
                $item->delete();
            }

            $passport->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Проверить паспорт на правильность
     *
     * @param ShopProductPassport $passport
     */
    public function updateProductPassportValid(ShopProductPassport $passport) {
        try {
            SQLObject::TransactionStart();

            $valid = true;

            $items = $passport->getItems();
            $items->setIstarget(1);
            if (!$items->getNext()) {
                $valid = false;
            }

            $items = $passport->getItems();
            $items->setIstarget(0);
            if (!$items->getNext()) {
                $valid = false;
            }

            if ($passport->getValid() != $valid) {
                $passport->setValid($valid);
                $passport->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return ShopProductPassportItem
     */
    public function getProductPassportItemsAll() {
        return $this->getObjectsAll('ShopProductPassportItem');
    }

    /**
     * Получить товары паспорта
     *
     * @param ShopProductPassport $passport
     * @return ShopProductPassportItem
     */
    public function getProductPassportItemsByPassport(ShopProductPassport $passport) {
        $x = $this->getProductPassportItemsAll();
        $x->setPassportid($passport->getId());
        return $x;
    }

    /**
     * Получить товары-цели паспорта
     *
     * @param ShopProductPassport $passport
     * @return ShopProductPassportItem
     */
    public function getProductPassportItemsTargetByPassport(ShopProductPassport $passport) {
        $x = $this->getProductPassportItemsByPassport($passport);
        $x->setIstarget(1);
        return $x;
    }

    /**
     * Получить товары-материалы паспорта
     *
     * @param ShopProductPassport $passport
     * @return ShopProductPassportItem
     */
    public function getProductPassportItemsMaterialByPassport(ShopProductPassport $passport) {
        $x = $this->getProductPassportItemsAll();
        $x->setPassportid($passport->getId());
        $x->setIstarget(false);
        return $x;
    }

    /**
     * @return ShopProductPassportItem
     * @param int $id
     */
    public function getProductPassportItemByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProductPassportItem');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Добавить товар в паспорт
     *
     * @param ShopProductPassport $passport
     * @param int $productID
     * @param float $amount
     * @param bool $isTarget
     * @return ShopProductPassportItem
     */
    public function addProductPassportItem(ShopProductPassport $passport, $productID, $amount,
    $isTarget) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $amount = str_replace(',', '.', $amount);
            $amount = (float) $amount;

            if ($amount <= 0) {
                $ex->addError('amount');
            }

            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);

                $test = $passport->getItems();
                $test->setProductid($productID);
                if ($test->getNext()) {
                    $ex->addError('productExists');
                }
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('product');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $item = new ShopProductPassportItem();
            $item->setProductid($productID);
            $item->setAmount($amount);
            $item->setPassportid($passport->getId());
            $item->setIstarget($isTarget);
            $item->insert();

            $this->updateProductPassportValid($passport);

            SQLObject::TransactionCommit();

            return $item;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Редактировать количество товара в паспорте
     *
     * @param ShopProductPassportItem $item
     * @param float $amount
     * @return ShopProductPassportItem
     */
    public function updateProductPassportItem(ShopProductPassportItem $item, $amount) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $amount = str_replace(',', '.', $amount);
            $amount = (float) $amount;

            if ($amount <= 0) {
                $ex->addError('amount');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $item->setAmount($amount);
            $item->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар из паспорта
     *
     * @param ShopProductPassportItem $item
     */
    public function deleteProductPassportItem(ShopProductPassportItem $item) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $passport = $item->getPassport();

            $item->delete();

            $this->updateProductPassportValid($passport);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Поиск паспортов
     *
     * @param string $query
     * @return ShopProductPassport
     */
    public function searchPassports($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $passports = $this->getProductPassportsAll();
        $connection = $passports->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        $passports->setValid(1);

        foreach ($a as $part) {
            $w = array();
            $orderBy = array();

            if (is_numeric($part)) {
                $w[] = $passports->getTablename().".id = '$part'";
            }

            $w[] = $passports->getTablename().".name LIKE '%$part%'";
            $orderBy[] = "(CASE WHEN {$passports->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);
                $partTr = $connection->escapeString($partTr);

                $w[] = $passports->getTablename().".name LIKE '%$partTr%'";
                $orderBy[] = "(CASE WHEN {$passports->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);
                $partRu = $connection->escapeString($partRu);

                $w[] = $passports->getTablename().".name LIKE '%$partRu%'";
                $orderBy[] = "(CASE WHEN {$passports->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);
                $partEn = $connection->escapeString($partEn);

                $w[] = $passports->getTablename().".name LIKE '%$partEn%'";
                $orderBy[] = "(CASE WHEN {$passports->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            $passports->addWhereQuery("(".implode(' OR ', $w).")");
        }

        $passports->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $passports->setOrder('`relevance`', 'DESC');

        return $passports;
    }

    /**
     * @return StorageProductionService
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