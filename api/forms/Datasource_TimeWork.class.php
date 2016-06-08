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
class Datasource_TimeWork extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getTimeworkAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-timework-control', 'key');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('datefrom');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_start_date'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('dateto');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_of_completion'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('comment');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $this->addField($field);
    }

}