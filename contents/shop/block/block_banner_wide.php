<?php
class block_banner_wide extends Engine_Class {

    public function process() {
        // список баннеров сверху
        $bannerArray = Shop::Get()->getShopService()->getBanners('wide');
        $this->setValue('bannerArray', $bannerArray);

    }

}