<?php

class StorageStocktakingService extends ServiceUtils_AbstractService {

    /**
     * Получить товары из корзины переучета
     *
     * @return ShopStorageBasket
     */
    public function getStocktakingBaskets() {
        $x = new ShopStorageBasket();
        $x->setType('stocktaking');
        $x->setOrder('cdate', 'DESC');
        return $x;
    }

    /**
     * Добавить товар в корзину переучета
     *
     * @param User $cuser
     * @param int $storageNameID
     * @param int $productID
     * @param int $count
     *
     * @return ShopStorageBasket
     *
     * @throws ServiceUtils_Exception
     */
    public function addStocktaking(User $cuser, $storageNameID, $productID, $count) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count < 0) {
                $ex->addError('count');
            }

            try {
                $product = Shop::Get()->getShopService()->getProductByID($productID);

                if ($count && !$product->testDivisibility($count)) {
                    $ex->addError('divisibility');
                }
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('product');
            }

            // получение склада
            try {
                $baskets = $this->getStocktakingBaskets();
                if ($transfer = $baskets->getNext()) {
                    $storageNameID = $transfer->getStoragenamefromid();
                }

                $storageName = StorageNameService::Get()->getStorageNameByID($storageNameID);
            } catch (ServiceUtils_Exception $e) {
                throw new ServiceUtils_Exception('storagefrom');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $basket = new ShopStorageBasket();
            $basket->setType('stocktaking');
            $basket->setProductid($product->getId());
            $basket->setStoragenamefromid($storageName->getId());

            if ($basket->select()) {
                $basket->setUserid($cuser->getId());
                $basket->setAmount($basket->getAmount() + $count);
                $basket->setCdate(date('Y-m-d H:i:s'));
                $basket->update();
            } else {
                $basket->setUserid($cuser->getId());
                $basket->setAmount($count);
                $basket->setCdate(date('Y-m-d H:i:s'));
                $basket->insert();
            }

            SQLObject::TransactionCommit();

            return $basket;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в корзине переучета
     *
     * @param ShopStorageBasket $basket
     * @param User $cuser
     * @param float $amount
     *
     * @return ShopStorageBasket
     *
     * @throws ServiceUtils_Exception
     */
    public function updateStocktaking(ShopStorageBasket $basket, User $cuser, $amount) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount < 0) {
                $ex->addError('count');
            }

            try{
                $product = $basket->getProduct();
            } catch (Exception $eproduct) {
                // такого продукта больше нет в бд, удаляем
                StorageStocktakingService::Get()->deleteStocktaking(
                    $basket,
                    $cuser
                );

                return;
            }

            if (!$product->testDivisibility($amount)) {
                $ex->addError('divisibility');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $basket->setAmount($amount);
            $basket->update();

            SQLObject::TransactionCommit();

            return $basket;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товар из корзины переучета
     *
     * @param ShopStorageBasket $basket
     * @param User $cuser
     *
     * @throws ServiceUtils_Exception
     */
    public function deleteStocktaking(ShopStorageBasket $basket, User $cuser) {
        $cuser;
        try {
            SQLObject::TransactionStart();

            $basket->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Очистить корзину переучета
     */
    public function clearStocktakingBasket() {
        try {
            SQLObject::TransactionStart();

            $x = $this->getStocktakingBaskets();
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
     * Get
     *
     * @return StorageStocktakingService
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