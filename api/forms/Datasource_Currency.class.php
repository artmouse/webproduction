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
class Datasource_Currency extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getCurrencyService()->getCurrencyAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_currency'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('symbol');
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_symbol'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('rate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_course'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('default');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_basic'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden'));
        $this->addField($field);

        $field = new Forms_ContentField('logicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_autoupdate'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('percent');
        $field->setName('%');
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($r);

                CommentsAPI::Get()->addComment(
                'shop-history-currency-'.$r,
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_added_new_currency').' #'.$r.' '.$currency->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

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

            $r = parent::update($key, $fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                'shop-history-currency-'.$currency->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_edited_currency').' #'.$currency->getId().' '.$currency->getName()."\n".implode("\n", $diffArray),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function delete($key) {
        try {
            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($key);

            // если хотя-бы один товар
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setCurrencyid($currency->getId());
            if ($currency->select()) {
                throw new ServiceUtils_Exception();
            }

            // если хотя-бы один заказ
            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->setCurrencyid($currency->getId());
            if ($orders->select()) {
                throw new ServiceUtils_Exception();
            }

            // если хотя-бы один прайс
            $prices = Shop::Get()->getShopService()->getPricesAll();
            $prices->setCurrencyid($currency->getId());
            if ($prices->select()) {
                throw new ServiceUtils_Exception();
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-currency-'.$currency->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_removed_currency').' #'.$currency->getId().' '.$currency->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }

}