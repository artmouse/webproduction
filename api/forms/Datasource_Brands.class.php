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
class Datasource_Brands extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getBrandsAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_choice'));
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_brand_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_URL_prefix'));
        $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden_brand'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('top');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_top_brand'));
        $this->addField($field);

        $field = new Forms_ContentField('country');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_country_brand'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('showtype');
        $field->setDataSource(new Datasource_CategoryShowType());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_viewing_mode'));
        $this->addField($field);

        $field = new Forms_ContentField('siteurl');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_website_brand'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('description');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_description'));
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_title'));
        $this->addField($field);

        $field = new Forms_ContentField('seoh1');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_h1'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_keywords'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_description'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_text'));
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $brand = Shop::Get()->getShopService()->getBrandByID($r);

                CommentsAPI::Get()->addComment(
                'shop-history-brand-'.$r,
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_added_a_new_brand').' #'.$r.' '.$brand->getName(),
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

                $brand = Shop::Get()->getShopService()->getBrandByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                'shop-history-brand-'.$brand->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_edited_by_brand').' #'.$brand->getId().' '.$brand->getName()."\n".implode("\n", $diffArray),
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
            $brand = Shop::Get()->getShopService()->getBrandByID($key);
            if ($brand->getProducts()->getCount()) {
                throw new ServiceUtils_Exception();
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-brand-'.$brand->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_removed_brand').' #'.$brand->getId().' '.$brand->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }

}