<?php
class shop_tpl_column extends Engine_Class {

    public function process() {
        // настройки
        $this->setValue('phone', strip_tags(trim(Shop::Get()->getSettingsService()->getSettingValue('header-phone'))));
        $this->setValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
        $this->setValue('copyright', Shop::Get()->getSettingsService()->getSettingValue('copyright'));

        // код для рекламного банера google adsence
        $this->setValue(
            'integration_google_adsence_right',
            Shop::Get()->getSettingsService()->getSettingValue('integration-google-adsence-right')
        );
    }

}