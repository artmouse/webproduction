<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_ProductFilterType extends Forms_ADataSourceEnum {

    public function __construct() {
        $this->addOption('interval', Shop::Get()->getTranslateService()->getTranslateSecure('translate_interval'));
        $this->addOption('intervalselect', Shop::Get()->getTranslateService()->getTranslateSecure('translate_intervalselect'));
        $this->addOption('intervalslider', Shop::Get()->getTranslateService()->getTranslateSecure('translate_intervalslider'));
        $this->addOption('select', Shop::Get()->getTranslateService()->getTranslateSecure('translate_drop_down_list'));
        $this->addOption('checkbox', Shop::Get()->getTranslateService()->getTranslateSecure('translate_checkmark').' (checkbox)');
        $this->addOption('radiobox', Shop::Get()->getTranslateService()->getTranslateSecure('translate_switches').' (radiobox)');
    }

}