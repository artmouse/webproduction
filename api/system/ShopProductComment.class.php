<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class ShopProductComment extends XShopProductComment {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductComment
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProductComment
     */
    public static function Get($key) {
        return self::GetObject('ShopProductComment', $key);
    }

    /**
     * @return ShopProduct
     */
    public function getProduct() {
        return Shop::Get()->getShopService()->getProductByID(
        $this->getProductid()
        );
    }

    /**
     * @return User
     */
    public function getUser() {
        return Shop::Get()->getUserService()->getUserByID(
        $this->getUserid()
        );
    }

    public function makeImage () {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }
        $src = '/media/shop/'.$this->getImage();
        return $src;
    }

    public function makeImageThumb($width = 320, $height = 240, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
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

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

}