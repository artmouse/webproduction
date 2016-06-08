<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Datasource_FinanceCategory extends Forms_ADataSourceSQLObject {

    /**
     * Get all categories
     *
     * @return FinanceCategory
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $category = FinanceService::Get()->getCategoryAll();

            $this->_sqlobject = $category;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nazvanie_kategorii'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('active');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_aktivna'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('isfund');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_eto_fond'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('fundpercent');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_protsent_otchistyaemiy_v_fond')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('fundsum');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_summa_otchistyaemaya_v_fond')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('fundtotal');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_summa_fonda'));
        $this->addField($field);
    }

    private $_sqlobject;

}