<?php
class shop_category extends Engine_Class {

    public function process() {
        try {
            $category = Shop::Get()->getShopService()->getCategoryByID(
                $this->getArgument('id')
            );

            // скрытые товары показываем только админу
            if ($category->getHidden()) {
                if (!$this->getUserSecure()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setCategoryContentNotFound();
            return;

            // бросаем exception для 404
            //$e->setCode(404);
            //throw $e;
        }

        // проверяем, скрыта ли категория
        if ($category->isHidden()) {
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

        if ($categorySubdomain = Shop::Get()->getShopService()->getCategorySubdomain($category)) {
            $e = explode('.', Engine::GetURLParser()->getHost());
            if ($e[0] != $categorySubdomain) {
                $u = $h.$categorySubdomain.'.'.
                    Engine::Get()->getProjectHost().Engine::GetURLParser()->getTotalURL();
                header('HTTP/1.1 301 Moved Permanently');
                header('Location: '.$u);
                exit();
            }
        }

        // ------------------------------------------------- //

        // проверяем, есть ли у URL
        $url = Engine::GetURLParser()->getTotalURL();
        if ($category->getUrl() && preg_match("/^\/category\/(\d+)\/$/ius", $url)) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$category->makeURL());
            exit();
        }

        // ------------------------------------------------- //

        // проверяем, есть ли в конце URL'a слеш - если нет - делаем редирект
        $url = Engine::GetURLParser()->getTotalURL();
        if (!preg_match("/\/$/ius", $url)) {
            $url .= '/';
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$url);
            exit();
        }

        // ------------------------------------------------- //

        // отправляем в шаблон указание, какая категория выбрана
        Engine::GetContentDriver()->getContent('block-menu-category')->setValue(
            'categorySelected', $category->getId()
        );

        // ------------------------------------------------- //

        // устанавливаем meta-ключевые слова и описание
        Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($category->getSeokeywords()));

        $metaDescription = $category->getSeodescription();

        if (!$metaDescription) {
            $metaDescription = Shop::Get()->
            getSettingsService()->getSettingValue('seo-meta-description-category');
        }
        if (!$metaDescription) {
            $metaDescription = $category->getDescription();
            $metaDescription = strip_tags($metaDescription);
            $metaDescription = StringUtils_Object::Create($metaDescription)->limit(200)->__toString();
        }

        $metaDescription = $this->_processKeywords($metaDescription, $category);

        //Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($metaDescription));

        // устанавливаем title
        $title = $category->getSeotitle();

        if (!$title) {
            $title = Shop::Get()->getSettingsService()->getSettingValue('seo-title-category');
        }

        $title = $this->_processKeywords($title, $category);

        $page = $this->getArgumentSecure('p');
        if ($page) {
            $title .= ' (страница '.($page + 1).')';
        }

        Engine::GetHTMLHead()->setTitle(
            htmlspecialchars($title)
        );

        // ------------------------------------------------- //

        // open graph tags
        $image = $category->makeImageThumb(100);
        if ($image) {
            Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
        }
        Engine::GetHTMLHead()->setMetaTag('og:title', $category->getName());
        Engine::GetHTMLHead()->setMetaTag(
            'og:description',
            htmlspecialchars(strip_tags($category->getDescription()))
        );

        // ------------------------------------------------- //

        // подкатегории
        $childs = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
        $a = array();
        while ($x = $childs->getNext()) {
            $a[] = $x->makeInfoArray();
        }
        $this->setValue('categoryArray', $a);

        $this->setValue('categoryName', $category->getName());

        // показываем описание категории только на первой странице
        // и если нет фильтров
        if ($page < 1 && !$this->_checkFilters()) {
            $this->setValue('image', $category->makeImageThumb());
            $this->setValue('description', $category->getDescription());

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $category->getSeocontent());
        }

        if ($category->getLogicclass()
            && class_exists($category->getLogicclass())
            && method_exists($category->getLogicclass(), 'getProducts')
        ) {
            try {
                $class = $category->getLogicclass();
                $object = new $class;
                $products = $object->getProducts();

            } catch(Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
                $products = $category->getProducts();
            }

        } else {
            $products = $category->getProducts();
        }

        // подкатегории
        $subcategories = Shop::Get()->getShopService()->getCategoriesByParentID($category->getId());
        $subcategories->setHidden(0);

        // ------------------------------------------------- //

        // передаем в блок новостей "где мы сейчас"
        $blockNews = Engine::GetContentDriver()->getContent('block-news');
        $blockNews->setValue('category', $category);

        // ------------------------------------------------- //

        // seoh1
        $seoh1 = false;
        try {
            $seo = Shop::Get()->getSEOService()->getSEOByURL(
                Engine::GetURLParser()->getTotalURL()
            );
            $seoh1 = $seo->getSeoh1();
            if ($seo->getSeoh1()) {
                $this->setValue('seoh1', $seoh1);
            }
        } catch (Exception $seoEx) {

        }

        $titleH1 = false;
        if ($seoh1) {
            $titleH1 = $seoh1;
        } else {
            $titleH1 = $category->getSeotitle() ? $category->getSeotitle() : $category->getName();
        }

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $render->setValue(
            'categoryName',
            $category->getSeotitle() ? $category->getSeotitle() : $category->getName()
        );
        $render->setValue('showtype', $category->getShowtype());
        $render->setValue('filterbrand', true);
        $render->setValue('filtervalue', true);
        $render->setValue('category', $subcategories->getCount());
        $render->setValue('categoryid', $category->getId());
        $render->setValue('subcategories', $subcategories);
        $render->setValue('pathArray', $this->_makePathArray($category));
        $render->setValue('currentURL', $category->makeURL());
        $render->setValue('titleH1', $titleH1);
        $this->setValue('items', $render->render());
        $this->setValue('pathAdditionalH1', $render->getValue('pathAdditionalH1'));

        Engine::GetHTMLHead()->setMetaDescription(
            htmlspecialchars($this->getValue('pathAdditionalH1').': '.$metaDescription)
        );

        // список тегов
        try {
            $productForTag = $render->getValue('productsWithFilter');
            if (!$productForTag) {
                $productForTag = $products;
            }

            $tags = new XShopProduct2Tag();
            $tags->addWhereQuery(
                "productid IN (SELECT id FROM {$productForTag->getTablename()}
            WHERE {$productForTag->makeWhereString()})"
            );
            $tags->setGroupByQuery('tagid');
            $tags->setOrderByRAND();
            $tags->setLimitCount(30);
            $a = array();
            while ($x = $tags->getNext()) {
                try {
                    $tag = Shop::Get()->getShopService()->getProductTagByID($x->getTagid());

                    $a[] = array(
                        'name' => $tag->makeName(),
                        'url' => $tag->makeURL(),
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('tagArray', $a);
        } catch (Exception $tagEx) {

        }
    }

    /**
     * Построить путь категории
     *
     * @param ShopCategory $category
     *
     * @return array
     */
    protected function _makePathArray(ShopCategory $category) {
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

    private function _processKeywords($s, ShopCategory $category) {
        $s = str_replace('[name]', $category->getName(), $s);

        $cnt = $category->getProductcount();
        if ($cnt) {
            $s = str_replace('[count]', $cnt, $s);
        } else {
            $s = str_replace('[count]', '', $s);
        }

        $s = str_replace('[categorypath]', $category->makePathName(', '), $s);

        return $s;
    }

}