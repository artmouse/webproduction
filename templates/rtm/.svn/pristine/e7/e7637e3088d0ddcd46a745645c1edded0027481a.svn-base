<?php
/**
 * WebProduction Shop (wpshop)
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
class Datasource_Products extends Forms_ADataSourceSQLObject {

    public function __construct($categoryID = false) {
        $this->_categoryID = $categoryID;
    }

    /**
     * @return ShopProduct
     */
    public function getSQLObject() {
        if (!$this->_sqlobject) {
            if ($this->_categoryID === false) {
                $products = Shop::Get()->getShopService()->getProductsAll();
            } else {
                $products = Shop::Get()->getShopService()->getProductsByCategory(
                new ShopCategory($this->_categoryID)
                );
            }

            $this->_sqlobject = $products;
        }
        return $this->_sqlobject;
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldCheckboxKey('select');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_choice'));
        $field->setSortable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('id');
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldControlLink('name', 'shop-admin-products-edit', 'id');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_name'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price');
        $field->setName('Цена за работу');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldNumeric('price_product');
        $field->setName('Цена за изделие');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('currencyid');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_currency'));
        $field->setDataSource(new Datasource_Currency());
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('inventarnumber');
        $field->setName('Инвентарный номер');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('unit');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_unit'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('categoryid');
        $field->setDataSource(new Datasource_Category());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_category'));
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('brandid');
        $field->setDataSource(new Datasource_Brands());
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_brand'));
        $field->setQuickedit(true);
        $field->setEmptyOptionValue(0);
        $this->addField($field);

        $field = new Forms_ContentField('model');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_model'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('code1c');
        $field->setName('Артикул');
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('unitbox');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_quantity_in_the_box'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('barcode');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_bar_code'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('warranty');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_warranty'));
        $this->addField($field);

        $field = new Forms_ContentField('discount');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_discount'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('preorderDiscount');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_discount_preorder'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('top');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_the_promotional'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_hidden1'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('deleted');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_removed'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('avail');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_product_in_stock'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('denycomments');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_forbid_comment'));
        $field->setQuickedit(true);
        $this->addField($field);


        for ($j = 1; $j <= 5; $j++) {
            $field = new Forms_ContentFieldNumeric('price'.$j);
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_price').' '.$j);
            $field->setQuickedit(true);
            $this->addField($field);
        }

        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            $field = new Forms_ContentFieldSelectList('filter'.$j.'id');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_ProductFilters'));
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_filter').' '.$j);
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentField('filter'.$j.'value');
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_filter').' '.$j.' '.Shop_TranslateFormService::Get()->getTranslateSecure('translate_value'));
            $field->setQuickedit(true);
            $this->addField($field);
        }

        for ($j = 1; $j <= 5; $j++) {
            $field = new Forms_ContentFieldSelectList('supplier'.$j.'id');
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Supplier'));
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_supplier').' '.$j);
            $field->setQuickedit(true);
            $field->setEmptyOptionValue(0);
            $this->addField($field);

            $field = new Forms_ContentField('supplier'.$j.'code');
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_supplier_code').' '.$j);
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentField('supplier'.$j.'price');
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_supplier_price').' '.$j);
            $field->setQuickedit(true);
            $this->addField($field);

            $field = new Forms_ContentFieldDatetime('supplier'.$j.'date', 'Y-m-d H:i');
            $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_supplier_date').' '.$j);
            $this->addField($field);
        }

        $field = new Forms_ContentFieldInt('viewed');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_views'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('ordered');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_orders'));
        $field->setEditable(false);
        $this->addField($field);

        $field = new Forms_ContentFieldDatetime('lastordered');
        $field->setEditable(false);
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_last_order'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('rating');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_ratings'));
        $this->addField($field);

        $field = new Forms_ContentFieldInt('url');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_URL_prefix'));
        $field->setQuickedit(true);
        $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_title'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_keywords'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_description'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop_TranslateFormService::Get()->getTranslateSecure('translate_SEO_text'));
        $field->setQuickedit(true);
        $this->addField($field);
    }

    private $_sqlobject;

    private $_categoryID = false;

    public function update($key, $fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::update($key, $fieldsArray);
            try {
                $user = Shop::Get()->getUserService()->getUser();

                $product = new ShopProduct($key);

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName().' '.$field->getValue();
                    }
                }
                Shop::Get()->getShopService()->buildProductCategories($product);

                CommentsAPI::Get()->addComment(
                'shop-history-product-'.$product->getId(),
                Shop_TranslateFormService::Get()->getTranslateSecure('translate_edited_product').' #'.$product->getId().' '.$product->getName()."\n".implode("\n", $diffArray),
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

}

