<?php
class block_facebook extends Engine_Class {

    public function process() {
        $this->setValue(
        'facebook',
        Shop::Get()->getSettingsService()->getSettingValue('facebook-widget')
        );
    }

}