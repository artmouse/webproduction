<?php
class products_copy extends Engine_Class {

    public function process() {
        PackageLoader::Get()->import('CKFinder');
        CKFinder_Configuration::Get()->setAuthorized(true);
        $useCode1c = Shop::Get()->getSettingsService()->getSettingValue('use-code-1c');
        $this->setValue('useCode1c', $useCode1c);

        try {
            $product = false;
            if ($this->getArgumentSecure('copy')) {
                try {
                    if ($useCode1c) {
                        $product = Shop::Get()->getShopService()->getProductByCode1c(
                            $this->getControlValue('copyid')
                        );
                    } else {
                        $product = Shop::Get()->getShopService()->getProductByID(
                            $this->getControlValue('copyid')
                        );
                    }

                } catch (Exception $e) {
                    $this->setValue('messageCopy', 'error');
                }
            }
            $allowStorage = Engine::Get()->getConfigFieldSecure('storage-status');

            if ($product) {
                $this->setValue('productid', $product->getId());
                Engine::GetHTMLHead()->setTitle(
                    Shop::Get()->getTranslateService()->getTranslateSecure(
                        'translate_sozdat_kopiyu_tovara_'
                    ).$product->getId()
                );
                $this->setValue('allowStorage', $allowStorage);

                $this->setControlValue('name', $product->getName());
                $this->setControlValue('description', $product->getDescription());
                $this->setControlValue('price', $product->getPrice());
                $this->setControlValue('currency', $product->getCurrencyid());
                $this->setControlValue('category', $product->getCategoryid());
                $this->setControlValue('brand', $product->getBrandid());
                $this->setControlValue('model', $product->getModel());
                $this->setControlValue('discount', $product->getDiscount());
                $this->setControlValue('hidden', $product->getHidden());
                $this->setControlValue('deleted', $product->getDeleted());
                $this->setControlValue('unit', $product->getUnit());
                $this->setControlValue('url', $product->getUrl());
                $this->setControlValue('barcode', $product->getBarcode());
                $this->setControlValue('warranty', $product->getWarranty());
                $this->setControlValue('collection', $product->getCollectionid());
                $this->setControlValue('width', $product->getWidth());
                $this->setControlValue('height', $product->getHeight());
                $this->setControlValue('length', $product->getLength());
                $this->setControlValue('weight', $product->getWeight());
                $this->setControlValue('unitbox', $product->getUnitbox());
                $this->setControlValue('delivery', $product->getDelivery());
                $this->setControlValue('payment', $product->getPayment());
                $this->setControlValue('divisibility', $product->getDivisibility());
                $this->setControlValue('syncable', !$product->getUnsyncable());
                $this->setControlValue('avail', $product->getAvail());
                $this->setControlValue('availtext', $product->getAvailtext());
                $this->setControlValue('userid', $product->getUserid());
                $this->setControlValue('siteurl', $product->getSiteurl());
                $this->setControlValue('denycomments', $product->getDenycomments());
                $this->setControlValue('tax', $product->getTax());
                $this->setControlValue('descriptionshort', $product->getDescriptionshort());
                //$this->setControlValue('codesupplier', $product->getCodesupplier());
                $this->setControlValue('name1', $product->getName1());
                $this->setControlValue('name2', $product->getName2());
                $this->setControlValue('code1c', $product->getCode1c());
                $this->setControlValue('characteristics', $product->getCharacteristics());
                $this->setControlValue('share', $product->getShare());
                $this->setControlValue('seotitle', $product->getSeotitle());
                $this->setControlValue('seodescription', $product->getSeodescription());
                $this->setControlValue('seocontent', $product->getSeocontent());
                $this->setControlValue('seokeywords', $product->getSeokeywords());
                $this->setControlValue('priceold', $product->getPriceold());
                $this->setControlValue('seriesname', $product->getSeriesname());

                $mainImage = @$product->getImage();

                $this->setValue('imagemainsrc', $mainImage);
                $this->setValue('imagemain', $product->makeImageThumb(200));

                // список фильтров
                $filters = Shop::Get()->getShopService()->getProductFiltersAll();
                $this->setValue('filtersArray', $filters->toArray());

                $filters = Shop::Get()->getShopService()->getProductFilterValues($product);

                $a = array();
                while ($x = $filters->getNext()) {
                    $a[] = array(
                        'id' => $x->getFilterid(),
                        'value' => htmlspecialchars($x->getFiltervalue()),
                        'use' => $x->getFilteruse(),
                        'actual' => $x->getFilteractual(),
                        'option' => $x->getFilteroption(),
                        'markup' => $x->getFiltermarkup(),
                    );
                }
                // +5 полей
                for ($i = 1; $i <= 5; $i++) {
                    $a[] = array();
                }
                $this->setValue('valuesArray', $a);

                // дополнительные изображения
                $images = $product->getImages();
                $a = array();
                while ($x = $images->getNext()) {
                    try {
                        $a[] = array(
                        'id' => $x->getId(),
                        'image' => $x->makeImageThumb(200),
                        'imagebig' => $x->makeImageThumb(1200),
                        );
                    } catch (Exception $e) {

                    }
                }
                $this->setValue('imagesArray', $a);

                // список категорий
                $category = Shop::Get()->getShopService()->getCategoryAll();
                $a = array();
                while ($x = $category->getNext()) {
                    $a[$x->getParentid()][] = array(
                    'id' => $x->getId(),
                    'name' => $x->getName(),
                    'hidden' => $x->getHidden(),
                    );
                }
                $this->setValue('categoryArray', $this->_makeCategoryTree(0, 0, $a));

                // список брендов
                $brands = Shop::Get()->getShopService()->getBrandsAll();
                $this->setValue('brandsArray', $brands->toArray());

                // список валют
                $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
                $this->setValue('currencyArray', $currency->toArray());
            }

            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    $product = Shop::Get()->getShopService()->addProduct(
                        $this->getControlValue('name')
                    );

                    $image = $this->getControlValue('image');
                    $image = @$image['tmp_name'];

                    // Загружаем имагу.
                    // Если Пользователь не выбрал новую картинку, то подставлем с товара-донора
                    if (!$image) {
                        if ($this->getArgumentSecure('mainimageurl')) {
                            $image = PackageLoader::Get()->getProjectPath().$this->getArgumentSecure('mainimageurl');
                        } else {
                            $image = false;
                        }
                    }

                    try {
                        Shop::Get()->getShopService()->updateProduct(
                            $product,
                            $product->getName(),
                            $this->getControlValue('description'),
                            $this->getControlValue('category'),
                            $this->getControlValue('brand'),
                            $this->getControlValue('model'),
                            $this->getControlValue('price'),
                            $this->getControlValue('priceold'),
                            $this->getControlValue('currency'),
                            $this->getControlValue('unit'),
                            $this->getControlValue('barcode'),
                            $this->getControlValue('discount'),
                            false,
                            $this->getControlValue('warranty'),
                            $this->getControlValue('hidden'),
                            $this->getControlValue('deleted'),
                            $this->getControlValue('avail'),
                            $this->getControlValue('availtext'),
                            $this->getControlValue('syncable'),
                            $this->getControlValue('url'),
                            $image,
                            false,
                            0,
                            $this->getControlValue('width'),
                            $this->getControlValue('height'),
                            $this->getControlValue('length'),
                            $this->getControlValue('weight'),
                            $this->getControlValue('unitbox'),
                            $this->getControlValue('delivery'),
                            $this->getControlValue('payment'),
                            $this->getControlValue('divisibility'),
                            $this->getControlValue('userid'),
                            $this->getControlValue('denycomments'),
                            $this->getControlValue('notdiscount'),
                            $this->getControlValue('maxdiscount'),
                            $this->getControlValue('siteurl'),
                            $this->getControlValue('tax'),
                            $this->getControlValue('descriptionshort'),
                            $this->getControlValue('name1'),
                            $this->getControlValue('name2'),
                            $this->getControlValue('code1c'),
                            0,
                            $this->getControlValue('characteristics'),
                            $this->getControlValue('share'),
                            $this->getControlValue('seotitle'),
                            $this->getControlValue('seodescription'),
                            $this->getControlValue('seocontent'),
                            $this->getControlValue('seokeywords'),
                            false,
                            false,
                            $this->getControlValue('deleteDownloadfile'),
                            $this->getControlValue('datelifefrom'),
                            $this->getControlValue('datelifeto'),
                            $this->getControlValue('articul'),
                            $this->getControlValue('suppliered')
                        );
                    } catch (Exception $tty) {

                    }

                    // Добавляем картинки с товара-донора (Существующие).
                    $smallImagesArray = $this->getArgumentSecure('smallImagesArray', 'array');

                    if ($smallImagesArray) {
                        foreach ($smallImagesArray as $bigImageURL) {
                            Shop::Get()->getShopService()->addProductImage(
                                $product,
                                PackageLoader::Get()->getProjectPath().$bigImageURL
                            );
                        }
                    }


                    // добавляемновые дополнительные картинки
                    for ($index = 1; $index <= 5; $index++) {
                        try {
                            $image = $this->getArgument('image'.$index);
                            $image = @$image['tmp_name'];

                            Shop::Get()->getShopService()->addProductImage(
                                $product,
                                $image
                            );
                        } catch (Exception $e) {

                        }
                    }

                    if ($allowStorage) {
                        try {
                            Shop::Get()->getShopService()->updateProductStorageReserve(
                                $product,
                                $this->getControlValue('storagereserve')
                            );
                        } catch (Exception $e) {

                        }
                    }

                    $filterArray = array();
                    $index = 0;
                    while (1) {
                        try {
                            $filterId = $this->getArgument('filter'.$index.'id');
                            $filterValue = $this->getControlValue('filter'.$index.'value');
                            $filterUse = $this->getControlValue('filter'.$index.'use');
                            $filterActual = $this->getControlValue('filter'.$index.'actual');
                            $filterOption = $this->getControlValue('filter'.$index.'option');
                            $filterMarkup = $this->getControlValue('filter'.$index.'markup');

                            $filterArray[] = array(
                                'filterId' => $filterId,
                                'filterValue' => $filterValue,
                                'filterUse' => $filterUse,
                                'filterActual' => $filterActual,
                                'filterOption' => $filterOption,
                                'filterMarkup' => $filterMarkup
                            );
                        } catch (Exception $eFilterEmpty) {
                            break;
                        }

                        $index++;
                    }

                    Shop::Get()->getShopService()->updateProductFilterData($product, $filterArray);

                    $product->setSeriesname(trim(strip_tags($this->getControlValue('seriesname'))));

                    $product->update();

                    SQLObject::TransactionCommit();

                    $this->setValue('message', 'ok');
                    $this->setValue('urlredirect', $product->makeURLEdit());
                } catch (ServiceUtils_Exception $addEx) {
                    SQLObject::TransactionRollback();

                    if (PackageLoader::Get()->getMode('debug')) {
                        print $addEx;
                    }

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $addEx->getErrorsArray());
                }
            }
        } catch (ServiceUtils_Exception $e) {

        }
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

}