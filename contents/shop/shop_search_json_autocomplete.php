<?php
class shop_search_json_autocomplete extends Engine_Class {

    public function process() {
        try {
            $categoryid = $this->getArgumentSecure('categoryid');
            $query = $this->getArgument('name');

            try {
                $searchOptionArray = Engine::Get()->getConfigField('search-options');
            } catch (Exception $e) {
                $searchOptionArray = array('product', 'brand', 'category', 'page');
            }

            $type = $this->getArgumentSecure('type', 'string');
            if ($type) {
                $searchOptionArray = array($type);
            }

            $a = array();

            // если пришёл параметр категории, то ищем только в товарах
            if ($categoryid && $categoryid != -1) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                    $object = Shop::Get()->getShopService()->searchProducts($query, false);
                    $object->filterField('category'.$category->getLevel().'id', $category->getId());
                    $a = array_merge($a, $this->_getObjectArray($object));
                } catch (Exception $e) {

                }
            } else {
                foreach ($searchOptionArray as $searchKey) {
                    if ($searchKey == 'product') {
                        // поиск по товарам
                        $object = Shop::Get()->getShopService()->searchProducts($query, false);
                        if (Shop::Get()->getSettingsService()->getSettingValue('filtering-product-on-presence')) {
                            if ($object->getOrderBy()) { // если строки сортировки нет, то нет и товаров
                                $object->setOrderBy(
                                    array('CASE WHEN avail > 0 THEN 1 ELSE 0 END DESC', $object->getOrderBy())
                                );
                            }
                        }
                        $object->setHidden(0);
                        $object->setDeleted(0);
                        $object->addWhereQuery("categoryid IN (SELECT id FROM shopcategory WHERE hidden=0)");
                        $object->setLimitCount(10);
                    } elseif ($searchKey == 'brand') {
                        $object = Shop::Get()->getShopService()->searchBrand($query, false);
                        $object->setLimitCount(3);
                    } elseif ($searchKey == 'category') {
                        $object = Shop::Get()->getShopService()->searchCategory($query, false);
                        $object->setLimitCount(3);
                    } elseif ($searchKey == 'page') {
                        $object = Shop::Get()->getShopService()->searchPage($query, false);
                        $object->setLimitCount(3);
                    }

                    $a = array_merge($a, $this->_getObjectArray($object));
                }
            }

            echo json_encode($a);
        } catch (Exception $e) {

        }

        exit();
    }

    private function _getObjectArray($object) {
        $a = array();
        while ($x = $object->getNext()) {
            if (get_class($object) == 'ShopTextPage') {
                $description = strip_tags($x->getContent());
                $image = $x->makeImage();
            } else {
                $description = strip_tags($x->getDescription());
                $image = $x->makeImageThumb(100);
                if (!$image) {
                    $image = Shop_ImageProcessor::MakeThumbUniversal(
                        PackageLoader::Get()->getProjectPath().'/media/shop/stub.jpg',
                        100
                    );
                }
            }
            $description = StringUtils_Limiter::LimitWordsSmart($description, 20);

            $b = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getName()),
                'url' => $x->makeURL(),
                'image' => $image,
                'description' => $description,
            );

            if (get_class($object) == 'ShopProduct') {
                $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
                $b['isproduct'] = 1;

                $b['avail'] = $x->getAvail();

                if ($x->getAvailtext()) {
                    $b['availtext'] = htmlspecialchars($x->getAvailtext());
                } elseif ($x->getAvail()) {
                    $b['availtext'] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_v_nalichii');
                } else {
                    $b['availtext'] = Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_net_v_nalichii'
                    );
                }

                $b['price'] = $x->makePrice($currencyDefault, true);
                $b['currency'] = $currencyDefault->getSymbol();
            }

            $a[] = $b;
        }

        return $a;
    }

}