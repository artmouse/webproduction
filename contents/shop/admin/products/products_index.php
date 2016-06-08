<?php

class products_index extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        if (isset($_SESSION['categoryid']) && $this->getArgumentSecure('page') &&
                $_SESSION['categoryid'] != $this->getArgumentSecure('categoryid')) {
            Shop_URLParser::Get()->_replaceUrl('page');
        }
        $_SESSION['categoryid'] = $this->getArgumentSecure('categoryid');

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        $allowEdit = $this->getUser()->isAllowed('products-edit');
        $this->setValue('allowEdit', $allowEdit);

        $isOrder = Shop_ModuleLoader::Get()->isImported('order');

        if ($allowEdit && $this->getControlValue('change')) {
            $this->_productsChange();
        }

        // Добавление товаров в новый заказ
        if ($allowEdit && $isOrder && $this->getControlValue('createorder')) {
            $this->_addProductsToOrder();
        }

        // Добавление товаров в существующий заказ
        if ($allowEdit && $isOrder && $this->getControlValue('addexistorder')) {
            $this->_addProductsExistOrder();
        }


        // массовые операции над товарами
        $massAction = $this->getArgumentSecure('hide')
                || $this->getArgumentSecure('delete')
                || $this->getArgumentSecure('avail')
                || $this->getArgumentSecure('changeimage')
                || $this->getArgumentSecure('changedescription')
                || $this->getArgumentSecure('changeaddtags')
                || $this->getArgumentSecure('changeremovetags');

        if ($allowEdit && $massAction) {
            $this->_productsMassActions();
        }

        // Вывод товаров
        $this->_showProductsBlock();

        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandArray', $brands->toArray());

        // список поставщиков
        $suppliers = Shop::Get()->getSupplierService()->getSuppliersActive();
        $a = array();
        while ($x = $suppliers->getNext()) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
            );
        }
        $this->setValue('supplierArray', $a);

        // категории
        $this->setValue('categoryArray', $this->_makeCategoryArray());
        $this->setValue('newCategoryArray', $this->_makeCategoryArray2());

        $query = Engine::GetURLParser()->getGETString();
        if ($query) {
            $this->setValue('query', '?' . $query);
        }

        $this->setValue('isOrder', $isOrder);

        // фильтры/характеристики для фильтра
        $productFilters = Shop::Get()->getShopService()->getProductFiltersAll();
        $productFilters->setFilter(1);
        $productFilters->setHidden(0);

        $productFilterArray = array();
        while ($productFilter = $productFilters->getNext()) {
            $productFilterArray[] = array(
                'id' => $productFilter->getId(),
                'name' => $productFilter->getName(),
                'type' => $productFilter->getType(),
                'value' => $this->getArgumentSecure('custom_filter_'.$productFilter->getId())
            );
        }
        $this->setValue('productFilterArray', $productFilterArray);

    }

    /**
     * Вывод товаров таблицей или проводником, в зависимости от урл
     */
    private function _showProductsBlock() {
        $datasource = $this->_getDataSource();

        $url = Engine::GetURLParser()->getTotalURL();

        if ($url == '/admin/shop/products/') {
            $block = Engine::GetContentDriver()->getContent('shop-admin-products-table');
            $block->setValue('datasource', $datasource);
            $this->setValue('block_table', $block->render());
            $this->setValue('productFilterCount', $datasource->getSQLObject()->getCount());
        } else {
            $block = Engine::GetContentDriver()->getContent('shop-admin-products-inlist');
            $block->setValue('arguments', $this->getArguments());
            $block->setValue('datasource', $datasource);
            $this->setValue('block_folders', $block->render());
        }
    }

    /**
     * Datasource_Products
     *
     * @return Datasource_Products
     */
    protected function _getDataSource() {

        $datasource = new Datasource_Products($this->getArgumentSecure('categoryid'));

        $this->setControlValue('filter_show_deleted', $this->getArgumentSecure('filter_show_deleted'));
        $this->setControlValue('filter_show_hidden', $this->getArgumentSecure('filter_show_hidden'));
        $this->setControlValue('filter_show_not_sync', $this->getArgumentSecure('filter_show_not_sync'));
        $this->setControlValue('filter_show_avail', $this->getArgumentSecure('filter_show_avail'));
        $this->setControlValue('filter_show_not_avail', $this->getArgumentSecure('filter_show_not_avail'));


        if (!$this->getArgumentSecure('filter_show_deleted')) {
            $datasource->getSQLObject()->addWhere('deleted', '0', '=');
        }
        if (!$this->getArgumentSecure('filter_show_hidden')) {
            $datasource->getSQLObject()->addWhere('hidden', '0', '=');
        }
        if ($this->getArgumentSecure('filter_show_not_sync')) {
            $datasource->getSQLObject()->addWhere('unsyncable', '0', '!=');
        }
        if ($this->getArgumentSecure('filter_show_avail') && !$this->getArgumentSecure('filter_show_not_avail')) {
            $datasource->getSQLObject()->addWhere('avail', '1', '=');
        }
        if ($this->getArgumentSecure('filter_show_not_avail') && !$this->getArgumentSecure('filter_show_avail')) {
            $datasource->getSQLObject()->addWhere('avail', '0', '=');
        }
        
        $supplierID = $this->getControlValue('supplierid', 'int');
        if ($supplierID) {
            $a = array(-1);
            $tmpProducts = Shop::Get()->getSupplierService()->getProductsBySupplierID($supplierID);
            while ($x = $tmpProducts->getNext()) {
                $a[] = $x->getId();
            }

            $datasource->getSQLObject()->addWhereArray($a);
        }

        $arguments = $this->getArguments();
        foreach ($arguments as $keyArgument => $argument) {
            if (!$argument) {
                continue;
            }
            if (strpos($keyArgument, 'custom_filter_') === 0) {
                $filterId = str_replace('custom_filter_', '', $keyArgument);
                $filterValue = str_replace(' ', '%', $argument);

                $datasource->getSQLObject()->addWhereQuery(
                    '`id` IN (
                    SELECT `productid` FROM `shopproductfiltervalue`
                    WHERE `filterid` = "'.$filterId.'" AND `filtervalue` LIKE "%'.$filterValue.'%")'
                );

            }
        }

        return $datasource;
    }

    /**
     * Массовые операции над товарами
     */
    private function _productsMassActions() {
        $tagsToAdd = $this->getArgumentSecure('changeaddtags', 'string');
        $tagsToRemove = $this->getArgumentSecure('changeremovetags', 'string');
        $image = $this->getArgumentSecure('changeimage', 'file');
        $description = trim($this->getArgumentSecure('changedescription', 'string'));

        //делаем сохранение масовых сохранений многострочным (заключаем все строки в <p></p>)
        $patterns = array();
        $patterns[0] = '/(^[\w])/';
        $patterns[1] = '/([\w]$)/';
        $replacements = array();
        $replacements[1] = '<p>${1}';
        $replacements[0] = '${1}</p>';
        $result = preg_replace($patterns, $replacements, $description);
        // проверяем строку на наличие пробельных символов и заменяем если таке есть.
        $pattern = '/(\r?\n)+?/i';
        $replacement = '</p><p>';
        $result = preg_replace($pattern, $replacement, $result);
        //удаление пробельных символов перед </p>
        $pattern = '/ <\/p>/i';
        $replacement = '</p>';
        $description = preg_replace($pattern, $replacement, $result);

        if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {
            foreach ($r[1] as $productID) {
                try {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    if ($this->getControlValue('hide') == 'hide') {
                        $product->setHidden(1);
                    } elseif ($this->getControlValue('hide') == 'unhide') {
                        $product->setHidden(0);
                    }

                    if ($this->getControlValue('delete') == 'delete') {
                        try {
                            // пытаемся удалить полностью
                            Shop::Get()->getShopService()->deleteProduct($product);
                        } catch (Exception $deleteEx) {
                            // если не получилось - то помечаем как удаленный
                            $product->setDeleted(1);
                        }
                    } elseif ($this->getControlValue('delete') == 'undelete') {
                        $product->setDeleted(0);
                    }

                    if ($this->getControlValue('avail') == 'setavail') {
                        $product->setAvail(1);
                    } elseif ($this->getControlValue('avail') == 'setunavail') {
                        $product->setAvail(0);
                    }

                    if ($description) {
                        $product->setDescription($description);
                    }

                    $product->update();

                    if ($tagsToAdd) {
                        Shop::Get()->getShopService()->addTagsToProduct($product, $tagsToAdd);
                    }

                    if ($tagsToRemove) {
                        Shop::Get()->getShopService()->deleteTagsFromProduct($product, $tagsToRemove);
                    }

                    if ($image) {
                        Shop::Get()->getShopService()->updateProductImage($product, $image);
                    }
                } catch (Exception $pe) {

                }
            }
        }
    }

    /**
     * Добавление товаров в существующий заказ
     */
    private function _addProductsExistOrder() {
        try {
            $order = Shop::Get()->getShopService()->getOrderByID($this->getControlValue('orderid'));

            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r)) {

                foreach ($r[1] as $productID) {
                    try {
                        Shop::Get()->getShopService()->addOrderProduct($order, $productID);
                    } catch (Exception $pe) {

                    }
                }

                $urlRedirect = $order->makeURLEdit();
                $this->setValue('urlredirect', $urlRedirect);

                if ($this->getControlValue('gotoorder')) {
                    header('Location: ' . $urlRedirect);
                    exit();
                }
                $this->setValue('message', 'ok');
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Добавление товаров в новый заказ
     */
    private function _addProductsToOrder() {
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
                            'tax' => $product->getTax(),
                            'amount' => 1, // количество товаров
                        );
                    } catch (Exception $pe) {

                    }
                }
                $user = Shop::Get()->getUserService()->getUser();
                $result = Shop::Get()->getShopService()->makeOrderByProductArray(
                    $user,
                    false,
                    false,
                    false,
                    false,
                    $productsArray,
                    true
                );
                $order = $result['order'];
                $urlRedirect = $order->makeURLEdit();
                $this->setValue('urlredirect', $urlRedirect);

                if ($this->getControlValue('gotoorder')) {
                    header('Location: ' . $urlRedirect);
                    exit();
                }
                $this->setValue('message', 'ok');
            }
        } catch (Exception $e) {

        }
    }

    /**
     *  Перемещение товаров
     */
    private function _productsChange() {
        try {
            $toCategoryID = $this->getControlValue('movecategory');
            if ($toCategoryID) {
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
            }
        } catch (Exception $e) {

        }

        try {
            $syncID = $this->getControlValue('changesync');
            if (preg_match_all("/(\d+)/ius", $this->getControlValue('moveids'), $r) && $syncID != 'notTouch') {
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

        try {
            $toBrandID = $this->getControlValue('movebrand');
            if ($toBrandID) {
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
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Строим массив всех категорий
     *
     * @return array
     */
    private function _makeCategoryArray() {
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

    /**
     * Строим массив всех категорий
     *
     * @return array
     */
    private function _makeCategoryArray2() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[$x->getParentid()][] = array(
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

}