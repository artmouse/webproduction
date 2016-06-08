<?php
class shop_product extends Engine_Class {

    public function process() {
        header('Cache-Control: no-cache, max-age=3600, must-revalidate');
        header_remove('Expires');

        $this->setValue('storeTitle', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        try {
            // получаем товар по ID
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            // ------------------------------------------------- //

            // скрытые товары показываем только админу
            if ($product->getHidden()) {
                if (!$this->getUser()->isAdmin()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

            // issue #35572
            try {
                if ($product->getCategory()->getHidden()) {
                    if (!$this->getUser()->isAdmin()) {
                        throw new ServiceUtils_Exception('hidden');
                    }
                }
            } catch (Exception $e) {

            }

            // ------------------------------------------------- //

            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }

            // @todo: убрать говнистость
            if ($categorySubdomain = $product->getCategorySubdomain()) {
                $e = explode('.', Engine::GetURLParser()->getHost());
                $url = preg_replace("~^[a-z]+~ie", "strtolower('\\0')", $categorySubdomain);
                if ($e[0] != $url) {
                    $u = $h . $categorySubdomain . '.' . Engine::Get()->getProjectHost() .
                    Engine::GetURLParser()->getTotalURL();
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: ' . $u);
                    exit();
                }
            }

            // проверяем, есть ли у товара специфический URL
            // и делаем редирект
            $url = Engine_URLParser::Get()->getTotalURL();
            if ($product->getUrl() && preg_match("/^\/product\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $product->makeURL());
                exit();
            }

            //для корзины
            $this->setValue('productID', $product->getId());

            // ------------------------------------------------- //

            // open graph tags
            $image = $product->makeImageThumb(100);
            if ($image) {
                Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL() . $image);
            }
            Engine::GetHTMLHead()->setMetaTag('og:title', $product->getName());
            Engine::GetHTMLHead()->setMetaTag(
                'og:description', htmlspecialchars(strip_tags($product->getDescription()))
            );

            $productName = $product->getName(false);
            $productNameSmall = mb_strtolower($productName);
            $inventarNumber = $product->getInventarnumber();
            // title
            Engine::GetHTMLHead()->setTitle(
                $productName . ', код: ' . $inventarNumber . ' | Ремточмеханика'
            );

            // meta-ключевые слова
            Engine::GetHTMLHead()->setMetaKeywords(
                mb_strtolower($productNameSmall) . ', золотой, код: ' . $inventarNumber .
                ', киев, интернет-магазин, ремточмеханика'
            );

            $padezhArray = array(
                'браслет' => 'Золотой',
                'булавк' => 'Золотая',
                'значек' => 'Золотой',
                'кольцо' => 'Золотое',
                'кулон' => 'Золотой',
                'перстень' => 'Золотой',
                'крест' => 'Золотой',
                'крестик' => 'Золотой',
                'ладанка' => 'Золотая',
                'серьга' => 'Золотая',
                'серьги' => 'Золотые',
                'цепь' => 'Золотая',
            );
            $metaDescription = '';
            foreach ($padezhArray as $key => $val) {
                if (substr_count($productNameSmall, $key)) {
                    $metaDescription = $val;
                    break;
                }
            }
            if (!$metaDescription) {
                $metaDescription = 'Золотой';
            }
            $x = '. Интернет-магазин ювелирных изделий “Ремточмеханика”';
            $metaDescription .= ' ' . $productNameSmall . ', код: ' . $inventarNumber . $x .
            ' - широкий ассортимент украшений, превосходное качество.';

            Engine::GetHTMLHead()->setMetaDescription(
                $metaDescription
            );

            if ($product->getCategoryid()) {
                // отправляем в шаблон указание, какая категория выбрана
                $block = Engine::GetContentDriver()->getContent('shop-tpl-column');
                $block->setValue('categorySelected', $product->getCategoryid());
            }

            // +1 view counter
            Shop::Get()->getShopService()->viewProduct($product);

            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();

            $this->setValue('id', $product->getId());
            $this->setValue('code', $product->getCode1c() ? $product->getCode1c() : $product->getId());
            $this->setValue('paymentid', $product->getId() . time());
            $this->setValue('name', $productName);
            $this->setValue('description', $product->getDescription());
            if ($product->getWidth() != 0) {
                $this->setValue('width', $product->getWidth());
            }
            if ($product->getHeight() != 0) {
                $this->setValue('height', $product->getHeight());
            }
            if ($product->getLength() != 0) {
                $this->setValue('length', $product->getLength());
            }
            if ($product->getWeight() != 0) {
                $this->setValue('weight', $product->getWeight());
            }

            $pricesArray = RtmService::Get()->getProductPricesArray($product, $currencyDefault);

            $productUrl = $product->makeUrl();

            if ($productUrl) {
                Engine::GetHTMLHead()->addLink('canonical', $productUrl);
            }

            $this->setValue('viewed', $product->getViewed());
            $this->setValue('url', $productUrl);
            $this->setValue('ordered', $product->getOrdered());
            $this->setValue('price', number_format($pricesArray['price'], 0, '.', ' '));
            $this->setValue('price_product', number_format($pricesArray['productPrice'], 0, '.', ' '));
            $this->setValue('priceold', number_format($pricesArray['priceOld'], 0, '.', ' '));
            $this->setValue('priceproductold', number_format($pricesArray['productPriceOld'], 0, '.', ' '));
            $this->setValue('discount', $product->getDiscount());
            $this->setValue('pricediscount', $product->makePriceWithTax($currencyDefault));
            $this->setValue('currency', $currencyDefault->getSymbol());
            $this->setValue('currencyName', $currencyDefault->getName());
            $this->setValue('model', htmlspecialchars($product->getModel()));
            $this->setValue('unit', htmlspecialchars($product->getUnit()));
            $this->setValue('count', (($product->getDivisibility() > 0) ? ((float) $product->getDivisibility()) : 1));
            $this->setValue('avail', $product->getAvail());
            $this->setValue('availtext', htmlspecialchars($product->getAvailtext()));
            $this->setValue('canbuy', $product->getCanBuy());
            $this->setValue('share', $product->getShare());
            $this->setValue('canMakePreorder', $product->getPreorderDiscount());
            $news = Shop::Get()->getNewsService()->getNewsByProduct($product);
            if ($n = $news->getNext()) {
                $this->setValue('abouturl', $n->makeUrl());
            }
            $imagesArray = array();

            $category = $product->getCategory();
            $categoryName = trim($category->getName());

            if ($categoryName == 'Браслеты' || $categoryName == 'Цепи') {
                $this->setValue('baseWeight', $product->getBaseweight());
            }

            $this->setValue('inventarNumber', $inventarNumber);

            foreach ($product->getImagesArray() as $k => $image) {
                // Если нету файла на диске, то идем дальше
                if (!file_exists(PackageLoader::Get()->getProjectPath() . '/media/shop/' . $image)) {
                    continue;
                }
                $originalUrl = Shop_ImageProcessor::MakeThumbProportional(
                    PackageLoader::Get()->getProjectPath() . '/media/shop/' . $image, 1200, false, 'png'
                );
                $originalUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $originalUrl);

                $cropUrl = Shop_ImageProcessor::MakeThumbUniversal(
                    PackageLoader::Get()->getProjectPath() . '/media/shop/' . $image, 602, 519
                );
                $cropUrl = str_replace(PackageLoader::Get()->getProjectPath(), '', $cropUrl);

                $alt = $product->makeImageAlt($cropUrl, $k + 1);

                $imagesArray[] = array(
                    'alt' => $alt,
                    'title' => $alt . '-Ремточмеханика',
                    'originalUrl' => $originalUrl,
                    'cropUrl' => $cropUrl
                );
            }
            $this->setValue('imagesArray', $imagesArray);

            // Ювелир
            if ($product->getJewelerid()) {
                try {

                    $jeweler = Shop::Get()->getShopService()->getObjectByID($product->getJewelerid(), 'XJeweler');
                    $img = $jeweler->getImage();
                    $image = Shop_ImageProcessor::MakeThumbProportional(
                        PackageLoader::Get()->getProjectPath() . '/media/shop/' . $img, 602, false, 'png'
                    );
                    $image = str_replace(PackageLoader::Get()->getProjectPath(), '', $image);
                    $this->setValue('jewelerImageSmall', $image);
                    $image = Shop_ImageProcessor::MakeThumbProportional(
                        PackageLoader::Get()->getProjectPath() . '/media/shop/' . $img, 1200, 526, 'png'
                    );
                    $image = str_replace(PackageLoader::Get()->getProjectPath(), '', $image);
                    $this->setValue('jewelerImage', $image);
                    $this->setValue('jewelerDescription', $jeweler->getDescription());
                    $this->setValue('jewelerName', $jeweler->getName());

                } catch (Exception $e) {

                }

            }

            $tradeHallPhoto = Shop::Get()->getSettingsService()->getSettingValue('trade-hall-photo');
            if ($tradeHallPhoto) {
                $image = Shop_ImageProcessor::MakeThumbProportional(
                    PackageLoader::Get()->getProjectPath() . $tradeHallPhoto, 591, 523, 'png'
                );
                $image = str_replace(PackageLoader::Get()->getProjectPath(), '', $image);
                $a = array(
                    'photo' => $image,
                    'description' => Shop::Get()->getSettingsService()->getSettingValue('trade-hall-photo-description'),
                    'text' => Shop::Get()->getSettingsService()->getSettingValue('trade-hall-photo-text')
                );
                $this->setValue('tradeHall', $a);
            }

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $product->getSeocontent());

            // иконка к товару
            $this->setValue('iconImage', $product->makeIcon());

            $this->setValue('siteurl', $product->getSiteurl());
            $this->setValue('descriptionshort', $product->getDescriptionshort());

            // показывать ли штрих-код
            if (Shop::Get()->getSettingsService()->getSettingValue('product-barcode-show')) {
                $this->setValue('barcode', $product->getBarcode());
            }

            if (Shop::Get()->getSettingsService()->getSettingValue('found-cheaper')) {
                $render = Engine::GetContentDriver()->getContent('shop-products-found-cheaper');
                $render->setValue('productName', $product->getName());
                $render->setValue('productID', $product->getId());
                $this->setValue('foundcheaper', $render->render());
            }

            // quick order
            $render = Engine::GetContentDriver()->getContent('shop-products-quick-order');
            $render->setValue('product', $product);
            $this->setValue('quickOrder', $render->render());

            // показывать ли кнопки соц. сетей
            if (Shop::Get()->getSettingsService()->getSettingValue('social-button')) {
                $this->setValue('showSocial', 1);
            }

            // Показывать блок "Сообщите когда появится"
            if (!$product->getAvail() &&
            Shop::Get()->getSettingsService()->getSettingValue('products-notice-of-availability')) {
                $render = Engine::GetContentDriver()->getContent('shop-products-notice-of-availability');
                $render->setValue('id', $product->getId());
                $this->setValue('noticeOfAvailability', $render->render());
            }

            $render = Engine::GetContentDriver()->getContent('shop-tpl-column');
            $warranty = htmlspecialchars($product->getWarranty());
            $payment = htmlspecialchars($product->getPayment());
            $delivery = htmlspecialchars($product->getDelivery());
            if (empty($warranty)) {
                $warranty = Shop::Get()->getSettingsService()->getSettingValue('warranty');
            }
            if (empty($payment)) {
                $payment = Shop::Get()->getSettingsService()->getSettingValue('payment');
            }
            if (empty($delivery)) {
                $delivery = Shop::Get()->getSettingsService()->getSettingValue('delivery');
            }
            $render->setValue('warranty', $warranty);
            $render->setValue('payment', $payment);
            $render->setValue('delivery', $delivery);

            $this->setValue('characteristics', nl2br(htmlspecialchars($product->getCharacteristics())));

            // характеристики по данному товару;
            // одновременно строим массив опций
            $a = array();

            $filter_count = $this->_getFiltersCount();

            $productProbe = '';
            $productWeightExchange = '';
            $filterExchangeid = 0;

            for ($j = 1; $j <= $filter_count; $j++) {
                try {
                    $filterID = $product->getField('filter' . $j . 'id');
                    $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);
                    if ($filter->getHidden()) throw new Exception('hidden filter');

                    if ($product->getField('filter' . $j . 'actual')) {

                        $filterValue = $product->getField('filter' . $j . 'value');

                        if ($product->getField('filter' . $j . 'actual')) {
                            $filterColor = '';

                            if (preg_match("/^color:(.+?)(?:\s+)(.+?)$/ius", $filterValue, $r)) {
                                // фильтр по цветам
                                $filterValue = $r[2];
                                $filterColor = $r[1];
                            } else {
                                // обычный фильтр
                                $filterValue = htmlspecialchars($filterValue);
                            }

                            $filterName = $filter->getName();
                            if ($filterName == 'Металл') {
                                $productProbe = filter_var($filterValue, FILTER_SANITIZE_NUMBER_INT);
                                $filterValue = $filterValue . '&deg;';
                            } else if ($filterName == 'Вес золота для обмена') {
                                $productWeightExchange = $filterValue;
                                $filterExchangeid = $filter->getId();
                            }

                            $a[] = array(
                                'characteristicName' => $filterName,
                                'characteristicValue' => $filterValue,
                                'characteristicColor' => $filterColor,
                            );
                        }

                    }

                } catch (Exception $e) {

                }
            }
            $this->setValue('characteristicsArray', $a);


            if ($productWeightExchange) {
                $this->setValue(
                    'weightExchange',
                    array(
                        'id' => $filterExchangeid,
                        'value' => $productProbe . '&deg; ' . $productWeightExchange . 'г'
                    )
                );
            }

            // Строим опцию заказа Размер
            $optionArray = array();
            $sizeArr = $this->_makeSizeOrderOption($product, $currencyDefault);
            if (!empty($sizeArr)) {
                $optionArray[] = $sizeArr;
            }
            $this->setValue('optionArray', $optionArray);

            Engine::GetContentDriver()->getContent('shop-tpl-column')->setValue('productSelected', true);

            try {
                $this->setValue('brand', $product->getBrand()->makeInfoArray());
            } catch (Exception $e) {

            }

            try {
                if ($this->getUser()->isAdmin()) {
                    $this->setValue('urledit', $product->makeURLEdit());
                    $this->setValue('adminRed', !$product->getAvail());
                }
            } catch (Exception $e) {

            }
            $this->setValue(
                'orderurl', Engine::GetLinkMaker()->makeURLByContentIDParam($this->getContentID(), $product->getId())
            );

            // ловим комментарий
            if ($this->getControlValue('submitcomment')) {
                try {
                    if ($this->getControlValue('ajs') != 'ready') {
                        throw new ServiceUtils_Exception('bot');
                    }

                    Shop::Get()->getShopService()->addProductComment(
                        $product,
                        $this->getUser(),
                        $this->getControlValue('postcomment'),
                        $this->getControlValue('postplus'),
                        $this->getControlValue('postminus'),
                        $this->getControlValue('commentrating')
                    );

                    $this->setValue('message', 'commentok');
                } catch (Exception $commentException) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $commentException;
                    }

                    $this->setValue('message', 'commenterror');
                }
            }

            // новости по товару
            try {
                $news = Shop::Get()->getNewsService()->getNewsByProduct(
                    $product
                );

                $a = array();
                while ($x = $news->getNext()) {
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => htmlspecialchars($x->getName()),
                        'date' => DateTime_Formatter::DatePhonetic($x->getCdate()),
                        'url' => Engine::GetLinkMaker()->makeURLByContentIDParam('shop-news-view', $x->getId()),
                    );
                }
                $this->setValue('productnewsArray', $a);
            } catch (Exception $e) {

            }

            // комментарии по товару
            if (!$product->getDenycomments()) {
                $comments = Shop::Get()->getShopService()->getProductComments($product);
                $a = array();
                $index = 0;
                while ($x = $comments->getNext()) {
                    try {
                        $user = Shop::Get()->getUserService()->getUserByID(
                            $x->getUserid()
                        );

                        $a[] = array(
                            'id' => $x->getId(),
                            'index' => $index,
                            'content' => htmlspecialchars($x->getText()),
                            'plus' => htmlspecialchars($x->getPlus()),
                            'minus' => htmlspecialchars($x->getMinus()),
                            'datetime' => DateTime_Formatter::DateISO9075($x->getCdate()),
                            'rating' => $x->getRating(),
                            'user' => $user->makeInfoArray()
                        );

                        $index++;
                    } catch (Exception $e) {

                    }
                }
                $this->setValue('commentsArray', $a);

                // разрешено ли комментировать товар?
                $this->setValue('allowcomment', $this->isUserAuthorized());
                if ($this->isUserAuthorized()) {
                    $ratingArray = array(0, 1, 2, 3, 4, 5);
                    $this->setValue('ratingArray', $ratingArray);
                }

                // интеграция с внешней системой комментариев
                $integration = Shop::Get()->getSettingsService()->getSettingValue('integration-comments');
                $integration = trim($integration);
                $this->setValue('commentIntegration', $integration);
            }

            // путь к товару (хлебные крошки)
            $a = array();
            for ($i = 1; $i <= 10; $i++) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                        $product->getField('category' . $i . 'id')
                    );

                    $a[] = $category->makeInfoArray();
                } catch (Exception $e) {
                    break;
                }
            }
            $a[] = array(
                'name' => $product->getCode1c()
            );
            $this->setValue('pathArray', $a);

            // связанные списки товаров
            $lists = Shop::Get()->getShopService()->getProductsListAll();
            $lists->setHidden(0);
            $lists->addWhere('linkkey', 'product-' . $product->getId() . '-%', 'LIKE');

            $listsArray = array();
            while ($list = $lists->getNext()) {
                try {
                    // @todo: optimization
                    if ($list->getProducts()->getCount() > 0) {
                        $listProducts = $list->getProducts();
                        while ($listProduct = $listProducts->getNext()) {
                            $a = array();
                            $a['name'] = $listProduct->getName();
                            $a['url'] = $listProduct->makeURL();
                            $a['image'] = $listProduct->makeImageThumb(106, 88);

                            $listsArray[] = $a;
                        }
                    }
                } catch (Exception $e) {

                }
            }

            $this->setValue('listsArray', $listsArray);
            $this->setValue(
                'characteristics_message',
                nl2br(Shop::Get()->getSettingsService()->getSettingValue('characteristics-message'))
            );
        } catch (Exception $ge) {
            Engine::Get()->getRequest()->setContentNotFound();

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }

        // Вы смотрели
        try {
            $views = new XShopProductView(); // @todo: service
            $views->setOrder('cdate', 'DESC');
            try {
                $user = $this->getUser();
                $views->setUserid($user->getId());
            } catch (Exception $e) {
                $views->setSessionid($this->_getSessionID());
            }

            $productsIDArray = array();
            $subarticulArray = array();
            while ($x = $views->getNext()) {

                $productId = 0;
                try {
                    $viewProduct = Shop::Get()->getShopService()->getProductByID($x->getProductid());
                    $subarticul = $viewProduct->getSubarticul();
                    if (!in_array($subarticul, $subarticulArray)) {
                        $productId = $x->getProductid();
                        $subarticulArray[] = $subarticul;
                    }
                } catch (Exception $e) {

                }
                if ($productId) {
                    $productsIDArray[] = $productId;

                    if (count($productsIDArray) >= 5) {
                        break;
                    }
                }

            }

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->addWhereArray($productsIDArray);

            $productsViewsArray = array();
            while ($x = $products->getNext()) {
                $a = array();
                $a['name'] = $x->getName();
                $a['url'] = $x->makeURL();

                $a['image'] = $x->makeImageThumb(602, 519);

                $alt = $x->makeImageAlt($a['image'], 1);

                $a['alt'] = $alt;

                $a['title'] = $alt . '-Ремточмеханика';

                $productsViewsArray[] = $a;
            }

            $this->setValue('productsViewsArrayCount', count($productsViewsArray));
            $this->setValue('productsViewsArray', $productsViewsArray);

        } catch (Exception $e) {

        }

        $video = $product->getVideoUrl();
        if ($video) {
            $video = str_replace('https://www.youtube.com/watch?v=', '', $video);
            $this->setValue('video', $video);
        }

        // Похожие товары
        try {
            $category = $product->getCategory();
            $productsCategory = $category->getProducts();
            $productsCategory->addWhere('price', $this->_getPriceInterval($product->getPrice(), 'plus'), '<');
            $productsCategory->addWhere('price', $this->_getPriceInterval($product->getPrice(), 'minus'), '>');
            $productsCategory->addWhere('id', $product->getId(), '<>');
            $productsCategory->setLimitCount(15);


            $render = Engine::GetContentDriver()->getContent('shop-product-carousel');
            $render->setValue('products', $productsCategory);
            $render->setValue('name', 'Похожие товары');
            $html = $render->render();
            $this->setValue('productsSimilar', $html);
        } catch (Exception $e) {

        }

        //передадим данные для соц кнопок
        $this->setValue('mainUrl', 'http://' . Engine::GetURLParser()->getHost());
        $this->setValue('totalUrl', Engine::GetURLParser()->getTotalURL());

    }


    /**
     * ShopProduct
     *
     * @param ShopProduct $product
     * @param $currencyDefault
     */
    private function _makeSizeOrderOption(ShopProduct $product, $currencyDefault) {
        $currencyDefault;
        // Строим опцию заказа Размер

        $a = array();

        try {
            $filter_count = $this->_getFiltersCount();

            $filterId = $this->_getFilterIdByName('Размер');

            $currentProductSize = $this->_getProductFilterValues($product, $filterId, $filter_count);
            // Если есть размер у товара
            if ($currentProductSize) {

                $optionProducts = new ShopProduct();
                $optionProducts->setSubarticul($product->getSubarticul());
                $optionProducts->addWhere('id', $product->getId(), '<>');
                $optionProducts->setCategoryid($product->getCategoryid());
                $optionProducts->setHidden(0);
                $optionProducts->setDeleted(0);

                $valueArray = array();
                $productsArray = array();

                // Получаем размеры и данные похожих продуктов
                while ($similarProduct = $optionProducts->getNext()) {

                    $value = $this->_getProductFilterValues($similarProduct, $filterId, $filter_count);
                    if ($value) {
                        $valueArray[] = $value;
                        $productsArray[] = array('id' => $similarProduct->getId());
                    }
                }

                array_multisort($valueArray, $productsArray);

                array_unshift($valueArray, $currentProductSize);

                array_unshift($productsArray, array('id' => $product->getId()));
                foreach ($productsArray as $key=>$id) {
                    $p = Shop::Get()->getShopService()->getProductByID($id['id']);
                    $productsArray[$key]['avail'] = $p->getAvail();
                }
                $a = array(
                    'id' => $filterId,
                    'name' => 'Размер',
                    'valueArray' => $valueArray,
                    'productArray' => $productsArray,
                );

            }

            return $a;

        } catch (Exception $e) {

        }
    }


    /**
     * ProductFilterValues
     *
     * @param ShopProduct $product
     * @param $filterId
     * @param $filterCount
     *
     * @return mixed
     */
    private function _getProductFilterValues(ShopProduct $product, $filterId, $filterCount) {
        for ($index = 1; $index < $filterCount; $index++) {
            if ($filterId == $product->getField('filter' . $index . 'id')) {
                return $product->getField('filter' . $index . 'value');
            }
        }
    }

    /**
     * FilterIdByName
     *
     * @param $filterName
     *
     * @return bool
     */
    private function _getFilterIdByName($filterName) {
        try {
            $filter = $this->_getObjectByName($filterName, 'ShopProductFilter');
            return $filter->getId();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * Получить идентификатор сесии
     * с проверкой его состояния
     *
     * @return string
     */
    private function _getSessionID() {
        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }

    /**
     * ObjectByName
     *
     * @param $name
     * @param $object
     *
     * @return object
     */
    private function _getObjectByName($name, $object) {
        $name = trim($name);
        return Shop::Get()->getShopService()->getObjectByField('name', $name, $object);
    }

    /**
     * FiltersCount
     *
     * @return int|mixed
     */
    private function _getFiltersCount() {
        try {
            $filterCount = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filterCount = 10;
        }

        if (!$filterCount) {
            $filterCount = 10;
        }
        return $filterCount;
    }

    /**
     * PriceInterval
     *
     * @param $price
     * @param $action
     *
     * @return mixed
     */
    private function _getPriceInterval($price, $action) {
        $percentageSection = ($price * 35) / 100;
        if ($action == 'plus') {
            $price = $price + $percentageSection;
        } elseif ($action == 'minus') {
            $price = $price - $percentageSection;
        }

        return $price;
    }

}