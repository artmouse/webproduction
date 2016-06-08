<?php
class shop_page_yandex_map extends Engine_Class {

    public function process() {
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
    }

}