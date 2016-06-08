<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Заказы для отгрузки
 *
 * @copyright WebProduction
 * @package   Shop
 */
class Datasource_OrdersForShipment extends Forms_ADataSourceSQLObject {

    /**
     * Получить заказы
     *
     * @return ShopOrder
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $orders = Shop::Get()->getShopService()->getOrdersAll();

            // нас интересуют только не отгруженные товары
            $orders->setIsshipped(0);

            // только входящие заказы
            $orders->setOutcoming(0);

            // только заказы, в которых есть товары
            $orders->addWhereQuery(
                'EXISTS (SELECT * FROM `shoporderproduct` WHERE `shoporderproduct`.`orderid` = `shoporder`.`id`)'
            );

            $this->_sqlobject = $orders;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_issued'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('sum');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sum'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('managerid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_manager'));
        $this->addField($field);

        /*if (Engine::Get()->getConfigFieldSecure('finance-status')) {
            $field = new Forms_ContentField('sumpaid');
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_paid'));
            $field->setSortable(false);
            $field->setEditable(false);
            $this->addField($field);
        }*/

        $field = new Forms_ContentFieldSelectList('statusid');
        $field->setDataSource(new Datasource_OrderStatus());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_status'));
        $this->addField($field);

        $field = new Shop_ContentFieldUserInfo('userid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_client_user'));
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

        $field = new Shop_ContentField_Actions(
            'actions',
            array(
                array(
                    'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_storage_ship'),
                    'contentID' => 'shop-admin-storage-order-tosale'
                ),
                array(
                    'actionName' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_order_goto'),
                    'contentID' => 'shop-admin-orders-control'
                )
            )
        );
        $field->setSortable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_actions'));
        $this->addField($field);
    }

    private $_sqlobject;

}