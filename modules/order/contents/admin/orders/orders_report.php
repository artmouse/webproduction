<?php
class orders_report extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $dateFrom = $this->getArgumentSecure('datefrom');
            $dateTo = $this->getArgumentSecure('dateto');

            if (!$dateFrom) {
                $dateFrom = '1970-01-01';
            }
            if (!$dateTo) {
                $dateTo = date('Y-m-d');
            }

            $dateFrom = DateTime_Corrector::CorrectDate($dateFrom);
            $dateTo = DateTime_Corrector::CorrectDate($dateTo).' 23:59:59';

            $statusID = $this->getArgumentSecure('status', 'int');

            // валюта отчета
            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currencyName', $currency->getName());

            // строим отчет по всем заказам
            $reportArray = array();
            $productArray = array();
            $clientArray = array();

            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser());
            $orders->addWhere('cdate', $dateFrom, '>=');
            $orders->addWhere('cdate', $dateTo, '<=');

            if ($statusID) {
                // только отгруженые заказы
                $orders->setStatusid($statusID);
            }

            while ($order = $orders->getNext()) {
                $ops = $order->getOrderProducts();
                while ($op = $ops->getNext()) {
                    @$reportArray[$order->getUserid()][$op->getProductid()] += $op->makeSum($currency);

                    @$productArray[$op->getProductid()] = $op->getProductname();
                }

                if (!isset($clientArray[$order->getUserid()])) {
                    try {
                        $client = $order->getUser();
                        $clientArray[$client->getId()] = $client->makeName();
                    } catch (Exception $e) {

                    }
                }
            }
            $this->setValue('reportArray', $reportArray);
            $this->setValue('productArray', $productArray);
            $this->setValue('clientArray', $clientArray);
        }

        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $a = array();
        while ($x = $statuses->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            );
        }
        $this->setValue('statusArray', $a);
    }

}