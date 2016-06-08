<?php

class ProductMargin_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_marginrule_system'),
            '/admin/shop/marginrule/'
        );

    }

}