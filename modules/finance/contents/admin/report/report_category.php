<?php
class report_category extends Engine_Class {

    public function process() {
        $startDate = $this->getArgumentSecure('startdate');
        $endDate = $this->getArgumentSecure('enddate');
        $groupBy = $this->getArgumentSecure('groupby');
        $categoryIDArray = $this->getArgumentSecure('categoryid', 'array');

        if (!$groupBy) {
            $groupBy = 'week';
        }
        $this->setControlValue('groupby', $groupBy);

        $cuser = $this->getUser();

        if (!$startDate && !$endDate) {
            $this->setValue('text', true);
        }

        if (!$startDate) {
            $startDate = date("Y-m-d", time()-60*60*24*14);
            $this->setControlValue('startdate', $startDate);
        }

        if (!$endDate) {
            $endDate = date("Y-m-d");
            $this->setControlValue('enddate', $endDate);
        }

        $startDate = DateTime_Corrector::CorrectDate($startDate);
        $endDate = DateTime_Corrector::CorrectDate($endDate);

        if ($startDate && $endDate && in_array($groupBy, array('day', 'week', 'month', 'year'))) {
            $a = array();
            $categoryArray = array();
            $sum = 0;
            $period = '';

            $defaultCurrency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $defaultCurrency->getName());

            $categories = FinanceService::Get()->getCategoryAll();
            if ($categoryIDArray) {
                $categories->addWhereArray($categoryIDArray, 'id');
            }
            if (!$categoryIDArray || in_array(0, $categoryIDArray)) {
                $categoryArray[0]['name'] = Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_no_category'
                );
                $categoryArray[0]['sum'] = 0;
            }
            while ($category = $categories->getNext()) {
                $categoryArray[$category->getId()]['name'] = $category->getName();
                $categoryArray[$category->getId()]['sum'] = 0;
            }

            $date = DateTime_Object::FromString($startDate)->setFormat('Y-m-d');

            while ($date->__toString() <= DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString()) {
                $payments = PaymentService::Get()->getPaymentsByUser($cuser);
                if ($categoryIDArray) {
                    $payments->addWhereArray($categoryIDArray, 'categoryid');
                }

                $payments->addWhereQuery('( DATE(`pdate`) >= \''.$date->setFormat('Y-m-d H:i:s')->__toString().'\' )');

                if ($groupBy == 'day') {
                    $date2 = DateTime_Object::FromString($date->__toString())->addDay(1);
                    $last = ($date->__toString()
                        >= DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString());
                } elseif ($groupBy == 'week') {
                    $date2 = DateTime_Object::FromString($date->__toString())->addDay(7);
                    $last = (DateTime_Object::FromString($date->__toString())->addDay(7)
                        >= DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString());
                } elseif ($groupBy == 'month') {
                    $date2 = DateTime_Object::FromString($date->__toString())->addMonth(1);
                    $last = (DateTime_Object::FromString($date->__toString())->addMonth(1)
                        >= DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString());
                } elseif ($groupBy == 'year') {
                    $date2 = DateTime_Object::FromString($date->__toString())->addYear(1);
                    $last = (DateTime_Object::FromString($date->__toString())->addYear(1)
                        >= DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString());
                }

                if ($date2->setFormat('Y-m-d')->__toString() >
                    DateTime_Object::FromString($endDate)->setFormat('Y-m-d')->__toString()
                ) {
                    $date2 = DateTime_Object::FromString($endDate);
                }

                if ($groupBy == 'day') {
                    $period = $date->setFormat('Y-m-d')->__toString();
                } else {
                    if (!$last) {
                        $period = $date->setFormat('Y-m-d')->__toString() .' - '.
                        DateTime_Object::FromString($date2)->addDay(-1)->setFormat('Y-m-d')->__toString();
                    } else {
                        $period = $date->setFormat('Y-m-d')->__toString()
                            .' - '. $date2->setFormat('Y-m-d')->__toString();
                    }
                }

                if (!$last) {
                    $payments->addWhereQuery(
                        '( DATE(`pdate`) < \''.$date2->setFormat('Y-m-d H:i:s')->__toString().'\' )'
                    );
                } else {
                    $payments->addWhereQuery(
                        '( DATE(`pdate`) <= \''.$date2->setFormat('Y-m-d H:i:s')->__toString().'\' )'
                    );
                }

                @$a[$period]['sum'] += 0;

                while ($x = $payments->getNext()) {
                    $amount = $x->getAmount();

                    $account = new XFinanceAccount();
                    $account->setId($x->getAccountid());
                    if ($account->select()) {
                        $curency = Shop::Get()->getCurrencyService()->getCurrencyByID($account->getCurrencyid());
                    } else {
                        $curency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                    }

                    $amount = Shop::Get()->getCurrencyService()->convertCurrency($amount, $curency, $defaultCurrency);

                    @$categoryArray[$x->getCategoryid()]['sum'] += $amount;
                    @$a[$period][$x->getCategoryid()] += $amount;
                    @$a[$period]['sum'] += $amount;
                    $sum += $amount;
                }

                $date = $date2;
            }

            //arsort($a);

            $this->setValue('table', $a);
            $this->setValue('sum', $sum);
            $this->setValue('categoryArray', $categoryArray);
            $this->setValue('categorySelectedArray', $categoryIDArray);

            $categories = FinanceService::Get()->getCategoryAll();
            $a = array();
            $a[] = array(
            'id' => 0,
            'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_no_category')
            );
            while ($category = $categories->getNext()) {
                $a[] = array(
                'id' => $category->getId(),
                'name' => $category->getName()
                );
            }
            $this->setValue('filterCategoryArray', $a);
        }
    }

}