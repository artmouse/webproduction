<?php
/**
 * WebProduction Shop (wpshop)
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Datasource_TextPages
 * 
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Datasource_TextPages extends Forms_ADataSourceSQLObject {

    public function __construct($level = true) {
        $this->_level = $level;
    }

    public function getSQLObject() {
        $x = new XShopTextPage();
        if ($this->_level) {
            $x->setParentid(0);
        }
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_page_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('content');
        $field->setName(Shop_TranslateFormService::Get()->getTranslate('translate_page_content'));
        $this->addField($field);

        $field = new Forms_ContentField('btnname');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_button_name'));
        // $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('parentid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_TextPages'));
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_parent_page'));
        $field->addValidator(new Forms_ValidatorParentId());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('logicclass', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_PageLogicclass'));
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_type_page'));
        $this->addField($field);

        $field = new Forms_ContentField('key');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_key'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_hidden'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_sort_order'));
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_URL_prefix'));
        // $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_title'));
        $this->addField($field);

        $field = new Forms_ContentField('seoh1');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_h1'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_description'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_text'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_keywords'));
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $x = new XShopTextPage($r);

                CommentsAPI::Get()->addComment(
                    'shop-history-textpage-'.$r,
                    Shop_TranslateFormService::Get()->getTranslateSecure('translate_added_a_new_page')
                    .' #'.$r.' '.$x->getName(),
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

                $textpage = new XShopTextPage($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                    'shop-history-textpage-'.$textpage->getId(),
                    Shop_TranslateFormService::Get()->getTranslateSecure('translate_edited_text_page')
                    .' #'.$textpage->getId().' '.$textpage->getName()."\n".implode("\n", $diffArray),
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
            $textpage = new XShopTextPage($key);

            $tmp = new XShopTextPage();
            $tmp->setParentid($key);
            if ($tmp->select()) {
                throw new ServiceUtils_Exception();
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-textpage-'.$textpage->getId(),
                    Shop_TranslateFormService::Get()->getTranslateSecure('translate_removed_page')
                    .' #'.$textpage->getId().' '.$textpage->getName(),
                    $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }

    private $_level = false;

}