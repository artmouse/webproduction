<?php
class error404_brand extends Engine_Class {

    public function process() {
        $this->setValue('image', Shop::Get()->getSettingsService()->getSettingValue('image-404'));

        $render = Engine::GetContentDriver()->getContent('brand-all');
        $this->setValue('content', $render->render());

        header('HTTP/1.0 404 Not Found');
    }

}