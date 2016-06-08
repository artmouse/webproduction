<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_Issue extends Forms_ADataSourceSQLObject {

    /**
     *  Получить задачи
     *
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();
            $issues = IssueService::Get()->getIssuesAll($cuser);
            $issues->setType('issue');
            $this->_sqlobject = $issues;
        }
        return $this->_sqlobject;
    }

    public function setSQLObject($sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName('#');
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('id', 'admin-issue-control', 'id');
        $field->setName('#');
        $this->addField($field);

        /*if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-number')) {
        $field = new Forms_ContentFieldControlLink('number', 'issue-view', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nomer'));
        $this->addField($field);
        }*/

        /*$field = new Forms_ContentFieldSelectList('projectid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_proekt'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Project'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);*/

        //$field = new Shop_ContentFieldIssueInfo('name');
        $field = new Forms_ContentFieldControlLink('name', 'admin-issue-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_imya_zadachi'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('categoryid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_protsess'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('statusid');
        $field->setDataSource(new Datasource_OrderStatus());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('cdate', 'admin-issue-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_issue_to'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('dateto', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_execute_to'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('authorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_obnovlenie'));
        $this->addField($field);
    }

    private $_sqlobject;

}