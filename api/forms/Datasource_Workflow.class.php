<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_Workflow extends Forms_ADataSourceSQLObject {

    private $_workflow = false;
    public function __construct($workflow = false) {
        $this->_workflow = $workflow;
    }
    public function getSQLObject() {
        if ($this->_workflow) {
            $x = $this->_workflow;
        } else {
            $x = Shop::Get()->getShopService()->getWorkflowsAll();
        }
        return $x;
    }

    protected function _initialize() {
        $isBox = Engine::Get()->getConfigFieldSecure('project-box');

        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $this->addField($field);

        $field = new Shop_ContentField_WorkflowType('type');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_naznachenie'));
        $this->addField($field);

        $field = new Shop_ContentField_WorkflowDefault('default');
        $field->setName('');
        $this->addField($field);

        $field = new Shop_ContentField_WorkflowDirection('outcoming');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_napravlenie'));
        $this->addField($field);

        if ($isBox) {
            $field = new Forms_ContentFieldSelectList('currencyid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
            $field->setDataSource(new Datasource_Currency());
            $this->addField($field);

            $field = new Forms_ContentField('productsDefault');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('acl_products'));
            $this->addField($field);

            $field = new Forms_ContentField('term');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_srok_zhizni'));
            $this->addField($field);

            $field = new Forms_ContentField('keywords');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_klyuchevie_slova'));
            $this->addField($field);

            $field = new Forms_ContentField('issuename');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_shablon_imeni'));
            $this->addField($field);

            $field = new Shop_ContentFieldUserInfo('managerid');
            $field->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_otvetstvenniy_dlya_starta_novih_zadach'
                )
            );
            $this->addField($field);

            $field = new Forms_ContentFieldCheckbox('hidden');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden'));
            $this->addField($field);
        }
    }
}