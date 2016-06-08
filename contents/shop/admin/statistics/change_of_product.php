<?php
class change_of_product extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');
        $userId = $this->getArgumentSecure('userid', 'int');

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
        
        // основаная логика (перенесена из tool-скрипта yazz-content-report.php
        // Запустить если выбран userid - иначе в результате могут быть сотни тысяч строк
        if ($userId) {
            set_time_limit(10*60); // устанавливаем время работы 
            $host = Engine::Get()->getProjectURL();
            $changes = new XShopProductChange();
            $changes->addWhere('cdate', $dateFrom, '>=');
            $changes->addWhere('cdate', $dateTo.' 23:59:59', '<=');
            $changes->addWhereQuery("valuenew != valueold");
            $changes->addWhere('valuenew', '', '!=');
            $changes->setOrder('id', 'ASC');
            $changes->setUserid($userId);

            $keyArray = array();
            $a = array();
            while ($x = $changes->getNext()) {
                $keyArray[$x->getKey()] = $x->getKey();

                $a[$x->getProductid()][$x->getKey()] = $x->getValuenew();
            }

            sort($keyArray);

            $resultArray = array();
            foreach ($a as $productID => $keys) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    $tmp = array(
                        'productid' => $product->getId(),
                        'productname' => $product->makeName(),
                        'producturl' => $product->makeURL(),
                    );

                    foreach ($keyArray as $key) {
                        if ($key == 'avail') {
                            continue;
                        }

                        if ($key == 'availtext') {
                            continue;
                        }
                        if ($key == 'sync') {
                            continue;
                        }
                        if ($key == 'term') {
                            continue;
                        }
                        if ($key == 'imagecrop') {
                            continue;
                        }
                        if ($key == 'priceold') {
                            continue;
                        }
                        if ($key == 'price') {
                            continue;
                        }
                        if ($key == 'pricebase') {
                            continue;
                        }
                        if ($key == 'datelifefrom') {
                            continue;
                        }
                        if ($key == 'datelifeto') {
                            continue;
                        }
                        if (preg_match("/use$/ius", $key)) {
                            continue;
                        }
                        if (preg_match("/actual$/ius", $key)) {
                            continue;
                        }
                        if (preg_match("/filter(\d+)id$/ius", $key)) {
                            continue;
                        }
                        if (preg_match("/category(\d+)id$/ius", $key)) {
                            continue;
                        }
                        if (preg_match("/^supplier/ius", $key)) {
                            continue;
                        }

                        if (isset($keys[$key])) {
                            $v = $keys[$key];

                            if ($key == 'description') {
                                $v = 'html';
                            }
                            if ($key == 'image') {
                                $v = $host.'/media/shop/'.$v;
                            }
                            $tmp[$key] = $v;
                        } else {
                            $tmp[$key] = 'no-change';
                        }
                    }

                    $resultArray[] = $tmp;
                } catch (Exception $e) {

                }
            }
        }
        $reportname = Shop::Get()->getTranslateService()->getTranslateSecure('translate_history_change_of_product');
        $this->setValue('reportname', $reportname);
        $this->setValue('dfrom', $dateFrom);
        $this->setValue('dto', $dateTo);
        $this->setValue('changeArray', $resultArray);

        //массивы для select-ов в фильтрах
        // массив пользователей
        $a = array();
        $users = Shop_UserService::Get()->getUsersAll();
        $users->setLevel(3);
        while ($s = $users->getNext()) {
            $namefull = $this->_escapeString($s->getName().' '.$s->getNamemiddle().' '.$s->getNamelast());
            if (!$namefull) {
                continue;
            }
            $a[] = array(
                'id' => $s->getId(),
                'namefull' => $namefull,
            );
        }
        $this->setValue('userArray', $a);

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