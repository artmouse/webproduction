<?php
/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Datasource_Banner
 * 
 * @author Oleksii Golub <avator@webproduction.ua>
 * 
 * @copyright WebProduction
 * 
 * @package Shop
 */
class Datasource_Banner extends Forms_ADataSourceSQLObject {

    private $_add = true;
    public function __construct($id=false) {
        if ($id) {
            $this->_add = false;
        }
    }

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getBannerAll();
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
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden_banner'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sorting'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_picture'));
        if ($this->_add) {
            $field->addValidator(new Forms_ValidatorEmpty());
        }
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_link_URL'));
        //$field->addValidator(new Forms_ValidatorSubUrl(false));
        //$field->addValidator(new Shop_ValidatorURLUnique());
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('place');
        $field->setDataSource(new Datasource_BannerPlace());
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_location'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('categoryid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Category'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_category'));
        $field->addValidator(new Forms_ValidatorParentId());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('comment');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_comment'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('sdate');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_sdate_time'));
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('edate');
        $field->setValueDefault('');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_edate_time'));
        $this->addField($field);
        
        $field = new Forms_ContentField('pageinterval');
        $field->setName("Интервал показа постранично");
        $field->setEnabled();
        $this->addField($field);
    }

    public function update($key, $fieldsArray) {
        $r = parent::update($key, $fieldsArray);
        $banner = Shop::Get()->getShopService()->getBannerByID($key);
        if ($banner->getSdate() == '1970-01-01 02:00:00') {
            $banner->setSdate('');
            $banner->update();
        }
        if ($banner->getEdate() == '1970-01-01 02:00:00') {
            $banner->setEdate('');
            $banner->update();
        }
        return $r;
    }

}