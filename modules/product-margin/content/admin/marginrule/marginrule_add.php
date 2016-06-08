<?php
class marginrule_add extends Engine_Class {

    public function process() {
        $categoryIDArray = $this->getArgumentSecure('categoryid', 'array');

        if ($this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                $noException = false;
                for ($i = 1; $i <= 10; $i++) {
                    $pricefrom = $this->getControlValue('pricefrom'.$i);
                    $priceto = $this->getControlValue('priceto'.$i);
                    $type = $this->getControlValue('type'.$i);
                    $value = $this->getControlValue('value'.$i);
                    $currencyID = $this->getControlValue('currencyid'.$i);
                    $brandID = $this->getControlValue('brandid'.$i);
                    $supplierID = $this->getControlValue('supplierid'.$i);
                    $priority = $this->getControlValue('priority'.$i);

                    if ($priority < 0) {
                        $priority = 0;
                    } else if ($priority > 99) {
                        $priority = 99;
                    }

                    $pricefrom = (float) str_replace(',', '.', $pricefrom);
                    $priceto = (float) str_replace(',', '.', $priceto);
                    $value = (float) str_replace(',', '.', $value);

                    if ($value && $categoryIDArray) {
                        $rule = new ShopMarginRule();
                        $rule->setPricefrom($pricefrom);
                        $rule->setPriceto($priceto);
                        $rule->setType($type);
                        $rule->setValue($value);
                        $rule->setCurrencyid($currencyID);
                        $rule->setBrandid($brandID);
                        $rule->setSupplierid($supplierID);
                        $rule->setPriority($priority);
                        if (!$rule->select()) {
                            $rule->insert();
                        }
                        $locationCategoryId = 0;
                        foreach ($categoryIDArray as $categoryID) {
                            try {
                                if ( $categoryID == -1 ) {
                                    $link = new ShopMarginRuleLink();
                                    $link->setObjecttype('AllCategories');
                                    $link->setObjectid(0);
                                    $link->setMarginruleid($rule->getId());
                                    $link->insert();
                                } else {
                                    $category = Shop::Get()->getShopService()->getCategoryByID(
                                        $categoryID
                                    );
                                    $locationCategoryId = $categoryID;
                                    $link = new ShopMarginRuleLink();
                                    $link->setObjecttype($category->getClassname());
                                    $link->setObjectid($category->getId());
                                    $link->setMarginruleid($rule->getId());
                                    if (!$link->select()) {
                                        $link->insert();
                                    }
                                }
                            } catch (ServiceUtils_Exception $ce) {

                            }
                        }
                        $noException = true;
                    }

                }
                if ( $noException ) {
                    SQLObject::TransactionCommit();

                    $url = Engine::GetLinkMaker()->makeURLByContentIDParams(
                        'shop-admin-marginrule',
                        array('categoryid' => $locationCategoryId)
                    );

                    header('Location: '.$url);
                } else {
                    $this->setValue('message', 'empty');
                    SQLObject::TransactionRollback();
                }

            } catch (Exceprion $e) {
                SQLObject::TransactionRollback();
                $this->setValue('message', 'error');
            }

        }

        $this->setValue('categorySelectedArray', $categoryIDArray);

        // валюты
        $currencies = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $currencyArray = array();
        while ($x = $currencies->getNext()) {
            $currencyArray[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('currencyArray', $currencyArray);

        // список категорий
        $category = Shop::Get()->getShopService()->makeCategoryTree();
        $a = array();
        foreach ($category as $x) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->makeName(),
            'hidden' => $x->getHidden(),
            'level' => $x->getField('level'),
            );
        }
        $this->setValue('categoryArray', $a);

        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $a = array();
        while ($x = $brands->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('brandArray', $a);

        // список поставщиков
        $suppliers = Shop::Get()->getSupplierService()->getSuppliersActive();
        $a = array();
        while ($x = $suppliers->getNext()) {
            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName()
            );
        }
        $this->setValue('suppliersArray', $a);
    }

}