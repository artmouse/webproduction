<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopGallery extends XShopGallery {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * *
     * @return ShopGallery
     */
    public function getNext($exception = false) {
        $x = 1; // Sniffer fix Possible useless method overriding detected
        return parent::getNext($exception);
    }

    /**
     * *
     * @return ShopGallery
     */
    public static function Get($key) {
        return self::GetObject('ShopGallery', $key);
    }

    /**
     * *
     * @param bool $friendlyURL
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
                'shop-gallery-view',
                $this->getId()
            );
        }
        return $url;
    }

        
    /**
     * Получить имя галереи
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeImageThumb($width = 100, $height = false, $method = 'prop') {
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

        return Shop_ImageProcessor::makeThumbUniversal($src, $width, $height, $method, $format);
    }

}