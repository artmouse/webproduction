<?php
/**
 * OneBox
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * @author Oleksii Golub <avator@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_Payment extends Forms_ADataSourceSQLObject {

    /**
     * @return XShopPayment
     */
    public function getSQLObject() {
        return Shop::Get()->getShopService()->getPaymentAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-payment-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('deliveryid', true);
        $field->setDataSource(new Datasource_Delivery());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_delivery'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_description_of_payment'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_default'));
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contentid', true);
        $field->setDataSource(new Datasource_PaymentContent());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_automation'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('paysystem-status') && Shop::Get()->getSettingsService()->getSettingValue('paysystem-status')) {
            $field = new Forms_ContentFieldSelectList('logicclass', true);
            $field->setDataSource(new Datasource_PaymentLogicclass());
            $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_logic_of_payment'));
            $this->addField($field);
        }
    }

}