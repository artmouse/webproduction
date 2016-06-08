<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProductList extends XShopProductList {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProductList
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProduct
     */
    public function getProducts() {
        return Shop::Get()->getShopService()->getProductsInList($this);
    }

    /**
     * @return string
     */
    public function makeName() {
        if ($this->getNameshort()) {
            return htmlspecialchars($this->getNameshort());
        }
        return htmlspecialchars($this->getName());
    }

    /**
     *
     * Делаем тюмб для изображения набора
     *
     * @param int $width
     * @param bool $height
     * @param string $method
     * @return bool|string
     */
    public function makeImageThumb($width = 100, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getSetimage();
        if (!file_exists($src) || is_dir($src)) {
            throw new Exception('no image file');
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

    /**
     * Отрисовать список в HTML
     *
     * @uses Engine
     * @return string
     */
    public function render(ShopProduct $products = null) {
        // получаем товары списка
        if ($products == null) {
            $products = $this->getProducts();
            $products->setAvail(1);
        }

        $showtype = $this->getShowtype();
        if (!$showtype) {
            $showtype = 'carousel';
        }

        if ($showtype == 'carousel') {
            // показываем список каруселью
            $render = Engine::GetContentDriver()->getContent('shop-product-carousel');
            $render->setValue('products', $products);
            $render->setValue('autoplay', $this->getAutoplay());
            $html = $render->render();
        } else {
            // показываем через shop-product-list
            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $render->setValue('nofilters', true);
            $render->setValue('nostepper', true);
            // набор в отдельном контенте выводим table
            if ($showtype == 'set') {
                $showtype = 'table';
            }
            $render->setValue('showtype', $showtype);
            $html = $render->render();
        }

        return $html;
    }

}