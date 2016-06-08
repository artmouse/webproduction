<?php
/**
 * OneBox
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Передача в каждый контент переменных.
 * Все слеплено в кучу в рамках оптимизации.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_ContentValueObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {

        $contentUrl = Engine::GetURLParser()->getTotalURL();

        if (!$this->_currency && $contentUrl != '/install/') {
            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                $this->_currency = $currency->getSymbol();
            } catch (Exception $e) {

            }
        }

        $contentObject = $event->getContent();

        $contentObject->setValue('contentID', Engine::Get()->getRequest()->getContentID());
        $contentObject->setValue('currentURL', Engine::GetURLParser()->getTotalURL());

        if (isset($_COOKIE['filterpanelCookie'])) {
            $contentObject->setValue('filterpanelCookie', @$_COOKIE['filterpanelCookie']);
        }

        $contentObject->setValue('currency', $this->_currency);

        $contentObject->addValuesArray(Shop::Get()->getTranslateService()->getTranslateArray());
    }

    private $_currency = false;

}