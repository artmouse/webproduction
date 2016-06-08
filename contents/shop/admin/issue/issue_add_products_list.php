<?php
class issue_add_products_list extends Engine_Class {

    public function process() {

        $name = trim($this->getArgument('name'));
        $categoryId = $this->getArgumentSecure('categoryId');
        $filterArray = $this->getArgumentSecure('filter');

        $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $else = array();

        if (!$name) {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setDeleted(0);

        } elseif (strlen($name) < 3) {
            return false;
        } else {
            // этот код не удалять!
            $products = false;
            if (Shop_ModuleLoader::Get()->isImported('storage')) {
                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->setDeleted(0);
                $products->addWhereQuery(
                    '`id` IN (SELECT `productid` FROM `shopstoragebalance`
                     WHERE `serial` LIKE "%'.$name.'%" AND `amount` > `amountlinked` AND `amount` > 0)'
                );
                // поиск по имени
                if (!$products->getCount()) {
                    $products = Shop::Get()->getShopService()->searchProducts($name);
                }
            } else {
                $products = Shop::Get()->getShopService()->searchProducts($name);
            }           
        }

        if ($categoryId) {
            $str = '(';
            for ($i=1; $i<=10; $i++) {
                $str .= '`category'.$i.'id` = '.$categoryId;

                if ($i!=10) {
                    $str .= ' OR ';
                }
            }
            $str .= ')';
            $products->addWhereQuery($str);
        }



        if ($filterArray) {
            $productIDAllArray = array();

            foreach ($filterArray as $filterId => $filterValue) {
                if (!$filterValue) {
                    continue;
                }

                $productIDArray = array();
                try{
                    $tmp = new XShopProductFilterValue();
                    $tmp->setFiltervalue($filterValue);
                    $tmp->setFilterid($filterId);
                    while ($xtmp = $tmp->getNext()) {
                        $productIDArray[$xtmp->getProductid()] = $xtmp->getProductid();
                    }

                } catch (Exception $efe) {

                }

                if (!$productIDArray) {
                    return false;
                }

                if ($productIDArray && !$productIDAllArray) {
                    $productIDAllArray = $productIDArray;
                } elseif ($productIDArray) {
                    $productIDAllArray = array_intersect($productIDAllArray, $productIDArray);
                }

            }

            if ($productIDAllArray) {
                $w1 = "shopproduct.id IN (".implode(',', $productIDAllArray).")";
                $products->addWhereQuery($w1);
            }

        }


        $products->addWhere('price', '0', '>');
        $products->setLimitCount(1000);
        $products->setOrderBy('`storaged` DESC, `suppliered` DESC, `price`');

        while ($x = $products->getNext()) {
            try {
                $storageArray = array();
                if (Shop_ModuleLoader::Get()->isImported('storage')) {
                    $balance = StorageBalanceService::Get()->getBalanceByProductAndStoragesForSale(
                        $this->getUser(),
                        $x
                    );

                    while ($bal = $balance->getNext()) {
                        $storageArray[] = array(
                            'name' => $bal->getStorageName()->getName(),
                            'count' => round($bal->getAmountAvailable(), 3),
                            'price' => $bal->getPricebase(),
                            'serial' => $bal->getSerial(),
                            'linkkey' => 'balance_'.$bal->getId()
                        );
                    }
                }

                $supplierArray = array();
                
                $productSuppliers = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($x);
                while ($p = $productSuppliers->getNext()) {
                    $supplierID = $p->getSupplierid();
                    $supplierCurrencyID = $p->getCurrencyid();
                    $supplierDate = $p->getDate();
                    $supplierPrice = $p->getPrice();
                    $supplierAvailText = $p->getAvailtext();
                    $supplierAvail = $p->getAvail();
                    $supplierComment = $p->getComment();

                    if ($supplierID && $supplierAvail) {
                        if (!$supplierCurrencyID) {
                            $supplierCurrencyID = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
                        }

                        $supplier = Shop::Get()->getShopService()->getSupplierByID($supplierID);

                        if ($supplier->getHidden()) {
                            continue;
                        }

                        $price = Shop::Get()->getCurrencyService()->convertCurrency(
                            $supplierPrice,
                            Shop::Get()->getCurrencyService()->getCurrencyByID($supplierCurrencyID),
                            $currency
                        );

                        $supplierArray[] = array(
                        'name' => $supplier->getName(),
                        'color' => $supplier->getColor(),
                        'avail' => $supplierAvail,
                        'availText' => $supplierAvailText,
                        'date' => $supplierDate,
                        'price' => $price,
                        'comment' => $supplierComment,
                        'linkkey' => 'supplier_'.$supplier->getId()
                        );
                        $visible = Shop::Get()->getSettingsService()->getSettingValue('show-hide-purchase-price');
                        $this->setValue('visible', $visible);
                    }
                }

                $name = str_replace('"', '\"', $x->getName());
                $name = str_replace('\'', '\"', $name);

                try {
                    $categoryName = $x->getCategory()->makeName(false);
                } catch (Exception $e) {
                    $categoryName = false;
                }

                try {
                    $pricebaseCurrency = $x->getCurrency()->getSymbol();
                } catch (Exception $e) {
                    $pricebaseCurrency = false;
                }

                $else[] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'avail' => $x->getAvail(),
                    'categoryName' => $categoryName,
                    'url' => $x->makeURLEdit(),
                    'name2' => $name,
                    'pricebase' => round($x->getPricebase(), 2),
                    'pricebasecurrency' => $pricebaseCurrency,
                    'price' => round($x->makePrice($currency), 2),
                    'pricebaseInCurrencyDefault' => round(
                        Shop::Get()->getCurrencyService()->convertCurrency(
                            $x->getPricebase(),
                            $x->getCurrency(),
                            $currency
                        ),
                        2
                    ),
                    'currency' => $x->getCurrency()->getSymbol(),
                    'supplierArray' => $supplierArray,
                    'storageArray' => $storageArray,

                );
            } catch (Exception $e) {

            }
        }

        $this->setValue('productArray', $else);

        try {
            $workflow = Shop::Get()->getShopService()->getOrderCategoryByID(
                $this->getArgument('workflowId')
            );

            $this->setValue('isOrderOutcoming', $workflow->getOutcoming());
        } catch (Exception $we) {

        }
    }

}