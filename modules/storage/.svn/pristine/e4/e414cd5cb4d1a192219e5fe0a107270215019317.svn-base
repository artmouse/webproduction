<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * StorageSaleService
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class StorageSaleService extends ServiceUtils_AbstractService {

    /**
     * Получить склад по id
     *
     * @param int $id
     *
     * @return ShopStorageBasket
     */
    public function getSaleByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageBasket');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Sale by id not found');
    }

    /**
     * Получить записи из текущей корзины продаж пользователя
     *
     * @param User $cuser
     * @param bool $quick
     *
     * @return ShopStorageBasket
     */
    public function getSalesByUser(User $cuser, $quick = false) {
        $x = StorageService::Get()->getStorageBasketsByUser($cuser, 'sale');

        if ($quick) {
            $x->setOrderid(0);
        } else {
            $x->addWhere('orderid', 0, '<>');
        }

        return $x;
    }

    /**
     * Получить запись из текущей корзины продаж пользователя
     *
     * @param User $cuser
     *
     * @return ShopStorageBasket
     */
    public function getSaleCurrentByUser(User $cuser) {
        $transfer = $this->getSalesByUser($cuser);
        if ($t = $transfer->getNext()) {
            return $t;
        }
        throw new ServiceUtils_Exception('No current sale');
    }

    /**
     * Очистить корзину продаж
     *
     * @param User $user
     */
    public function clearSales(User $user) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getSalesByUser($user);
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
     * Добавить товар в "продажу"
     *
     * @param User $cuser
     * @param ShopOrder $order
     * @param int $productID
     * @param float $count
     * @param int $orderProductID
     * @param int $storageNameID
     *
     * @return ShopStorageBasket
     */
    public function addSale(User $cuser, ShopOrder $order, $productID,
    $count, $orderProductID, $storageNameID) {
        try {
            SQLObject::TransactionStart();

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

            try {
                $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);

                // проверка прав пользователя
                if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'salefrom')) {
                    throw new ServiceUtils_Exception('user');
                }
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('storagefrom');
            }

            $sale = new ShopStorageBasket();
            $sale->setType('sale');
            $sale->setUserid($cuser->getId());
            $sale->setProductid($product->getId());
            $sale->setAmount($count);
            $sale->setOrderproductid($orderProductID);
            $sale->setOrderid($order->getId());
            $sale->setStoragenamefromid($storageNameID);
            $sale->insert();

            SQLObject::TransactionCommit();

            return $sale;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в "быструю продажу"
     *
     * @param User $cuser
     * @param int $storageNameID
     * @param int $productID
     * @param float $count
     * @param float $price
     * @param int $currencyID
     *
     * @return ShopStorageBasket
     */
    public function addSaleQuick(User $cuser, $storageNameID, $productID, $count,
    $price, $currencyID) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            // получение склада
            try {
                $sales = $this->getSalesByUser($cuser, true);
                if ($sale = $sales->getNext()) {
                    $storageNameID = $sale->getStoragenamefromid();
                }

                $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);
            } catch (ServiceUtils_Exception $e) {
                $ex->addError('storagefrom');
            }

            // проверка прав пользователя
            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'salefrom')) {
                $ex->addError('user');
            }

            // получение товара
            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);
            } catch (ServiceUtils_Exception $e) {
                $ex->addError('product');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count <= 0) {
                $ex->addError('count');
            }

            if (!$product->testDivisibility($count)) {
                $ex->addError('divisibility');
            }

            $price = str_replace(',', '.', $price);
            $price = (float) trim($price);

            if ($price < 0) {
                $ex->addError('price');
            }

            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $sale = new ShopStorageBasket();
            $sale->setType('sale');
            $sale->setUserid($cuser->getId());
            $sale->setProductid($product->getId());
            $sale->setAmount($count);
            $sale->setStoragenamefromid($storageName->getId());
            $sale->setPrice($price);
            $sale->setCurrencyid($currencyID);
            $sale->insert();

            SQLObject::TransactionCommit();

            return $sale;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в корзине быстрой продажи
     *
     * @param ShopStorageBasket $sale
     * @param User $cuser
     * @param float $amount
     * @param float $price
     * @param int $currencyID
     *
     * @return ShopStorageBasket
     *
     * @throws ServiceUtils_Exception
     */
    public function updateSaleQuick(ShopStorageBasket $sale, User $cuser,
    $amount, $price, $currencyID) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if ($sale->getUserid() != $cuser->getId()) {
                $ex->addError('permission');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            if (!$sale->getProduct()->testDivisibility($amount)) {
                $ex->addError('divisibility');
            }

            $price = str_replace(',', '.', $price);
            $price = (float) trim($price);

            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            if ($price < 0) {
                $ex->addError('price');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $sale->setCurrencyid($currencyID);
            $sale->setPrice($price);
            $sale->setAmount($amount);
            $sale->update();

            SQLObject::TransactionCommit();

            return $sale;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар из корзины быстрой продажи
     *
     * @param ShopStorageBasket $sale
     * @param User $cuser
     *
     * @throws ServiceUtils_Exception
     */
    public function deleteSaleQuick(ShopStorageBasket $sale, User $cuser) {
        try {
            SQLObject::TransactionStart();

            if ($sale->getUserid() != $cuser->getId()) {
                throw new ServiceUtils_Exception('permission');
            }

            $sale->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Провести отгрузку (продажу)
     *
     * @param User $cuser
     * @param string $date
     * @param bool $quick
     * @param int $orderID
     *
     * @return int
     */
    public function processSale(User $cuser, $date, $quick = false, $orderID = false, $storageId = false) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $date = DateTime_Corrector::CorrectDateTime($date);

            // получение товаров для перемещения
            $basketProducts = $this->getSalesByUser($cuser, $quick);

            $basket_test = clone $basketProducts;
            $basket_test = $basket_test->getNext();

            if (!$basket_test) {
                throw new ServiceUtils_Exception();
            }

            if ($quick) {
                // это быстрый заказ
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);

            } elseif ($orderID) {

                // это автоматическая отгрузка со склада
                $order = Shop::Get()->getShopService()->getOrderByID($orderID);
                $basketProducts->setOrderid($orderID);

            } else {
                $order = Shop::Get()->getShopService()->getOrderByID($basket_test->getOrderid());

                if ($order->getIsshipped()) {
                    throw new ServiceUtils_Exception('shipped');
                }

                $orderID = $order->getId();
            }

            // получение складов для продажи
            if ($storageId) {
                $storageTo = StorageNameService::Get()->getStorageNameByID($storageId);
            } else {
                $storageTo = StorageNameService::Get()->getStorageNameSold();
            }

            // проверка прав пользователя
            if (
            !StorageNameService::Get()->isStorageOperationAllowed($cuser, $basket_test->getStorageName(), 'salefrom')
            ) {
                throw new ServiceUtils_Exception('user');
            }

            // системная валюта
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $storageID = 0;

            // создаем транзакцию
            $transaction = StorageService::Get()->addStorageTransaction(
                $cuser,
                'sale',
                $date,
                $basket_test->getStorageName(),
                $storageTo,
                false,
                $orderID
            );

            $amount_total = 0;
            $cost_total = 0;

            while ($x = $basketProducts->getNext()) {
                try {
                    // проверяем товар
                    $product = $x->getProduct();

                    // проверяем склад from
                    $storageFrom = $x->getStorageName();
                } catch (ServiceUtils_Exception $ee) {

                    $x->delete();
                    continue;
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
                    if ($balance->getProductid() != $x->getProductid() &&
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
                    $storage->setType('sale');
                    $storage->setOrderproductid($x->getOrderproductid());
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
                    false
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
                    $storage->setType('sale');
                    $storage->setOrderproductid($x->getOrderproductid());
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

            $order->setIsshipped(1);
            $order->setDateshipped($date);
            $order->update();

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
     * Отправить заказ в корзину отгрузки
     *
     * @param User $cuser
     * @param ShopOrder $order
     * @param int $storageNameID
     *
     * @return bool
     */
    public function moveOrderToSale(User $cuser, ShopOrder $order, $storageNameID) {
        try {
            SQLObject::TransactionStart();

            $orderProducts = Shop::Get()->getShopService()->getOrderProducts($order);

            // дописываем условие, чтобы не отгружать виртуальные тоары
            $orderProducts->addWhere('productid', 0, '>');

            // добавляем каждый товар заказа в корзину

            $ex = new ServiceUtils_Exception();
            $added = false;

            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    // пропускаем товары, которые услуги
                    $product = $orderProduct->getProduct();
                    if ($product->getSource()) {
                        continue;
                    }

                    $basket = StorageSaleService::Get()->addSale(
                        $cuser,
                        $order,
                        $orderProduct->getProductid(),
                        $orderProduct->getProductcount(),
                        $orderProduct->getId(),
                        $storageNameID
                    );

                    // а теперь смотрим резерв и делаем привязки уже к корзине отгрузки
                    $reserve = StorageReserveService::Get()->getLinksByOrderProduct($orderProduct);
                    while ($r = $reserve->getNext()) {
                        $r->setBasketid($basket->getId());
                        $r->update();
                    }

                    $added = true;
                } catch (ServiceUtils_Exception $se) {
                    $errorArray = $se->getErrorsArray();

                    foreach ($errorArray as $error) {
                        $ex->addError($error);
                    }
                }
            }

            if ($ex->getErrorsArray()) {
                1;
                ///throw $ex;
            }

            SQLObject::TransactionCommit();

            return $added;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Отправить заказ в корзину отгрузки для разных складов
     *
     * @param User $cuser
     * @param ShopOrder $order
     * @param int $storageNameID
     *
     * @return bool
     */
    public function moveOrderToSaleDifferentStorage(User $cuser, ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            $orderProducts = Shop::Get()->getShopService()->getOrderProducts($order);

            // дописываем условие, чтобы не отгружать виртуальные тоары
            $orderProducts->addWhere('productid', 0, '>');

            // добавляем каждый товар заказа в корзину

            $ex = new ServiceUtils_Exception();
            $added = false;

            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    // пропускаем товары, которые услуги
                    $product = $orderProduct->getProduct();
                    if ($product->getSource()) {
                        continue;
                    }

                    // а теперь смотрим резерв и делаем привязки уже к корзине отгрузки
                    $reserve = StorageReserveService::Get()->getLinksByOrderProduct($orderProduct);
                    while ($r = $reserve->getNext()) {

                        $storageNameIDLink = false;
                        try{
                            $storageNameIDLink = $r->getStorageName()->getId();
                        } catch (Exception $eee) {

                        }
                        $basket = StorageSaleService::Get()->addSale(
                            $cuser,
                            $order,
                            $orderProduct->getProductid(),
                            $r->getAmount(),
                            $orderProduct->getId(),
                            $storageNameIDLink
                        );

                        $r->setBasketid($basket->getId());
                        $r->update();
                    }

                    $added = true;
                } catch (ServiceUtils_Exception $se) {
                    $errorArray = $se->getErrorsArray();

                    foreach ($errorArray as $error) {
                        $ex->addError($error);
                    }
                }
            }


            if ($ex->getErrorsArray()) {
                1;
                ///throw $ex;
            }

            SQLObject::TransactionCommit();

            return $added;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Автоматически продать заказ со склада
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function processSaleAuto(User $cuser, ShopOrder $order, $storageId = false) {
        try {
            SQLObject::TransactionStart();

            // очищаем данные из корзины продажи,
            // которые нам мешают
            $salesOld = StorageSaleService::Get()->getSalesByUser($cuser);
            $salesOld->setOrderid($order->getId());
            while ($saleOld = $salesOld->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($saleOld, $cuser);
                $saleOld->delete();
            }

            // резервируем товар
            StorageReserveService::Get()->addLinksReserveAuto($cuser, $order, $storageId);

            if ($storageId) {
                $storageName = StorageNameService::Get()->getStorageNameByID($storageId);
            } else {
                $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
            }

            if (!$storageName) {
                throw new ServiceUtils_Exception('storage-no-storage-found');
            }

            // добавляем товары заказа в корзину отгрузки
            $added = $this->moveOrderToSale($cuser, $order, $storageName->getId());

            // отгружаем
            if ($added) {
                try {
                    $this->processSale($cuser, date('Y-m-d H:i:s'), false, $order->getId(), false);
                } catch (ServiceUtils_Exception $se) {
                    throw new ServiceUtils_Exception('storage-product-lack');
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Автоматически продать заказ со склада для разных складов
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function processSaleAutoDifferentStorage(User $cuser, ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            // очищаем данные из корзины продажи,
            // которые нам мешают
            $salesOld = StorageSaleService::Get()->getSalesByUser($cuser);
            $salesOld->setOrderid($order->getId());
            while ($saleOld = $salesOld->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($saleOld, $cuser);
                $saleOld->delete();
            }

            // резервируем товар
            StorageReserveService::Get()->addLinksReserveAutoDifferentStorage($cuser, $order);

            // добавляем товары заказа в корзину отгрузки
            $added = $this->moveOrderToSaleDifferentStorage($cuser, $order);

            // отгружаем
            if ($added) {
                try {
                    $this->processSale($cuser, date('Y-m-d H:i:s'), false, $order->getId());
                } catch (ServiceUtils_Exception $se) {
                    throw new ServiceUtils_Exception('storage-product-lack');
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Оформить заказ во время быстрой продажи.
     * Все суммы заказа фиксируются в системной валюте.
     * То есть, Order и все OrderProduct изначально будут в одной валюте.
     *
     * @param User $cuser
     * @param int $contractorID
     * @param int $userID
     * @param string $name
     * @param string $comments
     *
     * @return ShopOrder
     */
    public function makeOrder($cuser, $contractorID, $userID, $name, $comments) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $baskets = $this->getSalesByUser($cuser, true);
            $baskets2 = clone $baskets;

            $productArray = array();
            while ($x = $baskets->getNext()) {
                $productArray[$x->getId()] = array(
                'productid' => $x->getProductid(),
                'currencyid' => $x->getCurrencyid(),
                'price' => $x->getPrice(),
                'amount' => $x->getAmount(),
                'serial' => $x->getSerial(),
                'warranty' => $x->getWarranty(),
                );
            }

            $result = Shop::Get()->getShopService()->makeOrderByProductArray(
                $cuser,
                $contractorID,
                $userID,
                $name,
                $comments,
                $productArray
            );

            $order = $result['order'];
            $productArray = $result['productArray'];

            while ($x = $baskets2->getNext()) {
                $x->setOrderproductid(@$productArray[$x->getId()]['orderproductid']);
                $x->update();

                if (isset($productArray[$x->getId()]['error'])
                    || !isset($productArray[$x->getId()]['orderproductid'])
                ) {
                    $ex->addError($x->getId().':problem');
                }
            }

            // поиск категории по умолчанию
            $category = new ShopOrderCategory();
            $category->setDefault(1);
            $category->setType('order');
            if ($category->select()) {
                $categoryID = $category->getId();
            } else {
                $categoryID = 0;
            }

            // поиск статуса заказа для проданного заказа
            try {
                $statusDefault = new ShopOrderStatus();
                $statusDefault->setSaled(1);
                $statusDefault->setCategoryid($categoryID);
                $statusDefault->select();
            } catch (Exception $e) {

            }

            $order->setStatusid($statusDefault->getId());
            $order->setCategoryid($categoryID);
            $order->update();

            if ($ex->getCount()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function buildReportSales(ShopOrder $order) {
        try {
            SQLObject::TransactionStart();
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // суммы по заказу
            $total_ship = 0;
            $total_cost = 0;
            $sumArray = array();

            // если записи по заказу были - удаляем
            $x = new ShopStorageReportSales();
            $x->setOrderid($order->getId());
            while ($y = $x->getNext()) {
                $y->delete();
            }

            // формируем данные о заказе
            $x = new ShopStorageReportSales();
            $x->setOrderid($order->getId());
            $x->setCdate(date('Y-m-d H-i-s'));
            $x->setDateorder($order->getCdate());
            $x->setSumorder($order->getSum());
            $x->setClientid($order->getUserid());
            $x->setManagerid($order->getManagerid());
            // $x->setDepartmentid($order->getManager()->getDepartmentid());
            $x->setDiscountpercent($order->getDiscountPercent());

            // формируем данные об отгрузке
            $transaction = StorageService::Get()->getStorageTransactionsAll();
            $transaction->setOrderid($order->getId());
            if ($transaction->select()) {
                $x->setTransactionid($transaction->getId());
                $x->setDateship($transaction->getDate());
            }

            // формируем данные о товарах
            // (если товаров нет, данные об этом заказе нас не волнуют)
            $orderProducts = $order->getOrderProducts();
            while ($orderProduct = $orderProducts->getNext()) {
                $y = clone $x;
                $y->setOrderproductid($orderProduct->getId());
                $y->setProductid($orderProduct->getProductid());
                $y->setProductname($orderProduct->getProductname());
                $y->setProductprice(
                    Shop::Get()->getCurrencyService()->convertCurrency(
                        $orderProduct->getProductprice(),
                        $orderProduct->getCurrency(),
                        $currencySystem
                    )
                );

                $y->setProductamountorder($orderProduct->getProductcount());
                $y->setProductsumorder(round($y->getProductamountorder() * $y->getProductprice(), 2));

                // формируем данные о товарах склада, если была отгрузка,
                // если нет, делаем вставку

                print 1;
                if (!$transaction->select()) {
                    $y->insert();
                } else {
                    $storages = StorageService::Get()->getStoragesByTransaction($transaction);
                    $storages->setOrderproductid($orderProduct->getId());
                    $storages->addWhere('amount', 0, '>');

                    while ($storage = $storages->getNext()) {
                        $z = clone $y;
                        $z->setStorageid($storage->getId());
                        $z->setStorageprice($storage->getPricebase());

                        $z->setStorageamountorder($storage->getAmount());
                        $z->setStorageamountship($storage->getAmount());

                        $z->setStoragesumorder($storage->getAmount() * $z->getProductprice());
                        $z->setStoragesumship($storage->getAmount() * $z->getProductprice());
                        $z->setStoragesumcost($storage->getAmount() * $z->setStorageprice());

                        // получаем данные о поставщике
                        $incoming = new ShopStorage();
                        $incoming->setCode($storage->getCode());
                        $incoming->setOrder('cdate', 'ASC');
                        $incoming->addWhere('amount', 0, '>');
                        $incoming = $incoming->getNext();
                        if ($incoming) {
                            $z->setSupplierid($incoming->getStoragenamefromid());
                            $z->setDateincoming($incoming->getDate());
                        }

                        // получаем данные о возвратах
                        $return_transaction = new ShopStorageTransaction();
                        $return_transaction->setReturntransactionid($transaction->getId());
                        $returnsum = 0;
                        $returncostsum = 0;
                        $returnamount = 0;
                        while ($rt = $return_transaction->getNext()) {
                            $returns = StorageService::Get()->getStoragesByTransaction($rt);
                            $returns->setCode($storage->getCode());
                            $returns->addWhere('amount', 0, '>');
                            while ($return = $returns->getNext()) {
                                $returnsum += $return->getAmount() * $z->getProductprice();
                                $returncostsum += $return->getAmount() * $return->getPricebase();
                                $returnamount += $return->getAmount();
                            }
                        }

                        // считаем суммы
                        $z->setStorageamountship($z->getStorageamountship() - $returnamount);
                        $z->setStoragesumship($z->getStoragesumship() - $returnsum);
                        $z->setStoragesumcost($z->getStoragesumcost() - $returncostsum);

                        @$sumArray[$orderProduct->getId()]['amountship'] += $z->getStorageamountship();
                        @$sumArray[$orderProduct->getId()]['sumship'] += $z->getStoragesumship();
                        @$sumArray[$orderProduct->getId()]['sumcost'] += $z->getStoragesumcost();
                        $total_ship += $z->getStoragesumship();
                        $total_cost += $z->getStoragesumcost();

                        $z->insert();
                    }
                }

            }

            // обновляем суммы
            $x = new ShopStorageReportSales();
            $x->setOrderid($order->getId());
            while ($y = $x->getNext()) {
                $y->setSumship($total_ship);
                $y->setSumcost($total_cost);

                $y->setProductsumship(@$sumArray[$y->getOrderproductid()]['sumship']);
                $y->setProductsumcost(@$sumArray[$y->getOrderproductid()]['sumcost']);
                $y->update();
            }
            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            print $e;
            SQLObject::TransactionRollback();
        }

    }

    /**
     * Get
     *
     * @return StorageSaleService
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