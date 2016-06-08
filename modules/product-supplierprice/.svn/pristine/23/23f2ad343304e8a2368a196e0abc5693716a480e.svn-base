<?php

/**
 * Datasource_TmpPrice
 *
 * @author Andrey Lazarenko <a.lazarenko@webproduction.com.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Datasource_TmpPrice extends Forms_ADataSourceSQLObject {

    /**
     * Получить записи
     *
     * @return XShopTmpPriceSupplier
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            $tmpPrice = new XShopTmpPrice();
            $this->_sqlobject = $tmpPrice;
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

        $field = new Forms_ContentField('code');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_code'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_product'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Shop_contentFieldSearchProduct('productid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_found'));
        $this->addField($field);

        $field = new Forms_ContentField('matchreason');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_match'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_price'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_currency_small'));
        $field->setDataSource(new Datasource_Currency());
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('oldprice');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_old_price'));
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('oldpricecurrencyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_old_price_currency'));
        $field->setDataSource(new Datasource_Currency());
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('minretail');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_minimalnaya_roznitsa'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('minretailcurrrncyid');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_min_retail_currency'));
        $field->setDataSource(new Datasource_Currency());
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('recommretail');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_recommended_retail'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('recommretailcurrruncyid');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_recommended_retail_currency')
        );
        $field->setDataSource(new Datasource_Currency());
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('availtext');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_new_avail'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('oldavailtext');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_old_avail'));
        $this->addField($field);

        $field = new Forms_ContentField('comment');
        $field->setQuickedit(true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('discount');
        $field->setQuickedit(true);
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_discount'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('olddate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_date_last_update'));
        $this->addField($field);
    }

    private $_sqlobject;

}