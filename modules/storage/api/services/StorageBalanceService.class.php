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
 * StorageBalanceService
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class StorageBalanceService extends ServiceUtils_AbstractService {

    /**
     * Получить баланс по id
     *
     * @param int $id
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopStorageBalance');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Balance by id not found');
    }

    /**
     * Получить остатки конкретного товара на конкретном складе
     * (метод нужен для привязок и перемещений, группировка не нужна)
     *
     * @param User $cuser
     * @param ShopStorageName $storageName
     * @param ShopProduct $product
     * @param string $code
     * @param string $serial
     *
     * @return ShopStorageBalance
     *
     * @throws ServiceUtils_Exception
     */
    public function getBalanceByStorageAndProduct(User $cuser, ShopStorageName $storageName,
    ShopProduct $product, $code = false, $serial = false) {
        if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'transferfrom')) {
            throw new ServiceUtils_Exception('user');
        }

        $balance = new ShopStorageBalance();
        $balance->setStoragenameid($storageName->getId());
        $balance->setProductid($product->getId());

        // нас интересует только незарезервированный товар
        $balance->addWhereQuery('(`amount` > `amountlinked`)');
        // и только товар который ЕСТЬ на складе
        $balance->addWhereQuery('(`amount` > 0)');

        if ($code) {
            $balance->setCode($code);
        }

        if ($serial) {
            $balance->setSerial($serial);
        }

        $balance->setOrder('cdate', 'ASC');

        return $balance;
    }

    /**
     * Получить остатки конкретного товара на складах для продажи
     * (метод нужен для привязок и продажи, группировка не нужна)
     *
     * @param User $cuser
     * @param ShopProduct $product
     * @param string $code
     * @param string $serial
     *
     * @deprecated
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByProductAndStoragesForSale($cuser, ShopProduct $product,
    $code = false, $serial = false) {

        // получаем все склады, с которых можно продавать
        $storageNamesForSale = StorageNameService::Get()->getStorageNamesForSaleByUser($cuser);
        $storageNamesForSaleIDs = array(-1);
        while ($storageNameForSale = $storageNamesForSale->getNext()) {
            $storageNamesForSaleIDs[] = $storageNameForSale->getId();
        }

        $balance = new ShopStorageBalance();
        $balance->setProductid($product->getId());

        $balance->addWhereQuery(
            '(`storagenameid` IN ('.implode(',', $storageNamesForSaleIDs).'))'
        );

        // нас интересует только незарезервированный товар
        $balance->addWhereQuery('(`amount` > `amountlinked`)');
        // и только товар который ЕСТЬ на складе
        $balance->addWhereQuery('(`amount` > 0)');

        if ($code) {
            $balance->setCode($code);
        }

        if ($serial) {
            $balance->setSerial($serial);
        }

        $balance->setOrder('cdate', 'ASC');

        return $balance;
    }

    /**
     * Получить остатки всех товаров на складах
     * (метод нужен для отчета "баланс", группируем по складу и товару)
     *
     * @param User $cuser
     * @param array $storageNameIDArray
     * @param array $productIDArray
     * @param ShopCategory $category
     * @param string $productName
     * @param string $serial
     * @param bool $showDetailed
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByStorage(User $cuser, $storageNameIDArray, $productIDArray,
    $category, $productName = false, $serial = false, $showDetailed = false) {
        $balance = new ShopStorageBalance();

        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amount`) AS `amount`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amountlinked`) AS `amountlinked`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`cost`) AS `cost`');

        $storageNameIDAllowed = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read');
        $storageNameIDArray[] = -1;

        if ($storageNameIDArray) {
            foreach ($storageNameIDArray as $k => $v) {
                if (!in_array($v, $storageNameIDAllowed)) {
                    unset($storageNameIDArray[$k]);
                }
            }
        }

        $balance->addWhereQuery('`shopstoragebalance`.`storagenameid` IN ('.implode(',', $storageNameIDArray).')');

        if ($category) {
            $products = new ShopProduct();
            $balance->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');

            $level = $category->getLevel();
            $balance->addWhere('`shopproduct`.`category'.$level.'id`', $category->getId(), '=');
        }

        if ($productIDArray) {
            $balance->addWhereQuery('`shopstoragebalance`.`productid` IN ('.implode(',', $productIDArray).')');
        }

        if ($productName) {
            $productName = '%'.str_replace(' ', '%', $productName).'%';

            $products = new ShopProduct();
            $balance->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');
            $balance->addWhereQuery(
                '(`shopproduct`.`id` LIKE \''.$productName.'\' OR `shopproduct`.`name` LIKE \''.
                $productName.'\' OR `shopproduct`.`articul` LIKE \''.
                $productName.'\' OR `shopproduct`.`model` LIKE \''.
                $productName.'\' OR `shopstoragebalance`.`productname` LIKE \''.$productName.'\')'
            );
        }

        if ($serial) {
            $balance->addWhere('serial', '%'.$serial.'%', 'LIKE');
        }

        if ($showDetailed) {
            $balance->setGroupByQuery('storagenameid, productid, serial');
        } else {
            $balance->setGroupByQuery('storagenameid, productid');
        }

        // порядок по складу обязательно
        $balance->setOrder('`shopstoragebalance`.`storagenameid`, `shopstoragebalance`.`productname`');

        $balance->addWhere('amount', 0, '>');

        return $balance;
    }

    /**
     * Получить остатки конкретного товара на всех складах
     * (метод нужен для поиска товара, группируем по складу)
     *
     * @param ShopProduct $product
     * @param User $cuser
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByProduct(ShopProduct $product, $cuser = false) {
        $balance = new ShopStorageBalance();
        $balance->setProductid($product->getId());

        if ($cuser) {
            $balance->addWhereQuery(
                '(`storagenameid` IN ('.implode(
                    ',', StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read')
                ).'))'
            );
        }

        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amount`) AS `amount`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amountlinked`) AS `amountlinked`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`cost`) AS `cost`');

        $balance->setGroupByQuery('storagenameid');
        return $balance;
    }

    /**
     * Поиск товаров на складе по серийнику
     *
     * @param User $cuser
     * @param string $serial
     *
     * @return ShopStorageBalance
     */
    public function getBalanceBySerial(User $cuser, $serial) {
        $balance = new ShopStorageBalance();
        $balance->addWhere('serial', '%'.$serial.'%', 'LIKE');
        $balance->addWhere('amount', 0, '>');
        $balance->addWhereQuery('(`amount` > `amountlinked`)');

        $storageNameIDAllowed = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read');
        $balance->addWhereArray($storageNameIDAllowed, 'storagenameid');

        return $balance;
    }

    /**
     * Получить остатки конкретного товара на всех складах
     * (для вывода в карточке товара)
     *
     * @param int $productID
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByProductsOnWarehouses($productID = false) {
        $balance = new ShopStorageBalance();

        if ($productID) {
            $balance->setProductid($productID);
        }

        $storageNames = StorageNameService::Get()->getStorageNamesWarehouses();
        $storageNameIDArray = array(-1);
        while ($storageName = $storageNames->getNext()) {
            $storageNameIDArray[] = $storageName->getId();
        }

        $balance->addWhereQuery('(`storagenameid` IN ('.implode(',', $storageNameIDArray).'))');

        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amount`) AS `amount`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`amountlinked`) AS `amountlinked`');
        $balance->addFieldQuery('SUM(`shopstoragebalance`.`cost`) AS `cost`');

        $balance->setGroupByQuery('productid');
        return $balance;
    }

    /**
     * Получить количество заданного товара на складах
     *
     * @param ShopProduct $product
     *
     * @return float
     */
    public function getBalanceByProductOnWarehouses(ShopProduct $product) {
        $balance = $this->getBalanceByProductsOnWarehouses($product->getId());
        while ($b = $balance->getNext()) {
            try {
                $amount = $b->getField('amount') - $b->getField('amountlinked');
                return $amount;
            } catch (Exception $e) {

            }
        }

        return false;
    }

    /**
     * Получить остатки, которые можно зарезервировать
     * (т.е. количество данного товара на складе для продажи)
     *
     * @param ShopProduct $product
     * @param User $cuser
     *
     * @return ShopStorageBalance
     */
    public function getBalanceByProductForReserve(ShopProduct $product, $cuser = false, $storageId  = false) {
        // баланс товара
        $balance = $this->getBalanceByProduct($product, $cuser);

        // находим нужный склад
        // (первый для продажи)
        if ($storageId) {
            $storageName = StorageNameService::Get()->getStorageNameByID($storageId);
        } else {
            $storageName = StorageNameService::Get()->getStorageNamesForSale()->getNext();
        }

        if ($storageName) {
            $balance->setStoragenameid($storageName->getId());
        } else {
            $balance->setId(false);
        }

        return $balance;
    }

    /**
     * Получить баланс для отчета по резерву
     *
     * @param User $cuser
     * @param ShopStorageName $storageName
     * @param ShopProduct $product
     *
     * @return ShopStorageBalance
     */
    public function getBalanceReserveReport(User $cuser, ShopStorageName $storageName, ShopProduct $product) {
        $cuser;
        $balance = new ShopStorageBalance();
        $balance->setStoragenameid($storageName->getId());
        $balance->setProductid($product->getId());

        // и только товар который ЕСТЬ на складе
        $balance->addWhereQuery('(`amount` > 0)');

        $balance->setOrder('cdate', 'ASC');

        return $balance;
    }

    /**
     * Получить "Закупки у поставщиков"
     *
     * @param User $cuser
     * @param ShopStorageName $vendor
     * @param array $productIDArray
     * @param ShopCategory $category
     * @param string $datefrom
     * @param string $dateto
     * @param array $contractorIDArray
     *
     * @return ShopStorage
     */
    public function getBalanceVendors(User $cuser, ShopStorageName $vendor,
    $productIDArray, $category, $datefrom, $dateto, $contractorIDArray) {
        if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $vendor, 'read')) {
            throw new ServiceUtils_Exception('user');
        }

        $x = new ShopStorage();
        $x->setStoragenamefromid($vendor->getId());
        $x->addFieldQuery('SUM(`shopstorage`.`amount`) AS `amount`');
        $x->addFieldQuery('SUM(`shopstorage`.`pricebase` * `shopstorage`.`amount`) AS `cost`');

        // определяем склады, на которые пользователю можно смотреть
        $storagenameallowedArray = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read');
        $storagenameidArray = array();
        $storagenames = StorageNameService::Get()->getStorageNamesForTransfers();
        while ($storagename = $storagenames->getNext()) {
            if (in_array($storagename->getId(), $storagenameallowedArray)) {
                $storagenameidArray[] = $storagename->getId();
            }
        }
        $x->addWhereQuery('(`storagenametoid` IN ('.implode(',', $storagenameidArray).'))');

        if ($category) {
            $products = new ShopProduct();
            $x->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');

            $level = $category->getLevel();
            $x->addWhere('`shopproduct`.`category'.$level.'id`', $category->getId(), '=');
        }

        if ($productIDArray) {
            $x->addWhereQuery('`shopstorage`.`productid` IN ('.implode(',', $productIDArray).')');
        }

        if ($contractorIDArray) {
            $x->addWhereQuery('`shopstorage`.`contractorid` IN ('.implode(',', $contractorIDArray).')');
        }

        // дата с
        if ($datefrom) {
            $x->addWhereQuery('( DATE(`shopstorage`.`date`) >= \''.$datefrom.'\' )');
        }

        // дата по
        if ($dateto) {
            $x->addWhereQuery('( DATE(`shopstorage`.`date`) <= \''.$dateto.'\' )');
        }

        $x->setOrder('`shopstorage`.`productname`');
        $x->setGroupByQuery('`shopstorage`.`storagenametoid`, `shopstorage`.`productid`, `shopstorage`.`shipment`');

        return $x;
    }

    /**
     * Получить "Продажи"
     *
     * @param User $cuser
     * @param array $productIDArray
     * @param ShopCategory $category
     * @param string $datefrom
     * @param string $dateto
     *
     * @return ShopStorage
     */
    public function getBalanceSales(User $cuser, $productIDArray, $category, $datefrom, $dateto) {
        $sold = StorageNameService::Get()->getStorageNameSold();

        if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $sold, 'read')) {
            throw new ServiceUtils_Exception('user');
        }

        $x = new ShopStorage();
        $x->setStoragenametoid($sold->getId());
        $x->addFieldQuery('SUM(`shopstorage`.`amount`) AS `amount`');
        $x->addFieldQuery('SUM(`shopstorage`.`pricebase` * `shopstorage`.`amount`) AS `cost`');

        // определяем склады, на которые пользователю можно смотреть
        $storagenameallowedArray = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read');
        $storagenameidArray = array();
        $storagenames = StorageNameService::Get()->getStorageNamesForTransfers();
        while ($storagename = $storagenames->getNext()) {
            if (in_array($storagename->getId(), $storagenameallowedArray)) {
                $storagenameidArray[] = $storagename->getId();
            }
        }
        $x->addWhereQuery('(`storagenamefromid` IN ('.implode(',', $storagenameidArray).'))');

        if ($category) {
            $products = new ShopProduct();
            $x->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');

            $level = $category->getLevel();
            $x->addWhere('`shopproduct`.`category'.$level.'id`', $category->getId(), '=');
        }

        if ($productIDArray) {
            $x->addWhereQuery('`shopstorage`.`productid` IN ('.implode(',', $productIDArray).')');
        }

        // дата с
        if ($datefrom) {
            $x->addWhereQuery('( DATE(`shopstorage`.`date`) >= \''.$datefrom.'\' )');
        }

        // дата по
        if ($dateto) {
            $x->addWhereQuery('( DATE(`shopstorage`.`date`) <= \''.$dateto.'\' )');
        }

        $x->setOrder('`shopstorage`.`productname`');
        $x->setGroupByQuery('`shopstorage`.`storagenamefromid`, `shopstorage`.`productid`');

        return $x;
    }

    /**
     * Обновить таблицу "баланс"
     *
     * @param ShopStorageName $storageName
     * @param ShopProduct $product
     * @param string $code
     * @param string $serial
     */
    public function updateBalance(ShopStorageName $storageName, ShopProduct $product, $code = false) {

        // обновляем старые записи баланса

        $balance = new ShopStorageBalance();
        $balance->setStoragenameid($storageName->getId());
        $balance->setProductid($product->getId());
        if ($code) {
            $balance->setCode($code);
        }

        while ($b = $balance->getNext()) {
            // посчитать баланс
            $storage = $this->_getBalanceByLog(
                $b->getStorageName(),
                $b->getProduct(),
                $b->getCode()
            );

            $x = $storage->getNext();
            if (!$x) {
                // если таких товаров больше нет - удалить и баланс
                $b->delete();
            } else {
                // обновить
                $b->setPricebase($x->getPricebase());
                $b->setAmount($x->getAmount());
                $b->setCost($x->getField('cost'));
                $b->setShipment($x->getShipment());
                $b->setProductname($product->getName());
                $b->setPrice($x->getPrice());
                $b->setCurrencyid($x->getCurrencyid());
                $b->setCurrencyrate($x->getCurrencyrate());
                $b->setTaxrate($x->getTaxrate());
                $b->update();
            }
        }

        // добавляем новые записи баланса

        // посчитать баланс товара
        $storage = $this->_getBalanceByLog($storageName, $product, $code);

        while ($x = $storage->getNext()) {
            $y = new XShopStorageBalance();
            $y->setStoragenameid($x->getStoragenametoid());
            $y->setProductid($x->getProductid());
            $y->setCode($x->getCode());
            $y->setSerial($x->getSerial());
            if (!$y->select()) {
                $y->setPricebase($x->getPricebase());
                $y->setAmount($x->getAmount());
                $y->setCost($x->getField('cost'));
                $y->setShipment($x->getShipment());
                $y->setProductname($product->getName());
                $y->setPrice($x->getPrice());
                $y->setCurrencyid($x->getCurrencyid());
                $y->setCurrencyrate($x->getCurrencyrate());
                $y->setTaxrate($x->getTaxrate());
                $y->setCdate($x->getCdate());
                $y->insert();
            }
        }
    }

    /**
     * Обновить таблицу "баланс" (поле amount linked)
     *
     * @param ShopStorageBalance $balance
     *
     * @return ShopStorageBalance
     */
    public function updateBalanceLinked(ShopStorageBalance $balance) {
        $links = StorageLinkService::Get()->getLinksByBalance($balance);
        $links->addFieldQuery('SUM(`amount`) AS `amount`');
        $links->setGroupByQuery('storagebalanceid');
        $link = $links->getNext();
        $amount = 0;
        if ($link) {
            $amount = $link->getAmount();
        }
        $balance->setAmountlinked($amount);
        $balance->update();
        return $balance;
    }

    /**
     * Получить остатки на складах
     * (группируем по товару/коду)
     * метод нужен для обновления кеширующей таблицы "баланс"
     *
     * @param ShopStorageName $storageName
     * @param ShopProduct $product
     * @param string $code
     * @param string $serial
     *
     * @return ShopStorage
     */
    private function _getBalanceByLog($storageName = false, $product = false, $code = false) {

        $x = new ShopStorage();
        $x->addFieldQuery('SUM(`shopstorage`.`amount`) AS `amount`');
        $x->addFieldQuery('SUM(`shopstorage`.`pricebase` * `shopstorage`.`amount`) AS `cost`');

        if ($storageName) {
            $x->setStoragenametoid($storageName->getId());
        }

        if ($product) {
            $x->setProductid($product->getId());
        }

        if ($code) {
            $x->setCode($code);
        }

        $x->setGroupByQuery('`shopstorage`.`storagenametoid`, `shopstorage`.`code`');
        $x->setOrder('cdate', 'ASC');
        return $x;
    }

    /**
     * Движение по складам
     * Отчет об изменении баланса
     *
     * @param array $storageNameIDArray
     * @param User $cuser
     * @param date $datefrom
     * @param date $dateto
     * @param int $limitFrom
     * @param int $limitCount
     *
     * @return array
     */
    public function getBalanceMotion($storageNameIDArray, User $cuser,
    $datefrom, $dateto, $limitFrom = 0, $limitCount = false) {
        if ($cuser->getLevel() == 2) {

            // проверка прав
            $storageIDs = StorageNameService::Get()->getStorageNameIDsArrayByUser(
                $cuser,
                'read'
            );

            // удаляем склады, на которые нет прав
            foreach ($storageNameIDArray as $k => $storageNameID) {
                if (!in_array($storageNameID, $storageIDs)) {
                    unset($storageNameIDArray[$k]);
                }
            }
        }

        if (!$storageNameIDArray) {
            // если не выбран ни один склад
            throw new ServiceUtils_Exception('nostorage');
        }

        // проверка дат
        if ($datefrom > $dateto) {
            throw new ServiceUtils_Exception();
        }

        // товары
        $storageProducts = new ShopStorage();

        if ($storageNameIDArray) {
            $storageProducts->addWhereQuery('(`storagenametoid` IN ('.implode(', ', $storageNameIDArray).'))');
        }
        $storageProducts->addWhereQuery('( DATE(`date`) <= \''.$dateto.'\' )');
        $storageProducts->addWhereQuery('( DATE(`date`) >= \''. $datefrom.'\' ) ');
        $storageProducts->setGroupByQuery('productid');
        $storageProducts->setOrder('productname');

        if ($limitCount) {
            $storageProducts->setLimit($limitFrom, $limitCount);
        }

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $all_sum_was = $all_sum_plus = $all_sum_minus = $all_sum_became = 0;
        $all_was = $all_plus = $all_minus = $all_became = 0;

        // переменные для степпера
        $i = 0;
        $onPage = $limitCount/3+1;

        $a = array();
        // по каждому товару смотрим изменения
        while ($p = $storageProducts->getNext()) {
            $i++;
            if ($i >= $onPage) {
                continue;
            }

            try {
                $productID = $p->getProductid();
                if ($p->getProduct()->getDeleted()) {
                    continue;
                }

                $storages = new ShopStorage();
                $storages->setProductid($productID);
                if ($storageNameIDArray) {
                    $storages->addWhereQuery('(`storagenametoid` IN ('.implode(', ', $storageNameIDArray).'))');
                }

                $storage = clone $storages;
                $storage->addWhereQuery('( DATE(`date`) < \''.$datefrom.'\' )');

                $was = 0;
                $was_sum = 0;
                while ($s = $storage->getNext()) {
                    $was += $s->getAmount();
                    if ($s->getPrice() > 0) {
                        $price = $s->getPrice();

                        $was_sum += Shop::Get()->getCurrencyService()->convertCurrency(
                            $s->getAmount() * $price,
                            $s->getCurrency(),
                            $currencyDefault
                        );
                    }
                }

                $storage = clone $storages;
                $storage->addWhereQuery('( DATE(`date`) >= \''. $datefrom.'\' ) ');
                $storage->addWhereQuery('( DATE(`date`) <= \''. $dateto.'\' ) ');

                $plus = $minus = $plus_sum = $minus_sum = $returned_plus = 0;
                $returned_plus_sum = $returned_minus = $returned_minus_sum = 0;

                while ($s = $storage->getNext()) {
                    $sum = 0;
                    if ($s->getPrice() > 0) {
                        $price = $s->getPrice();

                        $sum = Shop::Get()->getCurrencyService()->convertCurrency(
                            $s->getAmount() * $price,
                            $s->getCurrency(),
                            $currencyDefault
                        );
                    }
                    if ($s->getAmount() > 0) {
                        if ($s->getReturn()) {
                            $returned_plus += $s->getAmount();
                            $returned_plus_sum += $sum;
                        } else {
                            $plus += $s->getAmount();
                            $plus_sum += $sum;
                        }
                    }
                    if ($s->getAmount() < 0) {
                        if ($s->getReturn()) {
                            $returned_minus += $s->getAmount();
                            $returned_minus_sum += $sum;
                        } else {
                            $minus += $s->getAmount();
                            $minus_sum += $sum;
                        }
                    }
                }

                $plus = $plus + $returned_minus;
                $plus_sum = $plus_sum + $returned_minus_sum;

                $minus = $minus + $returned_plus;
                $minus_sum = $minus_sum + $returned_plus_sum;

                $became = $was + $plus + $minus;
                $became_sum = $was_sum + $plus_sum + $minus_sum;

                //if ($plus != 0 || $minus != 0) {
                $a[] = array(
                'productid' => $productID,
                'productname' => $p->getProduct()->getName(),
                'was' => number_format($was, 3),
                'was_sum' => number_format($was_sum, 2),
                'plus' => number_format($plus, 3),
                'plus_sum' => number_format($plus_sum, 2),
                'minus' => number_format(-$minus, 3),
                'minus_sum' => number_format(-$minus_sum, 2),
                'became' => number_format($became, 3),
                'became_sum' => number_format($became_sum, 2),
                'currency' => $currencyDefault->getSymbol(),
                'green' => ($plus > 0 && $plus > -$minus),
                'red' => (-$minus > 0 && -$minus > $plus),
                'hidden' => ($p->getProduct()->getHidden() && $became == 0),
                'productURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $productID)
                );
                //}

                $all_sum_was += $was_sum;
                $all_sum_plus += $plus_sum;
                $all_sum_minus += $minus_sum;
                $all_sum_became += $became_sum;

                $all_was += $was;
                $all_plus += $plus;
                $all_minus += $minus;
                $all_became += $became;
            } catch (Exception $e) {

            }

        }

        if ($a) {
            $a[] = array(
            'productname' => 'Итого:',
            'was_sum' => number_format($all_sum_was, 2),
            'plus_sum' => number_format($all_sum_plus, 2),
            'minus_sum' => number_format(-$all_sum_minus, 2),
            'became_sum' => number_format($all_sum_became, 2),
            'was' => number_format($all_was, 3),
            'plus' => number_format($all_plus, 3),
            'minus' => number_format(-$all_minus, 3),
            'became' => number_format($all_became, 3),
            'currency' => $currencyDefault->getSymbol()
            );
        }

        return array('result' => $a, 'count' => $i);

    }

    /**
     * GetStorageReserve
     *
     * @param int $storageNameID
     * @param int $productID
     *
     * @return ShopStorageReserve
     */
    public function getStorageReserve($storageNameID, $productID) {
        $reserves = new ShopStorageReserve();
        $reserves->setStoragenameid($storageNameID);
        $reserves->setProductid($productID);

        if ($x = $reserves->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить минимальный резерв
     *
     * @param array $storageNameIDArray
     * @param array $productIDArray
     * @param ShopCategory $category
     * @param string $productName
     *
     * @return ShopStorageReserve
     */
    public function getStorageReserves($storageNameIDArray, $productIDArray, $category, $productName) {
        $reserves = new ShopStorageReserve();

        if ($storageNameIDArray) {
            $reserves->addWhereArray($storageNameIDArray, 'storagenameid');
        }

        if ($productIDArray) {
            $reserves->addWhereArray($productIDArray, 'productid');
        }

        if ($category) {
            $products = new ShopProduct();
            $reserves->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');

            $level = $category->getLevel();
            $reserves->addWhere('`shopproduct`.`category'.$level.'id`', $category->getId(), '=');
        }

        if ($productName) {
            $productName = '%'.str_replace(' ', '%', $productName).'%';

            $products = new ShopProduct();
            $reserves->leftJoinTable($products->getTablename(), 'productid='.$products->getTablename().'.id');
            $reserves->addWhereQuery(
                '(`'.$products->getTablename().'`.`id` LIKE \''.
                $productName.'\' OR `'.$products->getTablename().'`.`name` LIKE \''.
                $productName.'\' OR `'.$products->getTablename().'`.`articul` LIKE \''.
                $productName.'\' OR `'.$products->getTablename().'`.`model` LIKE \''.$productName.'\')'
            );
        }

        return $reserves;
    }

    /**
     * GetProductStrorageRRC
     *
     * @param ShopProduct $product
     * @param ShopStorageName $storageName
     * @param ShopCurrency $currency
     *
     * @return decimal
     */
    public function getProductStrorageRRC(ShopProduct $product, ShopStorageName $storageName, ShopCurrency $currency) {
        $x = $this->getStorageReserve($storageName->getId(), $product->getId());
        $rrc = Shop::Get()->getCurrencyService()->convertCurrency($x->getRrc(), $x->getCurrency(), $currency);
        return $rrc;
    }

    /**
     * Обновить/добавить значение минимального резерва
     *
     * @param int $storagenameID
     * @param int $productID
     * @param decimal $amount
     * @param decimal $rrc
     * @param int $currencyID
     *
     * @return ShopStorageReserve
     */
    public function updateStorageReserve($storagenameID, $productID, $amount, $rrc, $currencyID) {
        try {
            SQLObject::TransactionStart();

            if (!$storagenameID || !$productID || $amount < 0) {
                throw new ServiceUtils_Exception();
            }

            $reserve = new ShopStorageReserve();
            $reserve->setStoragenameid($storagenameID);
            $reserve->setProductid($productID);
            if ($reserve->select()) {
                $reserve->setAmount($amount);
                $reserve->setRrc($rrc);
                $reserve->setCurrencyid($currencyID);
                $reserve->update();
            } else {
                $reserve->setAmount($amount);
                $reserve->setRrc($rrc);
                $reserve->setCurrencyid($currencyID);
                $reserve->insert();
            }

            SQLObject::TransactionCommit();

            return $reserve;
        } catch (ServiceUtils_Exception $se) {
            SQLObject::TransactionRollback();
            throw $se;
        }
    }

    public function getBalanceByForSearch(User $cuser, $storageNameIDArray) {
        $balance = new ShopStorageBalance();

        $storageNameIDAllowed = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'read');
        $storageNameIDArray[] = -1;

        if ($storageNameIDArray) {
            foreach ($storageNameIDArray as $k => $v) {
                if (!in_array($v, $storageNameIDAllowed)) {
                    unset($storageNameIDArray[$k]);
                }
            }
        }

        if (!$storageNameIDArray) {
            $storageNameIDArray = $storageNameIDAllowed;
        }

        $balance->addWhereQuery('`shopstoragebalance`.`storagenameid` IN ('.implode(',', $storageNameIDArray).')');
        $balance->addWhere('amount', 0, '>');

        $p = new ShopProduct();
        $balance->leftJoinTable($p->getTablename(), 'productid='.$p->getTablename().'.id');

        return $balance;
    }

    /**
     * Поиск товаров на складе
     *
     * @param string $query
     * @param User $cuser
     *
     * @return ShopStorageBalance
     */
    public function searchProducts($query, User $cuser) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $storagenames = StorageNameService::Get()->getStorageNamesForSaleByUser($cuser);
        $storagenameIDArray = array();
        while ($storagename = $storagenames->getNext()) {
            $storagenameIDArray[] = $storagename->getId();
        }

        $products = StorageBalanceService::Get()->getBalanceByForSearch(
            $cuser,
            $storagenameIDArray
        );

        $p = new ShopProduct();

        $connection = $products->getConnectionDatabase();

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

        foreach ($a as $part) {
            $w = array();
            $orderBy = array();

            if (is_numeric($part)) {
                $w[] = $products->getTablename().".productid = '$part'";
                // если длинна строки == 13 - значит поиск по штрих-коду
                if (strlen($part) == 13) {
                    $w[] = $p->getTablename().".barcode = '$part'";
                }
            }
            if (Shop::Get()->getSettingsService()->getSettingValue('use-code-1c')) {
                $w[] = $p->getTablename().".code1c LIKE '%$part%'";
            }
            $w[] = $products->getTablename().".productname LIKE '%$part%'";
            $w[] = $products->getTablename().".serial LIKE '%$part%'";
            $w[] = $p->getTablename().".seokeywords LIKE '%$part%'";
            $w[] = $p->getTablename().".description LIKE '%$part%'";

            $orderBy[] = "(CASE WHEN {$products->getTablename()}.`productname` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = $products->getTablename().".productname LIKE '%$partTr%'";
                $w[] = $products->getTablename().".serial LIKE '%$partTr%'";
                $w[] = $p->getTablename().".seokeywords LIKE '%$partTr%'";
                $w[] = $p->getTablename().".description LIKE '%$partTr%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`productname` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = $products->getTablename().".productname LIKE '%$partRu%'";
                $w[] = $products->getTablename().".serial LIKE '%$partRu%'";
                $w[] = $p->getTablename().".seokeywords LIKE '%$partRu%'";
                $w[] = $p->getTablename().".description LIKE '%$partRu%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`productname` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = $products->getTablename().".productname LIKE '%$partEn%'";
                $w[] = $products->getTablename().".serial LIKE '%$partEn%'";
                $w[] = $p->getTablename().".seokeywords LIKE '%$partEn%'";
                $w[] = $p->getTablename().".description LIKE '%$partEn%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`productname` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {

            }

            $products->addWhereQuery("(".implode(' OR ', $w).")");
        }

        $products->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $products->setOrder('`relevance`', 'DESC');

        return $products;
    }

    /**
     * Обновить в товарах остатки на складах.
     * Возвращает массив ID товаров которые есть на складах.
     *
     * @return array
     */
    public function updateProductsAvailable($updateUnavail = true) {
        try {
            SQLObject::TransactionStart(false, true);

            /**
             * Внимание! Метод будет считать только те товары, которы
             * реально есть или были на складах.
             * Если товара никогда не было на складах - то
             * getBalanceByProductsOnWarehouses не вернет productID's
             */

            $balance = $this->getBalanceByProductsOnWarehouses();
            $availProductArray = array();
            while ($b = $balance->getNext()) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID(
                        $b->getProductid()
                    );

                    // пропускаем не_синхронизируемые товары
                    if ($product->getUnsyncable()) {
                        continue;
                    }

                    $amount = $b->getField('amount') - $b->getField('amountlinked');

                    if ($amount > 0) {
                        $product->setAvail($amount);
                        $product->setAvailtext('');
                        $product->update();

                        $availProductArray[] = $product->getId();
                    } elseif ($updateUnavail) {
                        $product->setAvail(0);
                        $product->setAvailtext('');
                        $product->update();
                    }
                } catch (Exception $e) {

                }
            }

            SQLObject::TransactionCommit();

            return $availProductArray;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Get
     *
     * @return StorageBalanceService
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