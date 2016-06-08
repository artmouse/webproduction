<?php
class report_sourceclients extends Engine_Class {

    public function process() {
        $dateFrom = $this->getArgumentSecure('datefrom', 'date');
        $dateTo = $this->getArgumentSecure('dateto', 'date');

        $sourceID = $this->getArgumentSecure('sourceid', 'int');
        $managerID = $this->getArgumentSecure('managerid', 'int');
        $contractorID = $this->getArgumentSecure('contractorid', 'int');

        // -------

        $clients = Shop::Get()->getUserService()->getUsersAll($this->getUser());
        if ($dateFrom) {
            $clients->addWhere('cdate', $dateFrom, '>=');
        }
        if ($dateTo) {
            $clients->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        }
        if ($sourceID) {
            $clients->setSourceid($sourceID);
        }
        if ($managerID) {
            $clients->setManagerid($managerID);
        }
        if ($contractorID) {
            $clients->setContractorid($contractorID);
        }

        $reportArray = array();

        while ($c = $clients->getNext()) {
            try {
                if (empty($reportArray[$c->getSourceid()])) {
                    $reportArray[$c->getSourceid()] = array(
                    'name' => $this->_escapeString($c->getSource()->makeName()),
                    'count' => 1,
                    );
                } else {
                    $reportArray[$c->getSourceid()]['count'] ++;
                }
            } catch (Exception $e) {

            }
        }
        $this->setValue('reportArray', $reportArray);

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