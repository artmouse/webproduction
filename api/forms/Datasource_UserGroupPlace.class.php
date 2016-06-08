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
class Datasource_UserGroupPlace extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('callback', Shop::Get()->getTranslateService()->getTranslateSecure('translate_to_call_backs'));
        $this->addOption('feedback', Shop::Get()->getTranslateService()->getTranslateSecure('translate_applied_to_the_shape_due'));
        $this->addOption('checkout', Shop::Get()->getTranslateService()->getTranslateSecure('translate_to_place_your_order'));
        $this->addOption('foundCheaper', Shop::Get()->getTranslateService()->getTranslateSecure('translate_applied_for_on_the_form_of_cheaply'));
    }

}