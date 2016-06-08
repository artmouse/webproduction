<?php

class products_supplier_import extends Engine_Class {

    public function process() {
        /*Shop_SupplierService::Get()->importSupplierPrice();
        exit;*/
        ini_set('max_input_vars', 100000);
        ini_set('suhosin.post.max_vars', 100000);
        ini_set('suhosin.request.max_vars', 100000);
        ini_set('memory_limit', '512M');
        set_time_limit(5 * 60); // 5 min

        // проверить процесор и если есть запись ждать
        $processor = new XShopProcessorQue();
        $processor->filterLogicclass('ShopSupplier_Processor_UploadProducts');
        if ($processor->select()) {
            $this->setValue('process', true);
        }

        try{
            // 1 потому что результат положительной обработки 0
            $resaltConvert = 1;

            if ($this->getControlValue('ok')) {
                $resultImportCron = Shop::Get()->getSupplierService()->createSupplierImport(
                    $this->getControlValue('supplierid'),
                    $this->getControlValue('currencysupplierid'),
                    $this->getControlValue('file'),
                    $this->getControlValue('type'),
                    $this->getControlValue('encoding'),
                    $this->getControlValue('columncode'),
                    $this->getControlValue('columnname'),
                    $this->getControlValue('columnprice'),
                    $this->getControlValue('columnarticul'),
                    $this->getControlValue('columnminretail'),
                    $this->getControlValue('currencyminretail'),
                    $this->getControlValue('columnrecommretail'),
                    $this->getControlValue('currencyrecommretail'),
                    $this->getControlValue('columnavail'),
                    $this->getControlValue('columndiscount'),
                    $this->getControlValue('issearchcode'),
                    $this->getControlValue('issearchcodethis'),
                    $this->getControlValue('issearchcodemd5'),
                    $this->getControlValue('issearchname'),
                    $this->getControlValue('issearchnameprecision'),
                    $this->getControlValue('issearcharticul'),
                    $this->getControlValue('createNewProduct'),
                    $this->getControlValue('onlyRetail'),
                    $this->getControlValue('removeMinretail'),
                    $this->getControlValue('removeRecommretail'),
                    $this->getControlValue('notimportemptyprice'),
                    $this->getControlValue('columncomment'),
                    $this->getControlValue('datelifeto'),
                    $this->getControlValue('processedLists'),
                    $this->getControlValue('notimportemptyavail')
                );

                $dateUpload = $resultImportCron['date'];
                $resaltConvert = $resultImportCron['resaltConvert'];
                $this->setValue('dateUpload', $dateUpload);
            }
        } catch (ServiceUtils_Exception $e) {
            $this->setValue('message', 'error');
            $this->setValue('errorArray', $e->getErrorsArray());
        }

        // Запоминание настроек импорта, для поставщика
        if ($this->getControlValue('ok')) {
            $availableConfig = true;
            $importConfig = new XShopPriceSupplierConfig();
            $saveSupplierId = $this->getControlValue('supplierid');

            $importConfig->filterSupplierid($saveSupplierId);
            if (!$importConfig->select()) {
                $importConfig = new XShopPriceSupplierConfig();
                $availableConfig = false;
            }
            $importConfig->setSupplierid($saveSupplierId);
            $importConfig->setSuppliercurrencyid($this->getControlValue('currencysupplierid'));
            $importConfig->setFiletype($this->getControlValue('type'));
            $importConfig->setFileencoding($this->getControlValue('encoding'));
            $importConfig->setColumncode($this->getControlValue('columncode'));
            $importConfig->setColumnname($this->getControlValue('columnname'));
            $importConfig->setColumnarticul($this->getControlValue('columnarticul'));
            $importConfig->setColumnprice($this->getControlValue('columnprice'));
            $importConfig->setColumnminretail($this->getControlValue('columnminretail'));
            $importConfig->setMinretail_cur_id($this->getControlValue('currencyminretail'));
            $importConfig->setColumnrecommretail($this->getControlValue('columnrecommretail'));
            $importConfig->setRecommretail_cur_id($this->getControlValue('currencyrecommretail'));
            $importConfig->setColumnavail($this->getControlValue('columnavail'));
            $importConfig->setColumncomment($this->getControlValue('columncomment'));
            $importConfig->setColumndiscount($this->getControlValue('columndiscount'));
            $importConfig->setLimitfrom($this->getControlValue('limitfrom'));
            $importConfig->setLimitto($this->getControlValue('limitto'));
            $importConfig->setIssearchcode($this->getControlValue('issearchcode'));
            $importConfig->setIssearchcodethis($this->getControlValue('issearchcodethis'));
            $importConfig->setIssearchcodemd5($this->getControlValue('issearchcodemd5'));
            $importConfig->setIssearchname($this->getControlValue('issearchname'));
            $importConfig->setIssearchnameprecision($this->getControlValue('issearchnameprecision'));
            $importConfig->setNotimportemptyprice($this->getControlValue('notimportemptyprice'));
            $importConfig->setNotimportemptyavail($this->getControlValue('notimportemptyavail'));
            $importConfig->setIssearcharticul($this->getControlValue('issearcharticul'));
            $importConfig->setCreatenewproduct($this->getControlValue('createNewProduct'));
            $importConfig->setOnlyretail($this->getControlValue('onlyRetail'));
            $importConfig->setRemoveminretail($this->getControlValue('removeMinretail'));
            $importConfig->setRemoverecommretail($this->getControlValue('removeRecommretail'));
            $importConfig->setImportcron($this->getControlValue('importCron'));
            $importConfig->setProcessed_lists($this->getControlValue('processedLists'));

            if ($availableConfig) {
                $importConfig->update();
            } else {
                $importConfig->insert();
            }
        }
        if ($this->getControlValue('processCroneImport')) {

            $Cdate = $this->getControlValue('dateUpload');
            // получено подтверждение валидности
            $supplierImport = new XShopPriceSupplierImport();
            $supplierImport->setCdate($Cdate);
            while ($x = $supplierImport->getNext()) {
                $x->setPdate(0);
                $x->update();
                $this->setValue('message', 'cronImportSuccess');
                // задание на загрузку
                ProcessorQueService::Get()->addProcessor('ShopSupplier_Processor_ReadPrice');
            }
        }

        // таблица со списком очереди загрузок
        $statusTable = Engine::GetContentDriver()->getContent('shop-admin-status-supplier-import');
        // на страницу загрузки только не обрабртанные
        $statusTable->setValue('processed', true);
        $this->setValue('statusTable', $statusTable->render());

        // Прайсы ожидающие загрузки
        $pricesIdArray = array(-1);
        $priceLoadArray = array();
        $tmpPrice = new XShopTmpPrice();
        $tmpPrice->setGroupByQuery('priceid');
        while ($x = $tmpPrice->getNext()) {
            $pricesIdArray[] = $x->getPriceid();
        }
        $supplierImport = new XShopPriceSupplierImport();
        $supplierImport->addWhereArray($pricesIdArray);
        $supplierImport->setGroupByQuery('cdate');
        while ($x = $supplierImport->getnext()) {
            try {
                $supplier = Shop::Get()->getSupplierService()->getSupplierByID($x->getSupplierid());
                $supplierName = $supplier->getName();
            } catch (Exception $e) {

            }
            $priceFileName = $x->getPricename();
            $priceLoadArray[] = array(
                'supplierName' => $supplierName,
                'priceFileName' => $priceFileName,
            );
        }
        $this->setValue('priceLoadArray', $priceLoadArray);


        // распознание прайса
        if ($this->getControlValue('ok')) {
            try {
                $ex = new ServiceUtils_Exception();

                $type = $this->getControlValue('type');


                // конвертация успешно прошла
                // для подтверждения использовать сгенерированый файл csv
                if (($type== 'xlsx' || $type== 'xls') && $resaltConvert === 0) {
                    $file = PackageLoader::Get()->getProjectPath().'media/import/csv/Sheet1.csv';
                    $type = 'csv-comma';
                    $convert = true;
                } else {
                    // получаем файл
                    $file = $this->getControlValue('file');
                    $file = @$file['tmp_name'];
                }
                
                if (!file_exists($file)) {
                    $ex->addError('file');
                }
                
                $currencyActive = Shop::Get()->getCurrencyService()->getCurrencyActive();
                $currencyArray = array();
                while ($c = $currencyActive->getNext()) {
                    $currencyArray[$c->getId()] = $c->getName();
                }

                // получаем поставщика
                try {
                    $supplier = Shop::Get()->getShopService()->getSupplierByID(
                        $this->getControlValue('supplierid')
                    );

                    Engine::GetHTMLHead()->setTitle($supplier->getName().' price import');
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('supplier');
                }

                // получаем валюту
                try {
                    $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                        $this->getControlValue('currencysupplierid')
                    );
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('currency');
                    throw $ex;
                }

                // валюта мин розницы
                try {
                    $currencyminretail = Shop::Get()->getCurrencyService()->getCurrencyByID(
                        $this->getControlValue('currencyminretail')
                    );
                } catch (ServiceUtils_Exception $se) {
                    $currencyminretail = $currency;
                }

                // валюта рекомендуемой розницы
                try {
                    $currencyrecommretail = Shop::Get()->getCurrencyService()->getCurrencyByID(
                        $this->getControlValue('currencyrecommretail')
                    );
                } catch (ServiceUtils_Exception $se) {
                    $currencyrecommretail = $currency;
                    // @todo: оповещение о авто выборе валюты поставщика
                }

                try {
                    $currencyminretailname = $currencyminretail->getName();
                    $currencyrecommretailname = $currencyrecommretail->getName();
                    $currencyminretailid = $currencyminretail->getId();
                    $currencyrecommretailid = $currencyrecommretail->getId();
                } catch (ServiceUtils_Exception $ce) {

                }
                $this->setValue('currencyminretailname', $currencyminretailname);
                $this->setValue('currencyrecommretailname', $currencyrecommretailname);
                $this->setValue('currencyminretailid', $currencyminretailid);
                $this->setValue('currencyrecommretailid', $currencyrecommretailid);
                $this->setValue('processedLists', $this->getControlValue('processedLists'));
                
                $encoding = $this->getControlValue('encoding');
                $columnCode = $this->getControlValue('columncode');
                $columnarticul = $this->getControlValue('columnarticul');
                $columnPrice = $this->getControlValue('columnprice');
                $columnAvail = $this->getControlValue('columnavail');
                $columnComment = $this->getControlValue('columncomment');
                $columnName = $this->getControlValue('columnname');
                $columnDiscount = $this->getControlValue('columndiscount');
                $limitFrom = (int) $this->getControlValue('limitfrom');
                $limitTo = (int) $this->getControlValue('limitto');
                // искать по коду поставщика
                $issearchcode = $this->getControlValue('issearchcode');
                // искать только по коду текущего поставщика
                $issearchcodethis = $this->getControlValue('issearchcodethis');
                // md5 trim code
                $issearchcodemd5 = $this->getControlValue('issearchcodemd5');
                // искать по имени товара
                $issearchname = $this->getControlValue('issearchname');
                // точность поиска по имени
                $issearchnameprecision = $this->getControlValue('issearchnameprecision');
                // Не импортировать товары с пустой или нулевой ценой
                $notimportemptyprice = $this->getControlValue('notimportemptyprice');
                // Не импортировать товары с пустым наличием
                $notimportemptyavail = $this->getControlValue('notimportemptyavail');
                // искать по артик(модели)
                $issearcharticul = $this->getControlValue('issearcharticul');
                $columnminretail = $this->getControlValue('columnminretail');
                $columnrecommretail = $this->getControlValue('columnrecommretail');
                $onlyRetail = $this->getControlValue('onlyRetail');
                $removeMinretail = $this->getControlValue('removeMinretail');
                $removeRecommretail = $this->getControlValue('removeRecommretail');

                if ($issearchname && (!$issearchnameprecision || $issearchnameprecision > 100)) {
                    $issearchnameprecision = 100;
                }

                if ($issearchname && $issearchnameprecision < 50) {
                    $issearchnameprecision = 50;
                }
                
                // время жизни товаров прайса
                $datelifeto = $this->getControlValue('datelifeto');
                
                if (!$columnCode || !$columnName) {
                    $ex->addError('column');
                }

                if (!$columnPrice && !$onlyRetail) {
                    $ex->addError('column');
                }

                if ($ex->getErrorsArray()) {
                    throw $ex;
                }

                // если в колонках буквы - переводим в числа
                if (preg_match("/^([a-z]+)$/ius", $columnPrice)) {
                    $columnPrice = ord(strtoupper($columnPrice)) - 64;
                }

                if (preg_match("/^([a-z]+)$/ius", $columnminretail)) {
                    $columnminretail = ord(strtoupper($columnminretail)) - 64;
                }

                if (preg_match("/^([a-z]+)$/ius", $columnrecommretail)) {
                    $columnrecommretail = ord(strtoupper($columnrecommretail)) - 64;
                }

                if (preg_match("/^([a-z]+)$/ius", $columnCode)) {
                    $columnCode = ord(strtoupper($columnCode)) - 64;
                }

                if ($columnarticul) {
                    if (preg_match("/^([a-z]+)$/ius", $columnarticul)) {
                        $columnarticul = ord(strtoupper($columnarticul)) - 64;
                    }
                }

                if ($columnAvail) {
                    if (preg_match("/^([a-z]+)$/ius", $columnAvail)) {
                        $columnAvail = ord(strtoupper($columnAvail)) - 64;
                    }
                }

                if ($columnComment) {
                    if (preg_match("/^([a-z]+)$/ius", $columnComment)) {
                        $columnComment = ord(strtoupper($columnComment)) - 64;
                    }
                }

                if (preg_match("/^([a-z]+)$/ius", $columnName)) {
                    $columnName = ord(strtoupper($columnName)) - 64;
                }

                $resultArray = array();

                if (preg_match("/^([a-z]+)$/ius", $columnDiscount)) {
                    $columnDiscount = ord(strtoupper($columnDiscount)) - 64;
                }

                $columnName =  Shop::Get()->getSupplierService()->ColumnNumberToArray($columnName);
                $columnCode = Shop::Get()->getSupplierService()->ColumnNumberToArray($columnCode);
                if ($columnarticul) {
                    $columnarticul = Shop::Get()->getSupplierService()->ColumnNumberToArray($columnarticul);
                }
                if ($columnAvail) {
                    $columnAvail = Shop::Get()->getSupplierService()->ColumnNumberToArray($columnAvail);
                }

                if ($columnComment) {
                    $columnComment = Shop::Get()->getSupplierService()->ColumnNumberToArray($columnComment);
                }
                
                // Обрабатываем листы, введенные пользователем 
                $processedLists = $this->getControlValue('processedLists');
                $processedListsArray  = explode(',', $processedLists);
                $processedListsArray = array_map('trim', $processedListsArray);
                // Удалить пустые значения
                // Отнять единичку от нумерации
                // Пользователь считает от 1 а reader от 0
                $tempArray = array();
                foreach ($processedListsArray as  $value) {
                    $value = (int) $value;
                    if (!$value) {
                        continue;
                    }
                    $tempArray[] = $value - 1;
                }
                $processedListsArray = $tempArray;
                
                // читаем прайс
                if ($type == 'xls') {
                    PackageLoader::Get()->import('XLS');

                    $data = new XLS_Reader();
                    $data->setOutputEncoding('UTF-8');
                    $data->read($file);

                    $from = 1;
                    $to = $data->sheets[0]['numRows'];
                    // количество листов всего
                    $numberSheets = count($data->sheets); 

                    $findNonAvail = '';
                    if ($limitTo >= $to || $limitTo <= 0) {
                        // Если это последняя часть прайса или весь прайс,
                        // то обновляем товары которых не было в прайсе
                        $findNonAvail = 1;
                    }

                    if ($limitFrom > 0) {
                        $from = $limitFrom;
                    }
                    if ($limitTo > 0) {
                        $to = $limitTo;
                    }

                    $to = 50;


                    if (!$processedListsArray) {
                        // Обрабатываем все
                        for ($j = $numberSheets; 1 <= $j; $j--) {
                            $processedListsArray[] = $j - 1;
                        }
                    }
                    asort($processedListsArray);
                    foreach ($processedListsArray as $numberSheet) {
                        for ($i = $from; $i <= $to; $i++) {

                            $currencyId = $currency->getId();
                            $currencyName = $currency->getName();

                            if ($columnAvail) {

                                if (is_array($columnAvail)) {
                                    $avail = Shop::Get()->getSupplierService()->gluePriceValue(
                                        $data,
                                        $columnAvail,
                                        'xls',
                                        $i,
                                        $numberSheet    
                                    );
                                } else {
                                    $avail = @trim($data->sheets[$numberSheet]['cells'][$i][$columnAvail]);
                                }
                                if ($notimportemptyavail && !$avail) {
                                    continue;
                                }
                            } else {
                                $avail = 'В наличии';
                            }



                            if ($columnarticul) {
                                if (is_array($columnarticul)) {
                                    $articul = Shop::Get()->getSupplierService()->gluePriceValue(
                                        $data,
                                        $columnarticul,
                                        'xls',
                                        $i,
                                        $numberSheet    
                                    );
                                } else {
                                    $articul = @trim($data->sheets[$numberSheet]['cells'][$i][$columnarticul]);
                                }
                            } else {
                                $articul = '';
                            }

                            if ($columnComment) {
                                if (is_array($columnComment)) {
                                    $comment = Shop::Get()->getSupplierService()->gluePriceValue(
                                        $data,
                                        $columnComment,
                                        'xls',
                                        $i,
                                        $numberSheet    
                                    );
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
                                        $currencyId = $productCurrency->getId();
                                        $currencyName = $productCurrency->getName();
                                        break;
                                    } catch (Exception $e) {

                                    }
                                }
                            }


                            if ($notimportemptyprice) {
                                if (!(float) $price) {
                                    continue;
                                }
                            }

                            if ($columnminretail) {
                                $minretail = @trim($data->sheets[$numberSheet]['cells'][$i][$columnminretail]);
                                $minretail = str_replace(',', '.', $minretail);
                                $minretail = str_replace(' ', '', $minretail);
                            } else {
                                $minretail = 0;
                            }

                            if ($columnrecommretail) {
                                $recommretail = @trim($data->sheets[$numberSheet]['cells'][$i][$columnrecommretail]);
                                $recommretail = str_replace(',', '.', $recommretail);
                                $recommretail = str_replace(' ', '', $recommretail);
                            } else {
                                $recommretail = 0;
                            }

                            // код поставщика
                            if (is_array($columnCode)) {
                                $code = Shop::Get()->getSupplierService()->gluePriceValue(
                                    $data,
                                    $columnCode,
                                    'xls',
                                    $i,
                                    $numberSheet    
                                );
                            } else {
                                $code = @trim($data->sheets[$numberSheet]['cells'][$i][$columnCode]);
                            }

                            if ($issearchcodemd5) {
                                $code = str_replace(' ', '', $code);
                                $code = trim($code);
                                $code = md5($code);
                            }

                            // название товара
                            if (is_array($columnName)) {
                                $name = Shop::Get()->getSupplierService()->gluePriceValue(
                                    $data, $columnName, 'xls', $i, $numberSheet
                                );
                            } else {
                                $name = @trim($data->sheets[$numberSheet]['cells'][$i][$columnName]);
                            }

                            $discount = @trim($data->sheets[$numberSheet]['cells'][$i][$columnDiscount]);
                            $discount = abs($discount);
                            if ($discount < 1 && $discount > 0) {
                                $discount = $discount * 100;
                            }

                            if ($code && $price || $onlyRetail) {

                                try {
                                    $product = Shop::Get()->getSupplierService()->getProductBySupplierCode(
                                        $supplier,
                                        $code,
                                        $name,
                                        $articul,
                                        $issearchcode,
                                        $issearchcodethis,
                                        $issearchnameprecision,
                                        $issearcharticul
                                    );

                                    $oldcurrencyname = '';
                                    $oldPrice = 0;
                                    $oldAvail = '';
                                    $oldDate = 0;
                                    try {
                                        $productSupplier = Shop::Get()->getSupplierService()->getShopProductSupplier(
                                            $product, $supplier
                                        );
                                        
                                        $oldcurrencyname = Shop::Get()->getCurrencyService()->getCurrencyByID(
                                            $productSupplier->getCurrencyid()
                                        );
                                        $oldcurrencyname = $oldcurrencyname->getName();
                                        $oldPrice = $productSupplier->getPrice(); 
                                        $oldAvail = $productSupplier->getAvailtext();
                                        $oldDate = $productSupplier->getDate();
                                    } catch (ServiceUtils_Exception $ce) {

                                    }

                                    $resultArray[] = array(
                                    'avail' => $avail,
                                    'price' => round($price, 2),
                                    'code' => $code,
                                    'name' => $name,
                                    'articul' => $articul,
                                    'productid' => $product->getId(),
                                    'productname' => $product->makeName(),
                                    'currencyid' => $currencyId,
                                    'currencyname' => $currencyName,    
                                    'oldprice' => round($oldPrice, 2),
                                    'oldcurrency' => $oldcurrencyname,
                                    'oldavail' => $oldAvail,
                                    'olddate' => $oldDate,
                                    'discount' => $discount,
                                    'minretail' => $minretail,
                                    'recommretail' => $recommretail,
                                    'reason' => $product->getMatchReason(),
                                    'comment' => $comment,
                                    );
                                } catch (ServiceUtils_Exception $se) {
                                    // не предлагать создание новых товаров
                                    if ($onlyRetail) {
                                        continue;
                                    }
                                    $resultArray[] = array(
                                    'avail' => $avail,
                                    'price' => $price,
                                    'articul' => $articul,
                                    'code' => $code,
                                    'name' => $name,
                                    'discount' => $discount,
                                    'minretail' => $minretail,
                                    'recommretail' => $recommretail,
                                    'comment' => $comment,
                                    'currencyid' => $currencyId,
                                    'currencyname' => $currencyName,    
                                    );
                                }
                            }
                        }

                        // для превью первый лист
                        break;

                        
                    }
                    
                    
                } elseif ($type == 'csv-default' || $type == 'csv-comma' || $type == 'csv-tab') {
                    $delimeter = ';';
                    if ($type == 'csv-comma') {
                        $delimeter = ',';
                    }
                    if ($type == 'csv-tab') {
                        $delimeter = "\t";
                    }

                    if ($encoding == 'windows-1251') {
                        setlocale(LC_ALL, 'ru_RU.CP1251');
                    }

                    $f = fopen($file, 'r');

                    $lineIndex = 0;

                    $from = 1;
                    $to = count(file($file));

                    $findNonAvail = '';

                    if ($limitTo >= $to || $limitTo <= 0) {
                        // Если это последняя часть прайса или весь прайс,
                        // то обновляем товары которых не было в прайсе
                        $findNonAvail = 1;
                    }

                    while ($line = fgetcsv($f, 4096, $delimeter)) {
                        $currencyId = $currency->getId();
                        $currencyName = $currency->getName();
                        $lineIndex ++;

                        if ($limitFrom && $limitFrom > $lineIndex) {
                            continue;
                        }
                        if ($limitTo && $limitTo < $lineIndex) {
                            break;
                        }

                        $limitTo = 50;


                        if ($columnAvail) {

                            if (is_array($columnAvail)) {
                                $avail = Shop::Get()->getSupplierService()->gluePriceValue($line, $columnAvail, 'csv');
                            } else {
                                $avail = @trim($line[$columnAvail - 1]);
                            }
                            if ($notimportemptyavail && !$avail) {
                                continue;
                            }
                        } else {
                            $avail = 'В наличии';
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
                                    $currencyId = $productCurrency->getId();
                                    $currencyName = $productCurrency->getName();
                                } catch (Exception $e) {
                                    
                                }
                            }
                        }

                        if ($notimportemptyprice) {
                            if (!(float) $price) {
                                continue;
                            }
                        }

                        // код поставщика
                        if (is_array($columnCode)) {
                            $code = Shop::Get()->getSupplierService()->gluePriceValue($line, $columnCode, 'csv');
                        } else {
                            $code = @trim($line[$columnCode - 1]);
                        }

                        $code = preg_replace("/^(.+?)\.0$/ius", '$1', $code);

                        // артикул
                        if ($columnarticul) {
                            if (is_array($columnarticul)) {
                                $articul = Shop::Get()->getSupplierService()->gluePriceValue(
                                    $line,
                                    $columnarticul,
                                    'csv'
                                );
                            } else {
                                $articul = @trim($line[$columnarticul - 1]);
                            }
                        } else {
                            $articul = '';
                        }

                        if ($columnComment) {
                            if (is_array($columnComment)) {
                                $comment = Shop::Get()->getSupplierService()->gluePriceValue(
                                    $line,
                                    $columnComment,
                                    'csv'
                                );
                            } else {
                                $comment = @trim($line[$columnComment - 1]);
                            }
                        } else {
                            $comment = '';
                        }

                        // наименование
                        if (is_array($columnName)) {
                            $name = Shop::Get()->getSupplierService()->gluePriceValue($line, $columnName, 'csv');
                        } else {
                            $name = @trim($line[$columnName - 1]);
                        }

                        $discount = @trim($line[$columnDiscount - 1]);
                        $discount = abs($discount);
                        if ($discount < 1 && $discount > 0) {
                            $discount = $discount * 100;
                        }
                        $minRetail = @trim($line[$columnminretail - 1]);
                        $minRetail = str_replace(',', '.', $minRetail);
                        $recommRetail = @trim($line[$columnrecommretail - 1]);
                        $recommRetail = str_replace(',', '.', $recommRetail);

                        if ($code && $price || $onlyRetail) {
                            try {
                                $product = Shop::Get()->getSupplierService()->getProductBySupplierCode(
                                    $supplier,
                                    $code,
                                    $name,
                                    $articul,
                                    $issearchcode,
                                    $issearchcodethis,
                                    $issearchnameprecision,
                                    $issearcharticul
                                );

                                $oldcurrencyname = '';
                                $oldPrice = 0;
                                $oldAvail = '';
                                $oldDate = 0;
                                try {
                                    $productSupplier = Shop::Get()->getSupplierService()->getShopProductSupplier(
                                        $product, $supplier
                                    );

                                    $oldcurrencyname = Shop::Get()->getCurrencyService()->getCurrencyByID(
                                        $productSupplier->getCurrencyid()
                                    );
                                    $oldcurrencyname = $oldcurrencyname->getName();
                                    $oldPrice = $productSupplier->getPrice();
                                    $oldAvail = $productSupplier->getAvailtext();
                                    $oldDate = $productSupplier->getDate();
                                } catch (ServiceUtils_Exception $ce) {
                                    
                                }

                                $resultArray[] = array(
                                'avail' => $avail,
                                'price' => $price,
                                'code' => $code,
                                'name' => $name,
                                'articul' => $articul,
                                'productid' => $product->getId(),
                                'productname' => $product->makeName(),
                                'oldprice' => $oldPrice,
                                'oldcurrency' => $oldcurrencyname,
                                'oldavail' => $oldAvail,
                                'olddate' => $oldDate,
                                'discount' => $discount,
                                'minretail' => $minRetail,
                                'recommretail' => $recommRetail,
                                'reason' => $product->getMatchReason(),
                                'comment' => $comment,
                                'currencyid' => $currencyId,
                                'currencyname' => $currencyName,    
                                );
                            } catch (ServiceUtils_Exception $se) {
                                // не предлагать создание новых товаров
                                if ($onlyRetail) {
                                    continue;
                                }
                                $resultArray[] = array(
                                'avail' => $avail,
                                'price' => $price,
                                'code' => $code,
                                'name' => $name,
                                'articul' => $articul,
                                'discount' => $discount,
                                'minretail' => $minRetail,
                                'recommretail' => $recommRetail,
                                'comment' => $comment,
                                'currencyid' => $currencyId,
                                'currencyname' => $currencyName,    
                                );
                            }
                        }
                    }
                    fclose($f);

                    setlocale(LC_ALL, 'ru_RU.UTF-8');
                } else {
                    // тип файла xlsx и не сработал конвертер
                    if ($type == 'xlsx') {
                        $ex->addError('xls2csv');
                        throw $ex;
                    }
                    throw new ServiceUtils_Exception('type');
                }

                if (!$resultArray) {
                    throw new ServiceUtils_Exception('noresult');
                }

                $productName = array();
                foreach ($resultArray as $key => $arr) {
                    @$productName[$key] = $arr['productname'];
                }

                // сортировка по имени товара - пустые наверх
                array_multisort($productName, SORT_STRING, $resultArray);

                $this->setValue('supplierid', $supplier->getId());
                $this->setValue('currencyid', $currency->getId());
                $this->setValue('issearchcode', $issearchcode);
                $this->setValue('issearchcodethis', $issearchcodethis);
                $this->setValue('issearchcodemd5', $issearchcodemd5);
                $this->setValue('issearchname', $issearchname);
                $this->setValue('issearchnameprecision', $issearchnameprecision);
                $this->setValue('datelifeto', $datelifeto);
                $this->setValue('issearcharticul', $issearcharticul);
                $this->setValue('findNotAvail', $findNonAvail);
                $this->setValue('currency', $currency->getName());
                $this->setValue('supplierName', $supplier->getName());
                $this->setValue('onlyRetail', $onlyRetail);
                $this->setValue('resultArray', $resultArray);
                $this->setValue('removeMinretail', $removeMinretail);
                $this->setValue('removeRecommretail', $removeRecommretail);
            } catch (ServiceUtils_Exception $e) {
                $this->setValue('message', 'error');
                $this->setValue('errorArray', $e->getErrorsArray());
            } catch (Exception $e) {
                echo $e;
                $this->setValue('message', 'error');
            }
        }

        // поставщики
        $suppliers = Shop::Get()->getSupplierService()->getSuppliersActive();
        $supplierArray = array();
        while ($x = $suppliers->getNext()) {
            $supplierArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('supplierArray', $supplierArray);

        // валюты
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $currencyArray = array();
        while ($x = $currencies->getNext()) {
            $currencyArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('currencyArray', $currencyArray);
    }

    private $_cookieTime = 72000;

}