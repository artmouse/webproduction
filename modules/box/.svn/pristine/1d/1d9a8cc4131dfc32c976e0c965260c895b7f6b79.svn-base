<?php
class box_block_info_short extends Engine_Class {

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
        $process = $this->getValue('process');

        // текущий авторизированный пользователь
        $user = $this->getUser();

        $canEdit = Shop::Get()->getShopService()->isOrderChangeAllowed($order, $user);
        $this->setValue('canEdit', $canEdit);

        // когда нажата кнопка Сохранить
        if (!$process && $canEdit && $this->getControlValue('ok')) {
            // обновляем номер заказа
            try{
                $number = $this->getArgument('number');
            } catch (Exception $enumber) {
                $number = false;
            }

            if ($number) {
                $tmp = new XShopOrder();
                $tmp->setNumber($number);
                $tmp->addWhere('id', $order->getId(), '<>');
                $tmp->setLimitCount(1);
                if ($tmp->getNext()) {
                    $this->setValue('IdBusy', 'ok');
                    throw new ServiceUtils_Exception();
                } else {
                    $order->setNumber($number);

                }
            }

            // обновляем имя заказа
            try {
                $name = $this->getArgument('name');
                Shop::Get()->getShopService()->updateOrderName($order, $this->getUser(), $name);
            } catch (Exception $ename) {

            }

            // обновляем статус
            try {
                $statusID = $this->getArgument('info_status_short');
            } catch (Exception $e) {
                $statusID = false;
            }
            if ($statusID) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $this->getUser(),
                    $order,
                    $statusID
                );
            }

            // обновляем оплату заказа
            try{
                $order->setPaymentid($this->getArgument('payment'));
            } catch (Exception $e) {

            }

            // обвновляем доставку
            try{
                $order->setDeliveryid($this->getArgument('delivery'));
            } catch (Exception $e) {

            }

            // обновляем накладную доставки
            try{
                $order->setDeliverynote($this->getArgument('deliveryNote'));
            } catch (Exception $e) {

            }

            // обновляем заказ
            $order->update();
        }

        // все варианты доставки
        $a = array();
        $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
        while ($d = $delivery->getNext()) {
            $a[] = array(
                'id' => $d->getId(),
                'name' => $d->getName(),
                'currency' => $d->getCurrency()->getSymbol(),
                'price' => $d->makePrice($order->getCurrency()),
            );
        }
        $this->setControlValue('delivery', $order->getDeliveryid());
        $this->setValue('deliveryArray', $a);

        // @todo: total refactoring, что это за ахтунг?
        try {
            try {
                Shop::Get()->getDeliveryService()->getDeliveryByID(
                    $order->getDeliveryid()
                );

                $payment = Shop::Get()->getShopService()->getPaymentByDeliveryID(
                    $order->getDeliveryid()
                );

                if ($payment->getCount() == 0) {
                    throw new ServiceUtils_Exception();
                }
            } catch (Exception $e) {
                $payment = Shop::Get()->getShopService()->getPaymentAll();
                $payment->setDeliveryid(0);
            }

            $payment->setHidden(0);
            $a = array();
            while ($pay = $payment->getNext()) {
                $a[] = array(
                    'id' => $pay->getId(),
                    'name' => $pay->getName()
                );
            }
            $this->setControlValue('payment', $order->getPaymentid());
            $this->setValue('paymentArray', $a);
        } catch (Exception $de) {

        }

        try {
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID(
                $order->getDeliveryid()
            );

            // если доставка новой почты, то делаем ссылку на состояние посылки
            if ($order->getDeliverynote()
                && $delivery->getLogicclass() == 'ShopDelivery_NovaPoshta'
                && class_exists('ShopDelivery_NovaPoshta')
            ) {
                $novaPoshta = new ShopDelivery_NovaPoshta();
                $this->setValue('deliveryNoteUrl', $novaPoshta->getDeliveryNoteUrl($order->getDeliverynote()));
            }
        } catch (Exception $de) {

        }

        $this->setControlValue('info_status_short', $order->getStatusid());
        $this->setControlValue('deliveryNote', $order->getDeliverynote());
        $this->setControlValue('number', $order->getNumber());
        $this->setControlValue('name', $order->getName());

        try {
            $this->setValue('statusName', $order->getStatus()->makeName());
            $this->setValue('statusColor', $order->getStatus()->getColour());
        } catch (Exception $e) {

        }

        // статусы заказа по workflow
        $statusNextArray = array();
        try {
            $category = $order->getWorkflow();

            $statuses = WorkflowService::Get()->getStatusNextByWorkflow($category, $order->getStatus());
            while ($s = $statuses->getNext()) {
                $statusNextArray[] = array(
                   'id' => $s->getId(),
                   'name' => $s->makeName(),
                );
            }
        } catch (Exception $e) {

        }
        $this->setValue('statusNextArray', $statusNextArray);

    }

}