<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_SEO extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getSEOService()->getSEOAll();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setName('URL');
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName('Title');
        $this->addField($field);

        $field = new Forms_ContentField('seoh1');
        $field->setName( 'SEO h1');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName('meta-keywords');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName('meta-description');
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName('SEO text');
        $this->addField($field);
    }

}