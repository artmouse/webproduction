<?php
/**
 * OneBox
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_OrderCategory extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getOrderCategoryAll();
    }

    public function getFieldPreview() {
        return $this->getField('name');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);
    }

}