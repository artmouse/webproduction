<?php
class box_block_issues_like extends Engine_Class {

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
        if (strlen($order->getName()) > 2 && $order->getParentid()) {
            // список заказов
            $orders = Shop::Get()->getShopService()->searchOrders($order->getName(), $user);
            $orders->setParentid($order->getParentid());
            $orders->addWhere('id', $order->getId(), '<>');
            $orders->setLimitCount(30);
            $orders->setOrder('id', 'DESC');
            $orderArray = array();
            while ($x = $orders->getNext()) {
                $orderArray[] = $this->_makeOrderInfoArray($x);
            }
            $this->setValue('orderArray', $orderArray);

        }

    }

    /**
     * Получить массив информации о задаче
     *
     * @param ShopOrder $issue
     *
     * @return array
     */
    private function _makeOrderInfoArray(ShopOrder $issue) {
        $a = array();

        $managerName = false;
        $managerUrl = false;
        try {
            $managerName = $issue->getManager()->makeName(true, 'lfm');
            $managerUrl = $issue->makeURLEdit();
        } catch (Exception $ee) {

        }

        $dateto = false;
        $fire = Shop::Get()->getShopService()->isFireOrder($issue);
        if (!$fire && $issue->getType() != 'issue') {
            $fire = Shop::Get()->getShopService()->isFireOrderStatus($issue);
        }

        if ($issue->getDateto()) {
            $dateto = $issue->getDateto();
            $dateto = DateTime_Formatter::DatePhoneticMonthRus(
                DateTime_Object::FromString($dateto)->setFormat('d-m-Y')
            );
        }

        $a = array(
            'id' => $issue->getId(),
            'name' => $issue->getName(),
            'url' => $issue->makeURLEdit(),
            'managerName' => $managerName,
            'managerUrl' => $managerUrl,
            'dateto' => $dateto,
            'fire' => $fire,
            'closed' => $issue->getDateclosed() == '0000-00-00 00:00:00' ? false:true
        );

        return $a;
    }

}