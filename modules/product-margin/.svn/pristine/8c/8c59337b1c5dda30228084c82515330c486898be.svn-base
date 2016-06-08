<?php
class product_margin extends Engine_Class {

    public function process() {
        $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
        $menu->setValue('selected', 'product-margin');
        $this->setValue('menu', $menu->render());

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );
            if ($this->getArgumentSecure('ok')) {
                $this->setValue('reculc', true);
                $curencyProduct = $product->getCurrency();
                $this->setValue('currency', $curencyProduct->getName());

                // цена склада
                if (Shop_ModuleLoader::Get()->isImported('storage')) {
                    $resultStorage = Shop::Get()->getSupplierService()->calculatePriceByStorage($product);
                } else {
                    $resultStorage = false;
                }

                // запишем инфо по поставщикам

                $suppliersInfoArray = $this->_getSuppliersPriceArray($product);
                if ($resultStorage) {
                    // info по складу
                    $storageInfoArray = array(
                        'name' => 'Склад',
                        'price' => $resultStorage['price'],
                        'priceBase' => $resultStorage['pricebase'],
                        'ruleName' => $resultStorage['ruleName'],
                        'discount' => 0,
                        'recomreatil' => $resultStorage['rrc']

                    );
                    $this->setValue('storageInfoArray', $storageInfoArray);
                }
                $this->setValue('suppliersInfoArray', $suppliersInfoArray);

                $calculateAdditionalPrice = Shop::Get()->getSettingsService()->getSettingValue(
                    'calculate-additional-price'
                );
                $priceOld = $product->getPriceold();

                $result = Shop::Get()->getSupplierService()->calculatePrice($product);
                // availtext supplier
                try {
                    $currentSupplierObj = Shop::Get()->getSupplierService()->getSupplierByID(
                        $result['supplierid']
                    );
                    $supplierAvailText = $currentSupplierObj->getAvailtext();
                    $currentSupplierName = $currentSupplierObj->getName();

                } catch (Exception $e) {
                    $supplierAvailText = '';
                    $currentSupplierName = 'Склад';
                }
                $this->setValue('currentSupplierName', $currentSupplierName);
                $product->setRrc($result['rrc']);
                $product->setPrice($result['price']);
                $product->setPricebase($result['pricebase']);
                $product->setSupplierid($result['supplierid']);
                if ($priceOld > $result['price']) {
                    $product->setPriceold($priceOld);
                }
                $product->setAvailtext($supplierAvailText);
                if ($calculateAdditionalPrice) {
                    $event = Events::Get()->generateEvent('shopMarginProductAfter');
                    $event->setProduct($product);
                    $event->notify();
                }
                $product->update();
                $this->setValue('result', $result);
            }

        } catch (Exception $e) {

        }

    }

    private function _getSuppliersPriceArray(ShopProduct $product) {
        $suppliers_price_array = Shop::Get()->getSupplierService()->getSuppliersPrice($product);
        $supplierPriceResalt = array();
        foreach ($suppliers_price_array as $supplier_data) {
            $incoming_supplier_id = $supplier_data['id'];
            $price = $supplier_data['price_discount'];

            $minretail = $supplier_data['minretail'];
            $recommretail = $supplier_data['recommretail'];
            $discount = $supplier_data['s_discount'];
            $pricenew = $price;

            $links = new ShopMarginRuleLink();
            $category = null;

            // смтрим по категориям товара наличие наценок, начинаем с верхней по иерархии
            // берем самую нижнюю по иерархие категорию с наценками
            $priority = 0;
            for ($i = 1; $i < 10; $i++) {
                $id = $product->getField('category' . $i . 'id');
                if ($id != 0 && $rules = $links->categoryHasMarginrule($id)) {
                    // категория имеет много правил нужно проверить все
                    while ($rule = $rules->getNext()) {
                        $marginrule = Shop::Get()->getShopService()->getMarginRuleByID($rule->getMarginruleid());
                        $supplierid = $marginrule->getSupplierid();
                        $brandid = $marginrule->getBrandid();

                        if ($brandid && $product->getBrandid() != $brandid) {
                            continue;
                        }

                        if ($supplierid && $incoming_supplier_id != $supplierid) {
                            continue;
                        }

                        if ($marginrule->getPriority() >= $priority) {
                            // берем самое приоритетное правило из всех категорий
                            $category = Shop::Get()->getShopService()->getCategoryByID($id);
                            $priority = $marginrule->getPriority();
                        }
                    }
                }
            }
            if ($category) {
                $links->addWhereArray(array('AllCategories', $category->getClassname()), 'objecttype');
                $links->addWhereArray(array('AllCategories', $category->getId()), 'objectid');
            } else {
                $links->setObjecttype('AllCategories');
                $links->setObjectid(0);
            }

            $rulesArray = array(); // массив для сортировки правил по приоритетам
            while ($link = $links->getNext()) {
                try {
                    $rule = Shop::Get()->getShopService()->getMarginRuleByID($link->getMarginruleid());

                    $supplierid = $rule->getSupplierid();
                    $brandid = $rule->getBrandid();
                    $pricefrom = Shop::Get()->getCurrencyService()->convertCurrency(
                        $rule->getPricefrom(),
                        $rule->getCurrency(),
                        $product->getCurrency()
                    );

                    $priceto = Shop::Get()->getCurrencyService()->convertCurrency(
                        $rule->getPriceto(),
                        $rule->getCurrency(),
                        $product->getCurrency()
                    );

                    if ($brandid && $product->getBrandid() != $brandid) {
                        continue;
                    }

                    if ($supplierid && $incoming_supplier_id != $supplierid) {
                        continue;
                    }

                    if (($pricefrom && $price < $pricefrom) ||
                        ($priceto && $price > $priceto)) {
                        continue;
                    }


                    $rulesArray[$rule->getPriority()] = $rule;
                } catch (ServiceUtils_Exception $le) {

                }
            }

            ksort($rulesArray);
            @$rule = end($rulesArray); // берем самое приоритетное правило для данного товара.
            if (is_object($rule)) {
                try {
                    $retail = '';
                    $pricenew += $rule->getMarginValue($price, $product->getCurrency());
                    if ($discount) {
                        $retail = "<strong> Учтена скидка поставщика {$discount}%</strong>";
                    }
                    if ($pricenew < $minretail) {
                        $pricenew = $minretail;
                        $retail = '<strong> Минимальная розница</strong>';
                    }
                    if ($recommretail) {
                        $pricenew = $recommretail;
                        $retail = '<strong> РРЦ</strong>';
                    }

                    $supplier = Shop::Get()->getSupplierService()->getSupplierByID($incoming_supplier_id);
                    $supplierPriceResalt[] = array(
                        'name' => $supplier->makeName(),
                        'price' => $pricenew,
                        'priceBase' => $price,
                        'ruleName' => $rule->makeName() . $retail,
                        'discount' => $discount,
                        'minretail' => $minretail,
                        'recomreatil' => $recommretail
                    );

                } catch (Exception $e) {

                }
            }
        }
        return $supplierPriceResalt;
    }

}