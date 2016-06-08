<?php
class orders_control_block_processorform extends Engine_Class {

    public function process() {
        $order = $this->_getOrder();

        try {
            $processorForm = $order->getStatus()->getProcessorform();
        } catch (Exception $e) {
            $processorForm = false;
        }
        if ($processorForm) {
            $processorFormContent = Engine::GetContentDriver()->getContent($processorForm);
            $this->setValue('block_processorform', $processorFormContent->render());
        }
    }

    /**
     * Получить заказ
     *
     * @return ShopOrder
     */
    private function _getOrder() {
        return $this->getValue('order');
    }

}