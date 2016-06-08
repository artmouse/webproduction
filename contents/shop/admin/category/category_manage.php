<?php
class category_manage extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/categorySortable.js');

        if ($this->getControlValue('delete')) {
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                foreach ($r[1] as $categoryID) {
                    try {
                        SQLObject::TransactionStart();
                        $currentCategory = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                        $currentCategory->delete();
                        $this->setValue('successDel', 1);
                        $this->setValue(
                            'successName',
                            Shop::Get()->getTranslateService()->getTranslateSecure(
                                'translate_udalenie_uspeshno_vipolneno'
                            )
                        );
                        SQLObject::TransactionCommit();
                    } catch (Exception $e) {
                        SQLObject::TransactionRollback();
                    }
                }
                header('Refresh: 3;');
            }
        }
        // добавление категории
        if ($this->getArgumentSecure('createcategory') && $this->getArgumentSecure('categoryname')) {
            try{
                $categoryName = $this->getArgumentSecure('categoryname');
                Shop::Get()->getShopService()->addCategory($categoryName);
            } catch (Exception $e) {

            }

        }

        if ($this->getControlValue('do-action')) {
            try {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            $currentCategory = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                            $currentCategory->setHidden(0);
                            $currentCategory->update();
                            Shop::Get()->getShopService()->updateCategoryHidden($currentCategory, 0);
                            $this->setValue('success', 1);
                            $this->setValue(
                                'successName',
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_vidimost_izmenena_uspeshno'
                                )
                            );
                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }

        if ($this->getControlValue('do-action-hidden')) {
            try {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            $currentCategory = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                            $currentCategory->setHidden(1);
                            $currentCategory->update();
                            Shop::Get()->getShopService()->updateCategoryHidden($currentCategory, 1);
                            $this->setValue('success', 1);
                            $this->setValue(
                                'successName',
                                Shop::Get()->getTranslateService()->getTranslateSecure(
                                    'translate_vidimost_izmenena_uspeshno'
                                )
                            );
                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }

        if ($this->getControlValue('changeshowtype')) {
            try {

                $showType = $this->getControlValue('showtype');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            if ($showType != '0') {
                                $currentCategory = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                                $currentCategory->setShowtype($showType);
                                $currentCategory->update();
                            }
                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                }

            } catch (Exception $e) {

            }
        }

        if ($this->getControlValue('gotocategory')) {
            try {

                $tocategoryid = $this->getControlValue('goidcategory');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $categoryID) {
                        try {
                            SQLObject::TransactionStart();
                            if ($tocategoryid != '0') {
                                $currentCategory = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                                $currentCategory->setParentid($tocategoryid);
                                $currentCategory->update();
                            }

                            SQLObject::TransactionCommit();
                        } catch (Exceprion $e) {
                            SQLObject::TransactionRollback();
                        }
                    }
                    $this->_updateProductsCategoryTree();
                }

            } catch (Exception $e) {

            }
        }

        if ($this->getControlValue('reletedcategory')) {

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {

                foreach ($r[1] as $categoryID) {

                    $categoryIDArray = $this->getControlValue('reletedidcategory', 'array');

                    foreach ($categoryIDArray as $reletedCategoryId) {
                        try {
                            $x = new XShopReletedCategory();
                            $x->setCategoryid($categoryID);
                            $x->setReletedcategoryid($reletedCategoryId);
                            if (!$x->select()) {
                                $x->insert();
                            }
                        } catch (Exception $e) {

                        }
                    }

                }

            }
        }

        // Удаление связей категорий
        if ($this->getControlValue('delreletedcategory')) {

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {

                foreach ($r[1] as $id) {
                    try {
                        $x = new XShopReletedCategory();
                        $x->setCategoryid($id);

                        while ($relation = $x->getNext()) {
                            $relation->delete();
                        }

                    } catch (Exception $e) {

                    }
                }
            }
        }

        $this->setValue('categoryTreeArray', $this->_makeCategoryTreeArray());
        $this->setValue('categoryArray', $this->_makeCategoryArray());
    }

    private function _makeCategoryTreeArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
                'productcount' => $x->getProductcount(),
                'level' => $x->getField('level'),
            );
        }
        return $a;
    }

    private function _makeCategoryArray($categorySelectedArray = false) {
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'hidden' => $x->getHidden(),
                'selected' => $x->getId() == $this->getValue('categorySelected'),
                'editURL' => $x->makeEditURL()
            );
        }
        return $this->_makeCategoryTree(0, 0, $a, $categorySelectedArray);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray, $categorySelectedArray = false) {
        $a = array();

        if (empty($categoryArray[$parentID])) {
            return $a;
        }

        foreach ($categoryArray[$parentID] as $x) {
            $b = array();
            $x['level'] = $level;

            if ($categorySelectedArray) {
                in_array(
                    $x['id'],
                    $categorySelectedArray
                ) ? ($childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray)) : ($childs = array());
            } else {
                $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            }

            foreach ($childs as $y) {
                $b[] = $y;
            }

            $x['childsArray'] = $b;

            $a[] = $x;
        }
        return $a;
    }

    private function _updateProductsCategoryTree() {
        // Обновляем дерево категорий у товаров.
        $products = Shop::Get()->getShopService()->getProductsAll();
        $products->setOrderBy('categoryid'); // оптимизация кеша по категориям

        $transactions = 250;
        $index = 0;

        SQLObject::TransactionStart();

        while ($product = $products->getNext()) {
            // устанавливаем родительские категории
            try {
                Shop::Get()->getShopService()->buildProductCategories($product);
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $index ++;
            if ($index % $transactions == 0) {
                SQLObject::TransactionCommit();
                SQLObject::TransactionStart();
            }
        }

        SQLObject::TransactionCommit();
    }


}