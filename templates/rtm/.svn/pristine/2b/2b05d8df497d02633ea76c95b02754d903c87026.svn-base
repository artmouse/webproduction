<?php
/**
 * Author: Andrii Andriiets
 * Date: 28.11.14
 * Time: 16:37
 */

class RtmShopService extends Shop_ShopService {

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
     */
    public function updateProduct(ShopProduct $product, $name, $description, 
        $categoryID, $brandID, $model, $price, $priceold, $currencyID, $unit, 
        $barcode, $discount,$preorderDiscount, $warranty, $hidden, $deleted, 
        $avail, $availText, $syncable, $url, $image, $deleteImage, $collectionID, 
        $width, $height, $length, $weight, $unitbox, $delivery, $payment, 
        $divisibility, $userID, $denycomments, $siteURL, $taxID, $descriptionshort,
        $name1, $name2, $code1c, $codesupplier, $characteristics, $share, 
        $seotitle, $seodescription, $seocontent, $seokeywords, $icon = false, 
        $downloadFile = false, $deleteDownloadFile = false, 
        $datelifefrom = false, $datelifeto = false) {

        $collectionID = $collectionID;
        try {
            SQLObject::TransactionStart();

            $event = Events::Get()->generateEvent('shopProductEditBefore');
            $event->setProduct($product);
            $event->notify();

            $name = trim($name);
            $name1 = trim($name1);
            $name2 = trim($name2);
            $price = trim($price);
            $icon = trim($icon);
            $oldprice = trim($priceold);
            $price = str_replace(',', '.', $price);
            $priceold = str_replace(',', '.', $priceold);
            $description = trim($description);
            $model = trim($model);
            $unit = trim($unit);
            $barcode = trim($barcode);
            $warranty = trim($warranty);
            $descriptionshort = trim($descriptionshort);
            $url = trim($url);
            $url = strtolower($url);
            $availText = trim($availText);
            $divisibility = str_replace(',', '.', $divisibility);
            $divisibility = (float) $divisibility;
            $code1c = trim($code1c);
            $width = trim($width);
            $height = trim($height);
            $length = trim($length);
            $weight = trim($weight);
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

            if (!empty($url)) {
                // проверка URL на валидность
                if (!preg_match("/^[a-zA-Z0-9\-\_a-zA-Z0-9]+$/", $url)) {
                    $ex->addError('url');
                }
                // проверка URL на дубликат
                // @todo
            } else {
                // если делаем ЧПУ по code1c
                if (Shop::Get()->getSettingsService()->getSettingValue('product-url-type') 
                    == 'code1c' && !empty($code1c)) {
                    $url = $this->buildURL($code1c);
                } else {
                    $url = $this->buildURL($name);
                }
            }

            // проверка на случай повторяющихся URL
            try {
                $tmpProduct = Shop::Get()->getShopService()->getProductByURL($url);
                if ($tmpProduct->getId() == $product->getId()) {
                    throw new ServiceUtils_Exception();
                }

                // если дубликат URL найден - то дописываем ID в конец
                $url .= '-p'.$product->getId();
            } catch (Exception $e) {

            }

            $category = false;
            if ($categoryID) {
                try {
                    $category = $this->getCategoryByID($categoryID);
                } catch (Exception $e) {
                    $ex->addError('category');
                }
            }

            if ($brandID) {
                try {
                    $brand = $this->getBrandByID($brandID);
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

            $taxRate = 0;
            if ($taxID) {
                $tax = Shop::Get()->getShopService()->getTaxByID($taxID);
                $taxRate = $tax->getRate();
            }

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

            // что поменялось
            $diffArray = array();
            if ($product->getName() != $name) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_name_of_the_product_with'
                ).$product->getName().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$name.'"';
            }
            $product->setName($name);

            if ($product->getName1() != $name1) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_SEO_has_changed_the_name_of_1'
                ).$product->getName1().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$name1.'"';
            }
            $product->setName1($name1);

            if ($product->getName2() != $name2) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_SEO_has_changed_the_name_of_2'
                ).$product->getName2().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$name2.'"';
            }
            $product->setName2($name2);

            if ($product->getDescription() != $description) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_description_of_the_goods_from_the'
                ).$product->getDescription().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$description.'"';
            }
            $product->setDescription($description);

            if ($product->getSeotitle() != $seotitle) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_SEO_has_changed_the_title_to_the_goods'
                ).$product->getSeotitle().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$seotitle.'"';
            }
            $product->setSeotitle($seotitle);

            if ($product->getSeodescription() != $seodescription) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_SEO_has_changed_the_description_of_the_goods_from_the'
                ).$product->getSeodescription().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$seodescription.'"';
            }
            $product->setSeodescription($seodescription);

            $seocontentbuf = strip_tags($seocontent);

            if ( $product->getSeocontent() != $seocontent) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_SEO_has_changed_the_text_of_the_goods_from_the'
                ).$product->getSeocontent().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$seocontent.'"';
            }


            if ( empty($seocontent) || !empty($seocontentbuf) ) {
                $product->setSeocontent($seocontent);
            }


            if ($product->getSeokeywords() != $seokeywords) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_SEO_keywords_goods_from'
                ).$product->getSeokeywords().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$seokeywords.'"';
            }
            $product->setSeokeywords($seokeywords);

            if ($product->getDelivery() != $delivery) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_change_the_terms_of_delivery_of_the_goods_to_the'
                ).$product->getDelivery().Shop_TranslateFormService::Get()->getTranslate('translate_on').$delivery.'"';
            }
            $product->setDelivery($delivery);

            if ($product->getCharacteristics() != $characteristics) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_characteristics_of_the_product_with'
                ).$product->getCharacteristics().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).$characteristics.'"';
            }
            $product->setCharacteristics($characteristics);

            if ($product->getPayment() != $payment) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_terms_of_payment_for_the_goods_from_the'
                ).$product->getPayment().Shop_TranslateFormService::Get()->getTranslate('translate_on').$payment.'"';
            }
            $product->setPayment($payment);

            if ($product->getPrice() != round($price, 2)) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_price_of_the_goods_to'
                ).$product->getPrice().Shop_TranslateFormService::Get()->getTranslate('translate_on').$price.'"';
            }
            $product->setPrice($price);

            if ($product->getPriceold() != round($priceold, 2)) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_price_of_the_item_with_a_strikeout'
                ).$product->getPriceold().Shop_TranslateFormService::Get()->getTranslate('translate_on').$priceold.'"';
            }
            $product->setPriceold($priceold);

            if ((int) $product->getCurrencyid() != (int) $currencyID) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_change_currency_goods_on'
                ).$currency->getName().'"';
            }
            $product->setCurrencyid($currency->getId());


            if ($unit) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_set_the_unit_of_measure_of_goods'
                ).$unit;
            } else {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_removed_the_unit_of_measure_of_goods'
                );
            }

            $product->setUnit($unit);

            if ($product->getDivisibility() != $divisibility) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_crushability_goods_from'
                ).$product->getDivisibility().
                Shop_TranslateFormService::Get()->getTranslate('translate_on').$divisibility.'"';
            }
            $product->setDivisibility($divisibility);

            if ($product->getDiscount() != $discount) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_discount_goods_with'
                ).$product->getDiscount().Shop_TranslateFormService::Get()->getTranslate('translate_on').$discount.'"';
            }
            $product->setDiscount($discount);
            $product->setPreorderDiscount($preorderDiscount);
            if ($product->getBarcode() != $barcode) {
                if ($barcode) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_set_the_bar_code'
                    ).$barcode;
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_barcode');
                }
            }
            $product->setBarcode($barcode);

            if ($product->getWarranty() != $warranty) {
                if ($warranty) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_established_a_guarantee'
                    ).$warranty;
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_guarantee');
                }
            }
            $product->setWarranty($warranty);

            if ($product->getUrl() != $url) {
                if ($url) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_set_the_URL_prefix').$url;
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_URL_prefix');
                }

                // issue #38800
                // При смене URL автоматически добавлять его в redirect
                if ($product->getUrl() && $url && !$product->getUrl() == $url) {
                    $redirect = new XShopRedirect();
                    $redirect->setUrlfrom($product->getUrl());
                    $redirect->setUrlto($url);
                    if (!$redirect->select()) {
                        $redirect->setCode(301);
                        $redirect->insert();
                    }
                }
            }
            $product->setUrl($url);

            if ((bool) $product->getHidden() != (bool) $hidden) {
                if ($hidden) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_concealed_items');
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_restored_the_product_of_the_hidden'
                    );
                }
            }
            $product->setHidden($hidden);

            if ((bool) $product->getDenycomments() != (bool) $denycomments) {
                if ($denycomments) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_it_is_forbidden_to_comment_on_goods'
                    );
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_resumed_commenting_goods');
                }
            }
            $product->setDenycomments($denycomments);

            if ((bool) $product->getDeleted() != (bool) $deleted) {
                if ($deleted) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_delete_article');
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_restored_items_from_remote'
                    );
                }
            }
            $product->setDeleted($deleted);

            $product->setSync($syncable);
            $product->setUnsyncable(!$syncable);
            $product->setAvail($avail);
            $product->setAvailtext($availText);

            if ($product->getDescriptionshort() != $descriptionshort) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_with_a_brief_explanation'
                ).$product->getDescriptionshort().
                Shop_TranslateFormService::Get()->getTranslate('translate_on').$descriptionshort.'"';
            }
            $product->setDescriptionshort($descriptionshort);

            if ((int) $product->getCategoryid() != (int) $categoryID) {
                if ($categoryID) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_established_product_category'
                    ).$categoryID.' '.$category->getName();
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_product_category');
                }
            }
            $product->setCategoryid($categoryID);

            $this->buildProductCategories($product);

            if ((int) $product->getBrandid() != (int) $brandID) {
                if ($brandID) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_established_product_brand'
                    ).$brandID.' '.$brand->getName();
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_product_brand');
                }
            }
            $product->setBrandid($brandID);

            if ($product->getModel() != $model) {
                if ($model) {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                        'translate_established_a_product_model'
                    ).$model;
                } else {
                    $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_removed_product_model');
                }
            }
            $product->setModel($model);

            if ($deleteImage) {
                $product->setImage('');

                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_remove_the_primary_product_image'
                );
            } elseif ($image) {
                // конвертация изображения в необходимый формат
                // и допустимый размер
                $image = Shop::Get()->getShopService()->convertImage($image);



                $file = RtmService::Get()->makeImagesUploadUrl($image, '', 'shop/', $product, 1);
                copy($image, MEDIA_PATH.'shop/'.$file);
                $product->setImage($file);

                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_installed_on_the_product_image'
                ).$file;
            }

            if ($deleteDownloadFile) {
                $product->setFiledownload('');

                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_removed_downloadable_file_product'
                );
            } elseif ($downloadFile) {
                $hash = md5_file($downloadFile);

                copy($downloadFile, MEDIA_PATH.'/downloadfile/'.$hash);
                $product->setFiledownload($hash);

                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_established_a_downloadable_file_product'
                ).$hash;
            }

            if ((int) $product->getTaxrate() != (int) $taxRate) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_product_with_VAT'
                ).
                $product->getTaxrate().Shop_TranslateFormService::Get()->getTranslate('translate_on').$taxRate.'"';
            }
            $product->setTaxrate($taxRate);

            if ($product->getWidth() != $width) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_change_the_width_of_the_goods_from_the'
                ).
                $product->getWidth().Shop_TranslateFormService::Get()->getTranslate('translate_on').$width.'"';
            }
            $product->setWidth($width);

            if ($product->getHeight() != $height) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_height_of_the_product_with'
                ).
                $product->getHeight().Shop_TranslateFormService::Get()->getTranslate('translate_on').$height.'"';
            }
            $product->setHeight($height);

            if ($product->getLength() !=  $length) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_length_of_the_product_with'
                ).
                $product->getLength().Shop_TranslateFormService::Get()->getTranslate('translate_on').$length.'"';
            }
            $product->setLength($length);

            if ($product->getWeight() != $weight) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_weight_of_the_goods_to_the'
                ).
                $product->getWeight().Shop_TranslateFormService::Get()->getTranslate('translate_on').$weight.'"';
            }
            $product->setWeight($weight);

            if ((int) $product->getUnitbox() != (int) $unitbox) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_number_in_the_box_with_the_product'
                ).
                $product->getUnitbox().Shop_TranslateFormService::Get()->getTranslate('translate_on').$unitbox.'"';
            }
            $product->setUnitbox($unitbox);

            if ($product->getCode1c() != $code1c) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_change_the_code_1C_with').
                $product->getCode1c().Shop_TranslateFormService::Get()->getTranslate('translate_on').$code1c.'"';
            }
            $product->setCode1c($code1c);

            if ($product->getCodesupplier() != $codesupplier) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_changed_supplier_code').
                $product->getCodesupplier().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_on'
                ).
                $codesupplier.'"';
            }
            $product->setCodesupplier($codesupplier);

            if ($product->getSiteurl() != $siteURL) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_the_reference_to_the_manufacturer_website'
                ).
                $product->getSiteurl().Shop_TranslateFormService::Get()->getTranslate('translate_on').$siteURL.'"';
            }
            $product->setSiteurl($siteURL);

            if ($product->getShare() != $share) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_changed_the_action_with').
                $product->getShare().Shop_TranslateFormService::Get()->getTranslate('translate_on').$share.'"';
            }
            $product->setShare($share);

            if ($product->getIconid() != $icon) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate(
                    'translate_changed_the_icon_for_the_item_with'
                ).
                $product->getIconid().Shop_TranslateFormService::Get()->getTranslate('translate_on').$icon.'"';
            }
            $product->setIconid($icon);
            if ($product->getIconid() != 0) {
                $product->setIconimage(Shop::Get()->getShopService()->getProductIconByID($icon)->getImage());
            }

            if ($product->getDatelifefrom() != $datelifefrom) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_changed_datelifefrom').
                $product->getDatelifefrom().Shop_TranslateFormService::Get()->getTranslate('translate_on').
                $datelifefrom.'"';
            }
            $product->setDatelifefrom($datelifefrom);

            if ($product->getDatelifeto() != $datelifeto) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_changed_datelifeto').
                $product->getDatelifeto().Shop_TranslateFormService::Get()->getTranslate('translate_on').
                $datelifeto.'"';
            }
            $product->setDatelifeto($datelifeto);

            /*if ($product->getAbouturl() != $abouturl) {
                $diffArray[] = Shop_TranslateFormService::Get()->getTranslate('translate_changed_datelifeto').
                $product->getDatelifeto().Shop_TranslateFormService::Get()->getTranslate(
                    'translate_abouturl'
                ).
                $abouturl.'"';
            }
            $product->setAbouturl($abouturl);*/

            // автор/поставщик товара
            $product->setUserid($userID);

            $product->update();

            if ($categoryID) {
                $this->updateCategoryProductCount($categoryID);
            }
            if ($brandID) {
                $this->updateBrandProductCount($brandID);
            }

            // issue #42297 - старые товары убираем из корзин
            if ($deleted && $hidden) {
                $baskets = new ShopBasket();
                $baskets->setProductid($product->getId());
                while ($b = $baskets->getNext()) {
                    $b->delete();
                }
            }

            if ($diffArray) {
                try {
                    $user = Shop::Get()->getUserService()->getUser();

                    CommentsAPI::Get()->addComment(
                        'shop-history-product-'.$product->getId(),
                        Shop_TranslateFormService::Get()->getTranslate('translate_product').
                        " #{$product->getId()} \"{$product->getName()}\"\n".implode("\n", $diffArray),
                        $user->getId()
                    );
                } catch (Exception $e) {

                }
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


    public function getOrdersAll($user = false, $includeIssues = false) {
        $orders = new ShopOrder();

        if (!$includeIssues) {
            $orders->setIssue(0);
        }

        $orders->setOrder('id', 'DESC');

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $orders;
            }

            if ($user->isAllowed('orders-all-view')) {
                return $orders;
            }

            $userID = $user->getId();

            $whereArray = array();

            $direction = array(-1);
            if ($user->isAllowed('orders-direction-in')) {
                $direction[] = 0;
            }
            if ($user->isAllowed('orders-direction-out')) {
                $direction[] = 1;
            }
            $whereArray[] ='(issue=1 OR outcoming IN ('.implode(',', $direction).'))';

            // фильтр по менеджеру заказа
            if ($user->isDenied('orders-manager-all-view')) {
                $managers = Shop::Get()->getUserService()->getUsersManagers();
                $managerIDArray = array($userID); // свои заказы видно всегда
                while ($m = $managers->getNext()) {
                    if ($user->isAllowed('orders-manager-'.$m->getId().'-view')) {
                        $managerIDArray[] = $m->getId();
                    }
                }
                $whereArray[] = "(userid IN (".implode(',', $managerIDArray).") OR managerid IN (".
                implode(',', $managerIDArray).") OR authorid IN (".implode(',', $managerIDArray).
                ") OR EXISTS(SELECT * FROM shoporderemployer WHERE orderid=shoporder.id AND managerid IN (".
                implode(',', $managerIDArray).")))";
            }

            // фильтр по статусу
            if ($user->isDenied('orders-status-all-view')) {
                $status = Shop::Get()->getShopService()->getStatusAll();
                $statusIDs = array(-1);
                while ($s = $status->getNext()) {
                    if ($user->isAllowed('orders-status-'.$s->getId().'-view')) {
                        $statusIDs[] = $s->getId();
                    }
                }
                $whereArray[] = '(`statusid` IN ('.implode(', ', $statusIDs).'))';
            }

            // фильтр по проекту
            /*if ($user->isDenied('orders-project-all')) {
                $project = IssueService::Get()->getProjectsAll();
                $projectIDArray = array(-1);
                while ($x = $project->getNext()) {
                    if ($user->isAllowed('orders-project-'.$x->getId())) {
                        $projectIDArray[] = $x->getId();
                    }
                }
                $whereArray[] = '(`projectid` IN ('.implode(', ', $projectIDArray).'))';
            }*/

            // фильтр по категории (бизнес-процессу)
            if ($user->isDenied('orders-category-all-view')) {
                $categoryIDArray = array(-1);
                if ($user->isAllowed('orders-category-0-view')) {
                    $categoryIDArray[] = 0;
                }
                $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
                while ($c = $categories->getNext()) {
                    if ($user->isAllowed('orders-category-'.$c->getId().'-view')) {
                        $categoryIDArray[] = $c->getId();
                    }
                }
                $whereArray[] = '(`categoryid` IN ('.implode(', ', $categoryIDArray).'))';
            }

            if ($whereArray) {
                $orders->addWhereQuery(
                    "(userid={$user->getId()} OR authorid={$user->getId()} OR managerid={$user->getId()} OR (".
                    implode(' AND ', $whereArray)."))"
                );
            }
        }

        return $orders;
    }

    /**
     * Сменить статус заказу.
     * Последний параметр говорит "проверять ACL или нет"
     *
     * @param User $user
     * @param ShopOrder $order
     * @param int $statusID
     */
    public function updateOrderStatus(User $user, ShopOrder $order, $statusID) {
        PackageLoader::Get()->import('CommentsAPI');

        try {
            SQLObject::TransactionStart();

            $status = $this->getStatusByID($statusID);

            if ($statusID != $order->getStatusid()) {
                $order->setStatusid($status->getId());

                // записываем статус в историю
                $change = new XShopOrderChange();
                $change->setCdate(date('Y-m-d H:i:s'));
                $change->setOrderid($order->getId());
                $change->setKey('statusid');
                $change->setValue($statusID);
                $change->insert();

                if ($status->getShipped()) {
                    $order->setDateshipped(date('Y-m-d H:i:s'));
                } else {
                    $order->setDateshipped('0000-00-00 00:00:00');
                }

                if ($status->getClosed()) {
                    $order->setDateclosed(date('Y-m-d H:i:s'));
                } else {
                    $order->setDateclosed('0000-00-00 00:00:00');
                }

                $order->update();

                $updated = true;

                // отправляем почтовое уведомление
                $this->_orderSendmail($order);

                // отправляем SMS клиенту и админу
                $this->_orderSMS($order);

                // в историю заказа
                $comment = 'Статус обновлен на: '.$status->getName()."\n";

                // создаем подзадачи
                for ($j = 1; $j <= 10; $j++) {
                    try {
                        $subWorkflowID = $status->getField('subworkflow'.$j);
                        $subWorkflow = Shop::Get()->getShopService()->getOrderCategoryByID($subWorkflowID);

                        $subIssue = new ShopOrder();
                        $subIssue->setParentid($order->getId());
                        $subIssue->setCategoryid($subWorkflow->getId());
                        if ($subIssue->select()) {
                            // задача найдена - обновляем ее на старт
                            $this->updateOrderStatus($user, $subIssue, $subWorkflow->getStatusDefault());

                            $comment .= "Подзадача #{$subIssue->getId()} переведена в состояние";
                            $comment .= "{$subIssue->getStatus()->getName()}\n";
                        } else {
                            // определяем кто ответственный за этап
                            // по умолчанию - никто
                            $subWorkflowManagerID = false;

                            // может кто-то из сотрудников?
                            $employer = new XShopOrderEmployer();
                            $employer->setOrderid($order->getId());
                            $employer->setStatusid($status->getId());
                            if ($employer->select()) {
                                $subWorkflowManagerID = $employer->getManagerid();
                            }

                            // может задан по умолчанию?
                            if (!$subWorkflowManagerID) {
                                $subWorkflowManagerID = $subWorkflow->getManagerid();
                            }

                            // тогда менеджер заказа
                            if (!$subWorkflowManagerID) {
                                $subWorkflowManagerID = $order->getManagerid();
                            }

                            // проект новой задачи
                            $subWorkflowProjectID = $subWorkflow->getProjectid();
                            if (!$subWorkflowProjectID) {
                                $subWorkflowProjectID = $order->getProjectid();
                            }

                            // имя новой задачи
                            $name = $subWorkflow->getIssuename();
                            if (!$name) {
                                $name = $subWorkflow->getName();
                            }
                            $name = str_replace('[IssueName]', $order->getName(), $name);

                            // задача не найдена, создаем ее
                            /*$subIssue = IssueService::Get()->addIssue(
                                $user,
                                $name,
                                '', // content
                                $subWorkflowProjectID,
                                $subWorkflowManagerID,
                                $subWorkflow->getId(),
                                DateTime_Object::Now()->addDay(+$subWorkflow->getTerm())->__toString(), // dateto
                                $order->getUserid(),
                                $order->getId()
                            );

                            $comment .= "Создана подзадача #{$subIssue->getId()} для 
                             ".$subIssue->getManager()->makeName(false, 'lfm')."\n";
                            */
                        }
                    } catch (Exception $subEx) {

                    }
                }

                for ($j = 1; $j <= 10; $j++) {
                    try {
                        $checklist = $status->getField('checklist'.$j);
                        $checklist = trim($checklist);

                        if (!$checklist) {
                            continue;
                        }

                        $cl = new XShopOrderChecklist();
                        $cl->setOrderid($order->getId());
                        $cl->setStatusid($status->getId());
                        $cl->setName($checklist);
                        if (!$cl->select()) {
                            $cl->setCdate(date('Y-m-d H:i:s'));
                            $cl->insert();
                        }
                    } catch (Exception $checkEx) {

                    }
                }

                try {
                    // записываем комментарий
                    $this->addOrderComment(
                        $order,
                        $user,
                        $comment
                    );
                } catch (Exception $userEx) {

                }
            }

            SQLObject::TransactionCommit();

            if (!empty($updated)) {
                // выгрузка в XML
                $this->_orderXML($order);
                $this->_orderCSV($order);
            }

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

} 