<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductIcon extends XShopProductIcon {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductIcon
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProductIcon
     */
    public static function Get($key) {
        return self::GetObject('ShopProductIcon', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * @param $width
     * @param $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            $src = false;
        }
        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH);
    }

    /**
     * @return string
     */
    public function makeImage() {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();

        if (file_exists($src) || is_dir($src)) {
            return MEDIA_DIR.'/shop/'.$this->getImage();
        }

        return false;
    }

}