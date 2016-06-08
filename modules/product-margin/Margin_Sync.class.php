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
class Margin_Sync implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        // дописываем нужные settings.
        // Внимание! Этот код должен быть в mode developent
        Shop::Get()->getSettingsService()->addSetting(
            'automatic-calculate-prices',
            'Автоматический пересчет цен',
            'Пересчет цен и наличия',
            'Время выполнения автоматического пересчета цен',
            false, // default value
            'chzn-select-time'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'priority-source-product',
            'Приоритет выбора цены',
            'Пересчет цен и наличия',
            'Приоритет выбора цены продукта',
            'supplier', // default value
            'select-margin-priority'
        );

        Shop::Get()->getSettingsService()->addSetting(
            'margin-not-avail-product',
            'Пересчитывать цены для товаров, которых нет в наличии',
            'Пересчет цен и наличия',
            '', // description
            0, // default value
            'boolean'
        );
    }

}