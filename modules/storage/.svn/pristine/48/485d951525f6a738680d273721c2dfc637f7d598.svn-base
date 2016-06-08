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
class StorageLinkService extends ServiceUtils_AbstractService {

    /**
     * @param int $id
     * @return ShopStorageLink
     */
    public function getLinkByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageLink');
        } catch (Exception $e) {}
        throw new ServiceUtils_Exception('Link by id not found');
    }

    /**
     * Получить связи товаров на складе с перещениями/заказами/тп
     *
     * @param ShopStorageBalance $balance
     * @return ShopStorageLink
     */
    public function getLinksByBalance(ShopStorageBalance $balance) {
        $links = new ShopStorageLink();
        $links->setStoragebalanceid($balance->getId());
        return $links;
    }

    /**
     * Получить связи товаров на складе с товаром из корзины
     *
     * @param ShopStorageBasket $basket
     * @return ShopStorageLink
     */
    public function getLinksByBasket(ShopStorageBasket $basket) {
        $links = new ShopStorageLink();
        $links->setBasketid($basket->getId());
        return $links;
    }

    /**
     * Получить количество привязанного товара к "объекту"
     *
     * @param User $user
     * @param ShopStorageBasket $basket
     * @return float
     */
    public function getLinkedProductAmount(User $user, ShopStorageBasket $basket) {
        $amount = 0;

        $links = $this->getLinksByBasket($basket);
        while ($link = $links->getNext()) {
            $amount += $link->getAmount();
        }

        return $amount;
    }

    /**
     * Привязать товар на складе к перемещению/заказу/тп
     *
     * @param User $cuser
     * @param ShopStorageBalance $balance
     * @param string $type
     * @param int $objectID
     * @param float $amount
     *
     * @return ShopStorageLink
     */
    public function addLink(User $cuser, ShopStorageBalance $balance,
    ShopStorageBasket $basket, $amount) {
        try {
            SQLObject::TransactionStart();

            $amount = (float) $amount;

            // проверка совпадения товаров
            if ($basket->getProductid() != $balance->getProductid()) {
                throw new ServiceUtils_Exception('product');
            }

            // проверка количества
            if ($amount > $basket->getAmount()) {
                $amount = $basket->getAmount();
            }

            $type = $basket->getType();

            // если привязываем к перемещению
            if ($type == 'transfer' || $type == 'outcoming') {

                // проверка совпадения складов
                if ($basket->getStoragenamefromid() != $balance->getStoragenameid()) {
                    throw new ServiceUtils_Exception('storagename');
                }

                // проверка прав
                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $balance->getStorageName(),
                'transferfrom')
                ) {
                    throw new ServiceUtils_Exception('user');
                }

                // если привязываем к отгрузке
            } elseif ($type == 'sale') {

                // проверка склада (можно ли с него продавать)
                if (!$balance->getStorageName()->getForsale()) {
                    throw new ServiceUtils_Exception('storagename');
                }

                // проверка прав
                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $balance->getStorageName(),
                'salefrom')
                ) {
                    throw new ServiceUtils_Exception('user');
                }

                // если привязываем к производству
            } elseif ($type == 'production') {

                // проверка совпадения складов
                if ($basket->getStoragenamefromid() != $balance->getStoragenameid()) {
                    throw new ServiceUtils_Exception('storagename');
                }

                // проверка прав
                if (!StorageNameService::Get()->isStorageOperationAllowed(
                $cuser,
                $balance->getStorageName(),
                'transferfrom')
                ) {
                    throw new ServiceUtils_Exception('user');
                }

            } else {
                // непонятный тип привязки
                throw new ServiceUtils_Exception('type');
            }

            // если количетва не хватает
            if ($balance->getAmountAvailable() < $amount) {
                $amount = $balance->getAmountAvailable();
            }

            // отрицательное количество не устраивает
            if ($amount <= 0) {
                throw new ServiceUtils_Exception('balance');
            }

            $link = new ShopStorageLink();
            $link->setStoragebalanceid($balance->getId());
            $link->setBasketid($basket->getId());
            $link->setAmount($amount);
            $link->setUserid($cuser->getId());
            $link->setCdate(date('Y-m-d H:i:s'));
            $link->insert();

            // пересчитываем количество привязанного товара
            StorageBalanceService::Get()->updateBalanceLinked(
            $balance
            );

            SQLObject::TransactionCommit();

            return $link;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить привязку
     *
     * @param ShopStorageLink $link
     * @param User $cuser
     */
    public function deleteLink(ShopStorageLink $link, User $cuser) {
        try {
            SQLObject::TransactionStart();

            if ($link->getUserid() != $cuser->getId()){
                //throw new ServiceUtils_Exception('user');
            }

            $balance = $link->getBalance();
            $link->delete();

            // пересчитываем количество привязанного товара
            StorageBalanceService::Get()->updateBalanceLinked(
            $balance
            );

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить все привязки товара к перемещению
     *
     * @param ShopOrderProduct $orderProduct
     * @param User $cuser
     */
    public function deleteBasketLinks(ShopStorageBasket $basket, User $cuser) {
        try {
            SQLObject::TransactionStart();

            $links = $this->getLinksByBasket($basket);

            while ($link = $links->getNext()) {
                $this->deleteLink($link, $cuser);
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return StorageLinkService
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