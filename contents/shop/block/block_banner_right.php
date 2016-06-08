<?php
class block_banner_right extends Engine_Class {

    public function process() {
        $bannerArray = Shop::Get()->getShopService()->getBanners('right');
        $this->setValue('bannerRightArray', $bannerArray);
    }

}