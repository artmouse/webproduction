<?php
class shop_product_list extends Engine_Class {

    /**
     * Получаем ShopProduct
     *
     * @return ShopProduct
     */
    protected function _getItemsAll() {
        $x = $this->getValue('items');
        $no_hidden_regulate = $this->getValue('no_hidden_regulate');
        if (!$no_hidden_regulate) {
            $x->setHidden(0);
            $x->setDeleted(0);
        }
        return $x;
    }

    public function process() {
        // Подключаем библиотеки, и устанавливаем Title
        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        $this->setValue('storeTitle', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));

        if ($user = $this->getUserSecure()) {
            $this->setValue('isAdmin', $user->isAdmin());
        }

        // Телефоны для отображения ошибки
        $phones = trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-phone')));
        $phones = explode(',', $phones);
        $phonesCount = count($phones) + 1;
        for ($i = 1; $i < $phonesCount; $i++) {
            $this->setValue("phone$i", $phones[$i - 1]);
        }

        // Это категория или нет?
        $isCategory = $this->getValue('category');

        // способ отображения по умолчанию
        $show = $this->getValue('showtype');
        $show = str_replace('only', '', $show);
        if ($show == 'tableonly') {
            $show = 'table';
        }
        if ($show == 'subcategory') {
            if (!$this->getValue('subcategories')) {
                $show = 'thumbs';
            } elseif (!$this->getValue('subcategories')->getCount()) {
                $show = 'thumbs';
            }
        }
        if (!$show) {
            $show = 'thumbs';
        }
        $this->setValue('show', $show);

        // получаем товары
        $products = $this->_getItemsAll();

        // определяем способ отобажения
        try {
            $showContainer = Engine::GetContentDriver()->getContent('shop-product-list-' . $show);
        } catch (Exception $showEx) {
            $show = 'thumbs';
            $showContainer = Engine::GetContentDriver()->getContent('shop-product-list-' . $show);
        }

        // узнаем что нужно показывать, а что нет
        $showPages = $showContainer->getValue('showPages');
        $showFilters = $showContainer->getValue('showFilters');
        $showSort = $showContainer->getValue('showSort');

        // показываем только в нужных контентах
        $contentId = Engine::Get()->getRequest()->getContentID();

        if ($contentId != 'shop-brand'
            && $contentId != 'shop-category'
            && $contentId != 'shop-search'
            && $contentId != 'shop-tag'
            && $contentId != 'shop-client-products-viewed'
            && $contentId != 'shop-client-products-ordered'
            && $contentId != 'shop-product-list-ajax'
            && $contentId != '404-product'
            && $contentId != '404-category'
        ) {
            $showFilters = false;
            $showSort = false;
        }

        // Показываем или не показываем фильтра, в зависимости от настроек магазина.
        if (!Shop::Get()->getSettingsService()->getSettingValue('show-filters')) {
            $showFilters = false;
        }

        if ($this->getValue('nostepper')) {
            $showPages = false;
        }

        $this->setValue('showFilters', $showFilters);
        $this->setValue('showPages', $showPages);
        $this->setValue('showSort', $showSort);

        // обработка фильтрации
        if ($showFilters) {
            // блок фильтров
            $filtersBlock = Engine::GetContentDriver()->getContent('block-productfilter');

            // получение дефолтной валюты
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            // получаем максимальную цену
            $filtersBlock->setValue(
                'maxPrice',
                Shop::Get()->getShopService()->getProductMaxPrice(clone $products, $currencyDefault)
            );
            $filtersBlock->setValue('products', clone $products);
            $filtersBlock->setValue('filtercategory', $this->getValue('filtercategory'));
            $filtersBlock->setValue('filterbrand', $this->getValue('filterbrand'));
            $filtersBlock->setValue('filtervalue', $this->getValue('filtervalue'));
            $filtersBlock->setValue('titleH1', $this->getValue('titleH1'));
            $filtersBlock->setValue('currencyDefault', $currencyDefault);

            // запускаем обработку, чтобы потом можно было получить $productsWithFilters
            $filtersBlock->process();

            // получаем количество товаров и товары после обработки
            $productsWithFilters = $filtersBlock->getValue('productsWithFilter');
            $this->setValue('productsWithFilter', clone $productsWithFilters);

            //$cntAfterFilter = $productsWithFilters->getCount();

            $products = $productsWithFilters;
        }

        $cntAfterFilter = $products->getCount();
        $this->setValue('productCount', $cntAfterFilter);

        if ($showPages) {
            // в этот параметр может прийти из кастомного модуля
            $onPage = $this->getArgumentSecure('onpage');
            if (!$onPage) {
                if (!empty($_SESSION['onPage'])) {
                    $onPage = $_SESSION['onPage'];
                }
            }
            if (!$onPage) {
                $onPage = Shop::Get()->getSettingsService()->getSettingValue('shop-onpage');
            }

            if ($onPage == 0) {
                $onPage = 12;
            }

            $_SESSION['onPage'] = $onPage;
            $this->setValue('onpage', $onPage);

            $p = $this->getArgumentSecure('p');

            // страницы
            $stepper = false;
            if (!$products->getLimitCount()) {
                $stepper = true;
                $products->setLimit($p * $onPage, $onPage);
            }
        }

        if ($showSort) {
            // сортировка
            $sort = $this->getArgumentSecure('sort');
            if (!$sort) {
                // если это страница поиска, то по умолчанию сортировка по релевантности
                if ($this->getValue('need_relevance_sort')) {
                    $sort = 'relevance';
                } elseif (isset($_SESSION['sort'])) {
                    $sort = $_SESSION['sort'];
                } else {
                    try {
                        $sort = Shop::Get()->getShopService()->getCategoryByID($this->getArgumentSecure('id'))
                            ->getSortdefault();
                    } catch (Exception $e) {
                        $sort = false;
                    }
                }
            }

            $this->setValue('need_relevance_sort', $this->getValue('need_relevance_sort'));

            if (!$sort) {
                $sort = 'rating';
            }

            // если сортировка по релевантности, то в сессию её не пишем
            if ($sort != 'relevance') {
                $_SESSION['sort'] = $sort;
            }

            $this->setValue('sort', $sort);

            $urlCurrent = Engine::GetURLParser()->getTotalURL();
            $urlCurrent = preg_replace("/\/p-(\d+)\//ius", '/', $urlCurrent);
            $urlGET = Engine::GetURLParser()->getGETString();
            if ($urlGET) {
                $urlGET = '?' . $urlGET;
            }

            $this->setValue('formUrl', $urlCurrent.$urlGET);

            // допустимые сортировки
            $sortsArray = array();
            $sortsArray[] = 'rating';
            $sortsArray[] = 'ordered';
            $sortsArray[] = 'name';
            $sortsArray[] = 'price-asc';
            $sortsArray[] = 'price-desc';
            $sortsArray[] = 'avail';
            $sortsArray[] = 'relevance';

            if (!in_array($sort, $sortsArray)) {
                $sort = $sortsArray[0];
            }

            // по умолчанию сортировка в обратном порядке
            $sortType = $this->getArgumentSecure('sorttype');
            if (!$sortType) {
                if (!empty($_SESSION['sortType'])) {
                    $sortType = $_SESSION['sortType'];
                }
            }
            if (!$sortType) {
                $sortType = 'DESC';
                if ($sort == 'name') {
                    $sortType = 'ASC';
                }
            }
            if ($sort == 'price-asc') {
                $sort = 'pricesell';
                $sortType = 'ASC';
            }
            if ($sort == 'price-desc') {
                $sortType = 'DESC';
                $sort = 'pricesell';
            }

            $_SESSION['sortType'] = $sortType;
            $this->setValue('sorttype', $sortType);

            /*if ($sort != 'relevance') {
                if ($show == 'thumbsgrouped') {
                    $products->addFieldQuery('(`'.$sort.'` * `avail`) as sortflag');
                    $products->setOrder(array('`sortflag` ' . $sortType, 'pricesell ASC'));
                } else {
                    $products->addFieldQuery('(`'.$sort.'`) as sortflag');
                    $products->setOrder(array('`sortflag` ' . $sortType, 'pricesell ASC'));
                }

            }*/

            // сортировать по наличию
            if (Shop::Get()->getSettingsService()->getSettingValue('filtering-product-on-presence')) {
                if ($sort == 'relevance') {
                    if ($products->getOrderBy()) {
                        $products->setOrderBy(
                            array('CASE WHEN avail > 0 THEN 1 ELSE 0 END DESC',
                                $productsWithFilters->getOrderBy())
                        );
                    }
                } else {
                    $products->setOrderBy(
                        array('CASE WHEN avail > 0 THEN 1 ELSE 0 END DESC', $sort . ' ' . $sortType, 'pricesell ASC')
                    );
                }
            }
        }

        // передаем товары
        $showContainer->setValue('subcategories', $this->getValue('subcategories'));
        $showContainer->setValue('products', $products);

        // и формируем отображение
        try {
            $this->setValue('container', $showContainer->render());
        } catch (Exception $e) {
            print_r($e);
        }

        // делаем правильный pagination
        if ($showPages) {
            if ($show == 'thumbsgrouped' || $show == 'tablegrouped') {
                $products->setGroupByQuery(Shop::Get()->getShopService()->getProductsGroup($products));
                $cntAfterFilter = $products->getCount();
            }
            $ar = array();
            $ar = $this->_pages($p, $onPage, $cntAfterFilter);
            $nextCount = $onPage;
            if (($p+2)*$onPage > $cntAfterFilter) {
                $nextCount = $cntAfterFilter - ($p+1)*$onPage;
            }

            $this->setValue('nextCount', $nextCount);

            $a = array();
            $a = $ar['pagesArray'];
            $this->setValue('pagesArray', $a);
            if (isset($ar['urlnext'])) {
                $this->setValue('urlnext', $ar['urlnext']);
            }
            if (isset($ar['urlprev'])) {
                $this->setValue('urlprev', $ar['urlprev']);
            }
            if (isset($ar['hellip'])) {
                $this->setValue('hellip', $ar['hellip']);
            }
        }

        // карусели
        if (!$this->getValue('nocarousel')) {
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

        // если есть код для рекламного банера google adsence
        $this->setValue(
            'integration_google_adsence_left',
            Shop::Get()->getSettingsService()->getSettingValue('integration-google-adsence-left')
        );

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

        $urlCurrent = Engine::GetURLParser()->getTotalURL();
        $urlCurrent = preg_replace("/\/p-(\d+)\//ius", '/', $urlCurrent);
        $urlGET = Engine::GetURLParser()->getGETString();
        if ($urlGET) {
            $urlGET = '?' . $urlGET;
        }

        for ($j = $start; $j < $cnt; $j++) {
            $a[] = array(
                'name' => ($j + 1),
                'url' => $j > 0 ? $urlCurrent . 'p-' . $j . '/' . $urlGET : $urlCurrent . $urlGET,
                'selected' => $j == $page,
                'visible' => $j > $stop ? false : true,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // next
        if ($page + 1 < $cnt) {
            $urlNext = $urlCurrent . 'p-' . ($page + 1) . '/' . $urlGET;

            $assignsArray['urlnext'] = $urlNext;

            Engine::GetHTMLHead()->addLink('next', Engine::Get()->getProjectURL() . $urlNext);
        }

        // prev
        if ($page - 1 >= 0) {
            if ($page - 1 > 0) {
                $urlPrev = $urlCurrent . 'p-' . ($page - 1) . '/' . $urlGET;
            } else {
                $urlPrev = $urlCurrent . $urlGET;
            }

            $assignsArray['urlprev'] = $urlPrev;

            Engine::GetHTMLHead()->addLink('prev', Engine::Get()->getProjectURL() . $urlPrev);
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return $assignsArray;
    }

    private function _toFloat($x) {
        return (float) $x;
    }

    private $_fieldName = 'name';

}