<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopImage extends XShopImage {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopImage
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopImage
     */
    public static function Get($key) {
        return self::GetObject('ShopImage', $key);
    }

    /**
     * *
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID(
            $this->getProductid()
        );
    }

    /**
     * *
     * @param $width
     * @param $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getFile();
        if (!file_exists($src) || is_dir($src)) {
            $src = MEDIA_PATH.'/shop/stub.jpg';
        }

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        // ширина меньше 100px смысла не имеет
        if ($width <= 100) {
            $width = 100;
        }

        // приводим размер изображений к кратности 100px (в большую сторону)
        $width = round(ceil($width / 100) * 100);

        return Shop_ImageProcessor::makeThumbUniversal($src, $width, $height, $method, $format);
    }

}