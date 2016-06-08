<?php

class Datasource_FinanceInvoice_Type extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false, $categories = false) {
        $categories;
        parent::__construct($optionsArray);

        $this->addOption('in', Shop::Get()->getTranslateService()->getTranslateSecure('translate_client_from'));
        $this->addOption('out', Shop::Get()->getTranslateService()->getTranslateSecure('translate_client_to'));
    }

}