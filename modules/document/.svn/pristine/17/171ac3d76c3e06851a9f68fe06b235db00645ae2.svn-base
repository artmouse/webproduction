<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Источник данных: направление документов
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_DocumentTemplateDirection extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('our', Shop::Get()->getTranslateService()->getTranslateSecure('translate_vnutrennie'));
        $this->addOption('in', Shop::Get()->getTranslateService()->getTranslateSecure('translate_vhodyashchie'));
        $this->addOption('out', Shop::Get()->getTranslateService()->getTranslateSecure('translate_ishodyashchie'));
    }

}