<?php
class products_index_inlist extends Engine_Class {

    public function process() {

        $arguments = $this->getArguments();
        unset($arguments['categoryid']);
        $products = $this->_getProducts();
        // делаем массив категорий для папок и устанавливаем продуктам категорию
        $this->setValue('categoryArrayForFolders', $this->_makeCategoryArrayForFolders($products, $arguments));       

        $this->setValue('productsArray', $this->_getProductsArray($products));
    }

    /**
     * ShopProduct
     *
     * @return ShopProduct
     */
    private function _getProducts() {
        $datasource = $this->_getDatasource();

        $x = new Shop_ContentTable($datasource);
        $filtersArray = $x->makeFiltersArray();
        
        $products = $this->_select($datasource, $filtersArray);
        return $products;
    }

    /**
     * ShopProduct
     *
     * @return array|int
     */
    private function _getProductsArray(ShopProduct $products) {

        $productsArray = array();
        while ($x = $products->getNext()) {
            $productsArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => $x->makeURLEdit(),
                'image' => $x->makeImageThumb(200, 200),
                'hidden' => $x->getHidden()
            );
        }

        return $productsArray;
    }

    /**
     * Возвращает отфильтрованные товары
     *
     * @param Datasource_Products $datasource
     * @param $filtersArray
     *
     * @return array|ShopProduct
     */
    private function _select(Datasource_Products $datasource, $filtersArray) {
        $sqlobject = $datasource->getSQLObject();
        $fieldsArray = $datasource->getFieldsArray();

        // превращаем массив в ассоциативный для более быстрого доступа по ключу
        // это полезно в случае связи с другими таблицами
        foreach ($fieldsArray as $key => $field) {
            $fieldsArray[$field->getKey()] = $field;
            unset($fieldsArray[$key]);
        }

        if (is_array($filtersArray)
        && count($filtersArray) == 1
        && !$sqlobject->hasConditions()
        ) {

            if ($filtersArray[0]->getKey() == $sqlobject->getPrimaryKey()
            && $filtersArray[0]->getExpression() == false
            ) {
                // достаем из SQLObject'a с учетом кеша

                $r = SQLObject::GetObject(
                    $sqlobject->getClassname(),
                    $filtersArray[0]->getValue()
                );

                $b = array();
                foreach ($fieldsArray as $f) {
                    $b[$f->getKey()] = $r->getField($f->getLink());
                }
                return array($b);
            }
        }

        $tablelike = false;
        $filterRule = '';

        $whereArray = array();

        $connection = $datasource->getSQLObject()->getConnectionDatabase();

        if ($filtersArray) {
            foreach ($filtersArray as $key => $value) {
                if (is_object($value)) {
                    $key = $value->getKey();

                    // отлов специального фильтра
                    if ($key == 'filterrule') {
                        $filterRule = $value->getValue();
                        continue;
                    }

                    // отлов специального фильтра
                    if ($key == 'tablelike') {
                        $tablelike = $value->getValue();
                        continue;
                    }

                    if ($value->getExpression()) {
                        $whereArray[] = $fieldsArray[$value->getKey()]->getLink() . ' ' . $value->getValue();
                    } else {
                        $whereArray[] = $fieldsArray[$value->getKey()]->getLink() . " = '" .
                        $connection->escapeString($value->getValue()) . "'";
                    }
                } else {
                    $whereArray[] = $fieldsArray[$key]->getLink() . " = '" . $connection->escapeString($value) . "'";
                }
            }
        }

        // all/any filter rule
        if ($filterRule == 'any') {
            $filterRule = ' OR ';
        } else {
            $filterRule = ' AND ';
        }

        if ($whereArray) {
            $sqlobject->addWhereQuery('(' . implode($filterRule, $whereArray) . ')');
        }

        // массовый like по таблице
        if ($tablelike) {
            $tablelike = $connection->escapeString($tablelike);
            $w = array();
            foreach ($fieldsArray as $field) {
                if (!$field->getTablelike()) {
                    continue;
                }

                $w[] = $field->getLink() . ' LIKE \'' . $tablelike . '%\'';
            }
            if ($w) {
                $sqlobject->addWhereQuery("(" . implode(' OR ', $w) . ")");
            }
        }
        return $sqlobject;
    }

    /**
     * ShopCategory
     *
     * @return ShopCategory
     */
    private function _getOpenCategory() {
        $openCategory = false;
        $categoryid = $this->getArgumentSecure('categoryid');
        if ($categoryid === '0') { // товары без категории
            return 0;
        } else {
            if ($categoryid) {
                $this->setValue('openCategoryId', $categoryid);
                $openCategory = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                $this->setValue('productcount', $openCategory->getProducts()->getCount());
            }
        }
        return $openCategory;
    }

    /**
     * Datasource_Products
     *
     * @return Datasource_Products
     */
    private function _getDatasource() {
        return $this->getValue('datasource');
    }

    /**
     * Делаем массив категорий для папок и устанавливаем продуктам категорию
     * 
     * @param ShopProduct $product
     * @param array $arguments
     *
     * @return array
     */
    private function _makeCategoryArrayForFolders(ShopProduct $product, $arguments = array()) {
        $openCategory = $this->_getOpenCategory();
        $a = array();

        // проверить наличие реальных  фильтров
        $availFilter = false;
        foreach ($arguments as $k => $v) {
            if (preg_match('/^filter(\d+)_/uis', $k)) {
                $availFilter = true;
                break;
            }
        }    
        // Если нет категории и фильтров, выводим категории верхнего уровня
        if (!$openCategory && !$availFilter) {
            $product->setCategoryid(0);
            // С категориями
            if ($openCategory !== 0) {
                $category = Shop::Get()->getShopService()->getCategoryAll();
                $category->setParentid(0);

                while ($x = $category->getNext()) {
                    $a[$x->getId()] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                            array('categoryid' => $x->getId())
                        ),
                        'hidden' => $x->getHidden()
                    );
                }
            }
        } else {
            if ($openCategory || $availFilter) { // Если есть категория, или фильтры
                $orArr = array();
                $level = 1;
                $openCategoryId = false;
                if ($openCategory === 0) {
                    $openCategoryId = 0;
                } else {
                    if (is_object($openCategory)) {
                        $level = $openCategory->getLevel();
                        $openCategoryId = $openCategory->getId();
                    }
                }

                try {
                    // выбрана категория
                    if ($openCategoryId != false) {
                        $parentCategory = $openCategory->getParent();
                        $this->setValue(
                            'openCategory',
                            array(
                                 'parentid' => $parentCategory->getId(),
                                 'name' => $parentCategory->getName(),
                                 'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                                     array('categoryid' => $parentCategory->getId())
                                 ),
                            )
                        );
                    }
                } catch (Exception $e) {
                    $this->setValue(
                        'openCategory',
                        array(
                             'parentid' => '',
                             'name' => '',
                             'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => '')),
                        )
                    );
                }
                if ($openCategoryId) {
                    // Ищим продукты во всех вложенных категориях
                    for ($i = $level; $i <= 10; $i++) {
                        $orArr[] = "category{$i}id = {$openCategoryId}";
                    }
                    $product->addWhereQuery("(" . implode(' OR ', $orArr) . ")");
                    $product->setCategoryid($openCategoryId); // выводим товары только текущей категории

                    // если указана категория, то выводим всех её детей #2012101274
                    $categoryChild = Shop::Get()->getShopService()->getCategoriesByParentID($openCategoryId);
                    while ($c = $categoryChild->getNext()) {
                        $a[$c->getId()] = array(
                            'id' => $c->getId(),
                            'name' => $c->getName(),
                            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                                array('categoryid' => $c->getId())
                            ),
                            'hidden' => $c->getHidden(),
                            'level' => $c->getLevel()
                        );
                    }
                } else { // фильтры без категории (определяем папки по товарам)
                    // Определяем категории в которые входят найденные продукты
                    while ($p = $product->getNext()) {
                        try {
                            $category = $p->getCategory();
                            // если выбрана категория и она не верхняя
                            if ($openCategoryId !== false && $category->getParentid() != $openCategoryId) {
                                // Категория на уровень ниже
                                $category = $this->_getTopParentCategory($category, $level + 1);
                            } else {
                                if ($openCategoryId === false) { // Если не выбрана категория
                                    $category = $this->_getTopParentCategory($category);
                                }
                            }

                            $a[$category->getId()] = array(
                                'id' => $category->getId(),
                                'name' => $category->getName(),
                                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                                    array('categoryid' => $category->getId())
                                ),
                                'hidden' => $category->getHidden(),
                                'level' => $category->getLevel()
                            );
                        } catch (Exception $e) {

                        }
                        unset($a[$openCategoryId]); // удаляем текущую категорию с вывода
                    }
                }


            }
        }

        return $a;
    }

    /**
     * ShopCategory
     *
     * @param ShopCategory $category
     * @param int $level
     *
     * @return ShopCategory
     */
    private function _getTopParentCategory(ShopCategory $category, $level = 1) {
        if ($category->getLevel() == $level) {
            return $category;
        }
        return $this->_getTopParentCategory($category->getParent(), $level);
    }

}