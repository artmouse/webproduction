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
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_OrdersNotPaid extends Forms_ADataSourceSQLObject {

    /**
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->addWhereQuery('`sum` > `sumpaid`');
            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        if (Engine::Get()->getConfigFieldSecure('finance-status')) {

            $field = new Forms_ContentFieldControlLink('id', 'shop-admin-orders-control', 'id');
            $field->setName('#');
            $this->addField($field);

            $field = new Forms_ContentFieldControlLink('cdate', 'shop-admin-orders-control', 'id');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_decorated'));
            $this->addField($field);

            $field = new Shop_ContentFieldUserInfo('userid');
            $field->setDataSource(new Datasource_Users());
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
            $this->addField($field);

            $field = new Forms_ContentField('clientname');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_fio'));
            $this->addField($field);

            $field = new Forms_ContentFieldSelectList('managerid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
            $field->setDataSource(new Datasource_UserManager());
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentFieldNumeric('sum');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
            $this->addField($field);

            $field = new Forms_ContentField('sumpaid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_paid'));
            $field->setEditable(false);
            $field->setSortable(false);
            $this->addField($field);

            $field = new Forms_ContentFieldSelectList('currencyid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
            $field->setDataSource(new Datasource_Currency());
            $this->addField($field);

        }
    }

    private $_sqlobject;

}