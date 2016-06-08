<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopCategory extends XShopCategory {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopCategory
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopCategory
     */
    public static function Get($key) {
        return self::GetObject('ShopCategory', $key);
    }

    /**
     * @return ShopProduct
     */
    public function getProducts($showHidden = true) {
        $products = Shop::Get()->getShopService()->getProductsByCategory($this);
        if (!$showHidden) {
            $products->setHidden(0);
            $products->setDeleted(0);
        }
        return $products;
    }

    /**
     * @return ShopCategory
     */
    public function getParent() {
        return Shop::Get()->getShopService()->getCategoryByID(
        $this->getParentid()
        );
    }

    /**
     * Уровень категории в дереве
     *
     * @return int
     */
    public function getLevel() {
        return Shop::Get()->getShopService()->getCategoryLevel($this);
    }

    /**
     * @return ShopCategory
     */
    public function getChilds() {
        return Shop::Get()->getShopService()->getCategoriesByParentID(
        $this->getId()
        );
    }

    /**
     * Построить URL на страницу
     *
     * @param bool $friendlyURL
     * @param int $page
     * @return string
     */
    public function makeURL($friendlyURL = true, $page = false) {
        $fullurl = '';
        $h = '';
        if ($friendlyURL) {
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            $categorySubdomain = Shop::Get()->getShopService()->getCategorySubdomain($this);

            if (Engine::Get()->getProjectHost()) {
                $fullurl = ($categorySubdomain ? $categorySubdomain.'.' : '').Engine::Get()->getProjectHost();
            } else {
                $fullurl = '';
            }
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = $this->getUrl().'/';
            $url = '/'.str_replace('//', '/', $url);
            $url = $fullurl.$url;
            $url = rtrim($url, '/');
        } else {
            $url = $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-category',
            $this->getId()
            );
        }

        if ($page) {
            $url .= '/filter_p='.$page;
            $url = str_replace('//', '/', $url);
        }
        $url = $h.$url;
        return $url;
    }

    public function makeEditURL() {
        return $url = Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-category-control',
            $this->getId(),
            'key'
        );
    }

    /**
     * @return array
     */
    public function makeInfoArray() {
        $a = array();
        $a['id'] = $this->getId();
        $a['name'] = $this->makeName();
        $a['url'] = $this->makeURL();
        $a['image'] = $this->makeImageThumb();
        return $a;
    }

    public function makeName($escape = true) {
        if ($escape) {
            return htmlspecialchars($this->getName());
        } else {
            return $this->getName();
        }
    }

    public function makePathName($separator = ' / ') {
        $x = $this->makeName();

        try {
            $x = $this->getParent()->makeName().$separator.$x;
        } catch (Exception $e) {

        }

        return $x;
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
        //$width = round(ceil($width / 100) * 100);

        return ImageProcessor_Thumber::makeThumbUniversal($src, $width, $height, $method, PROJECT_PATH, $format);
    }

    /**
     *
     * Вернет путь к изображению если оно есть
     * не обижмая саму картинку.
     *
     * @return bool|string
     */
    public function makeImage() {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }
        return '/media/shop/'.$this->getImage();
    }

    /**
     * Возвращает true, если категория считается скрытой
     * по всей цепочке
     *
     * @return bool
     */
    public function isHidden() {
        $x = $this;
        try {
            while (1) {
                if ($x->getHidden()) {
                	return true;
                }
            	$x = $x->getParent();
            }
        } catch (Exception $e) {

        }

        return false;
    }

    public function getShowtype() {
        return parent::getShowtype() ? parent::getShowtype() : 'subcategoryonly';
    }

}