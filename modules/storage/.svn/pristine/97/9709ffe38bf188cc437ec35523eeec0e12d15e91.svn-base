<?php
class storage_balance_employees extends Engine_Class {

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
                $storageNames = StorageNameService::Get()->getStorageNamesEmployeesByUser($cuser);
                while ($storageName = $storageNames->getNext()) {
                    $storageNameIDArray[] = $storageName->getId();
                }
            }

            try {
                $balance = StorageBalanceService::Get()->getBalanceByStorage(
                $cuser,
                $storageNameIDArray,
                false,
                $category,
                $this->getControlValue('productname'),
                $this->getControlValue('serial'),
                $this->getControlValue('showdetailed')
                );

                $amount_total = 0;
                $amountlinked_total = 0;
                $cost_total = 0;
                $tmp = 0;
                $a = array();

                while ($x = $balance->getNext()) {
                    try {
                        $tmp = $x->getStoragenameid();

                        $categoryName = '';
                        try {
                            $categoryName = $x->getProduct()->getCategory()->makePathName();
                        } catch (ServiceUtils_Exception $ce) {

                        }

                        $a[$tmp]['productArray'][] = array(
                        'productid' => $x->getProductid(),
                        'productname' => $x->getProduct()->makeName(),
                        'categoryname' => $categoryName,
                        'amount' => $x->getAmount(),
                        'amountlinked' => $x->getAmountlinked(),
                        'cost' => $x->getCost(),
                        'serial' => $x->getSerial(),
                        'productURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-products-edit', $x->getProductid()),
                        'reserveURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-reserve', $x->getId(), 'balanceid'),
                        'historyURL' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-motion-balance-history', $x->getId(), 'balanceid')
                        );

                        @$a[$tmp]['amount'] += $x->getAmount();
                        @$a[$tmp]['amountlinked'] += $x->getAmountlinked();
                        @$a[$tmp]['cost'] += $x->getCost();

                        if (!isset($a[$tmp]['storagename'])) {
                            $a[$tmp]['storagename'] = $x->getStorageName()->getName();
                        }

                        $amount_total += $x->getAmount();
                        $amountlinked_total += $x->getAmountlinked();
                        $cost_total += $x->getCost();
                    } catch (ServiceUtils_Exception $see) {

                    }
                }

                $this->setValue('storageArray', $a);
                $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());

                $totalArray = array(
                'amount' => $amount_total,
                'amountlinked' => $amountlinked_total,
                'cost' => $cost_total
                );

                $this->setValue('totalArray', $totalArray);
            } catch (ServiceUtils_Exception $se) {

            }

            // склады
            $storageNames = StorageNameService::Get()->getStorageNamesEmployeesByUser($cuser);
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

            // выбранные склады
            $this->setValue('storagenameSelectedArray', $this->getArgumentSecure('storagenameid', 'array'));

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}