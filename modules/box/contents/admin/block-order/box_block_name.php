<?php
class box_block_name extends Engine_Class {

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
        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {
            // обновляем имя заказа
            try{
                $name = $this->getArgument('name');
                Shop::Get()->getShopService()->updateOrderName($order, $this->getUser(), $name);
            } catch (Exception $ename) {

            }
        }

        $this->setControlValue('name', $order->getName());

    }

}