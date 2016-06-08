<?php

/**
 * OneBox
 * 
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify it.
 */

/**
 * Datasource_Category
 * 
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 *
 * @copyright WebProduction
 * 
 * @package Shop
 */
class Datasource_Category extends Forms_ADataSourceSQLObject {

    public function getSQLObject() {
        return Shop::Get()->getShopService()->getCategoryAll();
    }

    protected function _initialize() {
        $field = new Forms_ContentFieldInt('id');
        $field->setEditable(false);
        $field->setName('#');
        $this->addField($field);

        $field = new Forms_ContentField('name');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_category_name'));
        $field->addValidator(new Forms_ValidatorEmpty());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectTree('parentid', true);
        $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_Category'));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_parent_category'));
        $field->addValidator(new Forms_ValidatorParentId());
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('hidden');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_hidden'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('subdomain');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_subdomain'));
        $field->setEditable(true);
        $this->addField($field);

        $field = new Forms_ContentFieldInt('sort');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_sort_order'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('nameformula');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_the_formula_category'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('description');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure(
                'translate_description_of_the_category'
            )
        );
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldFileImage('image');
        $field->setMediaDirectory('/media/shop/');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image'));
        $this->addField($field);

        $field = new Forms_ContentFieldImageCrop('imagecrop');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_image_crop'));
        $this->addField($field);

        $field = new Forms_ContentField('url');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_URL_prefix'));
        $field->addValidator(new Forms_ValidatorSubUrl());
        $field->addValidator(new Shop_ValidatorURLUnique());
        $field->setEditable(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('showtype');
        $field->setDataSource(new Datasource_CategoryShowType(false, true));
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_viewing_mode'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCheckbox('imageInModel');
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_pokazivat_izobrazhenie_v_modelnom_ryadu')
        );
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('code1c');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_code_1C'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('codesupplier');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_supplier_code'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentField('seotitle');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_title'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seokeywords');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_keywords'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldTextarea('seodescription');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_description'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldCKEditor('seocontent');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_SEO_text'));
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldSelectList('sortdefault');
        $field->setDataSource(new Datasource_CategoryDefaultSort(false, true));
        $field->setName(
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_sortirovka_tovarov_po_umolchaniyu')
        );
        $field->setQuickedit(true);
        $this->addField($field);

        $field = new Forms_ContentFieldColor('color');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_tsvet'));
        $this->addField($field);

        $field = new Forms_ContentField('linkkey');
        $field->setName('Technical link key');
        $this->addField($field);

        $field = new Forms_ContentField('logicclass');
        $field->setName(Shop::Get()->getTranslateService()->getTranslateSecure('translate_klassobrabotchik'));
        $this->addField($field);

        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }

        for ($j = 1; $j <= $filter_count; $j++) {
            $field = new Forms_ContentFieldSelectList('filter' . $j . 'id', true);
            $field->setDataSource(Forms_DataSourceManager::Get()->getDataSource('Datasource_ProductFilters'));
            $field->setName(
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_vibrat_'
                ) . $j . ' фильтр по умолчанию'
            );
            $field->setEmptyOptionValue(0);
            $field->setQuickedit(true);
            $this->addField($field);
        }
    }

    public function insert($fieldsArray) {
        try {
            SQLObject::TransactionStart();

            $r = parent::insert($fieldsArray);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $category = Shop::Get()->getShopService()->getCategoryByID($r);

                CommentsAPI::Get()->addComment(
                    'shop-history-category-' . $r,
                    Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_added_a_new_category'
                    ) . ' #' . $r . ' ' . $category->getName(), $user->getId()
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

            $category = Shop::Get()->getShopService()->getCategoryByID($key);
            $parentid = $category->getParentid();

            // скрытая ли категория?
            $hidden = $category->getHidden();
            // старый url
            $oldUrl = $category->getUrl();

            // все товары, в которых "возможно" нужно перестроить список категорий
            $products = Shop::Get()->getShopService()->getProductsByCategory($category);
            $products->setOrderBy('categoryid');
            // обновляем категорию
            $r = parent::update($key, $fieldsArray);

            // получаем уже обновленную категорию
            $category = Shop::Get()->getShopService()->getCategoryByID($key, false);
            
            // Защита от зацикливания категории
            if ($category->getId() == $category->getParentid()) {
                $category->setParentid($parentid);
                $category->update();
                throw new Exception('parentId');
            }
            
            // если изменился parentID - делаем перестройку
            if ((int) $category->getParentid() != $parentid) {
                while ($product = $products->getNext()) {
                    Shop::Get()->getShopService()->buildProductCategories($product);
                }
                Shop::Get()->getShopService()->updateCategoryProductCount($category->getId());
            }

            if ($oldUrl && !$category->getUrl()) {
                throw new Exception('not delete url');
            }

            // если изменился url
            if ($category->getUrl() !== $oldUrl) {
                $redirect = new XShopRedirect();
                $redirect->setUrlfrom('/' . $oldUrl . '/');
                if (!$redirect->select()) {
                    $redirect->setUrlto('/' . $category->getUrl() . '/');
                    $redirect->setCode(301);
                    $redirect->insert();
                }
            }

            // если изменился hidden, то скрываем или раскрываем все товары
            // и категории в этой категории
            if ($category->getHidden() != $hidden) {
                // скрываем/раскрываем всю категорию
                Shop::Get()->getShopService()->updateCategoryHidden($category, $category->getHidden());
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                $diffArray = array();
                foreach ($fieldsArray as $field) {
                    if ($field->getEditable()) {
                        $diffArray[] = $field->getName() . ' ' . $field->getValue();
                    }
                }

                CommentsAPI::Get()->addComment(
                    'shop-history-category-' . $category->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_edited_by_category'
                    ) . ' #' . $category->getId() . ' ' . $category->getName() 
                    . "\n" . implode("\n", $diffArray), $user->getId()
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

    /**
     * Удаление категории
     *
     * @param int $key
     * 
     * @return bool
     */
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
                    'shop-history-category-' . $category->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_removed_category'
                    ) . ' #' . $category->getId() . ' ' . $category->getName(), $user->getId()
                );
            } catch (Exception $e) {
                
            }

            return parent::delete($key);
        } catch (Exception $e) {
            
        }
    }

}