<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_PageLogicclass extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('shop-guestbook', Shop::Get()->getTranslateService()->getTranslateSecure('translate_reviews_of_the_store').' (guestbook)');
        $this->addOption('shop-payment', Shop::Get()->getTranslateService()->getTranslateSecure('translate_ways_to_pay'));
        $this->addOption('shop-delivery', Shop::Get()->getTranslateService()->getTranslateSecure('translate_delivery_methods'));
        $this->addOption('shop-faq', Shop::Get()->getTranslateService()->getTranslateSecure('translate_faq').' (FAQ)');
        $this->addOption('shop-news', Shop::Get()->getTranslateService()->getTranslateSecure('translate_site_news'));
        $this->addOption('shop-gallery', Shop::Get()->getTranslateService()->getTranslateSecure('translate_gallery'));
        $this->addOption('shop-news-view-key', Shop::Get()->getTranslateService()->getTranslateSecure('translate_view_news_by_ID'));
        $this->addOption('shop-product-list-key', Shop::Get()->getTranslateService()->getTranslateSecure('translate_view_the_list_of_products_on_the_key'));
        $this->addOption('shop-page-content', Shop::Get()->getTranslateService()->getTranslateSecure('translate_special_page'));
        $this->addOption('shop-page-html', Shop::Get()->getTranslateService()->getTranslateSecure('translate_special_page_html'));
        $this->addOption('shop-page-yandex-map', Shop::Get()->getTranslateService()->getTranslateSecure('translate_shop_page_yandex_map'));
    }

}