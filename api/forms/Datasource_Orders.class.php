<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */


class Datasource_Orders extends Forms_ADataSourceSQLObject {

    /**
     * GetSQLObject
     *
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $cuser = Shop::Get()->getUserService()->getUser();
            $orders = Shop::Get()->getShopService()->getOrdersAll($cuser);
            $orders->addWhereArray(array('', 'order'), 'type');
            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    public function setSQLObject($sqlobject) {
        $this->_sqlobject = $sqlobject;
    }

    public function getFieldPreview() {
        return $this->getField('id');
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName('#');
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orders-control', 'id');
        $field->setName('#');
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-number')) {
            $field = new Forms_ContentFieldControlLink('number', 'shop-admin-orders-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_nomer'));
            $this->addField($field);
        }

        if (Engine::Get()->getConfigFieldSecure('project-box-custom-order-name')) {
            $field = new Forms_ContentFieldControlLink('name', 'shop-admin-orders-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_imya_zakaza'));
            $field->setQuickedit(true);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-orders-control', 'id');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('dateshipped', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_dateshipped'));
        $this->addField($field);

        /*if (Shop_ModuleLoader::Get()->isImported('storage')) {
        $field = new Forms_ContentFieldSelectList('isshipped');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_shipped'));
        $field->setDataSource(new Datasource_OrderShipped());
        $this->addField($field);
        }*/

        $field = new Forms_ContentFieldDatetime('dateto', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_execute_to'));
        $field->setQuickedit(true);
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
            $field->setSortable(false);
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum_payed'));
            $this->addField($field);
        }

        // товары
        $field = new Shop_ContentField_Order_Products('products');
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('categoryid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_single_category'));
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_OrderCategory'));
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldSelectList('statusid');
        $field->setDataSource(new Datasource_OrderStatus());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Shop_ContentFieldOutcoming('outcoming');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_type_shot'));
        $field->setSortable(false);
        $field->setEditable(false);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
        $field->setEmptyOptionValue(0);
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

        $field = new Forms_ContentFieldCheckbox('forgift');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_dlya_podarka'));
        $this->addField($field);

        $field = new Shop_ContentFieldOrderComment('comments');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        //$field->setQuickedit(true);
        $field->setEditable(false);
        $field->setSortable(false);
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contractorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Contractors'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_legal_entity'));
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('project-box')) {
            $field = new Forms_ContentFieldSelectList('sourceid');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Source'));
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_istochnik'));
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);
        }

        $field = new Shop_ContentFieldUserInfo('authorid');
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Users'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_oformil'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('udate', 'Y-m-d H:i');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_obnovlenie'));
        $this->addField($field);
    }

    private $_sqlobject;

}