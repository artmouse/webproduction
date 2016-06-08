<?php

class Datasource_Comments extends Forms_ADataSourceSQLObject {

    public function __construct($commentkey = false) {
        $this->_commentkey = $commentkey;
    }

    public function getSQLObject() {
        $x = CommentsAPI::Get()->getComments();
        if ($this->_commentkey) {
            $x->setKey($this->_commentkey);
        } else {
            $x->addWhere('key', 'shop-product-%', 'LIKE');
        }
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_time'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('id_user');
        $field->setDataSource(new Datasource_Users());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('content');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_contents'));
        $this->addField($field);
    }

    /*public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $category = Shop::Get()->getShopService()->getCategoryByID($r);

                CommentsAPI::Get()->addComment(
                'shop-history-category-'.$r,
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_dobavlena_novaya_kategoriya_'
                ).$r.' '.$category->getName(),
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

                $category = Shop::Get()->getShopService()->getCategoryByID($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                'shop-history-category-'.$category->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_otredaktirovana_kategoriya_'
                ).$category->getId().' '.$category->getName()."\n".implode("\n", $diffArray),
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
            $category = Shop::Get()->getShopService()->getCategoryByID($key);
            if ($category->getProducts()->getCount()) {
                throw new ServiceUtils_Exception();
            }

            if ($category->getChilds()->getCount()) {
                throw new ServiceUtils_Exception();
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                'shop-history-category-'.$category->getId(),
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_udalena_kategoriya_'
                ).$category->getId().' '.$category->getName(),
                $user->getId()
                );
            } catch (Exception $e) {

            }

            return parent::delete($key);
        } catch (Exception $e) {

        }
    }*/

}