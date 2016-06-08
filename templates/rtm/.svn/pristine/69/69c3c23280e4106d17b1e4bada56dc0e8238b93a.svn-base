<?php
class report_utm extends Engine_Class {

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

        $orderid = false;
        $level = false;
        if ($this->getArgumentSecure('ok') && $utm = $this->getArgumentSecure('utm')) {
            $this->setControlValue('utm', $utm);
            $tableArray = array();
            try{
                $utm = explode('|#|', $utm, 2);
                $orderid = $utm[1];
                $level = $utm[0];
                $order = new XShopOrder($orderid);
                $utm_source = $order->getUtm_source();
                $utm_medium = $order->getUtm_medium();
                $utm_campaign = $order->getUtm_campaign();

                $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
                $orders->addWhere('cdate', $dateFrom, '>=');
                $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
                $orders->setOrderBy('');
                $orders->setOrderType('');
                $orders->setGroupByQuery('`utm_source`, `utm_medium`, `utm_campaign`, `utm_content`, `utm_term`');

                if ($level == 0) {
                    $orders->setUtm_source($utm_source);
                } elseif ($level == 1) {
                    $orders->setUtm_source($utm_source);
                    $orders->setUtm_medium($utm_medium);
                } elseif ($level == 2) {
                    $orders->setUtm_source($utm_source);
                    $orders->setUtm_medium($utm_medium);
                    $orders->setUtm_campaign($utm_campaign);
                }

                while ($order = $orders->getNext()) {
                    $tableArray[] = array(
                        'id' => $order->getId(),
                        'name' => $order->getName(),
                        'url' => $order->makeURLEdit(),
                        'source' => urldecode($order->getUtm_source()),
                        'medium' => urldecode($order->getUtm_medium()),
                        'campaign' => urldecode($order->getUtm_campaign()),
                        'content' => urldecode($order->getUtm_content()),
                        'term' => urldecode($order->getUtm_term()),
                        'utm_date' => str_replace('.', '-', DateTime_Formatter::DateRussianGOST($order->getUtm_date())),
                        'order_date' => str_replace('.', '-', DateTime_Formatter::DateRussianGOST($order->getCdate())),
                        'date' => DateTime_Differ::DiffDay($order->getCdate(), $order->getUtm_date())
                    );
                }
                $this->setValue('tableArray', $tableArray);
                $this->setValue('productCount', $orders->getCount());
            } catch (Exception $e2) {

            }
        }

        $orders = Shop::Get()->getShopService()->getOrdersAll($this->getUser(), true);
        $orders->addWhere('cdate', $dateFrom, '>=');
        $orders->addWhere('cdate', $dateTo.' 23:59:59', '<=');
        $orders->setOrderBy('');
        $orders->setOrderType('');
        $orders->addWhere('utm_source', '', '<>');
        $orders->setGroupByQuery('`utm_source`, `utm_medium`, `utm_campaign`');

        $reportArray = array();
        $source = '';
        $medium = '';
        $campaign = '';
        while ($order = $orders->getNext()) {

            if ($source != $order->getUtm_source()) {
                if (!$order->getUtm_source()) {
                    continue;
                }

                $reportArray[] = array(
                    'id' => $order->getId(),
                    'name' => urldecode($order->getUtm_source()),
                    'level' => 0,
                    'selected' => (!$level && $orderid == $order->getId()) ? true:false
                );
                if ($order->getUtm_medium()) {
                    $reportArray[] = array(
                        'id' => $order->getId(),
                        'name' => urldecode($order->getUtm_medium()),
                        'level' => 1,
                        'selected' => ($level == 1 && $orderid == $order->getId()) ? true:false
                    );
                    if ($order->getUtm_campaign()) {
                        $reportArray[] = array(
                            'id' => $order->getId(),
                            'name' => urldecode($order->getUtm_campaign()),
                            'level' => 2,
                            'selected' => ($level == 2 && $orderid == $order->getId()) ? true:false
                        );
                    }
                }
            } elseif ($medium != $order->getUtm_medium()) {
                if (!$order->getUtm_source() || !$order->getUtm_medium()) {
                    continue;
                }
                $reportArray[] = array(
                    'id' => $order->getId(),
                    'name' => urldecode($order->getUtm_medium()),
                    'level' => 1,
                    'selected' => ($level == 1 && $orderid == $order->getId()) ? true:false
                );
                if ($order->getUtm_campaign()) {
                    $reportArray[] = array(
                        'id' => $order->getId(),
                        'name' => urldecode($order->getUtm_campaign()),
                        'level' => 2,
                        'selected' => ($level == 2 && $orderid == $order->getId()) ? true:false
                    );
                }


            } else {
                if (!$order->getUtm_source() || !$order->getUtm_medium() || !$order->getUtm_campaign()) {
                    continue;
                }
                $reportArray[] = array(
                    'id' => $order->getId(),
                    'name' => urldecode($order->getUtm_campaign()),
                    'level' => 2,
                    'selected' => ($level == 2 && $orderid == $order->getId()) ? true:false
                );
            }

            $source = $order->getUtm_source();
            $medium = $order->getUtm_medium();
            $campaign = $order->getUtm_campaign();
        }
        $this->setValue('reportArray', $reportArray);
    }
}