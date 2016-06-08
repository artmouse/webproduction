<?php
class shop_category extends Engine_Class {

    public function process() {
        try {
            $category = Shop::Get()->getShopService()->getCategoryByID(
                $this->getArgument('id')
            );

            // проверяем, скрыта ли категория
            if ($category->getHidden()) {
                try {
                    if (!$this->getUser()->isAdmin()) {
                        throw new ServiceUtils_Exception();
                    }
                } catch (Exception $e) {
                    Engine::Get()->getRequest()->setContentNotFound();
                    return;
                }
            }
            if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
                $h = 'https://';
            } else {
                $h = 'http://';
            }

            if ($category->getSubdomain()
            && $category->getUrl()
            ) {
                // категория на субдомене
                $e = explode('.', Engine::GetURLParser()->getHost());
                // @todo
                $url = preg_replace("~^[a-z]+~ie", "strtolower('\\0')", $category->getUrl());
                if ($e[0] != $url) {
                    $u = $h . $category->getUrl() . '.' . Engine::Get()->getProjectHost() .
                    Engine::GetURLParser()->getTotalURL();
                    header('HTTP/1.1 301 Moved Permanently');
                    header('Location: ' . $u);
                    exit();
                }
            } else {
                try {
                    // пытаемся найти родительский URL
                    // @todo: код говнист!
                    $parent = $category->getParent();
                    if ($parent->getSubdomain() && $parent->getUrl()) {
                        $e = explode('.', Engine::GetURLParser()->getHost());
                        $url = preg_replace("~^[a-z]+~ie", "strtolower('\\0')", $parent->getUrl());
                        if ($e[0] != $url) {
                            $u = $h . $parent->getUrl() . '.' . Engine::Get()->getProjectHost() .
                            Engine::GetURLParser()->getTotalURL();
                            header('HTTP/1.1 301 Moved Permanently');
                            header('Location: ' . $u);
                            exit();
                        }
                    }
                } catch (Exception $e) {

                }
            }

            // проверяем, есть ли у URL
            $url = Engine::GetURLParser()->getTotalURL();
            if ($category->getUrl() && preg_match("/^\/category\/(\d+)\/$/ius", $url)) {
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: ' . $category->makeURL());
                exit();
            }

            // отправляем в шаблон указание, какая категория выбрана
            Engine::GetContentDriver()->getContent('block-menu-category')->setValue(
                'categorySelected', $category->getId()
            );

            // устанавливаем meta-ключевые слова и описание
            Engine::GetHTMLHead()->setMetaKeywords(
                htmlspecialchars($this->_getSeoWithPage($category->getSeokeywords()))
            );
            Engine::GetHTMLHead()->setMetaDescription(
                htmlspecialchars(
                    $category->getSeodescription() ? $this->_getSeoWithPage($category->getSeodescription()) :
                    $this->_getSeoWithPage($category->getDescription())
                )
            );

            // open graph tags
            $image = $category->makeImageThumb(100);
            if ($image) {
                Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL() . $image);
            }
            Engine::GetHTMLHead()->setMetaTag('og:title', $this->_getSeoWithPage($category->getName()));
            Engine::GetHTMLHead()->setMetaTag(
                'og:description', htmlspecialchars(strip_tags($this->_getSeoWithPage($category->getDescription())))
            );

            // подкатегории
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
            $a = array();
            while ($x = $childs->getNext()) {
                $a[] = $x->makeInfoArray();
            }
            $this->setValue('categoryArray', $a);

            // устанавливаем title
            $title = $category->getSeotitle();
            if (!$title) {
                // авто-формирование title
                $title = $category->makePathName(', ') . '. ';

                $title .= 'Купить, цены, отзывы, доставка.';

                $storeName = Shop::Get()->getSettingsService()->getSettingValue('shop-name');
                $storeSlogan = Shop::Get()->getSettingsService()->getSettingValue('shop-slogan');

                if ($storeSlogan) {
                    $title .= ' ' . $storeSlogan;
                } else {
                    $title .= ' ' . $storeName;
                }
            }

            $page = $this->_getCurrentPage();

            Engine::GetHTMLHead()->setTitle($this->_getSeoWithPage($title));

            // показываем описание категории только на первой странице
            // и если нет фильтров
            if ($page < 1 && !$this->_checkFilters()) {
                $this->setValue('image', $category->makeImageThumb());
                $this->setValue('description', $category->getDescription());
                $this->setValue('categoryName', $category->getName());
               
                if (!preg_match('/^\/.*\/.*$/ius', Engine::GetURLParser()->getTotalURL())) {
                    // SEO-контекнт передаем в shop-tpl    
                    $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
                    $tpl->setValue('seocontent', $category->getSeocontent());
                    
                }
            }

            $products = $category->getProducts();

            // подкатегории
            $subcategories = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
            $subcategories->setHidden(0);

            // ------------------------------------------------- //

            // передаем в блок новостей "где мы сейчас"
            $blockNews = Engine::GetContentDriver()->getContent('block-news');
            $blockNews->setValue('category', $category);

            // ------------------------------------------------- //

            // seoh1
            try {
                $seo = SEOService::Get()->getSEOByURL(
                    Engine::GetURLParser()->getTotalURL()
                );
                if ($seo->getSeoh1()) {

                    $this->setValue('seoh1', $this->_getSeoWithPage($seo->getSeoh1()));

                }
            } catch (Exception $seoEx) {
                $this->setValue('seoh1', $this->_getSeoWithPage($category->getName()));
            }

            $render = Engine::GetContentDriver()->getContent('shop-product-list');
            $render->setValue('items', $products);
            $render->setValue('categoryName', $category->getName());
            $render->setValue('showtype', $category->getShowtype());
            $render->setValue('filterbrand', true);
            $render->setValue('category', $subcategories->getCount());
            $render->setValue('subcategories', $subcategories);
            $render->setValue('pathArray', $this->_makePathArray($category));
            $render->setValue('currentURL', $category->makeURL());

            $this->setValue('items', $render->render());
            if ($h1 = $this->getValue('h1')) {
                $this->setValue('seoh1', $h1);
            }
            if ($title = $this->getValue('title')) {
                Engine::GetHTMLHead()->setTitle($title);
            }
            if ($metaDescription = $this->getValue('metaDescription')) {
                Engine::GetHTMLHead()->setMetaDescription(
                    $metaDescription
                );
            }
            if ($keywords = $this->getValue('keywords')) {
                Engine::GetHTMLHead()->setMetaKeywords(
                    $keywords
                );
            }

        } catch (Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

    /**
     * Возвращает текущую страницу категории
     *
     * @return int|string
     */
    private function _getCurrentPage() {
        $page = 0;
        $tmpUrl = Engine::GetURLParser()->getCurrentURL();
        if (strpos($tmpUrl, '_p=') !== false) {
            $page = $this->_getStringBetween('_p=', '_', $tmpUrl);
        }
        return $page;
    }

    /**
     * Если есть страници пагинации, то возвращает текст формата |Cтраница # $page
     *
     * @return string
     */
    private function _getPageText() {

        if ($this->_pageText == null) {
            $page = $this->_getCurrentPage();

            if ($page) {
                $this->_pageText = ' | Cтраница #' . ($page + 1);
            } else {
                $this->_pageText = '';
            }
        }
        return $this->_pageText;

    }

    /**
     * Возвращает сео-текст с добавлением номера страници, когда есть страници и сео-текст
     *
     * @param $someSeoString
     */
    private function _getSeoWithPage($someSeoString) {
        if ($someSeoString) {
            return $someSeoString . $this->_getPageText();
        } else {
            return '';
        }
    }

    private function _getStringBetween($var1, $var2, $pool) {
        $temp1 = strpos($pool, $var1) + strlen($var1);
        $result = substr($pool, $temp1, strlen($pool));
        $dd = strpos($result, $var2);
        if ($dd == 0) {
            $dd = strlen($result);
        }

        return substr($result, 0, $dd);
    }


    /**
     * Построить путь категории
     *
     * @param ShopCategory $category
     *
     * @return array
     */
    private function _makePathArray(ShopCategory $category) {
        $category = clone $category;
        $a = array();
        try {
            $a[] = $category->makeInfoArray();
            while ($category = $category->getParent()) {
                $a[] = $category->makeInfoArray();
            }
        } catch (Exception $e) {

        }
        return array_reverse($a);
    }

    /**
     * Проверить, есть ли по указанному URL какие-либо SEO-примочки
     *
     * @param string $url
     *
     * @return bool
     */
    private function _checkFilters() {
        $argumentsArray = $this->getArguments();
        foreach ($argumentsArray as $key => $value) {
            if (preg_match("/^filter(\d+)value$/ius", $key, $r)) {
                return true;
            }
        }
        return false;
    }

    private $_pageText = null;

}