<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_Document extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $this->_sqlobject = DocumentService::Get()->getDocumentsAll();
        }
        return $this->_sqlobject;
    }

    public function setSQLObject($sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('number');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_document_number'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title_of_document'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('templateid');
        $field->setDataSource(new Datasource_DocumentTemplate());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tip_dokumenta'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setDataSource(new Datasource_Contractors());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contractor'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $this->addField($field);

        $field = new Document_ContentField_LinkKey('linkkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_privyazka'));
        $this->addField($field);

        $field = new Document_ContentField_Status('status');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sformirovan'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('sdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_otpravlen'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('bdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_poluchen'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('adate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_arhiv'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('edate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_srok_okonchaniya'));
        $this->addField($field);

        $user = Shop::Get()->getUserService()->getUser();
        if ($user->isAllowed('documents-all-delete')) {
            $field = new Document_ContentField_Delete(
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_delete')
            );
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_delete'));
            $this->addField($field);
        }

        $field = new Forms_ContentFieldControlLink('print', 'shop-admin-document-print', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_print'));
        $field->getContentView()->setFileHTML(dirname(__FILE__).'/Document_ContentFieldPrint.html');
        $this->addField($field);
    }

    private $_sqlobject;
}