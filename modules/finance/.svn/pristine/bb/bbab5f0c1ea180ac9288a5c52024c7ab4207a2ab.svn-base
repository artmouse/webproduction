<?php

class Datasource_FinanceAccount extends Forms_ADataSourceSQLObject {

    /**
     * SQLObject
     *
     * @return FinanceAccount
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $account = FinanceService::Get()->getAccountsAll();

            $this->_sqlobject = $account;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_koshelka'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_opisanie_koshelka'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Currency'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('active');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_aktiven'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_legal_entity'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('balancestart');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_startoviy_balans'));
        $field->setQuickedit(true);
        $this->addField($field);
    }

    private $_sqlobject;

}