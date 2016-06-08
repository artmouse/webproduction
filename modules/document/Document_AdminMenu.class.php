<?php

class Document_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // добавляем документы в верхнее меню
        Shop_ModuleLoader::Get()->registerTopMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_documents'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-document-index'),
            'documents',
            'icon-docs'
        );

        // добавляем шаблоны документов в "Настройки"
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Шаблоны документов',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-document-templates'),
            'documents'
        );
    }

}