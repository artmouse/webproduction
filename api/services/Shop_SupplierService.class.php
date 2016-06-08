<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Сервис, отвечающий за работу с поставщиками и пересчеты цен
 */
class Shop_SupplierService extends ServiceUtils_AbstractService {

    /**
     * Получить всех поставщиков
     *
     * @return ShopSupplier
     */
    public function getSuppliersAll() {
        $x = new ShopSupplier();
        $x->setOrder('name');
        return $x;
    }

    /**
     * Получить всех активных поставщиков
     *
     * @return ShopSupplier
     */
    public function getSuppliersActive() {
        $x = $this->getSuppliersAll();
        $x->setHidden(0);
        return $x;
    }

    /**
     * Получить поставщика по его номеру
     *
     * @param int $supplierID
     *
     * @return ShopSupplier
     */
    public function getSupplierByID($supplierID) {
        try {
            return $this->getObjectByID($supplierID, 'ShopSupplier');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('ShopSupplier by id not found');
    }

    /**
     * Создать поставщика.
     * Если такой уже есть - то возвращаем его.
     *
     * @param string $name
     *
     * @return ShopSupplier
     */
    public function addSupplier($name) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            $supplier = new ShopSupplier();
            $supplier->setName($name);
            if (!$supplier->select()) {
                $supplier->insert();
            }

            SQLObject::TransactionCommit();

            return $supplier;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать поставщиков по outcoming заказам автоматически
     */
    public function syncSuppliers() {
        ModeService::Get()->verbose('Sync suppliers...');
        try {
            SQLObject::TransactionStart(false, true);

            $supplier = new ShopSupplier();

            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->filterOutcoming(1);
            $orders->addWhere('userid', 0, '<>');
            $orders->leftJoinTable(
                $supplier->getTablename(),
                $orders->getTablename().'.`userid` = '.$supplier->getTablename().'.`contactid`'
            );
            $orders->addWhereQuery($supplier->getTablename().'.`contactid` IS NULL');
            $orders->setGroupByQuery('userid');

            while ($order = $orders->getNext()) {
                $supplierName = '';
                try {
                    $supplierName = $order->getClient()->makeName();
                } catch (ServiceUtils_Exception $se) {

                }

                $supplier = new ShopSupplier();
                $supplier->setContactid($order->getUserid());
                $supplier->setName($supplierName);
                $supplier->insert();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать задачи на импорт прайса поставщика,
     * задачи разбиваются на части по 1000 позиций
     *
     * @param integer $supplierId
     * @param integer $currencySupplierId
     * @param array $file
     * @param string $type
     * @param string $encoding
     * @param integer $columnCode
     * @param integer $columnName
     * @param integer $columnPrice
     * @param integer $columnArticul
     * @param integer $columnMinretail
     * @param integer $currencyMinretail
     * @param integer $columnRecommretail
     * @param integer $currencyRecommretail
     * @param integer $columnAvail
     * @param integer $columnDiscount
     * @param bool $isSearchCode
     * @param bool $isSearchCodeThis
     * @param bool $isSearchName
     * @param bool $isSearchArticul
     *
     * @return array
     */
    public function createSupplierImport(
        $supplierId,
        $currencySupplierId,
        $file,
        $type,
        $encoding,
        $columnCode,
        $columnName,
        $columnPrice,
        $columnArticul = false,
        $columnMinretail = false,
        $currencyMinretail = false,
        $columnRecommretail = false,
        $currencyRecommretail = false,
        $columnAvail = false,
        $columnDiscount = false,
        $isSearchCode = false,
        $isSearchCodeThis = false,
        $isSearchCodeMD5 = false,
        $isSearchName = false,
        $isSearchNamePrecision = 100,
        $isSearchArticul =  false,
        $createNewProduct = false,
        $onlyRetail = false,
        $removeMinretail = false,
        $removeRecommretail = false,
        $notimportemptyprice = false,
        $columcomment = false,
        $datelifeto = false,
        $processed_lists = '',
        $notimportemptyavail = false
    ) {
        // один потому как положительный результат имеет заначение 0
        $result = 1;
        $convert = false;
        if ($type == 'xls' || $type == 'xlsx') {

            $priceName = @$file['name'];
            $file = @$file['tmp_name'];
            $ex = new ServiceUtils_Exception();
            if (!file_exists($file)) {
                $ex->addError('file');
                throw $ex;
            }

            if ($type == 'xlsx') {
                $mediaFile = md5(file_get_contents($file)) . '.xlsx';
            } elseif ($type == 'xls') {
                $mediaFile = md5(file_get_contents($file)) . '.xls';
            }
            $priceNameMD5 = $mediaFile;

            copy($file, PackageLoader::Get()->getProjectPath().'media/import/'.$mediaFile);
            // пробуем конвертировать в csv
            $result = $this->convertXLStoCSV($mediaFile);
            if ((int) $result != 0) {
                // если не сработал и тип xlsx
                if ($type == 'xlsx') {
                    $ex->addError('xls2csv');
                    throw $ex;
                }
                // если конвертор не сработал
                // обрабатываем файл xls
                PackageLoader::Get()->import('XLS');
                $data = new XLS_Reader();
                $data->setOutputEncoding('UTF-8');
                $data->read($file);

                // количество листов всего
                $numberSheets = count($data->sheets);
                $sheetsArray = array();

                $processedListsArray = $this->_listsNumberToArray($processed_lists);
                if (!$processedListsArray) {
                    // Обрабатываем все
                    for ($j = $numberSheets; 1 <= $j; $j--) {
                        $processedListsArray[] = $j;
                    }
                }
                foreach ($processedListsArray as $numberSheet) {
                    $numberSheet = $numberSheet - 1;
                    $numRows = $data->sheets[$numberSheet]['numRows'];
                    $sheetsArray[] = array(
                        'sheet' => $numberSheet,
                        'numRows' => $numRows
                    );
                }

            } else {
                // если сработал
                $type = 'csv-comma';

                $processedListsArray = $this->_listsNumberToArray($processed_lists);

                // запишем что csv получен конвертированием и может быть несколько файлов
                $convert = true;

                $filesArray = array();

                PackageLoader::Get()->import('XLS');
                $data = new XLS_Reader();
                $data->setOutputEncoding('UTF-8');
                $data->read($file);
                // количество листов всего
                $numberSheets = count($data->sheets);
                // Пользователь не вводил листы, обрабатываем все
                if (!$processedListsArray) {
                    // Обрабатываем все
                    for ($j = $numberSheets; 1 <= $j; $j--) {
                        $processedListsArray[] = $j;
                    }
                }

                foreach ($processedListsArray as $numberSheet) {
                    // Копируем полученные csv файлы в медиа
                    $tmpFileName = 'Sheet' . $numberSheet .'.csv';
                    $csvFile = PackageLoader::Get()->getProjectPath().'media/import/csv/'. $tmpFileName;
                    $mediaFile = md5(file_get_contents($csvFile)).'.csv';
                    copy($csvFile, PackageLoader::Get()->getProjectPath().'media/import/'.$mediaFile);
                    $f = file($csvFile);
                    $numRows = count($f);
                    $filesArray[] = array(
                        'file' => $mediaFile,
                        'numRows' => $numRows
                    );
                }

            }

        } elseif ($type == 'csv-default' || $type == 'csv-comma' || $type == 'csv-tab') {
            $file = @$file['tmp_name'];
            $mediaFile = md5(file_get_contents($file)).'.csv';
            $priceNameMD5 = $mediaFile;
            copy($file, PackageLoader::Get()->getProjectPath().'media/import/'.$mediaFile);
            $f = file($file);
            $numRows = count($f);
            $filesArray = array(
                'numRows' => $numRows,
                'file' => $mediaFile
            );
        }


        // дополнительные настройки
        $optionArray = array();
        if ($isSearchCode) {
            $optionArray[] = 'isSearchCode';
        }
        if ($isSearchCodeThis) {
            $optionArray[] = 'isSearchCodeThis';
        }
        if ($isSearchCodeMD5) {
            $optionArray[] = 'isSearchCodeMD5';
        }
        if ($isSearchArticul) {
            $optionArray[] = 'isSearchArticul';
        }
        if ($isSearchName) {
            $optionArray[] = 'isSearchName';
        }
        if ($createNewProduct) {
            $optionArray[] = 'createNewProduct';
        }
        if ($onlyRetail) {
            $optionArray[] = 'onlyRetail';
        }
        if ($removeRecommretail) {
            $optionArray[] = 'removeRecommretail';
        }
        if ($removeMinretail) {
            $optionArray[] = 'removeMinretail';
        }

        if ($notimportemptyprice) {
            $optionArray[] = 'notimportemptyprice';
        }

        if ($notimportemptyavail) {
            $optionArray[] = 'notimportemptyavail';
        }

        $option = serialize($optionArray);
        // дата создания задач
        $date = date("Y-m-d H:i:s");

        // создать запись о загрузке прайса в таблицу отчета
        $importStatus = new XPriceSupplierImportStatus;
        $importStatus->setDateupload($date);
        $importStatus->setPricenamemd5($priceNameMD5);
        $importStatus->setSupplierid($supplierId);
        $importStatus->insert();
        $arrayCounter = 0;
        $firstPart = true;
        if (!$convert) {
            // создать запись в базу
            // записи для листов

            foreach ($sheetsArray as $sheetData) {
                $step = $sheetData['numRows'] / 1000;
                $arrayCounter++;
                // к целому числу
                $step = ceil($step);
                while ($step) {
                    $supplierImport = new XShopPriceSupplierImport();
                    $supplierImport->setPricename($priceName);
                    $supplierImport->setCdate($date);
                    // пока не получено подтверждение ожидаем 
                    $supplierImport->setPdate($date);
                    $supplierImport->setStep($step);
                    $supplierImport->setSupplierid($supplierId);
                    $supplierImport->setSuppliercurrencyid($currencySupplierId);
                    $supplierImport->setFile($mediaFile);
                    $supplierImport->setFiletype($type);
                    $supplierImport->setFileencoding($encoding);
                    $supplierImport->setColumncode($columnCode);
                    $supplierImport->setColumnname($columnName);
                    $supplierImport->setColumnarticul($columnArticul);
                    $supplierImport->setColumnprice($columnPrice);
                    $supplierImport->setColumnminretail($columnMinretail);
                    $supplierImport->setColumnminretail_cur_id($currencyMinretail);
                    $supplierImport->setColumnrecommretail($columnRecommretail);
                    $supplierImport->setColumnrecommretail_cur_id($currencyRecommretail);
                    $supplierImport->setColumnavail($columnAvail);
                    $supplierImport->setColumndiscount($columnDiscount);
                    $supplierImport->setOptionarray($option);
                    $supplierImport->setSearchnameprecision($isSearchNamePrecision);
                    $supplierImport->setColumncomment($columcomment);
                    $supplierImport->setDatelifeto($datelifeto);
                    $supplierImport->setProcessed_lists($processed_lists);
                    $supplierImport->setConvert($convert);
                    $supplierImport->setXlssheet($sheetData['sheet']);
                    if ($firstPart) {
                        // Первая запись
                        $supplierImport->setFirstpart(1);
                        //$firstPart = false;
                    }
                    $step--;
                    if ($step == 0 && $arrayCounter == count($sheetsArray)) {
                        // Последняя запись
                        $supplierImport->setLastpart(1);
                    }
                    $supplierImport->insert();

                    if ($firstPart) {
                        $importStatus->setPriceid($supplierImport->getId());
                        $importStatus->update();
                        $firstPart = false;
                    }

                }
            }
        } else {
            foreach ($filesArray as $fileData) {
                // создать запись в базу
                $step = $fileData['numRows'] / 1000;
                // к целому числу
                $step = ceil($step);
                $arrayCounter++;
                while ($step) {
                    $supplierImport = new XShopPriceSupplierImport();
                    $supplierImport->setCdate($date);
                    // пока не получено подтверждение ожидаем
                    $supplierImport->setPdate($date);
                    $supplierImport->setPricename($priceName);
                    $supplierImport->setStep($step);
                    $supplierImport->setSupplierid($supplierId);
                    $supplierImport->setSuppliercurrencyid($currencySupplierId);
                    $supplierImport->setFile($fileData['file']);
                    $supplierImport->setFiletype($type);
                    $supplierImport->setFileencoding($encoding);
                    $supplierImport->setColumncode($columnCode);
                    $supplierImport->setColumnname($columnName);
                    $supplierImport->setColumnarticul($columnArticul);
                    $supplierImport->setColumnprice($columnPrice);
                    $supplierImport->setColumnminretail($columnMinretail);
                    $supplierImport->setColumnminretail_cur_id($currencyMinretail);
                    $supplierImport->setColumnrecommretail($columnRecommretail);
                    $supplierImport->setColumnrecommretail_cur_id($currencyRecommretail);
                    $supplierImport->setColumnavail($columnAvail);
                    $supplierImport->setColumndiscount($columnDiscount);
                    $supplierImport->setOptionarray($option);
                    $supplierImport->setSearchnameprecision($isSearchNamePrecision);
                    $supplierImport->setColumncomment($columcomment);
                    $supplierImport->setDatelifeto($datelifeto);
                    $supplierImport->setProcessed_lists($processed_lists);
                    $supplierImport->setConvert($convert);
                    if ($firstPart) {
                        // Первая запись
                        $supplierImport->setFirstpart(1);
                        //$firstPart = false;
                    }
                    $step--;
                    if ($step == 0 && $arrayCounter == count($filesArray)) {
                        // Последняя запись
                        $supplierImport->setLastpart(1);
                    }
                    $supplierImport->insert();

                    if ($firstPart) {
                        $importStatus->setPriceid($supplierImport->getId());
                        $importStatus->update();
                        $firstPart = false;
                    }

                }
            }
        }
        return array('date'=> $date, 'resaltConvert'=> $result);
    }


    /**
     * Залить все  записи прайсов поставщиков с временной таблицы
     */
    public function updateProductsWithPriceEntity () {
        echo 'start entity';
        $tmpPrice = new XShopTmpPrice();
        // Поставщики участвующие в импорте
        $suppliersIdArray = array();
        // Прайсы участвующие в импорте - по дате
        $pricesDateArray = array();
        while ($x = $tmpPrice->getNext()) {
            if (!in_array($x->getSupplierid(), $suppliersIdArray)) {
                $suppliersIdArray[] = $x->getSupplierid();
            }

            $dateUpload = $x->getDateupload();
            if (!in_array($dateUpload, $pricesDateArray)) {
                $pricesDateArray[] = $dateUpload;
            }
            try {
                SQLObject::TransactionStart();
                $productId = $x->getProductid();
                $onlyRetail = $x->getOnlyretail();


                if ($productId) {
                    $product = Shop::Get()->getShopService()->getProductByID($productId);
                } elseif ($x->getCreatenew()) {
                    $product = Shop::Get()->getShopService()->addProduct($x->getName());
                    $product->setHidden(0);
                    $product->update();
                } else {
                    $x->delete();
                    SQLObject::TransactionCommit();
                    continue;
                }

                if ($x->getArticul() && !$product->getArticul()) {
                    $product->setArticul($x->getArticul());
                }

                // отмечаем что товар был в прайсе
                $product->setSync(0);


                if ($x->getDatelifeto() && $x->getDatelifeto() != '0000-00-00 00:00:00') {
                    $product->setDatelifeto($x->getDatelifeto());
                }
                $product->update();
                $productSupplier = new ShopProductSupplier();
                $productSupplier->setProductid($product->getId());
                $productSupplier->setSupplierid($x->getSupplierid());
                if (!$productSupplier->select()) {
                    $productSupplier->insert();
                }


                if (!$onlyRetail) {
                    $productSupplier->setCode($x->getCode());
                    $productSupplier->setPrice($x->getPrice());
                    $productSupplier->setCurrencyid($x->getCurrencyid());
                    $productSupplier->setAvailtext($x->getAvailtext());
                    $productSupplier->setComment($x->getComment());
                    $productSupplier->setAvail($x->getAvail());
                    $productSupplier->setDate($x->getDate());
                    $productSupplier->setDiscount($x->getDiscount());
                }
                if ($x->getMinretail()) {
                    $productSupplier->setMinretail($x->getMinretail());
                    $productSupplier->setMinretail_cur_id($x->getMinretailcurrrncyid());
                }
                if ($x->getRecommretail()) {
                    $productSupplier->setRecommretail($x->getRecommretail());
                    $productSupplier->setRecommretail_cur_id($x->getRecommretailcurrruncyid());
                }
                if ($x->getIsRemoveminretail()) {
                    $productSupplier->setMinretail(0);
                    $productSupplier->setMinretail_cur_id(0);
                }
                if ($x->getIsremoverecommretail()) {
                    $productSupplier->setRecommretail(0);
                    $productSupplier->setRecommretail_cur_id(0);
                }
                $productSupplier->update();
                // добавить запись о обновлении товара

                if ($x->getIsnew()) {
                    $this->_updatePriceSupplierImportReport($product, $dateUpload, true);
                } else {
                    $this->_updatePriceSupplierImportReport($product, $dateUpload, false);
                }

                $x->delete();
                SQLObject::TransactionCommit();
            } catch(Exception $e) {
                SQLObject::TransactionRollback();
                LogService::Get()->add($e, 'supplierPriceImport');
            }
        }
        foreach ($suppliersIdArray as $supplierid) {
            try{
                $supplier = Shop::Get()->getSupplierService()->getSupplierByID($supplierid);
                $this->_updateSupplierProductAvail($supplier);
                LogService::Get()->add(
                    "Экспортированы товары поставщика {$supplier->makeName()}",
                    'supplierPriceImport'
                );
            } catch(Exception $e) {

            }
        }
        foreach ($pricesDateArray as $dateUpload) {
            $this->_updateSupplierImportStatus($dateUpload, date("Y-m-d H:i:s"));
            $this->_sendReportPriseSupplierImport($dateUpload);
        }

        // пересчет наличия
        ProcessorQueService::Get()->addProcessor('ShopSupplier_Processor_Avail');

    }

    /**
     * обработать очередь загрузки прайса поставщика
     */
    public function importSupplierPrice() {
        ModeService::Get()->verbose('Process supplier prices import...');

        $ex = new ServiceUtils_Exception();
        // Определить первый загружаемый прайс
        $supplierImportTmp = new XShopPriceSupplierImport();
        $supplierImportTmp->setPdate('0000-00-00 00:00:00');
        $supplierImportTmp->setOrder('cdate', 'ASC');

        $supplierImport = new XShopPriceSupplierImport();
        $supplierImport->setPdate('0000-00-00 00:00:00');
        $supplierImport->setOrder('step', 'DESC');
        $supplierImport->setOrder('lastpart', 'ASC');
        if ($supplierImportTmp->select()) {
            $supplierImport->setCdate($supplierImportTmp->getCdate());
        }
        if ($x = $supplierImport->getNext()) {

            // проверка лимита памяти, только если есть файлы
            $this->_checkMemoryLimit();

            print_r($x->getValues());

            $dateUpload = $x->getCdate();
            $step = $x->getStep();
            $file = $x->getFile();
            $type = $x->getFiletype();
            $fileEncoding = $x->getFileencoding();
            $currencySupplierId = $x->getSuppliercurrencyid();
            $supplierId = $x->getSupplierid();
            $columnCode = $x->getColumncode();
            $columnName = $x->getColumnname();
            $columnArticul = $x->getColumnarticul();
            $columnPrice = $x->getColumnprice();
            $columnMinRetail = $x->getColumnminretail();
            $currencyMinretail = $x->getColumnminretail_cur_id();
            $columnRecommRetail = $x->getColumnrecommretail();
            $currencyRecommRetail = $x->getColumnrecommretail_cur_id();
            $columnAvail = $x->getColumnavail();
            $columnDiscount = $x->getColumndiscount();
            $optionarray = unserialize($x->getOptionarray());
            $lastPart = $x->getLastpart();
            $firstPart = $x->getFirstpart();
            $nameSearchPrecision = $x->getSearchnameprecision();
            $columnComment = $x->getColumncomment();
            $datelifeto = $x->getDatelifeto();
            $numberSheet = $x->getXlssheet();
            $notimportemptyprice = false;

            if (in_array('isSearchName', $optionarray, true)) {
                if (!$nameSearchPrecision || $nameSearchPrecision >= 100) {
                    $nameSearchPrecision = 100;
                }
                if ($nameSearchPrecision <= 50) {
                    $nameSearchPrecision = 50;
                }

                $optionarray['nameSearchPrecision'] = $nameSearchPrecision;
            } else {
                $optionarray['nameSearchPrecision'] = 0;
            }

            // импорт только рцц и мин розницы
            if (in_array('onlyRetail', $optionarray, true)) {
                $onlyRetail = true;
            }

            // не импортировать товары с пустой ценой
            if (in_array('notimportemptyprice', $optionarray, true)) {
                $notimportemptyprice = true;
            }

            // получаем поставщика
            try {
                $supplier = $this->getSupplierByID(
                    $supplierId
                );
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('supplier');
            }

            // получаем валюту
            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                    $currencySupplierId
                );
            } catch (ServiceUtils_Exception $se) {
                $ex->addError('currency');
            }

            // валюта мин розницы
            try {
                $currencyMinretail = Shop::Get()->getCurrencyService()->getCurrencyByID(
                    $currencyMinretail
                );
            } catch (ServiceUtils_Exception $se) {
                $currencyMinretail = $currency;
            }

            // валюта рекомендуемой розницы
            try {
                $currencyRecommRetail = Shop::Get()->getCurrencyService()->getCurrencyByID(
                    $currencyRecommRetail
                );
            } catch (ServiceUtils_Exception $se) {
                $currencyRecommRetail = $currency;
            }

            $currencyActive = Shop::Get()->getCurrencyService()->getCurrencyActive();
            $currencyArray = array();
            while ($c = $currencyActive->getNext()) {
                $currencyArray[$c->getId()] = $c->getName();
            }

            if (!$columnCode || !$columnName) {
                $ex->addError('column');
            }


            if (!$columnPrice && !$onlyRetail) {
                $ex->addError('column');
            }

            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            if ($firstPart) {
                // Помечаем товары которые должны обновится
                // только в первом задании
                $products = $this->getProductsBySupplierID(
                    $supplier->getId()
                );
                // while ($product = $products->getNext()) {
                $products->setSync(1, true);
                $products->update(true);
                // }
            }

            $date = date('Y-m-d H:i:s');
            $from = $step * 1000 - 1000;
            $to = $step * 1000;

            $columnName = $this->columnNumberToArray($columnName);
            $columnCode = $this->columnNumberToArray($columnCode);
            if ($columnArticul) {
                $columnArticul = $this->columnNumberToArray($columnArticul);
            }
            if ($columnAvail) {
                $columnAvail = $this->columnNumberToArray($columnAvail);
            }
            if ($columnComment) {
                $columnComment = $this->columnNumberToArray($columnComment);
            }

            if ($type == 'xls') {
                PackageLoader::Get()->import('XLS');
                $data = new XLS_Reader();
                $data->setOutputEncoding('UTF-8');
                $file = PackageLoader::Get()->getProjectPath() . 'media/import/' . $file;
                $data->read($file);
                for ($i = $from; $i <= $to; $i++) {
                    $productCurrency = null;
                    if ($columnAvail) {
                        if (is_array($columnAvail)) {
                            $availText = $this->gluePriceValue($data, $columnAvail, 'xls', $i, $numberSheet);
                        } else {
                            $availText = @trim($data->sheets[$numberSheet]['cells'][$i][$columnAvail]);
                        }
                    } else {
                        $availText = 'В наличии';
                    }

                    if ($columnArticul) {
                        if (is_array($columnArticul)) {
                            $articul = $this->gluePriceValue($data, $columnArticul, 'xls', $i, $numberSheet);
                        } else {
                            $articul = @trim($data->sheets[$numberSheet]['cells'][$i][$columnArticul]);
                        }
                    } else {
                        $articul = '';
                    }

                    if ($columnComment) {
                        if (is_array($columnComment)) {
                            $comment = $this->gluePriceValue($data, $columnComment, 'xls', $i, $numberSheet);
                        } else {
                            $comment = @trim($data->sheets[$numberSheet]['cells'][$i][$columnComment]);
                        }
                    } else {
                        $comment = '';
                    }

                    $price = @trim($data->sheets[$numberSheet]['cells'][$i][$columnPrice]);
                    $price = str_replace(',', '.', $price);
                    $price = str_replace(' ', '', $price);
                    // Обработать валюту в цене поставщика
                    foreach ($currencyArray as $curName) {
                        if (preg_match("/{$curName}/i", $price)) {
                            try {
                                $productCurrency = Shop::Get()->getCurrencyService()->getCurrencyByName(
                                    $curName
                                );
                                break;
                            } catch (Exception $e) {

                            }
                        }
                    }

                    if ($productCurrency) {
                        $supplierCurrency = $productCurrency;
                    } else {
                        $supplierCurrency = $currency;
                    }

                    if ($notimportemptyprice) {
                        if (!(float) $price) {
                            continue;
                        }
                    }

                    if ($columnMinRetail) {
                        $minRetail = @trim($data->sheets[$numberSheet]['cells'][$i][$columnMinRetail]);
                        $minRetail = str_replace(',', '.', $minRetail);
                        $minRetail = str_replace(' ', '', $minRetail);
                    } else {
                        $minRetail = 0;
                    }

                    if ($columnRecommRetail) {
                        $recommRetail = @trim($data->sheets[$numberSheet]['cells'][$i][$columnRecommRetail]);
                        $recommRetail = str_replace(',', '.', $recommRetail);
                        $recommRetail = str_replace(' ', '', $recommRetail);
                    } else {
                        $recommRetail = 0;
                    }

                    // код поставщика
                    if (is_array($columnCode)) {
                        $code = $this->gluePriceValue($data, $columnCode, 'xls', $i, $numberSheet);
                    } else {
                        $code = @trim($data->sheets[$numberSheet]['cells'][$i][$columnCode]);
                    }

                    // название товара
                    if (is_array($columnName)) {
                        $name = $this->gluePriceValue($data, $columnName, 'xls', $i, $numberSheet);
                    } else {
                        $name = @trim($data->sheets[$numberSheet]['cells'][$i][$columnName]);
                    }

                    $discount = @trim($data->sheets[$numberSheet]['cells'][$i][$columnDiscount]);
                    // значения закончились
                    if (!$price && !$code) {
                        continue;
                    }

                    try {
                        $this->_addTmpPriceSupplierRecord(
                            $supplier,
                            $code,
                            $name,
                            $articul,
                            $optionarray,
                            $price,
                            $supplierCurrency,
                            $availText,
                            $date,
                            $discount,
                            $minRetail,
                            $recommRetail,
                            $currencyMinretail,
                            $currencyRecommRetail,
                            $dateUpload,
                            $comment,
                            $datelifeto,
                            $x->getId()
                        );
                    } catch (Exception $priceEx) {
                        $product = new ShopProduct();
                        $product->setName($name);
                        // записать ошибку в отчет загрузки
                        $this->_updatePriceSupplierImportReport($product, $dateUpload, false, 1);
                    }

                }
            } elseif ($type == 'csv-default' || $type == 'csv-comma' || $type == 'csv-tab') {
                $delimeter = ';';
                if ($type == 'csv-comma') {
                    $delimeter = ',';
                }
                if ($type == 'csv-tab') {
                    $delimeter = "\t";
                }

                if ($fileEncoding == 'windows-1251') {
                    setlocale(LC_ALL, 'ru_RU.CP1251');
                }
                $file = PackageLoader::Get()->getProjectPath() . 'media/import/' . $file;
                $f = fopen($file, 'r');


                $lineIndex = 0;
                while ($line = fgetcsv($f, 4096, $delimeter)) {
                    $lineIndex ++;
                    $productCurrency = null;
                    if ($from && $from > $lineIndex) {
                        continue;
                    }
                    if ($to && $to < $lineIndex) {
                        break;
                    }

                    if ($columnAvail) {
                        if (is_array($columnAvail)) {
                            $availText = $this->gluePriceValue($line, $columnAvail, 'csv');
                        } else {
                            $availText = @trim($line[$columnAvail - 1]);
                        }
                    } else {
                        $availText = 'В наличии';
                    }

                    $price = @trim($line[$columnPrice - 1]);
                    $price = str_replace(',', '.', $price);
                    // Обработать валюту в цене поставщика
                    foreach ($currencyArray as $curName) {
                        if (preg_match("/{$curName}/i", $price)) {
                            try {
                                $productCurrency = Shop::Get()->getCurrencyService()->getCurrencyByName(
                                    $curName
                                );
                                break;
                            } catch (Exception $e) {

                            }
                        }
                    }
                    if ($productCurrency) {
                        $supplierCurrency = $productCurrency;
                    } else {
                        $supplierCurrency = $currency;
                    }


                    if ($notimportemptyprice) {
                        if (!(float) $price) {
                            continue;
                        }
                    }

                    // код поставщика
                    if (is_array($columnCode)) {
                        $code = $this->gluePriceValue($line, $columnCode, 'csv');
                    } else {
                        $code = @trim($line[$columnCode - 1]);
                    }

                    $code = preg_replace("/^(.+?)\.0$/ius", '$1', $code);

                    // артикул
                    if ($columnArticul) {
                        if (is_array($columnArticul)) {
                            $articul = $this->gluePriceValue($line, $columnArticul, 'csv');
                        } else {
                            $articul = @trim($line[$columnArticul - 1]);
                        }
                    } else {
                        $articul = '';
                    }


                    if ($columnComment) {
                        if (is_array($columnComment)) {
                            $comment = $this->gluePriceValue($line, $columnComment, 'csv');
                        } else {
                            $comment = @trim($line[$columnComment - 1]);
                        }
                    } else {
                        $comment = '';
                    }

                    // наименование
                    if (is_array($columnName)) {
                        $name = $this->gluePriceValue($line, $columnName, 'csv');
                    } else {
                        $name = @trim($line[$columnName - 1]);
                    }

                    $discount = @trim($line[$columnDiscount - 1]);
                    $minRetail = @trim($line[$columnMinRetail - 1]);
                    $minRetail = str_replace(',', '.', $minRetail);
                    $recommRetail = @trim($line[$columnRecommRetail - 1]);
                    $recommRetail = str_replace(',', '.', $recommRetail);

                    // значения закончились
                    if (!$price && !$code) {
                        continue;
                    }

                    try {
                        $this->_addTmpPriceSupplierRecord(
                            $supplier,
                            $code,
                            $name,
                            $articul,
                            $optionarray,
                            $price,
                            $supplierCurrency,
                            $availText,
                            $date,
                            $discount,
                            $minRetail,
                            $recommRetail,
                            $currencyMinretail,
                            $currencyRecommRetail,
                            $dateUpload,
                            $comment,
                            $datelifeto,
                            $x->getId()
                        );
                    } catch (Exception $priceEx) {

                    }
                }
                fclose($f);

                setlocale(LC_ALL, 'ru_RU.UTF-8');
            } else {
                LogService::Get()->add('Неизвесный тип файла', 'supplierPriceImport');
                throw new ServiceUtils_Exception('Unknown file type');
            }
            // закрыть задачу

            $x->setPdate(date("Y-m-d H:i:s"));
            $x->update();
            if ($lastPart) {
                $supplier = $this->getSupplierByID($x->getSupplierid());
                $supplierName = $supplier->makeName();
                LogService::Get()->add(
                    "Распознан и связан прайс {$x->getPricename()} поставщика $supplierName",
                    'supplierPriceImport'
                );
            }


        } else {
            ModeService::Get()->verbose("No supplier price import tasks.");
        }
    }

    /**
     * Пересчитать цены товаров
     */
    public function calculateAllProductPriceWithMargin() {
        // категории
        $category_all = Shop::Get()->getShopService()->getCategoryAll();
        $category_all->addWhereQuery(
            '(`id` IN (SELECT `shopmarginrulelink`.`objectid` FROM `shopmarginrulelink`
            WHERE `shopmarginrulelink`.`objecttype` = \'ShopCategory\'))'
        );

        $category_withrule = array();
        $category_obj = clone $category_all;
        // проверить, есть ли правила для категорий
        $category_rule = true;
        if (!$category_obj->getNext()) {
            $category_rule = false;
        }
        // Смотрим общие правила
        $shopmarginruleLink = new ShopMarginRuleLink;
        $shopmarginruleLink->setObjectid(0);
        $shopmarginrule_all_avail = $shopmarginruleLink->getNext();
        if (!$category_rule) {
            if (!$shopmarginrule_all_avail) {
                // нет правил пересчета цен
                ModeService::Get()->verbose('No MarginRule found...');
            } else {
                ModeService::Get()->verbose('MarginRule for ALL categories...');

                $this->_calculateProductPriceForCategory(0);
            }

        } else {
            // переходим к правилам для категорий
            ModeService::Get()->verbose('MarginRule for categories...');

            $i = 0;
            while ($x = $category_all->getNext()) {
                // категории с правилами
                $category_withrule[$i] = $x->getid();
                $i++;
                ModeService::Get()->verbose('MarginRule for category: '.$x->getName().'...');
                $this->_calculateProductPriceForCategory($x->getId());
            }
            // категории вернего уровня без правил, по общим правилам если они есть
            if ($shopmarginrule_all_avail) {
                $category_all = Shop::Get()->getShopService()->getCategoryAll();
                $category_all->setParentid(0);
                while ($x = $category_all->getNext()) {
                    $category_id = $x->getId();
                    if (in_array($category_id, $category_withrule)) {
                        // пропускаем те что уже отработали
                        continue;
                    }
                    ModeService::Get()->verbose('MarginRule for category: '.$x->getName().'...');
                    $this->_calculateProductPriceForCategory($x->getId());
                }
            }
        }
    }

    /**
     * Создать задачу на пересчет
     *
     * @param int $categoryId
     */
    public function createProductPriceTask($categoryId) {
        $date = date("Y-m-d H:i:s");
        $priceTask = new XShopProductPriceTask();
        $priceTask->setCdate($date);
        $priceTask->setpdate('0000-00-00 00:00:00');
        $priceTask->setCategoryid($categoryId);
        $priceTask->insert();
        // зарегистрировать пересчет
        ProcessorQueService::Get()->addProcessor('MarginRule_Processor_PriceTask');
    }

    /**
     * Проверить задачи на пересчет
     */
    public function processProductPriceTask() {
        ModeService::Get()->verbose('Process margin rules...');

        $pdate = date('Y-m-d H:i:s');
        $calculateIssue = new XShopProductPriceTask();
        $calculateIssue->setPdate('0000-00-00 00:00:00');

        if (!$calculateIssue->select()) {
            return;
        }

        $this->_checkMemoryLimit();

        // есть задача
        $categoryId = $calculateIssue->getCategoryid();
        if ($categoryId) {
            // для конкретной категории
            $this->_calculateProductPriceForCategory($categoryId);
        } elseif ($categoryId == 0) {
            // для всех категорий
            $this->calculateAllProductPriceWithMargin();
        }
        // закрываем задачу
        $calculateIssue->setPdate($pdate);
        $calculateIssue->update();

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = Shop::Get()->getShopService()->getNotificationEmailArray('email-tehnical');
        $host = Engine::Get()->getProjectURL();
        foreach ($emailToArray as $emailTo) {
            // отправить письмо админу о пересчете
            $from = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
            $subj = 'Пересчет цен '.$pdate.' ('.$host.')';
            $body = 'Выполнен фоновый пересчет цен по';
            if (0 == $categoryId) {
                $body .= ' всем категориям';
            } else {
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);
                $body .= ' категории "'.$category->getName().'"';
            }
            $body .= "\nв ".$pdate;
            try {
                Shop::Get()->getUserService()->sendEmail($from, $emailTo, $subj, $body);
            } catch (Exception $exc) {

            }
        }
    }

    /**
     * Массив цен поставщиков в валюте товара
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function getSuppliersPrice(ShopProduct $product) {
        $suppliers_price_array = array();

        $availProduct = Shop::Get()->getSettingsService()->getSettingValue('margin-not-avail-product');

        $productSuppliers = $this->getProductSupplierFromProduct($product);
        while ($productSupplier = $productSuppliers->getNext()) {
            try {
                $s_avail = $productSupplier->getAvail();

                // пропускаем поставщика у которого товар не в наличии
                if (!$s_avail && !$availProduct) {
                    continue;
                }



                $s_id = (int) $productSupplier->getSupplierid();
                // проверка поставщика
                Shop::Get()->getSupplierService()->getSupplierByID($s_id);

                $s_price = (float) $productSupplier->getPrice(); // цена

                $s_discount = (float) $productSupplier->getDiscount(); // скидка
                $s_currencyid = (int) $productSupplier->getCurrencyid(); // валюта

                $s_minretail = (float) $productSupplier->getMinretail(); // мин розница
                // валюта мин розницы
                $s_minretail_cur_id = (int) $productSupplier->getMinretail_cur_id();
                // рекомендуемая розница
                $s_recommretail = (float) $productSupplier->getRecommretail();
                // валюта рекомендуемой розницы
                $s_recommretail_cur_id = (int) $productSupplier->getRecommretail_cur_id();
                // получаем цену в системной валюте
                $s_currency = Shop::Get()->getCurrencyService()->getCurrencyByID($s_currencyid);
                $price = Shop::Get()->getCurrencyService()->convertCurrency(
                    $s_price,
                    $s_currency,
                    $product->getCurrency()
                );
                $minretail = 0;
                if ($s_minretail) {
                    // получаем мин розницу в системной валюте
                    $s_minretail_cur = Shop::Get()->getCurrencyService()->getCurrencyByID($s_minretail_cur_id);
                    $minretail = Shop::Get()->getCurrencyService()->convertCurrency(
                        $s_minretail,
                        $s_minretail_cur,
                        $product->getCurrency()
                    );
                }
                $recommretail = 0;
                if ($s_recommretail) {
                    // получаем рекомендуемую розницу в системной валюте
                    $s_minretail_cur = Shop::Get()->getCurrencyService()->getCurrencyByID($s_recommretail_cur_id);
                    $recommretail = Shop::Get()->getCurrencyService()->convertCurrency(
                        $s_recommretail,
                        $s_minretail_cur,
                        $product->getCurrency()
                    );
                }

                $price_discount = $price - $price * $s_discount / 100; //цена с учетом скидки
                $price_discount = round($price_discount, 2);
                $suppliers_price_array[$s_id] = array(
                    'id' => $s_id,
                    'price_discount' => $price_discount,
                    's_discount' => $s_discount,
                    'minretail' => $minretail,
                    'recommretail' => $recommretail,
                );
            } catch (ServiceUtils_Exception $se) {

            }
        }
        return $suppliers_price_array;
    }

    /**
     * Перевести строк со значения полей - в массив
     *
     * @param string
     *
     * @return array|string
     */
    public function columnNumberToArray($column) {
        $columnArr = explode(',', $column);
        if (count($columnArr) > 1) {
            $columnArr = array_map('trim', $columnArr);
            return $columnArr;
        } else {
            return $column;
        }
    }

    /**
     * Склеить значения колонок поставщика
     * @param mixed $data
     * @param array $arrayFild
     * @param  string $type
     * @param int $iteration
     * @param int $sheetNumber
     * @return string
     */
    public function gluePriceValue( $data, $arrayFild, $type = 'xls', $iteration = false, $sheetNumber = 0) {
        $glueValue = '';
        foreach ($arrayFild as $value) {
            if ($type == 'xls') {
                $glueValue.= ' ' . @trim($data->sheets[$sheetNumber]['cells'][$iteration][$value]);
            } elseif ($type == 'csv') {
                $glueValue.= ' ' . @trim($data[$value - 1]);
            }
        }
        $glueValue = trim($glueValue);
        return $glueValue;
    }

    /**
     * Определить приоритетный источник продукта
     * И вернуть массив результатов пересчета
     *
     * @param mixed $resultSupplier массив или false
     * @param mixed $resultStorageTemp массив или false
     */
    protected function _getPrioritySourceProduct($resultSupplier, $resultStorage) {
        if ($resultStorage) {
            $priceStorage = (float) $resultStorage['price'];
        } else {
            $priceStorage = 0;
        }

        if ($resultSupplier) {
            $priceSupplier = (float) $resultSupplier['price'];
        } else {
            $priceSupplier = 0;
        }

        // Приоритетный источник товара
        $prioritySourceProduct = Shop::Get()->getSettingsService()->getSettingValue('priority-source-product');

        // приоритет поставщик
        if ($prioritySourceProduct == 'supplier') {
            if ($resultSupplier) {
                return $resultSupplier;
            } else {
                return $resultStorage;
            }
        }

        // приоритет склад
        if ($prioritySourceProduct == 'storage') {
            if ($resultStorage) {
                return $resultStorage;
            } else {
                return $resultSupplier;
            }
        }

        // Самая выгодная (низкая) цена
        if ($priceStorage && $priceSupplier) {
            if ($priceSupplier < $priceStorage) {
                return $resultSupplier;
            } elseif ($priceStorage) {
                return $resultStorage;
            }
        } elseif ($priceStorage) {
            return $resultStorage;
        } elseif ($priceSupplier) {
            return $resultSupplier;
        }
    }

    /**
     * Пересчет цены для категории товаров
     *
     * @param integer $categoryid
     */
    private function _calculateProductPriceForCategory($categoryid) {
        try {
            SQLObject::TransactionStart(false, true);
            if ($categoryid == 0) {
                $products = Shop::Get()->getShopService()->getProductsAll();
            } else {
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryid);

                $products = Shop::Get()->getShopService()->getProductsByCategory($category);
            }

            // сбросить supplierid
            $productToUpdate = clone $products;
            $productToUpdate->setSupplierid(0, true);
            $productToUpdate->update(true);

            //$products->setHidden(0);
            $products->filterDeleted(0);
            $products->filterUnsyncable(0);

            $calculateAdditionalPrice = Shop::Get()->getSettingsService()->getSettingValue(
                'calculate-additional-price'
            );

            while ($product = $products->getNext()) {

                try {
                    // цена поставщика
                    $result = $this->calculatePrice($product);

                    if (!$result['price']) {
                        continue;
                    }
                    // availtext supplier
                    $supplierID = $result['supplierid'];
                    try {
                        $currentSupplierObj = Shop::Get()->getShopService()->getSupplierByID(
                            $supplierID
                        );
                        $supplierAvailText = $currentSupplierObj->getAvailtext();
                    } catch (Exception $e) {
                        $supplierAvailText = '';
                    }


                    $pricebase = $result['pricebase'];
                    $pricenew = $result['price'];
                    $priceold = round($product->getPrice(), 2);
                    $rrc = $result['rrc'];
                    if ($pricenew) {
                        // запись в базу, результатов пересчета цен
                        // старая цена, если она больше новой
                        if ($priceold > $pricenew) {
                            $product->setPriceold($priceold);
                        }
                        $product->setPricebase($pricebase);
                        $product->setPrice($pricenew);
                        $product->setSupplierid($supplierID);
                        $product->setAvailtext($supplierAvailText);
                        $product->setRrc($rrc);
                        if ($calculateAdditionalPrice) {
                            $event = Events::Get()->generateEvent('shopMarginProductAfter');
                            $event->setProduct($product);
                            $event->notify();
                        }
                        $product->update();
                    }
                } catch (ServiceUtils_Exception $pe) {
                    print $pe;
                }
            }

            SQLObject::TransactionCommit();
            LogService::Get()->add(
                "{Выполнен пересчет для категории {$category->makeName()}}",
                'marginPrice'
            );
        } catch (ServiceUtils_Exception $se) {
            print $se;
            LogService::Get()->add($se, 'marginPrice');
            SQLObject::TransactionRollback();
        }
    }

    /**
     * Посчитать цену товара по схеме:
     * определить минимальная цену от поставщика + все наценки
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function calculatePriceBySupplier(ShopProduct $product) {
        $suppliers_price_array = Shop::Get()->getSupplierService()->getSuppliersPrice($product);
        $supplier_price_resalt = array();
        $min = 0;
        foreach ($suppliers_price_array as $supplier_data) {
            $discount = 0;
            $incoming_supplier_id = 0;
            $incoming_supplier_id = $supplier_data['id'];
            $price = $supplier_data['price_discount'];

            $minretail = $supplier_data['minretail'];
            $recommretail = $supplier_data['recommretail'];
            $discount = $supplier_data['s_discount'];
            $pricenew = $price;
            // тут прогнать все цены поставщиков

            $links = new ShopMarginRuleLink();
            $category = null;

            // смтрим по категориям товара наличие наценок, начинаем с верхней по иерархии
            // берем самую нижнюю по иерархие категорию с наценками
            $priority = 0;
            for ($i = 1; $i < 10; $i++) {
                $id = $product->getField('category' . $i . 'id');
                if ($id != 0 && $rules = $links->categoryHasMarginrule($id)) {
                    // категория имеет много правил нужно проверить все
                    while ($rule = $rules->getNext()) {
                        $marginrule = Shop::Get()->getShopService()->getMarginRuleByID($rule->getMarginruleid());
                        $marginruleid = $marginrule->getId();
                        $supplierid = $marginrule->getSupplierid();
                        $brandid = $marginrule->getBrandid();

                        if ($brandid && $product->getBrandid() != $brandid) {
                            continue;
                        }

                        if ($supplierid && $incoming_supplier_id != $supplierid) {
                            continue;
                        }

                        if ($marginrule->getPriority() >= $priority) {
                            // берем самое приоритетное правило из всех категорий
                            $category = Shop::Get()->getShopService()->getCategoryByID($id);
                            $priority = $marginrule->getPriority();
                        }
                    }
                }
            }
            if ($category) {
                $links->addWhereArray(array('AllCategories', $category->getClassname()), 'objecttype');
                $links->addWhereArray(array('AllCategories', $category->getId()), 'objectid');
            } else {
                $links->setObjecttype('AllCategories');
                $links->setObjectid(0);
            }


            $ruleArray = array();

            $rulesArray = array(); // массив для сортировки правил по приоритетам
            while ($link = $links->getNext()) {
                try {
                    $rule = Shop::Get()->getShopService()->getMarginRuleByID($link->getMarginruleid());

                    $supplierid = $rule->getSupplierid();
                    $brandid = $rule->getBrandid();
                    $pricefrom = Shop::Get()->getCurrencyService()->convertCurrency(
                        $rule->getPricefrom(),
                        $rule->getCurrency(),
                        $product->getCurrency()
                    );

                    $priceto = Shop::Get()->getCurrencyService()->convertCurrency(
                        $rule->getPriceto(),
                        $rule->getCurrency(),
                        $product->getCurrency()
                    );

                    if ($brandid && $product->getBrandid() != $brandid) {
                        continue;
                    }

                    if ($supplierid && $incoming_supplier_id != $supplierid) {
                        continue;
                    }

                    if (($pricefrom && $price < $pricefrom) ||
                    ($priceto && $price > $priceto)) {
                        continue;
                    }


                    $rulesArray[$rule->getPriority()] = $rule;
                } catch (ServiceUtils_Exception $le) {

                }
            }

            ksort($rulesArray);
            @$rule = end($rulesArray); // берем самое приоритетное правило для данного товара.
            if (is_object($rule)) {
                try {
                    $retail = '';
                    $rrc = 0;
                    $pricenew += $rule->getMarginValue($price, $product->getCurrency());
                    if ($discount) {
                        $retail = "<strong> Учтена скидка поставщика {$discount}%</strong>";
                    }
                    if ($pricenew < $minretail) {
                        $pricenew = $minretail;
                        $rrc = 1;
                        $retail = '<strong> Минимальная розница</strong>';
                    }
                    if ($recommretail) {
                        $pricenew = $recommretail;
                        $rrc = 1;
                        $retail = '<strong> РРЦ</strong>';
                    }
                    if ((!$min || $pricenew < $min) && $pricenew > 0) {
                        $current_supplier_id = $incoming_supplier_id;
                        $ruleArray = array();
                        $min = $pricenew;
                        $ruleName = $rule->makeName() . $retail;
                        $currentprice = $price;
                    }
                } catch (Exception $e) {

                }
            }
        }


        if ($min) {
            $resultArray = array();
            $resultArray['price'] = $min;
            $resultArray['ruleName'] = $ruleName;
            $resultArray['pricebase'] = $currentprice;
            $resultArray['supplierid'] = $current_supplier_id;
            $resultArray['rrc'] = $rrc;

            return $resultArray;
        } else {
            return false;
        }
    }

    /**
     * Получить все товары поставщика.
     * Опция $exclusive = true позволяет выбрать товары, у которых
     * установлен этот поставщик по умолчанию.
     *
     * @param int $supplierID
     * @param bool $exclusive
     *
     * @return ShopProduct
     */
    public function getProductsBySupplier(ShopSupplier $supplier, $exclusive = false) {
        return $this->getProductsBySupplierID($supplier->getId(), $exclusive);
    }

    /**
     * Получить товары по поставщику $supplierID.
     * Опция $exclusive = true позволяет выбрать товары, у которых
     * установлен этот поставщик по умолчанию.
     *
     * @param int $supplierID
     * @param bool $exclusive
     *
     * @return ShopProduct
     */
    public function getProductsBySupplierID($supplierID, $exclusive = false) {
        $supplierID = (int) $supplierID;

        $products = Shop::Get()->getShopService()->getProductsAll();

        if ($exclusive) {
            $products->setSupplierid($supplierID);
        } else {
            $tmp = new XShopProductSupplier();
            $tmp->setSupplierid($supplierID);
            $a = array(-1);
            while ($x = $tmp->getNext()) {
                $a[] = $x->getProductid();
            }

            $products->addWhereArray($a);

        }
        return $products;
    }

    /**
     * Найти товар по поставщику и его коду
     *
     * @param ShopSupplier $supplier
     * @param string $code
     *
     * @return ShopProduct
     */
    public function getProductBySupplierAndCode(ShopSupplier $supplier, $code) {
        $tmp = new XShopProductSupplier();
        $tmp->setSupplierid($supplier->getId());
        $tmp->setCode($code);
        if ($tmp->select()) {
            return Shop::Get()->getShopService()->getProductByID($tmp->getProductid());
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Находит товар по коду поставщика, наименованию, артикулу
     *
     * @param ShopSupplier $supplier
     * @param string $code
     * @param string $productName
     * @param string $articul
     * @param bool $issearchcode искать по коду поставщика
     * @param bool $issearchcodethis  искать только по коду текущего поставщика
     * @param bool $issearchcodemd5 превращать код в md5 trim lowercase
     * @param bool $issearchname точность поиска по имени
     * @param bool $issearcharticul искать по артикулу
     *
     * @return ShopProduct
     */
    public function getProductBySupplierCode(ShopSupplier $supplier, $code, $productName, $articul, $issearchcode,
    $issearchcodethis, $issearchname, $issearcharticul) {
        //$productName = iconv('utf-8', 'utf-8//IGNORE', $productName);
        //$code = iconv('utf-8', 'utf-8//IGNORE', $code);
        //var_dump($code);

        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $codeEscaped = $connection->escapeString($code);
        $productName = $connection->escapeString($productName);

        // превращаем из процентов в чисто от 0 до 1
        $issearchname = $issearchname / 100;


        // Сначала сохраненные выборы пользователя
        $userSelection = new XShopPriceSupplierUserSelection();
        $userSelection->filterName($productName);
        if ($userSelection->select()) {
            try {
                $x = Shop::Get()->getShopService()->getProductByID($userSelection->getProductid());
                if ($x = $x->getNext()) {
                    $x->setMatchReason('Ручной выбор пользователя');
                    return $x;
                }
            } catch (Exception $e) {

            }
        }

        // поиск по коду текущего поставщика
        if ($issearchcode || $issearchcodethis) {
            $a = array(-1);
            $tmp = new XShopProductSupplier();
            $tmp->setSupplierid($supplier->getId());
            $tmp->setCode($code);
            while ($x = $tmp->getNext()) {
                $a[] = $x->getProductid();
            }

            $x = Shop::Get()->getShopService()->getProductsAll();
            $x->addWhereArray($a);
            $x->setLimitCount(1);

            if ($x = $x->getNext()) {
                $x->setMatchReason('По коду поставщика');
                return $x;
            }
        }


        // поиск по артикулу
        if ($articul && $issearcharticul) {
            $x = Shop::Get()->getShopService()->getProductsAll();
            $x->setArticul($articul);
            $x->setLimitCount(1);
            if ($x = $x->getNext()) {
                $x->setMatchReason('По артикулу '.$articul);
                return $x;
            }
        }

        // поиск по артикулу  (выбираем поле модель)
        if ($articul && $issearcharticul) {
            $x = Shop::Get()->getShopService()->getProductsAll();
            $x->setModel($articul);
            $x->setLimitCount(1);
            if ($x = $x->getNext()) {
                $x->setMatchReason('По модели '.$articul);
                return $x;
            }
        }

        // поиск по такому же коду у других поставщиков
        if ($issearchcode && !$issearchcodethis) {
            $a = array(-1);
            $productSupplier = new ShopProductSupplier();
            // исключить текущего
            $productSupplier->addWhere('supplierid', $supplier->getId(), '<>');
            $productSupplier->filterCode($codeEscaped);
            while ($x = $productSupplier->getNext()) {
                $a[] = $x->getProductid();
            }

            $x = Shop::Get()->getShopService()->getProductsAll();
            $x->addWhereArray($a);
            $x->setLimitCount(1);
            if ($x = $x->getNext()) {
                $x->setMatchReason('По коду у другого поставщика');
                return $x;
            }
        }

        // поиск по имени с перестановками
        if ($issearchname && $productName && preg_match_all("/([\d\pL]+)/ius", $productName, $r)) {
            $a = array();

            $totalLength = 0;
            $wordArray = array();
            $sphinx1Array = array();
            $sphinx2Array = array();
            foreach ($r[1] as $x) {
                $totalLength += mb_strlen($x);

                if (preg_match("/(\d+)(\pL+\d+)/ius", $x, $x2)) {
                    $a[] = "name LIKE '%" . $connection->escapeString($x2[1]).
                           "%".$connection->escapeString($x2[2])."%'";

                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];

                    $sphinx1Array[] = '*'.$x2[1].'*';
                    $sphinx1Array[] = '*'.$x2[2].'*';
                    //$sphinx1Array[] = "(={$x2[0]}|(={$x2[1]} ={$x2[2]}))";
                } elseif (preg_match("/^([a-zа-я]+)(\d+)$/ius", $x, $x2)) {
                    $a[] = "name LIKE '%" . $connection->escapeString($x2[1]).
                           "%".$connection->escapeString($x2[2])."%'";

                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];

                    $sphinx1Array[] = '*'.$x2[1].'*';
                    $sphinx1Array[] = '*'.$x2[2].'*';
                } elseif (preg_match("/^(\d+)([a-zа-я]+)$/ius", $x, $x2)) {
                    $a[] = "name LIKE '%" . $connection->escapeString($x2[1]).
                           "%".$connection->escapeString($x2[2])."%'";

                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];

                    $sphinx1Array[] = '*'.$x2[1].'*';
                    $sphinx1Array[] = '*'.$x2[2].'*';
                    //$sphinx1Array[] = "(={$x2[0]}|(={$x2[1]} ={$x2[2]}))";
                } else {
                    $a[] = "name LIKE '%" . $connection->escapeString($x) . "%'";

                    $wordArray[] = $x;

                    if (is_numeric($x)) {
                        $sphinx1Array[] = '*'.$x.'*';
                    } else {
                        $sphinx2Array[] = '*'.$x.'*';
                    }
                }
            }

            // попытка поиска на основе sphinx (будет намного быстрее)
            try {
                $sphinxProductIndex = Engine::Get()->getConfigField('sphinx-product-index');
                $sphinxConnection = ConnectionManager::Get()->getConnection('sphinx');
            } catch (Exception $sphinxEx) {
                $sphinxConnection = false;
                $sphinxProductIndex = false;
            }

            if ($sphinxConnection) {
                // поиск на основе SphinxQL

                // строим запрос
                $query = implode(' ', $sphinx1Array);
                if ($sphinx2Array) {
                    if ($query) {
                        $query .= ' | ';
                    }
                    $query .= implode(' | ', $sphinx2Array);
                }

                $query = "SELECT *
                FROM {$sphinxProductIndex}
                WHERE MATCH ('@name {$query}')
                LIMIT 10
                ";

                $q = $sphinxConnection->query($query);
                while ($x = $sphinxConnection->fetch($q)) {
                    try {
                        $x = Shop::Get()->getShopService()->getProductByID($x['id']);

                        $relevance = StringUtils_SimilarText::CalculateSimilarText($x->getName(), $productName);
                        $accept = $relevance > $issearchname;

                        // если есть числа - то числа должны быть по-любому
                        if ($accept) {
                            $xName = implode('', $this->_explodeString($x->getName()));
                            foreach ($wordArray as $digit) {
                                if (preg_match("/(\d+)/", $digit, $r)) {
                                    if (!substr_count($xName, $r[1])) {
                                        $accept = false;
                                        break;
                                    }
                                }
                            }
                        }

                        if ($accept) {
                            $x->setMatchReason('Sphinx с вероятностью '.round($relevance * 100).'%');
                            return $x;
                        }
                    } catch (Exception $productEx) {

                    }
                }
            } else {
                // поиск по неточному совпадению, до N% схожести
                // без Sphinx
                $x = Shop::Get()->getShopService()->getProductsAll();
                $x->setLimitCount(1);
                $x->addWhereQuery("(" . implode(' OR ', $a) . ")");
                $caseArray = array();
                foreach ($wordArray as $word) {
                    $word = $connection->escapeString($word);
                    $caseArray[] = "(CASE WHEN name LIKE '%{$word}%' THEN ".mb_strlen($word)." ELSE 0 END)";
                }
                $x->addFieldQuery("(".implode(' + ', $caseArray).") AS relevance");
                $x->setOrder('`relevance`', 'DESC');
                if ($x = $x->getNext()) {
                    $relevance = $x->getField('relevance');

                    $xName = implode('', $this->_explodeString($x->getName()));
                    $foundLength = mb_strlen($xName);

                    $accept = $relevance > $totalLength * ($issearchname * 0.8)
                              && $relevance > $foundLength * $issearchname;

                    // если есть числа - то числа должны быть по-любому
                    foreach ($wordArray as $digit) {
                        if (preg_match("/(\d+)/", $digit, $r)) {
                            if (!substr_count($xName, $r[1])) {
                                $accept = false;
                                break;
                            }
                        }
                    }

                    // @todo: пока не удалять
                    // $x->setName($x->getName().' relevance='.$relevance.'/'.$totalLength.
                    // '/'.$foundLength.'/'.$accept);

                    /*if ($code == 'а60') {
                    print $x->getName().' relevance='.$relevance.'/'.$totalLength.'/'.$foundLength.'/'.$accept;
                    print_r($a);
                    print_r($wordArray);
                    exit();
                    }*/

                    if ($accept) {
                        $x->setMatchReason('По имени с вероятностью '.round($relevance / $totalLength * 100).'%');
                        return $x;
                    }
                }
            }
        }

        // поиск по вхождению в имя
        /*if ($productName && $issearchname) {
            $x = Shop::Get()->getShopService()->getProductsAll();
            $x->addWhereQuery("name LIKE '%$productName%'");
            $x->setLimitCount(1);
            if ($x = $x->getNext()) {
                return $x;
            } else {
                $x = Shop::Get()->getShopService()->getProductsAll();
                $x->addWhereQuery("'$productName' LIKE CONCAT('%',name,'%')");
                $x->setLimitCount(1);
                if ($x = $x->getNext()) {
                    return $x;
                }
            }
        }*/

        throw new ServiceUtils_Exception();
    }

    /**
     * Посчитать цену товара и вернуть результат в виде массива.
     * Цена только считается, но не сохраняется в БД.
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function calculatePrice(ShopProduct $product) {
        // цена поставщика
        $resultSupplier = $this->calculatePriceBySupplier($product);

        // цена склада
        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            $resultStorage = $this->calculatePriceByStorage($product);
        } else {
            $resultStorage = false;
        }

        if (!$resultSupplier && !$resultStorage) {
            return false;
        }

        // Определить цену согласно настройкам
        $result = $this->_getPrioritySourceProduct($resultSupplier, $resultStorage);

        if ($result) {
            $result['price'] = round($result['price'], 2);
            $result['pricebase'] = round($result['pricebase'], 2);
        }

        return $result;
    }

    /**
     * Посчитать цену продажи и себестоимость по данным склада.
     * Метод возвращает массив array(Цена, базовая цена, название склада, название наценки)
     *
     * @param ShopProduct $product
     *
     * @return array | false
     */
    public function calculatePriceByStorage(ShopProduct $product) {
        $balance = StorageBalanceService::Get()->getBalanceByProductAndStoragesForSale(
            false, // cuser
            $product
        );

        $s = $balance->getNext();

        // Нет наличия на складе
        if (!$s || !(int) $s->getAmount() || !$s->getCurrencyid()) {
            return false;
        }

        $priceBase = 0;
        $priceNew = 0;
        $rcc = 0;
        $ruleName = '';

        // валюта товара
        $currencyProduct = $product->getCurrency();
        // системная валюта
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        // rcc from storage
        try{
            $storageName = StorageNameService::Get()->getStorageNameByID($s->getStoragenameid());
            $rcc = StorageBalanceService::Get()->getProductStrorageRRC(
                $product,
                $storageName,
                $currencyProduct
            );
        } catch (Exception $e) {

        }

        // Базовая цена продукта в валюте товара
        $priceBase = Shop::Get()->getCurrencyService()->convertCurrency(
            $s->getPrice(),
            Shop::Get()->getCurrencyService()->getCurrencyByID($s->getCurrencyid()),
            $currencyProduct
        );

        // Системная валюта
        $priceBaseSystem = Shop::Get()->getCurrencyService()->convertCurrency(
            $s->getPrice(),
            Shop::Get()->getCurrencyService()->getCurrencyByID($s->getCurrencyid()),
            $currencySystem
        );

        // название склада
        $nameStorage = $s->getStorageName()->getName();

        if ($rcc) {
            $priceNew = $rcc;
            $ruleName = ' РЦЦ склад';
        } else {
            // наиболее приоритетное правило
            $rule = $this->_getMaxPriorityMarginRule($product, $priceBaseSystem);

            if (!$rule) {
                return false;
            }

            // цена с наценкой
            $priceNew = $priceBase + $rule->getMarginValue($priceBase, $product->getCurrency());
            $ruleName = $rule->makeName();
        }

        $resultArray = array();
        $resultArray['price'] = $priceNew;
        $resultArray['pricebase'] = $priceBase;
        $resultArray['rrc'] = $rcc;
        $resultArray['ruleName'] = "Склад: {$nameStorage}. Правило:".$ruleName;
        $resultArray['supplierid'] = 0;

        return $resultArray;
    }

    /**
     * Получить для товара, самое приоритетное правило наценки
     *
     * @param ShopProduct $product
     * @param float $price Цена нужна для проверки вхождения в правило
     * @param integer $incommingSupplierId = 0  Для вхождение в правила с поставщиками
     *
     * @return ShopMarginRuleLink|false
     */
    private function _getMaxPriorityMarginRule(ShopProduct $product, $price, $incommingSupplierId = 0) {
        $links = new ShopMarginRuleLink();
        $category = null;

        // смотрим по категориям товара наличие наценок, начинаем с верхней по иерархии
        // берем самую нижнюю по иерархие категорию с наценками
        $priority = 0;

        for ($i = 1; $i < 10; $i++) {
            $id = $product->getField('category' . $i . 'id');
            if (!$id) {
                continue;
            }

            $rules = $links->categoryHasMarginrule($id);
            if (!$rules) {
                continue;
            }
            while ($rule = $rules->getNext()) {
                $marginrule = Shop::Get()->getShopService()->getMarginRuleByID($rule->getMarginruleid());
                $supplierid = $marginrule->getSupplierid();
                $brandid = $marginrule->getBrandid();

                if ($brandid && $product->getBrandid() != $brandid) {
                    continue;
                }

                if ($supplierid && $incommingSupplierId != $supplierid) {
                    continue;
                }

                // берем самое приоритетное правило из всех категорий
                if ($marginrule->getPriority() >= $priority) {
                    $category = Shop::Get()->getShopService()->getCategoryByID($id);
                    $priority = $marginrule->getPriority();
                }
            }
        }

        if ($category) {
            $links->addWhereArray(array('AllCategories', $category->getClassname()), 'objecttype');
            $links->addWhereArray(array('AllCategories', $category->getId()), 'objectid');
        } else {
            $links->setObjecttype('AllCategories');
            $links->setObjectid(0);
        }

        $ruleArray = array();

        $rulesArray = array();
        while ($link = $links->getNext()) {
            try {
                $rule = Shop::Get()->getShopService()->getMarginRuleByID($link->getMarginruleid());

                // системная валюта
                $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

                $supplierid = $rule->getSupplierid();
                $brandid = $rule->getBrandid();

                $pricefrom = Shop::Get()->getCurrencyService()->convertCurrency(
                    $rule->getPricefrom(),
                    $rule->getCurrency(),
                    $currencySystem
                );

                $priceto = Shop::Get()->getCurrencyService()->convertCurrency(
                    $rule->getPriceto(),
                    $rule->getCurrency(),
                    $currencySystem
                );

                if ($brandid && $product->getBrandid() != $brandid) {
                    continue;
                }

                if ($supplierid && $incommingSupplierId != $supplierid) {
                    continue;
                }

                if (($pricefrom && $price < $pricefrom) ||
                ($priceto && $price > $priceto)) {
                    continue;
                }

                $rulesArray[$rule->getPriority()] = $rule;
            } catch (ServiceUtils_Exception $le) {
                print $e;
            }
        }

        ksort($rulesArray);
        // берем самое приоритетное правило для данного товара.
        @$rule = end($rulesArray);

        if (!is_object($rule)) {
            return false;
        }

        return $rule;
    }

    /**
     * Обновить информацию поставщика в конкретном товаре
     *
     * @param ShopProduct $product
     * @param ShopSupplier $supplier
     * @param string $code
     * @param float $price
     * @param ShopCurrency $currency
     * @param bool $avail
     * @param string $availText
     * @param float $discount
     */
    public function updateProductSupplierInfo(ShopProduct $product, ShopSupplier $supplier, $code, $price,
    ShopCurrency $currency, $avail, $availText, $discount) {
        //$supplierNum = $this->_getSupplierNumber($product, $supplier);

        $productSupplier = new ShopProductSupplier();
        $productSupplier->filterProductid($product->getId());
        $productSupplier->filterSupplierid($supplier->getId());
        if (!$productSupplier->select()) {
            $productSupplier->insert();
        }
        $date = date('Y-m-d H:i:s');
        $price = StringUtils_FormatterPrice::format($price);


        $productSupplier->setCode($code);
        $productSupplier->setPrice($price);
        $productSupplier->setCurrencyid($currency->getId());
        $productSupplier->setAvailtext($availText);
        $productSupplier->setAvail($avail);
        $productSupplier->setDate($date);
        $productSupplier->setDiscount($discount);
        $productSupplier->update();

    }

    /**
     * Выполнить пересчет наличия.
     * Сначала считается наличие по поставщику, затем наличие по складу,
     * затем итоговое.
     *
     * Метод выбрасывает события beforeProductAvailProcess
     * и afterProductAvailProcess, на которые можно прицепить свои обработчики.
     */
    public function processProductAvails() {
        ModeService::Get()->verbose('Process product avails...');

        $this->_checkMemoryLimit();

        $event = Events::Get()->generateEvent('beforeProductAvailProcess');
        $event->notify();

        // Наличие у поставщиков
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->filterUnsyncable(0);
        $products->filterDeleted(0);
        $products->filterHidden(0);

        // ставим всем товарам "наличие у поставщика = 0"
        $products->setSuppliered(0, true);
        $products->update(true);

        // ставим товарам "наличие у поставщика = 1"
        $a = array(-1);
        $tmp = new ShopProductSupplier();
        $tmp->filterAvail(1);
        while ($x = $tmp->getNext()) {
            $a[] = $x->getProductid();
        }

        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->filterHidden(0);
        $products->filterDeleted(0);
        $products->filterUnsyncable(0);
        $products->addWhereArray($a);
        $products->setSuppliered(1, true);
        $products->update(true);

        // @todo: разнести по модулям
        // склады на первом месте
        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            $idArray = StorageBalanceService::Get()->updateProductsAvailable();
            $idArray[] = -1;
        } else {
            $idArray = array(-1);
        }

        // наличие от поставщиков на втором месте.
        // наличие продукта соответствует наличию у любого из поставщиков
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = "
        UPDATE
            shopproduct
        SET
            avail = suppliered
        WHERE
            id NOT IN (".implode(',', $idArray).")
            AND hidden=0
            AND deleted=0
            AND unsyncable=0
        ";
        $connection->query($query);

        $event = Events::Get()->generateEvent('afterProductAvailProcess');
        $event->notify();
    }

    /**
     * Обновить товар из прайса поставщика
     *
     * @param $supplier
     * @param $code
     * @param $name
     * @param $articul
     * @param $optionarray
     * @param $price
     * @param $currency
     * @param $availText
     * @param $date
     * @param $discount
     * @param $minRetail
     * @param $recommRetail
     * @param $currencyMinRetail
     * @param $currencyRecommRetail
     *
     * @return ShopProduct
     */
    private function _updateProductWithPriceSupplier(ShopSupplier $supplier, $code, $name, $articul, $optionarray,
    $price, ShopCurrency $currency, $availText, $date, $discount, $minRetail, $recommRetail,
    ShopCurrency $currencyMinRetail, ShopCurrency $currencyRecommRetail, $dateUpdate, $comment, $datelifeto) {
        // настройки поиска
        $issearchcode = false;
        $issearchcodethis = false;
        $issearchcodemd5 = false;
        $issearcharticul = false;
        $issearchname = false;
        $createnewproduct = false;
        $onlyRetail = false;
        $removeMinretail = false;
        $removeRecommretail = false;
        if (in_array('isSearchCode', $optionarray, true)) {
            $issearchcode = true;
        }
        if (in_array('isSearchCodeThis', $optionarray, true)) {
            $issearchcodethis = true;
        }
        if (in_array('isSearchCodeMD5', $optionarray, true)) {
            $issearchcodemd5 = true;
        }
        if (in_array('isSearchArticul', $optionarray, true)) {
            $issearcharticul = true;
        }
        if (in_array('isSearchName', $optionarray, true)) {
            $issearchname = true;
        }
        $nameSearchPrecision = $optionarray['nameSearchPrecision'];

        // создавать ли новые товары
        if (in_array('createNewProduct', $optionarray, true)) {
            $createnewproduct = true;
        }
        // импорт только рцц и мин розницы
        if (in_array('onlyRetail', $optionarray, true)) {
            $onlyRetail = true;
        }

        if (in_array('removeMinretail', $optionarray, true)) {
            $removeMinretail = true;
        }
        if (in_array('removeRecommretail', $optionarray, true)) {
            $removeRecommretail = true;
        }

        if ($issearchcodemd5) {
            $code = str_replace(' ', '', $code);
            $code = trim($code);
            $code = md5($code);
        }

        $isNew = false;
        try {
            $product = $this->getProductBySupplierCode(
                $supplier,
                $code,
                $name,
                $articul,
                $issearchcode,
                $issearchcodethis,
                $nameSearchPrecision,
                $issearcharticul
            );
        } catch (ServiceUtils_Exception $se) {
            print $se;

            // если сказано создавать новые товары
            // или импортировать только рцц/мин розницу
            // при импорте рцц/мин розницы, создание новых товаров не целесообразно
            if (!$createnewproduct || !$name || $onlyRetail) {
                // @todo: report
                return false;
            }
            $product = Shop::Get()->getShopService()->addProduct($name);
            $product->setHidden(0);
            $isNew = true;
        }

        print 'Supplier up '.$product->getId()."\n";

        if ($articul && !$product->getArticul()) {
            $product->setArticul($articul);
        }

        $discount = abs($discount);
        if ($discount < 1 && $discount > 0) {
            $discount = $discount * 100;
        }

        // отмечаем что товар был в прайсе
        $product->setSync(0);

        if ($datelifeto && $datelifeto != '0000-00-00 00:00:00') {
            $product->setDatelifeto($datelifeto);
        }

        $product->update();


        if ($availText == '0.0' || $availText == '0') {
            $availText = '';
        }

        if ($availText) {
            $supplierAvail = 1;
        } else {
            $supplierAvail = 0;
        }
        $productSupplier = new ShopProductSupplier();
        $productSupplier->setProductid($product->getId());
        $productSupplier->setSupplierid($supplier->getId());
        if (!$productSupplier->select()) {
            $productSupplier->insert();
        }

        if (!$onlyRetail) {
            $productSupplier->setCode($code);
            $productSupplier->setPrice($price);
            $productSupplier->setCurrencyid($currency->getId());
            $productSupplier->setAvailtext($availText);
            $productSupplier->setComment($comment);
            $productSupplier->setAvail($supplierAvail);
            $productSupplier->setDate($date);
            $productSupplier->setDiscount($discount);
        }
        if ($minRetail) {
            $productSupplier->setMinretail($minRetail);
            $productSupplier->setMinretail_cur_id($currencyMinRetail->getId());
        }
        if ($recommRetail) {
            $productSupplier->setRecommretail($recommRetail);
            $productSupplier->setRecommretail_cur_id($currencyRecommRetail->getId());
        }
        if ($removeMinretail) {
            $productSupplier->setMinretail(0);
            $productSupplier->setMinretail_cur_id(0);
        }
        if ($removeRecommretail) {
            $productSupplier->setRecommretail(0);
            $productSupplier->setRecommretail_cur_id(0);
        }
        $productSupplier->update();
        // добавить запись о обновлении товара
        $this->_updatePriceSupplierImportReport($product, $dateUpdate, $isNew);
    }

    /**
     * Получить номер, под которым поставщик записан у товара
     *
     * @param ShopProduct $product
     * @param ShopSupplier $supplier
     *
     * @deprecated
     *
     * @return int
     */

    private function _getSupplierNumber(ShopProduct $product, ShopSupplier $supplier) {
        for ($j = 1; $j <= 10; $j++) {
            if ($product->getField('supplier' . $j . 'id') == $supplier->getId()) {
                return $j;
            }
        }
        return false;
    }

    /**
     * Проставить наличие продуктам поставщика, которых не было в прайсе
     *
     * @param ShopSupplier $supplier
     */
    private function _updateSupplierProductAvail(ShopSupplier $supplier) {
        try {
            $products = $this->getProductsBySupplierID(
                $supplier->getId()
            );
            $products->filterSync(1);
            $a = array(-1);

            while ($x = $products->getNext()) {
                $a[] = $x->getId();
                $x->setSync(0);
                $x->update();
            }

            $productSupplier = new ShopProductSupplier();
            $productSupplier->filterSupplierid($supplier->getId());
            $productSupplier->addWhereArray($a, 'productid');
            while ($x = $productSupplier->getNext()) {
                $x->setAvailtext('Нет в прайсе');
                $x->setAvail(0);
                $x->setDate(date('Y-m-d H:i:s'));
                $x->update();
            }

        } catch (Exception $e) {

        }
    }

    /**
     * Добавить запись, о обновлении продукта из прайса поставщика
     *
     * @param ShopProduct $product
     * @param integer $dateUpdate
     * @param bool $isNew
     * @param bool $error
     */
    private function _updatePriceSupplierImportReport(ShopProduct $product, $dateUpdate, $isNew, $error = 0) {
        $report = new XPriceSupplierImportReport();
        $report->setProductname($product->getName());
        $report->setProductid($product->getId());
        $report->setDateupdate($dateUpdate);
        $report->setIsnew($isNew);
        $report->setError($error);
        $report->insert();
    }

    /**
     * Обработать данные загрузки прайса  и обновить отчет загрузки
     *
     * @param string $dateUpload
     * @param string $dateProcessed
     */
    private function _updateSupplierImportStatus($dateUpload, $dateProcessed) {
        $diffArrayUpdate = array();
        $diffArrayInsert = array();
        $diffArrayError = array();

        $report = new XPriceSupplierImportReport();
        $report->filterDateupdate($dateUpload);

        // Обновлено
        $reportUpdate = clone $report;
        $reportUpdate->filterError(0);
        $reportUpdate->filterIsnew(0);
        $countUpdate = $reportUpdate->getCount();
        while ($x = $reportUpdate->getNext()) {
            $diffArrayUpdate[] = "Обновлен товар: #{$x->getProductid()} {$x->getProductname()}";
        }

        // Добавлено
        $reportAdd = clone $report;
        $reportAdd->filterError(0);
        $reportAdd->filterIsnew(1);
        $countAdd = $reportAdd->getCount();
        while ($x = $reportAdd->getNext()) {
            $diffArrayInsert[] = "Добавлен  товар: #{$x->getProductid()} {$x->getProductname()}";
        }

        // Ошибки
        $reportError = clone $report;
        $reportError->filterError(1);
        $countError =  $reportError->getCount();
        while ($x = $reportError->getNext()) {
            $diffArrayError[] = "Ошибка добавления товара: #{$x->getgetProductid()} {$x->getProductname()}";
        }

         // Отчет
        $resultText = '';
        if ($diffArrayUpdate) {
            $resultText .= " --- Обновлено:\n\n";
            $resultText .= implode("\n", $diffArrayUpdate);
        }

        $resultText .= "\n============================================================\n";

        if ($diffArrayInsert) {
            $resultText .= " --- Добавлено:\n\n";
            $resultText .= implode("\n", $diffArrayInsert);
        }

        $resultText .= "\n============================================================\n";

        if ($diffArrayError) {
            $resultText .= " --- Ошибки:\n\n";
            $resultText .= implode("\n", $diffArrayError);
        }

        // дописать данные в статус
        $importStatus = new XPriceSupplierImportStatus();
        $importStatus->filterDateupload($dateUpload);
        if ($importStatus->select()) {
            $importStatus->setProcessed(1);
            $importStatus->setDateprocessed($dateProcessed);
            $importStatus->setResultsuccess($countUpdate);
            $importStatus->setResultadded($countAdd);
            $importStatus->setResultfail($countError);
            $importStatus->setResulttext($resultText);
            $importStatus->update();
        }
    }

    /**
     * Отчет на почту о обновлении товаров, при загрузке прайса поставщика
     *
     * @param integer $dateUdate
     */
    private function _sendReportPriseSupplierImport($dateUdate) {
        PackageLoader::Get()->import('CSV');
        // обновлено
        $diffArrayUpdate = array();
        $report = new XPriceSupplierImportReport();
        $report->setIsnew(0);
        $report->setDateupdate($dateUdate);
        $a = array();
        while ($x = $report->getNext()) {
            $a[] = array(
                'id' => $x->getProductid(),
                'name' => $x->getProductname(),
                'status' => 'Updated'
            );
            $diffArrayUpdate[] = "Обновлен товар: #{$x->getProductid()} {$x->getProductname()}";
            $x->delete();
        }
        // добавлено
        $diffArrayInsert = array();
        $report = new XPriceSupplierImportReport();
        $report->setIsnew(1);
        $report->setDateupdate($dateUdate);
        while ($x = $report->getNext()) {
            $a[] = array(
                'id'=>$x->getProductid(),
                'name'=>$x->getProductname(),
                'status'=>'Added'
            );
            $diffArrayInsert[] = "Добавлен  товар: #{$x->getProductid()} {$x->getProductname()}";
            $x->delete();
        }

        //содержимое CSV
        $contentCSV='';
        foreach ($a as $value) {
            $contentCSV .= $value['id'].' '.$value['name'].' ('.$value['status'].')'."\n";
        }
        // Отправляем письмо с отчетом.
        // От кого
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // Тело сообщения
        $emailBody = '';
        if ($diffArrayUpdate) {
            $emailBody .= " --- Обновлено: ".count($diffArrayUpdate)."\n\n";
        }

        if ($diffArrayInsert) {
            $emailBody .= " --- Добавлено: ".count($diffArrayInsert)."\n";
        }

        $emailBody .= "\n============================================================\n";
        $emailBody .= $contentCSV;
        $emailBody .= "\n============================================================\n";

        $emailTo = Shop::Get()->getSettingsService()->getSettingValue('email-tehnical');

        // отправляем
        $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Supplier import products. ', $emailBody);
        $csv = CSV_Creator::CreateFromArray($a, true);
        $letter->addAttachment(
            file_get_contents($csv->__toFile()),
            'status_import_price_supplier.csv',
            'text/csv'
        );
        $letter->send();
    }

    /**
     * Разбить строку на массив ключевых слов
     *
     * @param string $s
     *
     * @return array
     */
    private function _explodeString($s) {
        if (preg_match_all("/([\d\pL]+)/ius", $s, $r)) {
            $wordArray = array();
            foreach ($r[1] as $x) {
                if (preg_match("/(\d+)(\pL+\d+)/ius", $x, $x2)) {
                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];
                } elseif (preg_match("/^([a-zа-я]+)(\d+)$/ius", $x, $x2)) {
                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];
                } elseif (preg_match("/^(\d+)([a-zа-я]+)$/ius", $x, $x2)) {
                    $wordArray[] = $x2[1];
                    $wordArray[] = $x2[2];
                } else {
                    $wordArray[] = $x;
                }
            }

            return $wordArray;
        }

        return array();
    }

    /**
     * Выполнить конвертацию XLS/XLSX в CSV если это возможно.
     * Используется наш специальный скрипт xls_to_csv.py
     *
     * @param string $fileXls Description
     */
    public function convertXLStoCSV($fileXls) {
        $dir = PackageLoader::Get()->getProjectPath().'media/import/csv/';
        if (!is_dir($dir)) {
            mkdir($dir, 0777);
        }
        $b = 1;
        $fileXls = PackageLoader::Get()->getProjectPath().'media/import/'.$fileXls;
        $pyScript = PackageLoader::Get()->getProjectPath().'packages/XLS/xls_to_csv.py';
        $fileXls = escapeshellarg($fileXls);
        $command = 'python '.$pyScript.' '. $fileXls.' '.$dir;
        system($command, $b);
        return $b;
    }

    // Методы получения данных по поставщику товара

    /**
     * Получить ShopProductSupplier
     * данные конкретного поставщика для конкретного товара
     *
     * @param ShopProduct $product
     * @param ShopSupplier $supplier
     *
     * @return ShopProductSupplier
     *
     * @throws ServiceUtils_Exception
     */

    public function getShopProductSupplier(ShopProduct $product, ShopSupplier $supplier) {
        $productSupplier = new ShopProductSupplier();
        $productSupplier->filterProductid($product->getId());
        $productSupplier->filterSupplierid($supplier->getId());
        if ($productSupplier->select()) {
            return $productSupplier;
        }
        throw new ServiceUtils_Exception('ShopProductSupplier not found');
    }

    /**
     * Получить все записи ShopProductSupplier по товару
     *
     * @param ShopProduct $product
     *
     * @return ShopProductSupplier
     *
     * @throws ServiceUtils_Exception
     */

    public function getProductSupplierFromProduct(ShopProduct $product) {
        $productSupplier = new ShopProductSupplier();
        $productSupplier->filterProductid($product->getId());
        return $productSupplier;
    }


    /**
     * Привести в формат массива номера обрабатываемых листов введенных пользователем
     *
     * @param string $processed_lists
     */
    private function _listsNumberToArray($processed_lists) {
        $processedListsArray = explode(',', $processed_lists);
        $processedListsArray = array_map('trim', $processedListsArray);
        // Удалить пустые значения
        $tempArray = array();
        foreach ($processedListsArray as $value) {
            $value = (int) $value;
            if (!$value) {
                continue;
            }
            $tempArray[] = $value;
        }
        return $tempArray;
    }

    private function _checkMemoryLimit() {
        $memory_limit = ini_get('memory_limit');
        if (preg_match('/^(\d+)(.)$/', $memory_limit, $matches)) {
            if ($matches[2] == 'M') {
                $matches[1] = $matches[1];
            }
            if ($matches[2] == 'G') {
                $matches[1] = $matches[1] * 1024;
            }
            if ($matches[1] < 500) {
                ModeService::Get()->verbose(
                    "Warning: memory_limit is ".$matches[1].$matches[2].", expected 500M or more"
                );
            }
        }
    }

    private function _addTmpPriceSupplierRecord(ShopSupplier $supplier, $code, $name, $articul, $optionarray,
    $price, ShopCurrency $currency, $availText, $date, $discount, $minRetail, $recommRetail,
    ShopCurrency $currencyMinRetail, ShopCurrency $currencyRecommRetail, $dateUpdate, $comment, $datelifeto, $priceId) {
        // проверим игнор лист
        try {
            $productIgnore =  $this->_checkProductSupplierIgnore($name, $supplier->getId(), $code);
            $productIgnore->setCode($code);
            $productIgnore->setPrice($price);
            $productIgnore->setCurrencyid($currency->getId());
            $productIgnore->setAvailtext($availText);
            $productIgnore->update();
            return;
        } catch (Exception $e) {

        }

        // настройки поиска
        $issearchcode = false;
        $issearchcodethis = false;
        $issearchcodemd5 = false;
        $issearcharticul = false;
        $onlyRetail = false;
        $removeMinretail = false;
        $removeRecommretail = false;
        if (in_array('isSearchCode', $optionarray, true)) {
            $issearchcode = true;
        }
        if (in_array('isSearchCodeThis', $optionarray, true)) {
            $issearchcodethis = true;
        }
        if (in_array('isSearchCodeMD5', $optionarray, true)) {
            $issearchcodemd5 = true;
        }
        if (in_array('isSearchArticul', $optionarray, true)) {
            $issearcharticul = true;
        }
        $nameSearchPrecision = $optionarray['nameSearchPrecision'];

        // импорт только рцц и мин розницы
        if (in_array('onlyRetail', $optionarray, true)) {
            $onlyRetail = true;
        }

        if (in_array('removeMinretail', $optionarray, true)) {
            $removeMinretail = true;
        }
        if (in_array('removeRecommretail', $optionarray, true)) {
            $removeRecommretail = true;
        }

        if ($issearchcodemd5) {
            $code = str_replace(' ', '', $code);
            $code = trim($code);
            $code = md5($code);
        }

        $isNew = false;
        try {
            $product = $this->getProductBySupplierCode(
                $supplier,
                $code,
                $name,
                $articul,
                $issearchcode,
                $issearchcodethis,
                $nameSearchPrecision,
                $issearcharticul
            );
        } catch (ServiceUtils_Exception $se) {
            if (!$name || $onlyRetail) {
                // @todo: report
                return false;
            }
            $product = null;
            $isNew = true;
        }


        $discount = abs($discount);
        if ($discount < 1 && $discount > 0) {
            $discount = $discount * 100;
        }
        if ($availText == '0.0' || $availText == '0') {
            $availText = '';
        }

        if ($availText) {
            $supplierAvail = 1;
        } else {
            $supplierAvail = 0;
        }
        $oldPrice = 0;
        $oldPriceCurrency = 0;
        $oldAvailText = '';
        $oldDate = '0000-00-00 00:00:00';
        // проверка на поставщика
        if ($product) {
            try {
                $productSupplier = Shop::Get()->getSupplierService()->getShopProductSupplier(
                    $product, $supplier
                );
                $oldPrice = $productSupplier->getPrice();
                $oldPriceCurrency = $productSupplier->getCurrencyid();
                $oldAvailText = $productSupplier->getAvailtext();
                $oldDate = $productSupplier->getDate();
            } catch (Exception $e) {

            }
        }

        // создать временную запись
        $tpmPriceSupplier = new XShopTmpPrice();
        // id прайса
        $tpmPriceSupplier->setPriceid($priceId);
        $tpmPriceSupplier->setArticul($articul);
        $tpmPriceSupplier->setIsnew($isNew);
        $tpmPriceSupplier->setName($name);
        if ($datelifeto && $datelifeto != '0000-00-00 00:00:00') {
            $tpmPriceSupplier->setDatelifeto($datelifeto);
        }
        $tpmPriceSupplier->setAvailtext($availText);
        $tpmPriceSupplier->setAvail($supplierAvail);
        if (!$isNew) {
            $tpmPriceSupplier->setProductid($product->getId());
            $tpmPriceSupplier->setMatchreason($product->getMatchReason());
        }
        $tpmPriceSupplier->setOldprice($oldPrice);
        $tpmPriceSupplier->setOldpricecurrencyid($oldPriceCurrency);
        $tpmPriceSupplier->setOldavailtext($oldAvailText);
        $tpmPriceSupplier->setOlddate($oldDate);
        $tpmPriceSupplier->setSupplierid($supplier->getId());
        $tpmPriceSupplier->setCode($code);
        $tpmPriceSupplier->setPrice($price);
        $tpmPriceSupplier->setDateupload($dateUpdate);
        $tpmPriceSupplier->setCurrencyid($currency->getId());
        $tpmPriceSupplier->setComment($comment);
        $tpmPriceSupplier->setDate($date);
        $tpmPriceSupplier->setDiscount($discount);
        $tpmPriceSupplier->setMinretail($minRetail);
        $tpmPriceSupplier->setMinretailcurrrncyid($currencyMinRetail->getId());
        $tpmPriceSupplier->setRecommretail($recommRetail);
        $tpmPriceSupplier->setRecommretailcurrruncyid($currencyRecommRetail->getId());
        $tpmPriceSupplier->setIsRemoveMinretail($removeMinretail);
        $tpmPriceSupplier->setIsRemoveRecommretail($removeRecommretail);
        $tpmPriceSupplier->setOnlyRetail($onlyRetail);
        $tpmPriceSupplier->insert();

    }

    /**
     * Получить игнорируемый товар
     *
     * @param $name
     * @param $supplierId
     *
     * @return XShopPriceSupplierIgnore
     *
     * @throws ServiceUtils_Exception
     */
    private function _checkProductSupplierIgnore ($name, $supplierId, $code) {
        $productIgnore = new XShopPriceSupplierIgnore();
        $productIgnore->filterName($name);
        $productIgnore->filtersupplierid($supplierId);
        if ($productIgnore->select()) {
            return $productIgnore;
        }
        $productIgnore = new XShopPriceSupplierIgnore();
        $productIgnore->filterCode($code);
        $productIgnore->filtersupplierid($supplierId);
        if ($productIgnore->select()) {
            return $productIgnore;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_SupplierService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }

    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_SupplierService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}