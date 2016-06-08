<?php

class Datasource_ActionProductSet extends Forms_ADataSourceSQLObject {

    private $_productid;
    private $_add;
    public function __construct(ShopProduct $product,$add = false) {
        $this->_productid = $product->getId();
        $this->_add = $add;
    }

    public function getSQLObject() {
        if ($this->_add) {
            $x = new XShopActionSet();
        } else {
            $x = new XShopActionSet();
            $x->setProductid($this->_productid);
        }
        return $x;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_title'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_skritiy_nabor'));
        $field->setQuickedit(true);
        $this->addField($field);
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            $actionSet = Shop::Get()->getShopService()->getActionSetById($r);
            $actionSet->setProductid($this->_productid);
            $actionSet->update();

            SQLObject::TransactionCommit();

            // после вставки сразу редиректимся на редактирование

            header('Location: '.Engine::GetLinkMaker()->makeURLByContentIDParam('shop-admin-action-set-control', $r));
            exit();

            return $r;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

}