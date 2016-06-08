<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopBrand extends XShopBrand {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopBrand
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopBrand
     */
    public static function Get($key) {
        return self::GetObject('ShopBrand', $key);
    }

    /**
     * Получить все товары бренда
     *
     * @return ShopProduct
     */
    public function getProducts() {
        return Shop::Get()->getShopService()->getProductsByBrand($this);
    }

    /**
     * @param bool $friendlyURL
     * @param int $page
     * @return string
     */
    public function makeURL($friendlyURL = true, $page = false) {
        $fullurl = '';
        if ($friendlyURL) {
            $fullurl = Engine::Get()->getProjectURL();
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = $this->getUrl().'/';
            $url = $fullurl.'/'.str_replace('//', '/', $url);
        } else {
            $url = $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-brand',
            $this->getId()
            );
        }
        if ($page) {
            $url .= 'p-'.$page.'/';
        }
        return $url;
    }

    /**
     * Получить имя бренда
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * @return array
     */
    public function makeInfoArray($imageWidth = 100, $imageHeight = false) {
        $a = array();
        $a['id'] = $this->getId();
        $a['name'] = $this->makeName();
        $a['image'] = $this->makeImageThumb($imageWidth, $imageHeight);
        $a['url'] = $this->makeURL();
        $a['country'] = $this->getCountry();
        $a['productCount'] = $this->getProductcount();
        $a['description'] = $this->getDescription();
        return $a;
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

        // ширина меньше 30px смысла не имеет
        if ($width <= 30) {
            $width = 30;
        }

        // приводим размер изображений к кратности 100px (в большую сторону)
        //$width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }
}