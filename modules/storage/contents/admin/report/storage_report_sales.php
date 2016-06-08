<?php
class storage_report_sales extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/modules/storage/contents/admin/ajaxproduct/ajaxproduct.js');
        PackageLoader::Get()->registerJSFile(
            '/modules/storage/contents/admin/ajaxproduct/product_filter_autocomplete.js'
        );

        $cuser = $this->getUser();

        $storageNameIDArray = $this->getArgumentSecure('storagenameid', 'array');
        $userIDArray = $this->getArgumentSecure('userid', 'array');
        // $departmentIDArray = $this->getArgumentSecure('departmentid', 'array');
        $clientIDArray = $this->getArgumentSecure('clientid', 'array');

        $productIDArray = array();
        if ($this->getArgumentSecure('productid')) {
            $productIDArray = explode(',', $this->getArgumentSecure('productid'));
        }

        $exportArray = array();

        if ($this->getControlValue('ok')) {
            $a = array();

            try {
                $datefrom = DateTime_Corrector::CorrectDateTime($this->getControlValue('datefrom'));
                $dateto = DateTime_Corrector::CorrectDateTime($this->getControlValue('dateto'));
                $date = DateTime_Object::FromString($dateto)->setFormat('Y-m-d');

                $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

                $storageNameIDAllowed = StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'motionlog');
                if (in_array('all', $storageNameIDArray)) {
                    $storageNameIDArray = $storageNameIDAllowed;
                } else {
                    foreach ($storageNameIDArray as $k => $storageNameID) {
                        if (!in_array($storageNameID, $storageNameIDAllowed)) {
                            unset($storageNameIDArray['k']);
                        }
                    }
                }



                // суммы:
                // заказов на сумму
                $orderSum = 0;
                // продаж на сумму
                $saleSum = 0;
                // себестоимость
                $costSum = 0;
                // маржа
                $marginSum = 0;
                // отказов на сумму
                $rejectSum = 0;

                // вычисляем промежуток, по которому будем группировать данные
                $diff = DateTime_Differ::DiffDay($dateto, $datefrom);

                // если выбран промежуток меньше 31 дня, группируем данные по дням,
                // за каждый день показываем все заказы
                $step = 'day';

                if ($diff > 31) {
                    // если дней больше 31, группируем по месяцу, за каждый месяц
                    // показываем суммы заказов по дням
                    $step = 'month';
                }

                if ($diff > 93) {
                    // если дней больше 93, группируем по году, за каждый год
                    // показываем суммы заказов по месяцам
                    $step = 'year';
                }

                if ($diff > 731) {
                    throw new ServiceUtils_Exception('period');
                }

                $j = 0;

                // идем по каждому "отрезку времени"
                while (
                    $date->__toString() >= DateTime_Object::FromString($datefrom)->setFormat('Y-m-d')->__toString()
                ) {
                    $orders = Shop::Get()->getShopService()->getOrdersAll();

                    // получаем заказы за необходимый промежуток
                    if ($step == 'day') {
                        $orders->addWhereQuery(
                            'YEAR(`shoporder`.`cdate`) = \''.$date->setFormat('Y')->__toString().'\''
                        );
                        $orders->addWhereQuery(
                            'MONTH(`shoporder`.`cdate`) = \''.$date->setFormat('m')->__toString().'\''
                        );
                        $orders->addWhereQuery(
                            'DAY(`shoporder`.`cdate`) = \''.$date->setFormat('d')->__toString().'\''
                        );
                    } elseif ($step == 'month') {
                        $orders->addWhereQuery(
                            'YEAR(`shoporder`.`cdate`) = \''.$date->setFormat('Y')->__toString().'\''
                        );
                        $orders->addWhereQuery(
                            'MONTH(`shoporder`.`cdate`) = \''.$date->setFormat('m')->__toString().'\''
                        );
                    } elseif ($step == 'year') {
                        $orders->addWhereQuery(
                            'YEAR(`shoporder`.`cdate`) = \''.$date->setFormat('Y')->__toString().'\''
                        );
                    }

                    $date->setFormat('Y-m-d');

                    if ($step == 'month') {
                        // получам ID заказов за каждый день
                        $orderIDArray = array();
                        $orders2 = clone $orders;

                        $j++;

                        while ($order = $orders2->getNext()) {
                            $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m-d')->__toString();
                            $orderIDArray[$d][] = $order->getId();
                        }

                        // группируем суммы заказов по дням
                        $orders->addFieldQuery('SUM(`shoporder`.`sum`) AS `sum`');
                        $orders->setGroupByQuery(
                            'YEAR(`shoporder`.`cdate`), MONTH(`shoporder`.`cdate`), DAY(`shoporder`.`cdate`)'
                        );
                    } elseif ($step == 'year') {
                        // получам ID заказов за каждый год
                        $orderIDArray = array();
                        $orders2 = clone $orders;
                        $j++;

                        while ($order = $orders2->getNext()) {
                            $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m')->__toString();
                            $orderIDArray[$d][] = $order->getId();
                        }

                        // группируем суммы заказов по месяцам
                        $orders->addFieldQuery('SUM(`shoporder`.`sum`) AS `sum`');
                        $orders->setGroupByQuery('YEAR(`shoporder`.`cdate`), MONTH(`shoporder`.`cdate`)');

                    }

                    // фильтры
                    if ($userIDArray) {
                        $orders->addWhereQuery('(`shoporder`.`managerid` IN ('.implode(', ', $userIDArray).'))');
                    }

                    if ($clientIDArray) {
                        $orders->addWhereQuery('(`shoporder`.`userid` IN ('.implode(', ', $clientIDArray).'))');
                    }

                    if ($productIDArray) {
                        $orderProduct = new ShopOrderProduct();
                        $orders->leftJoinTable(
                            $orderProduct->getTablename(),
                            $orders->getTablename().'.id='.$orderProduct->getTablename().'.orderid'
                        );
                        $orders->addWhereQuery(
                            '(`shoporderproduct`.`productid` IN ('.implode(', ', $productIDArray).'))'
                        );
                    }

                    // суммы на промежуток:
                    // заказов на сумму
                    $orderSumDate = 0;
                    // продаж на сумму
                    $saleSumDate = 0;
                    // себестоимость
                    $costSumDate = 0;
                    // маржа
                    $marginSumDate = 0;
                    // отказов на сумму
                    $rejectSumDate = 0;

                    $orderArray = array();

                    $j++;

                    while ($order = $orders->getNext()) {
                        // суммы на строку:
                        // заказов на сумму
                        $orderSumOrder = 0;
                        // продаж на сумму
                        $saleSumOrder = 0;
                        // себестоимость
                        $costSumOrder = 0;
                        // маржа
                        $marginSumOrder = 0;
                        // отказов на сумму
                        $rejectSumOrder = 0;

                        $client = '';
                        $manager = '';
                        $department = '';
                        $storagename = '';

                        if ($step == 'day') {
                            // если группируем по дням, получаем поля о каждом заказе
                            try {
                                $client = $order->getUser()->makeName();
                            } catch (Exception $use) {

                            }

                            try {
                                $manager = $order->getManager()->makeName();
                            } catch (Exception $use) {

                            }
                            /*
                            try {
                            $department = Shop::Get()->getUserService()->getDepartmentByID(
                            $order->getManager()->getDepartmentid()
                            )->getName();
                            } catch (Exception $use) {}
                            */
                        }

                        // если заказ отгружен
                        if ($order->getIsshipped()) {

                            // находим транзакции отгрузки
                            $transactions = new ShopStorageTransaction();
                            $transactions->setReturn(0);

                            if ($step == 'day') {
                                $transactions->setOrderid($order->getId());
                            } elseif ($step == 'month') {
                                $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m-d')->__toString();
                                $transactions->addWhereQuery('(`orderid` IN ('.implode(',', $orderIDArray[$d]).'))');
                            } elseif ($step == 'year') {
                                $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m')->__toString();
                                $transactions->addWhereQuery('(`orderid` IN ('.implode(',', $orderIDArray[$d]).'))');
                            }

                            // получаем ID транзакций отгрузки
                            $transactionIDArray = array(-1);

                            $j++;
                            while ($transaction = $transactions->getNext()) {
                                $transactionIDArray[] = $transaction->getId();
                            }

                            if ($transactionIDArray) {

                                // находим складские записи отгрузки
                                $storages = new ShopStorage();
                                $storages->addWhereQuery(
                                    '(`transactionid` IN ('.implode(',', $transactionIDArray).'))'
                                );
                                $storages->addWhere('amount', 0, '>');

                                // фильтры
                                if ($storageNameIDArray) {
                                    $storages->addWhereQuery(
                                        '(`shopstorage`.`storagenamefromid` IN ('.
                                        implode(', ', $storageNameIDArray).'))'
                                    );
                                } else {
                                    $storages->addWhereQuery(
                                        '(`shopstorage`.`storagenamefromid` IN ('.
                                        implode(
                                            ',',
                                            StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'motionlog')
                                        ).
                                        '))'
                                    );
                                }

                                if ($productIDArray) {
                                    $storages->addWhereQuery(
                                        '(`shopstorage`.`productid` IN ('.implode(', ', $productIDArray).'))'
                                    );
                                }

                                $storages1 = clone $storages;

                                $j++;
                                // если есть складские записи, значит продажа была
                                if ($storage1 = $storages1->getNext()) {

                                    if (!$productIDArray) {
                                        $saleSumOrder = Shop::Get()->getCurrencyService()->convertCurrency(
                                            $order->getSum(),
                                            $order->getCurrency(),
                                            $currencyDefault
                                        );
                                    } else {
                                        // если установлен фильтр товара,
                                        // считаем сумму только тех товаров, которые выбраны
                                        $saleSumOrder = Shop::Get()->getCurrencyService()->convertCurrency(
                                            $this->_calculateOrderSum($order, $productIDArray),
                                            $order->getCurrency(),
                                            $currencyDefault
                                        );
                                    }

                                    $j++;

                                    while ($storage = $storages->getNext()) {
                                        $costSumOrder += $storage->getAmount() * $storage->getPricebase();
                                    }

                                    // проверяем возврат товара

                                    // если были возвраты по этой транзакции
                                    // получаем массив ид-шников этих транзакций-возвратов
                                    $transactions_return = new ShopStorageTransaction();
                                    $transactions_return->addWhereQuery(
                                        '(`returntransactionid` IN ('.implode(',', $transactionIDArray).'))'
                                    );
                                    $returnIDArray = array(-1);

                                    $j++;
                                    while ($x = $transactions_return->getNext()) {
                                        $returnIDArray[] = $x->getId();
                                    }

                                    // получаем складсие записи возвратов
                                    $storages_return = StorageService::Get()->getStoragesAll();
                                    $storages_return->addWhereQuery(
                                        '(`transactionid` IN ('.implode(',', $returnIDArray).'))'
                                    );
                                    $storages_return->addWhere('amount', 0, '>');

                                    // фильтры
                                    if ($storageNameIDArray) {
                                        $storages_return->addWhereQuery(
                                            '(`shopstorage`.`storagenametoid` IN ('.
                                            implode(', ', $storageNameIDArray).
                                            '))'
                                        );
                                    } else {
                                        $storages_return->addWhereQuery(
                                            '(`shopstorage`.`storagenametoid` IN ('.
                                            implode(
                                                ',',
                                                StorageNameService::Get()->getStorageNameIDsArrayByUser(
                                                    $cuser,
                                                    'motionlog'
                                                )
                                            )
                                            .'))'
                                        );
                                    }

                                    if ($productIDArray) {
                                        $storages_return->addWhereQuery(
                                            '(`shopstorage`.`productid` IN ('.implode(', ', $productIDArray).'))'
                                        );
                                    }

                                    $j++;
                                    while ($storage_return = $storages_return->getNext()) {
                                        try {
                                            // получаем товар заказа
                                            $op = Shop::Get()->getShopService()->getOrderProductById(
                                                $storage_return->getOrderproductid()
                                            );

                                            // считаем себестоимость
                                            $costSumOrder -=
                                                $storage_return->getAmount() * $storage_return->getPricebase();

                                            // считаем сумму продажи
                                            $saleSumOrder -= $storage_return->getAmount() * $op->getProductprice();
                                        } catch (ServiceUtils_Exception $re) {

                                        }
                                    }

                                    $marginSumOrder = $saleSumOrder - $costSumOrder;

                                    $saleSumDate += $saleSumOrder;
                                    $costSumDate += $costSumOrder;

                                    try {
                                        $storagename = $storage1->getStorageNameFrom()->getName();
                                    } catch (ServiceUtils_Exception $use) {

                                    }

                                }
                            }
                        }

                        // если есть фильтр по складу, то добавлем только заказы, которые
                        // отгружены с этого склада
                        if (!$storageNameIDArray || ($storageNameIDArray && $saleSumOrder)) {
                            if (!$productIDArray) {
                                $orderSumOrder = Shop::Get()->getCurrencyService()->convertCurrency(
                                    $order->getSum(),
                                    $order->getCurrency(),
                                    $currencyDefault
                                );
                            } else {
                                // если установлен фильтр товара,
                                // считаем сумму только тех товаров, которые выбраны
                                $orderSumOrder = Shop::Get()->getCurrencyService()->convertCurrency(
                                    $this->_calculateOrderSum($order, $productIDArray),
                                    $order->getCurrency(),
                                    $currencyDefault
                                );
                            }

                            $orderSumDate += $orderSumOrder;

                            $rejectSumOrder = $orderSumOrder - $saleSumOrder;

                            $d = '';
                            if ($step == 'month') {
                                $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m-d')->__toString();
                            } elseif ($step == 'year') {
                                $d = DateTime_Object::FromString($order->getCdate())->setFormat('Y-m')->__toString();
                            }

                            $orderArray[] = array(
                            'id' => $step == 'day'?$order->getId():$d,
                            'url' => $step == 'day'?$order->makeURLEdit():'#',
                            'orderSum' => number_format($orderSumOrder, 2),
                            'saleSum' => number_format($saleSumOrder, 2),
                            'costSum' => number_format($costSumOrder, 2),
                            'marginSum' => number_format($marginSumOrder, 2),
                            'rejectSum' => number_format($rejectSumOrder, 2),
                            'client' => $client,
                            'manager' => $manager,
                            'department' => false, //$department
                            'storagename' => $storagename
                            );

                            $exportArray[] = array(
                            'Дата' => $date->__toString(),
                            'Номер документа' => $order->getId(),
                            'Заказ на сумму' => $orderSumOrder,
                            'Продажа на сумму' => $saleSumOrder,
                            'Себестоимость товара' => $costSumOrder,
                            'Маржа' => $marginSumOrder,
                            'Отказ на сумму' => $rejectSumOrder,
                            'Склад' => $storagename,
                            'Пользователь' => $manager,
                            'Отдел' => false, //$department,
                            'Клиент' => $client
                            );
                        }

                    }

                    $marginSumDate = $saleSumDate - $costSumDate;
                    $rejectSumDate = $orderSumDate - $saleSumDate;

                    if ($orderArray) {
                        if ($step == 'day') {
                            $d = $date->__toString();
                        } elseif ($step == 'month') {
                            $d = $date->setFormat('Y-m')->__toString();
                        } elseif ($step == 'year') {
                            $d = $date->setFormat('Y')->__toString();
                        }

                        $a[] = array(
                        'date' => $d,
                        'orderArray' => $orderArray,
                        'orderCount' => count($orderArray),
                        'orderSum' => number_format($orderSumDate, 2),
                        'saleSum' => number_format($saleSumDate, 2),
                        'costSum' => number_format($costSumDate, 2),
                        'marginSum' => number_format($marginSumDate, 2),
                        'rejectSum' => number_format($rejectSumDate, 2)
                        );
                    }

                    $orderSum += $orderSumDate;
                    $saleSum += $saleSumDate;
                    $costSum += $costSumDate;
                    $marginSum += $marginSumDate;
                    $rejectSum += $rejectSumDate;

                    $date->setFormat('Y-m-d');

                    if ($step == 'day') {
                        $date->addDay(-1);
                    } elseif ($step == 'month') {
                        $date->addMonth(-1);
                    } elseif ($step == 'year') {
                        $date->addYear(-1);
                    }
                }

                $total = array(
                'orderSum' => number_format($orderSum, 2),
                'saleSum' => number_format($saleSum, 2),
                'costSum' => number_format($costSum, 2),
                'marginSum' => number_format($marginSum, 2),
                'rejectSum' => number_format($rejectSum, 2),
                );

                if ($exportArray) {
                    $exportArray[] = array(
                    'Дата' => 'Итого:',
                    'Номер документа' => '',
                    'Заказ на сумму' => $orderSum,
                    'Продажа на сумму' => $saleSum,
                    'Себестоимость товара' => $costSum,
                    'Маржа' => $marginSum,
                    'Отказ на сумму' => $rejectSum,
                    'Склад' => '',
                    'Пользователь' => '',
                    'Отдел' => '',
                    'Клиент' => ''
                    );
                }

                $this->setValue('tableArray', $a);
                $this->setValue('total', $total);
                $this->setValue('currency', $currencyDefault->getSymbol());
                $this->setValue('step', $step);

            } catch (ServiceUtils_Exception $se) {
                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $se->getErrorsArray());

                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }
        }

        // exports
        $exportXLS = Engine::GetURLParser()->getArgumentSecure('export-xls');
        $exportPDF = Engine::GetURLParser()->getArgumentSecure('export-pdf');
        $filename = 'export_'.date('Y_m_d_H_i_s').'_sales_report';

        if ($exportXLS && $exportArray) {
            PackageLoader::Get()->import('XLS');
            $xls = XLS_Creator::CreateFromArray($exportArray);
            header('Content-Type: application/vnd.ms-excel; charset=utf-8');
            header('Content-Disposition: attachment; filename="'.$filename.'.xls"');
            print $xls->__toString();
            exit();
        }

        if ($exportPDF && $exportArray) {
            $assigns= array();
            $assigns['tableArray'] = $a;
            $assigns['total'] = $total;
            $assigns['currency'] = $currencyDefault;

            $assigns['datefrom'] = DateTime_Corrector::CorrectDate($this->getControlValue('datefrom'));
            $assigns['dateto'] = DateTime_Corrector::CorrectDate($this->getControlValue('dateto'));

            $storageNameArray = array();
            $storageNames = StorageNameService::Get()->getStorageNamesForSale();
            while ($x = $storageNames->getNext()) {
                if (in_array($x->getId(), $storageNameIDArray)) {
                    $storageNameArray[] = $x->getName();
                }
            }
            $assigns['storageNameArray'] = $storageNameArray;

            $productArray = array();
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setDeleted(0);
            while ($x = $products->getNext()) {
                if (in_array($x->getId(), $productIDArray)) {
                    $productArray[] = $x->getName();
                }
            }
            $assigns['productArray'] = $productArray;

            $userArray = array();
            $users = Shop::Get()->getUserService()->getUsersAll();
            while ($x = $users->getNext()) {
                if (in_array($x->getId(), $userIDArray)) {
                    $userArray[] = $x->getName();
                }
            }
            $assigns['userArray'] = $userArray;

            $clientArray = array();
            $users = Shop::Get()->getUserService()->getUsersAll();
            while ($x = $users->getNext()) {
                if (in_array($x->getId(), $clientIDArray)) {
                    $clientArray[] = $x->getName();
                }
            }
            $assigns['clientArray'] = $clientArray;

            /*
            $departmentArray = array();
            $departments = Shop::Get()->getUserService()->getDepartmentsAll();
            while ($x = $departments->getNext()) {
            if (in_array($x->getId(), $departmentIDArray)) {
            $departmentArray[] = $x->getName();
            }
            }
            $assigns['departmentArray'] = $departmentArray;
            */

            $file = MEDIA_PATH.'/tmp/'.rand().time();
            file_put_contents($file.'.html', file_get_contents(dirname(__FILE__).'/tpl-report-sales.html'));
            $content = Engine::GetSmarty()->fetch($file.'.html', $assigns);
            file_put_contents($file.'.html', $content);

            PackageLoader::Get()->import('PDF');
            @PDF_Container::Get()->html2pdf_internal($file.'.html', $file.'.pdf');
            header('Content-Type: application/pdf; charset=utf-8');
            header('Content-Disposition: attachment; filename="'.$filename.'.pdf"');
            print file_get_contents($file.'.pdf');

            unlink($file.'.pdf');
            unlink($file.'.html');
            exit();
        }

        $storageNames = StorageNameService::Get()->getStorageNamesForSale();
        $storageNames->addWhereQuery(
            '(`id` IN ('.implode(',', StorageNameService::Get()->getStorageNameIDsArrayByUser($cuser, 'motionlog')).'))'
        );
        $this->setValue('storageNamesArray', $storageNames->toArray());

        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery('(`id` IN (SELECT `userid` FROM `shoporder`))');
        $clientAllArray = array();
        while ($user = $users->getNext()) {
            $clientAllArray[] = array(
            'id' => $user->getId(),
            'name' => $user->makeName()
            );
        }
        $this->setValue('clientArray', $clientAllArray);

        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery('(`id` IN (SELECT `managerid` FROM `shoporder`))');
        $userAllArray = array();
        while ($user = $users->getNext()) {
            $userAllArray[] = array(
            'id' => $user->getId(),
            'name' => $user->makeName()
            );
        }
        $this->setValue('userArray', $userAllArray);

        /*
        $departments = Shop::Get()->getUserService()->getDepartmentsAll();
        $this->setValue('departmentArray', $departments->toArray());
        */

        if (empty($datefrom)) {
            $this->setControlValue('datefrom', DateTime_Object::Now()->addMonth(-1)->setFormat('Y-m-d')->__toString());
        }
        if (empty($dateto)) {
            $this->setControlValue('dateto', date('Y-m-d'));
        }

        // выбранные мульти-фильтры
        $this->setValue('storagenameSelectedArray', $storageNameIDArray);
        $this->setValue('userSelectedArray', $userIDArray);
        $this->setValue('clientSelectedArray', $clientIDArray);
        // $this->setValue('departmentSelectedArray', $departmentIDArray);

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

        $this->setValue(
            'urlexportxls',
            Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('export-xls' => 1))
        );

        $this->setValue(
            'urlexportpdf',
            Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('export-pdf' => 1))
        );
    }

    /**
     * Пересчитываем сумму заказа как сумму товаров, выбранных в фильтре
     *
     * @param ShopOrder $order
     */
    private function _calculateOrderSum(ShopOrder $order, $productIDArray) {
        // пересчитываем заказ в валюту заказа
        $currencyDefault = $order->getCurrency();

        // получаем процент скидки (заказ -> скидка -> %)
        $discountPercent = $order->getDiscountPercent();
        $discountValue = $order->getDiscountValue($currencyDefault);

        // перевод суммы скидки в процент (извращение)
        // т.к. применяем скидку не для всего заказа, а для конкретных товаров
        // и сумму нужно уменьшать пропорционально
        if ($discountValue) {
            $discountPercent = 100 * $discountValue / $order->getSum();
            $discountValue = 0;
        }

        // процент налогообложения юрлица
        try {
            $contractorTax = $order->getContractor()->getTax();
        } catch (ServiceUtils_Exception $se) {
            $contractorTax = 0;
        }

        // полная сумма заказа
        $sum = 0;

        // проходимся по каждому товарару в заказе
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            // пропускаем ненужные товары
            if (!in_array($op->getProductid(), $productIDArray)) {
                continue;
            }

            // цена без ПДВ
            $price = Shop::Get()->getShopService()->calculateSum(
                $op->makePrice($currencyDefault),
                $contractorTax,
                0,
                0,
                true, // return sum
                false, // + vat tax
                false // without discount
            );

            $sum += round($price * $op->getProductcount(), 2);
        }

        // добавляем ПДВ к заказу
        if ($contractorTax) {
            $sum *= (1 + $contractorTax / 100);
        }

        $sum = Shop::Get()->getShopService()->calculateSum(
            $sum,
            0,
            $discountPercent,
            $discountValue,
            true, // + sum
            true, // + tax vat
            false // - discount
        );

        return $sum;

    }

}