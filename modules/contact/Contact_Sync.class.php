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
 * событие для Sync
 *
 * @author    i.ustimenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Contact_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // settings
        Shop::Get()->getSettingsService()->addSetting(
            'user-add-source-field',
            'Не создавать контакт без указания Источника/канала',
            'Настройки магазина',
            'Невозможно создать контакт без указания Источника или канала',
            '0',
            'boolean'
        );
        
    }

}