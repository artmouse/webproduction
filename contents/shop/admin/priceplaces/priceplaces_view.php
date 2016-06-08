<?php
class priceplaces_view extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        try {
            $priceplace = new ShopExportPlace($this->getArgument('id'));
            if (!$priceplace->getId()) {
                throw new ServiceUtils_Exception();
            }

            $this->setValue('name', $priceplace->getName());

            $this->setValue('url', $priceplace->makeExternalLink());

            // добавление кодов
            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $codes = $this->getArgument('codes');
                    if (preg_match_all("/([\d\w]+)/ius", $codes, $r)) {
                        foreach ($r[1] as $code) {
                            $product = false;

                            // поиск товара по коду
                            try {
                                $product = Shop::Get()->getShopService()->getProductByID($code);
                            } catch (Exception $e) {

                            }

                            // поиск по штрих-коду
                            if (!$product) {
                                try {
                                    $product = Shop::Get()->getShopService()->getProductByBarcode($code);
                                } catch (Exception $e) {

                                }
                            }

                            // добавляем товар
                            if ($product) {
                                $links = new XShopExportPlaceCategory();
                                $links->setPlaceid($priceplace->getId());
                                $links->setProductid($product->getId());
                                if (!$links->select()) {
                                    $links->insert();
                                }
                            }
                        }
                    }

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                } catch (Exception $te) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $te;
                    }

                    $this->setValue('message', 'error');
                }
            }

            // получаем список категорий и список товаров
            $categoryArray = array(0);
            $productsArray = array(0);

            $links = new XShopExportPlaceCategory();
            $links->setPlaceid($priceplace->getId());
            while ($x = $links->getNext()) {
                if ($x->getCategoryid()) {
                    $categoryArray[] = $x->getCategoryid();
                }
                if ($x->getProductid()) {
                    $productsArray[] = $x->getProductid();
                }
            }

            // категории превращаем в товары
            foreach ($categoryArray as $id) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID($id);
                    $products = Shop::Get()->getShopService()->getProductsByCategory($category);
                    $products->setHidden(0);
                    while ($x = $products->getNext()) {
                        $productsArray[] = $x->getId();
                    }
                } catch (Exception $e) {

                }
            }

            $productsArray = array_unique($productsArray);

            // строим реальный список товаров
            // (включая скрытые товары!)
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->addWhereArray($productsArray);
            $products->setOrder('name', 'ASC');
            $a = array();
            while ($x = $products->getNext()) {
                $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'price' => $x->getPrice(),
                'currency' => $x->getCurrency()->getName(),
                'url' => $x->makeURLEdit(),
                'image' => $x->makeImageThumb(100),
                );
            }
            $this->setValue('productsArray', $a);

        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }

            Engine::Get()->getRequest()->setContentNotFound();
        }
    }

}