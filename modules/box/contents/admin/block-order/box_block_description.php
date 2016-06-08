<?php
class box_block_description extends Engine_Class {

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
        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);
        $process = $this->getValue('process');

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {
            // обновляем описанние
            try{
                $order->setComments($this->getArgument('comments'));
            } catch (Exception $ecomments) {

            }

            // обновляем заказ
            $order->update();
        }

        $this->setControlValue('comments', $order->getComments());
        $this->setValue(
            'comments',
            Shop::Get()->getShopService()->formatComment(
                $order->getComments(),
                'order-'.$order->getId()
            )
        );

    }

}