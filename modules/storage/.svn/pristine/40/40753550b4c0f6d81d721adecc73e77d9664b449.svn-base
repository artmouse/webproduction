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
class StorageOrderService extends ServiceUtils_AbstractService {

    /**
     * @return ShopStorageOrder
     */
    public function getStorageOrderByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageOrder');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить складские заказы пользователя по типу
     *
     * @param User $user
     * @param string $type
     * @return ShopStorageOrder
     */
    public function getStorageOrdersByUser(User $user, $type) {
        $x = new ShopStorageOrder();
        //$x->setUserid($user->getId());
        $x->setType($type);
        return $x;
    }

    /**
     * Создать новый пустой заказ
     *
     * @param string $type
     * @return ShopStorageOrder
     */
    public function makeStorageOrderEmpty(User $cuser, $type) {
        try {
            SQLObject::TransactionStart();

            if (!in_array($type, $this->getOrderTypeArray())) {
                throw new ServiceUtils_Exception();
            }

            // оформление заказа
            $order = new ShopStorageOrder();
            $order->setCdate(date('Y-m-d H:i:s'));
            $order->setUserid($cuser->getId());
            $order->setType($type);
            $order->insert();

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить данные заказа
     *
     * @param ShopStorageOrder $order
     * @param User $cuser
     * @param string $cdate
     * @param int $storageNameFromID
     * @param int $storageNameToID
     */
    public function updateStorageOrder(ShopStorageOrder $order, User $cuser, $cdate,
    $storageNameFromID, $storageNameToID) {
        try {
            SQLObject::TransactionStart();
            
            if (!$cuser->isAllowed('storage-'.$order->getType()) || 
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                throw new ServiceUtils_Exception('permission');
            }

            $cdate = DateTime_Corrector::CorrectDateTime($cdate);

            if ($storageNameFromID) {
                try {
                    StorageNameService::Get()->getStorageNameByID($storageNameFromID);
                } catch (ServiceUtils_Exception $se) {
                    throw new ServiceUtils_Exception('storagenamefrom');
                }
            }

            if ($storageNameToID) {
                try {
                    StorageNameService::Get()->getStorageNameByID($storageNameToID);
                } catch (ServiceUtils_Exception $se) {
                    throw new ServiceUtils_Exception('storagenameto');
                }
            }

            $order->setCdate($cdate);
            $order->setStoragenamefromid($storageNameFromID);
            $order->setStoragenametoid($storageNameToID);
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить заказ
     * 
     * @param ShopStorageOrder $order
     * @param User $cuser
     */
    public function deleteStorageOrder(ShopStorageOrder $order, User $cuser) {
        try {
            SQLObject::TransactionStart();
            
            if (!$cuser->isAllowed('storage-'.$order->getType()) || 
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                throw new ServiceUtils_Exception('permission');
            }

            // чистка товара
            $orderproduct = $order->getStorageOrderProducts();
            while ($x = $orderproduct->getNext()) {
                $x->delete();
            }

            // удаляем заказ
            $order->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return ShopStorageOrderProduct
     */
    public function getStorageOrderProductByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageOrderProduct');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * @param ShopStorageOrder $order
     * @return ShopStorageOrderProduct
     */
    public function getStorageOrderProducts(ShopStorageOrder $order) {
        $x = new ShopStorageOrderProduct();
        $x->setOrderid($order->getId());
        return $x;
    }

    /**
     * @param ShopStorageOrder $order
     * @return ShopStorageOrderProduct
     */
    public function getStorageOrderProductsNotShipped(ShopStorageOrder $order) {
        $x = $this->getStorageOrderProducts($order);
        $x->setIsshipped(0);
        return $x;
    }
    
    /**
     * Есть ли у заказа неотгруженные товары
     *
     * @param ShopStorageOrder $order
     * @return bool
     */
    public function hasStorageOrderProducts(ShopStorageOrder $order) {
        $x = $this->getStorageOrderProductsNotShipped($order);
        if ($x->getNext()) {
            return true;
        }
        return false;
    }

    /**
     * Добавить товар в заказ
     *
     * @param User $cuser
     * @param ShopStorageOrder $order
     * @param int $productID
     * @param int $count
     * @param float $price
     * @param int $currencyID
     * @return ShopStorageOrderProduct
     */
    public function addOrderProduct(User $cuser, ShopStorageOrder $order, $productID,
    $count, $price = 0, $currencyID = false) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();
            
            if (!$cuser->isAllowed('storage-'.$order->getType()) || 
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                $ex->addError('permission');
            }
            
            if ($order->getIsshipped()) {
                $ex->addError('shipped');
            }

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

            $currencyRate = 0;
            if ($currencyID) {
                try {
                    $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
                    $currencyRate = $currency->getRate();
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('currency');
                }
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $orderProduct = new ShopStorageOrderProduct();
            $orderProduct->setOrderid($order->getId());
            $orderProduct->setProductid($product->getId());
            $orderProduct->setAmount($count);
            $orderProduct->setPrice($price);
            $orderProduct->setCurrencyid($currencyID);
            $orderProduct->setCurrencyrate($currencyRate);
            $orderProduct->insert();

            $this->_calculateStorageOrderSum($order);

            SQLObject::TransactionCommit();

            return $orderProduct;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в заказе
     *
     * @param ShopStorageOrderProduct $op
     * @param User $cuser
     * @param float $amount
     * @param float $price
     * @param int $currencyID
     */
    public function updateOrderProduct(ShopStorageOrderProduct $op, User $cuser,
    $amount, $price = 0, $currencyID = false) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();
            
            $order = $op->getOrder();
            
            if (!$cuser->isAllowed('storage-'.$order->getType()) || 
            ($cuser->getId() != $order->getUserid() && !$cuser->isAllowed('storage-orders-edit'))) {
                $ex->addError('permission');
            }
            
            if ($op->getIsshipped()) {
                $ex->addError('shipped');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            if (!$op->getProduct()->testDivisibility($amount)) {
                $ex->addError('divisibility');
            }

            $price = str_replace(',', '.', $price);
            $price = (float) trim($price);

            $currencyRate = 0;
            if ($currencyID) {
                try {
                    $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
                    $currencyRate = $currency->getRate();
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('currency');
                }
            }

            if ($price < 0) {
                $ex->addError('price');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $op->setCurrencyid($currencyID);
            $op->setPrice($price);
            $op->setAmount($amount);
            $op->update();

            $this->_calculateStorageOrderSum($order);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Пометить товар заказа как отгруженный
     *
     * @param ShopStorageOrderProduct $op
     * @param User $cuser
     * @param ShopStorageTransaction $transaction
     * @param float $amount
     * @param float $price
     * @param int $currencyID
     * @param int $storagenamefromID
     * @param int $storagenametoID
     * @param bool $sync
     */
    public function shipOrderProduct(ShopStorageOrderProduct $op, User $cuser,
    ShopStorageTransaction $transaction, $amount, $price, $currencyID,
    $storagenamefromID, $storagenametoID, $sync = true) {
        try {
            SQLObject::TransactionStart();
            
            if ($op->getIsshipped()) {
                throw new ServiceUtils_Exception('shipped');
            }

            if ($sync) {
                // синхронизируем данные заказа со складом
                $this->updateOrderProduct($op, $cuser, $amount, $price, $currencyID);
            } else {
                if ($amount < $op->getAmount()) {
                    // если было оприходовано количество меньшее, чем в заказе
  
                    // какое количество осталось дооприходовать
                    $amountNew = $op->getAmount() - $amount;
                    
                    // ставим в товаре заказа оприходованное количество
                    $op->setAmount($amount);
                    $op->update();
                    
                    // создаем товар заказа с количеством, 
                    // которое осталось еще дооприходовать
                    $this->addOrderProduct(
                    $cuser,
                    $op->getOrder(),
                    $op->getProductid(),
                    $amountNew,
                    $op->getPrice(),
                    $op->getCurrencyid()
                    );
                }
            }

            // отмечаем товар как отгруженный
            $op->setIsshipped(1);
            $op->update();

            // связываем заказ и транзакцию
            $o2t = new ShopStorageOrder2Transaction();
            $o2t->setOrderid($op->getOrderid());
            $o2t->setTransactionid($transaction->getId());
            if (!$o2t->select()) {
                $o2t->insert();
            }

            // обновляем данные заказа
            $order = $op->getOrder();
            $order->setStoragenamefromid($storagenamefromID);
            $order->setStoragenametoid($storagenametoID);

            // если больше нет неотгруженных товаров, отмечаем весь заказ как отгруженный
            $orderProducts = $this->getStorageOrderProductsNotShipped($order);
            if (!$orderProducts->getNext()) {
                $order->setIsshipped(1);
            }
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар из заказа
     *
     * @param ShopStorageOrderProduct $op
     * @param User $cuser
     */
    public function deleteOrderProduct(ShopStorageOrderProduct $op, User $cuser) {
        try {
            SQLObject::TransactionStart();

            /*if ($incoming->getUserid() != $cuser->getId()) {
            throw new ServiceUtils_Exception('permission');
            }*/

            $order = $op->getOrder();

            $op->delete();

            $this->_calculateStorageOrderSum($order);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Считаем сумму заказа
     * 
     * @param ShopStorageOrder $order
     */
    private function _calculateStorageOrderSum(ShopStorageOrder $order) {
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // полная сумма заказа
        $sum = 0;

        // проходимся по каждому товарару в заказе
        $orderproducts = $order->getStorageOrderProducts();
        while ($op = $orderproducts->getNext()) {
            try {
                // определяем цену в системной валюте с учетом НДС
                $money = new ShopMoney($op->getPrice(), $op->getCurrency(), 0);
                $price = $money->getAmount();
                $priceBase = $money->changeCurrency($currencySystem)->getAmount();

                $sum += round($priceBase * $op->getAmount(), 2);
            } catch (ServiceUtils_Exception $se) {

            }
        }

        // записываем
        $order->setSum($sum);
        $order->update();
    }

    /**
     * Получить массив возможных типов заказа
     *
     * @return array
     */
    public function getOrderTypeArray() {
        return array('incoming', 'transfer', 'production');
    }

    /**
     * @return StorageOrderService
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