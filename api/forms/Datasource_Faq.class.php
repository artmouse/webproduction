<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Golub Oleksii <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Faq extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = Shop::Get()->getFaqService()->getFaqAll();
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-faq-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('question');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_question'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('answer');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_answer'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid', true);
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_small'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);
    }


}