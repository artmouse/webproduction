<?php
class error404 extends Engine_Class {

    public function process() {
        $this->setValue('image', Shop::Get()->getSettingsService()->getSettingValue('image-404'));

        header('HTTP/1.0 404 Not Found');
    }

}