<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_SearchLog extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new XShopSearchLog();
        $x->setOrder('cdate', 'DESC');
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_and_time'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('query');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_inquiry'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('countresult');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_displaying_the_results'));
        $this->addField($field);
    }

}