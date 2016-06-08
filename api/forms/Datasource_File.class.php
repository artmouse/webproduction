<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_File extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $this->_sqlobject = Shop::Get()->getFileService()->getFilesAll();
        }
        return $this->_sqlobject;
    }

    public function setSQLObject($sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'admin-file-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('name', 'admin-file-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_filename'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_data_zagruzki'));
        $this->addField($field);

        $field = new Forms_ContentField('contenttype');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_download'),
            'file-download',
            'id'
        );
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_download'));
        $field->getContentView()->setFileHTML(dirname(__FILE__).'/Shop_ContentFieldDownload.html');
        $this->addField($field);
    }

    private $_sqlobject;
}