<?php

class block_banner_pageinterval extends Engine_Class {

    public function process() {
        // popup-pageinterval
        $arr = @$_COOKIE['popup-pageinterval'];
        try {
            $banners = Shop::Get()->getShopService()->getBannerAll();
            $banners->setHidden(0);
            $banners->setPlace('page-interval');
            $banners->setOrder('sort', 'DESC');
            $banners = $banners->getNext();
            if ($banners) {
                $this->setValue('pages', $banners->getPageinterval());
                $interval = explode(",", $banners->getPageinterval());
                $user = Shop::Get()->getUserService()->getUserSecure();
                if (in_array($arr, $interval) && !$user) {
                    $this->setValue('urlBannerLoginImg', $banners->makeImage());
                    $this->setValue('urlBannerLogin', $banners->getUrl());
                    $this->setValue('pageIntervalName', $banners->getName());
                    $this->setValue('pageIntervalBannerId', $banners->getId());
                    $this->setValue('commentPageIntervalBanner', str_replace("\n", "<br />", $banners->getComment()));
                }
            }
        } catch (Exception $e) {
            
        }
    }

}