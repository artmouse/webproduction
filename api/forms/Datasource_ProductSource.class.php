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
class Datasource_ProductSource extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption("", Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_or_supplier'));
        $this->addOption("service", Shop::Get()->getTranslateService()->getTranslateSecure('translate_service_unlimited_replicability'));
        $this->addOption("servicebusy", Shop::Get()->getTranslateService()->getTranslateSecure('translate_service_with_net_employment'));
    }

}