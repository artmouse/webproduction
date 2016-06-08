<?php
class report_timelog extends Engine_Class {

    public function process() {
        if ($this->getArgumentSecure('ok')) {
            $managerID = $this->getArgumentSecure('managerid', 'array');

            if (count($managerID) == 1 && $managerID[0] == 0 ) {
                $managerID = array();
            }

            $this->setValue('managerFilter', $managerID);
            $time = new XShopTimeLog();

            if ($managerID) {
                $time->addWhereArray($managerID, 'userid');
            }

            if ($this->getArgumentSecure('workflowid')) {
                $time->addWhereQuery(
                    '`orderid` IN (SELECT `id` FROM `shoporder` WHERE `categoryid` = '.
                    $this->getArgumentSecure('workflowid').')'
                );
            }

            if ($this->getArgumentSecure('datefrom')) {
                $time->addWhere(
                    'cdate',
                    DateTime_Object::FromString($this->getArgumentSecure('datefrom').' 00:00:00')->__toString(),
                    '>'
                );
            }

            if ($this->getArgumentSecure('dateto')) {
                $time->addWhere(
                    'cdate',
                    DateTime_Object::FromString($this->getArgumentSecure('dateto').' 23:59:59')->__toString(),
                    '<'
                );
            }


            $reportArray = array();
            $reportArray2 = array();

            $time->setOrder('id', 'DESC');

            while ($x = $time->getNext()) {
                $orderName = $x->getOrderid();
                $orderUrl = false;
                $orderId = false;
                try {
                    $order = Shop::Get()->getShopService()->getOrderByID($x->getOrderid());
                    $orderName = $order->makeName();
                    $orderUrl = $order->makeURLEdit();
                    $orderId = $order->getId();
                } catch (Exception $erder) {

                }

                $userName = $x->getUserid();
                $userUrl = false;
                $userId = false;
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($x->getUserid());
                    $userName = $user->makeName(false, 'lfm');
                    $userUrl = $user->makeURLEdit();
                    $userId = $user->getId();
                } catch (Exception $erder) {

                }

                $key = false;
                if ($userId && $orderId) {
                    $key = 'u-'.$userId.'o-'.$orderId;
                }

                if ($key) {
                    if (array_key_exists($key, $reportArray)) {
                        $reportArray[$key]['time'] += round($x->getTime()/60, 2);
                    } else {
                        $reportArray[$key] = array(
                            'date' => $x->getCdate(),
                            'name' => $orderName,
                            'url' => $orderUrl,
                            'nameUser' => $userName,
                            'urlUser' => $userUrl,
                            'time' => round($x->getTime()/60, 2)
                        );
                    }

                } else {
                    $reportArray[] = array(
                        'date' => $x->getCdate(),
                        'name' => $orderName,
                        'url' => $orderUrl,
                        'nameUser' => $userName,
                        'urlUser' => $userUrl,
                        'time' => round($x->getTime()/60, 2)
                    );
                }


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

        $workflowArray = array();

        $workflows = WorkflowService::Get()->getWorkflowsAll($this->getUser());
        while ($x = $workflows->getNext()) {
            $workflowArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName()
            );
        }
        $this->setValue('workflowArray', $workflowArray);
    }

}