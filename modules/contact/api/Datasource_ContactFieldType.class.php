<?php

class Datasource_ContactFieldType extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('system', Shop::Get()->getTranslateService()->getTranslateSecure('translate_sistemnoe'));
        $this->addOption('string', Shop::Get()->getTranslateService()->getTranslateSecure('translate_stroka'));
        $this->addOption('text', Shop::Get()->getTranslateService()->getTranslateSecure('translate_tekst'));
        $this->addOption('bool', Shop::Get()->getTranslateService()->getTranslateSecure('translate_galochka'));
        $this->addOption('check', Shop::Get()->getTranslateService()->getTranslateSecure('translate_danet'));
        $this->addOption('date', Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addOption('datetime', Shop::Get()->getTranslateService()->getTranslateSecure('translate_datetime'));
    }

}