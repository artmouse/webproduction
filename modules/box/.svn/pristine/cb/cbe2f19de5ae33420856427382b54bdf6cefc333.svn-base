<?php
class box_block_active_order extends Engine_Class {

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

        // список активных заказов
        $orders = Shop::Get()->getShopService()->getOrdersAll($user);
        $orders->setDateclosed('0000-00-00 00:00:00');
        $orders->setOrder('id', 'DESC');
        $orders->setLimitCount(100);
        $a = array();
        while ($x = $orders->getNext()) {
            try {
                $color = $x->getStatus()->getColour();
            } catch (Exception $e) {
                $color = false;
            }

            $a[] = array(
                'id' => $x->getId(),
                'clientName' => htmlspecialchars($x->getClientname()),
                'color' => $color,
                'url' => $x->makeURLEdit(),
            );
        }
        $this->setValue('activeOrderArray', $a);

    }

}