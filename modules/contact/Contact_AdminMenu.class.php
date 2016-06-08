<?php

class Contact_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop_ModuleLoader::Get()->registerTopMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_users'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-users'),
            'users',
            'icon-users'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_users_groups'),
            '/admin/shop/usergroups/',
            'users-groups'
        );

        // настройки полей
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Поля контактов',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-contactfield'),
            'users'
        );
    }

}