<?php
class shop_tpl extends Engine_Class {

    public function process() {

        PackageLoader::Get()->registerJSFile('/_js/shop.loading.js');

        // подключаем файлы из модулей
        if (Shop_ModuleLoader::Get()->isImported('product-favorite')) {
            PackageLoader::Get()->registerJSFile('/modules/product-favorite/_js/shop_product_favorite.js');
        }
        if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
            PackageLoader::Get()->registerJSFile('/modules/personal-discount/_js/personal_discount_check.js');
        }

        $this->setValue('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        // выводить или нет ссылку сравнения товаров
        // @todo: кривой код
        $this->setValue('countCompare', Shop::Get()->getCompareService()->getCompareProducts()->getCount());

        // редиректы
        $host = Engine::GetURLParser()->getHost();
        $projecthost = Engine::Get()->getProjectHost();
        $mobileHost = Engine::Get()->getConfigFieldSecure('mobile-host');
        if (($host != $projecthost && ($mobileHost && $host != $mobileHost))
        && (Engine::Get()->getRequest()->getContentID() != 'shop-category'
        && Engine::Get()->getRequest()->getContentID() != 'shop-product')
        ) {
            $url = Engine::Get()->getProjectURL() . Engine::GetURLParser()->getTotalURL();
            header('Location: ' . $url);
            exit();
        }

        // popup-welcome
        $idArray = explode(';', @$_COOKIE['popup-welcome']);

        // отображение кнопки бренды в меню
        $showMenuBrands = Shop::Get()->getSettingsService()->getSettingValue('show-menu-brands');
        $this->setValue('showMenuBrands', $showMenuBrands);

        // отображение контактов в шапке
        $showHeaderPhone = Shop::Get()->getSettingsService()->getSettingValue('show-header-phone');
        $this->setValue('showHeaderPhone', $showHeaderPhone);
        $showHeaderIcq = Shop::Get()->getSettingsService()->getSettingValue('show-header-icq');
        $this->setValue('showHeaderIcq', $showHeaderIcq);
        $showHeaderEmail = Shop::Get()->getSettingsService()->getSettingValue('show-header-email');
        $this->setValue('showHeaderEmail', $showHeaderEmail);
        $showHeaderAddress = Shop::Get()->getSettingsService()->getSettingValue('show-header-address');
        $this->setValue('showHeaderAddress', $showHeaderAddress);
        $showHeaderSkype = Shop::Get()->getSettingsService()->getSettingValue('show-header-skype');
        $this->setValue('showHeaderSkype', $showHeaderSkype);

        try {
            $banners = Shop::Get()->getShopService()->getBannerAll();
            $banners->setHidden(0);
            $banners->setPlace('welcome');
            $banners->setOrder('sort', 'DESC');
            $banners = $banners->getNext();
            if ($banners && !in_array($banners->getId(), $idArray)) {
                $this->setValue('urlBannerWelcome', $banners->makeImage());
                $this->setValue('welcomeName', $banners->getName());
                $this->setValue('welcomeBannerId', $banners->getId());
            }
        } catch (Exception $e) {

        }

        // интеграции (настройки)
        $contentID = Engine::Get()->getRequest()->getContentID();

        $this->setValue('contentID', $contentID);

        // интеграции
        $content = Engine::GetContentDriver()->getContent($contentID);
        if ($content->getField('moveto') != 'shop-client-tpl'
        && $content->getField('id') != 'shop-order'
        ) {
            $this->setValue(
                'integration_cloudim',
                Shop::Get()->getSettingsService()->getSettingValue('integration-cloudim')
            );
            $this->setValue(
                'integration_ga', Shop::Get()->getSettingsService()->getSettingValue('integration-googleanalytics')
            );
            $this->setValue(
                'integration_google_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-google-wmt')
            );
            $this->setValue(
                'integration_gadwords', Shop::Get()->getSettingsService()->getSettingValue('integration-google-adwords')
            );
            $this->setValue(
                'integration_yandex_wmt', Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-wmt')
            );
            $this->setValue(
                'integration_liveinternet',
                Shop::Get()->getSettingsService()->getSettingValue('integration-liveinternet')
            );
        }

        // показывать или нет ссылку на избранное
        if (Shop_ModuleLoader::Get()->isImported('product-favorite')) {
            $this->setValue('favoriteUrl', Engine::GetLinkMaker()->makeURLByContentID('shop-client-favorite'));
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
        $phones = trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-phone')));
        $phones = explode(',', $phones);
        if (Shop::Get()->getSettingsService()->getSettingValue('header-phone-shuffle')) {
            shuffle($phones);
        }
        $countPhones = count($phones) + 1;
        for ($i = 1; $i < $countPhones; $i++) {
            $this->setValue("phone$i", $phones[$i - 1]);
        }

        try {
            $callback = Shop::Get()->getBlockService()->getBlockByContentId('block-callback');
            $this->setValue('callback', $callback->getActive());
        } catch (Exception $e) {

        }
        try {
            $feedback = Shop::Get()->getBlockService()->getBlockByContentId('block-feedback');
            $this->setValue('feedback', $feedback->getActive());
        } catch (Exception $ex) {

        }
        
        $this->setValue('icq', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-icq'))));
        $this->setValue('skype', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-skype'))));
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
        $this->setValue('worktime', Shop::Get()->getSettingsService()->getSettingValue('work-time'));
        $this->setValue('email', trim(strip_tags(Shop::Get()->getSettingsService()->getSettingValue('header-email'))));
        $this->setValue('logo', Shop::Get()->getSettingsService()->getSettingValue('header-logo'));
        $this->setValue('shopName', htmlspecialchars(Shop::Get()->getSettingsService()->getSettingValue('shop-name')));
        $this->setValue('copyright', Shop::Get()->getSettingsService()->getSettingValue('copyright'));
        $this->setValue('background', Shop::Get()->getSettingsService()->getSettingValue('background-image'));
        $this->setValue('phone_mask', Shop::Get()->getSettingsService()->getSettingValue('phone-mask'));

        try {
            $logo = Shop::Get()->getShopService()->getLogoCurrent();
            $this->setValue('logo', $logo->makeImage());
        } catch (ServiceUtils_Exception $le) {

        }

        // quick order
        $render = Engine::GetContentDriver()->getContent('shop-products-quick-order');
        $this->setValue('quickOrder', $render->render());

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
            $seo = Shop::Get()->getSEOService()->getSEOByURL(
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

            if ($seo->getSeocontent()) {
                $this->setValue('seocontent', $seo->getSeocontent());
            }

        } catch (Exception $seoEx) {

        }

        // если title нет - по умочанию ставим название магазина
        if (!Engine::GetHTMLHead()->getTitle()) {
            Engine::GetHTMLHead()->setTitle(Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        }

        // SEO hreflang
        $hreflang = Shop::Get()->getSettingsService()->getSettingValue('seo-hreflang');
        $currentURL = Engine::GetURLParser()->getTotalURL();
        if ($hreflang) {
            $a = explode("\n", $hreflang);
            $hreflangString = '';
            foreach ($a as $x) {
                $x = trim($x);
                if (!$x) {
                    continue;
                }
                $x = explode(' ', $x, 2);
                $x[0] = trim($x[0], '/');
                $hreflangString .= "<link rel=\"alternate\" href=\"{$x[0]}{$currentURL}\" hreflang=\"{$x[1]}\" />\n";
            }
            $this->setValue('hreflang', $hreflangString);
        }

        $this->setValue('deliveryUrl', $this->_makePagesUrlByLogicclass('shop-delivery'));
        $this->setValue('paymentUrl', $this->_makePagesUrlByLogicclass('shop-payment'));

        $this->setValue('main', Engine::Get()->getProjectURL());

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

        $this->setValue(
            'integration_facebook_pixel_head',
            Shop::Get()->getSettingsService()->getSettingValue('integration-facebook-pixel-head')
        );
        $this->setValue(
            'integration_facebook_pixel_body',
            Shop::Get()->getSettingsService()->getSettingValue('integration-facebook-pixel-body')
        );

        $title = Engine::GetHTMLHead()->getTitle();
        $title = $this->_processKeywords($title);
        $title = str_replace('&quot;', '', $title);
        //$title = preg_replace('/[^a-zA-ZА-Яа-я0-9їЇіІєЄёЁ\+\-\,\.\#\№\:\;\|\(\)\&]/u', ' ', $title);

        // автоматическая транслитерация en->ru для всех русских фраз
        if (Engine::Get()->getConfigFieldSecure('seo-transliterate-en2ru-auto')) {
            $title = preg_replace_callback("/([a-z-\.\s]+)/ius", array($this, '_seoTitle_en2ru'), $title);
        }

        $x = new ShopTextPage();
        $x->setKey("help");
        $x->setHidden(0);
        $help = array();
        while ($y = $x->getNext()) {
            $help []  = array(
                "name" => $y->getName(),
                "url" => $y->getUrl()
            );
        }

        $this->setValue('helpArray', $help);


        $x = new ShopTextPage();
        $x->setKey("company");
        $x->setHidden(0);
        $company = array();
        while ($y = $x->getNext()) {
            $company [] = array(
                "name" => $y->getName(),
                "url" => $y->getUrl()
            );
        }

        $this->setValue('companyArray', $company);

        $description = Engine::GetHTMLHead()->getMetaDescription();
        $description = $this->_processKeywords($description);
        $keywords = Engine::GetHTMLHead()->getMetaKeywords();
        $keywords = $this->_processKeywords($keywords);

        Engine::GetHTMLHead()->setMetaDescription($description);
        Engine::GetHTMLHead()->setMetaKeywords($keywords);

        // если нет seo контента - то строим его автоматически
        if (!$this->getValue('seocontent')) {
            $metaDescription = Engine::GetHTMLHead()->getMetaDescription();
            $metaKeywords = Engine::GetHTMLHead()->getMetaKeywords();

            if ($metaDescription || $metaKeywords) {
                $this->setValue('seocontent', $metaKeywords . ' ' . $metaDescription);
            }
        }

        // !!! эти строки должны быть в самом конце !!!
        $this->setValue('title', $title);
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
        // !!! после этой строки ничего не дописывать !!!

        //-------------------Вывод склееных и сжатых css и js файлов----------------------------//
        /* $rev = false;
        $revInfoFile = PackageLoader::Get()->getProjectPath().'rev.info';
        if (file_exists($revInfoFile)) {
            $rev = file_get_contents($revInfoFile);
        }
        $jsCacheDir = '/_js/cache/';
        $cssCacheDir = '/_css/cache/';

        $cssUrl = "/{$cssCacheDir}client-{$rev}.min.css";
        $cssUrl = str_replace('//', '/', $cssUrl);
        $this->setValue('cssUrl', $cssUrl);

        $jsUrl = "/{$jsCacheDir}client-{$rev}.min.js";
        $jsUrl = str_replace('//', '/', $jsUrl);
        $this->setValue('jsUrl', $jsUrl);*/

        //-------------------Конец вывода склееных и сжатых css и js файлов-----------------------//
    }


    /**
     * Get TextPage By Logicclass
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

    private function _seoTitle_en2ru($s) {
        $s = $s[1];

        if (preg_match("/[a-z]+/ius", $s)) {
            // если найдены буквы
            if (preg_match("/\s+$/ius", $s)) {
                // если в конце есть пробел

                $t = StringUtils_Transliterate::TransliterateEnToRu($s);

                $s .= '' . $t . ' ';
            } elseif (preg_match("/^\s+/ius", $s)) {
                // в начале есть пробел

                $t = StringUtils_Transliterate::TransliterateEnToRu($s);

                $s .= ' ' . $t . '';
            }
        }

        return $s;
    }

    /**
     * Заменить ключевые слова
     */
    private function _processKeywords($s) {
        $s = str_replace('[phones]', Shop::Get()->getSettingsService()->getSettingValue('header-phone'), $s);
        $s = str_replace('[slogan]', Shop::Get()->getSettingsService()->getSettingValue('shop-slogan'), $s);
        $s = str_replace('[shopname]', Shop::Get()->getSettingsService()->getSettingValue('shop-name'), $s);
        return $s;
    }

}