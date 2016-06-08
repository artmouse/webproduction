<?php
class admin_search_block_order extends Engine_Class {

    public function process() {
        try {
            $cuser = $this->getUser();
            $query = $this->getValue('query');
            $limit = $this->getValue('limit');

            $orderArray = array();

            $workflowType = new XShopWorkflowType();
            $workflowType->addWhere('type', 'issue', '<>');
            while ($wt = $workflowType->getNext()) {
                // поиск проектов
                $orders = Shop::Get()->getShopService()->searchOrders($query, $cuser, $wt->getType());
                $orders->setLimitCount($limit);
                $orders->setDateclosed('0000-00-00 00-00');
                $orders->setType($wt->getType());

                $orderArray = $this->_addOrdersToArray($orders, $orderArray);
            }

            $workflowType = new XShopWorkflowType();
            $workflowType->addWhere('type', 'issue', '<>');
            while ($wt = $workflowType->getNext()) {
                // поиск закрытых проектов
                $orders = Shop::Get()->getShopService()->searchOrders($query, $cuser, $wt->getType());
                $orders->setLimitCount($limit);
                $orders->addWhere('dateclosed', '0000-00-00 00-00', '!=');
                $orders->setType($wt->getType());

                $orderArray = $this->_addOrdersToArray($orders, $orderArray);
            }

            $this->setValue('orderArray', $orderArray);
        } catch (Exception $e) {

        }
    }

    /**
     * Добавить заказы в массив
     *
     * @param ShopOrder $orders
     * @param array $a
     *
     * @return array
     */
    private function _addOrdersToArray(ShopOrder $orders, $a) {
        while ($order = $orders->getNext()) {
            try {
                $managerName = $order->getManager()->makeName(true, 'lfm');
                $managerURL = $order->getManager()->makeURLEdit();
            } catch (ServiceUtils_Exception $se) {
                $managerName = false;
                $managerURL = false;
            }

            try {
                $clientName = $order->getClient()->makeName();
                $clientURL = $order->getClient()->makeURLEdit();
            } catch (ServiceUtils_Exception $se) {
                $clientName = false;
                $clientURL = false;
            }

            try {
                $color = $order->getStatus()->getColour();
            } catch (Exception $e) {
                $color = false;
            }

            $name = $order->getName();
            if (!$name) {
                $name = $order->getNumber();
            }

            $a[] = array(
                'id' => $order->getNumber(),
                'name' => $name,
                'url' => $order->makeURLEdit(),
                'managerName' => $managerName,
                'managerURL' => $managerURL,
                'clientName' => $clientName,
                'clientURL' => $clientURL,
                'color' => $color,
                'closed' => ($order->getDateclosed() != '0000-00-00 00:00:00')
            );
        }

        return $a;
    }
}