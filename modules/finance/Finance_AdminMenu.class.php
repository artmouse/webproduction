<?php

class Finance_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // добавляем финансы в верхнее меню
        Shop_ModuleLoader::Get()->registerTopMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_financial_accounting'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-finance-index'),
            'finance',
            'icon-money'
        );

        // добавляем "отчет по категориям"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Финансовый отчет по категориям',
            Engine::GetLinkMaker()->makeURLByContentID('shop-finance-category-order'),
            'finance-report-category'
        );

        // добавляем "отчет по кошелькам"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Финансовый отчет по кошелькам',
            Engine::GetLinkMaker()->makeURLByContentID('shop-finance-account-order'),
            'finance-report-account'
        );

        // добавляем "кошельки" в меню настроек
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_finances_purses_and_accounts'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-finance-account')
        );

        // добавляем "категории" в меню настроек
        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_finances_category_and_funds'),
            Engine::GetLinkMaker()->makeURLByContentID('shop-finance-category')
        );
    }

}