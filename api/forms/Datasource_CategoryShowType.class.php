<?php

/**
 * Datasource_CategoryShowType
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_CategoryShowType extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false, $categories = false) {
        parent::__construct($optionsArray);

        if ($optionsArray) {
            $this->addOption(
                'carousel',
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_carousel')
            );
        }

        if ($categories) {
            $this->addOption(
                'subcategoryonly',
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_default_sub_categories')
            );
        }

        $this->addOption(
            'thumbsonly',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_pictures_by_default')
        );
        $this->addOption(
            'tableonly',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_list_default_table')
        );
        $this->addOption(
            'thumbsgrouped',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_pictures_by_default_grouped')
        );
        $this->addOption(
            'tablegrouped',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_list_default_table_grouped')
        );
        $this->addOption(
            'set',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_naborom_na_otdelnoy_stranitse')
        );
    }

}