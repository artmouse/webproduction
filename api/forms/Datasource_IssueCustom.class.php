<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Datasource_IssueCustom extends Forms_ADataSourceSQLObject {

    public function __construct($type = false) {
        $this->setType($type);
    }

    public function setType($type) {
        $this->_type = $type;
    }

    /**
     *  Получить задачи
     *
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();
            $issues = Shop::Get()->getShopService()->getOrdersAll($cuser, true);
            $issues->setType($this->_type);
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

        /*if ($this->_type == 'project') {
            $field = new Forms_ContentFieldControlLink('id', 'admin-project-control', 'id');
            $field->setName('#');
            $this->addField($field);

            $field = new Forms_ContentFieldControlLink('name', 'admin-project-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
            $this->addField($field);

        } elseif ($this->_type == 'issue') {
            $field = new Forms_ContentFieldControlLink('id', 'admin-issue-control', 'id');
            $field->setName('#');
            $this->addField($field);

            $field = new Forms_ContentFieldControlLink('name', 'admin-issue-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
            $this->addField($field);

        } elseif ($this->_type == 'order' || !$this->_type) {
            $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orders-control', 'id');
            $field->setName('#');
            $this->addField($field);

            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-orders-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
            $this->addField($field);

        } else {
            $field = new Forms_ContentFieldControlLinkParams(
                'id',
                'custom-issue-shop-control',
                array('id' => 'id', 'type' => 'type')
            );
            $field->setName('#');
            $this->addField($field);

            $field = new Forms_ContentFieldControlLinkParams('name', 'custom-issue-shop-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
            $this->addField($field);
        }*/

        $field = new Forms_ContentFieldControlLinkParams(
            'id',
            'custom-issue-shop-control',
            array('id' => 'id', 'type' => 'type')
        );
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldControlLinkParams(
            'name',
            'custom-issue-shop-control',
            array('id' => 'id', 'type' => 'type')
        );
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('sum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $field = new Shop_ContentField_Order_SumPayed('sum_payed');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum_payed'));
            $this->addField($field);
        }

        $field = new Forms_ContentFieldDatetime('dateto', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_execute_to'));
        $field->setQuickedit(true);
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

        $field = new Forms_ContentFieldControlLinkParams(
            'cdate',
            'custom-issue-shop-control',
            array('id' => 'id', 'type' => 'type')
        );
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_issue_to'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('forgift');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_dlya_podarka'));
        $this->addField($field);

        $field = new Shop_ContentFieldOrderComment('comments');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        //$field->setQuickedit(true);
        $field->setSortable(false);
        $field->setEditable(false);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Shop_ContentFieldOutcoming('outcoming');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $field->setEditable(false);
        $this->addField($field);

        // товары
        $field = new Shop_ContentField_Order_Products('products');
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $this->addField($field);

        $field = new Forms_ContentField('clientname');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_fio'));
        $this->addField($field);

        $field = new Forms_ContentField('clientemail');
        $field->setName('Email');
        $this->addField($field);

        $field = new Forms_ContentField('clientphone');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_telephone'));
        $this->addField($field);

        $field = new Forms_ContentField('clientaddress');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_address'));
        $this->addField($field);

        $field = new Forms_ContentField('clientcontacts');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contacts'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('authorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_legal_entity'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('sourceid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Source'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_istochnik'));
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_obnovlenie'));
        $this->addField($field);

        $field = new Forms_ContentField('type');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_WorkflowType'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $this->addField($field);
    }

    private $_sqlobject;
    private $_type;
}