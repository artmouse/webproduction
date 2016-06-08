<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_DiscountType extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('percent', Shop::Get()->getTranslateService()->getTranslateSecure('translate_percentage'));
        $this->addOption('value', Shop::Get()->getTranslateService()->getTranslateSecure('translate_total'));
    }

}