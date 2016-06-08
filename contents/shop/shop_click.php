<?php
class shop_click extends Engine_Class {

    public function process() {
        try {
            $bannerURL = $this->getArgument('url');

            $banner = Shop::Get()->getShopService()->getBannerByID(
            $this->getArgument('id')
            );

            Shop::Get()->getShopService()->clickBanner($banner);
            $this->setValue('url', $bannerURL);

            header('Location: '.$bannerURL);
            exit();
        } catch (Exception $e) {

        }
    }

}