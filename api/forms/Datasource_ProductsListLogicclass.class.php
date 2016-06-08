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
class Datasource_ProductsListLogicclass extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('', Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_usual_list'));
        $this->addOption('ShopProductListLogicclassViewed12', Shop::Get()->getTranslateService()->getTranslateSecure('translate_most_viewed_products').' (12 шт.)');
        $this->addOption('ShopProductListLogicclassOrdered12', Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_most_ordered_products').' (12 шт.)');
        $this->addOption('ShopProductListLogicclassRecentlyOrdered', Shop::Get()->getTranslateService()->getTranslateSecure('translate_just_bought').' (12 шт.)');
        $this->addOption('ShopProductListLogicclassRecentlyViewed', Shop::Get()->getTranslateService()->getTranslateSecure('translate_just_viewed').' (12 шт.)');

    }

}