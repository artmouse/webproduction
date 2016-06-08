<?php
class products_add extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        PackageLoader::Get()->import('CKFinder');

        $this->setValue('cropper', Engine::GetContentDriver()->getContent('imagecropper')->render());

        if ($this->getControlValue('ok')) {
            try {
                SQLObject::TransactionStart();

                $name = $this->getControlValue('name');
                if (is_array($name)) {
                    $name = implode(' / ', $name);
                }
                $this->setControlValue('name', $name);

                $product = Shop::Get()->getShopService()->addProduct(
                    $name,
                    $this->getControlValue('code')
                );

                if ($this->getControlValue('big-image-main')) {
                    $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                } else {
                    $image = '';
                }

                $downloadFile = $this->getControlValue('downloadfile');
                $downloadFile = @$downloadFile['tmp_name'];

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
                    $this->getControlValue('preorderDiscount'),
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
                    $this->getControlValue('icon'),
                    $downloadFile,
                    false, // не удалять скачиваемый файл
                    $this->getControlValue('datelifefrom'),
                    $this->getControlValue('datelifeto')
                );

                if ($this->getArgumentSecure('price_product')) {
                    $product->setPrice_product($this->getArgumentSecure('price_product'));
                    $product->update();
                }

                $product->setJewelerid($this->getArgumentSecure('jeweler'));
                $product->update();

                if ($this->getArgumentSecure('videoUrl')) {
                    $product->setVideoUrl($this->getArgumentSecure('videoUrl'));
                    $product->update();
                }

                if ($this->getControlValue('imagecropper-name') != 'noChange') {
                    $file = $this->getControlValue('imagecropper-name');
                    $x1 = $this->getControlValue('imagecropper-x1');
                    $y1 = $this->getControlValue('imagecropper-y1');
                    $x2 = $this->getControlValue('imagecropper-x2');
                    $y2 = $this->getControlValue('imagecropper-y2');

                    $width =  $x2 - $x1;
                    $height =  $y2 - $y1;

                    try {
                        $ip = new ImageProcessor(PackageLoader::Get()->getProjectPath().$file);
                        // выполняем вырезку
                        $ip->addAction(new ImageProcessor_ActionCut($x1, $y1, $width, $height));
                        if ($this->getControlValue('imagecropper-ext') == 'jpg') {
                            $ip->addAction(
                                new ImageProcessor_ActionToJPEG(PackageLoader::Get()->getProjectPath().$file)
                            );
                        } else {
                            $ip->addAction(
                                new ImageProcessor_ActionToPNG(PackageLoader::Get()->getProjectPath().$file)
                            );
                        }
                        $ip->process();
                        $imageCrop = PackageLoader::Get()->getProjectPath().$file;
                    } catch (Exception $e) {
                        $imageCrop = '';
                    }
                } else {
                    $imageCrop = '';
                }

                // Добавляем кроп-изображение.
                if ($imageCrop) {
                    Shop::Get()->getShopService()->updateProductImageCrop($product, $imageCrop);
                    unlink($imageCrop);
                }

                // Удаляем временное изображение.
                @unlink($image);

                // обновляем фильтры
                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }
                for ($j = 1; $j <= $filter_count; $j++) {
                    $filterID = $this->getControlValue('filter'.$j.'id');
                    $filterValue = $this->getControlValue('filter'.$j.'value');
                    $filterUse = $this->getControlValue('filter'.$j.'use');
                    $filterActual = $this->getControlValue('filter'.$j.'actual');
                    $filterOption = $this->getControlValue('filter'.$j.'option');

                    $product->setField('filter'.$j.'id', $filterID);
                    $product->setField('filter'.$j.'value', $filterValue);
                    $product->setField('filter'.$j.'use', $filterUse);
                    $product->setField('filter'.$j.'actual', $filterActual);
                    $product->setField('filter'.$j.'option', $filterOption);
                }

                // обновляем уровни цен
                for ($j = 1; $j <= 5; $j++) {
                    $product->setField('price'.$j, $this->getControlValue('price'.$j));
                }

                $product->setPricebase($this->getControlValue('pricebase'));
                $product->setSource($this->getControlValue('source'));
                $product->setTerm($this->getControlValue('term'));

                $product->update();

                SQLObject::TransactionCommit();

                $this->setValue('message', 'ok');
                $this->setValue('urlredirect', $product->makeURLEdit());
                $this->setValue('productURL', $product->makeURL());
            } catch (ServiceUtils_Exception $addEx) {
                SQLObject::TransactionRollback();

                if (PackageLoader::Get()->getMode('debug')) {
                    print $addEx;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $addEx->getErrorsArray());
            }
        } else {
            $this->setControlValue('syncable', true);
            $this->setControlValue('currency', Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
        }

        //вставляем новый фильтр
        if ($this->getControlValue('formsInsert')) {
            try {
                SQLObject::TransactionStart();
                $f = new ShopProductFilter();
                $f->setName($this->getArgumentSecure('add_name_filter'));
                $f->setType($this->getArgumentSecure('type_filter'));
                $f->setHidden($this->getArgumentSecure('hidden_filter'));
                $f->setSorttype($this->getArgumentSecure('sorttype'));
                $f->insert();
                SQLObject::TransactionCommit();
            } catch(ServiceUtils_Exception $e){
                SQLObject::TransactionRollback();

                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }

                $this->setValue('message', 'error');
                $this->setValue('errorsArray', $e->getErrorsArray());
            }
        }

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

        // значения фильтро по данному товару
        $a = array();
        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        for ($j = 1; $j <= $filter_count; $j++) {
            if (isset($product)) {
                $filterID = $product->getField('filter'.$j.'id');
                $filterValue = $product->getField('filter'.$j.'value');
                $filterUse = $product->getField('filter'.$j.'use');
                $filterActual = $product->getField('filter'.$j.'actual');
                $filterOption = $product->getField('filter'.$j.'option');
            } else {
                $filterID = 0;
                $filterValue = '';
                $filterUse = 0;
                $filterActual = 0;
                $filterOption = 0;
            }
            $a[$j] = array(
            'id' => $filterID,
            'value' => $filterValue,
            'use' => $filterUse,
            'actual' => $filterActual,
            'option' => $filterOption,
            );
        }
        $this->setValue('valuesArray', $a);

        // список фильтров
        $filters = Shop::Get()->getShopService()->getProductFiltersAll();
        $this->setValue('filtersArray', $filters->toArray());

        // список брендов
        $brands = Shop::Get()->getShopService()->getBrandsAll();
        $this->setValue('brandsArray', $brands->toArray());

        // список валют
        $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
        $this->setValue('currencyArray', $currency->toArray());

        // ювелиры
        $jewelers = Shop::Get()->getCurrencyService()->getObjectsAll('XJeweler');
        $this->setValue('jewelersArray', $jewelers->toArray());

        // список НДС
        $tax = Shop::Get()->getShopService()->getTaxAll();
        $this->setValue('taxArray', $tax->toArray());

        // список пользователей
        $users = Shop::Get()->getUserService()->getUsersAll($this->getUser());
        $this->setValue('usersArray', $users->toArray());

        // список значьков
        $icon = Shop::Get()->getShopService()->getProductIconAll();
        $this->setValue('iconsArray', $icon->toArray());

        if (!$this->getControlValue('ok')) {
            $this->setControlValue('divisibility', 0);
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