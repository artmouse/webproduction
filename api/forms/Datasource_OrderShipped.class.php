<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_OrderShipped extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false, $categories = false) {
        parent::__construct($optionsArray);

        $this->addOption(0, '-');
        $this->addOption(1, Shop::Get()->getTranslateService()->getTranslateSecure('translate_shipped'));
    }

}