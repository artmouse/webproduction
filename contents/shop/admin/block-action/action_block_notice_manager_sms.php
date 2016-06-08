<?php
class action_block_notice_manager_sms extends Engine_Class {

    public function process() {
        $this->setValue('contentID', $this->getContentID());
        $this->setValue('index', $this->getValue('index'));

        $data = (Array) json_decode($this->getValue('data'));
        $this->setValue('text_notify_sms_admin', $data['text']);
    }

    public function processData() {
        $index = $this->getValue('index');

        $status = $this->_getStatus();
        $status->setSmsadmin($this->getArgumentSecure($index.'_text_notify_sms_admin'));
        $status->update();

        $data = array(
            'text' => $this->getArgumentSecure($index.'_text_notify_sms_admin')
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
        $status->setSmsadmin('');
        $status->update();
    }

    public function processStatus(Events_Event $event) {
        $order = $this->_getOrder($event);
        $data = (Array) json_decode($this->getValue('data'));

        // номер телефона админа
        $phone = Shop::Get()->getSettingsService()->getSettingValue('sms-admin-phone');
        if (!$phone) {
            return;
        }

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
                $phone,
                $html,
                $user
            );

            $comment = trim(strip_tags($html));
            $comment .= "\n\n";
            $comment .= "Отправлено sms на номер {$phone}";

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
     * @return ShopOrder
     */
    private function _getOrder($event) {
        return $event->getOrder();
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
     * @return ShopOrderStatus
     */
    private function _getStatus () {
        return $this->getValue('status');
    }

}