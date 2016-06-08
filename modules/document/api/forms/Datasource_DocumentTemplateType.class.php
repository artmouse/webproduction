<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_DocumentTemplateType extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption(
            'ShopOrder',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_k_proektam_i_zakazam')
        );
        $this->addOption('User', Shop::Get()->getTranslateService()->getTranslateSecure('translate_k_kontaktam'));

        if (Shop_ModuleLoader::Get()->isImported('storage')) {
            $this->addOption(
                'ShopStorageTransaction',
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_k_skladskoy_operatsii')
            );
        }
    }

}