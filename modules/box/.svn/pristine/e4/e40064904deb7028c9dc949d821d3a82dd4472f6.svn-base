<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Источник данных для ролей
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 *
 * @copyright WebProduction
 * 
 * @package Shop
 */
class Datasource_Role extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $role = new XShopRole();
        $role->setOrder('name', 'ASC');
        return $role;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-role-control', 'key');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_roli'));
        $field->setQuickedit(true);
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_opisanie_roli'));
        $this->addField($field);

        $field = new Forms_ContentField('blockcolor');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_cvet_bloka_roli'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('parentid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Role'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_podchinyaetsya'));
        $field->addValidator(new Forms_ValidatorParentId());
        $field->setQuickedit(true);
        $this->addField($field);

        for ($j = 1; $j <= 10; $j++) {
            $field = new Forms_ContentFieldSelectList('kpi'.$j.'id', true);
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_KPI'));
            $field->setName('KPI'.$j);
            $field->setQuickedit(true);
            $field->setEmptyOptionName('');
            $field->setEmptyOptionValue(0);
            $this->addField($field);

            $field = new Forms_ContentField('kpi'.$j.'param');
            $field->setName('KPI'.$j.' параметр');
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentField('kpi'.$j.'value');
            $field->setName('KPI'.$j.' фактическое значение');
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentFieldSelectList('salary'.$j.'workflowid', true);
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Workflow'));
            $field->setName('KPI'.$j.' БП для ЗП');
            $this->addField($field);

            $field = new Forms_ContentField('salary'.$j.'koef');
            $field->setName('KPI'.$j.' коефициент для ЗП');
            $this->addField($field);
        }
    }

}