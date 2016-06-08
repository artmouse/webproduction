<?php
class marginrule_control extends Engine_Class {

    public function process() {
        try {
            $link = Shop::Get()->getShopService()->getMarginRuleLinkByID(
                $this->getArgumentSecure('id')
            );

            $rule = Shop::Get()->getShopService()->getMarginRuleByID(
                $link->getMarginruleid()
            );

            // обновление
            if ($this->getControlValue('update')) {
                try {
                    SQLObject::TransactionStart();

                    $pricefrom = $this->getControlValue('pricefrom');
                    $priceto = $this->getControlValue('priceto');
                    $type = $this->getControlValue('type');
                    $value = $this->getControlValue('value');
                    $currencyID = $this->getControlValue('currencyid');

                    $pricefrom = (float) str_replace(',', '.', $pricefrom);
                    $priceto = (float) str_replace(',', '.', $priceto);
                    $value = (float) str_replace(',', '.', $value);

                    $priority = $this->getControlValue('priority');
                    $supplierID = $this-> getControlValue('supplierid');
                    $brandID = $this->getControlValue('brandid');

                    if ($priority < 0) {
                        $priority = 0;
                    } else if ($priority > 99) {
                        $priority = 99;
                    }

                    // для всех категорий
                    if ($this->getControlValue('apply') == 'all') {
                        $rule->setPricefrom($pricefrom);
                        $rule->setPriceto($priceto);
                        $rule->setType($type);
                        $rule->setValue($value);
                        $rule->setCurrencyid($currencyID);
                        $rule->setBrandid($brandID);
                        $rule->setSupplierid($supplierID);
                        $rule->setPriority($priority);
                        $rule->update();

                        // для текущей категории
                    } elseif ($this->getControlValue('apply') == 'this') {
                        $rule = new ShopMarginRule();
                        $rule->setPricefrom($pricefrom);
                        $rule->setPriceto($priceto);
                        $rule->setType($type);
                        $rule->setValue($value);
                        $rule->setCurrencyid($currencyID);
                        $rule->setBrandid($brandID);
                        $rule->setSupplierid($supplierID);
                        $rule->setPriority($priority);
                        $rule->insert();

                        $link->setMarginruleid($rule->getId());

                        $link->update();
                    }

                    SQLObject::TransactionCommit();
                    $this->setValue('message', 'ok');
                    $this->setValue('categoryid', $link->getObjectid());
                } catch (Exceprion $ue) {
                    SQLObject::TransactionRollback();
                    $this->setValue('message', 'error');
                }
            }

            // получаем текущую категорию
            try {
                if ($link->getObjecttype() == 'ShopCategory') {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                        $link->getObjectid()
                    );

                    $this->setValue('categoryThisName', $category->getName());
                }
            } catch (ServiceUtils_Exception $se) {

            }

            // получаем все категории, в которых есть данное правило
            $links = new ShopMarginRuleLink();
            $links->setMarginruleid($rule->getId());
            $categoryArray = array();
            while ($link = $links->getNext()) {
                try {
                    if ($link->getObjecttype() == 'ShopCategory') {
                        $category = Shop::Get()->getShopService()->getCategoryByID(
                            $link->getObjectid()
                        );

                        $categoryArray[] = $category->getName();
                    }
                } catch (ServiceUtils_Exception $se) {

                }
            }

            $this->setValue('categoryAllName', implode(', ', $categoryArray));

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
            $this->setValue('supplierArray', $a);

            $this->setControlValue('pricefrom', $rule->getPricefrom());
            $this->setControlValue('priceto', $rule->getPriceto());
            $this->setControlValue('type', $rule->getType());
            $this->setControlValue('value', $rule->getValue());
            $this->setControlValue('currencyid', $rule->getCurrencyid());
            $this->setControlValue('brandid', $rule->getBrandid());
            $this->setControlValue('supplierid', $rule->getSupplierid());
            $this->setControlValue('priority', $rule->getPriority());

            // удаление
            if ($this->getControlValue('delete')) {
                try {
                    SQLObject::TransactionStart();

                    if ($this->getControlValue('apply') == 'all') {
                        $links = new ShopMarginRuleLink();
                        $links->setMarginruleid($rule->getId());
                        while ($link = $links->getNext()) {
                            $link->delete();
                        }

                        $rule->delete();

                    } elseif ($this->getControlValue('apply') == 'this') {
                        $link = Shop::Get()->getShopService()->getMarginRuleLinkByID(
                            $this->getArgumentSecure('id')
                        );
                        $link->delete();
                    }

                    SQLObject::TransactionCommit();
                    $this->setValue('message', 'ok');
                } catch (Exceprion $de) {
                    SQLObject::TransactionRollback();
                    $this->setValue('message', 'error');
                }
            }

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

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}