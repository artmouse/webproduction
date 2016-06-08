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
class Datasource_Redirect extends Forms_ADataSourceSQLObject {

    /**
     * @return XShopRedirect
     */
    public function getSQLObject() {
        return new XShopRedirect();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('urlfrom');
        $field->setName('URL from');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('urlto');
        $field->setName('URL to');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldInt('code');
        $field->setName('Code');
        $this->addField($field);
    }

}