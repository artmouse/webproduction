<?php
class box_block_stage_history extends Engine_Class {

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

        // список пройденых этапов
        $statusArray = array();
        $orderChange = new XShopOrderChange();
        $orderChange->setOrderid($order->getId());
        $orderChange->setKey('statusid');
        while ($x = $orderChange->getNext()) {
            try{
                $status = Shop::Get()->getShopService()->getStatusByID($x->getValue());
                $statusArray[] = array(
                    'name' => $status->getName(),
                    'color' => $status->getColour()
                );
            } catch (Exception $estatus) {

            }

        }
        $this->setValue('statusedArray', $statusArray);
    }

}