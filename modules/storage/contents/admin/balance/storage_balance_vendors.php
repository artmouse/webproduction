<?php
class storage_balance_vendors extends Engine_Class {

    public function process() {
        try {
            PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/ajaxproduct.js');
            PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/product_filter_autocomplete.js');

            $cuser = $this->getUser();

            // фильтры

            // по товару
            $productIDArray = array();
            if ($this->getArgumentSecure('productid')) {
                $productIDArray = explode(',', $this->getArgumentSecure('productid'));
            }

            // по юр лицу
            $contractorIDArray = $this->getArgumentSecure('contractorid', 'array');

            // по категории
            $categoryID = $this->getControlValue('categoryid');
            $category = false;
            if ($categoryID) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                } catch (ServiceUtils_Exception $se) {

                }
            }

            // по дате
            $datefrom = $dateto = false;
            if ($this->getControlValue('datefrom')) {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
            }
            if ($this->getControlValue('dateto')) {
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));
            }

            // если выбран поставщик
            if ($storageNameID = $this->getArgumentSecure('storagenameid')) {
                try {
                    // получаем поставщика
                    $storageName = StorageNameService::Get()->getStorageNameByID(
                    $storageNameID
                    );

                    // проверка, поставщик ли это
                    if (!$storageName->getIsvendor()) {
                        throw new ServiceUtils_Exception();
                    }

                    // получаем складские записи сгруппированные по:
                    // складу-получателю + товару + коду партии
                    $storage = StorageBalanceService::Get()->getBalanceVendors(
                    $cuser,
                    $storageName,
                    $productIDArray,
                    $category,
                    $datefrom,
                    $dateto,
                    $contractorIDArray
                    );

                    // формируем массив вида:
                    // [id склада-получателя]
                    //    [product_amount]
                    //    [product_cost]
                    //    [productArray]
                    //        [id товара]
                    //            [product_amount]
                    //            [product_cost]
                    //            [shipmentArray]
                    $a = array();

                    // текущие склад/товар
                    $tmpStoragenameid = 0;
                    $tmpProductid = 0;

                    // количество/стоимость всего
                    $amount_total = 0;
                    $cost_total = 0;

                    while ($x = $storage->getNext()) {
                        try {
                            $tmpStoragenameid = $x->getStoragenametoid();
                            $tmpProductid = $x->getProductid();

                            if (!isset($a[$tmpStoragenameid]['storageName'])) {
                                $a[$tmpStoragenameid]['storageName'] = $x->getStorageNameTo()->getName();
                            }
                            @$a[$tmpStoragenameid]['productAmount'] += $x->getAmount();
                            @$a[$tmpStoragenameid]['productCost'] += $x->getField('cost');
                            @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productAmount'] += $x->getAmount();
                            @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productCost'] += $x->getField('cost');
                            @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['productName'] = $x->getProduct()->makeName();
                            $a[$tmpStoragenameid]['productArray'][$tmpProductid]['productId'] = $tmpProductid;

                            // записываем shipmentArray
                            @$a[$tmpStoragenameid]['productArray'][$tmpProductid]['shipmentArray'][] = array(
                            'productAmount' => $x->getAmount(),
                            'productCost' => $x->getField('cost'),
                            'shipment' => $x->getShipment()?$x->getShipment():'---'
                            );

                            if ($x->getShipment()) {
                                // записывем shipmentCount+2 - количество различных партий + 2 доп. строки
                                if (!isset($a[$tmpStoragenameid]['productArray'][$tmpProductid]['shipmentCount'])) {
                                    $a[$tmpStoragenameid]['productArray'][$tmpProductid]['shipmentCount'] = 2;
                                } else {
                                    $a[$tmpStoragenameid]['productArray'][$tmpProductid]['shipmentCount'] += 1;
                                }
                            }

                            // обновление сумм
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
            }

            // склады
            $storageNames = StorageNameService::Get()->getStorageNamesVendorsByUser(
            $cuser,
            'read'
            );

            $storageNamesArray = array();
            while ($storageName = $storageNames->getNext()) {
                $storageNamesArray[] = array(
                'id' => $storageName->getId(),
                'name' => $storageName->getName(),
                'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-storage-balance-vendors', $storageName->getId(), 'storagenameid'),
                'selected' => ($storageName->getId() == $storageNameID)
                );
            }

            $this->setValue('storageNamesArray', $storageNamesArray);

            // категории
            $categories = Shop::Get()->getShopService()->getCategoryAll();
            $this->setValue('categoryArray', $categories->toArray());

            // текущий склад
            $this->setValue('storagenameid', $storageNameID);

            // юр лица
            $contractors = Shop::Get()->getShopService()->getContractorsActive();
            $this->setValue('contractorArray', $contractors->toArray());
            $this->setValue('contractorSelectedArray', $contractorIDArray);

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