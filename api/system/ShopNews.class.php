<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * *
 * @copyright WebProduction
 * @package Shop
 */
class ShopNews extends XShopNews {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopNews
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopNews
     */
    public static function Get($key) {
        return self::GetObject('ShopGuestBook', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeImageThumb($width = 200, $height = false, $method = 'prop') {
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

        // приводим размер изображений к кратности 100px (в большую сторону)
        $width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

    /**
     * *
     * 
     * @param bool $friendlyURL
     * 
     * @return string
     */
    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            $fullurl = Engine::Get()->getProjectURL();
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = $this->getUrl().'/';
            $url = $fullurl.'/'.str_replace('//', '/', $url);
        } else {
            $url = $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-news-view',
                $this->getId()
            );
        }
        return $url;
    }

}