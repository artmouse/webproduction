<?php
class shop_search extends Engine_Class {

    public function process() {
        Engine::GetHTMLHead()->setMetaTag('robots', 'noindex');

        try {
            $categoryid = $this->getArgumentSecure('categoryid');
            $query = $this->getArgument('query');
            $query = str_replace('/',' ',$query);
            $query = trim($query);
            if ($query != $this->getArgument('query')) {
                $_SESSION[$query] = $this->getArgument('query');
            } elseif (isset($_SESSION[$query])) {
                unset($_SESSION[$query]);
            }
            try {
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                $url = Engine::GetLinkMaker()->makeURLByContentIDParams('shop-search',
                    array('queryfixed' => urlencode($query), 'categoryid' => $category->getId()));
            } catch (Exception $e) {
                $url = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-search', urlencode($query), 'queryfixed');
            }

            header('Location: '.$url);
            exit();
        } catch (Exception $e) {

        }

        try {
            $query = urldecode($this->getArgument('queryfixed'));
            if (!empty($_SESSION[$query])) {
                $query = $_SESSION[$query];
            }

            Engine::GetURLParser()->setArgument('query', $query);

            $this->setValue('name', $query, true);
            Engine::GetHTMLHead()->setTitle($this->getControlValue('query'));
            $slogan = Shop::Get()->getSettingsService()->getSettingValue('shop-slogan');
            if ($slogan) {
                Engine::GetHTMLHead()->setMetaDescription($slogan);
            }

            try {
                $searchOptionArray = Engine::Get()->getConfigField('search-options');
            } catch (Exception $e) {
                $searchOptionArray = array('product', 'brand', 'category', 'page');
            }

            $a = array();

            $page = intval($this->getArgumentSecure('p')); // на следующих страницах выводим только товары

            // если есть параметр категории, то ищем только в товарах
            if ($categoryid) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($categoryid);
                    $blockSearch = Engine::GetContentDriver()->getContent('block-search');
                    $blockSearch->setValue('categoryIdSelected',$category->getId());
                    $products = Shop::Get()->getShopService()->searchProducts(
                        $query
                    );
                    $products->filterField('category'.$category->getLevel().'id',$category->getId());
                    $render = Engine::GetContentDriver()->getContent('shop-product-list');
                    $render->setValue('filtercategory', true);
                    $render->setValue('filterbrand', true);
                    $render->setValue('no_hidden_regulate', true);
                    $render->setValue('items', $products);
                    $render->setValue('need_relevance_sort', true);
                    $render->setValue('pathArray', $this->_makePathArray($query));
                    $a['product'] = $render->render();

                    $this->setValue('pathAdditionalH1', $render->getValue('pathAdditionalH1'));
                } catch (Exception $e) {

                }
            } else {
                foreach ($searchOptionArray as $searchKey) {
                    if ($searchKey == 'product') {
                        $products = Shop::Get()->getShopService()->searchProducts(
                            $query
                        );
                        $render = Engine::GetContentDriver()->getContent('shop-product-list');
                        $render->setValue('filtercategory', true);
                        $render->setValue('filterbrand', true);
                        $render->setValue('no_hidden_regulate', true);
                        $render->setValue('items', $products);
                        $render->setValue('need_relevance_sort', true);
                        $render->setValue('pathArray', $this->_makePathArray($query));
                        $a[$searchKey] = $render->render();

                        $this->setValue('pathAdditionalH1', $render->getValue('pathAdditionalH1'));
                    } elseif (!$page) {
                        if ($searchKey == 'brand') {
                            $object = Shop::Get()->getShopService()->searchBrand($query,false);
                        } elseif ($searchKey == 'category') {
                            $object = Shop::Get()->getShopService()->searchCategory($query,false);
                        } elseif ($searchKey == 'page') {
                            $object = Shop::Get()->getShopService()->searchPage($query,false);
                        }
                        $object->setLimitCount(3);
                        $a[$searchKey] = $this->_getObjectArray($object);
                    }
                }
            }

            $this->setValue('resultArray',$a);

        } catch (Exception $e) {
            $this->setValue('error', true);
        }
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
                    $image = Shop_ImageProcessor::MakeThumbUniversal(PackageLoader::Get()->getProjectPath().'/media/shop/stub.jpg', 100);
                }
            }
            $description = StringUtils_Limiter::LimitWordsSmart($description, 20);

            $a[] = array(
                'id' => $x->getId(),
                'name' => htmlspecialchars($x->getName()),
                'url' => $x->makeURL(),
                'image' => $image,
                'description' => $description,
            );
        }
        return $a;
    }

    /**
     * Построить путь категории
     *
     * @param ShopCategory $category
     * @return array
     */
    private function _makePathArray($query) {
        $a = array();
        $url = Engine::GetLinkMaker()->makeURLByContentIDParam('shop-search', urlencode($query), 'queryfixed');
        $a[] = array(
        'name' => $query,
        'url' => $url,
        );
        return $a;
    }

}