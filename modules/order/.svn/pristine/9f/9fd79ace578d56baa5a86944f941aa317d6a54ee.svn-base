<?php
class report_orderstatus extends Engine_Class {

    public function process() {
        $typeArray = $this->getArgumentSecure('type', 'array');
        if (!$typeArray) {
            $typeArray = array('', 'order', 'project');
        }
        $this->setValue('typeArray', $typeArray);

        if ($this->getArgumentSecure('ok')) {
            $dateFrom = $this->getArgumentSecure('datefrom', 'date');
            $dateTo = $this->getArgumentSecure('dateto', 'date');

            $sourceID = $this->getArgumentSecure('sourceid', 'int');
            $managerID = $this->getArgumentSecure('managerid', 'int');
            $authorID = $this->getArgumentSecure('authorid', 'int');
            $contractorID = $this->getArgumentSecure('contractorid', 'int');
            $direction = $this->getArgumentSecure('direction', 'string');

            $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
            $statusIDArray = $this->getArgumentSecure('statusid', 'array');

            // -------

            // идем по всем заказам и считаем статистику

            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
            $orders->addWhereArray($typeArray, 'type');
            if ($direction == 'in') {
                $orders->setOutcoming(0);
            }
            if ($direction == 'out') {
                $orders->setOutcoming(1);
            }
            if ($dateFrom) {
                $orders->addWhere('cdate', $dateFrom, '>=');
            }
            if ($dateTo) {
                $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
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

            $reportArray = array();

            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencySystem->getSymbol());

            $orders->setOrder(array('userid', 'cdate'));

            while ($order = $orders->getNext()) {
                try {
                    $sum = $order->getSumbase();

                    try {
                        $manager = $order->getManager();
                        $managerName = $manager->makeName(true, 'lfm');
                        $managerURL = $manager->makeURLEdit();
                        $managerID = $manager->getId();
                    } catch (Exception $mEx) {
                        $managerName = false;
                        $managerURL = false;
                        $managerID = false;
                    }

                    try {
                        $client = $order->getClient();

                        $clientName = $client->makeName(true, 'lfm');
                        $clientURL = $client->makeURLEdit();
                        $clientID = $client->getId();
                    } catch (Exception $mEx) {
                        $clientName = false;
                        $clientURL = false;
                        $clientID = false;
                    }

                    $tmp = new XShopOrderChange();
                    $tmp->setOrderid($order->getId());
                    $tmp->setKey('statusid');
                    $tmp->addWhereArray($statusIDArray, 'value');
                    $tmp->setOrderBy('id', 'DESC');
                    $tmp->setLimitCount(1);
                    if ($xtmp = $tmp->getNext()) {
                        $statusDate = $xtmp->getCdate();
                        $diff = DateTime_Differ::DiffDay($statusDate, $order->getCdate());
                    } else {
                        continue;
                    }

                    $reportArray[] = array(
                    'clientName' => $this->_escapeString($clientName),
                    'clientURL' => $clientURL,
                    'clientID' => $clientID,
                    'managerName' => $this->_escapeString($managerName),
                    'managerURL' => $managerURL,
                    'managerID' => $managerID,
                    'orderName' => $order->makeName(false),
                    'orderId' => $order->getId(),
                    'orderURL' => $order->makeURLEdit(),
                    'sum' => $sum,
                    'orderDate' => $order->getCdate(),
                    'statusDate' => $statusDate,
                    'diff' => $diff,
                    );
                } catch (Exception $e) {
                    print $e;
                }
            }

            $this->setValue('reportArray', $reportArray);

            $reportClientArray = array();
            $reportManagerArray = array();

            foreach ($reportArray as $x) {
                @$reportClientArray[$x['clientName']]['diff'] += $x['diff'];
                @$reportClientArray[$x['clientName']]['cnt'] ++;

                @$reportManagerArray[$x['managerName']]['diff'] += $x['diff'];
                @$reportManagerArray[$x['managerName']]['cnt'] ++;
            }

            foreach ($reportClientArray as $clientName => $x) {
                $reportClientArray[$clientName] = round($x['diff'] / $x['cnt'], 2);
            }

            foreach ($reportManagerArray as $managerName => $x) {
                $reportManagerArray[$managerName] = round($x['diff'] / $x['cnt'], 2);
            }

            $this->setValue('reportClientArray', $reportClientArray);
            $this->setValue('reportManagerArray', $reportManagerArray);
        }

        // -------

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