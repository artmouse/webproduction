<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

class Utm_Order implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        try {
            $this->_setOrderUTM($event->getOrder());
        } catch (ServiceUtils_Exception $e) {
            return;
        }

    }

    /**
     * Поставить заказу UTM-метки, referal, IP.
     *
     * @param ShopOrder $order
     */
    protected function _setOrderUTM(ShopOrder $order) {
        if (!empty($_COOKIE['utm_source'])) {
            $order->setUtm_source($_COOKIE['utm_source']);
        }
        if (!empty($_COOKIE['utm_medium'])) {
            $order->setUtm_medium($_COOKIE['utm_medium']);
        }
        if (!empty($_COOKIE['utm_campaign'])) {
            $order->setUtm_campaign($_COOKIE['utm_campaign']);
        }
        if (!empty($_COOKIE['utm_content'])) {
            $order->setUtm_content($_COOKIE['utm_content']);
        }
        if (!empty($_COOKIE['utm_source'])) {
            $order->setUtm_term($_COOKIE['utm_term']);
        }
        if (!empty($_COOKIE['utm_date'])) {
            $order->setUtm_date($_COOKIE['utm_date']);
        }
        if (!empty($_COOKIE['utm_referrer'])) {
            $order->setUtm_referrer($_COOKIE['utm_referrer']);
        }
        $order->update();
    }

}