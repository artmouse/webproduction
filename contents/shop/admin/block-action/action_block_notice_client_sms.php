<?php
class action_block_notice_client_sms extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('text_notify_sms_client', $data['text']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $status = $this->_getStatus();
        $status->setSms($this->getArgumentSecure($index.'_text_notify_sms_client'));
        $status->update();

        $data = array(
            'text' => $this->getArgumentSecure($index.'_text_notify_sms_client')
        );

        WorkflowStatusLoader::Get()->addBlockData(
            $this->_getStatus(),
            $this->getContentID(),
            $this->getValue('sort'),
            json_encode($data)
        );
    }

    public function processDataDelete() {
        $status = $this->_getStatus();
        $status->setSms('');
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);
        if (!$order->getClientphone()) {
            return;
        }

        $data = (Array) json_decode($this->getValue('data'));

        // получаем шаблон
        $tpl = $data['text'];
        if (!$tpl) {
            return;
        }

        // формируем письмо
        $html = Shop::Get()->getShopService()->makeOrderTemplate($order, $tpl);

        // отправляем SMS
        try {
            $user = $this->_getUser($event);

            Shop::Get()->getUserService()->sendSMS(
                $order->getClientphone(),
                $html,
                $user
            );

            $comment = trim(strip_tags($html));
            $comment .= "\n\n";
            $comment .= "Отправлено sms на номер {$order->getClientphone()}";

            // после того как письмо отправлено,
            // добавляем его в комментарий к order'y
            Shop::Get()->getShopService()->addOrderSMS(
                $order,
                $user,
                $comment
            );
        } catch (Exception $smsEx) {

        }
    }


    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return User
     */
    private function _getUser($event) {
        return $event->getUser();
    }

    /**
     * Обертка
     *
     * @param Shop_Event_Order $event
     *
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
    }

    /**
     * Обертка
     *
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}