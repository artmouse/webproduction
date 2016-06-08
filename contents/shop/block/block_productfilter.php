<?php
class block_productfilter extends Engine_Class {

    public function process() {
        // фильтра обрабатываются в два прохода.
        // если уже была обработка - то ничего делать не надо.
        if ($this->_processed) {
            return;
        }

        $pathH1 = false;

        // Получаем соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $products = $this->_getProducts();
        $currencyDefault = $this->getValue('currencyDefault');

        // если ничего не передано - то рендерить ничего не надо
        // это lifehack для движка, без HTML не запускается smarty
        if (!$products || !$currencyDefault) {
            $this->setField('filehtml', '');
            return;
        }

        // не знаю зачем это тут, но видимо кто-то умудрился вызвать
        // этот блок и не передать сюда $products
        if (!$products) {
            return;
        }

        $productsWithFilters = clone $products;

        // количество товаров с без фильтров
        $this->setValue('productCountWithOutFilters', $productsWithFilters->getCount());

        // фильтр по цене
        // разрешено править только senior'ам
        $filterPriceFrom = (float) $this->getControlValue('filterpricefrom');
        $filterPriceTo = (float) $this->getControlValue('filterpriceto');

        /*if ($filterPriceFrom > 0 || $filterPriceTo > 0) {
            // join-им таблицу rates
            $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $productsWithFilters->leftJoinTable(
                $currency->getTablename(),
                'currencyid=' . $currency->getTablename() . '.id'
            );
        }*/

        if ($filterPriceFrom > 0) {
            // то что ввел юзер, нужно конвертировать в валюту товара
            /*$productsWithFilters->addWhereQuery(
                'price >= (' . $filterPriceFrom . ' * ' .
                $currencyDefault->getRate() . ' / ' .
                $currency->getTablename() . '.rate )'
            );*/
            $productsWithFilters->addWhere('pricesell', $filterPriceFrom, '>=');
        }

        if ($filterPriceTo > 0) {
            // то что ввел юзер, нужно конвертировать в валюту товара
            /*$productsWithFilters->addWhereQuery(
                'price <= (' . $filterPriceTo . ' * ' .
                $currencyDefault->getRate() . ' / ' .
                $currency->getTablename() . '.rate )'
            );*/
            $productsWithFilters->addWhere('pricesell', $filterPriceTo, '<=');
        }

        // убираем пагинацию
        $currentURL = $this->getValue('currentURL');
        $currentURL = preg_replace("/\/p-(\d+)\//ius", '/', $currentURL);
        $this->setValue('currentURL', $currentURL);

        $a = 0;
        $b = $this->getValue('maxPrice');

        $tmp = $this->getControlValue('filterpricefrom');
        if ($tmp) {
            $a = $tmp;
        }

        $tmp = $this->getControlValue('filterpriceto');
        if ($tmp) {
            $b = $tmp;
        }

        $this->setValue('filterpricefrom_value', $a);
        $this->setValue('filterpriceto_value', $b);

        // Накладываем по наличию
        $filterPresence = $this->getControlValue('filterpresence');
        if ($filterPresence == 'yes') {
            $productsWithFilters->addWhere('avail', 0, '>');
        } elseif ($filterPresence == 'no') {
            $productsWithFilters->setAvail(0);
        }

        $filterSelectedCountArray = array();

        // получаем FVC фильтров ДО наложения самих фильтров
        $this->_fvc1 = $this->_makeFVC($productsWithFilters);

        // массив ANDов для всех фильтров, включая категории и бренды
        $whereArray = array();

        // Нкаладываем фильтр по категории
        $categorySelected = $this->getArgumentSecure('category', 'array');
        foreach ($categorySelected as $key => $value) {
            if (!$value) {
                unset($categorySelected[$key]);
            }
        }

        if (count($categorySelected) == 1) {
            try {
                $category = Shop::Get()->getShopService()->getCategoryByID(
                    $categorySelected[0]
                );

                Engine::GetHTMLHead()->setTitle($category->getName() . '. ' . Engine::GetHTMLHead()->getTitle());

                $content = Engine::GetContentDriver()->getContent('shop-product-list');
                $pathArray = $content->getValue('pathAdditionalArray');
                if (!$pathArray) {
                    $pathArray = array();
                }
                $pathArray[] = array(
                'name' => $category->makeName(),
                'url' => Engine::GetURLParser()->getCurrentURL(),
                );

                $pathH1 = $content->getValue('pathAdditionalH1');
                $pathH1 .= ' '.$category->makeName();

                $content->setValue('pathAdditionalArray', $pathArray);
                $content->setValue('pathAdditionalH1', $pathH1);
            } catch (Exception $categoryEx) {

            }
        }
        if ($categorySelected) {
            $whereArray['categoryid'] = "categoryid IN (".implode(',', $categorySelected).")";

            // запоминаем фильтра которые выбраны
            $filterSelectedCountArray[-2] = $categorySelected;
        }


        // Накладываем фильтр по брендам
        $brandSelected = $this->getArgumentSecure('brand', 'array');
        foreach ($brandSelected as $key => $value) {
            if (!$value) {
                unset($brandSelected[$key]);
            }
        }
        if (count($brandSelected) == 1) {
            try {
                $brand = Shop::Get()->getShopService()->getBrandByID(
                    $brandSelected[0]
                );

                Engine::GetHTMLHead()->setTitle($brand->getName() . '. ' . Engine::GetHTMLHead()->getTitle());

                $content = Engine::GetContentDriver()->getContent('shop-product-list');
                $pathArray = $content->getValue('pathAdditionalArray');
                if (!$pathArray) {
                    $pathArray = array();
                }

                $pathArray[] = array(
                'name' => $brand->makeName(),
                'url' => Engine::GetURLParser()->getCurrentURL(),
                );

                $pathH1 = $content->getValue('pathAdditionalH1');
                $pathH1 .= ' '.$brand->makeName();

                $content->setValue('pathAdditionalArray', $pathArray);
                $content->setValue('pathAdditionalH1', $pathH1);
            } catch (Exception $categoryEx) {

            }
        }
        if ($brandSelected) {
            $whereArray['brandid'] = "brandid IN (".implode(',', $brandSelected).")";

            // запоминаем фильтра которые выбраны
            $filterSelectedCountArray[-1] = $brandSelected;
        }

        // ловим и накладываем (применяем) фильтры
        $selectedFilterArray = array();
        $argumentsArray = $this->getArguments();
        $titleArray = array();
        $h1Array = array();
        foreach ($argumentsArray as $key => $value) {
            if (preg_match("/^filter(\d+)value$/ius", $key, $r)) {
                try {
                    $filterValue = $value;

                    $filter = Shop::Get()->getShopService()->getProductFilterByID($r[1]);

                    if (!is_array($filterValue)) {
                        $filterValue = $connection->escapeString($filterValue);
                    }

                    // накладываем фильтр
                    if (!$filterValue) {
                        continue;
                    }

                    $isIntervalFilter = ($filter->getType() == 'interval'
                        || $filter->getType() == 'intervalselect'
                        || $filter->getType() == 'intervalslider'
                    );

                    $w1 = array(); // массив OR-ов
                    $t = '';
                    if (is_array($filterValue) && $isIntervalFilter) {
                        // это интервал-фильтр
                        $filterValueFrom = $connection->escapeString(@$filterValue[0]);
                        $filterValueTo = $connection->escapeString(@$filterValue[1]);

                        $w2 = array(); // массив ANDов для interval-фильтра
                        if ($filterValueFrom) {
                            $w2[] = "CONVERT(filtervalue, DECIMAL(10,2)) >= '$filterValueFrom'";
                            $t .= Shop::Get()->getTranslateService()->getTranslateSecure('translate_ot_')
                                . $filterValueFrom;
                        }
                        if ($filterValueTo) {
                            $w2[] = "CONVERT(filtervalue, DECIMAL(10,2)) <= '$filterValueTo'";
                            $t .= ' до ' . $filterValueTo;
                        }

                        if ($w2) {
                            $tmp = new XShopProductFilterValue();
                            $tmp->setFilterid($filter->getId());
                            $tmp->addWhereQuery(implode(' AND ', $w2));
                            $productIDArray = array(-1);
                            while ($xtmp = $tmp->getNext()) {
                                $productIDArray[] = $xtmp->getProductid();
                            }

                            $w1[] = "shopproduct.id IN (".implode(',', $productIDArray).")";
                        }
                    } elseif (is_array($filterValue)) {
                        // это checkbox/radio фильтр
                        $filterValuesArray = array();
                        foreach ($filterValue as $x) {
                            if (!$x) {
                                continue;
                            }
                            $filterValuesArray[] = $x;
                        }

                        if ($filterValuesArray) {
                            $t = implode(', ', $filterValue);

                            $tmp = new XShopProductFilterValue();
                            $tmp->setFilterid($filter->getId());
                            $tmp->addWhereArray($filterValuesArray, 'filtervalue');
                            $productIDArray = array(-1);
                            while ($xtmp = $tmp->getNext()) {
                                $productIDArray[] = $xtmp->getProductid();
                            }

                            $w1[] = "shopproduct.id IN (".implode(',', $productIDArray).")";
                        }
                    } else {
                        // иначе это select фильтр
                        $t = $filterValue;

                        $tmp = new XShopProductFilterValue();
                        $tmp->setFilterid($filter->getId());
                        $tmp->setFiltervalue($filterValue);
                        $productIDArray = array(-1);
                        while ($xtmp = $tmp->getNext()) {
                            $productIDArray[] = $xtmp->getProductid();
                        }

                        $w1[] = "shopproduct.id IN (".implode(',', $productIDArray).")";
                    }

                    if ($w1) {
                        $whereArray[$filter->getId()] = implode(' ', $w1);

                        // запоминаем фильтра которые выбраны
                        $filterSelectedCountArray[$filter->getId()][] = $filterValue;
                    }

                    if ($t) {
                        $titleArray[] = $filter->getName() . ': ' . $t;
                        $h1Array[] = $t;
                    }
                } catch (Exception $filterEx) {

                }
            }
        }

        // товары перед накладыванием фильтров
        // все что наложено - это фильтр по цене/наличию
        $productsWithFiltersClean = clone $productsWithFilters;

        if ($whereArray) {
            $productsWithFilters->addWhereQuery("(" . implode(' AND ', $whereArray) . ")");

            // если есть что в заголовке
            if ($titleArray) {
                Engine::GetHTMLHead()->setTitle(implode('. ', $titleArray) . '. ' . Engine::GetHTMLHead()->getTitle());

                $content = Engine::GetContentDriver()->getContent('shop-product-list');
                $pathArray = $content->getValue('pathAdditionalArray');
                if (!$pathArray) {
                    $pathArray = array();
                }

                $pathH1 = $content->getValue('pathAdditionalH1');
                $pathH1 .= ' '.implode(', ', $h1Array);

                $pathArray[] = array(
                'name' => implode('. ', $titleArray),
                'url' => Engine::GetURLParser()->getCurrentURL(),
                );
                $content->setValue('pathAdditionalArray', $pathArray);
                $content->setValue('pathAdditionalH1', $pathH1);
            }
        }

        // количество товаров с наложенными фильтрами
        $productCountWithFilter = $productsWithFilters->getCount();
        $this->setValue('productCountWithFilter', $productCountWithFilter);

        // строим фильтра (2) после того как все применено
        if (count(array_keys($filterSelectedCountArray)) > 0) {
            $this->_fvc2 = $this->_makeFVC($productsWithFilters);
        }

        // для всех фильтров больше двух, то строим FVC (3)
        if (count(array_keys($filterSelectedCountArray)) >= 2) {

            // строим FVC2 для каждого выбранного фильтра
            foreach ($filterSelectedCountArray as $filterID => $filterValue) {
                // берем все товары без фильтров (но с фильтром по брендам и категориям)
                $tmpProducts = clone $productsWithFiltersClean;

                // строим новые WHERE
                $tmpWhere = $whereArray;
                unset($tmpWhere[$filterID]);

                // накладываем
                $tmpProducts->addWhereQuery("(" . implode(' AND ', $tmpWhere) . ")");

                $fvc = $this->_makeFVC($tmpProducts);
                $this->_fvc3[$filterID] = $fvc;
            }
        }

        // массив фильтров, который применен
        $filterSelectedArray = array();

        // фильтр по категориям
        if ($this->getValue('filtercategory') && !empty($this->_fvc1[-2])) {
            // получаем список всех категорий
            $categorySelected = $this->getArgumentSecure('category');

            $a = array();
            foreach ($this->_fvc1[-2] as $categoryID => $count) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                        $categoryID
                    );

                    if ($category->getHidden()) {
                        continue;
                    }

                    $isSelected = @in_array($category->getId(), $categorySelected);

                    $count = $this->_makeFilterCount(-2, $categoryID, $categorySelected);

                    $a[] = array (
                    'id' => $category->getId(),
                    'name' => $category->makeName(),
                    'url' => $category->getUrl(),
                    'selected' => $isSelected,
                    'count' => $count,
                    );

                    if (@in_array($category->getId(), $categorySelected)) {
                        $filterSelectedArray[
                            Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category')
                        ][] = array(
                            'name' => $category->makeName(),
                            'deleteUrl' => $this->_createUrlDeleteFilter('category', $category->getId())
                        );
                    }
                } catch (Exception $categoryEx) {

                }
            }

            $this->setValue('categoryArray', $this->_mySort($a));
        }

        // фильтр по брендам
        if ($this->getValue('filterbrand') && !empty($this->_fvc1[-1])) {
            // получаем список всех брендов
            $brandSelected = $this->getArgumentSecure('brand', 'array');

            $a = array();
            foreach ($this->_fvc1[-1] as $brandID => $count) {
                try {
                    $brand = Shop::Get()->getShopService()->getBrandByID(
                        $brandID
                    );

                    if ($brand->getHidden()) {
                        continue;
                    }

                    $isSelected = @in_array($brand->getId(), $brandSelected);

                    $count = $this->_makeFilterCount(-1, $brand->getId(), $brandSelected);

                    $a[] = array (
                    'id' => $brand->getId(),
                    'name' => $brand->makeName(),
                    'url' => $brand->getUrl(),
                    'selected' => $isSelected,
                    'count' => $count,
                    );

                    if (@in_array($brand->getId(), $brandSelected)) {
                        $brandTranslate = Shop::Get()->getTranslateService()->getTranslateSecure('translate_brand');
                        $filterSelectedArray[$brandTranslate][] = array(
                            'name' => $brand->makeName(),
                            'deleteUrl' => $this->_createUrlDeleteFilter('brand', $brand->getId())
                        );
                    }
                } catch (Exception $brandEx) {

                }
            }
            $this->setValue('brandArray', $this->_mySort($a));
        }

        // строим вывод фильтров
        if ($this->getValue('filtervalue')) {
            $sortFilterArray = false;

            $a = array();
            foreach ($this->_fvc1 as $filterID => $filterValuesArray) {
                $filterValuesArray = array_keys($filterValuesArray);

                try {
                    $filter = Shop::Get()->getShopService()->getProductFilterByID($filterID);

                    // скрытые фильтра пропускаем
                    if ($filter->getHidden()) {
                        continue;
                    }

                    // тип сортировки
                    if ($filter->getSorttype()) {
                        // сортировать как числа
                        uasort($filterValuesArray, array($this, '_sortFilterValuesAsNumbers'));
                    } else {
                        // обычная сортировка
                        asort($filterValuesArray);
                    }

                    // выделенные элементы данного фильтра
                    $selectedArray = $this->getArgumentSecure('filter' . $filter->getId() . 'value', 'array');

                    foreach ($filterValuesArray as $index => $filterValue) {
                        // выбран ли этот фильтр?
                        $isSelected = in_array($filterValue, $selectedArray);

                        // дописываем фильтр в выбранный
                        if ($isSelected) {
                            $filterSelectedArray[$filter->getName()][] = array(
                            'name' => $filterValue,
                            'deleteUrl' => $this->_createUrlDeleteFilter("filter{$filter->getId()}value", $filterValue)
                            );
                        }

                        $count = $this->_makeFilterCount(
                            $filter->getId(),
                            $filterValue,
                            isset($filterSelectedCountArray[$filterID])
                        );

                        $filterValuesArray[$index] = array(
                        'value' => $filterValue,
                        'name' => htmlspecialchars($filterValue),
                        'url' => "filter{$filter->getId()}=" . urlencode($filterValue) . '/',
                        'selected' => @in_array($filterValue, $selectedArray),
                        'count' => $count,
                        );
                    }

                    // определение min & max
                    $min = false;
                    $max = false;
                    foreach ($filterValuesArray as $x) {
                        if (!is_numeric($x['value'])) {
                            continue;
                        }

                        if (!$min || $x['value'] < $min) {
                            $min = $x['value'];
                        }
                        if (!$max || $x['value'] > $max) {
                            $max = $x['value'];
                        }
                    }
                    if ($filter->getSort()) {
                        $sortFilterArray = true;
                    }

                    $a[] = array(
                    'name' => htmlspecialchars($filter->getName()),
                    'id' => $filter->getId(),
                    'type' => $filter->getType(),
                    'sort' => $filter->getSort(),
                    'valuesArray' => $filterValuesArray,
                    'valueMin' => round($min, 2),
                    'valueMax' => round($max, 2),
                    'selectedArray' => $selectedArray,
                    );
                } catch (Exception $filterEx) {

                }
            }

            if ($sortFilterArray) {
                function compare($v1, $v2) {
                    if ($v1['sort'] == $v2['sort']) {
                        return strcasecmp($v1['name'], $v2['name']);
                    }
                    if (!$v1['sort'] || !$v2['sort']) {
                        if (!$v1['sort']) {
                            return 1;
                        } else {
                            return -1;
                        }
                    }

                    return ($v1['sort'] < $v2['sort']) ? -1:1;
                }

                uasort($a, 'compare');
            }
            $this->setValue('filtersArray', $a);
        }
        $this->setValue('filterSelectedArray', $filterSelectedArray);
        $this->setValue('productsWithFilter', $productsWithFilters);
        $this->setValue('urlWithoutFilters', $this->_urlWithoutFilters);
        $this->setValue('titleH1', htmlspecialchars($this->getValue('titleH1').' '.$pathH1));

        $this->_processed = true;
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
        $a = str_replace(',', '.', $a);
        $b = str_replace(',', '.', $b);
        $a = (float) preg_replace("/[^0-9|.|,]/ius", '', $a);
        $b = (float) preg_replace("/[^0-9|.|,]/ius", '', $b);
        return $a > $b;
    }

    private function _createUrlDeleteFilter ($filterId, $filterValue) {

        $replace = array("&{$filterId}[]={$filterValue}","&{$filterId}={$filterValue}");
        $deleteUrl = str_replace(
            $replace,
            '',
            urldecode(Engine::Get()->GetURLParser()->getCurrentURL())
        );
        
        // если фильтр первый в списке, то & не будет
        $deleteUrl = str_replace(
            "?{$filterId}[]={$filterValue}",
            '?',
            $deleteUrl
        );

        // если за первым фильтром шел еще 1, будет лишний &, после ?
        $deleteUrl = str_replace(
            "?&",
            '?',
            $deleteUrl
        );

        $filterId = str_replace('value', '', $filterId); // filter{id}value => filter{id}

        $this->_createUrlDeleteAllFilters($filterId, $filterValue);
        $deleteUrl =  str_replace(
            "{$filterId}={$filterValue}/",  
            '',
            $deleteUrl
        );

        return $deleteUrl;
    }

    /**
     * Удаляет статические значения фильтров из урла
     * @param $filterId
     * @param $filterValue
     */
    private function _createUrlDeleteAllFilters($filterId, $filterValue) {
        if ($this->_urlWithoutFilters === '') {
            $this->_urlWithoutFilters = urldecode(Engine::Get()->GetURLParser()->getTotalURL());
            // удаляет пагинацию
            $this->_urlWithoutFilters = preg_replace("/\/p-(\d+)\//ius", '/', $this->_urlWithoutFilters);
        }

        $this->_urlWithoutFilters =  str_replace(
            "{$filterId}={$filterValue}/",
            '',
            $this->_urlWithoutFilters
        );
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
     * Построить массив FilterValueCount (FVC) на основе выбранных продуктов
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    private function _makeFVC(ShopProduct $product) {
        // соединение с БД
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $whereString = $product->makeWhereString();

        // Внимание! Специально сокращаем fvc, чтобы экономить память
        // на ассоциативных массивах
        $query = "
        SELECT
            filterid AS f,
            filtervalue AS v,
            COUNT(filtervalue) AS c
        FROM shopproductfiltervalue
        JOIN shopproduct ON
        shopproduct.id=productid
        WHERE {$whereString} AND filteruse = 1 AND filtervalue <> ''
        GROUP BY filterid, filtervalue";

        $a = array();
        $q = $connection->query($query);
        while ($x = $connection->fetch($q)) {
            $a[$x['f']][$x['v']] = $x['c'];
        }

        return $a;
    }

    /**
     * Построить количество фильтров для данного значения
     *
     * @param string $key
     * @param string $value
     * @param bool $isSelected
     *
     * @return int
     */
    private function _makeFilterCount($key, $value, $isSelected) {
        /**
         * Структура данных в FVC:
         *
         * Поле key - id фильтра. -1 для брендов, -2 для категорий.
         * Поле value - конкретное значение заданного фильтра.
         * isSelected - отфильтрован ли сейчас фильтр key=value?
         * Если да - то показывать "+" перед значениями.
         */

        if ($this->_fvc3 && $isSelected) {
            $result = @$this->_fvc3[$key][$key][$value];
        } elseif ($this->_fvc2) {
            // если выбран этот фильтр - то надо показывать плюсики
            if ($isSelected) {
                $a = @$this->_fvc2[$key][$value];
                $b = @$this->_fvc1[$key][$value];
                $result = $b - $a;
            } else {
                // иначе просто значение
                $result = @$this->_fvc1[$key][$value];
            }
        } else {
            $result = @$this->_fvc1[$key][$value];
        }

        $result = (int) $result;
        if ($result <= 0) {
            $result = 0;
        }

        if ($result > 0 && $isSelected) {
            $result = '+'.($result);
        }

        return $result;
    }

    /**
     * Получить продукты, которые были переданы в этот контент
     *
     * @return ShopProduct
     */
    protected function _getProducts() {
        return $this->getValue('products');
    }

    private $_urlWithoutFilters = ''; // урл без фильтров

    /**
     * FVC для товаров без фильтров
     *
     * @var string
     */
    private $_fvc1 = array();

    private $_fvc2 = array();

    private $_fvc3 = array();

    private $_processed = false;

}