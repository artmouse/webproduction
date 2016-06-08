<?php
class storage_balance_sales extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/ajaxproduct.js');
            PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/product_filter_autocomplete.js');

            $cuser = $this->getUser();

            // фильтры
            $productIDArray = array();
            if ($this->getArgumentSecure('productid')) {
                $productIDArray = explode(',', $this->getArgumentSecure('productid'));
            }

            $categoryID = $this->getControlValue('categoryid');
            $category = false;
            if ($categoryID) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {

                }
            }

            // фильтр по дате
            $datefrom = $dateto = false;
            if ($this->getControlValue('datefrom')) {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
            }
            if ($this->getControlValue('dateto')) {
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));
            }

            try {
                $storageName = StorageNameService::Get()->getStorageNameSold();
                if (!StorageNameService::Get()->isStorageOperationAllowed($cuser, $storageName, 'read')) {
                    throw new ServiceUtils_Exception();
                }

                // получаем складские записи сгруппированные по
                // складу-магазину + товару
                $storage = StorageBalanceService::Get()->getBalanceSales(
                $cuser,
                $productIDArray,
                $category,
                $datefrom,
                $dateto
                );

                // формируем массив вида:
                // [id склада-получателя]
                //    [product_amount]
                //    [product_cost]
                //    [productArray]
                //        [id товара]
                //            [product_amount]
                //            [product_cost]
                $a = array();

                // текущие склад/товар
                $tmpStoragenameid = 0;
                $tmpProductid = 0;

                // количество/стоимость всего
                $amount_total = 0;
                $cost_total = 0;

                while ($x = $storage->getNext()) {
                    try {
                        $tmpStoragenameid = $x->getStoragenamefromid();
                        $tmpProductid = $x->getProductid();

                        if (!isset($a[$tmpStoragenameid]['storageName'])) {
                            $a[$tmpStoragenameid]['storageName'] = $x->getStorageNameFrom()->getName();
                        }
                        @$a[$tmpStoragenameid]['productAmount'] += $x->getAmount();
                        @$a[$tmpStoragenameid]['productCost'] += $x->getField('cost');
                        @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productAmount'] += $x->getAmount();
                        @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productCost'] += $x->getField('cost');
                        @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productName'] = $x->getProduct()->makeName();
                        $a[$tmpStoragenameid]['productArray'][$tmpProductid]['productId'] = $tmpProductid;

                        $amount_total += $x->getAmount();
                        $cost_total += $x->getField('cost');
                    } catch (ServiceUtils_Exception $see) {

                    }
                }

                $this->setValue('storageArray', $a);
                $this->setValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getSymbol());

                $totalArray = array(
                'amount' => $amount_total,
                'cost' => $cost_total
                );

                $this->setValue('totalArray', $totalArray);

            } catch (ServiceUtils_Exception $se) {
                //print $se;

            }

            // категории
            $categories = Shop::Get()->getShopService()->getCategoryAll();
            $this->setValue('categoryArray', $categories->toArray());

            // выбранные товары
            $productArray = array();
            foreach ($productIDArray as $productID) {
                try {
                    $productArray[] = array(
                    'id' => $productID,
                    'text' => Shop::Get()->getShopService()->getProductByID($productID)->makeName()
                    );
                } catch (ServiceUtils_Exception $pe) {

                }
            }
            $this->setValue('productArray', $productArray);

            // даты по умолчанию - последние 2 недели
            if (!$datefrom && !$dateto) {
                $this->setControlValue('dateto', date('Y-m-d'));
                $this->setControlValue('datefrom', DateTime_Object::FromString(date('Y-m-d'))->addDay(-14)->setFormat('Y-m-d')->__toString());
            }

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

}