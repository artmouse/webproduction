<?php
class RtmService extends ServiceUtils_AbstractService {


    /**
     * Построить URL-фильтра исходя из значения
     *
     * @param $value
     * @param $filterId
     *
     * @return mixed|string
     * @throws ServiceUtils_Exception
     */
    public function buildFilterURL($value, $filterId) {
        try {
            $x = new XFilterValue2Url();
            $x->setValue($value);
            if ($x->select()) {
                return $x->getUrl();
            }
        } catch (Exception $e) {

        }
        if ($text = $this->_colorToEn($value)) {
            $xxx = 1;
        } else {
            $text = $value;
            $text = trim($text);
            $text = StringUtils_Transliterate::TransliterateRuToEn($text);

            $text = preg_replace("/[^a-z0-9-_\s]/ius", '', $text);
            $text = preg_replace("/\s+/ius", '-', $text);
            $text = str_replace('_', '-', $text);
            $text = str_replace('--', '-', $text);
            $text = strtolower($text);
        }

        if (!$text) {
            throw new ServiceUtils_Exception();
        }

        try {
            $x = new XFilterValue2Url();
            $x->setUrl($text);
            if (!$x->select()) {
                $x->setValue($value);
                $x->setFilterid($filterId);
                $x->insert();
            } else {
                $x->setValue($value);
                $x->setFilterid($filterId);
                $x->update();
            }
        } catch (Exception $e) {

        }
        return $text;
    }

    /**
     * ShopProduct
     *
     * @param ShopProduct $product
     * @param $currency
     *
     * @return array
     */
    public function getProductPricesArray(ShopProduct $product, $currency) {
        $priceOld = $product->makePriceOld($currency);
        $priceProductOld = $product->makePriceProductOld($currency);
        $price = false;
        $priceProduct = false;
        if (!$priceOld) {
            $priceOld = $product->makePriceWithTax($currency, false);
            $price = RtmService::Get()->makeDiscount($product->getPrice(), $currency);
            if (!$price) {
                $priceOld = 0;
            }
        }
        if (!$price) {
            $price = $product->makePriceWithTax($currency, true);
        }

        if (!$priceProductOld) {
            $priceProductOld = $product->makePriceProduct($currency, false);
            $priceProduct = RtmService::Get()->makeDiscount($product->getPrice_product(), $currency);
            if (!$priceProduct) {
                $priceProductOld = 0;
            }
        }

        if (!$priceProduct) {
            $priceProduct = $product->makePriceProduct($currency, true);
        }

        return array(
            'price' => round($price),
            'priceOld' => round($priceOld),
            'productPrice' => round($priceProduct),
            'productPriceOld' => round($priceProductOld)
        );
    }

    /**
     * ShopDiscount
     *
     * @param $price
     * @param $currency
     *
     * @return bool|ShopDiscount
     */
    public function getMaxDiscount($price, $currency) {
        // автоопределение скидки
        $value = 0;
        $discount = false;
        $discounts = Shop::Get()->getShopService()->getDiscountAll();
        while ($x = $discounts->getNext()) {
            // если скидка может применятся автоматически
            if ($x->getMinstartsum() > 0) {
                // конвертируем сумму заказа в валюту скидки
                $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                    $price,
                    $currency,
                    $x->getCurrency()
                );

                if ($x->getMinstartsum() <= $sumDiscount) {
                    // ищем максимально возможную скидку
                    $x_value = $x->makeDiscountValue($price, $currency);
                    if ($x_value > $value) {
                        $value = $x_value;
                        $discount = clone $x;
                    }
                }
            }
        }

        return $discount;
    }


    /**
     * Discount
     *
     * @param ShopProduct $product
     * @param $currency
     *
     * @return float
     */
    public function makeDiscount($price, $currency) {
        try {

            $discount = $this->getMaxDiscount($price, $currency);

            if ($discount) {
                return $discount->applyDiscount($price, $currency);
            } else {
                return 0;
            }

        } catch (Exception $e) {

        }
    }


    /**
     * Скрываем и удаляем $product, открываем похожий товар
     * Метод применяется после покупки товара
     *
     * @param ShopProduct $product
     */
    public function clearSimilarProduct(ShopProduct $product) {
        try {

            if ($product->getShowincategory()) {
                $currentProductSize = $product->getSize();
                // Если есть размер у товара
                if ($currentProductSize) {

                    $optionProducts = new ShopProduct();
                    $optionProducts->setCode1c($product->getCode1c());
                    $optionProducts->setSubarticul($product->getSubarticul());
                    $optionProducts->setSize($product->getSize());
                    $optionProducts->addWhere('id', $product->getId(), '<>');
                    $optionProducts->setOrder('weight', 'ASC');
                    $optionProducts->setLimitCount(1);
                    $optionProducts->setHidden(1);
                    $optionProducts->setDeleted(0);

                } else {

                    $optionProducts = new ShopProduct();
                    $optionProducts->setCode1c($product->getCode1c());
                    $optionProducts->addWhere('id', $product->getId(), '<>');
                    $optionProducts->setSubarticul($product->getSubarticul());
                    $optionProducts->setOrder('weight', 'ASC');
                    $optionProducts->setLimitCount(1);
                    $optionProducts->setHidden(1);
                    $optionProducts->setDeleted(0);

                }

                if ($x = $optionProducts->getNext()) {
                    if (is_object($x)) {
                        $x->setHidden(0);
                        $x->setShowincategory(1);
                        $x->update();
                    }
                }
            }

            $product->setHidden(1);
            $product->setDeleted(1);
            $product->update();

        } catch (Exception $e) {

        }
    }

    /**
     * Открываем $product и скрываем похожий товар с большим весом
     *
     * @param ShopProduct $product
     */
    public function addSimilarProduct(ShopProduct $product) {
        try {

            if ($product->getShowincategory()) {
                $currentProductSize = $product->getSize();
                // Если есть размер у товара
                if ($currentProductSize) {

                    $optionProducts = new ShopProduct();
                    $optionProducts->setCode1c($product->getCode1c());
                    $optionProducts->setSubarticul($product->getSubarticul());
                    $optionProducts->setSize($product->getSize());
                    $optionProducts->addWhere('id', $product->getId(), '<>');
                    $optionProducts->setOrder('weight', 'ASC');
                    $optionProducts->setLimitCount(1);
                    $optionProducts->setHidden(0);
                    $optionProducts->setDeleted(0);

                } else {

                    $optionProducts = new ShopProduct();
                    $optionProducts->setCode1c($product->getCode1c());
                    $optionProducts->addWhere('id', $product->getId(), '<>');
                    $optionProducts->setSubarticul($product->getSubarticul());
                    $optionProducts->setOrder('weight', 'ASC');
                    $optionProducts->setLimitCount(1);
                    $optionProducts->setHidden(0);
                    $optionProducts->setDeleted(0);

                }

                if ($x = $optionProducts->getNext()) {
                    if (is_object($x)) {
                        $x->setHidden(1);
                        $x->setShowincategory(0);
                        $x->update();
                    }
                }
            }

            $product->setHidden(0);
            $product->setDeleted(0);
            $product->update();

        } catch (Exception $e) {

        }
    }

    /**
     * Получить размеры категории по умолчанию
     *
     * @param $categoryId
     *
     * @return array
     */
    public function getCategorySizesById($categoryId) {
        $categoryId = (int) $categoryId;
        $a = array();
        try {
            $x = new XCategorySizes();
            $x->setCategoryid($categoryId);
            if ($x->select()) {
                $a = explode(',', $x->getSizes());
            }
        } catch (Exception $e) {

        }
        return $a;
    }

    /**
     * Добавить изображение товару
     *
     * @param ShopProduct $product
     * @param string $image
     *
     * @return ShopImage
     */
    public function addProductImage(ShopProduct $product, $image, $imageNumber) {
        try {
            SQLObject::TransactionStart();

            if (!Checker::CheckImageFormat($image)) {
                throw new ServiceUtils_Exception('Invalid image format');
            }

            // конвертация изображения в необходимый формат
            // и допустимый размер
            $image = Shop::Get()->getShopService()->convertImage($image);

            $file = $this->makeImagesUploadUrl($image, '', 'shop/', $product, $imageNumber);
            copy($image, PackageLoader::Get()->getProjectPath() . 'media/shop/' . $file);

            $x = new ShopImage();
            $x->setProductid($product->getId());
            $x->setFile($file);
            if (!$x->select()) {
                try {
                    $user = Shop::Get()->getUserService()->getUser();

                    CommentsAPI::Get()->addComment(
                        'shop-history-product-' . $product->getId(),
                        Shop_TranslateFormService::Get()->getTranslate('translate_product') . ' #' . $product->getId() .
                        '. ' . Shop_TranslateFormService::Get()->getTranslate('translate_added_additional_image') .
                        $x->getId() . ' ' . $file,
                        $user->getId()
                    );
                } catch (Exception $e) {

                }

                $x->insert();
            }

            SQLObject::TransactionCommit();

            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * ImagesUploadUrl
     *
     * @param $image
     * @param $namePrefix
     * @param string $folder
     * @param bool $product
     * @param int $imageNumber
     *
     * @return string
     */

    public function makeImagesUploadUrl($image, $namePrefix, $folder = 'shop/', $product = false, $imageNumber = 1) {

        $sizeArray = @getimagesize($image);
        if ($sizeArray['mime'] == 'image/png') {
            $fileformat = 'png';
        } else {
            $fileformat = 'jpg';
        }

        $width = $sizeArray[0];
        $height = $sizeArray[1];

        if ($product) {
            $inventarNumber = $product->getInventarnumber();
            try {
                $category = $product->getCategory();
                $categoryName = $category->getName();
                $categoryName = StringUtils_Transliterate::TransliterateRuToEn($categoryName);
                $categoryName = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $categoryName);
                $categoryName = preg_replace('/([\-]{2,})/ius', '-', $categoryName);
                $namePrefix = "{$categoryName}-{$inventarNumber}-{$width}x{$height}-{$imageNumber}";
            } catch (Exception $e) {
                $namePrefix = "{$inventarNumber}-{$width}x{$height}-{$imageNumber}";
            }

        }

        if ($namePrefix) {
            // превращаем префикс в латинские символы
            // убираем все левое
            $namePrefix = StringUtils_Transliterate::TransliterateRuToEn($namePrefix);
            $namePrefix = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $namePrefix);
            $namePrefix = preg_replace('/([\-]{2,})/ius', '-', $namePrefix);
        }

        $url = MEDIA_PATH . $folder;

        $folder1 = 'image/';

        @mkdir($url . $folder1);


        $imagemd5 = $folder1 . $namePrefix . '.' . $fileformat;

        return $imagemd5;
    }

    public function addNews(
        $cdate, $hidden, $name, $contentPreview, $content, $image, $productid, $categoryID, $brandID, $url,
        $seodescription, $seotitle, $seocontent, $seokeywords, $pageID = false
    ) {
        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if ($image && !Checker::CheckImageFormat($image)) {
                $ex->addError('image');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if (!$cdate) {
                $cdate = date('Y-m-d H:i:s');
            }

            $url = trim($url);

            $x = new ShopNews();
            $x->setCdate($cdate);
            $x->setHidden($hidden);
            $x->setName($name);
            $x->setContent($content);
            $x->setContentpreview($contentPreview);
            $x->setProductid($productid);
            $x->setCategoryid($categoryID);
            $x->setBrandid($brandID);
            $x->setSeodescription($seodescription);
            $x->setSeotitle($seotitle);
            $x->setSeocontent($seocontent);
            $x->setSeokeywords($seokeywords);
            $x->setUrl($url);

            if ($pageID !== false) {
                $x->setPageid($pageID);
            }

            if ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false
                );

                copy($image, PackageLoader::Get()->getProjectPath() . 'media/shop/' . $file);

                $x->setImage($file);
            }

            $x->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    public function updateNews(
        ShopNews $news, $cdate, $hidden, $name, $contentPreview, $content, $image, $imageDelete,
        $productid, $categoryID, $brandID, $url, $seodescription, $seotitle, $seocontent,
        $seokeywords, $pageID = false
    ) {
        try {
            SQLObject::TransactionStart();
            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if (!Checker::CheckDate($cdate)) {
                $ex->addError('cdate');
            }

            if ($image && !Checker::CheckImageFormat($image)) {
                $ex->addError('image');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            //echo $pageID;exit;

            $url = trim($url);

            $news->setCdate($cdate);
            $news->setHidden($hidden);
            $news->setName($name);
            $news->setContent($content);
            $news->setContentpreview($contentPreview);
            $news->setProductid($productid);
            $news->setCategoryid($categoryID);
            $news->setBrandid($brandID);
            $news->setSeodescription($seodescription);
            $news->setSeotitle($seotitle);
            $news->setSeocontent($seocontent);
            $news->setSeokeywords($seokeywords);
            $news->setUrl($url);

            if ($pageID !== false) {
                $news->setPageid($pageID);
            }

            if ($imageDelete) {
                $news->setImage('');
            }

            if ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false
                );

                copy($image, PackageLoader::Get()->getProjectPath() . 'media/shop/' . $file);

                $news->setImage($file);
            }

            $news->update();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    /**
     * Получить максимальную вес товара
     *
     * @return type
     */
    public function getProductMaxWeight(ShopProduct $product) {
        $product->setOrder('weight', 'DESC');
        if ($p = $product->getNext()) {
            return $p->getWeight();
        }
        return 0;
    }

    /**
     * WWW
     *
     * @param $color
     *
     * @return mixed
     */
    private function _colorToEn($color) {
        $color = trim($color);
        $colorArray = array(
            'черный' => 'black',
            'белый' => 'white',
            'коричневый' => 'brown',
            'зеленый' => 'green',
            'желтый' => 'yellow',
            'фиолетовый' => 'purple',
            'красный' => 'red',
            'синий' => 'dark-blue',
            'голубой' => 'blue'
        );
        return @$colorArray[$color];
    }

    public $cannonicalArray = array(
        'http://www.rtm-zoloto.com.ua/kolca/filter_category=detskie',
        'http://www.rtm-zoloto.com.ua/kolca/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/kolca/filter_category=muzhskie',
        'http://www.rtm-zoloto.com.ua/kolca/filter_category=obruchalnie',
        'http://www.rtm-zoloto.com.ua/kolca/filter_types=bez-kamney',
        'http://www.rtm-zoloto.com.ua/kolca/filter_types=s-zhemchugom',
        'http://www.rtm-zoloto.com.ua/kolca/filter_types=s-kamnyami',
        'http://www.rtm-zoloto.com.ua/sergi/filter_types=bez-kamney',
        'http://www.rtm-zoloto.com.ua/sergi/filter_types=s-zhemchugom',
        'http://www.rtm-zoloto.com.ua/sergi/filter_types=s-kamnyami',
        'http://www.rtm-zoloto.com.ua/sergi/filter_category=detskie',
        'http://www.rtm-zoloto.com.ua/sergi/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/kulony/filter_types=s-kamnyami',
        'http://www.rtm-zoloto.com.ua/kulony/filter_category=detskie',
        'http://www.rtm-zoloto.com.ua/kulony/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/kulony/filter_category=muzhskie',
        'http://www.rtm-zoloto.com.ua/ladanki/filter_types=s-kamnyami',
        'http://www.rtm-zoloto.com.ua/ladanki/filter_category=detskie',
        'http://www.rtm-zoloto.com.ua/ladanki/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/ladanki/filter_category=muzhskie',
        'http://www.rtm-zoloto.com.ua/braslety/filter_types=bez-kamney',
        'http://www.rtm-zoloto.com.ua/braslety/filter_types=s-kamnyami',
        'http://www.rtm-zoloto.com.ua/braslety/filter_types=s-zhemchugom',
        'http://www.rtm-zoloto.com.ua/braslety/filter_category=muzhskie',
        'http://www.rtm-zoloto.com.ua/braslety/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/braslety/filter_category=detskie',
        'http://www.rtm-zoloto.com.ua/cepi/filter_category=zhenskie',
        'http://www.rtm-zoloto.com.ua/cepi/filter_category=muzhskie',
        'http://www.rtm-zoloto.com.ua/cepi/filter_category=detskie',
    );


    /**
     * RtmService
     *
     * @return RtmService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __clone() {

    }

    private static $_Instance = null;
}