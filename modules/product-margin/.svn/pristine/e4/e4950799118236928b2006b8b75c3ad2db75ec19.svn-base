<?php
class marginrule_index extends Engine_Class {

    public function process() {

        ini_set('max_input_vars', 10000);
        ini_set('memory_limit', '512M');
        set_time_limit(5*60); // 5 min

        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');

        // обновить цены
        if ($this->getControlValue('process')) {
            try {
                SQLObject::TransactionStart();

                $categoryId = (int) $this->getArgumentSecure('categoryId');
                // Сбросить supplierId для пересчитываемой категории
                $productToUpdate = Shop::Get()->getShopService()->getProductsAll();
                if ($categoryId !== 0) {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);
                    $productToUpdate = Shop::Get()->getShopService()->getProductsByCategory($category);
                }

                while ($x = $productToUpdate->getNext()) {
                    $x->setSupplierid(0);
                    $x->update();
                }

                $arguments = $this->getArguments();
                $calculateAdditionalPrice = Shop::Get()->getSettingsService()->getSettingValue(
                    'calculate-additional-price'
                );
                foreach ($arguments as $key => $index) {
                    if (preg_match("/^price-(\w+)$/ius", $key, $r)) {
                        $productID = $r[1];

                        $price = $this->getArgumentSecure('price-'.$productID, 'float');
                        $rrc = $this->getArgumentSecure('rrc-'.$productID);
                        $current_supplier_id = $this->getArgumentSecure('current_supplier_id-'.$productID);
                        // себестоимость (цена поставщика)
                        $pricebase = $this->getArgumentSecure('pricesupplier-'.$productID, 'float');
                        // старая цена
                        $priceold = $this->getArgumentSecure('priceold-'.$productID, 'float');

                        try {
                            $product = Shop::Get()->getShopService()->getProductByID(
                                $productID
                            );
                            // старая цена, если она больше новой
                            if ($priceold > $price) {
                                $product->setPriceold($priceold);
                            }
                            
                            // availtext supplier
                            try {
                                $currentSupplierObj = Shop::Get()->getShopService()->getSupplierByID(
                                    $current_supplier_id
                                );
                                $supplierAvailText = $currentSupplierObj->getAvailtext(); 
                            } catch (Exception $e) {
                                $supplierAvailText = '';
                            }
                            
                            $product->setRrc($rrc);
                            $product->setPricebase($pricebase);
                            $product->setPrice($price);
                            $product->setSupplierid($current_supplier_id);
                            $product->setAvailtext($supplierAvailText);
                            if ($calculateAdditionalPrice) {
                                $event = Events::Get()->generateEvent('shopMarginProductAfter');
                                $event->setProduct($product);
                                $event->notify();
                            }
                            $product->update();
                        } catch (ServiceUtils_Exception $pe) {

                        }
                    }
                }

                SQLObject::TransactionCommit();
                $this->setValue('message', 'ok');

                // Отправка писем о пересчете 
                // Выбрать всех админов
                $adminAll = new XUser();
                $adminAll->setDeleted(0);
                $adminAll->setLevel(3);
                while ($admin = $adminAll->getNext()) {
                    // если нет email - перейти к следующему админу
                    if (!$admin->getEmail()) {
                        continue;
                    }
                    // отправить письмо админу о пересчете 
                    $from = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                    $to = $admin->getEmail();
                    $pdate = DateTime_Formatter::DateTimeISO9075(DateTime_Object::Now());
                    $subj = 'Пересчет цен '.$pdate;
                    if (!$categoryId) {
                        $body = 'Выполнен пересчет цен в оконном режиме по всем категориям ';
                    } else {
                        $body = 'Выполнен пересчет цен в оконном режиме по категории "'.$category->getName().'"';
                    }                    
                    $body .= "\nв ".$pdate;
                    try {
                        Shop::Get()->getUserService()->sendEmail($from, $to, $subj, $body);
                    } catch (Exception $exc) {

                    }
                }

            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
                $this->setValue('message', 'error');
            }

        }

        // пересчитать цены
        if ($this->getControlValue('ok')) {
            try {
                $categoryID =  $this->getArgumentSecure('categoryid');
                $this->setValue('categoryId', $categoryID);

                if ($categoryID == 0) {
                    $products = Shop::Get()->getShopService()->getProductsAll();
                } else {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                    $products = Shop::Get()->getShopService()->getProductsByCategory($category);
                }
                $products->filterUnsyncable(0);
                $products->setDeleted(0);
                $productArray = array();

                while ($product = $products->getNext()) {
                    try {
                        $result = Shop::Get()->getSupplierService()->calculatePrice($product);
                        if (!$result['price']) {
                            continue;
                        }

                        $color = false;
                        $priceOld = round($product->getPrice(), 2);
                        $pricenew = $result['price'];

                        if ($priceOld > $pricenew) {
                            $color = 'palegreen';
                        } else if ($priceOld < $pricenew) {
                            $color = 'coral';
                        }

                        $productArray[] = array(
                        'productid' => $product->getId(),
                        'productname' => $product->makeName(),
                        'rulename' => $result['ruleName'],
                        'priceold' => $priceOld,
                        'pricesupplier' => $result['pricebase'],
                        'current_supplier_id' => $result['supplierid'],// выбранный поставщик
                        'pricenew' => $pricenew,
                        'currency' => $product->getCurrency()->getName(),
                        'color' => $color,
                        'rrc' => $result['rrc'],
                        );
                    } catch (ServiceUtils_Exception $pe) {

                    }
                }

                $this->setValue('productArray', $productArray);
            } catch (ServiceUtils_Exception $se) {

            }
        }

        // Пересчитать цены в фоне
        if ($this->getControlValue('recalcLeftOff')) {
            $categoryID =  $this->getArgumentSecure('categoryid');
            Shop::Get()->getSupplierService()->createProductPriceTask($categoryID);
            $this->setValue('message', 'okLeftOffImport');
        }

        // Пересчитать все цены в фоне
        if ($this->getControlValue('recalcLeftOffOll')) {
            Shop::Get()->getSupplierService()->createProductPriceTask(0);
            $this->setValue('message', 'okLeftOffImport');
        }

        // поиск правил для текущей категории и для всех категорий
        try {
            $categoryID = $this->getArgumentSecure('categoryid');

            if ($categoryID == 0) { // все категории
                $this->setValue('allCategory', 'allCategory');
                $links = new ShopMarginRuleLink();
                $links->setObjecttype('AllCategories');
                $links->setObjectid(0);
            } else { // для всех категорий и для текущей
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryID);
                $links = new ShopMarginRuleLink();
                $links->addWhereArray(array('AllCategories',$category->getClassname() ), 'objecttype');
                $links->addWhereArray(array('AllCategories',$category->getId() ), 'objectid');
            }

            $ruleArray = array();
            while ($link = $links->getNext()) {
                try {
                    $brand_name = '';
                    $supplier_name = '';
                    $rule = Shop::Get()->getShopService()->getMarginRuleByID($link->getMarginruleid());
                    // бренд
                    $barandId = $rule->getBrandid();
                    if ($barandId) {
                        $brand_obj = Shop::Get()->getShopService()->getBrandByID($barandId);
                        $brand_name = $brand_obj->getName();
                    }
                    // поставщик

                    $suppllirId = $rule->getSupplierid();
                    if ($suppllirId) {
                        $supplier_obj = Shop::Get()->getShopService()->getSupplierByID($suppllirId);
                        $supplier_name = $supplier_obj->getName();
                    }
                    $ruleArray[] = array(
                    'name' => $rule->makeName(),
                    'url' => Engine::GetLinkMaker()->makeURLByContentIDParam(
                        'shop-admin-marginrule-control',
                        $link->getId()
                    ),
                    'priority' => $rule->getPriority(),
                    'brand_name' => $brand_name,
                    'supplier_name' => $supplier_name,
                    );

                } catch (ServiceUtils_Exception $le) {

                }
            }

            // сортировка
            foreach ($ruleArray as $key => $row) {
                $priority[$key] = $row['priority'];
            }

            if ($ruleArray) {
                array_multisort($priority, SORT_DESC, $ruleArray);
            }

            $this->setValue('ruleArray', $ruleArray);

        } catch (ServiceUtils_Exception $se) {

        }

        // категории
        $categoryArray = $this->_makeCategoryArray();
        
        try {
            // Если есть правило для всех категорий, берем отдельно
            $shopMarginruleLink = new ShopMarginRuleLink();
            $shopMarginruleLink->setObjecttype('AllCategories');
            if ($marginrule = $shopMarginruleLink->getNext()) {
                array_unshift(
                    $categoryArray,
                    array(
                        'id' => 0,
                        'name' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_category_all'),
                        'selected' => 0 == $this->getArgumentSecure('categoryid'),
                        'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => 0)),
                        'level' => 0
                    )
                );
            }
        } catch (Exception $e) {

        }

        $categoryArrNew = array();
        $duplicateId = array();
        foreach ($categoryArray as $key => $value) {
            if (in_array($value['id'], $duplicateId)) {
                continue;
            }
            $duplicateId[] = $value['id'];
            $categoryArrNew[$key] = $value; 
        }
         $this->setValue('categoryArray', $categoryArrNew);


        $categoryArrNew = array();
        $categoryArrNew1 = array();
        $categoryArrs = $this->_makeCategoryArray2();
        foreach ($categoryArrs as $k => $v) {
            $duplicateId = array();
            $categoryArrNew = array();
            foreach ($v as $key => $value) {
                if (in_array($value['id'], $duplicateId)) {
                    continue;
                }
                $duplicateId[] = $value['id'];
                $categoryArrNew[$key] = $value;
            }
            $categoryArrNew1[$k] = $categoryArrNew;
        }

        $this->setValue('newCategoryArray', $categoryArrNew1);
    }

    /**
     * Private _makeCategoryArray()
     * 
     * @return array
     */
    private function _makeCategoryArray() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhereQuery(
            '(`id` IN (SELECT `shopmarginrulelink`.`objectid` FROM `shopmarginrulelink`
            WHERE `shopmarginrulelink`.`objecttype` = \'ShopCategory\'))'
        );
        $categoryIdArray = array();
        $a = array();
        while ($x = $category->getNext()) {
            $categoryIdArray[] = $x->getId();
            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
            'parentid' => $x->getParentid(),
            );
        }

        // Добавлеем родителей к категориям нижних уровней

        foreach ($a as $item) {
            // пропустить имеющиеся
            if (in_array($item[0]['parentid'], $categoryIdArray)) {
                continue;
            }

            try {

                $a = $this->_addParentCategory($a, $item[0]['parentid']);
            } catch (Exception $e) {

            }
        }

        return $this->_makeCategoryTree(0, 0, $a);
    }

    /**
     * Private _makeCategoryArray()
     *
     * @return array
     */
    private function _makeCategoryArray2() {
        // строим массив всех категорий
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhereQuery(
            '(`id` IN (SELECT `shopmarginrulelink`.`objectid` FROM `shopmarginrulelink`
            WHERE `shopmarginrulelink`.`objecttype` = \'ShopCategory\'))'
        );

        $categoryIdArray = array();
        $a = array();
        while ($x = $category->getNext()) {
            $categoryIdArray[] = $x->getId();
            $a[$x->getParentid()][] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
                'parentid' => $x->getParentid(),
            );


            try{
                while ($x = $x->getParent()) {
                    if (!in_array($x->getId(), $categoryIdArray)) {
                        $a[$x->getParentid()][] = array(
                            'id' => $x->getId(),
                            'name' => $x->getName(),
                            'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
                            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(
                                array('categoryid' => $x->getId())
                            ),
                            'parentid' => $x->getParentid(),
                        );
                    }
                }
            } catch (Exception $ee) {

            }

        }


        return $a;
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
     * Добавить родительские категории, массиву категорий
     * @param array $a
     * @param integer $categoryId
     * @return array
     */
    private function _addParentCategory($a, $categoryId) {
        $x = Shop::Get()->getShopService()->getCategoryByID($categoryId);
        $a[$x->getParentid()][] = array(
        'id' => $x->getId(),
        'name' => $x->getName(),
        'selected' => $x->getId() == $this->getArgumentSecure('categoryid'),
        'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('categoryid' => $x->getId())),
        'parentid' => $x->getParentid(),
        );
        
        if ($x->getParentid()) {
            $a = $this->_addParentCategory($a, $x->getParentid());
        }
        return $a;
    }

}