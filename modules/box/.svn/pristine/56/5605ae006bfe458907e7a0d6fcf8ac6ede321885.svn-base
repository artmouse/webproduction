<?php
class report_performersorders extends Engine_Class {

    public function process() {

        if ($this->getArgumentSecure('ok')) {
            $datePaymentFrom = $this->getArgumentSecure('paymentfrom', 'date');
            $datePaymentTo = $this->getArgumentSecure('paymentto', 'date');
            $workflowIDArray = $this->getArgumentSecure('workflowid', 'array');
            $statusIDArray = $this->getArgumentSecure('statusid', 'array');

            $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);

            if ($workflowIDArray) {
                $orders->addWhereArray($workflowIDArray, 'categoryid');
            }
            
            if ($statusIDArray) {
                $orders->addWhereArray($statusIDArray, 'statusid');
            }

            
            $reportArray = array();
            $managerArray = array();
            while ($order = $orders->getNext()) {
                try {
                    $payments = new FinancePayment();
                    $payments->setOrderid($order->getId());
                    if ($datePaymentFrom) {
                        $payments->addWhere('pdate', $datePaymentFrom, '>=');
                    }
                    if ($datePaymentTo) {
                        $payments->addWhere('pdate', $datePaymentTo.' 23:59:59', '<=');
                    }
                    
                    while ($x = $payments->getNext()) {                        
                        if ($datePaymentFrom && !$x->getAmount()) {
                            continue;
                        }
                        
                        $employers = new ShopOrderEmployer();
                        $employers->setOrderid($order->getId());
                        while ($xx = $employers->getNext()) {
                            try {
                                $manager = Shop_UserService::Get()->getUserByID($xx->getManagerid());
                                $reportArray[$order->getId()]['orderid'] = $order->getId();
                                $reportArray[$order->getId()]['orderUrl'] = $order->makeURLEdit();
                                $reportArray[$order->getId()]['orderName'] = $order->getName();
                                if (isset($reportArray[$order->getId()]['data'][$manager->getId()])) {
                                    $reportArray[$order->getId()]['data'][$manager->getId()]['amount'] += round(
                                        $x->getAmount() * ($xx->getPercent()/100),
                                        2
                                    );
                                } else {
                                    $reportArray[$order->getId()]['data'][$manager->getId()] = array(
                                        'managerId' => $manager->getId(),
                                        'amount' => round($x->getAmount() * ($xx->getPercent()/100), 2)
                                    ); 
                                }
                                if (!isset($managerArray[$manager->getId()])) {
                                    $managerArray[$manager->getId()] = $this->_escapeString($manager->makeName());
                                }
                               
                            } catch (Exception $ex) {
                                
                            }
                        }
                    
                    }

                } catch (Exception $e) {

                }
            }
        }
        $this->setValue('reportArray', $reportArray);
        $this->setValue('managerArray', $managerArray);
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