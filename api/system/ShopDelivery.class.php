<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopDelivery extends XShopDelivery {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Method getNext
     * @return ShopDelivery
     */
    public function getNext($exception = false) {
        $i = false;
        return parent::getNext($exception);
    }

    /**
     * Method Get
     * @return ShopDelivery
     */
    public static function Get($key) {
        return self::GetObject('ShopDelivery', $key);
    }

    /**
     * Method getCurrencyid
     * @return int
     */
    public function getCurrencyid() {
        $currencyID = parent::getCurrencyid();
        if (!$currencyID) {
            return Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
        }
        return $currencyID;
    }

    /**
     * Получить валюту доставки
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID($this->getCurrencyid());
    }

    /**
     * Посчитать цену доставки в указанной валюте
     *
     * @param ShopCurrency $currency
     * 
     * @return float
     */
    public function makePrice(ShopCurrency $currency) {
        return Shop::Get()->getCurrencyService()->convertCurrency(
            $this->getPrice(),
            $this->getCurrency(),
            $currency
        );
    }

    /**
     * Method makeImageThumb
     * 
     * @param $width
     * @param $height
     * @param string $method
     * 
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop') {        
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
     * Method makeName
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function update($massUpdate = false) {
        $result =  parent::update($massUpdate);

        if ($this->getDefault()) {
            $delivery = Shop::Get()->getDeliveryService()->getDeliveryAll();
            $delivery->addWhere('id', $this->getId(), '<>');
            $delivery->setDefault(1);
            while ($d = $delivery->getNext()) {
                $d->setDefault(0);
                $d->update();
            }
        }

        return $result;
    }

}