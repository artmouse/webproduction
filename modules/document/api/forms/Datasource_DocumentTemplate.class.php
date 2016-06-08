<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Шаблоны документов
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_DocumentTemplate extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return DocumentService::Get()->getDocumentTemplatesAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title_of_document'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('groupname');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_gruppa_dokumentov'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('direction');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_napravlenie'));
        $field->setDataSource(new Datasource_DocumentTemplateDirection());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('type');
        $field->setName('К чему относится?');
        $field->setDataSource(new Datasource_DocumentTemplateType());
        $field->setQuickedit(true);
        $this->addField($field);

        // Внимание! Тут лучше не ставить CKEditor!
        $field = new Forms_ContentFieldTextarea('content');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_shablon_dokumenta'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('required');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_obyazatelniy_dokument'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('period');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_srok_deystviya_dokumenta_v_dnyah')
        );
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sort_order'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('numberprocessor');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_programmniy_obrabotchik_numeratsii')
        );
        $field->setQuickedit(true);
        $this->addField($field);
    }

}