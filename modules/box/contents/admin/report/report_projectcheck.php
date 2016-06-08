<?php
class report_projectcheck extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $managerID = $this->getArgumentSecure('managerid', 'int');
            $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
            $statusIDArray = $this->getArgumentSecure('statusid', 'array');

            // -------

            $currencySystem = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $this->setValue('currency', $currencySystem->getSymbol());

            $orders = new ShopOrder();
            if ($workflowIDArray) {
                $orders->addWhereArray($workflowIDArray, 'categoryid');
            }
            if ($managerID) {
                $orders->setManagerid($managerID);
            }
            if ($statusIDArray) {
                $orders->addWhereArray($statusIDArray, 'statusid');
            }
            $orders->setDateclosed('0000-00-00 00:00:00');
            $orders->setDeleted(0);
            $orders->setOrder('cdate', 'DESC');

            $reportArray = array();

            while ($x = $orders->getNext()) {
                $probationSum = 0;
                $probations = FinanceService::Get()->getProbationsAll();
                $probations->filterOrderid($x->getId());
                $probations->filterPdate(date('Y-m-d'), '>=');
                while ($p = $probations->getNext()) {
                    $probationSum += $p->getAmountbase();
                }

                try {
                    $statusName = $x->getStatus()->makeName();
                    $statusColor = $x->getStatus()->getColour();
                } catch (Exception $e) {
                    $statusName = false;
                    $statusColor = false;
                }

                try {
                    $managerName = $x->getManager()->makeName(true, 'lfm');
                } catch (Exception $e) {
                    $managerName = false;
                }

                // открытые задачи с группировкой по сотрудникам
                $issueArray = array();
                $issues = IssueService::Get()->getIssuesAll($this->getUser());
                $issues->filterParentid($x->getId());
                $issues->setDateclosed('0000-00-00 00:00:00');
                while ($i = $issues->getNext()) {
                    $issueArray[$i->getManagerid()][] = array(
                    'name' => $i->makeName(true),
                    'url' => $i->makeURLEdit(),
                    'dateto' => DateTime_Formatter::DatePhonetic($i->getDateto()),
                    'priority' => $i->getPriority(),
                    );
                }

                $reportArray[] = array(
                'id' => $x->getId(),
                'name' => $x->makeName(true),
                'url' => $x->makeURLEdit(),
                'balance' => $x->makeSumBalance(),
                'balanceCurrency' => $x->getCurrency()->getSymbol(),
                'probation' => $probationSum,
                'statusName' => $statusName,
                'statusColor' => $statusColor,
                'managerName' => $managerName,
                'issueArray' => $issueArray,
                );
            }

            $this->setValue('reportArray', $reportArray);
        }

        // -------

        // менеджеры
        $a = array();
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($x = $managers->getNext()) {
            $a[$x->getId()] = $x->makeName(true, 'lfm');
        }
        $this->setValue('managerArray', $a);

        // статусы заказов
        $block = Engine::GetContentDriver()->getContent('workflow-filter-block');
        $this->setValue('block_workflow_filter', $block->render());
    }

}