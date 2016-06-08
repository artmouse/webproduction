<?php
class box_block_call extends Engine_Class {

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

        try{
            $this->setValue('clientPhoneArray', $order->getClient()->getPhoneArray());
        } catch (Exception $eee) {

        }

    }

}