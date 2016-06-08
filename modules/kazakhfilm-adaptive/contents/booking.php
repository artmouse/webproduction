<?php
class booking extends Engine_Class {

    public function process() {
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrder('sort');
        $products->setHidden(0);
        $a = array();
        $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $currency_usd = Shop::Get()->getCurrencyService()->getCurrencyByID(2);
        while ($p = $products->getNext()) {
            $characteristic = $p->getCharacteristics();
            $b = array();
            if ($characteristic) {
                $characteristic = explode('{separator}', $characteristic);
                foreach ($characteristic as $val) {
                    $val = explode(':', $val);
                    if (!empty($val[1])) {
                        $b[] = array(
                            'name' => trim($val[0]),
                            'child' => explode(';', trim($val[1])),
                        );
                    }
                }
            }

            $imagesArray = array();
            foreach ($p->getImagesArray() as $image) {
                // Если нету файла на диске, то идем дальше
                if (!file_exists(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image)) {
                    continue;
                }
                $sizeArray = @getimagesize(MEDIA_PATH.'/shop/'.$image);
                if ($sizeArray) {
                    if ($sizeArray[1] > 900) {
                        $height = 900;
                    } else {
                        $height = $sizeArray[1];
                    }
                    $originalUrl = Shop_ImageProcessor::MakeThumbProportional(
                        PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, false, $height, 'png'
                    );
                    $originalUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $originalUrl);

                    $mediumUrl = Shop_ImageProcessor::MakeThumbCrop(
                        PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, 300, 200, 'png'
                    );
                    $mediumUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $mediumUrl);

                    $cropUrl = Shop_ImageProcessor::MakeThumbCrop(
                        PackageLoader::Get()->getProjectPath().'/media/shop/'.$image, 90, 60, 'png'
                    );
                    $cropUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $cropUrl);

                    $imagesArray[] = array (
                        'originalUrl' => $originalUrl,
                        'mediumUrl' => $mediumUrl,
                        'cropUrl' => $cropUrl
                    );
                }
            }
            $this->setValue('imagesArray', $imagesArray);

            $a[] = array(
                'id' => $p->getId(),
                'name' => $p->getName(),
                'price' => $p->makePriceWithTax($currency),
                'price_usd' => $p->makePriceWithTax($currency_usd),
                'price_half' => ceil($this->_makePriceHalf($p, $currency)),
                'price_half_usd' => ceil($this->_makePriceHalf($p, $currency_usd)),
                'currency' => $currency->getName(),
                'currency_usd' => $currency_usd->getName(),
                'description' => strip_tags(trim($p->getDescription())),
                'characteristic' => $b,
                'images' => $imagesArray
            );

            $this->setValue('productsArray', $a);
        }
    }

    private function _makePriceHalf (ShopProduct $product, ShopCurrency $currency) {
        $price = $product->getPrice_half();
        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            Shop::Get()->getCurrencyService()->getCurrencyByID(
                $product->getCurrencyid()
            ),
            $currency
        );

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        }

        return $price;

    }
}