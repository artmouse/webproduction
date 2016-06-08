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
class Datasource_SMSLog extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        $log = new SMSUtils_XTurbosmsuaQue();
        $log->setOrder('cdate', 'DESC');
        return $log;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_powered_by'));
        $this->addField($field);

        $field = new Forms_ContentField('pdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_processed'));
        $this->addField($field);

        $field = new Forms_ContentField('sender');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sender'));
        $this->addField($field);

        $field = new Forms_ContentField('to');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_recipient'));
        $this->addField($field);

        $field = new Forms_ContentField('content');
        $field->setName('SMS');
        $this->addField($field);

        $field = new Forms_ContentField('result');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $this->addField($field);
    }

}