<?php
class shop_product_list extends Engine_Class {

    /**
     * ShopProduct
     *
     * @return ShopProduct
     */
    private function _getItems() {
        if (!$x = $this->getValue('items')) {
            $category = Shop::Get()->getShopService()->getCategoryByID($this->getArgumentSecure('categoryid'));
            $this->setValue('ajaxLoad', 1);
            $x = $category->getProducts();
        }
        $x->setHidden(0);
        $x->setDeleted(0);
        $x = Shop::Get()->getShopService()->setProductsDateLifeFilter($x);
        if (Shop::Get()->getSettingsService()->getSettingValue('only-avail-product')) {
            $x->addWhere('avail', 0, '>');
        }
        return $x;
    }

    /**
     * ShopCategory
     *
     * @return ShopCategory
     */
    private function _getSubcategories() {
        return $this->getValue('subcategories');
    }

    public function process() {
        $this->setValue('storeTitle', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');

        // время кеша по умолчанию
        $cacheTTL = 60;

        $admin = false;
        try {
            if ($this->getUser()->isAdmin()) {
                $admin = true;
            }
        } catch (Exception $e) {

        }
        $isCategory = $this->getValue('category');
        // ------------------------------------------------- //

        // ссылки на отображение thumbs/table
        $this->setValue('urlshow_thumbs', $this->makeURL(array('show' => 'thumbs')));
        $this->setValue('urlshow_table', $this->makeURL(array('show' => 'table')));
        if ($isCategory) {
            $this->setValue('urlshow_subcategory', $this->makeURL(array('show' => 'subcategory')));
            $this->setValue('urlshow_subcategoryproduct', $this->makeURL(array('show' => 'subcategoryproduct')));
        }

        // получаем способ отображения категории
        if (isset($_SESSION['shopshow'])) {
            $show = $_SESSION['shopshow'];
        } else {
            $show = false;
        }


        // способ отображения по умолчанию
        $showTypeDefault = $this->getValue('showtype');
        if (!$show) {
            $show = $showTypeDefault;
        }
        // если выбран only-параметр - то показываем только так
        if ($showTypeDefault == 'thumbsonly' || $showTypeDefault == 'tableonly' ||
        ($showTypeDefault == 'subcategoryonly' && $isCategory) ||
        ($showTypeDefault == 'subcategoryproductonly' && $isCategory)) {
            $show = $showTypeDefault;
            $this->setValue('disallowshow', true);
        }
        if ($show == 'tableonly') {
            $show = 'table';
        }
        if ($show == 'subcategoryonly' && $isCategory) {
            $show = 'subcategory';
        }
        if ($show == 'subcategoryproductonly' && $isCategory) {
            $show = 'subcategoryproduct';
        }
        if ($show != 'table' && ($show != 'subcategory' || !$isCategory) &&
        ($show != 'subcategoryproduct' || !$isCategory)) {
            $show = 'thumbs';
        }
        $this->setValue('show', $show);

        // получение дефолтной валюты
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencyDefault();

        if (!substr_count($show, 'subcategory') || !$isCategory) {
            // получаем товары
            $products = $this->_getItems();
            if (!$admin) {
                $products->setUser_view(1);
            }
            $products->setHidden(0); // накладываем условие видимости

            if (!Shop::Get()->getSettingsService()->getSettingValue('show-filters')) {
                $this->setValue('nofilters', true);
            }

            // Соединение с БД
            $connection = ConnectionManager::Get()->getConnectionDatabase();

            $argumentsArray = $this->_getFiltersArguments();

            // echo'<pre>';print_r($argumentsArray);echo'</pre>';exit;

            $selectedFilter = false;

            $withoutFilters = false;
            if (empty($argumentsArray)) {
                $withoutFilters = true;
            }

            $this->setValue('categoryid', $products->getCategory1id());

            // для некоторых фильтров особые метатеги
            $totalUrl = Engine_URLParser::Get()->getTotalURL();

            $contentID = Engine::Get()->getRequest()->getContentID();
            if ($contentID == 'shop-category') {
                // Строим канонические ссылки, если есть фильтры
                if (substr_count($totalUrl, 'filter')) {
                    $x = explode('/', $totalUrl);
                    $x = array_pop($x);
                    $x = preg_replace('#_p=\d+#', '', $x);
                    $categoryUrl = explode('filter', $totalUrl);
                    $categoryUrl = $categoryUrl[0];
                    if ($x == 'filter') {
                        Engine::GetHTMLHead()->addLink(
                            'canonical',
                            Engine::Get()->getProjectURL().$categoryUrl
                        );
                    } else {
                        Engine::GetHTMLHead()->addLink(
                            'canonical',
                            Engine::Get()->getProjectURL().$categoryUrl. $x
                        );
                    }
                }
            }

            $cannonicalArray = RtmService::Get()->cannonicalArray;
            $needMetaTeg = true;
            foreach ($cannonicalArray as $url) {
                if (substr_count($url, $totalUrl)) {
                    if (substr_count($totalUrl, 'kolca/filter_category=muzhskie')) {
                        $render = Engine::GetContentDriver()->getContent('shop-category');
                        $render->setValue('title', 'Мужские золотые кольца | Ювелирный магазин “Ремточмеханика”');
                        $render->setValue(
                            'keywords',
                            'мужские, золотые, кольца, перстни, печатки, ювелирные изделия, киев, ремточмеханика'
                        );
                        $x = 'Каталог золотых колец для мужчин. Изящные перстни и печатки, честные цены.';
                        $x .= ' Интернет-магазин “Ремточмеханика” - только качественные изделия от опытных ювелиров!';
                        $render->setValue(
                            'metaDescription',
                            $x
                        );
                        $render->setValue('h1', 'Мужские золотые кольца');
                        $needMetaTeg = false;
                        break;
                    } elseif (substr_count($totalUrl, 'kolca/filter_category=obruchalnie')) {
                        $render = Engine::GetContentDriver()->getContent('shop-category');
                        $render->setValue('h1', 'Обручальные золотые кольца');
                        $render->setValue('title', 'Золотые обручальные кольца | Ювелирный магазин “Ремточмеханика”');
                        $render->setValue(
                            'keywords',
                            'обручальные, золотые, кольца, ювелирные изделия, киев, ремточмеханика'
                        );

                        $x = 'Каталог золотых обручальных колец. Готовитесь к свадьбе - выберите изящное кольцо в';
                        $x .= ' интернет-магазине “Ремточмеханика”! Безупречное качество, честные цены.';
                        $render->setValue(
                            'metaDescription',
                            $x
                        );
                        $needMetaTeg = false;
                        break;
                    }
                }
            }

            if ($needMetaTeg) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($products->getCategory1id());
                    $categoryName = $category->getName();
                    if ($categoryName == 'Цепи') {
                        $categoryName = 'Цепочки';
                    }

                    $typeArray = array('Детские', 'Женские', 'Мужские', 'Обручальные');
                    $featureArray = array('Без камней', 'С жемчугом', 'С камнями');

                    $categoryType = '';
                    $categoryFeature = '';
                    foreach ($argumentsArray as $filterDate) {
                        if (in_array($filterDate['filterValue'], $typeArray)) {
                            $categoryType = $filterDate['filterValue'];
                        } elseif (in_array($filterDate['filterValue'], $featureArray)) {
                            $categoryFeature = $filterDate['filterValue'];
                        }
                    }

                    $title = '';
                    if ($categoryType) {
                        $title .= $categoryType. ' золотые';
                    } else {
                        $title .= 'Золотые';
                    }
                    $title .= ' ' . mb_strtolower($categoryName);
                    if ($categoryFeature) {
                        $title .= ' ' . mb_strtolower($categoryFeature);
                    }
                    $metaDescription = $title;
                    $h1 = $title;
                    $title .= ' | Ювелирный магазин “Ремточмеханика”';

                    $keywordsArray = array();
                    if ($categoryType) {
                        $keywordsArray[] = $categoryType;
                    }
                    $keywordsArray[] = 'золотые';
                    $keywordsArray[] = $categoryName;
                    if ($categoryFeature) {
                        $keywordsArray[] = $categoryFeature;
                    }
                    $keywordsArray[] = 'ювелирные изделия';
                    $keywordsArray[] = 'киев';
                    $keywordsArray[] = 'ремточмеханика';

                    $metaDescription .= '. Изящные украшения по доступным ценам. Безупречное качество.';
                    $metaDescription .= ' Бесплатная доставка по всей Украине.';

                    $render = Engine::GetContentDriver()->getContent('shop-category');
                    $render->setValue('h1', $h1);
                    $render->setValue('title', $title);
                    $render->setValue(
                        'keywords',
                        mb_strtolower(implode(', ', $keywordsArray))
                    );
                    $render->setValue(
                        'metaDescription',
                        $metaDescription
                    );

                } catch (Exception $e) {

                }
            }

            // накладываем (применяем) фильтры
            $products = $this->_applyFilters($argumentsArray, $connection, $products, $currencyDefault, $admin);

            $sqlAll = $products->__toString();
            $this->_tmpFiltersArray = $this->_getFiltersArray($sqlAll, $connection);

            $this->_productsCount = $products->getCount();

            // Если нет товаров после фильтрации то убираем фильтры
            if ($this->_productsCount == 0 && !$withoutFilters) {

                $products->clearWhere();

                /*$showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');
                if (!$showNoImageProducts) {
                    $products->addWhere('image', '', '<>');
                }*/

                if (!$this->_isProductFiltered($argumentsArray)) {
                    $products->addWhere('showincategory', '1', '=');
                }

                $this->setValue('noFilteredProducts', 1);
            } else if ($this->_productsCount < 6 && !$withoutFilters) {

                // вывод товаров
                $a = $this->_getProductsArray($products, $admin, $currencyDefault, $argumentsArray);
                $this->setValue('productsAfterFilters', $a); // продукты результат для которых был меньше 6-ти

                // для цены и веса делаем +- 20 %
                if (isset($argumentsArray['price-from'])) {
                    $argumentsArray['price-from'] *= 0.8;
                    if ($argumentsArray['price-from'] < 0) {
                        $argumentsArray['price-from'] = 0;
                    }
                }

                if (isset($argumentsArray['price-to'])) {
                    $argumentsArray['price-to'] *= 1.2;
                }

                if (isset($argumentsArray['weight-from'])) {
                    $argumentsArray['weight-from'] *= 0.8;
                    if ($argumentsArray['weight-from'] < 0) {
                        $argumentsArray['weight-from'] = 0;
                    }
                }

                if (isset($argumentsArray['weight-to'])) {
                    $argumentsArray['weight-to'] *= 1.2;
                }


                $filtersArray = $this->_tmpFiltersArray;

                $newArgumentsArray = array();
                foreach ($argumentsArray as $key => $filter) {
                    if (!is_array($filter)) {
                        $newArgumentsArray[$key] = $filter;
                        continue;
                    }

                    try {
                        $defaultValuesArray = array_unique($filtersArray[$filter['filterId']]);
                        // Если массив то добавляем еще два крайних размера
                        if (is_array($filter['filterValue'])) {

                            $newValueMin = $filter['filterValue'][0];
                            $k = array_search($newValueMin, $defaultValuesArray);
                            $newValueMin = @$defaultValuesArray[$k - 1];

                            $newValueMax = end($filter['filterValue']);
                            $k = array_search($newValueMax, $defaultValuesArray);
                            $newValueMax = @$defaultValuesArray[$k + 1];

                            $oldValue = $filter['filterValue'];

                        } else {

                            $newValueMin = $filter['filterValue'];
                            $k = array_search($newValueMin, $defaultValuesArray);
                            $newValueMin = @$defaultValuesArray[$k - 1];
                            $newValueMax = @$defaultValuesArray[$k + 1];

                            $oldValue = $argumentsArray[$key]['filterValue'];

                        }

                        if (!empty($newValueMin) && !empty($newValueMax)) {
                            $newValueArray = $this->_makeNewValueArray(array($newValueMin, $newValueMax), $oldValue);
                            $newArgumentsArray[$key] = array(
                                'filterId' => $argumentsArray[$key]['filterId'],
                                'filterValue' => $newValueArray
                            );
                        } else if (!empty($newValueMin)) {
                            $newValueArray = $this->_makeNewValueArray(array($newValueMin), $oldValue);

                            $newArgumentsArray[$key] = array(
                                'filterId' => $argumentsArray[$key]['filterId'],
                                'filterValue' => $newValueArray
                            );

                        } else if (!empty($newValueMax)) {
                            $newValueArray = $this->_makeNewValueArray(array($newValueMax), $oldValue);

                            $newArgumentsArray[$key] = array(
                                'filterId' => $argumentsArray[$key]['filterId'],
                                'filterValue' => $newValueArray
                            );
                        }

                    } catch (Exception $e) {

                    }


                }

                $argumentsArray = $newArgumentsArray;

                $products->clearWhere();
                // накладываем (применяем) фильтры
                $products = $this->_applyFilters($argumentsArray, $connection, $products, $currencyDefault, $admin);

            }

            // ------------------------------------------------- //
            // строим фильтры
            if (!$this->getValue('nofilters')) {
                // сначала проверяем, есть ли вообще у нас фильтры
                $filter = Shop::Get()->getShopService()->getProductFiltersAll();
                if ($filter->select()) {
                    // получаем все фильтры и допустимые значения

                    $filtersArray = $this->_getFiltersArray($this->_sqlAll, $connection);

                    $a = array();
                    $selectedArray = $argumentsArray;
                    foreach ($filtersArray as $filterID => $filterValuesArray) {
                        try {
                            $filter = Shop::Get()->getShopService()->getProductFilterByID(
                                $filterID
                            );

                            if ($filter->getHidden()) {
                                continue;
                            }

                            $filterValuesArray = array_unique($filterValuesArray);

                            // тип сортировки
                            if ($filter->getSorttype()) {
                                // сортировать как числа
                                usort($filterValuesArray, array($this, '_sortFilterValuesAsNumbers'));
                            } else {
                                // обычная сортировка
                                sort($filterValuesArray);
                            }

                            $filterName = $filter->getName();

                            if ($filterName == 'Размер') { // Костыль для невидимых размеров
                                $defaultSizesArray = array();
                                try {
                                    $defaultSizesArray = RtmService::Get()->getCategorySizesById(
                                        $products->getCategory1id()
                                    );
                                } catch (Exception $e) {

                                }
                            }

                            $filterValuesArray2 = array();

                            foreach ($filterValuesArray as $index => $filterValue) {
                                // обычный фильтр
                                $filterValuesArray2[$filterValue] = array(
                                    'title' => $filterValue,
                                    'value' => RtmService::Get()->buildFilterURL($filterValue, $filterID),
                                    'name' => htmlspecialchars($filterValue),
                                    'selected' => @$selectedArray[$filterValue],
                                    'disabled' => 0
                                );
                                if ($filterName == 'Размер' && !empty($defaultSizesArray)) {
                                    if (($key = array_search($filterValue, $defaultSizesArray)) !== false) {
                                        unset($defaultSizesArray[$key]);
                                    }
                                }
                            }

                            if ($filterName == 'Размер') {
                                // Добавляем все розмеры которых нету и отмечаем их disabled
                                foreach ($defaultSizesArray as $value) {
                                    $filterValuesArray2[$value] = array(
                                        'title' => $value,
                                        'value' => '',
                                        'name' => htmlspecialchars($value),
                                        'selected' => 0,
                                        'disabled' => 1
                                    );
                                }

                                ksort($filterValuesArray2);

                            }

                            // определение min & max
                            $min = false;
                            $max = false;
                            foreach ($filterValuesArray2 as $x) {
                                if (!$min || $x['value'] < $min) {
                                    $min = $x['value'];
                                }
                                if (!$max || $x['value'] > $max) {
                                    $max = $x['value'];
                                }
                            }

                            $a[$filter->getId()] = array(
                                'name' => htmlspecialchars($filterName),
                                'id' => $filter->getId(),
                                'type' => $filter->getType(),
                                'valuesArray' => $filterValuesArray2,
                                'valueMin' => (int) $min,
                                'valueMax' => (int) $max,
                                'selectedArray' => $selectedArray,
                                'filterUrl' => SEOService::Get()->getFilterUrl($filterName),
                            );
                        } catch (Exception $e) {

                        }
                    }

                    $filtersBlock = Engine::GetContentDriver()->getContent('shop-product-list-filters');

                    $filtersBlock->setValue('filtersArray', $a);
                }
            }

            // блок фильтров
            $filterPriceFrom = @$argumentsArray['price-from']; //(float)$this->getControlValue('filterpricefrom');
            $filterPriceTo = @$argumentsArray['price-to']; //(float)$this->getControlValue('filterpriceto');

            // фильтр по весу
            $filterWeightFrom = $connection->escapeString(@str_replace(',', '.', $argumentsArray['weight-from']));
            $filterWeightTo = $connection->escapeString(@str_replace(',', '.', $argumentsArray['weight-to']));

            // фильтр по наличию
            $filterPresence = @$argumentsArray['avail'];

            $filtersBlock = Engine::GetContentDriver()->getContent('shop-product-list-filters');
            $filtersBlock->setValue('currentURL', $this->getValue('currentURL'));
            $filtersBlock->setValue('selectedFilter', $selectedFilter);
            $filtersBlock->setControlValue('filterpricefrom', $filterPriceFrom);
            $filtersBlock->setControlValue('filterpriceto', $filterPriceTo);
            $filtersBlock->setControlValue('filterweightfrom', $filterWeightFrom);
            $filtersBlock->setControlValue('filterweightto', $filterWeightTo);
            $filtersBlock->setControlValue('avail', $filterPresence);
            $this->setValue('filters', $filtersBlock->render());

            // ------------------------------------------------- //

            $cntAfterFilter = $products->getCount();
            // stepper
            $onPage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
            if ($onPage == 0) {
                $onPage = 12;
            }

            if (isset($_COOKIE['cookieOnPage'])) {
                $onPage = $_COOKIE['cookieOnPage'];
            }

            if (@$argumentsArray['onpage']) {
                setcookie(
                    'cookieOnPage',
                    $argumentsArray['onpage'],
                    time() + 60 * 60 * 24 * 30,
                    '/',
                    '.' . Engine::Get()->getConfigField('project-host')
                );
                $onPage = $argumentsArray['onpage'];
            }

            $this->setControlValue('onpage', $onPage);
            $this->setValue('onpage_select', $onPage);

            $p = @$argumentsArray['p']; // $this->getArgumentSecure('p');

            // кнопка "показать все" доступна только для 10xOnpage товаров
            $allowAll = ($cntAfterFilter <= 10 * $onPage);
            $this->setValue('allowAll', $allowAll);

            if ($p == 'all' && !$allowAll) {
                $p = 'all';
            }

            if ($p !== 'all' && !$this->getValue('nostepper')) {
                // страницы
                $stepper = false;
                if (!$products->getLimitCount()) {
                    $stepper = true;
                    $products->setLimit($p * $onPage, $onPage);
                }
            }

            // ------------------------------------------------- //

            // сортировка

            $sort = @$argumentsArray['sort'];

            // Если нет товаров после фильтрации то к товарам без фильтров применяем сортировку price-asc
            if ($this->_productsCount == 0 && !$sort) {
                $sort = 'price-asc';
            }

            if (!$sort && isset($_SESSION['sort'])) {
                $sort = $_SESSION['sort'];
            }

            if (!$sort) {
                try {
                    $sort = Shop::Get()->getShopService()->getCategoryByID($this->getArgumentSecure('id'))->
                    getSortdefault();
                } catch (Exception $e) {
                    $sort = false;
                }
            }

            if (!$sort) {
                $sort = 'ordered';
            }

            $_SESSION['sort'] = $sort;

            $this->setValue('sort', $sort);

            // допустимые сортировки
            $sortsArray = array();
            $sortsArray[] = 'ordered';
            $sortsArray[] = 'name';
            $sortsArray[] = 'price-asc';
            $sortsArray[] = 'price-desc';
            //$sortsArray[] = 'rating';
            $sortsArray[] = 'viewed';
            $sortsArray[] = 'avail';

            if (!in_array($sort, $sortsArray)) {
                $sort = $sortsArray[0];
            }

            // по умолчанию сортировка в обратном порядке
            $sortType = 'DESC';
            if ($sort == 'price-asc') {
                $sort = 'price_product';
                $sortType = 'ASC';
            }
            if ($sort == 'price-desc') {
                $sort = 'price_product';
            }
            if ($sort == 'name') {
                $sortType = 'ASC';
            }

            if (@!$argumentsArray['sort'] && $products->getOrderBy() == '`relevance`') {
                // ничего не делаем если нет сортировки
                // и товары отсортированны по релевантности
                $products;
            } else {
                $products->setOrder($sort, $sortType);
            }

            // ------------------------------------------------- //
            // сортировать по наличию
            if (Shop::Get()->getSettingsService()->getSettingValue('filtering-product-on-presence')) {
                $orderBy = $products->getOrderBy();
                $products->setOrderBy(array('avail DESC', $sort . ' ' . $sortType));
            }

            $this->setValue('totalUrl', Engine::GetURLParser()->getTotalURL());
            $getStr = Engine::GetURLParser()->getGETString(); //echo $getStr;exit;
            $this->setValue('getStr', $getStr);

            // ------------------------------------------------- //

            // вывод товаров
            $a = $this->_getProductsArray($products, $admin, $currencyDefault, $argumentsArray);

            // Если нет такой страници выводим 404
            if (empty($a) && isset($p)) {
                Engine::Get()->getRequest()->setContentNotFound();
                return;
            }

            $this->setValue('productsArray', $a);

            $this->setValue('productsCount', $cntAfterFilter);
        } elseif ($show == 'subcategory') {
            $this->setValue('nofilters', true);

            // подкатегории
            $subcategories = $this->_getSubcategories();

            $subcategoriesArray = array();
            while ($x = $subcategories->getNext()) {
                $childs = Shop::Get()->getShopService()->getCategoriesByParentID($x->getId());
                $childs->setHidden(0);
                $childsArray = array();
                while ($y = $childs->getNext()) {
                    $childsArray[] = array(
                        'name' => $y->makeName(),
                        'url' => $y->makeURL(),
                    );
                }

                if ($x->makeImageThumb()) {
                    $image = $x->makeImageThumb();
                } else {
                    $image = false;
                    $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                    $product->addWhere('image', '', '<>');
                    $product->setLimitCount(1);
                    if ($w = $product->getNext()) {
                        $image = $w->makeImageThumb(100);
                    }
                }

                $subcategoriesArray[] = array(
                    'name' => $x->makeName(),
                    'url' => $x->makeURL(),
                    'image' => $image,
                    'childsArray' => $childsArray
                );
            }

            $this->setValue('subcategoriesArray', $subcategoriesArray);
        } else {
            $this->setValue('nofilters', true);

            // подкатегории
            $subcategories = $this->_getSubcategories();

            $subcategoriesArray = array();
            while ($x = $subcategories->getNext()) {
                $categoryProducts = $x->getProducts();
                $categoryProducts->setHidden(0);
                if (!$admin) {
                    $categoryProducts->setUser_view(1);
                }

                $productArray = array();
                while ($y = $categoryProducts->getNext()) {
                    $info = $y->makeInfoArray(true);
                    $info['orderurl'] = $this->makeURL(array('buy' => $y->getId()));
                    $info['urledit'] = ($admin ? $y->makeURLEdit() : false);
                    $info['discount'] = $y->getDiscount();
                    $info['avail'] = $y->getAvail();
                    $info['availtext'] = trim($y->getAvailtext());
                    $info['canbuy'] = $y->getCanBuy();
                    $info['descriptionshort'] = trim($y->getDescriptionshort());
                    $info['share'] = $y->getShare();
                    $info['priceold'] = $y->makePriceOld($currencyDefault);
                    $info['iconImage'] = $y->makeIcon();

                    $productArray[] = $info;
                }

                if ($x->makeImageThumb()) {
                    $image = $x->makeImageThumb();
                } else {
                    $image = false;
                    $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                    $product->addWhere('image', '', '<>');
                    $product->setLimitCount(1);
                    if ($w = $product->getNext()) {
                        $image = $w->makeImageThumb(200);
                    }
                }

                $subcategoriesArray[] = array(
                    'name' => $x->makeName(),
                    'url' => $x->makeURL(),
                    'image' => $image,
                    'productArray' => $productArray,
                );
            }

            $this->setValue('subcategoryProductArray', $subcategoriesArray);
        }

        // ------------------------------------------------- //

        if (!substr_count($show, 'subcategory')
        && !$this->getValue('nostepper')
        && $p !== 'all'
        ) {
            $ar = array();
            $ar = $this->_pages($p, $onPage, $cntAfterFilter);
            $a = array();
            $a = $ar['pagesArray'];

            // echo'<pre>';print_r($a);echo'</pre>';exit;

            $this->setValue('pagesArray', $a);
            if (isset($ar['urlnext'])) {
                $this->setValue('urlnext', $ar['urlnext']);
            }
            if (isset($ar['all'])) {
                $this->setValue('allpages', $ar['all']);
            }

            if (isset($ar['urlprev'])) {
                $this->setValue('urlprev', $ar['urlprev']);
            }
            if (isset($ar['hellip'])) {
                $this->setValue('hellip', $ar['hellip']);
            }

            // карусели
            $lists = Shop::Get()->getShopService()->getProductsListAll();
            $lists->setHidden(0);
            $lists->setShowtype('carousel');
            $lists->setShowinmain(1);
            $a = array();
            while ($x = $lists->getNext()) {
                try {
                    $l['id'] = $x->getId();
                    $l['name'] = $x->makeName();
                    $l['html'] = $x->render();
                    $a[] = $l;
                } catch (Exception $e) {

                }
            }
            $this->setValue('carouselArray', $a);
        }
    }

    /**
     * MakeNewValueArray
     *
     * @param $newValueArray
     * @param $oldValue
     *
     * @return bool
     */
    private function _makeNewValueArray($newValueArray, $oldValue) {
        if (is_array($oldValue)) {
            $newValueArray = $newValueArray;
            $newValueArray = array_merge($newValueArray, $oldValue);
        } else {
            $newValueArray[] = $oldValue;
        }
        sort($newValueArray);
        return $newValueArray;
    }

    /**
     * Получить массив продуктов для передачи в контент
     *
     * @param ShopProduct $products
     * @param $admin
     * @param $currencyDefault
     *
     * @return array
     */
    private function _getProductsArray(ShopProduct $products, $admin, $currencyDefault, $argumentsArray) {

        /*$showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

        if (!$showNoImageProducts) {
            $products->addWhere('image', '', '<>');
        }*/

        if (!$this->_isProductFiltered($argumentsArray)) {
            $products->addWhere('showincategory', '1', '=');
        }


        $a = array();

        while ($x = $products->getNext()) {
            try {

                $pricesArray = RtmService::Get()->getProductPricesArray($x, $currencyDefault);

                $info = $x->makeInfoArray(true);
                $info['name'] = str_replace($x->getInventarnumber(), '', $x->getName());
                $info['orderurl'] = $this->makeURL(array('buy' => $x->getId()));
                $info['urledit'] = ($admin ? $x->makeURLEdit() : false);
                $info['discount'] = $x->getDiscount();
                $info['avail'] = $x->getAvail();
                
                $optionProducts = new ShopProduct();
                $optionProducts->setSubarticul($x->getSubarticul());
                $optionProducts->addWhere('id', $x->getId(), '<>');
                $optionProducts->setCategoryid($x->getCategoryid());
                $optionProducts->setHidden(0);
                $optionProducts->setDeleted(0);
                $countAvail = 0;
                while ($similarproduct = $optionProducts->getNext()) {
                    if ($similarproduct->getAvail()) {
                        $countAvail++;
                    }
                }
                $info['admin_red'] = ($admin && !$x->getAvail() && !$countAvail) ? 1 : '';
                $info['availtext'] = trim($x->getAvailtext());
                $info['canbuy'] = $x->getCanBuy();
                $info['descriptionshort'] = str_replace('|', '<br />', trim($x->getDescriptionshort()));
                $info['share'] = $x->getShare();
                $info['priceold'] = $pricesArray['priceOld'];
                $info['priceproductold'] = $pricesArray['productPriceOld'];
                $info['iconImage'] = $x->makeIcon();
                $info['canMakePreorder'] = $x->getPreorderDiscount();
                $info['price_product'] = $pricesArray['productPrice'];
                $info['price'] = $pricesArray['price'];

                $filterWeightId = $this->_getFilterIdByName('Вес золота для обмена');

                if ($x->getExchangeweight()) {
                    $weightArr = explode(' ', $x->getExchangeweight());
                    $info['exchangeWeight'] = array(
                        'id' => $filterWeightId, 'name' => $weightArr[0] . '&deg; ' . $weightArr[1] . 'г'
                    );
                }

                try {
                    $info['brandName'] = $x->getBrand()->makeName();
                } catch (Exception $e) {

                }

                $a[] = $info;
            } catch (Exception $e) {

            }
        }

        return $a;
    }

    /**
     * Получить все фильтры со значениями
     *
     * @param $sql
     * @param $connection
     */
    private function _getFiltersArray($sqlAll, $connection) {
        $filtersArray = array();
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $sql = str_replace(
                "`shopproduct`.*", 'DISTINCT(filter' . $j . 'id) AS filterid, filter' . $j .
                'value AS filtervalue, filter' . $j . 'use AS filteruse',
                $sqlAll
            );

            $q = $connection->query($sql);
            while ($x = $connection->fetch($q)) {
                if ($x['filteruse']) {
                    if (!isset($filtersArray[$x['filterid']])) {
                        $filtersArray[$x['filterid']] = array();
                    }
                    if ($x['filtervalue'] !== '') {
                        $filtersArray[$x['filterid']][] = $x['filtervalue'];
                    }
                }
            }
        }

        // Если есть только 1 вариант типа изделия, то не выводим
        $filterTypeId = $this->_getFilterIdByName('Тип изделия');
        if (isset($filtersArray[$filterTypeId]) && count($filtersArray[$filterTypeId]) < 2) {
            unset($filtersArray[$filterTypeId]);
        }

        return $filtersArray;
    }


    /**
     * Применяем фильтры товарам
     *
     * @param $argumentsArray
     * @param $connection
     * @param $products
     *
     * @return ShopProduct
     */
    private function _applyFilters($argumentsArray, $connection, $products, $currencyDefault, $admin) {
        $admin;

        $showNoImageProducts = Shop::Get()->getSettingsService()->getSettingValue('show-nophoto-products');

        try {
            $filterCount = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filterCount = 10;
        }

        if (!$filterCount) {
            $filterCount = 10;
        }


        // фильтр по цене
        $this->setValue('check', false);
        if (@$argumentsArray['check']) {
            $priceNameFilter = 'price';
            $this->setValue('check', true);
        } else {
            $priceNameFilter = 'price_product';
        }
        $filterPriceFrom = @$argumentsArray['price-from']; //(float)$this->getControlValue('filterpricefrom');
        $filterPriceTo = @$argumentsArray['price-to']; //(float)$this->getControlValue('filterpriceto');

        if ($filterPriceFrom > 0) {
            $products->addWhereQuery($priceNameFilter . ' >= ' . $filterPriceFrom);
            $this->setValue('selectedFilter', true);
        }

        if ($filterPriceTo > 0) {
            $filterPriceTo++; // бывают в товара цены с дробями поэтому увеличиваем и берем < dvtcnm <=
            $products->addWhereQuery($priceNameFilter . ' < ' . $filterPriceTo);
            $this->setValue('selectedFilter', true);
        }


        // фильтр по весу
        $filterWeightFrom = $connection->escapeString(@str_replace(',', '.', $argumentsArray['weight-from']));
        $filterWeightTo = $connection->escapeString(@str_replace(',', '.', $argumentsArray['weight-to']));

        if ($filterWeightTo && $filterWeightFrom) {
            $products->addWhereQuery("`weight` BETWEEN {$filterWeightFrom} AND {$filterWeightTo}");
        } else if ($filterWeightTo) {
            $products->addWhereQuery("`weight` <= {$filterWeightTo}");
        } else if ($filterWeightFrom) {
            $products->addWhereQuery("`weight` >= {$filterWeightFrom}");
        }


        // ------------------------------------------------- //

        // фильтр по наличию
        $filterPresence = @$argumentsArray['avail'];
        if ($filterPresence == 'yes') {
            $products->setAvail(1);
        } elseif ($filterPresence == 'no') {
            $products->setAvail(0);
        }

        // ------------------------------------------------- //


        $w0 = array(); // массив ANDов
        $title = array();
        foreach ($argumentsArray as $key => $value) {
            //    if (preg_match("/^filter(\d+)value$/ius", $key, $r)) {
            try {
                @$filterID = $value['filterId']; //$r[1];
                @$filterValue = $value['filterValue'];

                $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);

                if (!is_array($filterValue)) {
                    $filterValue = $filter->getConnectionDatabase()->escapeString($filterValue);
                }

                // накладываем фильтр
                if ($filterValue) {
                    $w1 = array(); // массив OR-ов
                    for ($j = 1; $j <= $filterCount; $j++) {
                        $t = '';
                        if (is_array($filterValue)
                        && ($filter->getType() == 'interval' || $filter->getType() == 'intervalselect' ||
                        $filter->getType() == 'intervalslider')
                        ) {
                            // это интервал-фильтр
                            $filterValueFrom = $connection->escapeString(@$filterValue[0]);
                            $filterValueTo = $connection->escapeString(@$filterValue[1]);

                            $w2 = array(); // массив ANDов для interval-фильтра
                            if ($filterValueFrom) {
                                $w2[] = "CONVERT(filter{$j}value, DECIMAL) >= '$filterValueFrom'";
                                $t .= 'от ' . $filterValueFrom;
                            }
                            if ($filterValueTo) {
                                $w2[] = "CONVERT(filter{$j}value, DECIMAL) <= '$filterValueTo'";
                                $t .= ' до ' . $filterValueTo;
                            }

                            if ($w2) {
                                $w1[] = "(filter{$j}id='$filterID' AND filter{$j}use AND " . implode(' AND ', $w2) .
                                ")";
                            }
                        } elseif (is_array($filterValue)) {
                            // это checkbox/radio фильтр
                            $filterValuesArray = array();
                            foreach ($filterValue as $x) {
                                $filterValuesArray[] = "'" . $connection->escapeString($x) . "'";
                            }
                            $t = implode(', ', $filterValue);
                            $w1[] = "(filter{$j}id='$filterID' AND filter{$j}use AND filter{$j}value IN (" .
                            implode(',', $filterValuesArray) . "))";
                        } else {
                            $t = $filterValue;
                            // иначе это select фильтр
                            $w1[] = "(filter{$j}id='$filterID' AND filter{$j}use AND filter{$j}value='$filterValue')";
                        }
                    }
                    if ($w1) {
                        $w0[] = "(" . implode(' OR ', $w1) . ")";
                    }
                    if ($t) {
                        $title[] = $filter->getName() . ': ' . $t;
                    }
                }
            } catch (Exception $filterEx) {

            }
        }

        if ($w0) {
            $products->addWhereQuery("(" . implode(' AND ', $w0) . ")");
            $selectedFilter = true;
            if ($title) {
                Engine::GetHTMLHead()->setTitle(
                    Engine::GetHTMLHead()->getTitle() . ' | ' . implode('; ', $title) . '.'
                );
            }

            // если наложены фильтры, но нет явного SEO-URL,
            // то ставим meta noindex
            /*if (!$this->_checkSEOForFilter(Engine::GetURLParser()->getCurrentURL())) {
                Engine::GetHTMLHead()->setMetaTag('robots', 'noindex');
            }*/
        }

        // ------------------------------------------------- //

        // ловим фильтр по категории
        $categorySelected = $this->getArgumentSecure('category', 'array');
        foreach ($categorySelected as $key => $value) {
            if (!$value) {
                unset($categorySelected[$key]);
            }
        }
        if ($categorySelected) {
            $products->addWhereArray($categorySelected, 'categoryid');
            $selectedFilter = true;
        }

        // ------------------------------------------------- //

        // ловим фильтр по брендам
        $brandSelected = $this->getArgumentSecure('brand', 'array');
        foreach ($brandSelected as $key => $value) {
            if (!$value) {
                unset($brandSelected[$key]);
            }
        }
        if ($brandSelected) {
            $products->addWhereArray($brandSelected, 'brandid');
            $selectedFilter = true;
        }

        // получаем максимальную цену
        $maxprice = Shop::Get()->getShopService()->getProductMaxPrice(clone $products, $currencyDefault);

        $prMaxPriceProduct = clone $products;
        $prMaxPriceProduct->leftJoinTable(
            $currencyDefault->getTablename(), 'currencyid=' . $currencyDefault->getTablename() . '.id'
        );
        $prMaxPriceProduct->addFieldQuery(
            ' (price_product / ' . $currencyDefault->getRate() . ' * ' .
            $currencyDefault->getTablename() . '.rate ) as pr'
        );
        $prMaxPriceProduct->setLimitCount(1);
        $prMaxPriceProduct->setOrder(array('`price_product` DESC'));
        if ($p = $prMaxPriceProduct->getNext()) {
            $maxProductPrice = $p->makePriceProduct($currencyDefault);
        } else {
            $maxProductPrice = 0;
        }

        $maxWeight = RtmService::Get()->getProductMaxWeight(clone $products);

        $filtersBlock = Engine::GetContentDriver()->getContent('shop-product-list-filters');
        $filtersBlock->setValue('maxprice', $maxprice);
        $filtersBlock->setValue('maxProductPrice', $maxProductPrice);
        $filtersBlock->setValue('maxWeight', $maxWeight);

        // ------------------------------------------------- //

        /* if (!$showNoImageProducts) {
             $products->addWhere('image', '', '<>');
         }*/

        $this->_sqlAll = $products->__toString();

        if (!$this->_isProductFiltered($argumentsArray)) {
            $products->addWhere('showincategory', '1', '=');
        }


        // echo $products;exit;

        return $products;
    }

    /**
     * Проверяем применялись ли фильтры к товару
     *
     * @param $argumentsArray
     *
     * @return bool
     */
    private function _isProductFiltered($argumentsArray) {

        $notFiltersArray = array('filter', 'sort', 'p', 'onpage');

        foreach ($argumentsArray as $key => $value) {
            if (!in_array($key, $notFiltersArray) && (is_numeric($key) && is_array($value) || $key == 'sizes')) {
                return true;
            }
        }

        return false;

    }


    private function _pages($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        $currentURL = $this->getValue('currentURL'); // url категории

        $fullUrl = Engine::GetURLParser()->getCurrentURL(); // полный url

        $filter = false;
        $addLink = true;
        if (strpos($fullUrl, '/filter') !== false) {
            $filter = explode('_', $fullUrl);
            $filter = count($filter);
            // Если есть фильтра, не добавляем каноническую ссылку
            if (strpos($fullUrl, 'p=') !== false && $filter > 2 || strpos($fullUrl, 'p=') === false) {
                $addLink = false;
            }
        }

        for ($j = 0; $j < $cnt; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                // Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $j)),
                'url' => $filter ? $this->_makeFiltersUrl('p=', $fullUrl, 'p=' . $j) : $currentURL . '/filter_p=' . $j,
                'selected' => $j == $page,
                'visible' => (($j > $start) && ($j < $stop)) ? true : false,
                'always_open' => ($j == 0 || ($j == ($cnt - 1))) ? true : false,
            );
        }

        $assignsArray['pagesArray'] = $a;

        if ($page + 1 < $cnt) {
            $tmpPage = $page + 1;
            // Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $page + 1));
            $assignsArray['urlnext'] = $filter ? $this->_makeFiltersUrl('p=', $fullUrl, 'p=' . $tmpPage) :
            "{$currentURL}/filter_p={$tmpPage}";
            if ($addLink) {
                Engine::GetHTMLHead()->addLink('next', "{$currentURL}/filter_p={$tmpPage}");
            }
        }

        if ($page - 1 >= 0) {
            $tmpPage = $page - 1;
            // Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => $page - 1));
            $assignsArray['urlprev'] = $filter ? $this->_makeFiltersUrl('p=', $fullUrl, 'p=' . $tmpPage) :
            "{$currentURL}/filter_p={$tmpPage}";
            if ($addLink) {
                $tmpPage == 0 ? $urlPrev = $currentURL : $urlPrev = "{$currentURL}/filter_p={$tmpPage}";

                Engine::GetHTMLHead()->addLink('prev', $urlPrev);
            }
        }

        $assignsArray['all'] = $filter ? $this->_makeFiltersUrl('p=', $fullUrl, 'p=all') : $currentURL
        . '/filter_p=all'; // Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('p' => 'all'));


        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

    /**
     * MakeFiltersUrl
     *
     * @param $filter
     * @param $url
     * @param $value
     *
     * @return string
     */
    private function _makeFiltersUrl($filter, $url, $value) {

        $oldFiltersArray = explode('_', $url);
        $newFiltersArray = array();

        $findValue = false;
        // Меняем старые значения filter
        $cnt = count($oldFiltersArray);
        for ($index = 0; $index < $cnt; ++$index) {
            if (strpos($oldFiltersArray[$index], $filter) !== false) {
                $newFiltersArray[$index] = $value;
                $findValue = true;
            } else {
                $newFiltersArray[$index] = $oldFiltersArray[$index];
            }
        }
        // Если не нашли старых, добавляем в конец новое значение.
        if (!$findValue) {
            $newFiltersArray[$index] = $value;
        }

        return implode('_', $newFiltersArray);

    }

    private function _toFloat($x) {
        return (float) $x;
    }

    private function _mySort($ar, $fieldName = 'name') {
        $this->_fieldName = $fieldName;
        usort($ar, array($this, '_myCmp'));
        return $ar;
    }

    private function _myCmp($a, $b) {
        if (@$a[$this->_fieldName] == @$b[$this->_fieldName]) {
            return 0;
        }
        return (@$a[$this->_fieldName] < @$b[$this->_fieldName]) ? -1 : 1;
    }

    /**
     * Сортировать значения как числовые
     *
     * @param string $a
     * @param string $b
     *
     * @return bool
     */
    private function _sortFilterValuesAsNumbers($a, $b) {
        $a = (float) preg_replace("/[^0-9]/ius", '.', $a);
        $b = (float) preg_replace("/[^0-9]/ius", '.', $b);
        return $a > $b;
    }

    /**
     * Проверить, есть ли по указанному URL какие-либо SEO-примочки
     *
     * @param string $url
     *
     * @return bool
     */
    private function _checkSEOForFilter($url) {
        $url = parse_url($url);
        $url = @$url['path'];

        try {
            SEOService::Get()->getSEOByURL($url);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     *  Получить значения фильтров по урл
     *
     * @return array
     */
    private function _getFiltersArguments() {
        // массив типов фильтров для которых нет записей в БД
        $filterTypesWithoutRecords = array('p', 'sort', 'onpage', 'check');

        if (empty($this->_filtersArray)) {
            if (isset($_COOKIE['product-list-url'])) { // Мягкая пагинация
                $url = $_COOKIE['product-list-url'];
                unset($_COOKIE['product-list-url']);
                setcookie('product-list-url', '', time() - 3600, '/');
            } else {
                $url = Engine::GetURLParser()->getCurrentURL();
            }

            $a = explode('_', $url);
            $filtersArray = array();
            foreach ($a as $filter) {
                if (strpos($filter, 'filter') !== false) {
                    $filtersArray['filter'] = 1; // есть фильтра
                    continue;
                }

                if (strpos($filter, '=') !== false) { // фильтры с =
                    list($filterType, $filterValue) = explode('=', $filter);

                    if (strpos($filterValue, ',') !== false) {
                        $tmpArr = explode(',', $filterValue);

                        $a = array();
                        $filterId = 0;
                        foreach ($tmpArr as $filter) {
                            try {
                                $x = new XFilterValue2Url();
                                $x->setUrl($filter);
                                if ($x->select()) {
                                    $value = $x->getValue();
                                    $a[] = $value;
                                    $filterId = $x->getFilterid();
                                    $filtersArray[$value] = $value; // Для массива selected
                                }

                            } catch (Exception $e) {

                            }
                        }

                        $filtersArray[$filterType] = array(
                            'filterId' => $filterId,
                            'filterValue' => $a
                        );
                    } else {
                        if (strpos($filterType, 'price') === false && strpos($filterType, 'weight') === false &&
                        !in_array($filterType, $filterTypesWithoutRecords)
                        ) {
                            try {
                                $x = new XFilterValue2Url();
                                $x->setUrl($filterValue);
                                if ($x->select()) {
                                    $filtersArray[$x->getValue()] = array(
                                        'filterId' => $x->getFilterid(),
                                        'filterValue' => $x->getValue()
                                    );
                                }
                            } catch (Exception $e) {

                            }
                        } else {
                            if (strpos($filterType, 'weight') !== false) {
                                // меняем - для веса на .
                                $filtersArray[$filterType] = str_replace('-', '.', $filterValue);
                            } else {
                                $filtersArray[$filterType] = $filterValue;
                            }
                        }
                    }

                } else {
                    try {
                        $x = new XFilterValue2Url();
                        $x->setUrl($filter);
                        if ($x->select()) {
                            $filtersArray[$x->getValue()] = array(
                                'filterId' => $x->getFilterid(),
                                'filterValue' => $x->getValue()
                            );
                        }
                    } catch (Exception $e) {

                    }
                }


            }
            $this->_filtersArray = $filtersArray;
        }

        return $this->_filtersArray;

    }

    /**
     * ColorToRu
     *
     * @param $color
     *
     * @return mixed
     */
    private function _colorToRu($color) {
        $color = trim($color);
        $colorArray = array(
            'black' => 'черный',
            'white' => 'белый',
            'brown' => 'коричневый',
            'green' => 'зеленый',
            'yellow' => 'желтый',
            'purple' => 'фиолетовый',
            'red' => 'красный',
            'dark-blue' => 'синий',
            'blue' => 'голубой',
            'grey' => 'серый'
        );
        return @$colorArray[$color];
    }

    /**
     * ColorToEn
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

    /**
     * GetObjectByName
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
     * GetFilterIdByName
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

    private function _getTotalUrl() {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }

        return rtrim($h . Engine::Get()->getProjectHost() . Engine::GetURLParser()->getTotalURL(), '/');
    }

    private $_sqlAll = '';

    private $_productsCount = 0;

    private $_tmpFiltersArray = array();

    private $_filtersArray = array();

    private $_fieldName = 'name';

}