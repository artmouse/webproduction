<?php
class products_edit extends Engine_Class {

    public function process() {
        ini_set('max_input_vars', 10000);

        PackageLoader::Get()->registerJSFile('/_js/jquery.cookie.js');
        PackageLoader::Get()->import('CKFinder');

        $menu = Engine::GetContentDriver()->getContent('shop-admin-products-menu');
        $menu->setValue('selected', 'edit');
        $this->setValue('menu', $menu->render());

        $this->setValue('cropper', Engine::GetContentDriver()->getContent('imagecropper')->render());

        try {
            $product = Shop::Get()->getShopService()->getProductByID(
                $this->getArgument('id')
            );

            $user = $this->getUser();
            $isOwner = ($user->getId() == $product->getUserid());

            $this->setValue('productid', $product->getId());
            Engine::GetHTMLHead()->setTitle(
                'Редактирование товара - #' . $product->getId() . " " . htmlspecialchars($product->getName())
            );

            if (!($user->isAllowed('products-edit') || ($isOwner && $user->isAllowed('products-owner-edit')))) {
                $this->setValue('canEdit', false);
                throw new ServiceUtils_Exception();
            }

            $this->setValue('canEdit', true);

            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    if ($this->getControlValue('big-image-main')) {
                        $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                    } else {
                        $image = '';
                    }

                    if ($this->getArgumentSecure('deleteimagemain')) {
                        @unlink(@PackageLoader::Get()->getProjectPath().'/media/shop/'.$product->getImage());
                        @unlink(@PackageLoader::Get()->getProjectPath().'/media/shop/'.$product->getImagecrop());
                        $product->setImagecrop('');
                        $product->update();
                    }

                    $downloadFile = $this->getControlValue('downloadfile');
                    $downloadFile = @$downloadFile['tmp_name'];

                    Shop::Get()->getShopService()->updateProduct(
                        $product,
                        str_replace($product->getInventarnumber(), '', $this->getControlValue('name')),
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
                        $this->getControlValue('deleteimagemain'),
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
                        $this->getControlValue('deleteDownloadfile'),
                        $this->getControlValue('datelifefrom'),
                        $this->getControlValue('datelifeto')    
                    );

                    if ($this->getArgumentSecure('videoUrl')) {
                        $product->setVideoUrl($this->getArgumentSecure('videoUrl'));
                        $product->update();
                    }

                    if ($this->getArgumentSecure('price_product')) {
                        $product->setPrice_product($this->getArgumentSecure('price_product'));
                        $product->update();
                    }

                    $product->setJewelerid($this->getArgumentSecure('jeweler'));
                    $product->update();

                    $product->setPrice($this->getArgumentSecure('price'));
                    $product->update();

                    if ($this->getControlValue('imagecropper-name') != 'noChange') {
                        $file = $this->getControlValue('imagecropper-name');
                        $koef = $this->getControlValue('imagecropper-koef');
                        $x1 = $this->getControlValue('imagecropper-x1')*$koef;
                        $y1 = $this->getControlValue('imagecropper-y1')*$koef;
                        $x2 = $this->getControlValue('imagecropper-x2')*$koef;
                        $y2 = $this->getControlValue('imagecropper-y2')*$koef;

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

                    // удаляем картинки
                    $deleteArray = $this->getArgumentSecure('deleteimage');
                    if ($deleteArray) {
                        foreach ($deleteArray as $imageID) {
                            try {
                                $image = Shop::Get()->getShopService()->getProductImageByID(
                                    $imageID
                                );

                                @unlink(@PackageLoader::Get()->getProjectPath().'/media/shop/'.$image->getFile());

                                Shop::Get()->getShopService()->deleteProductImage(
                                    $product,
                                    $image
                                );
                            } catch (Exception $e) {

                            }
                        }
                    }


                    // обновляем уровни цен
                    for ($j = 1; $j <= 5; $j++) {
                        $product->setField('price'.$j, $this->getControlValue('price'.$j));
                    }

                    $product->setPricebase($this->getControlValue('pricebase'));
                    $product->setSource($this->getControlValue('source'));
                    $product->setTerm($this->getControlValue('term'));

                    $product->update();

                    $this->setValue('message', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $this->setControlValue('name', $product->getName());
            $this->setControlValue('videoUrl', $product->getVideoUrl());
            $this->setControlValue('description', $product->getDescription());
            $this->setControlValue('price', $product->getPrice());
            $this->setControlValue('price_product', $product->getPrice_product());

            $this->setControlValue('currency', $product->getCurrencyid());
            $this->setControlValue('category', $product->getCategoryid());
            $this->setControlValue('brand', $product->getBrandid());
            $this->setControlValue('model', $product->getModel());
            $this->setControlValue('discount', $product->getDiscount());
            $this->setControlValue('preorderDiscount', $product->getPreorderDiscount());
            $this->setControlValue('hidden', $product->getHidden());
            $this->setControlValue('deleted', $product->getDeleted());
            $this->setControlValue('unit', $product->getUnit());
            $this->setControlValue('url', $product->getUrl());
            $this->setControlValue('barcode', $product->getBarcode());
            $this->setControlValue('warranty', $product->getWarranty());
            //$this->setControlValue('collection', $product->getCollectionid());
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
            $this->setControlValue('tax', $product->getTaxid());
            $this->setControlValue('descriptionshort', $product->getDescriptionshort());
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
            //$this->setControlValue('icon', $product->getIconimage());
            $this->setControlValue('datelifefrom', $product->getDatelifefrom());
            $this->setControlValue('datelifeto', $product->getDatelifeto());
            
            $this->setControlValue('source', $product->getSource());
            $this->setControlValue('term', $product->getTerm());
            $this->setControlValue('jeweler', $product->getJewelerid());
            $this->setControlValue('pricebase', $product->getPricebase());
            for ($j =1; $j <= 5; $j++) {
                $this->setControlValue('price'.$j, $product->getField('price'.$j));
            }
            $this->setValue('productURL', $product->makeURL());

            try {
                $downloadfileURL = Shop::Get()->getShopService()->makeProductDownloadURL(
                    $product
                );

                $this->setValue('downloadfileURL', $downloadfileURL);
            } catch (Exception $e) {

            }

            $this->setValue('imagemainsrc', $product->getImage());
            $this->setValue('imagemain', $product->makeImageThumb(200));

            // дополнительные изображения
            $images = $product->getImages();
            $a = array();
            while ($x = $images->getNext()) {
                try {
                    $a[] = array(
                    'id' => $x->getId(),
                    'image' => $x->makeImageThumb(200),
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

            // значения по данному товару
            $a = array();
            try {
                $filter_count = Engine::Get()->getConfigField('filter_count');
            } catch (Exception $e) {
                $filter_count = 10;
            }
            for ($j = 1; $j <= $filter_count; $j++) {
                $filterID = $product->getField('filter'.$j.'id');
                $filterValue = $product->getField('filter'.$j.'value');
                $filterUse = $product->getField('filter'.$j.'use');
                $filterActual = $product->getField('filter'.$j.'actual');
                $filterOption = $product->getField('filter'.$j.'option');

                $a[$j] = array(
                'id' => $filterID,
                'value' => htmlspecialchars($filterValue),
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


        } catch (ServiceUtils_Exception $ge) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
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