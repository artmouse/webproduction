<?php
/**
 * WebProduction Shop (wpshop)
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_PageLogicclass extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption(
            'shop-guestbook', 
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_reviews_of_the_store').' (guestbook)'
        );
        $this->addOption('shop-payment', Shop_TranslateFormService::Get()->getTranslateSecure('translate_ways_to_pay'));
        $this->addOption(
            'shop-delivery',
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_delivery_methods')
        );
        $this->addOption('shop-faq', Shop_TranslateFormService::Get()->getTranslateSecure('translate_faq').' (FAQ)');
        $this->addOption('shop-news', Shop_TranslateFormService::Get()->getTranslateSecure('translate_site_news'));
        $this->addOption('shop-gallery', Shop_TranslateFormService::Get()->getTranslateSecure('translate_gallery'));
        $this->addOption(
            'shop-news-view-key',
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_view_news_by_ID')
        );
        $this->addOption(
            'shop-product-list-key',
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_view_the_list_of_products_on_the_key')
        );
        $this->addOption(
            'shop-page-content',
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_special_page')
        );
        $this->addOption(
            'shop-page-html',
            Shop_TranslateFormService::Get()->getTranslateSecure('translate_special_page_html')
        );
        $this->addOption('shop-forms-bonus-cart', 'Форма заказа бонусной карты');
    }

}