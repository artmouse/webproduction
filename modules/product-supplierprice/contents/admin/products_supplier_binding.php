<?php
class products_supplier_binding extends Engine_Class {

    public function process() {

        $supplierImport = new XShopPriceSupplierImport();
        $supplierImport->setPdate('0000-00-00 00:00:00');
        if ($supplierImport->select()) {
            // есть не распознаные прайсы.
            $this->setValue('load', true);
        }

        // Поставить задачу залить товары
        if ($this->getArgumentSecure('importAll')) {
            // создавать новые товары
            $createNew = $this->getArgumentSecure('createnew');
            if ($createNew) {
                $tmpPrice = new XShopTmpPrice();
                $tmpPrice->filterProductid(0);
                $tmpPrice->setCreatenew(1, true);
                $tmpPrice->update(true);
            }

            ProcessorQueService::Get()->addProcessor('ShopSupplier_Processor_UploadProducts');
        }

        // проверить процесор и если есть запись ждать
        $processor = new XShopProcessorQue();
        $processor->filterLogicclass('ShopSupplier_Processor_UploadProducts');
        if ($processor->select()) {
            $this->setValue('process', true);
        }

        // удаление, помещение в черный список
        $isDelete = $this->getArgumentSecure('delete');
        $isBlackList = $this->getArgumentSecure('blackList');
        if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
            foreach ($r[1] as $tmpPriceId) {
                try {
                    $tmpPrice = $this->_getTmpPriceItemByID($tmpPriceId);
                    if ($isDelete) {
                        $tmpPrice->delete();
                    } elseif ($isBlackList) {
                        // Логика черный список
                        $priceIgnore = new XShopPriceSupplierIgnore();
                        $supplierId =  $tmpPrice->getSupplierid();
                        $code = $tmpPrice->getCode();
                        $name = $tmpPrice->getName();
                        $price = $tmpPrice->getPrice();
                        $currencyId = $tmpPrice->getCurrencyid();
                        $availtext = $tmpPrice->getAvailtext();
                        $priceIgnore->setSupplierid($supplierId);
                        $priceIgnore->setCode($code);
                        $priceIgnore->setName($name);
                        $priceIgnore->setPrice($price);
                        $priceIgnore->setCurrencyid($currencyId);
                        $priceIgnore->setAvailtext($availtext);
                        $priceIgnore->insert();
                        $tmpPrice->delete();
                    }

                } catch (Exception $pe) {

                }
            }
        }



        // таблица
        $table = new Shop_ContentTable(
            new Datasource_TmpPrice()
        );
        $table->setRow(new Shop_ContentTableRowProductsSupplier());
        $this->setValue('table', $table->render());

        // Поставщики загружаемые в прайсе
        $suppliersNameArray = array();
        $tmpPrice = new XShopTmpPrice();
        $tmpPrice->setGroupByQuery('supplierid');
        while ($x = $tmpPrice->getNext()) {
            $supplier = Shop::Get()->getSupplierService()->getSupplierByID($x->getSupplierid());
            $supplierName = $supplier->makeName();
            $suppliersNameArray[] = $supplierName;
        }
        $suppliersNameString = implode(', ', $suppliersNameArray);
        $this->setValue('suppliersNameString', $suppliersNameString);

        // блок фильтров
        $productFilters = Shop::Get()->getShopService()->getProductFiltersAll();
        $productFilters->filterBasicfilter(1);
        $filtersArray = array();
        while ($productFilter = $productFilters->getNext()) {
            $filterName = $productFilter->getName();
            $tmpArray = array();
            $tmp = new XShopProductFilterValue();
            $tmp->filterFilterid($productFilter->getId());
            $tmp->setGroupByQuery('filtervalue');
            while ($x = $tmp->getNext()) {
                $tmpArray[] = array(
                    'id' => $x->getId(),
                    'value' => $x->getFiltervalue()
                );
            }
            $filtersArray[$productFilter->getId()] = array(
                  'name' => $filterName,
                  'values' => $tmpArray
                );

        }

        $this->setValue('filtersArray', $filtersArray);

    }

    // @todo в сервис
    private function _getTmpPriceItemByID ($id) {
        $tmpPrice = new XShopTmpPrice();
        $tmpPrice->filterId($id);
        if ($tmpPrice->select()) {
            return $tmpPrice;
        }
        throw new Exception();

    }

}