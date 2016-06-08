<?php
class Datasource_ProductsHistory extends Forms_ADataSourceSQLObject {

    public function __construct($id) {
        $this->_id = $id;
    }
    
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $x = new XShopProductChange();
            $x->setProductid($this->_id);
            $x->setOrder('id', 'DESC');
            $this->_sqlobject = $x;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $field->addValidator(new Forms_ValidatorInt());
        $this->addField($field);
        
        $field = new Forms_ContentFieldInt('productid');
        $field->setEditable(false);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_product'));
        $field->addValidator(new Forms_ValidatorInt());
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('userid');
        $field->setDataSource(new Datasource_UsersName());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_author'));
        $field->setEditable(false);   
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('cdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_time'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('key');
        $field->setName('Key');
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('valueold');
        $field->setName("Старое значение");
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('valuenew');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_novoe_znachenie'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentField('key');
        $field->setName("Поле");
        $field->setEditable(false);
        $this->addField($field);
       
    }
    private $_id;
    private $_sqlobject;
}