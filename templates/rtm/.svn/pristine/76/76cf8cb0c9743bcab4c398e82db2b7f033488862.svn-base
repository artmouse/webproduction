<?php
class products_index_inlist extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        $allowEdit = $this->getUser()->isAllowed('products-edit');
        $this->setValue('allowEdit', $allowEdit);
        if ( isset($_COOKIE['folderviewCookie']) ) {
            $this->setValue('folderviewCookie',$_COOKIE['folderviewCookie']);
        }

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
        // Добавление товаров в новый заказ
        if ($allowEdit
            && $this->getControlValue('createorder')) {
            try {

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
                    $productsArray = array();
                    foreach ($r[1] as $productID) {
                        try {
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            $productsArray[] = array(
                                'productid' => $product->getId(),
                                'currencyid' => $product->getCurrencyid(),
                                'price' => $product->getPrice(),
                                'taxrate' => $product->getTaxrate(),
                                'amount' => 1, // количество товаров
                            );
                        } catch (Exception $pe) {

                        }
                    }
                    $user = Shop::Get()->getUserService()->getUser();
                    $result = Shop::Get()->getShopService()->makeOrderByProductArray($user,false,false,false,false,$productsArray,true);
                    $order = $result['order'];
                    $urlRedirect = $order->makeURLEdit();
                    $this->setValue('urlredirect', $urlRedirect);

                    if ( $this->getControlValue('gotoorder') ) {
                        header('Location: '.$urlRedirect);
                        exit();
                    }
                    $this->setValue('message', 'ok');

                }
            } catch (Exception $e) {

            }
        }

        // Добавление товаров в существующий заказ
        if ($allowEdit
            && $this->getControlValue('addexistorder')) {
            try {
                $order = Shop::Get()->getShopService()->getOrderByID( $this->getControlValue('orderid') );

                if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {

                    foreach ($r[1] as $productID) {
                        try {
                            $this->_addOrderProduct($order,$productID);
                        } catch (Exception $pe) {

                        }
                    }

                    $urlRedirect = $order->makeURLEdit();
                    $this->setValue('urlredirect', $urlRedirect);

                    if ( $this->getControlValue('gotoorder') ) {
                        header('Location: '.$urlRedirect);
                        exit();
                    }
                    $this->setValue('message', 'ok');

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

        try {
            $category = Shop::Get()->getShopService()->getCategoryByID($this->getArgumentSecure('categoryid'));
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setField('category'.$category->getLevel().'id',$category->getId());
            $this->setValue('categoryProductCount',$products->getCount());
            $products->addWhere('image','','!=');
            $this->setValue('categoryProductCountImage',$products->getCount());
        } catch (Exception $e) {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setField('categoryid',0);
            $this->setValue('noCategoryProductCount',$products->getCount());
            $products->addWhere('image','','!=');
            $this->setValue('noCategoryProductCountImage',$products->getCount());
        }


        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandsArray', $brands->toArray());

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());

        $this->setControlValue('filter_show_deleted',$this->getArgumentSecure('filter_show_deleted'));
        $this->setControlValue('filter_show_hidden',$this->getArgumentSecure('filter_show_hidden'));

        try {
            $filtersArray = $this->_makeFiltersArray();
            if ($filtersArray) {
                $products = $this->_selectWithFilters($filtersArray);
                $a = array();
                foreach ($products as $v){
                    $x = Shop::Get()->getShopService()->getProductByID($v['id']);
                    $a[] = array(
                        'id' => $x->getId(),
                        'name' => $x->getName(),
                        'url' => $x->makeURLEdit(),
                        'image' => $x->makeImageThumb(200,200),
                        'hidden' => $x->getHidden()
                    );
                }
                $this->setValue('productsArray',$a);
            } else {

                $products = false;
                $openCategory = false;
                $category = Shop::Get()->getShopService()->getCategoryAll();
                if ( $categoryid = $this->getArgumentSecure('categoryid') ){
                    $openCategory = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                }
                $products = Shop::Get()->getShopService()->getProductsAll();
                if ( !$this->getArgumentSecure('filter_show_deleted' ) ) {
                    $products->addWhere('deleted','0','=');
                }
                if ( !$this->getArgumentSecure('filter_show_hidden' ) ) {
                    $products->addWhere('hidden','0','=');
                }
                if ($openCategory) {
                    $products->setCategoryid($openCategory->getId());// берем товары только данной категории
                    $this->setValue('openCategoryId',$openCategory->getId());
                }else {
                    $products->setCategoryid(0);
                }
                // делаем массив категорий для папок
                $this->setValue('categoryArrayForFolders', $this->_makeCategoryArrayForFolders($category,$openCategory));
                // делаем массив продуктов в выбраной категорие
                if ($products){
                    $a = array();
                    while ($x = $products->getNext()){

                        $a[] = array(
                            'id' => $x->getId(),
                            'name' => $x->getName(),
                            'url' => $x->makeURLEdit(),
                            'image' => $x->makeImageThumb(200,200),
                            'hidden' => $x->getHidden()
                        );
                    }
                    $this->setValue('productsArray',$a);
                }
            }




        }catch (Exception $e){

        }

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
                'productcount' => $x->getProductcount()
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

    /**
     * @param ShopCategory $category
     * @param  $openCategory
     * @return array
     */
    private function _makeCategoryArrayForFolders(ShopCategory $category, $openCategory = false) {

        if ($openCategory){
            $category->setParentid($openCategory->getId());
            $parentName = false;
            try {
                $parentCategory = Shop::Get()->getShopService()->getCategoryByID($openCategory->getParentid());
                $parentName = $parentCategory->getName();
            } catch ( Exception $e ) {

            }

            $this->setValue('openCategory',array(
                'parentid' => $openCategory->getParentid(),
                'name'=> $parentName,
                'url'=>Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $openCategory->getParentid())),
            ));

        }else {
            $category->setParentid(0);
        }

        $a = array();

        while ($x = $category->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'hidden' => $x->getHidden()
            );
        }

        return  $a;
    }

    private function _makeFiltersArray() {
        $operationsArray = array();
        $operationsArray[] = 'equals';
        $operationsArray[] = 'lt';
        $operationsArray[] = 'gt';
        $operationsArray[] = 'lte';
        $operationsArray[] = 'gte';
        $operationsArray[] = 'search'; // like

        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $filtersArray = array();
        $arguments = Engine::GetURLParser()->getArguments();
        foreach ($arguments as $k => $v) {
            if (preg_match('/^filter(\d+)_key$/uis', $k, $r)) {
                try {
                    $key = $v;
                    $type = @$arguments['filter'.$r[1].'_type'];
                    $value = @$arguments['filter'.$r[1].'_value'];

                    if ($value === false || $value === '' || $value === null) {
                        continue;
                    }

                    if (!in_array($type, $operationsArray)) {
                        $type = $operationsArray[0];
                    }

                    // @todo: переписать на обработчики
                    // @todo: refactoring

                    if ($type == 'equals') {

                        if (!is_numeric($value)) {
                            $value = "'$value'";
                        }



                        $filter = new Forms_FilterObject(
                            $key,
                            "= $value",
                            true
                        );
                    } elseif ($type == 'lt') {

                        if (!is_numeric($value)) {
                            $value = "'$value'";
                        }



                        $filter = new Forms_FilterObject(
                            $key,
                            "<= $value",
                            true
                        );
                    } elseif ($type == 'lte') {

                        if (!is_numeric($value)) {
                            $value = "'$value'";
                        }



                        $filter = new Forms_FilterObject(
                            $key,
                            "<= $value",
                            true
                        );
                    } elseif ($type == 'gt') {

                        if (!is_numeric($value)) {
                            $value = "'$value'";
                        }



                        $filter = new Forms_FilterObject(
                            $key,
                            "> $value",
                            true
                        );
                    } elseif ($type == 'gte') {

                        if (!is_numeric($value)) {
                            $value = "'$value'";
                        }


                        $filter = new Forms_FilterObject(
                            $key,
                            ">= $value",
                            true
                        );
                    } elseif ($type == 'in') {
                        // перечисление через запятую

                        $variantsArray = array();
                        $value = explode(',', $value);
                        foreach ($value as $x) {
                            $variantsArray[] = "'".$connection->escapeString($x)."'";
                        }

                        $filter = new Forms_FilterObject(
                            $key,
                            "IN (".implode(', ', $variantsArray).")",
                            true
                        );
                    } elseif ($type == 'search') {
                        // текстовый like поиск
                        // issue #22210
                        $value = str_replace(' ', '%', $value);

                        $filter = new Forms_FilterObject(
                            $key,
                            "LIKE '%".$connection->escapeString($value)."%'",
                            true
                        );
                    }

                    $filtersArray[] = $filter;
                } catch (Exception $filterException) {

                }
            }
        }
        return $filtersArray;
    }


    private function _selectWithFilters($filtersArray = array(), $sortBy = false, $sortType = 'ASC', $limitFrom = false, $limitCount = false, $count = false) {
        $sqlobject =  new ShopProduct();

        $fieldsArray = $sqlobject->getFields();

        // превращаем массив в ассоциативный для более быстрого доступа по ключу
        // это полезно в случае связи с другими таблицами
        foreach ($fieldsArray as $key => $field) {
            $fieldsArray[$field] = $field;
            unset($fieldsArray[$key]);
        }

        if (!$count
            && is_array($filtersArray)
            && count($filtersArray) == 1
            && !$sqlobject->hasConditions()) {

            if ($filtersArray[0]->getKey() == $sqlobject->getPrimaryKey()
                && $filtersArray[0]->getExpression() == false) {
                // достаем из SQLObject'a с учетом кеша

                $r = SQLObject::GetObject(
                    $sqlobject->getClassname(),
                    $filtersArray[0]->getValue()
                );

                $b = array();
                foreach ($fieldsArray as $f) {
                    $b[$f] = $r->getField($f);
                }
                return array($b);
            }
        }

        $tablelike = false;
        $filterRule = '';

        $whereArray = array();

        $connection = $sqlobject->getConnectionDatabase();

        if ($filtersArray) {
            if ( !$this->getArgumentSecure('filter_show_deleted' ) ) {
                $sqlobject->addWhere('deleted','0','=');
            }
            if ( !$this->getArgumentSecure('filter_show_hidden' ) ) {
                $sqlobject->addWhere('hidden','0','=');
            }
            if ( $categoryid = $this->getArgumentSecure('categoryid') ){
                $sqlobject->setCategoryid($categoryid);
            }
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
                        $whereArray[] = $value->getKey().' '.$value->getValue();
                    } else {
                        $whereArray[] = $value->getKey()." = '".$connection->escapeString($value->getValue())."'";
                    }
                } else {
                    $whereArray[] = $key." = '".$connection->escapeString($value)."'";
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
            $sqlobject->addWhereQuery('('.implode($filterRule, $whereArray).')');
        }

        // массовый like по таблице
        if ($tablelike) {
            $tablelike = $connection->escapeString($tablelike);
            $w = array();
            foreach ($fieldsArray as $field) {
                if (!$field->getTablelike()) {
                    continue;
                }

                $w[] = $field->getLink().' LIKE \''.$tablelike.'%\'';
            }
            if ($w) {
                $sqlobject->addWhereQuery("(".implode(' OR ', $w).")");
            }
        }

        $sqlobject->setLimit($limitFrom, $limitCount);
        if ($count) {
            return $sqlobject->getCount();
        }

        if ($sortBy) {
            $sqlobject->setOrder($sortBy, $sortType);
        }
        $a = array();
        while ($x = $sqlobject->getNext()) {
            $b = array();
            foreach ($fieldsArray as $f) {
                try {
                    $b[$f] = $x->getField($f);
                } catch (Exception $e) {

                }
            }
            $a[] = $b;
        }
        return $a;
    }

    /**
     * Обработчик добавления нового товара в заказ.
     *
     * При добавлении товара в заказ цена товара приводится по правилам:
     * (product.price + product.tax%)
     * и это все конвертируется в валюту заказа.
     *
     * @param ShopOrder $order
     */
    private function _addOrderProduct(ShopOrder $order, $addProductID) {

        $addProductCount = 1;

        // добавляем товар
        $product = Shop::Get()->getShopService()->getProductByID($addProductID);

        $op = new ShopOrderProduct();
        $op->setOrderid($order->getId());
        $op->setProductid($product->getId());
        $op->setProductname($product->getName());
        try {
            $op->setCategoryname($product->getCategory()->makePathName());
        } catch (Exception $e) {

        }
        $op->setProductprice($product->makePriceWithTax($order->getCurrency()));
        $op->setCurrencyid($order->getCurrencyid());
        $op->setProductcount($addProductCount);
        $op->insert();
    }

}