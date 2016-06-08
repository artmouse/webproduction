<?php
class block_banner_top_index extends Engine_Class {

    public function process() {
        // список баннеров сверху
        $bannerArray = Shop::Get()->getShopService()->getBanners('index');

        $this->setValue('bannerArray', $bannerArray);
        $this->setValue('buttonArray', count($bannerArray));
        $this->setValue('bannerCount', count($bannerArray));

        $maxHeight = Shop::Get()->getSettingsService()->getSettingValue('topBannerHeightMax');
        if (!$maxHeight) {
            $maxHeight = 340;
        }
        $this->setValue('bannerHeightMax', $maxHeight);
    }

}