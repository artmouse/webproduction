<?php
class shop_basket_success extends Engine_Class {

    public function process() {
        $ids = explode(',', $this->getArgumentSecure('ids'));
        $productsArray = false;

        foreach ($ids as $productId) {
            try{
                $product = Shop::Get()->getShopService()->getProductByID($productId);
                $productsArray[] = array(
                    'name' => $product->makeName(),
                    'image' => '/media/shop/'. ($product->getImage() ? $product->getImage():'stub.jpg'),
                    'url' => $product->makeURL()
                );
            } catch (Exception $e) {

            }
        }

        $this->setValue('productsArray', $productsArray);

        // если есть интеграция с отслеживанием конверсий google
        $this->setValue(
            'integration_google_conversion',
            Shop::Get()->getSettingsService()->getSettingValue('integration-google-conversion')
        );
        
        // баннер
        $banners = Shop::Get()->getShopService()->getBannerAll();
        $banners->setHidden(0);
        $banners->setPlace('success');
        $banners->setOrder('sort', 'DESC');
        $banners = $banners->getNext();
        if ($banners) {
            $this->setValue('bannerSuccess', $banners->makeImage());
            $this->setValue('bannerSuccessUrl', $banners->getUrl());
        }

        try {
            $this->setValue('goodmessage', Shop::Get()->getSettingsService()->getSettingValue('order-good-message'));
        } catch(Exception $gme) {

        }

    }

}