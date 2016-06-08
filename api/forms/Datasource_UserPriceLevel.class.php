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
class Datasource_UserPriceLevel extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        $this->addOption('0', Shop::Get()->getTranslateService()->getTranslateSecure('translate_usual_prices'));
        for ($j = 1; $j <= 5; $j++) {
            $this->addOption($j, $j);
        }
    }

}