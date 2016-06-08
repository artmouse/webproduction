<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
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
     * Получить следующий объект
     *
     * @return ShopProduct
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить объект
     *
     * @return ShopProduct
     */
    public static function Get($key) {
        return self::GetObject('ShopProduct', $key);
    }

    /**
     * Получить id валюты
     *
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
     * Получить пасспорт продукта
     * @return string
     */
    public function getPassportProducts() {
        return Shop::Get()->getShopService()->getProductPassport($this);
    }

    /**
     * Получить значение определенного фильтра.
     * $actual и $use - дополнительная фильтрация.
     *
     * @param ShopProductFilter $filter
     * @param bool $actual
     * @param bool $use
     *
     * @return mixed
     */
    public function getFilterValue(ShopProductFilter $filter, $actual = false, $use = false) {
        $a = array();

        $filters = Shop::Get()->getShopService()->getProductFilterValues($this);
        $filters->setFilterid($filter->getId());
        while ($objFilter = $filters->getNext()) {
            if ($actual && !$objFilter->getFilteractual()) {
                continue;
            }

            if ($use && !$objFilter->getFilteruse()) {
                continue;
            }

            $a[] = $objFilter->getFiltervalue();
        }

        // если значение одно - возвращаем его
        if (count($a) == 1) {
            return $a[0];
        } elseif (count($a) == 0) {
            return false;
        } else {
            return $a;
        }
    }

    public function getField($field, $events = true, $oldFilterFIeld = false) {
        if (!$oldFilterFIeld && preg_match('/^filter([\d]+)([\w]+)/uis', $field, $r)) {
            $result = false;

            if (!$r[1]) {
                return $result;
            }

            $filter = new XShopProductFilterValue();
            $filter->setProductid($this->getId());
            $filter->setLimit($r[1]-1, 1);
            $filter->setOrder('id');
            $filter = $filter->getNext();
            if ($filter) {
                $result = $filter->getField('filter'.$r[2]);
            }

            return $result;
        } else {
            return parent::getField($field, $events);
        }

    }

    public function setField($field, $value, $update = false) {
        if (preg_match('/^filter([\d]+)([\w]+)/uis', $field, $r)) {
            if (PackageLoader::Get()->getMode('debug')) {
                print_r(debug_backtrace());
            }
            throw new Exception('set field filter');
        } else {
            parent::setField($field, $value, $update);
        }

    }

    /**
     * Задать параметр фильтра.
     * Внимание! Метод не вызывает update()
     *
     * @param ShopProductFilter $filter
     * @param string $value
     * @param bool $actual
     * @param bool $use
     * @param bool $markup
     * @param bool $option
     */
    public function setFilterValue(ShopProductFilter $filter, $value, $actual = false, $use = false, $markup = false,
                $option = false) {

        $value = trim($value);

        $ok = false;

        $filters = Shop::Get()->getShopService()->getProductFilterValues($this);
        $filters->setFilterid($filter->getId());
        while ($objFilter = $filters->getNext()) {
            $objFilter->setFiltervalue($value);

            if ($actual !== false) {
                $objFilter->setFilteractual($actual);
            }
            if ($use !== false) {
                $objFilter->setFilteruse($use);
            }
            if ($markup !== false) {
                $objFilter->setFiltermarkup($markup);
            }
            if ($option !== false) {
                $objFilter->setFilteroption($option);
            }
            $objFilter->update();

            $ok = true;
        }

        if ($ok) {
            return;
        }

        // фильтр не найден
        Shop::Get()->getShopService()->addProductFilterValue(
            $this,
            $filter->getId(),
            $value,
            $use,
            $actual,
            $option,
            $markup
        );

        return;
    }

    /**
     * Получить категорию товара.
     * Можно указать какую по вложенности.
     *
     * @param int $index
     *
     * @return ShopCategory
     */
    public function getCategory($index = false) {
        $id = $this->getCategoryid();

        if ($index > 0) {
            $id = $this->getField('category'.$index.'id');
        }

        return Shop::Get()->getShopService()->getCategoryByID(
            $id
        );
    }

    /**
     * Получить ссылку на карточку товара
     *
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
            if (Engine::Get()->getProjectHost()) {
                $fullurl = $h.($categorySubdomain ? $categorySubdomain.'.' : '').Engine::Get()->getProjectHost();
            }
        }
        if ($friendlyURL && $this->getUrl()) {
            $url = '/'.$this->getUrl();
            $url = $fullurl.$url;
            if (substr($url, -1) != '/' ) {
                $url.= '/';
            }
            return $url;
        } else {
            $url = $fullurl.Engine::GetLinkMaker()->makeURLByContentIDParam('shop-product', $this->getId());
            
            if (substr($url, -1) != '/' ) {
                $url.= '/';
            }
            return $url;
        }
    }

    public function getCategorySubdomain() {
        try {
            return Shop::Get()->getShopService()->getCategorySubdomain($this->getCategory());
        } catch (Exception $e) {

        }
    }

    /**
     * Получить ссылку на страницу редактирования
     *
     * @return string
     */
    public function makeURLEdit() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-products-edit',
            $this->getId()
        );
    }

    /**
     * Получить ссылку на страницу Barcode
     *
     * @return string
     */
    public function makeURLBarcode() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-product-barcode',
            $this->getId()
        );
    }

    /**
     * Получить ссылку на страницу Pricecode
     *
     * @return string
     */
    public function makeURLPricecode() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-product-pricecode',
            $this->getId()
        );
    }

    /**
     * Получить ссылку на страницу удаления
     *
     * @return string
     */
    public function makeURLDelete() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-products-delete',
            $this->getId()
        );
    }

    /**
     * Получить валюту товара
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        return Shop::Get()->getCurrencyService()->getCurrencyByID(
            $this->getCurrencyid()
        );
    }

    /**
     * Построить информацию о товаре
     *
     * @return array
     */
    public function makeInfoArray() {
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

        $a = array();
        $a['id'] = $this->getId();
        $a['code'] = $this->makeCode();
        $a['name'] = $this->makeName();
        $a['nameQuick'] = str_replace("'", "\'", $this->makeName());
        $a['description'] = $this->getDescription();
        // #60817 если есть кроп, то берем кроп изображение, а не основное
        // необходимо указывать ширину дабы ImageProcessor смог расчитать положение wotemark
        if ($this->getImagecrop()) {
            $a['image'] = Shop_ImageProcessor::MakeThumbUniversal(
                MEDIA_PATH.'/shop/'.$this->getImagecrop(),
                330,
                225,
                'prop'
            );
        } else {
            $a['image'] = $this->makeImageThumb(330, 330, 'prop');
        }
        $a['url'] = $this->makeURL();
        $a['canbuy'] = $this->getCanBuy();
        $a['price'] = $this->makePrice($currencyDefault, true);
        $a['unit'] = $this->getUnit();
        $a['currency'] = $currencyDefault->getSymbol();
        $a['rating'] = $this->makeRating();
        $a['ordered'] = $this->getOrdered();
        $a['avail'] = $this->getAvail();
        $a['availtext'] = $this->getAvailtext();
        $a['model'] = $this->getModel();
        $a['seriesname'] = $this->getSeriesname();
        $a['priceold'] = $this->makePriceOld($currencyDefault);
        return $a;
    }

    /**
     * Построить строку характеристик продукта.
     *
     * @return string
     */
    public function makeCharacteristicsString() {
        $characteristicsArray = array();

        $filters = Shop::Get()->getShopService()->getProductFilterValues($this);
        while ($objFilter = $filters->getNext()) {
            try {
                if ($objFilter->getFilteractual() && $objFilter->getFiltervalue()) {
                    $filterID = $objFilter->getFilterid();
                    $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                    if ($filter->getHidden()) {
                        continue;
                    }

                    $characteristicsArray[] = str_replace(
                        '::',
                        ':',
                        $filter->getName().': '.$objFilter->getFiltervalue()
                    );
                }
            } catch (Exception $e) {

            }
        }

        return strip_tags(implode(', ', $characteristicsArray));
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
     * Получить рейтинг
     *
     * @todo
     *
     * @return float
     */
    public function makeRating() {
        return round($this->getRating());
    }

    /**
     * Получить изображение
     *
     * @param $width
     * @param $height
     * @param string $method
     *
     * @return string
     */
    public function makeImageThumb($width, $height = false, $method = 'prop') {
        $src = MEDIA_PATH.'/shop/'.$this->getImagecrop();

        if (!file_exists($src) || is_dir($src)) {
            $src = MEDIA_PATH.'/shop/'.$this->getImage();
        }
        if (!file_exists($src) || is_dir($src)) {
            $src = MEDIA_PATH.'/shop/stub.jpg';
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

        return Shop_ImageProcessor::MakeThumbUniversal($src, $width, $height, $method, $format);
    }

    /**
     * Получить иконку
     *
     * @return ShopProductIcon
     */
    public function getIcon() {
        return Shop::Get()->getShopService()->getProductIconByID(
            $this->getIconid()
        );
    }

    /**
     * Получить изображение иконки
     *
     * @return string
     */
    public function makeIcon() {
        try {
            $iconObject = $this->getIcon();

            return $iconObject->makeImage();
        } catch (Exception $e) {

        }
    }

    /**
     * Получить все дополнительные картинки
     *
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
                $a[] =  Shop_ImageProcessor::MakeThumbUniversal(
                    MEDIA_PATH.'/shop/'.$this->getImagecrop(),
                    $width,
                    false,
                    'prop',
                    'png'
                );
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
     * проверяем есть в настройках "Использовать на сайте aртикулы" == true
     * то вернем aртиекули id товара
     *
     * @return int|string
     */
    public function makeArticul() {
        if (Shop::Get()->getSettingsService()->getSettingValue('use-articul')) {
            return $this->getArticul();
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
     *
     * @return float
     */
    public function makePrice(ShopCurrency $currency, $discount = true) {
        $price = $this->getPrice();
        if ($discount && !$this->getNotdiscount()) {
            if ($this->getMaxdiscount() > 0 && ($this->getDiscount() > $this->getMaxdiscount())) {
                $price *= (1 - $this->getMaxdiscount() / 100);
            } else {
                $price *= (1 - $this->getDiscount() / 100);
            }
            
        }

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $this->getCurrency(),
            $currency
        );

        $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
        if ($round) {
            $price = round($price);
        } else {
            $price = round($price, 2);

            // если цена имеет дробную часть
            if ($price - intval($price)) {
                // формируем отображение 2-х знаков после запятой
                $price = number_format($price, 2, '.', '');
            }
        }

        return $price;
    }


    /**
     * Посчитать "Зачеркнутой цены" товара в указанной валюте.
     *
     * Метод править разрешено только Senior'ам!
     *
     * @param ShopCurrency $currency
     *
     * @return float
     */
    public function makePriceOld(ShopCurrency $currency) {
        $price = $this->getPriceold();

        if ( !$this->getDiscount() ) {
            $price = Shop::Get()->getCurrencyService()->convertCurrency(
                $price,
                $this->getCurrency(),
                $currency
            );

            $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
            if ($round) {
                $price = round($price);
            }

            $procent = (int) Shop::Get()->getSettingsService()->getSettingValue('show-old-price-persent-limit');
            $newprice = Shop::Get()->getCurrencyService()->convertCurrency(
                $this->getPrice(),
                $this->getCurrency(),
                $currency
            );

            if ($procent > 0) {
                $tempNum = $price/100 * $procent;
                $priceWhithPersent = $price - $tempNum;
                round($priceWhithPersent);
                if ($priceWhithPersent > $newprice ) {
                    return $price + 0;
                } else {
                    return false;
                }
            }

            return $price + 0;

        } else {

            return $this->makePrice($currency, false);

        }
    }

    /**
     * Получить цену товара с таксой
     *
     * @param ShopCurrency $currency
     * @param bool $discount
     *
     * @return float
     *
     * @deprecated
     *
     * @see makePrice()
     */

    public function makePriceWithTax(ShopCurrency $currency, $discount = true) {
        return $this->makePrice($currency, $discount);
    }

    /**
     * Проверка, подходит ли количество для товара
     *
     * @param float $count
     *
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
     *
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

        return $price;
    }

    public function makeName($escape = true) {
        if ($escape) {
            return htmlspecialchars($this->getName());
        } else {
            return $this->getName();
        }
    }

    public function getViewed() {
        $x = new XShopProductView();
        $x->setProductid($this->getId());
        return $x->getCount();
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
     * Получить масссив значений для документа
     *
     * @return array
     */
    public function makeAssignArrayForDocument() {
        return Shop::Get()->getShopService()->makeProductAssignArrayForDocument($this);
    }

    /**
     * Получить код поставщика $supplier
     *
     * @param ShopSupplier $supplier
     *
     * @return string
     */
    public function getSupplierCode(ShopSupplier $supplier) {
        
        $tmp = new ShopProductSupplier();
        $tmp->filterSupplierid($supplier->getId());
        $tmp->filterProductid($this->getId());
        if ($tmp->select()) {
            return $tmp->getCode();
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Проверить наличие поставщика у продукта по коду поставщика
     *
     * @param $supplierID
     *
     * @return bool
     */
    public function hasSupplier($supplierID) {
        
        $tmp = new ShopProductSupplier();
        $tmp->filterSupplierid($supplierID);
        $tmp->filterProductid($this->getId());
        if ($tmp->select()) {
            return true;
        }
        return false;
    }

    /**
     * Получить цену со скидкой
     *
     * @return float
     */
    public function getPriceWithDiscount() {

        $price = $this->getPrice();
        $discount = $this->getDiscount();

        if ($price && $discount) {
            $discount = $discount / 100;
            $price = $price - $price * $discount;
        }

        return  number_format($price, 2, '.', '');
    }

    public function update($massUpdate = false, $noChange = false) {
        if (!$massUpdate) {
            if (!$noChange) {
                try {
                    Shop::Get()->getShopService()->addProductChange($this);
                } catch (Exception $historyEx) {

                }
            }

            $this->setUdate(date('Y-m-d H:i:s'));
        }

        $updateFVCCategory = false;
        $updateFVCBrand = false;
        $updateFVC = false;
        $updateTag = false;
        $updateProductLive = false;
        $updateSupplier = false;
        $updatePriceSell = false;
        $a = $this->getValueUpdateArray();
        foreach ($a as $key => $value) {
            if (substr_count($key, 'brand') || substr_count($key, 'category')) {
                $updateFVCBrand = true;
            }
            if (substr_count($key, 'category')) {
                $updateFVCCategory = true;
            }
            if ($key == 'tags') {
                $updateTag = true;
            }
            if (substr_count($key, 'supplier') && $key != 'supplierid') {
                $updateSupplier = true;
            }
            if (substr_count($key, 'discount') || substr_count($key, 'price') || substr_count($key, 'currencyid')) {
                $updatePriceSell = true;
            }

            if (substr_count($key, 'datelifeto') || substr_count($key, 'datelifefrom')) {
                $updateProductLive = true;
            }
        }

        $result = parent::update($massUpdate);

        // обновление данных FVC
        if (!$massUpdate && $updateFVCBrand) {
            Shop::Get()->getShopService()->updateProductFVCBrand($this);
        }

        if (!$massUpdate && $updateFVCCategory) {
            Shop::Get()->getShopService()->updateProductFVCCategory($this);
        }

        /*if (!$massUpdate && $updateFVC) {
            Shop::Get()->getShopService()->updateProductFVC($this);
        }*/

        // обновление тегов
        if (!$massUpdate && $updateTag) {
            Shop::Get()->getShopService()->updateProductTags($this);
        }

        // обновление цены в валюте магазина
        if (!$massUpdate && $updatePriceSell) {
            try{
                $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

                $xproduct = new XShopProduct($this->getId());
                $xproduct->setPricesell(
                    $this->makePrice($currencyDefault, true)
                );
                $xproduct->update();
            } catch (Exception $ee) {

            }
        }
        // время жизни товаров
        if (!$massUpdate && $updateProductLive) {
            ProcessorQueService::Get()->addProcessor('Shop_Processor_UpdateProductLive');
        }

        return $result;
    }

    /**
     * Проверить, является ли продукт скрытый каким-либо образом
     *
     * @return bool
     */
    public function isHidden() {
        if ($this->getHidden()) {
            return true;
        }

        if ($this->getDeleted()) {
            return true;
        }

        try {
            if ($this->getCategory()->isHidden()) {
                return true;
            }
        } catch (Exception $e) {
            return true;
        }

        // скрыты ли родительские категории?
        for ($i=1; $i<=10; $i++) {
            try{
                $categoryId = $this->getField('category'.$i);

                if (!$categoryId || $categoryId == $this->getCategoryid()) {
                    break;
                }

                $category = Shop::Get()->getShopService()->getCategoryByID($this->getField('category'.$i));
                if ($category->isHidden()) {
                    return true;
                }

            } catch (Exception $ec) {
                return true;
            }

        }

        return false;
    }

    public function insert() {
        $this->setCdate(date('Y-m-d H:i:s'));
        $result = parent::insert();

        // FCV для insert пока не нужно
        /*// обновление данных FVC
        Shop::Get()->getShopService()->updateProductFVC($this);*/

        return $result;
    }

    /**
     * Получить причину совпадения.
     * Метод используется при загрузке прайс-листа.
     *
     * @return string
     */
    public function getMatchReason() {
        return $this->_matchReason;
    }

    /**
     * Задать причину совпадения.
     * Метод используется при загрузке прайс-листа.
     *
     * @param string $reason
     */
    public function setMatchReason($reason) {
        $this->_matchReason = $reason;
    }

    private $_matchReason = false;

}