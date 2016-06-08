<?php

/**
 * Datasource_IgnoreProductsPrice
 *
 * @author Andrey Lazarenko <a.lazarenko@webproduction.com.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_IgnoreProductsPrice extends Forms_ADataSourceSQLObject {

    /**
     * Получить записи
     *
     * @return XShopTmpPriceSupplier
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $priceIgnore = new XShopPriceSupplierIgnore();
            $this->_sqlobject = $priceIgnore;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_choice'));
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('supplierid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier'));
        $this->addField($field);


        $field = new Forms_ContentField('code');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_code'));
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_name'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_currency'));
        $field->setDataSource(new Datasource_Currency());
        $field->setEmptyOptionValue(0);
        $this->addField($field);


        $field = new Forms_ContentField('availtext');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_availability'));
        $field->setQuickedit(true);
        $this->addField($field);
    }

    private $_sqlobject;

}