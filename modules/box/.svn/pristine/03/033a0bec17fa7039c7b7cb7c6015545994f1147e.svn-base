<?php
class box_block_stage_instruction extends Engine_Class {

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

        $this->setControlValue('categoryid', $order->getCategoryid());

        try {
            $this->setValue(
                'statusContent',
                Shop::Get()->getShopService()->formatComment($order->getStatus()->getContent(), false)
            );
        } catch (Exception $e) {

        }
    }

}