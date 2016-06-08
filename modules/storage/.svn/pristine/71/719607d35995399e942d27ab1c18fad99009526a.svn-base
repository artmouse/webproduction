<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class StorageBasketService extends ServiceUtils_AbstractService {

    /**
     * StorageBasketByID
     *
     * @return ShopStorageBasket
     */
    public function getStorageBasketByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageBasket');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
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
     * Очистить складскую корзину пользователя пользователя по типу
     *
     * @param User $user
     * @param string $type
     */
    public function clearStorageBasketsByUser(User $user, $type) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getStorageBasketsByUser($user, $type);
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
     * Добавить товар в складскую корзину
     *
     * @param User $user
     * @param string $type
     * @param ShopProduct $product
     * @param int $storageNameID
     * @param int $count
     *
     * @return ShopStorageBasket
     */
    public function addStorageBasket(User $user, $type, ShopProduct $product,
    $storageNameID = false, $count = 1) {
        try {
            SQLObject::TransactionStart();

            if ($type != 'incoming') {
                // получение склада
                try {
                    $storageName = StorageNameService::Get()->getStorageNameByID(
                        $storageNameID
                    );

                    $baskets = $this->getStorageBasketsByUser($user, $type);
                    while ($x = $baskets->getNext()) {
                        if ($storageName->getId() != $x->getStoragenamefromid()) {
                            throw new ServiceUtils_Exception();
                        }
                    }
                } catch (ServiceUtils_Exception $e) {
                    throw new ServiceUtils_Exception('storagefrom');
                }
            }

            $basket = new ShopStorageBasket();
            $basket->setUserid($user->getId());
            $basket->setType($type);
            $basket->setProductid($product->getId());
            $basket->setStoragenamefromid($storageNameID);
            $basket->setAmount($product->getCountWithDivisibility(1) * $count);
            $basket->setPrice($product->getPricebase());
            $basket->setCurrencyid($product->getCurrencyid());
            $basket->setTax($product->getTax());
            $basket->setWarranty($product->getWarranty());
            $basket->setStoragenamefromid($storageNameID);
            $basket->insert();

            SQLObject::TransactionCommit();

            return $basket;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить товар в складскую корзину
     *
     * @param User $user
     * @param string $type
     * @param ShopProduct $product
     * @param int $storageNameID
     *
     * @return ShopStorageBasket
     */
    public function addStorageBasketFromXLS(
        User $user, ShopProduct $product, $price = false, $count = false,
        $currency = false, $warranty = false, $serial = false,  $shipment = false,  $tax = false
    ) {
        try {
            SQLObject::TransactionStart();

            if (!$count) {
                $count = 1;
            }

            try{
                $currencyId = Shop::Get()->getCurrencyService()->getCurrencyByName($currency)->getId();
            } catch (Exception $ec) {
                $price = $product->getPricebase();
                $currencyId  = $product->getCurrencyid();
            }

            $basket = new ShopStorageBasket();
            $basket->setUserid($user->getId());
            $basket->setType('incoming');
            $basket->setProductid($product->getId());
            $basket->setAmount($product->getCountWithDivisibility($count));
            $basket->setPrice($price);
            $basket->setCurrencyid($currencyId);
            $basket->setTax($product->getTax());
            $basket->setWarranty($warranty);
            $basket->setSerial($serial);
            $basket->setTax($tax);
            $basket->setShipment($shipment);
            $basket->insert();

            SQLObject::TransactionCommit();

            return $basket;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить товар в складской корзине
     *
     * @param ShopStorageBasket $basket
     * @param User $cuser
     * @param string $serial
     * @param float $amount
     * @param float $price
     * @param int $currencyID
     * @param bool $isWithTax
     * @param string $shipment
     * @param string $warranty
     *
     * @return ShopStorageBasket
     */
    public function updateStorageBasket(ShopStorageBasket $basket, User $cuser,
    $serial, $amount, $price = false, $currencyID = false, $isWithTax = false,
    $shipment = false, $warranty = false) {
        try {
            $ex = new ServiceUtils_Exception();

            if ($basket->getUserid() != $cuser->getId()) {
                $ex->addError('permission');
            }

            $amount = str_replace(',', '.', $amount);
            $amount = (float) trim($amount);

            if ($amount <= 0) {
                $ex->addError('count');
            }

            try{
                if (!$basket->getProduct()->testDivisibility($amount)) {
                    $ex->addError('divisibility');
                }
            } catch (Exception $eproduct) {
                StorageBasketService::Get()->deleteStorageBasket(
                    $basket,
                    $cuser
                );

                return;
            }

            if ($basket->getType() == 'incoming') {
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
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            if ($basket->getType() != 'incoming') {
                if ($amount != $basket->getAmount() || $serial != $basket->getSerial()) {
                    StorageLinkService::Get()->deleteBasketLinks($basket, $cuser);
                }
            }

            $basket->setSerial($serial);
            $basket->setAmount($amount);

            if ($basket->getType() == 'incoming') {
                $basket->setPrice($price);
                $basket->setCurrencyid($currencyID);
                $basket->setTax($isWithTax);
                $basket->setShipment($shipment);
                $basket->setWarranty($warranty);
            }

            $basket->update();

            return $basket;
        } catch (Exception $ge) {
            throw $ge;
        }
    }

    /**
     * Удалить товар из складской корзины
     *
     * @param ShopStorageBasket $basket
     * @param User $cuser
     */
    public function deleteStorageBasket(ShopStorageBasket $basket, User $cuser) {
        try {
            if ($basket->getUserid() != $cuser->getId()) {
                throw new ServiceUtils_Exception('permission');
            }

            $basket->delete();

        } catch (Exception $ge) {
            throw $ge;
        }
    }

    /**
     * Get
     * @return StorageBasketervice
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