<?php
class block_banner_bottom extends Engine_Class {

    public function process() {
        $bannerArray = Shop::Get()->getShopService()->getBanners('allpagesbottom');
        $this->setValue('bannerBottomArray', $bannerArray);
    }

}