<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_CategoryDefaultSort extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false, $sortDefault = false) {
        parent::__construct($optionsArray);

        if (!$sortDefault) {
            return;
        }

        $this->addOption(
            'rating',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_rating')
        );
        $this->addOption(
            'ordered',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_ordered')
        );
        $this->addOption(
            'name',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_name')
        );
        $this->addOption(
            'price-asc',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_price_asc')
        );
        $this->addOption(
            'price-desc',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_price_desc')
        );
        $this->addOption(
            'avail',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_avail')
        );
    }

}