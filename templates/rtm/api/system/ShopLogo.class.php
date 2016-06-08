<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class ShopLogo extends XShopLogo {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopLogo
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopLogo
     */
    public static function Get($key) {
        return self::GetObject('ShopLogo', $key);
    }

    public function makeImage() {
        $src = MEDIA_DIR.'/shop/'.$this->getFile();
        return $src;
    }

    /**
     * Получить уменьшенное изображение
     *
     * @param int $width
     * @param int $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width = 200, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getFile();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'png';
        }

        // ширина меньше 100px смысла не имеет
        if ($width <= 100) {
            $width = 100;
        }

        // приводим размер изображений к кратности 100px (в большую сторону)
        // $width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

}