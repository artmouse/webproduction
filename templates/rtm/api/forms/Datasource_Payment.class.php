<?php
/**
 * WebProduction Shop (wpshop)
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

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            foreach ($fieldsArray as $field) {
                if ($field->getEditable() && $field->getKey() == 'default' && $field->getValue() == 1) {
                    $x = new ShopPayment();
                    $x->setDefault(1);
                    if ($x->select()) {
                        throw new ServiceUtils_Exception('default payment already exist');
                    }
                }
            }

            $r = parent::insert($fieldsArray);

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function update($key, $fieldsArray) {
        try {
            SQLObject::TransactionStart();

            foreach ($fieldsArray as $field) {
                if ($field->getEditable() && $field->getKey() == 'default' && $field->getValue() == 1) {
                    $x = new ShopPayment();
                    $x->addWhere('id', $key, '<>');
                    $x->setDefault(1);
                    if ($x->select()) {
                        throw new ServiceUtils_Exception('default payment already exist');
                    }
                }
            }

            parent::update($key, $fieldsArray);

            SQLObject::TransactionCommit();

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-payment-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('deliveryid', true);
        $field->setDataSource(new Datasource_Delivery());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_delivery'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('description');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_description_of_payment'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('additionalinfo');
        $field->setName('Показывать дополнительную информацию');
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('additionalinfo');
        $field->setName('Дополнительная информация( выводится после оформления заказа )');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('showinfo');
        $field->setName('Показывать дополнительную информацию');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName('Оплпта по умолчанию');
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('contentid', true);
        $field->setDataSource(new Datasource_PaymentContent());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_automation'));
        $this->addField($field);

        if (Engine::Get()->getConfigFieldSecure('paysystem-status') && Shop::Get()->getSettingsService()->getSettingValue('paysystem-status')) {
            $field = new Forms_ContentFieldSelectList('logicclass', true);
            $field->setDataSource(new Datasource_PaymentLogicclass());
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_logic_of_payment'));
            $this->addField($field);
        }
    }

}