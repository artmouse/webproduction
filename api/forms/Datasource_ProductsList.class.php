<?php

class Datasource_ProductsList extends Forms_ADataSourceSQLObject {

    public function __construct($lists = false) {
        $this->_lists = $lists;
    }

    public function getSQLObject() {
        $x = Shop::Get()->getShopService()->getProductsListAll();
        if ($this->_lists) {
            $x->addWhereArray($this->_lists);
        }
        return $x;

    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $field->addValidator(new Forms_ValidatorInt());
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name_of_the_list'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $this->addField($field);

        $field = new Forms_ContentField('nameshort');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_short_name_for_the_list')
        );
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('showinmain');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_show_on_the_main'));
        $this->addField($field);

        $field = new Forms_ContentField('linkkey');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_key_binding'));
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden1'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('showtype');
        $field->setDataSource(new Datasource_CategoryShowType(true));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_viewing_mode'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('setimage');
        $field->setMediaDirectory('/media/shop/');
        $field->setName('Изображение<br />(только для наборов)');
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('autoplay');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_avtomaticheskaya_prokrutka'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('logicclass');
        $field->setDataSource(new Datasource_ProductsListLogicclass());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_list_type'));
        $this->addField($field);
    }

    private $_lists = false;

}