<?php
class block_banner_left extends Engine_Class {

    public function process() {
        $bannerArray = Shop::Get()->getShopService()->getBanners('left');
        $this->setValue('bannerLeftArray', $bannerArray);
    }

}