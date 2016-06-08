<?php
class products_edit extends Engine_Class {

    public function process() {
        header("X-XSS-Protection: 0"); // for chrome
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
                Shop::Get()->getTranslateService()->getTranslateSecure(
                    'translate_redaktirovanie_tovara_'
                ) . $product->getId() . " " . htmlspecialchars($product->getName())
            );
            if ($product->getAdvertise()) {
                $this->setValue('control_advertise', $product->getAdvertise());
            }

            if ($product->getSale() == 1) {
                $this->setValue('control_sale', $product->getSale());
            }

            if ($product->getDelivery_price()) {
                $this->setValue('control_dp', $product->getDelivery_price());
            }


            if (!($user->isAllowed('products-edit') || ($isOwner && $user->isAllowed('products-owner-edit')))) {
                $this->setValue('canEdit', false);
                throw new ServiceUtils_Exception();
            }

            $this->setValue('canEdit', true);
            $this->setControlValue('url', $product->getUrl());
            if ($this->getControlValue('ok')) {
                try {
                    SQLObject::TransactionStart();

                    if ($this->getArgumentSecure('imageSave') && $this->getControlValue('big-image-main')) {
                        $image = PackageLoader::Get()->getProjectPath().$this->getControlValue('big-image-main');
                    } else {
                        $image = '';
                    }
                    if ($this->getControlValue('icon')) {
                        if ($this->getControlValue('icon') != 0) {
                            $iconid = Shop::Get()->getShopService()->getProductIconByID(
                                $this->getControlValue('icon')
                            )->getId();
                        }
                    } else {
                        $iconid = false;
                    }

                    $downloadFile = $this->getControlValue('downloadfile');
                    $downloadFile = @$downloadFile['tmp_name'];

                    $this->_updateProduct(
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
                        $this->getControlValue('advertise'),
                        $this->getControlValue('delivery_price'),
                        $this->getControlValue('share'),
                        $this->getControlValue('seotitle'),
                        $this->getControlValue('seodescription'),
                        $this->getControlValue('seocontent'),
                        $this->getControlValue('seokeywords'),
                        $this->getControlValue('icon'),
                        $downloadFile,
                        false, // не удалять скачиваемый файл
                        $this->getControlValue('datelifefrom'),
                        $this->getControlValue('datelifeto'),
                        $this->getControlValue('articul'),
                        $this->getControlValue('suppliered'),
                        $this->getControlValue('sale')
                    );

                    $imageCrop = '';
                    if ($this->getControlValue('imagecropper-name') != 'noChange') {
                        $file = $this->getControlValue('imagecropper-name');

                        $data = array();

                        $data['x'] = $this->getControlValue('imagecropper-x1');
                        $data['y'] = $this->getControlValue('imagecropper-y1');
                        $data['width'] = $this->getControlValue('imagecropper-x2');
                        $data['height'] = $this->getControlValue('imagecropper-y2');
                        $data['rotate'] = 0;

                        $src = PackageLoader::Get()->getProjectPath() . $file;
                        $type = pathinfo($file, PATHINFO_EXTENSION);

                        $imageCrop = PackageLoader::Get()->getProjectPath() . 'media/tmp/' . date('YmdHis') . '.png';
                        copy($src, $imageCrop);

                        try {
                            $this->_crop($src, $imageCrop, $data, $type);

                            // Добавляем кроп-изображение.
                            Shop::Get()->getShopService()->updateProductImageCrop($product, $imageCrop);
                        } catch (Exception $e) {

                        }
                        // удалить временные изображения
                        unlink($imageCrop);
                        unlink($src);
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
                    $product->setSeriesname($this->getControlValue('seriesname'));
                    $product->setImagegrouped($this->getControlValue('imageGrouped'));

                    // кастомные поля
                    $arguments = $this->getArguments();
                    foreach ($arguments as $argkey => $argument) {
                        if (strpos($argkey, 'custom_') === 0) {
                            $field = str_replace('custom_', '', $argkey);
                            if (!in_array($field, $product->getFields())) {
                                continue;
                            }

                            $product->setField($field, $argument);
                        }
                    }

                    $product->update();

                    $this->setValue('message', 'ok');

                    SQLObject::TransactionCommit();
                } catch (ServiceUtils_Exception $e) {
                    SQLObject::TransactionRollback();  //echo'<pre>'; print_r($e);echo'<pre>'; exit;

                    $this->setValue('message', 'error');
                    $this->setValue('errorsArray', $e->getErrorsArray());
                }
            }

            $this->setControlValue('name', $product->getName());
            $this->setControlValue('description', $product->getDescription());
            $this->setControlValue('price', $product->getPrice());
            $this->setControlValue('currency', $product->getCurrencyid());
            $this->setControlValue('category', $product->getCategoryid());
            $this->setControlValue('brand', $product->getBrandid());
            $this->setControlValue('model', $product->getModel());
            $this->setControlValue('imageGrouped', $product->getImagegrouped());
            $this->setControlValue('articul', $product->getArticul());
            $this->setControlValue('seriesname', $product->getSeriesname());
            $this->setControlValue('discount', $product->getDiscount());
            $this->setControlValue('preorderDiscount', $product->getPreorderDiscount());
            $this->setControlValue('hidden', $product->getHidden());
            $this->setControlValue('deleted', $product->getDeleted());
            $this->setControlValue('unit', $product->getUnit());
            $this->setControlValue('barcode', $product->getBarcode());
            $this->setControlValue('warranty', $product->getWarranty());
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
            $this->setControlValue('suppliered', $product->getSuppliered());
            $this->setControlValue('availtext', $product->getAvailtext());
            $this->setControlValue('userid', $product->getUserid());
            $this->setControlValue('siteurl', $product->getSiteurl());
            $this->setControlValue('denycomments', $product->getDenycomments());
            $this->setControlValue('notdiscount', $product->getNotdiscount());
            $this->setControlValue('maxdiscount', $product->getMaxdiscount());
            $this->setControlValue('tax', $product->getTax());
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
            $this->setControlValue('icon', $product->getIconid());
            $this->setControlValue('datelifefrom', $product->getDatelifefrom());
            $this->setControlValue('datelifeto', $product->getDatelifeto());
            $this->setControlValue('source', $product->getSource());
            $this->setControlValue('term', $product->getTerm());
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
            if ($product->getImagecrop()) {
                $this->setValue('imagemainsrc', $product->getImagecrop());
            } elseif ($product->getImage()) {
                $this->setValue('imagemainsrc', $product->getImage());
            }
            $this->setValue('imagemain', $product->makeImageThumb(200));
            $this->setValue('imagemainBig', $product->makeImageThumb(1600));

            // дополнительные изображения
            $images = $product->getImages();
            $a = array();
            while ($x = $images->getNext()) {
                try {
                    $a[] = array(
                        'id' => $x->getId(),
                        'image' => $x->makeImageThumb(200),
                        'imageBig' => $x->makeImageThumb(1600),
                    );
                } catch (Exception $e) {

                }
            }
            $this->setValue('imagesArray', $a);

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
            $this->setValue('brandsArray', $brands->toArray());

            // список валют
            $currency = Shop::Get()->getCurrencyService()->getCurrencyAll();
            $this->setValue('currencyArray', $currency->toArray());

            // список значьков
            $icon = Shop::Get()->getShopService()->getProductIconAll();
            $this->setValue('iconsArray', $icon->toArray());

            // кастомные поля
            $productCustomFieldArray = Shop_ModuleLoader::Get()->getProductCustomFieldArray();
            foreach ($productCustomFieldArray as $key => $field) {
                // есть ли такое поле у продукта?
                if (!in_array($field['field'], $product->getFields())) {
                    unset($productCustomFieldArray[$key]);
                    continue;
                }

                $productCustomFieldArray[$key]['value'] = $product->getField($field['field']);
            }
            $this->setValue('customFieldArray', $productCustomFieldArray);

        } catch (ServiceUtils_Exception $ge) {
            if ($ge->getMessage() == 'Shop-object by id not found') {
                $this->setValue('message', 'product_not_fount');
            }
            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
        }
    }

    private function _crop($src, $dst, $data, $type) {
        $ex = new ServiceUtils_Exception();
        $ex->addError('crop-error');
        if (!empty($src) && !empty($dst) && !empty($data)) {

            switch ($type) {
                case 'gif':
                    $src_img = imagecreatefromgif($src);
                    break;

                case 'jpg':
                    $src_img = imagecreatefromjpeg($src);
                    break;

                case 'png':
                    $src_img = imagecreatefrompng($src);
                    break;
            }

            if (!$src_img) {
                throw $ex;
            }

            $size = getimagesize($src);
            $size_w = $size[0]; // natural width
            $size_h = $size[1]; // natural height

            $src_img_w = $size_w;
            $src_img_h = $size_h;

            $degrees = $data['rotate'];

            // Rotate the source image
            if (is_numeric($degrees) && $degrees != 0) {
                // PHP's degrees is opposite to CSS's degrees
                $new_img = imagerotate($src_img, -$degrees, imagecolorallocatealpha($src_img, 0, 0, 0, 127));

                imagedestroy($src_img);
                $src_img = $new_img;

                $deg = abs($degrees) % 180;
                $arc = ($deg > 90 ? (180 - $deg) : $deg) * M_PI / 180;

                $src_img_w = $size_w * cos($arc) + $size_h * sin($arc);
                $src_img_h = $size_w * sin($arc) + $size_h * cos($arc);

                // Fix rotated image miss 1px issue when degrees < 0
                $src_img_w -= 1;
                $src_img_h -= 1;
            }

            $tmp_img_w = $data['width'];
            $tmp_img_h = $data['height'];
            $dst_img_w = $data['width'];
            $dst_img_h = $data['height'];

            $src_x = $data['x'];
            $src_y = $data['y'];

            if ($src_x <= -$tmp_img_w || $src_x > $src_img_w) {
                $src_x = $src_w = $dst_x = $dst_w = 0;
            } else if ($src_x <= 0) {
                $dst_x = -$src_x;
                $src_x = 0;
                $src_w = $dst_w = min($src_img_w, $tmp_img_w + $src_x);
            } else if ($src_x <= $src_img_w) {
                $dst_x = 0;
                $src_w = $dst_w = min($tmp_img_w, $src_img_w - $src_x);
            }

            if ($src_w <= 0 || $src_y <= -$tmp_img_h || $src_y > $src_img_h) {
                $src_y = $src_h = $dst_y = $dst_h = 0;
            } else if ($src_y <= 0) {
                $dst_y = -$src_y;
                $src_y = 0;
                $src_h = $dst_h = min($src_img_h, $tmp_img_h + $src_y);
            } else if ($src_y <= $src_img_h) {
                $dst_y = 0;
                $src_h = $dst_h = min($tmp_img_h, $src_img_h - $src_y);
            }

            // Scale to destination position and size
            $ratio = $tmp_img_w / $dst_img_w;
            $dst_x /= $ratio;
            $dst_y /= $ratio;
            $dst_w /= $ratio;
            $dst_h /= $ratio;

            $dst_img = imagecreatetruecolor($dst_img_w, $dst_img_h);

            // Add transparent background to destination image
            imagefill($dst_img, 0, 0, imagecolorallocatealpha($dst_img, 0, 0, 0, 127));
            imagesavealpha($dst_img, true);

            $result = imagecopyresampled(
                $dst_img, $src_img, $dst_x, $dst_y, $src_x, $src_y, $dst_w, $dst_h, $src_w, $src_h
            );

            if ($result) {
                if (!imagepng($dst_img, $dst)) {
                    throw $ex;
                }
            } else {
                throw $ex;
            }

            imagedestroy($src_img);
            imagedestroy($dst_img);
        }
    }

    /**
     * Обновисть товар
     *
     * @param ShopProduct $product
     * @param $name
     * @param $description
     * @param $categoryID
     * @param $brandID
     * @param $model
     * @param $price
     * @param $priceold
     * @param $currencyID
     * @param $unit
     * @param $barcode
     * @param $discount
     * @param $warranty
     * @param $hidden
     * @param $deleted
     * @param $avail
     * @param $availText
     * @param $syncable
     * @param $url
     * @param $image
     * @param $deleteImage
     * @param $collectionID
     * @param $width
     * @param $height
     * @param $length
     * @param $weight
     * @param $unitbox
     * @param $delivery
     * @param $payment
     * @param $divisibility
     * @param $userID
     * @param $denycomments
     * @param $siteURL
     * @param $taxID
     * @param $descriptionshort
     * @param $name1
     * @param $name2
     * @param $code1c
     * @param $codesupplier
     * @param $characteristics
     * @param $share
     * @param $seotitle
     * @param $seodescription
     * @param $seocontent
     * @param $seokeywords
     * @param bool $icon
     * @param bool $downloadFile
     * @param bool $deleteDownloadFile
     *
     * @throws Exception
     */
    private function _updateProduct(ShopProduct $product,
                                    $name,
                                    $description,
                                    $categoryID,
                                    $brandID,
                                    $model,
                                    $price,
                                    $priceold,
                                    $currencyID,
                                    $unit,
                                    $barcode,
                                    $discount,
                                    $preorderDiscount,
                                    $warranty,
                                    $hidden,
                                    $deleted,
                                    $avail,
                                    $availText,
                                    $syncable,
                                    $url,
                                    $image,
                                    $deleteImage,
                                    $collectionID,
                                    $width,
                                    $height,
                                    $length,
                                    $weight,
                                    $unitbox,
                                    $delivery,
                                    $payment,
                                    $divisibility,
                                    $userID,
                                    $denycomments,
                                    $notdiscount, $maxdiscount, $siteURL,
                                    $tax, $descriptionshort, $name1, $name2, $code1c,
                                    $codesupplier, $characteristics, $advertise, $delivery_price,
                                    $share, $seotitle, $seodescription, $seocontent,
                                    $seokeywords, $icon = false, $downloadFile = false, $deleteDownloadFile = false,
                                    $datelifefrom = false, $datelifeto = false, $articul = false,
                                    $suppliered = false, $sale = false) {
        try {
            SQLObject::TransactionStart();

            $event = Events::Get()->generateEvent('shopProductEditBefore');
            $event->setProduct($product);
            $event->notify();

            // @todo - remove $collectionID
            $collectionID = (int) $collectionID;

            $name = trim($name);
            $name1 = trim($name1);
            $name2 = trim($name2);
            $price = trim($price);
            $icon = trim($icon);
            $oldprice = trim($priceold);
            $price = str_replace(',', '.', $price);
            $priceold = str_replace(',', '.', $priceold);
            $delivery_price = str_replace(',', '.', $delivery_price);
            $description = trim($description);
            $url = trim($url);
            $url = strtolower($url);
            $model = trim($model);
            $articul = trim($articul);
            $unit = trim($unit);
            $barcode = trim($barcode);
            $warranty = trim($warranty);
            $descriptionshort = trim($descriptionshort);
            $availText = trim($availText);
            $divisibility = str_replace(',', '.', $divisibility);
            $divisibility = (float) $divisibility;
            $code1c = trim($code1c);
            $width = trim($width);
            $height = trim($height);
            $length = trim($length);
            $weight = trim($weight);
            $maxdiscount = trim($maxdiscount);
            $seocontent = trim($seocontent);

            if ($datelifefrom) {
                $datelifefrom = DateTime_Corrector::CorrectDate($datelifefrom);
                if ($datelifefrom == '1970-01-01') {
                    $datelifefrom = '0000-00-00';
                }
            }

            if ($datelifeto) {
                $datelifeto = DateTime_Corrector::CorrectDate($datelifeto);
                if ($datelifeto == '1970-01-01') {
                    $datelifeto = '0000-00-00';
                }
            }


            // только если старая цена больше новой
            // приведение к типу для сравнения
            $priceold_float = (float) $priceold;
            $price_float = (float) $price;
            if ($priceold_float < $price_float) {
                $priceold = 0;
            }

            $ex = new ServiceUtils_Exception();
            if (!$name) {
                $ex->addError('name');
            }

            // проверка имени на уникальность
            if (!Shop::Get()->getSettingsService()->getSettingValue('product-name-doublicates')) {
                $tmp = new XShopProduct();
                $tmp->setName($name);
                $tmp->addWhere('id', $product->getId(), '!=');
                if ($tmp->getNext()) {
                    throw new ServiceUtils_Exception('name-doublicate');
                }
            }


            //url
            $url = preg_replace('/([\-]{2,})/ius', '-', $url);
            if ($product->getUrl() && !Checker::CheckURL($url)) {
                $ex->addError('url');
            }
            if (!$url) {
                $nameurl = $name;
                //если есть артикул у продукта - добавить его при формировании URL
                if ($articul) {
                    $nameurl .=' '.$articul;
                }
                $url = Shop::Get()->getShopService()->buildURL(trim($nameurl));
            }


            $category = false;
            if ($categoryID) {
                try {
                    $category = Shop_ShopService::Get()->getCategoryByID($categoryID);
                } catch (Exception $e) {
                    $ex->addError('category');
                }
            }

            if ($brandID) {
                try {
                    $brand = Shop_ShopService::Get()->getBrandByID($brandID);
                } catch (Exception $e) {
                    $ex->addError('brand');
                }
            }


            if ($image) {
                if (!Checker::CheckImageFormat($image)) {
                    $ex->addError('image');
                }
            }

            $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);

            if ($userID) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                } catch (Exception $userEx) {
                    $ex->addError('user');
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }
            $product->setSale($sale);
            $product->setName($name);
            $product->setName1($name1); // depr?
            $product->setName2($name2); // @todo
            $product->setDescription($description);
            $product->setSeotitle($seotitle);
            $product->setSeodescription($seodescription);

            $seocontentbuf = strip_tags($seocontent);
            if (empty($seocontent) || !empty($seocontentbuf)) {
                $product->setSeocontent($seocontent);
            }
            $product->setSeokeywords($seokeywords);
            $product->setDelivery($delivery);
            $product->setCharacteristics($characteristics);
            $product->setAdvertise($advertise);
            $product->setDelivery_price($delivery_price);
            $product->setPayment($payment);
            $product->setPrice($price);
            $product->setPriceold($priceold);
            $product->setCurrencyid($currency->getId());
            $product->setUnit($unit);
            $product->setDivisibility($divisibility);
            $product->setDiscount($discount);
            $product->setPreorderDiscount($preorderDiscount);
            $product->setBarcode($barcode);
            $product->setWarranty($warranty);

            if ($product->getUrl() != $url) {
                if (!Shop::Get()->getShopService()->checkURLUnique($url)) {
                    $url .= '-'.$product->getId();
                }

                // При смене URL автоматически добавлять его в redirect
                if ($product->getUrl() && $url && ($product->getUrl() !== $url)) {
                    $redirect = new XShopRedirect();
                    $redirect->setUrlfrom('/'.$product->getUrl());
                    if (!$redirect->select()) {
                        $redirect->setUrlto('/'.$url);
                        $redirect->setCode(301);
                        $redirect->insert();
                    }
                }
            }
            if ($url) {
                $product->setUrl($url);
            }

            $product->setHidden($hidden);
            $product->setDenycomments($denycomments);
            $product->setNotdiscount($notdiscount);
            $product->setMaxdiscount($maxdiscount);
            $product->setDeleted($deleted);

            $product->setSync($syncable);
            $product->setUnsyncable(!$syncable);
            $product->setAvail($avail);
            $product->setSuppliered($suppliered);
            $product->setAvailtext($availText);
            $product->setDescriptionshort($descriptionshort);

            // @todo - updateProductCategory
            $product->setCategoryid($categoryID);
            Shop_ShopService::Get()->buildProductCategories($product);

            if ($deleteImage) {
                Shop_ShopService::Get()->deleteProductImage($product);
            } elseif ($image) {
                Shop_ShopService::Get()->updateProductImage($product, $image);
            }

            if ($deleteDownloadFile) {
                $product->setFiledownload('');
            } elseif ($downloadFile) {
                $hash = md5_file($downloadFile);

                copy($downloadFile, MEDIA_PATH.'/downloadfile/'.$hash);
                $product->setFiledownload($hash);
            }

            $product->setBrandid($brandID);
            $product->setModel($model);
            $product->setArticul($articul);
            $product->setTax($tax);
            $product->setWidth($width);
            $product->setHeight($height);
            $product->setLength($length);
            $product->setWeight($weight);
            $product->setUnitbox($unitbox);
            $product->setCode1c($code1c);
            $product->setCodesupplier($codesupplier);
            $product->setSiteurl($siteURL);
            $product->setShare($share);
            $product->setIconid($icon);
            $product->setDatelifefrom($datelifefrom);
            $product->setDatelifeto($datelifeto);

            // автор/поставщик товара
            $product->setUserid($userID);

            $product->update();

            if ($categoryID) {
                Shop_ShopService::Get()->updateCategoryProductCount($categoryID);
            }
            if ($brandID) {
                Shop_ShopService::Get()->updateBrandProductCount($brandID);
            }

            // issue #42297 - старые товары убираем из корзин
            if ($deleted && $hidden) {
                $baskets = Shop_ShopService::Get()->getBasketAll();
                $baskets->setProductid($product->getId());
                $baskets->delete(true);
            }

            $event = Events::Get()->generateEvent('shopProductEditAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


}