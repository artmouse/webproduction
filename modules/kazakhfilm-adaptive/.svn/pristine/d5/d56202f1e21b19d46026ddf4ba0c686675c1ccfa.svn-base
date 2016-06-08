<?php
class products_index extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        $allowEdit = $this->getUser()->isAllowed('products-edit');
        $this->setValue('allowEdit', $allowEdit);

        // перемещение товаров в заданную категорию
        if ($allowEdit
            && $this->getControlValue('move')) {
            try {
                $toCategoryID = $this->getControlValue('movecategory');
                $toCategory = Shop::Get()->getShopService()->getCategoryByID($toCategoryID);

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            $product->setCategoryid($toCategoryID);
                            $product->update();

                            Shop::Get()->getShopService()->buildProductCategories($product);
                        } catch (Exception $pe) {

                        }
                    }
                }
            } catch (Exception $e) {

            }
        }

        if ($allowEdit
            && $this->getControlValue('sync')) {
            try {
                $syncID = $this->getControlValue('changesync');
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            $product->setUnsyncable($syncID);
                            $product->update();
                        } catch (Exception $pe) {

                        }
                    }
                }
            } catch (Exception $e) {

            }
        }

        // перемещение товаров в заданный бренд
        if ($allowEdit
            && $this->getControlValue('move')) {
            try {
                $toBrandID = $this->getControlValue('movebrand');
                $toBrand = Shop::Get()->getShopService()->getBrandByID($toBrandID);

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            $product->setBrandid($toBrandID);
                            $product->update();
                        } catch (Exception $pe) {

                        }
                    }
                }
            } catch (Exception $e) {

            }
        }

        // массовые операции над товарами
        $massAction =
            $this->getArgumentSecure('hide')
                || $this->getArgumentSecure('unhide')
                || $this->getArgumentSecure('delete')
                || $this->getArgumentSecure('undelete')
                || $this->getArgumentSecure('setavail')
                || $this->getArgumentSecure('setunavail');

        if ($allowEdit && $massAction) {
            try {
                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);

                            if ($this->getControlValue('hide')) {
                                $product->setHidden(1);
                            }

                            if ($this->getControlValue('unhide')) {
                                $product->setHidden(0);
                            }

                            if ($this->getControlValue('delete')) {
                                try {
                                    // пытаемся удалить полностью
                                    Shop::Get()->getShopService()->deleteProduct($product);
                                } catch (Exception $deleteEx) {
                                    // если не получилось - то помечаем как удаленный
                                    $product->setDeleted(1);
                                }
                            }

                            if ($this->getControlValue('undelete')) {
                                $product->setDeleted(0);
                            }

                            if ($this->getControlValue('setavail')) {
                                $product->setAvail(1);
                            }

                            if ($this->getControlValue('setunavail')) {
                                $product->setAvail(0);
                            }

                            $product->update();
                        } catch (Exception $pe) {

                        }
                    }
                }
            } catch (Exception $e) {

            }
        }

        $table = new Shop_ContentTable(new Datasource_Products_Kazah($this->getArgumentSecure('categoryid')));
        $field = new Forms_ContentFieldControlLink('id', 'shop-admin-products-edit', 'id');
        $field->setName(Shop_TranslateFormService::Get()->getTranslate('translate_code'));
        $table->addField($field);

        $field = new Shop_ContentFieldImage('image');
        $field->setName(Shop_TranslateFormService::Get()->getTranslate('translate_image'));
        $table->addField($field);

        $this->setValue('table', $table->render());

        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandsArray', $brands->toArray());

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());
    }

    /**
     * @return array
     */
    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
            );
        }

        return $this->_makeCategoryTree(0, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeCategoryTree($x['id'], $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

}