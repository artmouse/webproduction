<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Подгрузка переводов по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_TranslateLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        // генерим событие для модуля мультиязычности
        $event = Events::Get()->generateEvent('beforeShopTranslateObserver');
        $event->notify();

        // текущий язык
        $language = Engine::Get()->getConfigFieldSecure('language-site');

        if (strpos(Engine::GetURLParser()->getTotalURL(), '/admin/') === 0
            && Engine::Get()->getConfigFieldSecure('language-admin')) {
            $language = Engine::Get()->getConfigFieldSecure('language-admin');
        }

        if (!$language) {
            $language = 'ru';
        }

        // загружаем переводы translate, стандартные
        $phpFile = PackageLoader::Get()->getProjectPath().'/translate/'.$language.'.php';
        Shop::Get()->getTranslateService()->addTranslateFromPHP($phpFile);
    }

}