<?php
class error4xx extends Engine_Class {

    public function process() {
        $this->setValue('branding', Engine::Get()->getConfigFieldSecure('project-branding'));
        try {
            $logo = Shop::Get()->getShopService()->getLogoCurrent();
            $this->setValue('logo', $logo->makeImage());
            
        }  catch (Exception $e) {
            
        }
    }

}