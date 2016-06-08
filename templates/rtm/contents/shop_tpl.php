<?php
class shop_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/shop.loading.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.lazyload.min.js');

        $this->setValue('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        // выводить или нет ссылку сравнения товаров
        // @todo: кривой код
        $this->setValue('countCompare', Shop::Get()->getCompareService()->getCompareProducts()->getCount());

        // редиректы
        $host = Engine::GetURLParser()->getHost();
        $projecthost = Engine::Get()->getProjectHost();
        if ($host != $projecthost
        && (Engine::Get()->getRequest()->getContentID() != 'shop-category'
        && Engine::Get()->getRequest()->getContentID() != 'shop-product')
        ) {
            $url = Engine::Get()->getProjectURL() . Engine::GetURLParser()->getTotalURL();
            header('Location: ' . $url);
            exit();
        }

        // интеграции (настройки)
        $contentID = Engine::Get()->getRequest()->getContentID();

        // интеграции
        $content = Engine::GetContentDriver()->getContent($contentID);
        if ($content->getField('moveto') != 'shop-client-tpl'
        && $content->getField('id') != 'shop-order'
        ) {
            $this->setValue(
                'integration_cloudim', Shop::Get()->getSettingsService()->getSettingValue('integration-cloudim')
            );
            $this->setValue(
                'integration_ga', Shop::Get()->getSettingsService()->getSettingValue('integration-googleanalytics')
            );
            $this->setValue(
                'integration_google_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-google-wmt')
            );
            $this->setValue(
                'integration_yandex_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-wmt')
            );
            $this->setValue(
                'integration_liveinternet',
                Shop::Get()->getSettingsService()->getSettingValue('integration-liveinternet')
            );
            $this->setValue(
                'integration_zhivosite', Shop::Get()->getSettingsService()->getSettingValue('code-zhivosite')
            );

            $this->_setCanonicalLink();

        }

        if ($contentID == 'shop-basket' || $contentID == 'logout' ||
            Shop::Get()->getSettingsService()->getSettingValue('site-robots-hide')) {
            $this->setValue('noIndexing', 1);
        }
        // ------------------------------------------------- //

        // показывать или нет ссылку на админ панель
        // показываем информацию о юзере
        $this->setValue('admin', false);
        try {
            if ($this->getUser()->getLogin()) {
                $this->setValue('userlogin', $this->getUser()->getLogin());
            } else {
                $this->setValue('userlogin', $this->getUser()->getEmail());
            }
            $this->setValue('userName', $this->getUser()->makeName(true, false));
            $this->setValue('avatar', $this->getUser()->makeImageGravatar());

            if ($this->getUser()->isAdmin()) {
                $this->setValue('admin', true);
            }
        } catch (Exception $e) {

        }

        // настройки
        $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
        $phones = explode(',', $phones);
        shuffle($phones);
        $x = count($phones) + 1;
        for ($i = 1; $i < $x; $i++) {
            $this->setValue("phone$i", $phones[$i - 1]);
        }

        $this->setValue('icq', Shop::Get()->getSettingsService()->getSettingValue('header-icq'));
        $this->setValue('skype', Shop::Get()->getSettingsService()->getSettingValue('header-skype'));
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
        $this->setValue('worktime', Shop::Get()->getSettingsService()->getSettingValue('work-time'));
        $this->setValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
        $this->setValue('logo', Shop::Get()->getSettingsService()->getSettingValue('header-logo'));
        $this->setValue('shopName', htmlspecialchars(Shop::Get()->getSettingsService()->getSettingValue('shop-name')));
        $this->setValue('copyright', Shop::Get()->getSettingsService()->getSettingValue('copyright'));
        $this->setValue('background', Shop::Get()->getSettingsService()->getSettingValue('background-image'));
        $this->setValue('integration_istat', Shop::Get()->getSettingsService()->getSettingValue('code-istat'));
        $this->setValue('istat_span_0', Shop::Get()->getSettingsService()->getSettingValue('code-istat-span-0'));
        $this->setValue('istat_span_1', Shop::Get()->getSettingsService()->getSettingValue('code-istat-span-1'));

        try {
            $logo = Shop::Get()->getShopService()->getLogoCurrent();
            $this->setValue('logo', $logo->makeImageThumb());
        } catch (ServiceUtils_Exception $le) {

        }

        // @todo: а нужно ли?
        // какие категории сейчас выделены?
        /*$categorySelectedArray = array(0);
        $categorySelected = $this->getValue('categorySelected');
        if ($categorySelected) {
        $categorySelectedArray[] = $categorySelected;
        // поднимаемся наверх
        try {
        $category = Shop::Get()->getShopService()->getCategoryByID($categorySelected);
        while ($category = $category->getParent()) {
        $categorySelectedArray[] = $category->getId();
        }
        } catch (Exception $e) {

        }
        }*/

        // RSS links
        Engine::GetHTMLHead()->addFeedRSS(
            Engine::GetLinkMaker()->makeURLByContentID('shop-news-rss'),
            Shop::Get()->getSettingsService()->getSettingValue('title')
        );

        // SEO
        try {
            $seo = SEOService::Get()->getSEOByURL(
                Engine::GetURLParser()->getTotalURL()
            );

            if ($seo->getSeotitle()) {
                Engine::GetHTMLHead()->setTitle(
                    $seo->getSeotitle()
                );
            }

            if ($seo->getSeokeywords()) {
                Engine::GetHTMLHead()->setMetaKeywords(
                    $seo->getSeokeywords()
                );
            }

            if ($seo->getSeodescription()) {
                Engine::GetHTMLHead()->setMetaDescription(
                    $seo->getSeodescription()
                );
            }

            if ($seo->getSeocontent() && !$this->getArgumentSecure('p')) {
                $this->setValue('seocontent', $seo->getSeocontent());
            }

        } catch (Exception $seoEx) {

        }

        // если title нет - по умочанию ставим название магазина
        if (!Engine::GetHTMLHead()->getTitle()) {
            Engine::GetHTMLHead()->setTitle(Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        }

        $this->setValue('deliveryUrl', $this->_makePagesUrlByLogicclass('shop-delivery'));
        $this->setValue('paymentUrl', $this->_makePagesUrlByLogicclass('shop-payment'));

        $this->setValue('main', Engine::Get()->getProjectURL());

        $this->setValue('mainCategoryArray', $this->_getCategoryArray());

        // интеграция с loginza
        $loginzaVerification = Shop::Get()->getSettingsService()->getSettingValue('loginza-verification');
        $this->setValue('loginzaVerification', $loginzaVerification);

        $loginzaServices = Shop::Get()->getSettingsService()->getSettingValue('loginza-services');
        $loginzaWidgetID = Shop::Get()->getSettingsService()->getSettingValue('loginza-widgetid');
        $loginzaServices = str_replace(' ', '', $loginzaServices);
        $loginzaServices = trim($loginzaServices);
        if ($loginzaWidgetID && $loginzaServices) {
            $loginzaTokenURL = Engine::Get()->getProjectURL() . Engine::GetURLParser()->getCurrentURL();
            $loginzaTokenURL = urlencode($loginzaTokenURL);
            $loginzaURL = "https://loginza.ru/api/widget?token_url=" . $loginzaTokenURL . "&providers_set=" .
            $loginzaServices;
            $this->setValue('loginzaURL', $loginzaURL);
        }

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));
        $this->setValue(
            'integration_yandex_counter',
            Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-counter')
        );

        // !!! эти строки должны быть в самом конце !!!
        $this->setValue(
            'title',
            preg_replace('/[^a-zA-ZА-Яа-я0-9їЇіІєЄёЁ\+\-\,\.\#\№\:\;\|\(\)]/u', ' ', Engine::GetHTMLHead()->getTitle())
        );
        $includes = Engine::GetHTMLHead()->render();
        $includes = preg_replace(
            '/(<script type=\"text\/javascript\" src=\"\/_js\/jquery\.easing\.1\.3\.js.*?\"><\/script>)/',
            '',
            $includes
        ); // Костыль для easing
        $this->setValue('engine_includes', $includes);
        // !!! после этой строки ничего не дописывать !!!
    }

    /**
     * Устанавливаем каноническую ссылку, если пришел Get параметр из массива @parameters
     */
    private function _setCanonicalLink() {
        $arguments = $this->getArguments();
        $parameters = array(
            'gclid', 'utm_medium', 'utm_source', 'utm_campaign', 'utm_content', 'utm_term', '_openstat'
        );

        foreach ($arguments as $key => $argument) {
            if (in_array($key, $parameters)) {
                Engine::GetHTMLHead()->addLink('canonical', $this->_getTotalUrl());
                break;
            }
        }
    }

    /**
     * UrlByLogicclass
     *
     * @param $logicclass
     *
     * @return bool|string
     */
    private function _makePagesUrlByLogicclass($logicclass) {
        try {
            return Shop::Get()->getTextPageService()->getTextPageByLogicclass($logicclass)->makeURL();
        } catch (Exception $e) {
            return false;
        }
    }

    /**
     * CategoryArray
     *
     * @return array
     */
    private function _getCategoryArray() {
        $subcategories = Shop::Get()->getShopService()->getCategoryAll();
        $subcategories->setHidden(0);
        $subcategories->setParentid(0);

        $a = array();
        while ($x = $subcategories->getNext()) {
            $childs = Shop::Get()->getShopService()->getCategoriesByParentID($x->getId());
            $childs->setHidden(0);
            $childsArray = array();

            while ($y = $childs->getNext()) {
                $url = $y->makeURL();
                $childsArray[] = array(
                    'name' => $y->makeName(),
                    'url' => $url
                );
            }

            $image = false;

            if ($x->makeImageThumb()) {
                $image = $x->makeImageThumb();
            } else {
                $product = Shop::Get()->getShopService()->getProductsByCategory($x);
                $product->addWhere('image', '', '<>');
                $product->setLimitCount(1);
                if ($w = $product->getNext()) {
                    $image = $w->makeImageThumb(200);
                }
            }
            $url = $x->makeURL();
            $a[] = array(
                'name' => $x->makeName(),
                'url' => $url,
                'image' => $image,
                'childsArray' => $childsArray,
            );
        }
        return $a;
    }

    /**
     * Возвращает полный урл без Get параметров
     *
     * @return string
     */
    private function _getTotalUrl() {
        if (@isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] == 'on') {
            $h = 'https://';
        } else {
            $h = 'http://';
        }

        return rtrim($h . Engine::Get()->getProjectHost() . Engine::GetURLParser()->getTotalURL(), '/');
    }

}