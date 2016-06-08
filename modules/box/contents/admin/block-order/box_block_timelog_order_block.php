<?php
class box_block_timelog_order_block extends Engine_Class {

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

    public function process() {
        // получаем заказ
        $order = $this->_getOrder();
        $user = $this->getUser();
        $process = $this->getValue('process');

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        if (!$process && $canEdit && $this->getArgumentSecure('ok')) {
            $time = mb_strtolower(str_replace(' ', '', $this->getArgumentSecure('block_time_hour')));
            if ($time) {

                $minute = 0;
                if (substr_count($time, 'd') || substr_count($time, 'д')) {
                    // дни
                    $time = str_replace(array('d', 'д'), '', $time);
                    $minute = $time*60*24;
                } elseif (substr_count($time, 'h')) {
                    $timeArr = explode('h', $time);
                    if (strlen(@$timeArr[1]) == 1) {
                        $timeArr[1] = $timeArr[1]*10;
                    } elseif (strlen(@$timeArr[1]) > 1 && strpos($timeArr[1], '0') === 0) {
                        $timeArr[1] = str_replace('0', '', $timeArr[1]);
                    }

                    $minute = @$timeArr[0]*60 + @$timeArr[1];
                } elseif (substr_count($time, 'ч')) {
                    // часы
                    $timeArr = explode('ч', $time);
                    $minute = @$timeArr[0]*60 + @$timeArr[1];
                } elseif (substr_count($time, '.') || substr_count($time, ',')) {
                    // часы
                    $time = str_replace(',', '.', $time);
                    $minute = $time*60;
                } else {
                    // минуты
                    $minute= $time;
                }

                $minute = (int) $minute;

                if ($minute) {
                    $time = new XShopTimeLog();
                    $time->setOrderid($order->getId());
                    $time->setUserid($this->getUser()->getId());
                    $time->setCdate(DateTime_Object::Now());
                    $time->setTime($minute);
                    $time->insert();
                }
            }
        }

        $time = new XShopTimeLog();
        $time->setOrderid($order->getId());

        $minutes = 0;
        while ($x = $time->getNext()) {
            $minutes+= $x->getTime();
        }

        //$this->setValue('hour', sprintf('%02d:%02d', floor($minutes/60), $minutes%60));
        $this->setValue('hour', round($minutes/60, 2));
    }

}