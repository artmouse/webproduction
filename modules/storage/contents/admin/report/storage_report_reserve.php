<?php
class storage_report_reserve extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();

            // фильтры
            $categoryID = $this->getControlValue('categoryid');
            $category = false;
            if ($categoryID) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $storageNameIDArray = $this->getArgumentSecure('storagenameid', 'array');
            if (!$storageNameIDArray) {
                $storageNames = StorageNameService::Get()->getStorageNamesWarehousesByUser($cuser);
                while ($storageName = $storageNames->getNext()) {
                    $storageNameIDArray[] = $storageName->getId();
                }
            }

            if ($this->getControlValue('add')) {
                try {
                    StorageBalanceService::Get()->updateStorageReserve(
                    $this->getControlValue('storagenameid'),
                    $this->getControlValue('productid'),
                    $this->getControlValue('amount'),
                    $this->getControlValue('rrc'),
                    $this->getControlValue('currencyid')
                    );
                } catch (ServiceUtils_Exception $se) {

                }
            }

            try {
                // сначала находим резерв по тем товарам, которые есть на складе
                $balance = StorageBalanceService::Get()->getBalanceByStorage(
                $cuser,
                $storageNameIDArray,
                false,
                $category,
                $this->getControlValue('productname')
                );

                $reserve = new ShopStorageReserve();
                $balance->leftJoinTable($reserve->getTablename(), $balance->getTablename().'.`storagenameid` = '.$reserve->getTablename().'.`storagenameid` AND '.$balance->getTablename().'.`productid` = '.$reserve->getTablename().'.`productid`');
                $balance->addFieldQuery($reserve->getTablename().'.`amount` AS reserve_amount');
                $balance->addFieldQuery($reserve->getTablename().'.`rrc` AS reserve_rrc');
                $balance->addFieldQuery($reserve->getTablename().'.`currencyid` AS reserve_currencyid');

                $a = array();
                while ($x = $balance->getNext()) {
                    try {
                        $tmp = $x->getStoragenameid();
                        if (!isset($a[$tmp]['storagename'])) {
                            $a[$tmp]['storagename'] = $x->getStorageName()->getName();
                            $a[$tmp]['storagenameid'] = $x->getStoragenameid();
                        }

                        $categoryName = '';
                        try {
                            $categoryName = $x->getProduct()->getCategory()->makePathName();
                        } catch (ServiceUtils_Exception $ce) {

                        }

                        $currencyName = '';
                        try {
                            $currencyID = $x->getField('reserve_currencyid');
                            $currencyName = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID)->getSymbol();
                        } catch (ServiceUtils_Exception $ce) {

                        }

                        $reserveAmount = 0;
                        $reservePercent = 0;
                        $reservePlenty = false;
                        $reserveLack = false;

                        if ($x->getField('reserve_amount') > 0) {
                            $reserveAmount = $x->getField('reserve_amount');
                            $reservePercent = $x->getAmount() * 100 / $reserveAmount;
                            $reservePlenty = (($x->getAmount() / $reserveAmount) > 2);
                            $reserveLack = ($reserveAmount > $x->getAmount());
                        }

                        $a[$tmp]['productArray'][$x->getProductid()] = array(
                        'productid' => $x->getProductid(),
                        'productname' => $x->getProduct()->makeName(),
                        'categoryname' => $categoryName,
                        'amount' => $x->getAmount(),
                        'productURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $x->getProductid()),
                        'historyURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-balance-history', $x->getId(), 'balanceid'),
                        'reserve' => $reserveAmount,
                        'percent' => $reservePercent,
                        'plenty' => $reservePlenty,
                        'lack' => $reserveLack,
                        'rrc' => $x->getField('reserve_rrc'),
                        'currencyid' => $x->getField('reserve_currencyid'),
                        'currency' => $currencyName
                        );

                    } catch (ServiceUtils_Exception $see) {

                    }
                }

                // добавляем товары, которых на складе нет, но мин резерв задан
                $reserves = StorageBalanceService::Get()->getStorageReserves(
                $storageNameIDArray,
                false,
                $category,
                $this->getControlValue('productname')
                );

                while ($x = $reserves->getNext()) {
                    try {
                        $tmp = $x->getStoragenameid();

                        if (isset($a[$tmp]['productArray'][$x->getProductid()])) {
                            continue;
                        }

                        if ($x->getAmount() <= 0) {
                            continue;
                        }

                        if (!isset($a[$tmp]['storagename'])) {
                            $a[$tmp]['storagename'] = $x->getStorageName()->getName();
                            $a[$tmp]['storagenameid'] = $x->getStoragenameid();
                        }

                        $categoryName = '';
                        try {
                            $categoryName = $x->getProduct()->getCategory()->makePathName();
                        } catch (ServiceUtils_Exception $ce) {

                        }

                        $currencyName = '';
                        try {
                            $currencyName = $x->getCurrency()->getSymbol();
                        } catch (ServiceUtils_Exception $ce) {

                        }

                        $a[$tmp]['productArray'][] = array(
                        'productid' => $x->getProductid(),
                        'productname' => $x->getProduct()->makeName(),
                        'categoryname' => $categoryName,
                        'amount' => 0,
                        'productURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $x->getProductid()),
                        'reserve' => $x->getAmount(),
                        'percent' => 0,
                        'lack' => ($x->getAmount() > 0),
                        'rrc' => $x->getRrc(),
                        'currencyid' => $x->getCurrencyid(),
                        'currency' => $currencyName
                        );
                    } catch (ServiceUtils_Exception $see) {

                    }
                }

                $this->setValue('storageArray', $a);
                $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());
            } catch (ServiceUtils_Exception $se) {

            }

            // склады
            $storageNames = StorageNameService::Get()->getStorageNamesWarehousesByUser($cuser);
            $this->setValue('storageNamesArray', $storageNames->toArray());

            // список категорий
            $category = Shop::Get()->getShopService()->makeCategoryTree();
            $a = array();
            foreach ($category as $x) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(),
                'hidden' => $x->getHidden(),
                'level' => $x->getField('level'),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
                );
            }
            $this->setValue('categoryArray', $a);

            // валюты
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // выбранные склады
            $this->setValue('storagenameSelectedArray', $this->getArgumentSecure('storagenameid', 'array'));

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}