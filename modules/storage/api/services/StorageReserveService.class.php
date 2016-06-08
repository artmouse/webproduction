<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * StorageReserveService
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class StorageReserveService extends ServiceUtils_AbstractService {

    /**
     * Получить связи товаров на складе с товаром из заказа
     *
     * @param ShopOrderProduct $orderProduct
     *
     * @return ShopStorageLink
     */
    public function getLinksByOrderProduct(ShopOrderProduct $orderProduct) {
        $links = new ShopStorageLink();
        $links->setOrderproductid($orderProduct->getId());
        return $links;
    }

    /**
     * Получить количество привязанного товара к товару из заказа
     *
     * @param User $user
     * @param ShopOrderProduct $orderProduct
     *
     * @return float
     */
    public function getProductAmountReserved(User $user, ShopOrderProduct $orderProduct) {
        $user;
        $amount = 0;

        $links = $this->getLinksByOrderProduct($orderProduct);
        while ($link = $links->getNext()) {
            $amount += $link->getAmount();
        }

        return $amount;
    }

    /**
     * Добавить резерв
     *
     * @param User $cuser
     * @param ShopStorageBalance $balance
     * @param ShopOrderProduct $orderProduct
     */
    public function addLinksReserve(User $cuser, ShopStorageBalance $balance, ShopOrderProduct $orderProduct) {
        try {
            SQLObject::TransactionStart();

            // количество для резервирования
            $amount = $orderProduct->getProductcount();

            // проверка совпадения товаров
            if ($orderProduct->getProductid() != $balance->getProductid()) {
                throw new ServiceUtils_Exception('product');
            }

            // проверка, может товар уже зарезервирован
            $alreadyReservedAmount = $this->getProductAmountReserved($cuser, $orderProduct);
            if ($alreadyReservedAmount < $amount) {
                $amountNeed = $amount;

                if ($alreadyReservedAmount > 0) {
                    // отнимаем от количества уже зарезервированное количество
                    $amountNeed -= $alreadyReservedAmount;
                }

                $storageName = $balance->getStorageName();
                // нас устраивают все запасы нужного товара на нужном складе
                $balances = StorageBalanceService::Get()->getBalanceByStorageAndProduct(
                    $cuser,
                    $storageName,
                    $balance->getProduct(),
                    false,
                    $orderProduct->getSerial()
                );

                $reserveAmount = $amountNeed;
                $date = date('Y-m-d H:i:s');

                // идем по всем записям баланса
                while ($balance = $balances->getNext()) {

                    // если количества не хватает
                    if ($balance->getAmountAvailable() < $reserveAmount) {
                        $reserveAmount = $balance->getAmountAvailable();
                    }

                    // отрицательное количество не устраивает
                    if ($reserveAmount <= 0) {
                        continue;
                    }

                    $reserve = new XShopStorageLink();
                    $reserve->setCdate($date);
                    $reserve->setStoragebalanceid($balance->getId());
                    $reserve->setUserid($cuser->getId());
                    $reserve->setAmount($reserveAmount);
                    $reserve->setOrderid($orderProduct->getOrderid());
                    $reserve->setOrderproductid($orderProduct->getId());
                    $reserve->insert();

                    // пересчитываем количество привязанного товара
                    StorageBalanceService::Get()->updateBalanceLinked(
                        $balance
                    );

                    // обновить серийный номер
                    if ($balance->getSerial() && !$orderProduct->getSerial() && $orderProduct->getProductcount() == 1) {
                        $orderProduct->setSerial($balance->getSerial());
                        $orderProduct->update();
                    }

                    if (!$orderProduct->getWarranty()) {
                        try {
                            $storage = StorageService::Get()->getStorageByCode($cuser, $balance->getCode());

                            if ($storage->getWarranty()) {
                                $orderProduct->setWarranty($storage->getWarranty());
                                $orderProduct->update();
                            }
                        } catch (ServiceUtils_Exception $sce) {

                        }
                    }

                    // сколько осталось непривязано
                    $amountNeed = $amountNeed - $reserveAmount;
                    $reserveAmount = $amountNeed;
                    if ($reserveAmount <= 0) {
                        break;
                    }
                }

                $ex = new ServiceUtils_Exception();

                if ($amountNeed > 0 && $orderProduct->getSerial()) {
                    $ex->addError(
                        'storage-product-lack-reserve-serial',
                        array('serial' => $orderProduct->getSerial())
                    );
                }

                if ($ex->getErrorsArray()) {
                    throw $ex;
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить резерв
     *
     * @param ShopOrderProduct $orderProduct
     */
    public function deleteLinksReserve(ShopOrderProduct $orderProduct) {
        try {
            SQLObject::TransactionStart();

            $links = new ShopStorageLink();
            $links->setOrderproductid($orderProduct->getId());
            while ($link = $links->getNext()) {
                try{
                    $balance = $link->getBalance();

                    $link->delete();

                    // пересчитываем количество привязанного товара
                    StorageBalanceService::Get()->updateBalanceLinked(
                        $balance
                    );
                } catch (Exception $e) {
                    $link->delete();
                }

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Автоматически зарезервировать товар заказа
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function addLinksReserveAuto(User $cuser, ShopOrder $order, $storageId = false) {
        try {
            SQLObject::TransactionStart();

            if ($order->getOutcoming()) {
                throw new ServiceUtils_Exception('storage-order-not-incoming');
            }

            $ex = new ServiceUtils_Exception();

            // находим все товары заказа
            $orderProducts = $order->getOrderProducts();
            $orderProducts->addWhere('productid', 0, '>');
            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    // проверка, может товар уже зарезервирован
                    $alreadyReservedAmount = $this->getProductAmountReserved($cuser, $orderProduct);
                    if ($alreadyReservedAmount >= $orderProduct->getProductcount()) {
                        continue;
                    }

                    // какой товар
                    $product = $orderProduct->getProduct();
                    if ($product->getSource()) {
                        continue;
                    }

                    // находим баланс, который можно зарезервировать
                    $balance = StorageBalanceService::Get()->getBalanceByProductForReserve(
                        $product,
                        $cuser,
                        $storageId
                    )->getNext();

                    if ($balance) {
                        // резервируем товар
                        StorageReserveService::Get()->addLinksReserve(
                            $cuser,
                            $balance,
                            $orderProduct
                        );
                    } else {
                        if ($orderProduct->getSerial()) {
                            $ex->addError(
                                'storage-product-lack-reserve-serial',
                                array('serial' => $orderProduct->getSerial())
                            );
                        }
                    }
                } catch (ServiceUtils_Exception $se) {
                    $errorArray = $se->getErrorsArray(true);
                    foreach ($errorArray as $error) {
                        $ex->addError($error['key'], $error['parameterArray']);
                    }
                }
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }
    /**
     * Автоматически зарезервировать товар заказа для разных складов
     *
     * @param User $cuser
     * @param ShopOrder $order
     */
    public function addLinksReserveAutoDifferentStorage(User $cuser, ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            try {
                if ($order->getWorkflow()->getOutcoming()) {
                    throw new ServiceUtils_Exception('storage-order-not-incoming');
                }
            } catch (Exception $eworkflow) {
                if ($order->getOutcoming()) {
                    throw new ServiceUtils_Exception('storage-order-not-incoming');
                }
            }

            $ex = new ServiceUtils_Exception();

            // находим все товары заказа
            $orderProducts = $order->getOrderProducts();
            $orderProducts->addWhere('productid', 0, '>');
            while ($orderProduct = $orderProducts->getNext()) {
                try {
                    // проверка, может товар уже зарезервирован
                    $alreadyReservedAmount = $this->getProductAmountReserved($cuser, $orderProduct);
                    if ($alreadyReservedAmount >= $orderProduct->getProductcount()) {
                        continue;
                    }

                    // какой товар
                    $product = $orderProduct->getProduct();
                    if ($product->getSource()) {
                        continue;
                    }

                    // находим баланс, который можно зарезервировать
                    try{
                        $balance = StorageBalanceService::Get()->getBalanceByID($orderProduct->getStorageid());
                    } catch (Exception $ebalance) {
                        $balance = false;
                    }

                    if ($balance) {
                        // резервируем товар
                        StorageReserveService::Get()->addLinksReserve(
                            $cuser,
                            $balance,
                            $orderProduct
                        );
                    } else {
                        if ($orderProduct->getSerial()) {
                            $ex->addError(
                                'storage-product-lack-reserve-serial',
                                array('serial' => $orderProduct->getSerial())
                            );
                        }
                    }
                } catch (ServiceUtils_Exception $se) {
                    $errorArray = $se->getErrorsArray(true);
                    foreach ($errorArray as $error) {
                        $ex->addError($error['key'], $error['parameterArray']);
                    }
                }
            }
            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить все резервы в заказе
     *
     * @param ShopOrder $order
     */
    public function deleteLinksReserveAuto(ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            // находим все товары заказа
            $orderProducts = $order->getOrderProducts();
            $orderProducts->addWhere('productid', 0, '>');
            while ($orderProduct = $orderProducts->getNext()) {

                $this->deleteLinksReserve($orderProduct);
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Get
     *
     * @return StorageReserveService
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