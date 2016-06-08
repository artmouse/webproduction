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
class Datasource_BannerPlace extends Forms_ADataSourceEnum {

    public function __construct($optionsArray = false) {
        parent::__construct($optionsArray);

        try {
            $placeArray = Engine::Get()->getConfigField('shop-banner-place');

            foreach ($placeArray as $key => $x) {
                $this->addOption($key, $x['name']);
            }
        } catch (Exception $e) {

        }
    }

}