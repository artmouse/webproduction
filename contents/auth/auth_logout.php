<?php
class auth_logout extends Engine_Class {

    public function process() {
        $this->setValue('logout_good_message', Shop::Get()->getTranslateService()->getTranslateSecure('translate_logout_good_message'));
    }

}