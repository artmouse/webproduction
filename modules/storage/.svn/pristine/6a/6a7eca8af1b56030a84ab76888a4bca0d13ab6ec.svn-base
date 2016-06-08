<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class StorageIncomingService extends ServiceUtils_AbstractService {

    /**
     * Получить товары из текущей приходной накладной пользователя
     *
     * @param User $user
     *
     * @return ShopStorageBasket
     */
    public function getIncomingsByUser(User $user) {
        return StorageService::Get()->getStorageBasketsByUser($user, 'incoming');
    }

    /**
     * Очистить корзину прихода
     *
     * @param User $user
     */
    public function clearIncomings(User $user) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getIncomingsByUser($user);
            while ($y = $x->getNext()) {
                $y->delete();

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в приходную накладную
     *
     * @param User $cuser
     * @param int $productID
     * @param string $serial
     * @param int $count
     * @param float $price
     * @param int $currencyID
     * @param bool $isWithTax
     * @param varchar $warranty
     * @param string $shipment
     * @param int $workerid
     * @param string $workeroperation
     * @param int $orderProductID
     * @param int $orderID
     *
     * @return ShopStorageBasket
     */
    public function addIncoming(User $cuser, $productID, $serial, $count,
    $price, $currencyID, $isWithTax, $warranty, $shipment, $workerid, $workeroperation,
    $orderProductID = false, $orderID = false) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);
            $price = str_replace(',', '.', $price);
            $price = (float) trim($price);

            if ($count <= 0) {
                $ex->addError('count');
            }

            if ($price < 0) {
                $ex->addError('price');
            }

            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);

                if (!$product->testDivisibility($count)) {
                    $ex->addError('divisibility');
                }
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('product');
            }

            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $warranty = trim($warranty);
            if (!$warranty) {
                $warranty = $product->getWarranty();
            }

            // возможен ли производственный приход
            $productionAllowed = false;
            if (Engine::Get()->getConfigFieldSecure('production-status')
            && $cuser->isAllowed('production-incoming')) {
                $productionAllowed = true;
            }

            $incoming = new ShopStorageBasket();
            $incoming->setType('incoming');
            $incoming->setUserid($cuser->getId());
            $incoming->setAmount($count);
            $incoming->setProductid($product->getId());
            $incoming->setSerial($serial);
            $incoming->setPrice($price);
            $incoming->setWarranty($warranty);
            $incoming->setCurrencyid($currency->getId());
            $incoming->setShipment($shipment);
            $incoming->setTax($isWithTax);
            if ($productionAllowed) {
                $incoming->setWorkerid($workerid);
                $incoming->setWorkeroperation($workeroperation);
            }
            $incoming->setOrderproductid($orderProductID);
            $incoming->setOrderid($orderID);
            $incoming->insert();

            SQLObject::TransactionCommit();

            return $incoming;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в приходной корзине
     *
     * @param ShopStorageBasket $incoming
     * @param User $cuser
     * @param float $amount
     * @param float $price
     * @param int $currencyID
     * @param bool $isWithTax
     * @param string $shipment
     * @param int $workerID
     * @param string $workeroperation
     * @param bool $sync
     *
     * @return ShopStorageBasket
     *
     * @throws ServiceUtils_Exception
     */
    public function updateIncoming(ShopStorageBasket $incoming, User $cuser,
    $amount, $price, $currencyID, $isWithTax, $shipment, $workerID,
    $workeroperation, $sync) {
        $sync;
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if ($incoming->getUserid() != $cuser->getId()) {
                $ex->addError('permission');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            if (!$incoming->getProduct()->testDivisibility($amount)) {
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

            if ($amount > 1 && $incoming->getSerial()) {
                $ex->addError('serial');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $incoming->setCurrencyid($currencyID);
            $incoming->setPrice($price);
            $incoming->setAmount($amount);
            $incoming->setTax($isWithTax);
            $incoming->setShipment($shipment);
            $incoming->setWorkerid($workerID);
            $incoming->setWorkeroperation($workeroperation);
            $incoming->update();

            SQLObject::TransactionCommit();

            return $incoming;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар из приходной накладной
     *
     * @param ShopStorageBasket $incoming
     * @param User $cuser
     * 
     * @throws ServiceUtils_Exception
     */
    public function deleteIncoming(ShopStorageBasket $incoming, User $cuser) {
        try {
            SQLObject::TransactionStart();

            if ($incoming->getUserid() != $cuser->getId()) {
                throw new ServiceUtils_Exception('permission');
            }

            $incoming->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Провести приходную накладную на склад
     *
     * @param User $cuser
     * @param int $supplierID
     * @param int $storageNameID
     * @param string $document
     * @param string $request
     * @param int $date
     * @param int $contractorID
     * @param int $orderID
     *
     * @return int
     */
    public function processIncomings(User $cuser, $supplierID, $storageNameID,
    $document, $request, $date, $contractorID, $orderID = false, $updateOrderShipped = true) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $document = trim($document);
            $date = DateTime_Corrector::CorrectDateTime($date);

            // проверка склада
            try {
                $storageName = StorageNameService::Get()->getStorageNameByID(
                    $storageNameID
                );
            } catch (Exception $e) {
                $ex->addError('storagename');
            }

            // проверка склада-поставщика
            try {
                $supplier = StorageNameService::Get()->getStorageNameByID(
                    $supplierID
                );
            } catch (Exception $e) {
                $ex->addError('supplier');
            }

            if (!$supplier->getIsvendor()) {
                $ex->addError('supplier');
            }

            // проверка прав
            if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'incomingto')
                || !StorageNameService::Get()->isStorageOperationAllowed($cuser, $supplier, 'incomingfrom')
            ) {
                $ex->addError('permission');
            }

            $taxRate = 0;

            // проверка юр лица
            if ($contractorID) {
                try {
                    $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
                    $taxRate = $contractor->getTax();
                } catch (Exception $e) {
                    $contractorID = false;
                }
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            // возможен ли производственный приход
            $productionAllowed = false;
            if (Engine::Get()->getConfigFieldSecure('production-status')
            && $cuser->isAllowed('production-incoming')) {
                $productionAllowed = true;
            }

            // получение списка товаров накладной
            $incoming = $this->getIncomingsByUser($cuser);
            if ($orderID) {
                $incoming->setOrderid($orderID);
            }

            $k = 0;
            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $storageID = false;

            // создаем транзакцию
            $transaction = StorageService::Get()->addStorageTransaction(
                $cuser,
                'incoming',
                $date,
                $supplier,
                $storageName,
                false,
                $orderID
            );

            $amount_total = 0;
            $cost_total = 0;

            while ($x = $incoming->getNext()) {
                $k++;

                // проверяем товар
                try {
                    $product = $x->getProduct();
                } catch (ServiceUtils_Exception $ee) {
                    $x->delete();
                    continue;
                }

                // проверяем валюту
                try {
                    $currency = $x->getCurrency();
                } catch (ServiceUtils_Exception $ee) {
                    $x->delete();
                    continue;
                }

                // определяем цену pricebase - это цена в системной валюте
                // с учетом НДС (необходима для построения баланса)
                $money = new ShopMoney($x->getPrice(), $currency, $taxRate);
                $price = $money->getAmount();
                $taxRate = $money->getTaxRate();

                if (!$x->getTax()) {
                    $priceBase = $money->changeCurrency($currencySystem)->includeTax($taxRate)->getAmount();
                } else {
                    $priceBase = $money->changeCurrency($currencySystem)->getAmount();
                    $price = $price * 100 / (100 + $taxRate);
                }

                // вставляем на склад
                $storage = new ShopStorage();
                $storage->setTransactionid($transaction->getId());
                $storage->setCdate($transaction->getCdate());
                $storage->setDate($transaction->getDate());
                $storage->setUserid($cuser->getId());
                $storage->setProductid($x->getProductid());
                $storage->setProductname($product->getName());
                $storage->setPrice($price);
                $storage->setCurrencyid($x->getCurrencyid());
                $storage->setCurrencyrate($currency->getRate());
                $storage->setAmount($x->getAmount());
                $storage->setSerial($x->getSerial());
                $storage->setWarranty($x->getWarranty());
                $storage->setDocument($document);
                $storage->setStoragenamefromid($supplierID);
                $storage->setStoragenametoid($storageNameID);
                $storage->setCode(md5($storage->getCdate().$cuser->getId().$x->getProductid().$k));
                $storage->setTaxrate($taxRate);
                $storage->setPricebase($priceBase);
                $storage->setRequest($request);
                $storage->setIsbox($product->getIsbox());
                $storage->setShipment($x->getShipment());
                $storage->setContractorid($contractorID);
                if ($productionAllowed) {
                    $storage->setWorkerid($x->getWorkerid());
                    $storage->setWorkeroperation($x->getWorkeroperation());
                }
                $storage->setType('incoming');
                $storage->setOrderproductid($x->getOrderproductid());
                $storage->insert();

                $amount_total += $storage->getAmount();
                $cost_total += $storage->getPricebase() * $storage->getAmount();

                $storageID = $storage->getId();

                $storage->setId(false);
                $storage->setAmount((-1) * $x->getAmount());
                $storage->setStoragenamefromid($storageNameID);
                $storage->setStoragenametoid($supplierID);
                $storage->insert();

                // обновляем записи баланса
                StorageBalanceService::Get()->updateBalance(
                    $storageName,
                    $product
                );

                StorageBalanceService::Get()->updateBalance(
                    $supplier,
                    $product
                );

                // удаляем строку из приходной накладной
                $x->delete();

                // обновление RRC
                if ($product->getRrc()) {
                    try {
                        $r = StorageBalanceService::Get()->getStorageReserve(
                            $storageNameID,
                            $product->getId()
                        );

                        StorageBalanceService::Get()->updateStorageReserve(
                            $storageNameID,
                            $product->getId(),
                            $r->getAmount(),
                            $product->getPrice(),
                            $product->getCurrencyid()
                        );
                    } catch (ServiceUtils_Exception $rrce) {
                        StorageBalanceService::Get()->updateStorageReserve(
                            $storageNameID,
                            $product->getId(),
                            false,
                            $product->getPrice(),
                            $product->getCurrencyid()
                        );
                    }
                }

            }

            $transaction->setAmount($amount_total);
            $transaction->setCost($cost_total);
            $transaction->update();

            if ($orderID && $updateOrderShipped) {
                // при приходовании заказа ставим заказу isshipped=1

                $order = Shop::Get()->getShopService()->getOrderByID(
                    $orderID
                );

                $order->setIsshipped(1);
                $order->setDateshipped($date);
                $order->update();
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
     * Добавить товары заказа в корзину оприходования
     *
     * @param User $cuser
     * @param ShopOrder $order
     *
     * @return bool
     */
    public function moveOrderToIncoming(User $cuser, ShopOrder $order, ShopOrderProduct $orderProducts = null) {
        try {
            SQLObject::TransactionStart();

            if (!$orderProducts) {
                $orderProducts = $order->getOrderProducts();
            }

            // товары с кодом 0 не нужно приходовать
            $orderProducts->addWhere('productid', 0, '>');

            $added = false;
            $alreadyInBasket = false;

            // добавляем каждый товар заказа в приход
            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    $incomings = StorageIncomingService::Get()->getIncomingsByUser($cuser);
                    $incomings->setOrderproductid($orderProduct->getId());

                    if (!$incomings->getNext()) {
                        StorageIncomingService::Get()->addIncoming(
                            $cuser,
                            $orderProduct->getProductid(),
                            $orderProduct->getSerial(),
                            $orderProduct->getProductcount(),
                            $orderProduct->getProductprice(),
                            $orderProduct->getCurrencyid(),
                            $orderProduct->getProducttax(),
                            $orderProduct->getWarranty(),
                            false,
                            false,
                            false,
                            $orderProduct->getId(),
                            $order->getId()
                        );

                        $added = true;
                    } else {
                        $alreadyInBasket = true;
                    }
                } catch (ServiceUtils_Exception $se) {

                }
            }

            SQLObject::TransactionCommit();

            return ($added || $alreadyInBasket);
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Автоматически приходовать товар заказа
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function processIncomingsAuto(User $cuser, ShopOrder $order, ShopStorageName $storageName) {
        try {
            SQLObject::TransactionStart();

            // очищаем данные из корзины оприходования,
            // которые нам мешают
            $incomingsOld = StorageIncomingService::Get()->getIncomingsByUser($cuser);
            $incomingsOld->setOrderid($order->getId());
            while ($incomingOld = $incomingsOld->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($incomingOld, $cuser);
                $incomingOld->delete();
            }

            // добавляем товары заказа в корзину оприходования
            $this->moveOrderToIncoming($cuser, $order);

            $vendors = StorageNameService::Get()->getStorageNamesVendors();
            $vendors->setUserid($order->getUserid());
            $vendor = $vendors->getNext();
            if (!$vendor) {
                throw new ServiceUtils_Exception('storage-vendor-not-found');
            }

            // приходуем
            $this->processIncomings(
                $cuser,
                $vendor->getId(),
                $storageName->getId(),
                false,
                false,
                date('Y-m-d H:i:s'),
                $order->getContractorid(),
                $order->getId()
            );

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Автоматически приходовать товар заказа
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function processIncomingsAutoDifferentStorage(
        User $cuser, ShopOrder $order, ShopStorageName $storageName, ShopOrderProduct $orderProducts
    ) {
        try {
            SQLObject::TransactionStart();

            // очищаем данные из корзины оприходования,
            // которые нам мешают
            $incomingsOld = StorageIncomingService::Get()->getIncomingsByUser($cuser);
            $incomingsOld->setOrderid($order->getId());
            while ($incomingOld = $incomingsOld->getNext()) {
                StorageLinkService::Get()->deleteBasketLinks($incomingOld, $cuser);
                $incomingOld->delete();
            }

            // добавляем товары заказа в корзину оприходования
            $this->moveOrderToIncoming($cuser, $order, $orderProducts);

            $vendors = StorageNameService::Get()->getStorageNamesVendors();
            $vendors->setUserid($order->getUserid());
            $vendor = $vendors->getNext();
            if (!$vendor) {
                throw new ServiceUtils_Exception('storage-vendor-not-found');
            }

            // приходуем
            $this->processIncomings(
                $cuser,
                $vendor->getId(),
                $storageName->getId(),
                false,
                false,
                date('Y-m-d H:i:s'),
                $order->getContractorid(),
                $order->getId(),
                false
            );

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Get
     *
     * @return StorageIncomingService
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