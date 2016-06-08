<?php
class shop_brand extends Engine_Class {

    public function process() {
        try {
            $brand = Shop::Get()->getShopService()->getBrandByID(
                $this->getArgument('id')
            );

            // скрытые показываем только админу
            if ($brand->getHidden()) {
                if (!$this->getUserSecure()) {
                    throw new ServiceUtils_Exception('hidden');
                }
            }

        } catch (Exception $e) {
            Engine::Get()->getRequest()->setBrandContentNotFound();
            return;

            // бросаем exception для 404
            //$e->setCode(404);
            //throw $e;
        }

        // проверяем, есть ли у URL
        $url = Engine::GetURLParser()->getTotalURL();
        if ($brand->getUrl() && preg_match("/^\/brand\/(\d+)\/$/ius", $url)) {
            header('HTTP/1.1 301 Moved Permanently');
            header('Location: '.$brand->makeURL());
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

        // отправляем в шаблон указание, какой бренд выбран
        Engine::GetContentDriver()->getContent('shop-tpl-column')->setValue('brandSelected', $brand->getId());

        // ------------------------------------------------- //

        // устанавливаем meta-ключевые слова
        Engine::GetHTMLHead()->setMetaKeywords(htmlspecialchars($brand->getSeokeywords()));

        $metaDescription = $brand->getSeodescription();

        if (!$metaDescription) {
            $metaDescription = Shop::Get()->getSettingsService()->getSettingValue('seo-meta-description-brand');
        }

        if (!$metaDescription) {
            $metaDescription = $brand->getDescription();
            $metaDescription = strip_tags($metaDescription);
            $metaDescription = StringUtils_Object::Create($metaDescription)->limit(200)->__toString();
        }

        $metaDescription = $this->_processKeywords($metaDescription, $brand);

        Engine::GetHTMLHead()->setMetaDescription(htmlspecialchars($metaDescription));

        // устанавливаем title
        $title = $brand->getSeotitle();

        if (!$title) {
            $title = Shop::Get()->getSettingsService()->getSettingValue('seo-title-brand');
        }

        $title = $this->_processKeywords($title, $brand);

        $page = $this->getArgumentSecure('p');
        if ($page && $page != 'all') {
            $title .= ' (страница '.($page + 1).')';
        }

        Engine::GetHTMLHead()->setTitle(
            htmlspecialchars($title)
        );

        // ------------------------------------------------- //

        // open graph tags
        $image = $brand->makeImageThumb(100);
        if ($image) {
            Engine::GetHTMLHead()->setMetaTag('og:image', Engine::Get()->getProjectURL().$image);
        }
        Engine::GetHTMLHead()->setMetaTag('og:title', $brand->getName());
        Engine::GetHTMLHead()
            ->setMetaTag('og:description', htmlspecialchars(strip_tags($brand->getDescription())));


        // ------------------------------------------------- //

        // H1 SEO
        $this->setValue('seoh1', $brand->getSeoh1());

        $titleH1 = false;
        if ($brand->getSeoh1()) {
            $titleH1 = $brand->getSeoh1();
        } else {
            $titleH1 = $brand->getName();
        }

        $this->setValue('brandname', $brand->getName());
        $this->setValue('brandimage', $brand->makeImageThumb(177));
        $this->setValue('brandcountry', $brand->getCountry());

        // показываем описание категории только на первой странице.
        if ($page < 1 && !$this->_checkFilters()) {
            $this->setValue('branddescription', $brand->getDescription());
            $this->setValue('brandsiteurl', $brand->getSiteurl());

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $brand->getSeocontent());
        }

        // ------------------------------------------------- //

        // передаем в блок новостей "где мы сейчас"
        $blockNews = Engine::GetContentDriver()->getContent('block-news');
        $blockNews->setValue('brand', $brand);

        // ------------------------------------------------- //

        $products = $brand->getProducts();

        $render = Engine::GetContentDriver()->getContent('shop-product-list');
        $render->setValue('items', $products);
        $render->setValue('filtercategory', true);
        $render->setValue('showtype', $brand->getShowtype());
        $render->setValue('currentURL', $brand->makeURL());
        $render->setValue('brandid', $brand->getId());

        $render->setValue('brandname', $brand->getName());
        $render->setValue('brandimage', $brand->makeImageThumb(177));
        $render->setValue('brandsiteurl', $brand->getSiteurl());
        $render->setValue('titleH1', $titleH1);

        $render->setValue('pathArray', $this->_makePathArray($brand));

        // показываем описание бренда только на первой странице.
        if ($page < 1 && !$this->_checkFilters()) {
            $this->setValue('image', $brand->makeImageThumb());
            $this->setValue('description', $brand->getDescription());

            // SEO-контекнт передаем в shop-tpl
            $tpl = Engine::GetContentDriver()->getContent('shop-tpl');
            $tpl->setValue('seocontent', $brand->getSeocontent());
        }

        $this->setValue('items', $render->render());
        $this->setValue('pathAdditionalH1', $render->getValue('pathAdditionalH1'));
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

    private function _processKeywords($s, ShopBrand $brand) {
        $s = str_replace('[name]', $brand->getName(), $s);

        $cnt = $brand->getProductcount();
        if ($cnt) {
            $s = str_replace('[count]', $cnt, $s);
        } else {
            $s = str_replace('[count]', '', $s);
        }

        return $s;
    }

    /**
     * Построить путь бренда
     *
     * @param ShopBrand $brand
     *
     * @return array
     */
    private function _makePathArray(ShopBrand $brand) {
        $a = array();

        try {
            $a[] = $brand->makeInfoArray();
        } catch (Exception $e) {

        }
        return $a;
    }

}