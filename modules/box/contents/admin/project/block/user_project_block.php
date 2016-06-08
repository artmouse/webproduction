<?php
class user_project_block extends Engine_Class {

    public function process() {
        $userIDArray = $this->getValue('userIDArray');
        $user = $this->getValue('user');

        // статистика
        $orders = IssueService::Get()->getProjectsAll($this->getUser());
        $orders->addWhereArray($userIDArray, 'userid');
        $totalOrdersIn = 0;
        $totalOrdersOut = 0;
        $totalSumIn = 0;
        $totalSumOut = 0;
        $totalSumPayed = 0;
        $totalProduct = 0;
        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($x = $orders->getNext()) {

            try {
                $totalSum = Shop::Get()->getCurrencyService()->convertCurrency(
                $x->getSum(),
                $x->getCurrency(),
                $currencySystem
                );

                if ($x->getOutcoming()) {
                    $totalSumOut += $totalSum;
                    $totalOrdersOut ++;

                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed += $totalSum;
                    }
                } else {
                    $totalSumIn += $totalSum;
                    $totalOrdersIn ++;
                    $totalProduct += $x->getOrderProductsCount($x->getId());

                    if ($x->getStatus()->getPayed() || $x->getStatus()->getPrepayed()) {
                        $totalSumPayed -= $totalSum;
                    }
                }
            } catch (Exception $ex) {

            }
        }

        $this->setValue('totalOrdersIn', $totalOrdersIn);
        $this->setValue('totalOrdersOut', $totalOrdersOut);
        $totalOrder = $totalOrdersIn + $totalOrdersOut;
        $this->setValue('totalOrder', $totalOrder);

        $this->setValue('totalProduct', $totalProduct);

        $this->setValue('totalSumIn', $totalSumIn);
        $this->setValue('totalSumOut', $totalSumOut);

        // статистика (Создал заказов)
        $orders = IssueService::Get()->getProjectsAll($this->getUser());
        $orders->addWhereArray($userIDArray, 'authorid');
        $createOrderCount = 0;
        $createOrderSum = 0;
        while ($x = $orders->getNext()) {

            $createOrderCount++;
            $createOrderSum += Shop::Get()->getCurrencyService()->convertCurrency(
            $x->getSum(),
            $x->getCurrency(),
            $currencySystem
            );
        }
        $this->setValue('createOrderSum', $createOrderSum);
        $this->setValue('createOrderCount', $createOrderCount);

        $this->setValue('totalCurrency', $currencySystem->getSymbol());

        $this->setValue('userID', $user->getId());
    }

}