<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Подгрузка контентов по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_global_settings'),
            '/admin/shop/settings/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_timework'),
            '/admin/shop/timework/',
            'timework'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_logo'),
            '/admin/shop/logo/',
            'logo'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_blocks'),
            '/admin/shop/block/',
            'block'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_banner'),
            '/admin/shop/banner/',
            'banner'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_faq'),
            '/admin/shop/faq/',
            'faq'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_callback_small'),
            '/admin/shop/callback/',
            'callback'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_currency'),
            '/admin/shop/currency/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_coupons_promocodes_certificates'),
            '/admin/shop/coupon/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_priceplace'),
            '/admin/shop/priceplaces/',
            'priceplaces'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_delivery_methods'),
            '/admin/shop/delivery/',
            'delivery'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment_template'),
            '/admin/comment/template/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_feedback'),
            '/admin/shop/feedback/',
            'feedback'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_reviews_of_the_store'),
            '/admin/shop/guestbook/',
            'guestbook'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_ways_to_pay'),
            '/admin/shop/payment/',
            'payment'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_biznes_protsessi'),
            '/admin/shop/workflow/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_tipi_biznes_protsessov'),
            '/admin/shop/workflowtype/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_notice_availability'),
            '/admin/shop/products/noticeavailability/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_products_icon'),
            '/admin/shop/products/icon/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_news'),
            '/admin/shop/news/',
            'news'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_discounts'),
            '/admin/shop/discount/'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_contractors'),
            '/admin/shop/contractors/',
            'contractors'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_gallery'),
            '/admin/shop/gallery/',
            'gallery'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_textpages'),
            '/admin/shop/textpages/'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_activity'),
            '/admin/shop/activity/'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_statistics_search'),
            '/admin/shop/statistics/search/'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_history_change_of_product'),
            '/admin/shop/history-change-product/'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_users_online'),
            '/admin/shop/online/'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_history_of_SMS'),
            '/admin/shop/smslog/'
        );
    }

}