<?php
class shop_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/shop.loading.js');
        PackageLoader::Get()->registerJSFile('/_js/jquery.lazyload.min.js');

        $this->setValue('shopname', Shop::Get()->getSettingsService()->getSettingValue('shop-name'));
        // выводить или нет ссылку сравнения товаров
        // @todo: кривой код
        $this->setValue('countCompare', Shop::Get()->getCompareService()->getCompareProducts()->getCount());
        $url = Engine::Get()->getProjectURL().Engine::GetURLParser()->getTotalURL();
        $this->setValue('canonical', $url);

//        $txt = new XMainText();
//        $txt->setNum(1);
//        if ($txt->select()) {
//            $this->setValue('first_text', $txt->getText());
//        }

//        $txt = new XMainText();
//        $txt->setNum(2);
//        if ($txt->select()) {
//            $this->setValue('second_text', $txt->getText());
//        }
        // редиректы
        $host = Engine::GetURLParser()->getHost();
        $projecthost = Engine::Get()->getProjectHost();
        if ($host != $projecthost
            && (Engine::Get()->getRequest()->getContentID() != 'shop-category'
                && Engine::Get()->getRequest()->getContentID() != 'shop-product')
        ) {
            $url = Engine::Get()->getProjectURL().Engine::GetURLParser()->getTotalURL();
            $this->setValue('canonical', $url);
            header('Location: '.$url);
            exit();
        }

        // интеграции (настройки)
        $contentID = Engine::Get()->getRequest()->getContentID();

        // интеграции
        $content = Engine::GetContentDriver()->getContent($contentID);
        if ($content->getField('moveto') != 'shop-client-tpl'
            && $content->getField('id') != 'shop-basket'
            && $content->getField('id') != 'shop-order') {
            $this->setValue(
                'integration_cloudim',
                Shop::Get()->getSettingsService()->getSettingValue('integration-cloudim')
            );
            $this->setValue(
                'integration_ga',
                Shop::Get()->getSettingsService()->getSettingValue('integration-googleanalytics')
            );
            $this->setValue(
                'integration_google_wmt',
                Shop::Get()->getSettingsService()->getSettingValue('integration-google-wmt')
            );
            $this->setValue(
                'integration_yandex_wmt',
                Shop::Get()->getSettingsService()->getSettingValue('integration-yandex-wmt')
            );
            $this->setValue(
                'integration_liveinternet',
                Shop::Get()->getSettingsService()->getSettingValue('integration-liveinternet')
            );
        }

        // ------------------------------------------------- //

        // показывать или нет ссылку на админ панель
        // показываем информацию о юзере
        $this->setValue('admin', false);
        try {
            $this->setValue('userlogin', $this->getUser()->getLogin());
            $this->setValue('avatar', $this->getUser()->makeImageGravatar());

            if ($this->getUser()->isAdmin()) {
                $this->setValue('admin', true);
            }
        } catch (Exception $e) {

        }

        // настройки
        $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
        $phones = explode(',', $phones);
        $cnt = count($phones);


        for ($i = 1; $i< $cnt+1;$i++) {

            $this->setValue("phone$i", $phones[$i-1]);

        }

        $this->setValue('icq', Shop::Get()->getSettingsService()->getSettingValue('header-icq'));
        $this->setValue('skype', Shop::Get()->getSettingsService()->getSettingValue('header-skype'));
        $this->setValue('address', Shop::Get()->getSettingsService()->getSettingValue('company-address'));
        $this->setValue('email', Shop::Get()->getSettingsService()->getSettingValue('header-email'));
        $this->setValue('logo', Shop::Get()->getSettingsService()->getSettingValue('header-logo'));
        $this->setValue('shopName', htmlspecialchars(Shop::Get()->getSettingsService()->getSettingValue('shop-name')));
        $this->setValue('copyright', Shop::Get()->getSettingsService()->getSettingValue('copyright'));
        $this->setValue('background', Shop::Get()->getSettingsService()->getSettingValue('background-image'));

        try {
            $logo = Shop::Get()->getShopService()->getLogoCurrent();
            $this->setValue('logo', $logo->makeImage());
        } catch (ServiceUtils_Exception $le) {

        }


        if ($this->getArgumentSecure('ok')) {

            $this->setValue('callmessage', 'ok');

            try {
                $user = $this->getUser();
            } catch (Exception $e) {
                $user = Shop::Get()->getUserService()->addUserClient(
                    $this->getControlValue('cbname'),
                    false,
                    false,
                    false,
                    $this->getControlValue('cbphone'),
                    false, // address
                    false, // company
                    false, // department
                    false, // time
                    false, // comment admin
                    'callback' // group type
                );
            }

            Shop::Get()->getCallbackService()->addCallback(
                $this->getControlValue('cbname'),
                $this->getControlValue('cbphone'),
                '',
                $user
            );

        }

        // заполняем по умолчанию данными форму callback'a
        try {
            $u = $this->getUser();

            if (!$this->getValue('ok')) {
                $this->setControlValue('cbname', $u->getName());
                $this->setControlValue('cbphone', $u->getPhone());
            }
        } catch (Exception $e) {

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

            if ($seo->getSeocontent()) {
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

        // интеграция с loginza
        $loginzaVerification = Shop::Get()->getSettingsService()->getSettingValue('loginza-verification');
        $this->setValue('loginzaVerification', $loginzaVerification);

        $loginzaServices = Shop::Get()->getSettingsService()->getSettingValue('loginza-services');
        $loginzaWidgetID = Shop::Get()->getSettingsService()->getSettingValue('loginza-widgetid');
        $loginzaServices = str_replace(' ', '', $loginzaServices);
        $loginzaServices = trim($loginzaServices);
        if ($loginzaWidgetID && $loginzaServices) {
            $loginzaTokenURL = Engine::Get()->getProjectURL().Engine::GetURLParser()->getCurrentURL();
            $loginzaTokenURL = urlencode($loginzaTokenURL);
            $loginzaURL = "https://loginza.ru/api/widget?token_url=".
                $loginzaTokenURL. "&providers_set=".$loginzaServices;
            $this->setValue('loginzaURL', $loginzaURL);
        }

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));

        // !!! эти строки должны быть в самом конце !!!
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
        // !!! после этой строки ничего не дописывать !!!
    }

    private function _makePagesUrlByLogicclass($logicclass) {
        try {
            return Shop::Get()->getTextPageService()->getTextPageByLogicclass($logicclass)->makeURL();
        } catch (Exception $e) {
            return false;
        }
    }

}