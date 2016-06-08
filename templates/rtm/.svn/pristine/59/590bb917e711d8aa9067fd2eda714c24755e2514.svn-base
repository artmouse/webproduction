<?php
/**
 * WebProduction Shop (wpshop)
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class ShopProduct extends XShopProduct {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * @return ShopProduct
     */
    public function getNext($exception = false) {
        return parent::getNext($exception);
    }

    /**
     * @return ShopProduct
     */
    public static function Get($key) {
        return self::GetObject('ShopProduct', $key);
    }

    /**
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
     * @todo actual?
     * @deprecated
     *
     * @return ShopProductPassport
     */
    public function getPassportProducts() {
        return Shop::Get()->getShopService()->getProductPassport($this);
    }

    /**
     * Получить значение определенного фильтра
     *
     * @param ShopProductFilter $filter
     * @return mixed
     */
    public function getFilterValue(ShopProductFilter $filter) {
        $a = array();
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $filterID = $this->getField('filter'.$j.'id');

            if ($filterID == $filter->getId()) {
                $a[] = $this->getField('filter'.$j.'value');
            }
        }

        // если значение одно - возвращаем его
        // @todo: а правильно ли это?
        if (count($a) == 1) {
            return $a[0];
        } else {
            return $a;
        }
    }

    /**
     * @return ShopCategory
     */
    public function getCategory() {
        return Shop::Get()->getShopService()->getCategoryByID($this->getCategoryid());
    }

    /**
     * @return string
     */
    public function getName($withInventarNumber = true) {
        if ($withInventarNumber) {
            return parent::getName().' '.parent::getInventarnumber();
        } else {
            return parent::getName();
        }

    }

    /**
     * @return string
     */
    public function makeURL($friendlyURL = true) {
        $fullurl = '';
        if ($friendlyURL) {
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }
            $categorySubdomain = $this->getCategorySubdomain();

            $fullurl = '';
            if (Engine::Get()->getProjectHost()) {
                $fullurl = $h.($categorySubdomain ? $categorySubdomain.'.' : '').Engine::Get()->getProjectHost();
            }
            $categoryUrl = '';
            try {
                $category = $this->getCategory();
                $categoryUrl = $category->getUrl();
            } catch (Exception $e) {

            }
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = '/'.$this->getUrl();
            return $fullurl.'/'.$categoryUrl.$url;
        } else {
            return $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-product',
            $this->getId()
            );
        }
    }

    public function getCategorySubdomain() {
        for($i = 10; $i > 0; $i--) {
            try {
                $id = $this->getField('category'.$i.'id');
                if (!$id) {
                    continue;
                }

                $category = Shop::Get()->getShopService()->getCategoryByID($id);
                if ($category->getSubdomain() && $category->getUrl()) {
                    return $category->getUrl();
                }
            } catch (Exception $e) {

            }
        }
    }

    /**
     * @return string
     */
    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
        'shop-admin-products-edit',
        $this->getId()
        );
    }

    /**
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
        $this->getCurrencyid()
        );
    }

    /**
     * Построить информацию о товаре
     * @param bool $watermark убираем вотермарку
     * @return array
     */
    public function makeInfoArray($hideWatermark = false,  $imageWidth = 160, $imageHeight = 140, $withCropImage = true) {

        $image = '';
        $setting = null;

        if ($hideWatermark) {
            $imageHeight = 240;
            $imageWidth = 260;
        }

        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();
        $a = array();
        $a['id'] = $this->getId();
        $a['code'] = $this->makeCode();
        $a['name'] = $this->makeName();
        $a['description'] = $this->getDescription();
        if ($this->getImagecrop() && $withCropImage) {
            $a['image'] = Shop_ImageProcessor::MakeThumbUniversal(MEDIA_PATH.'/shop/'.$this->getImage(), false, $imageHeight, 'prop', 'png', !$hideWatermark);
        } else {
            $a['image'] = $this->makeImageThumb($imageWidth, $imageHeight, 'prop', !$hideWatermark);
        }
        $a['url'] = $this->makeURL();
        $a['canbuy'] = $this->getCanBuy();
        $a['price'] = $this->makePriceWithTax($currencyDefault, true);
        $a['unit'] = $this->getUnit();
        $a['currency'] = $currencyDefault->getSymbol();
        $a['rating'] = $this->makeRating();
        $a['viewed'] = $this->getViewed();
        $a['ordered'] = $this->getOrdered();
        $a['avail'] = $this->getAvail();
        $a['availtext'] = $this->getAvailtext();
        $alt = $this->makeImageAlt($a['image'], 1);
        $a['alt'] = $alt;
        $a['title'] = $alt.'-Ремточмеханика';

        return $a;
    }


    /**
     * Можно ли покупать такой товар?
     *
     * @return bool
     */
    public function getCanBuy() {
        return ($this->getAvail()
        || Shop::Get()->getSettingsService()->getSettingValue('product-cansale-unavail')
        );
    }

    /**
     * @todo
     *
     * @return float
     */
    public function makeRating() {
        return round($this->getRating());
    }

    /**
     * Get price_product
     * @return float
     */
    public function getPrice_product() { return round($this->getField('price_product'));}

    /**
     * @param $width
     * @param $height
     * @param string $method
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop', $watermark = true) {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {
            $src = PackageLoader::Get()->getProjectPath().'templates/rtm/_images/no-image.png';
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

        return Shop_ImageProcessor::MakeThumbUniversal($src, $width, $height, $method, $format, $watermark);
    }

    /**
     * @return string
     */
    public function makeIcon() {
    return false;
          /*
        $src = MEDIA_PATH.'/shop/'.$this->getIconimage();
        if (!file_exists($src) || is_dir($src)) {
            return false;
        }
        return MEDIA_DIR.'/shop/'.$this->getIconimage();
        */
    }


    /**
     * @return ShopImage
     */
    public function getImages() {
        // @todo: services
        $images = new ShopImage();
        $images->setProductid($this->getId());
        return $images;
    }

    /**
     * Получть массив URL'ов все картинов товара
     *
     * @return array
     */
    public function getImagesArray() {
        $imagesArray = array();
        if ($this->getImage()) {
            $imagesArray[] = $this->getImage();
        } elseif ($this->getImagecrop()) {
            $imagesArray[] = $this->getImagecrop();
        }
        $additionImages = $this->getImages();
        while ($x = $additionImages->getNext()) {
            $imagesArray[] = $x->getFile();
        }

        return $imagesArray;
    }

    public function makeImageAlt($imageUrl, $imageNumber, $imagePath = false) {
        try {
            $category = $this->getCategory();
            $categoryName = $category->getName();
            $inventarNumber = $this->getInventarnumber();

            if ($imagePath) {
                list($width, $height) = @getimagesize($imagePath);
            } else {
                list($width, $height) = @getimagesize(PackageLoader::Get()->getProjectPath().$imageUrl);
            }

            return "{$categoryName}-{$inventarNumber}-{$width}x{$height}-{$imageNumber}";

        } catch (Exception $e) {

        }

    }

    /**
     * Получить массив дополнительных изображений
     *
     * @return array
     */
    public function makeImagesArray($withMainImage = false) {
        $a = array();

        // заведомо большее разрешение, чтобы фотография
        // была качественная на retina-дисплее
        $width = 400;

        if ($this->getImagecrop()) {
            try {
                $a[] =  Shop_ImageProcessor::MakeThumbUniversal(MEDIA_PATH.'/shop/'.$this->getImagecrop(), $width, false, 'prop', 'png');
            } catch (Exception $e) {

            }
        } elseif ($withMainImage && $this->getImage()) {
            try {
                $a[] = $this->makeImageThumb($width);
            } catch (Exception $e) {

            }
        }

        $images = $this->getImages();
        while ($x = $images->getNext()) {
            try {
                $a[] = $x->makeImageThumb($width, $width, 'crop');
            } catch (Exception $e) {

            }
        }
        return $a;
    }

    /**
     * Получить массив дополнительных изображений в большом размере
     *
     * @return array
     */
    public function makeBigImagesArray($withMainImage = false, $maxWidth = 1200) {
        $a = array();

        if ($withMainImage && $this->getImage()) {
            $sizeArray = @getimagesize(MEDIA_PATH.'/shop/'.$this->getImage());
            if ($sizeArray) {
                if ($sizeArray[0] > $maxWidth) {
                    $size = $maxWidth;
                } else {
                    $size = $sizeArray[0];
                }

                $a[] = $this->makeImageThumb($size);
            }
        }

        $images = $this->getImages();
        while ($x = $images->getNext()) {
            $sizeArray = @getimagesize(MEDIA_PATH.'/shop/'.$x->getFile());
            if ($sizeArray) {
                if ($sizeArray[0] > $maxWidth) {
                    $size = $maxWidth;
                } else {
                    $size = $sizeArray[0];
                }

                $a[] = $x->makeImageThumb($size);
            }
        }

        return $a;
    }

    /**
     * проверяем есть в настройках "Использовать на сайте коды 1С" == true
     * то вернем cod1c или id товара
     *
     * @return int|string
     */
    public function makeCode() {
        if (Shop::Get()->getSettingsService()->getSettingValue('use-code-1c')) {
            return $this->getCode1c();
        }
        return $this->getId();

    }

    /**
     * Получить бренд товара
     *
     * @return ShopBrand
     */
    public function getBrand() {
        return Shop::Get()->getShopService()->getBrandByID(
        $this->getBrandid()
        );
    }

    /**
     * Посчитать цену товара в указанной валюте.
     * $discount - с учетом скидки
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @param bool $discount
     * @return float
     */
    public function makePrice(ShopCurrency $currency, $discount = true) {
        $price = $this->getPrice();
        if ($discount) {
            $price *= (1 - $this->getDiscount() / 100);
        }

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
        $price,
        $this->getCurrency(),
        $currency
        );

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        }

        return $price;
    }

    public function makePriceProduct(ShopCurrency $currency, $discount = true) {
        $price = $this->getPrice_product();
        if ($discount) {
            $price *= (1 - $this->getDiscount() / 100);
        }

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $this->getCurrency(),
            $currency
        );

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        }

        return $price;
    }


    /**
     * Посчитать "Зачеркнутой цены" товара в указанной валюте.
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     * @return float
     */
    public function makePriceOld(ShopCurrency $currency) {
        $price = $this->getPriceold();

        if ( $price  ) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $price,
                $this->getCurrency(),
                $currency
            );

            $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
            if ($round) {
                $price = round($price);
            }

            return $price + 0;

        } else if ($this->getDiscount()) {

            return $this->makePriceWithTax($currency, false);

        } else {

            return 0;

        }
    }

    /**
     * @param ShopCurrency $currency
     * @return float|int
     */
    public function makePriceProductOld(ShopCurrency $currency) {

        $price = $this->getPrice_product_old();

        if ( $price  ) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $price,
                $this->getCurrency(),
                $currency
            );

            $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
            if ($round) {
                $price = round($price);
            }

            return $price + 0;

        } else if ($this->getDiscount()) {

            return $this->makePriceProduct($currency, false);

        } else {

            return 0;

        }

    }

    /**
     * Посчитать цену товара в указанной валюте с учетом НДС и скидки.
     *
     * Если в товаре указан +% НДС - то добавляем его.
     * Иначе возвращаем просто цену.
     *
     * @uses при выводе товаров в магазине, при оформлении заказа
     *
     * @param ShopCurrency $currency
     * @param bool $discount
     * @return float
     */
    public function makePriceWithTax(ShopCurrency $currency, $discount = true) {
        // получаем цену в необходимой валюте
        $price = $this->makePrice($currency, $discount);

        // если есть НДС - то добавляем его к стоимости товара
        if ($this->getTaxrate() > 0) {
            $price = $price + ($price * $this->getTaxrate() / 100);
        }

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        } else {
            $price = round($price, 2);
            //если цена имеет дробную часть
            if ($price - intval($price)) {
                //формируем отображение 2-х знаков после запятой
                $price = number_format($price, 2, '.', '');
            }
        }

        return $price;
    }

    /**
     * Проверка, подходит ли количество для товара
     *
     * @param float $count
     * @return boolean
     */
    public function testDivisibility($count) {
        // @todo: to service
        if ($this->getDivisibility() > 0) {
            if (($count / $this->getDivisibility()) != floor($count / $this->getDivisibility())) {
                return false;
            }
        }
        return true;
    }

    /**
     * Округлить количество товара с учетом дробимости
     *
     * @param float $count
     * @return float
     */
    public function getCountWithDivisibility($count) {
        // @todo: to service
        if ($this->getDivisibility() > 0) {
            $count = ceil($count / $this->getDivisibility()) * $this->getDivisibility();
        }
        return $count;
    }

    /**
     * Есть ли этот товар в корзине?
     *
     * @return bool
     */
    public function isInBasket() {
        return Shop::Get()->getShopService()->isProductInBasket($this);
    }

    /**
     * Получить тариф налогообложения (VAT tax)
     *
     * @return string
     */
    public function getTaxName() {
        // @todo: to service
        $taxrate = $this->getTaxrate();
        $tax = Shop::Get()->getShopService()->getTaxAll();
        $tax->setRate($taxrate);
        if ($tax = $tax->getNext()) {
            return $tax->getName();
        } else {
            return '';
        }
    }

    /**
     * Получить id налогообложения (VAT tax ID)
     *
     * @return int
     */
    public function getTaxid() {
        // @todo: to service
        $taxrate = $this->getTaxrate();
        $tax = Shop::Get()->getShopService()->getTaxAll();
        $tax->setRate($taxrate);
        if ($tax = $tax->getNext()) {
            return $tax->getId();
        } else {
            return 0;
        }
    }

    /**
     * Перегрузка метода, для отображения нужных цен нужным
     *
     * @return float
     */
    public function getPrice() {
        $price = parent::getPrice();

        try {
            // сначала проверка у пользователя
            $level = Shop::Get()->getUserService()->getUser()->getPricelevel();
            if ($level > 0) {
                $x = $this->getField('price'.$level);
                if ($x > 0) {
                    $price = $x;
                }
            } else {
                // проверка прав у группы
                $level = Shop::Get()->getUserService()->getUser()->getUserGroup()->getPricelevel();
                if ($level > 0) {
                    $x = $this->getField('price'.$level);
                    if ($x > 0) {
                        $price = $x;
                    }
                }
            }
        } catch (Exception $e) {

        }

        return round($price);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Создать штрих-код
     *
     * @param string $file
     * @param string $text
     */
    public function createBarcodeImage($file, $text) {
        if (!file_exists($file)) {
            $fontSize = 60;
            $text = '*'.$text.'*';

            $bbox = imagettfbbox($fontSize, 0, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            $im = imagecreate($bbox[4] - $bbox[6] + 5, $bbox[3] - $bbox[5]);
            $background_color = imagecolorallocate($im, 255, 255, 255);
            $text_color = imagecolorallocate($im, 0, 0, 0);

            imagettftext($im, $fontSize, 0, -$bbox[6], -$bbox[5], $text_color, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            imagepng($im, $file);
            imagedestroy($im);
        }
    }

    public function makeBarcodeImageInternal() {
        $file = MEDIA_PATH.'/productbarcode/product'.$this->getId().'internal.png';
        $this->createBarcodeImage($file, $this->getId());
        return MEDIA_DIR.'/productbarcode/product'.$this->getId().'internal.png?'.time();
    }

    public function makeBarcodeImageExternal() {
        $barcode = $this->getBarcode();
        if (!$barcode) {
            throw new ServiceUtils_Exception();
        }
        $file = MEDIA_PATH.'/productbarcode/product'.$this->getId().'external.png';
        $this->createBarcodeImage($file, $barcode);
        return MEDIA_DIR.'/productbarcode/product'.$this->getId().'external.png?'.time();
    }

    /**
     * @return array
     */
    public function makeAssignArrayForDocument() {
        $a = array();

        $a['productid'] = $this->getId();
        $a['name'] = mb_substr($this->getName(), 0, 12);

        try {
            $a['barcodeimageexternal'] = $this->makeBarcodeImageExternal();
        } catch (ServiceUtils_Exception $se) {

        }

        $a['barcodeimageinternal'] = $this->makeBarcodeImageInternal();
        return $a;
    }

    /**
     * Получить минимальную цену товара у поставщика
     * в валюте товара
     *
     * @return float
     *
     */
    public function getSuppliersMinPrice() {
        $min = 0;

        for ($j = 1; $j <= 5; $j++) {
            try {
                // получаем цену в системной валюте
                $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $this->getField('supplier'.$j.'price'),
                Shop::Get()->getCurrencyService()->getCurrencyByID($this->getField('supplier'.$j.'currencyid')),
                $this->getCurrency()
                ); 

                if ((!$min || $price < $min) && $price > 0) {
                    $min = $price;
                }
            } catch (ServiceUtils_Exception $se) {

            }
        }

        return $min;
    }

    /**
     * Проверить наличие поставщика у продукта по коду поставщика
     *
     * @param $supplierID
     * @return bool
     */
    public function hasSupplier( $supplierID ) {
        for ($i = 1; $i <= 5; $i++) {
            try {
                if ($this->getField('supplier'.$i.'id') == $supplierID) {
                    return true;
                }
            } catch (Exception $e) {

            }
        }
        return false;
    }

    /**
     * @return float
     */
    public function getPriceWithDiscount() {

        $price = $this->getPrice_product();
        $discount = $this->getDiscount();

        if ($price && $discount) {
            $discount = $discount / 100;
            $price = $price - $price * $discount;
        }

        return  number_format($price, 2, '.', '');
    }
}
