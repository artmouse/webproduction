<?php

class Marginrule_CronHour implements Events_IEventObserver{

    public function notify(Events_Event $event) {
        $event;

        // Автоматический пересчет цен товаров
        $automaticCalculate = Shop::Get()->getSettingsService()->getSettingValue('automatic-calculate-prices');
        if (!$automaticCalculate) {
            return;
        }
        $automaticCalculateArray = @unserialize($automaticCalculate);
        if ($automaticCalculateArray && in_array(date('H'), $automaticCalculateArray)) {
            Shop::Get()->getSupplierService()->createProductPriceTask(0);
        }
    }

}