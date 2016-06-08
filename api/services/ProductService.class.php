<?php
/**
 * ProductService куча методов связанных с продуктами, брендами, категориями
 *
 * @author    Kyryll Maesh <k.maesh@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class ProductService extends ServiceUtils_AbstractService{


    /**
     * Найти товар по артикулу
     *
     * @param ShopSupplier $supplier
     * @param string $code
     *
     * @return ShopProduct
     */
    public function getProductByArticul($articul) {
        $articul = trim($articul);
        if (!$articul) {
            throw new ServiceUtils_Exception();
        }

        $product = new ShopProduct();
        $product->setArticul($articul);
        if ($product->select()) {
            return $product;
        }

        throw new ServiceUtils_Exception();
    }


    /**
     * Найти товар по URL-префиксу
     *
     * @param string $url
     *
     * @return ShopProduct
     */
    public function getProductByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopProduct', false);
    }


    /**
     * Получить бренд по имени
     *
     * @param string $name
     *
     * @return ShopBrand
     */
    public function getBrandByName($name) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('name', $name, 'ShopBrand', false);
    }


    /**
     * Найти бренд по URL-префиксу
     *
     * @param string $url
     *
     * @return ShopBrand
     */
    public function getBrandByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopBrand', false);
    }


    /**
     * Добавить теги к товару
     *
     * @param ShopProduct $product
     * @param string $tags
     */
    public function addTagsToProduct(ShopProduct $product, $tags) {
        if ($product->getTags()) {
            $productTagArray = explode(',', $product->getTags());
        } else {
            $productTagArray = array();
        }
        $tmp = explode(',', $tags);
        foreach ($tmp as $x) {
            $x = trim($x);
            if (!$x) {
                continue;
            }

            if (in_array($x, $productTagArray)) {
                continue;
            }

            $productTagArray[] = $x;
        }
        $product->setTags(implode(',', $productTagArray));
        $product->update();
    }


    /**
     * Удалить теги из товара
     *
     * @param ShopProduct $product
     * @param string $tags
     */
    public function deleteTagsFromProduct(ShopProduct $product, $tags) {
        if (!$tags) {
            return false;
        }

        if ($product->getTags()) {
            $productTagArray = explode(',', $product->getTags());
        } else {
            $productTagArray = array();
        }
        $tmp = explode(',', $tags);
        $a = array();
        foreach ($productTagArray as $x) {
            $x = trim($x);
            if (!$x) {
                continue;
            }

            if (in_array($x, $tmp)) {
                continue;
            }

            $a[] = $x;
        }
        $product->setTags(implode(',', $a));
        $product->update();
    }

    /**
     * Создать бренд.
     * Если такой уже есть - то пропускаем.
     *
     * @param string $name
     *
     * @return ShopBrand
     */
    public function addBrand($name) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            $brand = new ShopBrand();
            $brand->setName($name);
            if (!$brand->select()) {
                $brand->insert();
            }

            SQLObject::TransactionCommit();

            return $brand;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Обновить картинку бренду.
     * Вместо пути можно указывать прямой URL на картинку.
     *
     * Метод актуален для парсеров.
     *
     * @param ShopBrand $brand
     * @param string $image
     */
    public function updateBrandImage(ShopBrand $brand, $image) {
        if (!$image) {
            throw new ServiceUtils_Exception('Empty image');
        }

        $file = $this->makeImagesUploadUrl(
            $image,
            '/shop/',
            false,
            'brand-'.$brand->getName()
        );
        copy($image, MEDIA_PATH.'shop/'.$file);

        if (file_exists(MEDIA_PATH.'shop/'.$file)) {
            $brand->setImage($file);
            $brand->update();
        }
    }



    /**
     * Экспортировать все товары в XML и JSON.
     * Метод запускается в cron hour и нужен для интеграции с системами типа 1С.
     */
    public function exportProducts() {
        $host = Engine::Get()->getProjectURL();
        $cdate = date('Y-m-d H:i:s');
        $path = PackageLoader::Get()->getProjectPath().'/media/export/product/';

        $filterKeyArray = array();
        $filters = Shop::Get()->getShopService()->getProductFiltersAll();
        $filters->setHidden(0);
        while ($x = $filters->getNext()) {
            $filterKeyArray[] = $x;
        }

        // model & product
        $a = array();
        $product = Shop::Get()->getShopService()->getProductsAll();
        while ($x = $product->getNext()) {
            $imageArray = array();
            $imageArray['image'] = false;
            $imageArray['images'] = array();

            if ($x->getImage()) {
                $imageArray['image'] = $host.'/media/shop/'.$x->getImage();
            }
            $img = $x->getImages();
            while ($i = $img->getNext()) {
                $imageArray['images'][] = $host.'/media/shop/'.$i->getFile();
            }

            $filterArray = array();
            foreach ($filterKeyArray as $filter) {
                try {
                    $filterValue = $x->getFilterValue($filter);

                    $filterArray[] = array(
                        'id' => $filter->getId(),
                        'name' => $filter->getName(),
                        'value' => $filterValue,
                    );
                } catch (Exception $filterEx) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            $price = $x->makePrice($x->getCurrency());
            $priceOld = $x->makePriceOld($x->getCurrency());
            if ($price >= $priceOld) {
                $priceOld = 0;
            }

            $supplierArray = array();

            $productSuppliers = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($x);
            while ($xx =  $productSuppliers->getNext()) {
                $supplierid = $xx->getSupplierid();
                if ($supplierid) {
                    try {
                        $supplier = Shop::Get()->getSupplierService()->getSupplierByID($supplierid);
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                            $xx->getCurrencyid()
                        );
                        $supplierArray[] = array(
                            'id' => $supplierid,
                            'name' => $supplier->getName(),
                            'article' => $xx->getArticle(),
                            'avail' => $xx->getAvail(),
                            'code' => $xx->getCode(),
                            'currency' => $currency->getName()
                        );
                    } catch (Exception $ex) {

                    }

                }
            }

            $a[] = array(
                'id' => $x->getId(),
                'categoryid' => $x->getCategoryid(),
                'brandid' => $x->getBrandid(),
                'name' => $x->getName(),
                'price' => $price,
                'priceold' => $priceOld,
                'pricebase' => $x->getPricebase(),
                'currencyname' => $x->getCurrency()->getName(),
                'articul' => $x->getArticul() ? $x->getArticul() : $x->getId(),
                'discount' => $x->getDiscount(),
                'description' => $x->getDescription(),
                'sortorder' => 0,
                'code1c' => $x->getCode1c(),
                'divisibility' => $x->getDivisibility(),
                'unit' => $x->getUnit(),
                'udate' => $x->getUdate(),
                'url' => $x->makeURL(),
                'imageArray' => $imageArray,
                'filterArray' => $filterArray,
                'avail' => $x->getAvail(),
                'availtext' => $x->getAvailtext(),
                'hidden' => $x->getHidden(),
                'wdate' => $cdate,
                'supplierArray' => $supplierArray,
            );
        }
        file_put_contents($path.'product.json', json_encode($a), LOCK_EX);
        PackageLoader::Get()->import('XML');
        $xml = XML_Creator::CreateFromArray(array('product' => $a))->__toString();
        file_put_contents($path.'product.xml', $xml, LOCK_EX);



    }


    /**
     * Экспортировать все категории в XML и JSON.
     * Метод запускается в cron hour и нужен для интеграции с системами типа 1С.
     */
    public function exportCategories() {
        $host = Engine::Get()->getProjectURL();
        $cdate = date('Y-m-d H:i:s');

        $a = array();
        $category = $this->getCategoryAll();
        while ($x = $category->getNext()) {
            $image = $x->getImage();
            if (!Checker::CheckImageFormat(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image)) {
                $image = false;
            }

            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'parentid' => $x->getParentid(),
                'level' => $x->getLevel(),
                'hidden' => $x->getHidden(),
                'description' => $x->getDescription(),
                'image' => $image ? $host.'/media/shop/'.$image : false,
                'wdate' => $cdate,
            );
        }

        $path = PackageLoader::Get()->getProjectPath().'/media/export/product/';

        file_put_contents($path.'category.json', json_encode($a), LOCK_EX);

        PackageLoader::Get()->import('XML');
        $xml = XML_Creator::CreateFromArray(array('category' => $a))->__toString();
        file_put_contents($path.'category.xml', $xml, LOCK_EX);
    }


    /**
     * Получить все иконки товаров
     *
     * @return ShopProductIcon
     */
    public function getProductIconAll() {
        $x = new ShopProductIcon();
        $x->setOrder('name', 'ASC');
        return $x;
    }



    /**
     * Найти категорию по URL-префиксу
     *
     * @param string $url
     *
     * @return ShopCategory
     */
    public function getCategoryByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception('Empty url');
        }

        return $this->getObjectByField('url', $url, 'ShopCategory', false);
    }




    /**
     * Получить domainURL категории
     *
     * @param ShopCategory $category
     *
     * @return string
     */
    public function getCategorySubdomain(ShopCategory $category) {
        try {
            if ($category->getSubdomain()) {
                return $category->getSubdomain();
            } else {
                return $this->getCategorySubdomain($category->getParent());
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }




    /**
     * Получить все категории
     *
     * @return ShopCategory
     */
    public function getCategoryAll() {
        $x = new ShopCategory();
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }




    /**
     * Получить категории по родительской
     *
     * @return ShopCategory
     */
    public function getCategoriesByParentID($parentID) {
        $x = $this->getCategoryAll();
        $x->setParentid($parentID);
        return $x;
    }




    /**
     * Получить уровень вложенности категории
     *
     * @param ShopCategory $category
     *
     * @return int
     */
    public function getCategoryLevel(ShopCategory $category) {
        $level = 1; // уровень
        $a = array(); // массив пройденных элементов
        $x = clone $category;
        while (1) {
            try {
                // если элемент уже был
                if (!empty($a[$x->getId()])) {
                    break;
                }
                $a[$x->getId()] = true; // этот элемент уже прошли

                $x = $x->getParent();
                $level++;
            } catch (Exception $e) {
                break;
            }
        }
        return $level;
    }




    /**
     * Сделать копию товара и вернуть ее.
     * Копируется все - товар, картинки, фильтра.
     * Списки и участие в списках не копируется.
     *
     * @param ShopProduct $product
     *
     * @return ShopProduct
     */
    public function copyProduct(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            $copy = clone $product;
            $copy->setId(false);
            $copy->setUrl('');
            $copy->insert();

            $images = $product->getImages();
            while ($x = $images->getNext()) {
                $tmp = clone $x;
                $x->setId(false);
                $x->setProductid($copy->getId());
                $x->insert();
            }

            $fvc = new XShopProductFilterValue();
            $fvc->setProductid($product->getId());
            while ($x = $fvc->getNext()) {
                $tmp = clone $x;
                $x->setId(false);
                $x->setProductid($copy->getId());
                $x->insert();
            }

            SQLObject::TransactionCommit();

            return $copy;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Проверить, лежит ли товар в корзине пользователя
     *
     * @param ShopProduct $product
     *
     * @return bool
     */
    public function isProductInBasket(ShopProduct $product) {
        $a = $this->getBasketProductsArray();

        foreach ($a as $x) {
            if ($x->getProductid() == $product->getId()) {
                return true;
            }
        }

        return false;
    }



    /**
     * Добавить товар в корзину
     *
     * @return ShopBasket
     */
    public function addToBasket($productID, $count, $options = false, $datefrom = false, $dateto = false) {
        try {
            SQLObject::TransactionStart();

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            if ($count <= 0) {
                throw new ServiceUtils_Exception();
            }

            $product = $this->getProductByID($productID);

            $count = $product->getCountWithDivisibility($count);

            $x = new ShopBasket();

            // session basket
            $x->setSid($this->_getSessionID());

            // issue #34973 - smart basket
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $x->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // product
            $x->setProductid($product->getId());
            $x->setActionsetid(0);

            // @todo: setPrice

            // если переданы опции - сохраняем их
            if ($options) {
                $optionArray = explode(';', $options);
                foreach ($optionArray as $option) {
                    $option = trim($option);
                    if (!$option) {
                        continue;
                    }
                    $option = explode(':', $option);
                    $filterID = $option[0];
                    $filterValue = $option[1];

                    try {
                        $filter_count = Engine::Get()->getConfigField('filter_count');
                    } catch (Exception $e) {
                        $filter_count = 10;
                    }
                    for ($j = 1; $j <= $filter_count; $j++) {
                        if ($x->getField('filter'.$j.'id')) {
                            continue;
                        }
                        if ($filterID && $filterValue) {
                            $x->setField('filter'.$j.'id', $filterID);
                            $x->setField('filter'.$j.'value', $filterValue);
                            //находим наценку в товаре
                            $filters = Shop::Get()->getShopService()->getProductFilterValues($product);
                            $filters->setFilterid($filterID);
                            while ($objFilter = $filters->getNext()) {
                                if ($filterValue === '') {
                                    $x->setField('filter'.$j.'markup', 0);
                                } elseif ($objFilter->getFiltervalue() == $filterValue) {
                                    $x->setField('filter'.$j.'markup', $objFilter->getFiltermarkup());
                                    break;
                                }
                            }
                            break;
                        }

                    }
                    unset($filterID);
                    unset($filterValue);
                }
            }

            if ($x->select()) {
                $x->setProductcount($count + $x->getProductcount());

                if ($datefrom) {
                    $x->setDatefrom($datefrom);
                }
                if ($dateto) {
                    $x->setDateto($dateto);
                }

                $x->update();
            } else {
                $x->setCdate(date('Y-m-d H:i:s'));
                $x->setProductcount($count);

                if ($datefrom) {
                    $x->setDatefrom($datefrom);
                }
                if ($dateto) {
                    $x->setDateto($dateto);
                }

                $x->insert();
            }

            SQLObject::TransactionCommit();

            // сбрасываем данные в кеше
            $this->_basketArray = false;

            // возвращаем элемент корзины
            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Получить элемент корзины по ID
     *
     * @param int $id
     *
     * @return ShopBasket
     */
    public function getBasketByID($basketID) {
        $x = new ShopBasket($basketID);
        if (!$x->getId()) {
            throw new ServiceUtils_Exception('incorrectBasketID');
        }
        return $x;
    }



    /**
     * Удалить товар с корзины
     *
     * @param int $basketID
     */
    public function deleteFromBasket($basketID) {
        try {
            SQLObject::TransactionStart();

            $basket = $this->getBasketByID($basketID);

            try {
                $userID = Shop::Get()->getUserService()->getUser()->getId();
            } catch (Exception $e) {
                $userID = -1;
            }

            $allowOperaton = ($basket->getSid() == $this->_getSessionID()
                || $basket->getUserid() == $userID
            );
            if (!$allowOperaton) {
                throw new ServiceUtils_Exception();
            }

            $basket->delete();

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Получить идентификатор сесии
     * с проверкой его состояния
     *
     * @return string
     */
    private function _getSessionID() {
        if (!session_id()) {
            @session_start();
        }

        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }


    /**
     * Получить все сожержимое корзины для заданной сессии
     *
     * @return ShopBasket
     */
    public function getBasketProducts() {
        $x = $this->getBasketAll();

        $a = array();

        try {
            // issue #34973 - smart basket
            $user = Shop::Get()->getUserService()->getUser();
            $a[] = 'userid='.$user->getId();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        // session basket
        $sid = $this->_getSessionID();
        $a[] = "sid='{$sid}'";

        if ($a) {
            $x->addWhereQuery("(".implode(' OR ', $a).")");
        } else {
            //issue #47484 если не почему выберать, то возвращаем пустой объект ShopBasket
            $x->addWhereQuery("(0)");
        }

        return $x;

    }



    /**
     * Получить массив товаров в корзине.
     * Метод кешируется!
     * Array of ShopBasket
     *
     * @return array|bool
     */
    public function getBasketProductsArray() {
        if ($this->_basketArray === false) {
            $this->_basketArray = array();
            $basket = $this->getBasketProducts();
            while ($x = $basket->getNext()) {
                $this->_basketArray[] = $x;
            }
        }

        return $this->_basketArray;
    }



    /**
     * Добавить товар в заказ.
     * После добавления рекомендуется пересчитать цены методом
     * recalculateOrderSums()
     *
     * @param ShopOrder $order
     * @param int $productID
     * @param float $productCount
     *
     * @see recalculateOrderSums()
     *
     * @return ShopOrderProduct
     */
    public function addOrderProduct(ShopOrder $order, $productID, $productCount = 1,
                                    $productPrice = false, $productCurrencyID = false) {
        try {
            SQLObject::TransactionStart();

            try {
                $product = $this->getProductByID($productID);
            } catch (ServiceUtils_Exception $pe) {
                // добавляем товар-пустышку issue #68443
                $product = false;
            }

            // @todo: need method to normalize string > float
            $productCount = trim($productCount);
            $productCount = str_replace(',', '.', $productCount);
            $productCount = (float) $productCount;
            if ($productCount <= 0) {
                $productCount = 1;
            }

            if ($productCurrencyID) {
                $currency = Shop::Get()->getCurrencyService()->getCurrencyByID($productCurrencyID);
            } else {
                $currency = $order->getCurrency();
            }

            $op = new ShopOrderProduct();
            $op->setOrderid($order->getId());
            $op->setProductprice($productPrice);
            $op->setCurrencyid($currency->getId());
            $op->setProductcount($productCount);

            if ($product) {
                $op->setProductid($product->getId());
                $op->setProductname($product->getName());
                $op->setSupplierid($product->getSupplierid());
                try {
                    $op->setCategoryname($product->getCategory()->getName());
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
                if (!$productPrice) {
                    $productPrice = $product->makePrice($currency, false);
                    $op->setDiscountpercent($product->getDiscount());
                    $op->setProductprice($productPrice);
                }
                $op->setProducttax($product->getTax());
            } else {
                $op->setProductname($productID);
            }

            $op->insert();

            SQLObject::TransactionCommit();

            return $op;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }


    /**
     * Получить заказанный товар по ID
     *
     * @param int $id
     *
     * @return ShopOrderProduct
     */
    public function getOrderProductById($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrderProduct');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }


    /**
     * Получить все заказанные товары
     *
     * @return ShopOrderProduct
     */
    public function getOrderProductsAll() {
        return $this->getObjectsAll('ShopOrderProduct');
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
    public function updateProduct(ShopProduct $product,
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
                                  $codesupplier, $characteristics, $share,
                                  $seotitle, $seodescription, $seocontent,
                                  $seokeywords, $icon = false, $downloadFile = false, $deleteDownloadFile = false,
                                  $datelifefrom = false, $datelifeto = false, $articul = false, $suppliered = false
    ) {
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
            $this->buildProductCategories($product);

            if ($deleteImage) {
                $this->deleteProductImage($product);
            } elseif ($image) {
                $this->updateProductImage($product, $image);
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
                $this->updateCategoryProductCount($categoryID);
            }
            if ($brandID) {
                $this->updateBrandProductCount($brandID);
            }

            // issue #42297 - старые товары убираем из корзин
            if ($deleted && $hidden) {
                $baskets = $this->getBasketAll();
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





    /**
     * Установить crop-изображение на продукт.
     * Можно указывать URL на картинку.
     *
     * @param ShopProduct $product
     * @param string $image
     */
    public function updateProductImageCrop (ShopProduct $product, $image) {
        if (!$image || !Checker::CheckImageFormat($image)) {
            throw new ServiceUtils_Exception('image');
        }

        // конвертация изображения в необходимый формат
        // и допустимый размер
        $image = Shop::Get()->getShopService()->convertImage($image);

        // куда сохраняем
        $file = $this->makeImagesUploadUrl(
            $image,
            '/shop/',
            false,
            'product-'.$product->getName().'-cropper-'
        );

        copy($image, MEDIA_PATH.'shop/'.$file);

        $product->setImagecrop($file);
        $product->update();
    }


    /**
     * Обновить у товара hidden=0/1 в зависимости от его времени жизни
     */
    public function updateProductLive() {
        ModeService::Get()->verbose('Process products live flags...');

        try {
            SQLObject::TransactionStart(false, true);

            $dateNow = date('Y-m-d');

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setHidden(0);
            $products->setDeleted(0);
            $products->addWhereQuery(
                '(
                (DATE(`datelifefrom`) > \''.$dateNow.'\' AND `datelifefrom` <> \'0000-00-00\')
                OR
                (DATE(`datelifeto`) < \''.$dateNow.'\' AND `datelifeto` <> \'0000-00-00\')
                )'
            );

            $products->setHidden(1, true);
            $products->update(true);

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setHidden(1);
            $products->setDeleted(0);
            $products->addWhereQuery('(DATE(`datelifefrom`) <= \''.$dateNow.'\' )');
            $products->addWhereQuery('(DATE(`datelifeto`) >= \''.$dateNow.'\' )');
            $products->addWhere('datelifefrom', '0000-00-00', '<>');
            $products->addWhere('datelifeto', '0000-00-00', '<>');

            $products->setHidden(0, true);
            $products->update(true);

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setHidden(1);
            $products->setDeleted(0);
            $products->addWhereQuery('(DATE(`datelifefrom`) <= \''.$dateNow.'\' )');
            $products->addWhere('datelifefrom', '0000-00-00', '<>');
            $products->addWhere('datelifeto', '0000-00-00');

            $products->setHidden(0, true);
            $products->update(true);

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setHidden(1);
            $products->setDeleted(0);
            $products->addWhereQuery('(DATE(`datelifeto`) >= \''.$dateNow.'\' )');
            $products->addWhere('datelifefrom', '0000-00-00');
            $products->addWhere('datelifeto', '0000-00-00', '<>');

            $products->setHidden(0, true);
            $products->update(true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }

    }


    /**
     * Если у товаров есть tmpimageurl,
     * то импортируем картинки из них
     */
    public function importProductImageFromURLs($verbose = false) {
        ModeService::Get()->verbose('Process images from URLs...');

        if (!file_exists(MEDIA_PATH.'shop/tmpimageurl')) {
            @mkdir(MEDIA_PATH.'shop/tmpimageurl');
        }

        $products = $this->getProductsAll();
        $products->addWhere('tmpimageurl', '', '<>');

        $cacheArray = array();

        while ($x = $products->getNext()) {
            $urls = $x->getTmpimageurl();
            $urlArray = explode(' ', $urls);
            $count = 0;
            foreach ($urlArray as $image) {
                if (!$image) {
                    continue;
                }

                if ($verbose) {
                    print $x->getId()."\n";
                    print $image."\n";
                    print "\n";
                }

                if (!$count) {
                    if (!empty($cacheArray[$image])) {
                        $image = $cacheArray[$image];
                    }

                    // первый урл - основное изображение
                    try {
                        $result = $this->updateProductImage($x, $image);
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                    if ($result && empty($cacheArray[$image])) {
                        $cacheArray[$image] = $result;
                    }
                } else {
                    // остальные - дополнительные
                    try {
                        Shop::Get()->getShopService()->addProductImage($x, $image);
                    } catch(Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }

                }

                $count ++;
            }

            $x->setTmpimageurl('');
            $x->update();
        }
    }


    /**
     * Найти ближайшую не скрытую категорию для товара
     *
     * @param ShopProduct $product
     *
     * @return ShopCategory
     *
     * @throws ServiceUtils_Exception
     */
    public function getNotHiddenCategoryByProduct (ShopProduct $product) {
        try {
            $category = $product->getCategory();
            if (!$category->getHidden()) {
                return $category;
            }

            while ($pCategory = $category->getParent()) {
                if (!$pCategory->getHidden()) {
                    return $pCategory;
                }

                $category = $pCategory;
            }
        } catch (Exception $ecategory) {

        }

        throw new  ServiceUtils_Exception('no visible category');

    }


    /**
     * Найти ближайшую не скрытую категорию для категории
     *
     * @param ShopCategory $category
     *
     * @return ShopCategory
     *
     * @throws ServiceUtils_Exception
     */
    public function getNotHiddenCategoryByCategory (ShopCategory $category) {
        try {
            while ($pCategory = $category->getParent()) {
                if (!$pCategory->getHidden()) {
                    return $pCategory;
                }

                $category = $pCategory;
            }
        } catch (Exception $ecategory) {

        }

        throw new  ServiceUtils_Exception('no visible category');

    }



    /**
     * Обновить или добавить изображения товара массово.
     * Первая картинка станет основной.
     *
     * Можно указывать URL прямо на картинку.
     *
     * @param ShopProduct $product
     * @param array $imageArray
     * @param bool $deleteOldImages
     */
    public function updateProductImageArray(ShopProduct $product, $imageArray, $deleteOldImages = false) {
        try {
            SQLObject::TransactionStart();

            // удаляем старые картинки
            if ($deleteOldImages) {
                $images = $product->getImages();
                $images->delete(true);

                $product->setImage('');
                $product->update();
            }

            $index = 0;
            foreach ($imageArray as $image) {
                try {
                    if ($index == 0) {
                        $this->updateProductImage($product, $image);
                    } else {
                        $this->addProductImage($product, $image);
                    }

                    $index ++;
                } catch (Exception $imageEx) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $imageEx;
                    }
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $imageEx) {
            SQLObject::TransactionRollback();
        }
    }



    /**
     * Скрыть или открыть всю категорию с товарами (рекурсивно)
     *
     * @param ShopCategory $category
     * @param bool $hidden
     */
    public function updateCategoryHidden(ShopCategory $category, $hidden) {
        try {
            SQLObject::TransactionStart();

            $this->_updateCategoryHidden($category, $hidden);

            $products = $category->getProducts();
            while ($x = $products->getNext()) {
                $x->setHiddenold($x->getHidden());
                $x->setHidden($hidden);
                $x->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    protected function _updateCategoryHidden(ShopCategory $category, $hidden) {
        $category->setHiddenold($category->getHidden());
        $category->setHidden($hidden);
        $category->update();

        // идем по всем под-категориям
        $subCategories = $category->getChilds();
        while ($x = $subCategories->getNext()) {
            $this->updateCategoryHidden($x, $hidden);
        }
    }

    /**
     * Добавить комментарий к товару
     *
     * @param ShopProduct $product
     * @param User $user
     * @param string $comment
     * @param string $plus
     * @param string $minus
     * @param int $rating
     *
     * @return ShopProductComment
     * @throws ServiceUtils_Exception
     */
    public function addProductComment(ShopProduct $product, User $user, $comment, $plus, $minus, $rating,
                                      $image = false) {
        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);
            $plus = trim($plus);
            $minus = trim($minus);

            if (!$comment) {
                throw new ServiceUtils_Exception('comment');
            }
            $rating = (int) $rating;
            if ($rating < 0 || $rating > 5) {
                throw new ServiceUtils_Exception('rating');
            }

            $x = new ShopProductComment();
            $x->setProductid($product->getId());
            $x->setUserid($user->getId());
            $x->setCdate(date('Y-m-d H:i:s'));
            $x->setText($comment);
            $x->setPlus($plus);
            $x->setMinus($minus);
            $x->setRating($rating);
            $name = $user->getName();
            if (!$name) {
                $name = $user->getLogin();
            }
            $x->setUsername($name);
            if ($image && Checker::CheckImageFormat($image)) {
                $file = $this->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false,
                    'review-'.$product->getName()
                );
                copy($image, MEDIA_PATH.'shop/'.$file);

                if (file_exists(MEDIA_PATH.'shop/'.$file)) {
                    $x->setImage($file);
                }
            }
            $x->insert();

            SQLObject::TransactionCommit();

            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить комментарии к товару
     *
     * @param ShopProduct $product
     *
     * @return ShopProductComment
     */
    public function getProductComments(ShopProduct $product) {
        $x = new ShopProductComment();
        $x->setProductid($product->getId());
        $x->setOrder('cdate', 'DESC');
        return $x;
    }



    /**
     * Добавить изображение товару.
     * Можно указывать ссылку на картинку.
     *
     * @param ShopProduct $product
     * @param string $image
     *
     * @return ShopImage
     */
    public function addProductImage(ShopProduct $product, $image) {
        try {
            SQLObject::TransactionStart();

            if (!$image || !Checker::CheckImageFormat($image)) {
                throw new ServiceUtils_Exception('image');
            }

            $file = $this->makeImagesUploadUrl(
                $image,
                '/shop/',
                false,
                'product-'.$product->getName()
            );
            $path = PackageLoader::Get()->getProjectPath().'media/shop/'.$file;

            copy($image, $path);

            // конвертация изображения в необходимый формат
            // и допустимый размер
            $path = Shop::Get()->getShopService()->convertImage($path);

            $x = new ShopImage();
            $x->setProductid($product->getId());
            $x->setFile($file);
            if (!$x->select()) {
                $x->insert();
            }

            SQLObject::TransactionCommit();

            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Создания адреса для записи картинки
     * создаётся 3 папки которые вложены друг в друга
     * Имена папок определяется по md5-hash файла
     *
     * @param $image
     * @param string $folder
     * @param string $fileformat
     *
     * @return string
     */
    public function makeImagesUploadUrl($image, $folder = 'shop/', $fileformat = false, $namePrefix = false) {
        if ($fileformat === false) {
            $sizeArray = @getimagesize($image);
            if ($sizeArray['mime'] == 'image/png') {
                $fileformat = 'png';
            } else {
                $fileformat = 'jpg';
            }
        }

        if ($namePrefix) {
            // превращаем префикс в латинские символы
            // убираем все левое
            $namePrefix = StringUtils_Transliterate::TransliterateRuToEn($namePrefix);
            $namePrefix = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $namePrefix);
            $namePrefix = preg_replace('/([\-]{2,})/ius', '-', $namePrefix);
        }

        $url = MEDIA_PATH.$folder;

        $imagemd5 = md5_file($image);
        $folder1 = substr($imagemd5, 0, 2);
        $folder2 = substr($imagemd5, 2, 2);

        @mkdir($url.$folder1);
        @mkdir($url.$folder1.'/'.$folder2);

        if ($namePrefix) {
            $imagemd5 = $folder1.'/'.$folder2.'/'.$namePrefix.'_'.$imagemd5.'.'.$fileformat;
        } else {
            $imagemd5 = $folder1.'/'.$folder2.'/'.$imagemd5.'.'.$fileformat;
        }

        return $imagemd5;
    }



    /**
     * Отконвертировать изображение в заданный формат хранения.
     * Уменьшить изображение до нужного размера.
     * Вернуть путь на сконвертированный файл.
     *
     * @param string $filepath
     *
     * @return string
     */
    public function convertImage($filepath) {
        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        // получаем предельные размеры изображения
        $maxWidth = 1200;
        $maxHeight = 1200;

        // получаем текущий размер изображения
        $imageSize = @getimagesize($filepath);
        if (!$imageSize) {
            return $filepath;
        }
        $width = $imageSize[0];
        $height = $imageSize[1];

        // определяем, до какого размера уменьшать?
        if ($width > $maxWidth) {
            $width = $maxWidth;
        }
        if ($height > $maxHeight) {
            $height = $maxHeight;
        }

        // обработка изображения
        $ip = new ImageProcessor($filepath);
        $ip->addAction(new ImageProcessor_ActionResizeProportional($width, $height));
        if ($format == 'png') {
            $ip->addAction(new ImageProcessor_ActionToPNG($filepath));
        } else {
            $ip->addAction(new ImageProcessor_ActionToJPEG($filepath));
        }

        $ip->process();
        return $filepath;
    }



    /**
     * Обновить основную картинку товару.
     * Вместо пути можно указывать прямой URL на картинку.
     *
     * Метод актуален для парсеров.
     *
     * @param ShopProduct $product
     * @param string $image
     *
     * @return string
     */
    public function updateProductImage(ShopProduct $product, $image) {
        if (!$image || !Checker::CheckImageFormat($image)) {
            throw new ServiceUtils_Exception('image');
        }

        $file = $this->makeImagesUploadUrl(
            $image,
            '/shop/',
            false,
            'product-'.$product->getName()
        );

        $path = MEDIA_PATH.'shop/'.$file;
        copy($image, $path);

        $path = $this->convertImage($path);

        if (file_exists(MEDIA_PATH.'shop/'.$file)) {
            $product->setImage($file);
            $product->update();

            return MEDIA_PATH.'shop/'.$file;
        }
    }



    /**
     * Получить картинку товара по ее ID $imageID
     *
     * @param int $imageID
     *
     * @return ShopImage
     */
    public function getProductImageByID($imageID) {
        return $this->getObjectByID($imageID, 'ShopImage');
    }



    /**
     * Удалить изображение у товара.
     * Если в $image передать false - то будет удалена основная картинка и ее crop.
     * В $image можно передать ID ShopImage или сам объект ShopImage.
     *
     * @param ShopProduct $product
     * @param mixed $image
     */
    public function deleteProductImage(ShopProduct $product, $image = false) {
        try {
            SQLObject::TransactionStart();

            if (!$image) {
                $product->setImage('');
                $product->setImagecrop('');
            }

            if ($image instanceof ShopImage) {
                if ($image->getProductid() != $product->getId()) {
                    throw new ServiceUtils_Exception();
                }

                $image->delete();
            }

            if (is_int($image)) {
                $image = $this->getProductImageByID($image);

                if ($image->getProductid() != $product->getId()) {
                    throw new ServiceUtils_Exception();
                }

                $image->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Создать новый скрытый товар
     *
     * @param string $name
     * @param int $id
     *
     * @return ShopProduct
     */
    public function addProduct($name, $id = false) {
        try {
            SQLObject::TransactionStart();

            // заменяем спец-символы
            $name = str_replace(array("\n", "\r", "\t"), ' ', $name);

            // удаляем дубликаты пробелов
            $name = preg_replace('/(\s+)/ius', ' ', $name);
            $name = trim($name);

            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            // проверка имени на уникальность (антидубликат)
            if (!Shop::Get()->getSettingsService()->getSettingValue('product-name-doublicates')) {
                // issue #22470
                // проверяем чтобы такого дубликата не было
                // (антидубликат на основе similar text)
                $nameStub1 = str_replace(array("\n", ' ', '/', "\t", "\r"), '', $name);
                $nameLike = preg_replace("/(.){1}/ius", '$1%', $nameStub1);

                $tmp = new XShopProduct();
                $tmp->addWhere('name', $nameLike, 'LIKE');
                while ($x = $tmp->getNext()) {
                    $nameStub2 = str_replace(array("\n", ' ', '/', "\t", "\r"), '', $x->getName());

                    if ($nameStub1 == $nameStub2) {
                        throw new ServiceUtils_Exception('name-doublicate');
                    }
                }
            }

            if ($id) {
                try {
                    $this->getProductByID($id);
                    $found = true;
                } catch (Exception $e) {
                    $found = false;
                }

                if ($found) {
                    throw new ServiceUtils_Exception('id');
                }
            }

            $product = new ShopProduct();
            $product->setName($name);
            $product->setHidden(1);
            $product->setCurrencyid(Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
            if ($id) {
                $product->setId($id);
            }
            $product->insert();

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-product-'.$product->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_a_new_product').
                    ' #'.$product->getId().Shop::Get()->getTranslateService()->getTranslateSecure('translate_named')
                    .$name.
                    '". '.Shop::Get()->getTranslateService()->getTranslateSecure('translate_product_hidden').'.',
                    $user->getId()
                );
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $event = Events::Get()->generateEvent('shopProductAddAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();

            return $product;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Поиск товаров по категории
     *
     * @param ShopCategory $category
     *
     * @return ShopProduct
     */
    public function getProductsByCategory(ShopCategory $category) {
        $x = $this->getProductsAll();

        $level = $category->getLevel();
        $x->setField('category'.$level.'id', $category->getId());
        return $x;
    }



    /**
     * Получить категорию по ID
     *
     * @param int $id
     *
     * @return ShopCategory
     */
    public function getCategoryByID($id) {
        return $this->getObjectByID($id, 'ShopCategory');
    }



    /**
     * Получить все товары
     *
     * @return ShopProduct
     */
    public function getProductsAll() {
        $x = new ShopProduct();
        $x->setOrder('name', 'ASC');
        return $x;
    }



    /**
     * Получить товары по бренду
     *
     * @param ShopBrand $brand
     *
     * @return ShopProduct
     */
    public function getProductsByBrand(ShopBrand $brand) {
        $x = $this->getProductsAll();
        $x->setBrandid($brand->getId());
        return $x;
    }



    /**
     * Получить бренд по номеру
     *
     * @param int $id
     *
     * @return ShopBrand
     */
    public function getBrandByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopBrand');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }



    /**
     * Обновить кеш количества товаров бренда
     *
     * @param int $brandID
     */
    public function updateBrandProductCount($brandID) {
        try {
            SQLObject::TransactionStart();

            $brand = $this->getBrandByID($brandID);
            $products = $this->getProductsByBrand($brand);
            $products->addWhere('hidden', '0', '=');
            $products->addWhere('deleted', '0', '=');
            $brand->setProductcount($products->getCount());
            $brand->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Обновить кеш количества товаров в категории
     *
     * @param int $categoryID
     *
     * @todo remake to object
     */
    public function updateCategoryProductCount($categoryID) {
        try {
            SQLObject::TransactionStart();

            $category = $this->getCategoryByID($categoryID);
            $products = $this->getProductsByCategory($category);
            $products->addWhere('hidden', '0', '=');
            $products->addWhere('deleted', '0', '=');
            $category->setProductcount($products->getCount());
            $category->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Получить все товары из корзин
     *
     * @return ShopBasket
     */
    public function getBasketAll() {
        $x = new ShopBasket();
        return $x;
    }



    /**
     * Удалить товар
     *
     * @param ShopProduct $product
     */
    public function deleteProduct(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            // генерируем событие
            $event = Events::Get()->generateEvent('shopProductDeleteBefore');
            $event->setProduct($product);
            $event->notify();

            // чистка корзины
            $baskets = $this->getBasketAll();
            $baskets->setProductid($product->getId());
            $baskets->delete(true);

            // чистка "товаров в списках"
            $list = new XShopProduct2List();
            $list->setProductid($product->getId());
            $list->delete(true);

            // удаляем картинки
            $images = $product->getImages();
            $images->delete(true);

            // чистка истории просмотров
            $history = new XShopProductView();
            $history->setProductid($product->getId());
            $history->delete(true);

            $categoryID = $product->getCategoryid();
            $brandID = $product->getBrandid();

            // удаляем товар
            $product->delete();

            if ($categoryID) {
                $this->updateCategoryProductCount($categoryID);
            }
            if ($brandID) {
                $this->updateBrandProductCount($brandID);
            }

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-product-'.$product->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translate_deleted_items').
                    ' #'.$product->getId().' '.$product->getName(),
                    $user->getId()
                );
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $event = Events::Get()->generateEvent('shopProductDeleteAfter');
            $event->setProduct($product);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Получить массив всех родительских категорий
     *
     * @param ShopCategory $category
     *
     * @return array of int
     */
    protected function _getCategoryParentsArray(ShopCategory $category) {
        // если данные есть в кеше - сразу выдаем их
        if (isset($this->_categoryTreeArray[$category->getId()])) {
            return $this->_categoryTreeArray[$category->getId()];
        }

        $a = array(); // массив пройденных элементов
        $x = clone $category;
        while (1) {
            try {
                // если элемент уже был
                if (in_array($x->getId(), $a)) {
                    break;
                }
                $a[] = $x->getId(); // этот элемент уже прошли

                $x = $x->getParent();
            } catch (Exception $e) {
                break;
            }
        }

        $a = array_reverse($a);

        // заносим данные в кеш
        $this->_categoryTreeArray[$category->getId()] = $a;

        return $a;
    }



    /**
     * Перестроить кеш 1..10 из категорий для товара $product
     *
     * @param ShopProduct $product
     */
    public function buildProductCategories(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            if ($product->getCategoryid()) {
                $a = $this->_getCategoryParentsArray(
                    $product->getCategory()
                );
            } else {
                $a = array();
            }

            for ($i = 1; $i <= 10; $i++) {
                @$product->setField('category'.$i.'id', $a[$i-1]);
            }

            $product->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Обновить товару категорию
     *
     * @param ShopProduct $product
     * @param ShopCategory $category
     */
    public function updateProductCategory(ShopProduct $product, ShopCategory $category) {
        try {
            SQLObject::TransactionStart();

            $product->setCategoryid($category->getId());
            $this->buildProductCategories($product);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Склеить товары
     *
     * @param ShopProduct $productMain
     * @param array $productIDArray
     */
    public function mergeProducts(ShopProduct $productMain, $productIDArray) {
        try {
            SQLObject::TransactionStart();

            $imageNewArray = array();

            $imageArray = array();
            if ($productMain->getImage()) {
                $imageArray[] = $productMain->getImage();
            }
            $images = $productMain->getImages();
            while ($image = $images->getNext()) {
                $imageArray[] = $image->getFile();
            }

            $filters = Shop::Get()->getShopService()->getProductFilterValues($productMain);
            while ($objFilter = $filters->getNext()) {
                $filterIDArray[] = $objFilter->getId();
            }

            $supplierIDArray = array();
            $tmp = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($productMain);
            while ($x = $tmp->getNext()) {
                $supplierIDArray[] = $x->getSupplierId();
            }

            foreach ($productIDArray as $productID) {
                try {
                    $product = $this->getProductByID($productID);

                    if ($product->getImage()) {
                        if (!$productMain->getImage()) {
                            $productMain->setImage($product->getImage());
                        } elseif (!in_array($product->getImage(), $imageArray)) {
                            $imageNewArray[] = $product->getImage();
                        }
                        $imageArray[] = $product->getImage();
                    }

                    $images = $product->getImages();
                    while ($image = $images->getNext()) {
                        if (!$productMain->getImage()) {
                            $productMain->setImage($image->getFile());
                        } elseif (!in_array($image->getFile(), $imageArray)) {
                            $imageNewArray[] = $image->getFile();
                        }
                        $imageArray[] = $product->getImage();
                    }

                    if ($product->getCategoryid() && !$productMain->getCategoryid()) {
                        try {
                            $this->updateProductCategory($productMain, $product->getCategory());
                        } catch (ServiceUtils_Exception $sce) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $sce;
                            }
                        }
                    }

                    if ($product->getBrandid() && !$productMain->getBrandid()) {
                        $productMain->setBrandid($product->getBrandid());
                    }

                    if ($product->getDescription() && !$productMain->getDescription()) {
                        $productMain->setDescription($product->getDescription());
                    }

                    if ($product->getDescriptionshort() && !$productMain->getDescriptionshort()) {
                        $productMain->setDescriptionshort($product->getDescriptionshort());
                    }

                    if ($product->getCharacteristics() && !$productMain->getCharacteristics()) {
                        $productMain->setCharacteristics($product->getCharacteristics());
                    }

                    if ($product->getUnit() && !$productMain->getUnit()) {
                        $productMain->setUnit($product->getUnit());
                    }

                    $filters = Shop::Get()->getShopService()->getProductFilterValues($product);
                    while ($objFilter = $filters->getNext()) {
                        $filterID = $objFilter->getFilterid();
                        if (!in_array($filterID, $filterIDArray)) {
                            $filterIDArray[] = $filterID;

                            Shop::Get()->getShopService()->addProductFilterValue(
                                $productMain,
                                $objFilter->getFilterid(),
                                $objFilter->getFiltervalue(),
                                $objFilter->getFilteruse(),
                                $objFilter->getFilteractual(),
                                $objFilter->getFilteroption(),
                                $objFilter->getFiltermarkup()
                            );

                        }
                    }

                    $productSupplier = Shop::Get()->getSupplierService()->getProductSupplierFromProduct(
                        $product
                    );

                    while ($x = $productSupplier->getNext()) {
                        $supplierID = $x->getSupplierid();
                        if (!in_array($supplierID, $supplierIDArray)) {
                            $supplierIDArray[] = $supplierID;
                            // Если такого поставщика нет допишем его в продукт
                            $tmp = new ShopProductSupplier();
                            $tmp->filterProductid($productMain->getId());
                            $tmp->filterSupplierid($supplierID);
                            if (!$tmp->select()) {
                                $newSupplierObj = clone $x;
                                $newSupplierObj->setSupplierid($supplierID);
                                $newSupplierObj->setProductid($productMain->getId());
                                $newSupplierObj->insert();
                            }
                        }
                    }

                    if ($product->getArticul() && !$productMain->getArticul()) {
                        $productMain->setArticul($product->getArticul());
                    }

                    if ($product->getCode1c() && !$productMain->getCode1c()) {
                        $productMain->setCode1c($product->getCode1c());
                    }

                    if ($product->getModel() && !$productMain->getModel()) {
                        $productMain->setModel($product->getModel());
                    }

                    if ($product->getSeriesname() && !$productMain->getSeriesname()) {
                        $productMain->setSeriesname($product->getSeriesname());
                    }

                    $this->deleteProduct($product);

                } catch (ServiceUtils_Exception $se) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $se;
                    }
                }
            }

            $productMain->update();

            foreach ($imageNewArray as $image) {
                if ($image) {
                    $x = new ShopImage();
                    $x->setProductid($productMain->getId());
                    $x->setFile($image);
                    $x->insert();
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Получить объект по ID
     *
     * @param int $objectID
     *
     * @return SQLObject
     *
     * @throws ServiceUtils_Exception
     */
    public function getObjectByID($objectID, $classname = false) {
        if ($objectID > 0) {
            if (!$classname) {
                $classname = $this->_getServiceClassName();
            }
            try {
                return SQLObject::GetObject($classname, $objectID);
            } catch (Exception $e) {

            }
        }
        throw new ServiceUtils_Exception("$classname-object by id not found");
    }



    /**
     * Получить продукт по его ID
     *
     * @return ShopProduct
     */
    public function getProductByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProduct');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }



    /**
     * Получить все комментарии ко всем товарам
     *
     * @return ShopProductComment
     */
    public function getProductCommentsAll() {
        $x = new ShopProductComment();
        $x->setOrder('cdate', 'DESC');
        return $x;
    }



    /**
     * Пересчет рейтинга товаров
     */
    public function calculateProductRating() {
        ModeService::Get()->verbose('Calculate product rating...');

        $countArray = array();
        $countRatingArray = array();
        $ratingArray = array();
        $comments = $this->getProductCommentsAll();
        while ($x = $comments->getNext()) {
            @$countArray[$x->getProductid()] ++;
            if ($x->getRating() > 0) {
                @$countRatingArray[$x->getProductid()] ++;
                @$ratingArray[$x->getProductid()] += $x->getRating();
            }
        }

        foreach ($countArray as $productID => $count) {
            try {
                $product = $this->getProductByID($productID);

                if (!empty($countRatingArray[$productID])) {
                    $ratingCount = $countRatingArray[$productID];

                    // пишем рейтинг
                    $product->setRating($ratingArray[$productID] / $ratingCount);
                }

                // сюда пишем количество отзывов
                $product->setRatingcount($count);
                $product->update();
            } catch (Exception $productEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $productEx;
                }
            }
        }

        // для всех товаров у которых рейтинг 0, но их заказывали более 20 раз
        // ставим рейтинг автоматически
        $products = $this->getProductsAll();
        $products->setRatingcount(0);
        $products->addWhere('ordered', 20, '>=');
        while ($x = $products->getNext()) {
            if ($x->getOrdered() >= 20) {
                $x->setRating(5);
            } elseif ($x->getOrdered() >= 10) {
                $x->setRating(4);
            } else {
                $x->setRating(3);
            }
            $x->update();
        }
    }



    /**
     * Получить временную ссылку на скачивание товара
     * Ссылка будет действительна в течении времени ttl.
     *
     * @param ShopProduct $product
     *
     * @return string
     */
    public function makeProductDownloadURL(ShopProduct $product) {
        if (!$product->getFiledownload()) {
            throw new ServiceUtils_Exception();
        }

        $hash = md5(time().$product->getFiledownload().time());
        $ttl = Shop::Get()->getSettingsService()->getSettingValue('product-downloadfile-ttl');

        $x = new XShopDownloadURL();
        $x->setLinkkey('product-'.$product->getId());
        $x->setHash($hash);
        $x->setFile($product->getFiledownload());
        $x->setCdate(date('Y-m-d H:i:s'));
        $x->setEdate(DateTime_Object::Now()->addMinute($ttl)->__toString());
        $x->insert();

        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-product-download',
            $hash,
            'hash'
        );
    }



    /**
     * Получить массив продуктов, который надо выводить при группировке
     *
     * @return array
     */
    public function getProductsGroupedIdArray() {
        $productsArray = array();

        $grouped = new XShopProductGrouped();
        while ($x = $grouped->getNext()) {
            $productsArray[] = $x->getProductid();
        }

        return $productsArray;
    }



    /**
     * Проверить такую категорию и добавить ее, если нет.
     * parentID может быть не обязательным.
     *
     * Метод актуален для парсеров.
     *
     * @param string $name
     * @param int $parentID
     *
     * @return ShopCategory
     */
    public function addCategory($name, $parentID = false) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception('name');
        }

        try {
            SQLObject::TransactionStart();

            $category = new ShopCategory();
            $category->setName($name);
            if ($parentID !== false) {
                $category->setParentid($parentID);
            }
            if (!$category->select()) {
                $category->insert();
            }

            SQLObject::TransactionCommit();

            return $category;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Добавить фильтр если такого еще нет
     *
     * @param string $name
     * @param string $type
     *
     * @return ShopProductFilter
     */
    public function addProductFilter($name, $type = 'checkbox') {
        if (!$name) {
            throw new ServiceUtils_Exception('name');
        }

        try {
            SQLObject::TransactionStart();

            $filter = new ShopProductFilter();
            $filter->setName($name);
            if (!$filter->select()) {
                $filter->setType($type);
                $filter->insert();
            }

            SQLObject::TransactionCommit();

            return $filter;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Получить массив данных по продукту для формирования документов
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function makeProductAssignArrayForDocument(ShopProduct $product) {
        $a = array();
        $a['productid'] = $product->getId();
        $a['name'] = mb_substr($product->getName(), 0, 12);
        try {
            $a['barcodeimageexternal'] = $product->makeBarcodeImageExternal();
        } catch (ServiceUtils_Exception $se) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $se;
            }
        }
        $a['barcodeimageinternal'] = $product->makeBarcodeImageInternal();
        return $a;
    }



    /**
     * Обновить все необходимые значения filtervalue
     */
    public function updateProductFVC(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            // количество фильтров
            try {
                $filter_count = Engine::Get()->getConfigField('filter_count');
            } catch (Exception $e) {
                $filter_count = 10;
            }

            // получаем массив всех FCV по данному товару
            $tmp = new XShopProductFilterValue();
            $tmp->setProductid($product->getId());
            $fcvIDArray = array();
            while ($x = $tmp->getNext()) {
                $fcvIDArray[$x->getId()] = $x;
            }

            // обновляем или добавляем FVC
            for ($j = 1; $j <= $filter_count; $j++) {
                $use = $product->getField('filter'.$j.'use', true, true);
                $value = trim($product->getField('filter'.$j.'value', true, true));
                $filterID = trim($product->getField('filter'.$j.'id', true, true));

                if (!$filterID) {
                    continue;
                }

                try {
                    $tmp = new XShopProductFilterValue();
                    $tmp->setProductid($product->getId());
                    $tmp->setFilterid($filterID);
                    $tmp->setFiltervalue($value);
                    if (!$tmp->select()) {
                        $tmp->setFilteruse($use);
                        $tmp->setFilteroption(trim($product->getField('filter'.$j.'option', true, true)));
                        $tmp->setFilteractual(trim($product->getField('filter'.$j.'actual', true, true)));
                        $tmp->setFiltermarkup(trim($product->getField('filter'.$j.'markup', true, true)));
                        $tmp->insert();
                    } else {
                        $tmp->setFilteruse($use);
                        $tmp->setFilteroption(trim($product->getField('filter'.$j.'option', true, true)));
                        $tmp->setFilteractual(trim($product->getField('filter'.$j.'actual', true, true)));
                        $tmp->setFiltermarkup(trim($product->getField('filter'.$j.'markup', true, true)));

                        $tmp->update();
                    }

                    // если обновили - убираем из массива
                    if (isset($fcvIDArray[$tmp->getId()])) {
                        unset($fcvIDArray[$tmp->getId()]);
                    }
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            if ($product->getBrandid()) {
                $tmp = new XShopProductFilterValue();
                $tmp->setProductid($product->getId());
                $tmp->setFilterid(-1); // brandid
                $tmp->setFiltervalue($product->getBrandid());
                if (!$tmp->select()) {
                    $tmp->setFilteruse(1);
                    $tmp->insert();
                } else {
                    $tmp->setFilteruse(1);
                    $tmp->update();
                }

                // если обновили - убираем из массива
                if (isset($fcvIDArray[$tmp->getId()])) {
                    unset($fcvIDArray[$tmp->getId()]);
                }
            }

            if ($product->getCategoryid()) {
                $tmp = new XShopProductFilterValue();
                $tmp->setProductid($product->getId());
                $tmp->setFilterid(-2); // categoryid
                $tmp->setFiltervalue($product->getCategoryid());
                if (!$tmp->select()) {
                    $tmp->setFilteruse(1);
                    $tmp->insert();
                } else {
                    $tmp->setFilteruse(1);
                    $tmp->update();
                }

                // если обновили - убираем из массива
                if (isset($fcvIDArray[$tmp->getId()])) {
                    unset($fcvIDArray[$tmp->getId()]);
                }
            }

            // удаляем все не актуальне FVC данные
            foreach ($fcvIDArray as $id => $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Обновить все необходимые значения filtervalue
     */
    public function updateProductFVCCategory(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();
            // получаем массив всех FCV по данному товару
            $tmp = new XShopProductFilterValue();
            $tmp->setProductid($product->getId());
            $tmp->setFilterid(-2);
            $fcvIDArray = array();
            while ($x = $tmp->getNext()) {
                $fcvIDArray[$x->getId()] = $x;
            }

            if ($product->getCategoryid()) {
                $tmp = new XShopProductFilterValue();
                $tmp->setProductid($product->getId());
                $tmp->setFilterid(-2); // categoryid
                $tmp->setFiltervalue($product->getCategoryid());
                if (!$tmp->select()) {
                    $tmp->insert();
                } else {
                    $tmp->setFilteruse(1);
                    $tmp->update();
                }

                // если обновили - убираем из массива
                if (isset($fcvIDArray[$tmp->getId()])) {
                    unset($fcvIDArray[$tmp->getId()]);
                }
            }

            // удаляем все не актуальне FVC данные
            foreach ($fcvIDArray as $id => $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Обновить все необходимые значения filtervalue
     */
    public function updateProductFVCBrand(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();
            // получаем массив всех FCV по данному товару
            $tmp = new XShopProductFilterValue();
            $tmp->setProductid($product->getId());
            $tmp->setFilterid(-1);
            $fcvIDArray = array();
            while ($x = $tmp->getNext()) {
                $fcvIDArray[$x->getId()] = $x;
            }

            if ($product->getBrandid()) {
                $tmp = new XShopProductFilterValue();
                $tmp->setProductid($product->getId());
                $tmp->setFilterid(-1); // brandid
                $tmp->setFiltervalue($product->getBrandid());
                if (!$tmp->select()) {
                    $tmp->insert();
                } else {
                    $tmp->setFilteruse(1);
                    $tmp->update();
                }

                // если обновили - убираем из массива
                if (isset($fcvIDArray[$tmp->getId()])) {
                    unset($fcvIDArray[$tmp->getId()]);
                }
            }

            // удаляем все не актуальне FVC данные
            foreach ($fcvIDArray as $id => $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Обновить теги товара
     */
    public function updateProductTags(ShopProduct $product) {
        try {
            SQLObject::TransactionStart();

            // получаем массив всех FCV по данному товару
            $tmp = new XShopProduct2Tag();
            $tmp->setProductid($product->getId());
            $tagIDArray = array();
            while ($x = $tmp->getNext()) {
                $tagIDArray[$x->getTagid()] = $x;
            }

            $tags = explode(',', $product->getTags());

            foreach ($tags as $name) {
                $name = trim($name);
                if (!$name) {
                    continue;
                }

                try {
                    $tag = new XShopProductTag();
                    $tag->setName($name);
                    if (!$tag->select()) {
                        $tag->insert();
                    }

                    $tmp = new XShopProduct2Tag();
                    $tmp->setProductid($product->getId());
                    $tmp->setTagid($tag->getId());
                    if (!$tmp->select()) {
                        $tmp->insert();
                    }

                    // если обновили - убираем из массива
                    if (isset($tagIDArray[$tmp->getTagid()])) {
                        unset($tagIDArray[$tmp->getTagid()]);
                    }
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            // удаляем все не актуальные tag
            foreach ($tagIDArray as $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }



    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return ProductService
     */
    public static function Get() {
        if (!self::$_Instance) {
            $classname = self::$_Classname;
            if ($classname) {
                self::$_Instance = new $classname();
            } else {
                self::$_Instance = new self();
            }
        }
        return self::$_Instance;
    }



    /**
     * Задать класс сервиса.
     * override-метод.
     *
     * @param string $classname
     */
    public static function Set($classname) {
        self::$_Classname = $classname;
        self::$_Instance = null;
    }



    /**
     * Временный кеш для дерева категорий.
     * Нужен когда быстро и много вызывается buildProductCategory()
     *
     * @var array
     */
    private $_categoryTreeArray = array();



    /**
     * Кеш товаров, которые в корзине
     *
     * @var array
     */
    private $_basketArray = false;



    /**
     * Подменяемый объект сервиса
     *
     * @var OrderService
     */
    private static $_Instance = null;



    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;
}