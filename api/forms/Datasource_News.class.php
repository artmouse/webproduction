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
class Datasource_News extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getNewsService()->getNewsAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-news-control', 'id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_picture'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('contentpreview');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_short_contents'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('content');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contents'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_created'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('productid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_article_about_this_product'));
        $field->setDataSource(new Datasource_Products());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('categoryid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_article_about_the_category'));
        $field->setDataSource(new Datasource_Category());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('brandid', true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_article_about_the_brand'));
        $field->setDataSource(new Datasource_Brands());
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_title'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_description'));
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_text'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_keywords'));
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $x = new XShopNews($r);

                CommentsAPI::Get()->addComment(
                'shop-history-news-'.$r,
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_added_news').' #'.$r.' '.$x->getName(),
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

                $news = new XShopNews($key);

                $diffArray = array();
                /*foreach ($fieldsArray as $field) {
                if ($field->getEditable()) {
                $diffArray[] = $field->getName().' '.$field->getValue();
                }
                }*/

                CommentsAPI::Get()->addComment(
                'shop-history-news-'.$news->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_edited_news').' #'.$news->getId().' '.$news->getName()."\n".implode("\n", $diffArray),
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
            $news = new XShopNews($key);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-news-'.$news->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure('translate_remove_news').' #'.$news->getId().' '.$news->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }

}