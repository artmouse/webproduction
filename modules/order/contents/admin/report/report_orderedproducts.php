<?php
class report_orderedproducts extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');
        $storagenameID = $this->getArgumentSecure('storagenameid', 'int');
        $supplierID = $this->getArgumentSecure('supplierid', 'int');


        // по умолчанию datefrom - dateto полный текущий месяц
        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->setFormat('Y-m-01')->__toString();
            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        
        $productArray = array();
        $reportCountArray = array();
        $countStorageArray = array();
        $countStorageProduct = array();
        $availArray = array();
        
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $this->setValue('currency', $currencyDefault->getName());

        // перебрать заказы, а в них товары
        while ($order = $orders->getNext()) {
            $ops = $order->getOrderProducts();
            while ($op = $ops->getNext()) {
                try {
                    if ($supplierID && $supplierID != $op->getSupplierid()) {
                        continue;
                    }
                } catch (Exception $e) {

                }

                try {
                    $productArray[$op->getProductid()] = array(
                        'name' => $this->_escapeString($op->getProduct()->makeName()),
                        'url' => $op->getProduct()->makeURLEdit(),
                    );
                } catch (Exception $e) {

                }
                // взять колличество из заказа
                @$reportCountArray[$op->getProductid()] += $op->getProductcount();
                // добавить заказ
                @$reportCountOrderArray[$op->getProductid()] += 1;
                
                //получить остатки на складе 
                //@$countStorageArray[$op->getProductid()] += 0;
                @$countStorageProduct[$op->getProductid()] += 0;
                if (Shop_ModuleLoader::Get()->isImported('storage') &&
                        !$countStorageProduct[$op->getProductid()]) {
                    // считаем количество на складе
                    //$storageArray = array();
                    try {
                        $balance = StorageBalanceService::Get()->getBalanceByProductAndStoragesForSale(
                            $this->getUser(),
                            $op->getProduct()
                        );
                    } catch (Exception $e) {
                        
                    }
                    @$countStorageProduct[$op->getProductid()] = 1;
                    while ($s = $balance->getNext()) {
                        try {
                            if (!$storagenameID || $storagenameID == $s->getStoragenameid()) {
                                @$countStorageArray[$op->getProductid()] += $s->getAmount();
                            }
                        } catch (Exception $balanceEx) {

                        }
                    }
                }

                // проверить наличие у поставщиков
                $avail = '';
                $productSupplier = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($op->getProduct());
                $productSupplier->filterAvail(1);
                $productSupplier->setLimitCount(1);
                if ($productSupplier->select()) {
                    $avail = Shop::Get()->getTranslateService()->getTranslateSecure('translate_est');
                }
                
                $availArray[$op->getProductid()] = $avail;
            }
        }
        arsort($reportCountArray);
        $this->setValue('reportCountArray', $reportCountArray);
        $this->setValue('reportCountOrderArray', $reportCountOrderArray);
        $this->setValue('productArray', $productArray);
        $this->setValue('dfrom', $dateFrom);
        $this->setValue('dto', $dateTo);
        $this->setValue('cntstorageArray', $countStorageArray);
        $this->setValue('availArray', $availArray);

        //***************************************************/
        
        //массивы для select-ов в фильтрах
        // массив складов
        $a = array();
        $storagenames = new XShopStorageName();
        while ($sn = $storagenames->getNext()) {
            $a[] = array(
                'id' => $sn->getId(),
                'name' => $sn->getName(),
            );
        }
        $this->setValue('storagenameArray', $a);
        
        // массив поставщиков
        $a = array();
        $supplier = Shop::Get()->getSupplierService()->getSuppliersAll();
        while ($s = $supplier->getNext()) {
            $a[] = array(
                'id' => $s->getId(),
                'name' => $s->getName(),
            );
        }
        $this->setValue('supplierArray', $a);
    }
    
    private function _escapeString($s) {
        $s = trim($s);
        $s = str_replace("\n", '', $s);
        $s = str_replace("\r", '', $s);
        $s = str_replace("\t", '', $s);
        $s = str_replace("'", '', $s);
        $s = str_replace("\"", '', $s);
        return $s;
    }
}