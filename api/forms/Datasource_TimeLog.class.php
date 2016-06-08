<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @deprecated
 * @todo remove
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_TimeLog extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $x = new XShopTimeLog();
        $x->setOrder('cdate', 'DESC');

        $x->addFieldQuery("(
        SELECT SUM(amount)
        FROM shoptimelog x
        WHERE
            x.cdate <= shoptimelog.cdate
            AND shoptimelog.id != x.id
            AND x.userid = shoptimelog.userid
        ) AS balance");

        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_agent'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_and_time'));
        $this->addField($field);

        $field = new Forms_ContentField('amount');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_time'));
        $this->addField($field);

        $field = new Forms_ContentField('balance');
        $field->setLink('`balance`');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_balance'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('linkkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_link_URL'));
        $this->addField($field);
    }

}