<?php
class report_compareorderplan extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom');
        $dateTo = $this->getArgumentSecure('dateto');

        if (!$dateFrom) {
            $dateFrom = DateTime_Object::Now()->addDay(+0)->setFormat('Y-m-01')->__toString();

            $this->setControlValue('datefrom', $dateFrom);
        } else {
            $dateFrom = DateTime_Object::FromString($dateFrom)->setFormat('Y-m-d')->__toString();
        }
        if (!$dateTo) {
            $dateTo = DateTime_Object::Now()->addMonth(+1)->setFormat('Y-m-t')->__toString();

            $this->setControlValue('dateto', $dateTo);
        } else {
            $dateTo = DateTime_Object::FromString($dateTo)->setFormat('Y-m-d')->__toString();
        }

        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $authorID = $this->getArgumentSecure('authorid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');
        $direction = $this->getArgumentSecure('direction', 'string');

        $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
        $statusIDArray = $this->getArgumentSecure('statusid', 'array');

        $typeArray = $this->getArgumentSecure('type', 'array');
        if (!$typeArray) {
            $typeArray = array('', 'order', 'project');
        }
        $this->setValue('typeArray', $typeArray);

        // -------

        // идем по всем заказам и считаем статистику

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $orders->addWhereArray($typeArray, 'type');
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        if ($direction == 'in') {
            $orders->setOutcoming(0);
        }
        if ($direction == 'out') {
            $orders->setOutcoming(1);
        }
        if ($workflowIDArray) {
            $orders->addWhereArray($workflowIDArray, 'categoryid');
        }
        if ($sourceID) {
            $orders->setSourceid($sourceID);
        }
        if ($managerID) {
            $orders->setManagerid($managerID);
        }
        if ($authorID) {
            $orders->setAuthorid($authorID);
        }
        if ($contractorID) {
            $orders->setContractorid($contractorID);
        }
        if ($statusIDArray) {
            $orders->addWhereArray($statusIDArray, 'statusid');
        }

        $reportArray = array();

        $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();

        while ($order = $orders->getNext()) {
            try {
                $sumReal = Shop::Get()->getCurrencyService()->convertCurrency(
                $order->makeSum(),
                $order->getCurrency(),
                $currencySystem
                );

                $sumPredicted = Shop::Get()->getCurrencyService()->convertCurrency(
                $order->getMoney(),
                $order->getCurrency(),
                $currencySystem
                );

                $sumPaid = Shop::Get()->getCurrencyService()->convertCurrency(
                $order->makeSumPaid(),
                $order->getCurrency(),
                $currencySystem
                );

                $sumBalance = Shop::Get()->getCurrencyService()->convertCurrency(
                $order->makeSumBalance(),
                $order->getCurrency(),
                $currencySystem
                );

                $reportArray[] = array(
                'name' => $order->makeName(),
                'orderId' => $order->getId(),
                'orderUrl' => $order->makeURLEdit(),
                'client' => $order->getClient()->makeName(),
                'clientUrl' => $order->getClient()->makeURLEdit(),
                'clientId' => $order->getClient()->getId(),
                'sum' => $sumReal,
                'sumPredicted' => $sumPredicted,
                'sumDiff' => $sumPredicted > 0 ? $sumPredicted - $sumReal : false,
                'paid' => $sumPaid,
                'balance' => $sumBalance,
                );
            } catch (Exception $e) {

            }
        }

        $this->setValue('reportArray', $reportArray);

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            );
        }
        $this->setValue('managerArray', $a);

        // источники заказов
        $sources = Shop::Get()->getShopService()->getSourceAll();
        $this->setValue('sourceArray', $sources->toArray());

        // юридические лица
        $contractors = Shop::Get()->getShopService()->getContractorsActive();
        $this->setValue('contractorArray', $contractors->toArray());

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
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