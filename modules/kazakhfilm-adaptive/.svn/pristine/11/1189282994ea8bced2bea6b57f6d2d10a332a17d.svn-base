<?php
class Datasource_Main_Text extends Forms_ADataSourceSQLObject {


    public function getSQLObject() {
        $x = new XMainText();
        return $x;
    }

    protected function _initialize() {

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-main-control', 'id');
        $field->setEditable(false);
        $field->setName('id');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('text');
        $field->setName('Text');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('num');
        $field->setName('Номер блока');
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);


    }
}