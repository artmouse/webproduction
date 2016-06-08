<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Datasource for IMAP config
 *
 * @copyright WebProduction
 * @package   OneBox
 */
class Datasource_IMAPconfig extends Forms_ADataSourceSQLObject {

    /**
     * GetSQLObject
     *
     * @return XShopEventIMAPConfig
     */
    public function getSQLObject() {
        return new XShopEventIMAPConfig();
    }


    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('email');
        $field->setName('Email');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('host');
        $field->setName('IMAP Host');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('port');
        $field->setName('IMAP Port');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('username');
        $field->setName('IMAP UserName');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('password');
        $field->setName('IMAP Password');
        $this->addField($field);

    }

}