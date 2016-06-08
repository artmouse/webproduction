<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Тут просто нереальное количество барахла ;)
 *
 * @copyright WebProduction
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @package   OneBox
 */
class Shop_ShopService extends ServiceUtils_AbstractService {

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
     * Получить продукт по коду 1С
     *
     * @return ShopProduct
     */
    public function getProductByCode1c($code1c) {
        try {
            return $this->getObjectByField('code1c', $code1c, 'ShopProduct');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by code1c not found');
    }

    /**
     * Найти товар по поставщику и его коду
     *
     * @param ShopSupplier $supplier
     * @param string $code
     *
     * @return ShopProduct
     *
     * @deprecated
     */
    public function getProductBySupplierCode(ShopSupplier $supplier, $code) {
        return Shop::Get()->getSupplierService()->getProductBySupplierAndCode($supplier, $code);
    }

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
     * неведомая херня
     *
     * @param $id
     *
     * @throws ServiceUtils_Exception
     * @return XShopActionSet
     */
    public function getActionSetById ($id) {
        try {
            return $this->getObjectByID($id, 'XShopActionSet');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * неведомая херня 2
     *
     * @return XShopActionSet
     */
    public function getActionSetAll() {
        $x = new XShopActionSet();
        return $x;
    }

    /**
     * Товары набора (без основного товара, который учитывается при определении набора)
     *
     * @param XShopActionSet $actionSet
     *
     * @return ShopProduct
     */
    public function getActionSetProduct(XShopActionSet $actionSet) {
        $products = $this->getProductsAll();
        $products->innerJoinTable('product2actionset', '(`shopproduct`.`id` = `product2actionset`.`productid`)');
        $products->addFieldQuery('`product2actionset`.`discount` as actiondiscount');
        $products->addWhere('`product2actionset`.`actionid`', $actionSet->getId());
        return $products;
    }

    /**
     * Массив акционных наборов продукта
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function getActionSetArrayByProduct(ShopProduct $product) {
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        $set = $this->getActionSetAll();
        $set->setProductid($product->getId());
        $set->setHidden(0);
        $resultArray = array();
        while ($s = $set->getNext()) {
            $setSum = 0;
            $product2ActionSet = Shop::Get()->getShopService()->getActionSetProduct($s);
            if (!$product2ActionSet->getCount()) {
                continue;
            }
            $a = array();
            $productArray = array();
            $actionPrice = Shop::Get()->getShopService()->makeActionPrice(
                $product,
                $currencyDefault,
                $s->getDiscount()
            );
            $productArray[] = array(
                'productid' => $product->getId(),
                'name' => $product->getName(),
                'actionPrice' => $actionPrice,
                'image' => $product->makeImageThumb(100),
                'url' => $product->makeURL(),
            );

            $setSum += $actionPrice;
            $removeSet = false;
            while ($p = $product2ActionSet->getNext()) {
                // если среди товаров есть скрытый или удалённый, то не показываем весь набор
                if ($p->getHidden() || $p->getDeleted()) {
                    $removeSet = true;
                    break;
                }

                $actionPrice = Shop::Get()->getShopService()->makeActionPrice(
                    $p,
                    $currencyDefault,
                    $p->getField('actiondiscount')
                );

                $productArray[] = array(
                    'productid' => $p->getId(),
                    'name' => $p->getName(),
                    'actionPrice' => $actionPrice,
                    'image' => $p->makeImageThumb(100),
                    'url' => $p->makeURL(),
                );
                $setSum += $actionPrice;
            }

            if ($removeSet) {
                continue;
            }

            $a['productArray'] = $productArray;
            $a['sum'] = round($setSum);
            $a['id'] = $s->getId();
            $a['name'] = $s->getName();

            $resultArray[] = $a;
        }

        return $resultArray;
    }

    /**
     * Цена товара в наборе
     * Фактически можно считать цену с произвольной скидкой
     *
     * @param ShopProduct $product
     * @param ShopCurrency $currency
     * @param $discount
     * @param bool $round
     *
     * @return float|int
     */
    public function makeActionPrice(ShopProduct $product, ShopCurrency $currency, $discount, $round = true) {
        $price = $product->getPrice();
        if ($discount) {
            $price *= (1 - $discount / 100);
        }

        $price = Shop::Get()->getCurrencyService()->convertCurrency(
            $price,
            $product->getCurrency(),
            $currency
        );

        if ($round) {
            $price = round($price);
        } else {
            $round = Shop::Get()->getSettingsService()->getSettingValue('price-rounding-off');
            if ($round) {
                $price = round($price);
            } else {
                $price = round($price, 2);
            }
        }

        return $price;
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
     * Найти тег по URL-префиксу
     *
     * @param string $url
     *
     * @return ShopProductTag
     */
    public function getProductTagByURL($url) {
        $url = trim($url);
        if (!$url) {
            throw new ServiceUtils_Exception();
        }
        return $this->getObjectByField('url', $url, 'ShopProductTag', false);
    }

    /**
     * Получить тег по ID
     *
     * @param int $id
     *
     * @return ShopProductTag
     */
    public function getProductTagByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProductTag');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
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
     * Получить статус заказа по ID
     *
     * @param int $id
     *
     * @return ShopOrderStatus
     *
     * @deprecated
     */
    public function getStatusByID($id) {
        return WorkflowService::Get()->getStatusByID($id);
    }

    /**
     * Получить способ оплаты по ID
     *
     * @return ShopPayment
     */
    public function getPaymentByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopPayment');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить все способы оплаты
     *
     * @return ShopPayment
     */
    public function getPaymentAll() {
        $x = new ShopPayment();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Добавить вариант оплаты или вернуть вариант,
     * если такой уже есть.
     *
     * @param string $name
     *
     * @return ShopPayment
     */
    public function addPayment($name) {
        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            $payment = new ShopPayment();
            $payment->setName($name);
            if (!$payment->select()) {
                $payment->insert();
            }

            SQLObject::TransactionCommit();

            return $payment;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить способы оплаты исходя из вариантов доставки
     *
     * @param int $deliveryID
     *
     * @return ShopPayment
     */
    public function getPaymentByDeliveryID($deliveryID = false) {
        $x = $this->getPaymentAll();
        $a = array(0, $deliveryID);
        $x->addWhereArray($a, 'deliveryid');
        return $x;
    }

    /**
     * Получить скидку по ID
     *
     * @param int $id
     *
     * @return ShopDiscount
     */
    public function getDiscountByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopDiscount');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить все скидки
     *
     * @return ShopDiscount
     */
    public function getDiscountAll() {
        $x = new ShopDiscount();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить все статусы заказов
     *
     * @return ShopOrderStatus
     *
     * @deprecated
     */
    public function getStatusAll() {
        return WorkflowService::Get()->getStatusAll();
    }

    /**
     * Обновить менеджера заказа.
     * $user - это кто меняет, может быть false.
     * $manager - на кого меняем, тоже может быть false
     *
     * @param ShopOrder $order
     * @param User $user
     * @param User $manager
     */
    public function updateOrderManager(ShopOrder $order, $user, $manager) {
        // проверка
        if ($manager) {
            if ($manager->getId() == $order->getManagerid()) {
                return false;
            }
        } elseif (!$order->getManagerid()) {
            return false;
        }

        try {
            SQLObject::TransactionStart();

            if ($manager) {
                $comment = 'Ответственный изменен на '.$manager->makeName(false, 'lfm');
                $order->setManagerid($manager->getId());
            } else {
                $comment = 'Ответственный удален.';
                $order->setManagerid(0);
            }

            // сбрасываем приоритет
            $order->setPriority(0);

            $order->update();

            // делаем запись в комментарий
            $this->addOrderChange($order, $user, $comment);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить имя заказа.
     * $user - это кто меняет, может быть false.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param String $name
     */
    public function updateOrderName(ShopOrder $order, $user, $name) {
        // проверка
        if ($order->getName() == $name) {
            return false;
        }

        try {
            SQLObject::TransactionStart();

            if ($name) {
                $comment = 'Имя заказа изменено на '.$name;
            } else {
                $comment = 'Имя заказа удалено.';
            }

            $order->setName($name);
            $order->update();

            // делаем запись в комментарий
            $this->addOrderChange($order, $user, $comment);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить клиента/поставщика заказа.
     * $user - это кто меняет, может быть false.
     * $client - на кого меняем, тоже может быть false
     *
     * @param ShopOrder $order
     * @param User $user
     * @param User $client
     */
    public function updateOrderUser(ShopOrder $order, $user, $client) {
        // проверка
        if ($client) {
            if ($client->getId() == $order->getUserid()) {
                return false;
            }
        } elseif (!$order->getUserid()) {
            return false;
        }

        try {
            SQLObject::TransactionStart();

            if ($client) {
                $comment = (($order->getOutcoming()) ? 'Поставщик' : 'Клиент').
                           ' изменен на '.$client->makeName(false, 'lfm').'.';

                $order->setUserid($client->getId());

                // issue #48522 - source from user
                if (!$order->getSourceid()) {
                    $order->setSourceid($client->getSourceid());
                }

                // issue #48710 - обновляем поля
                if ($client->getContractorid()) {
                    $order->setContractorid($client->getContractorid());
                }
                /*if ($client->getManagerid()) {
                    Shop::Get()->getShopService()->updateOrderManager(
                        $order,
                        $user,
                        $client
                    );
                }*/

                // issue #37125
                $order->setClientname($client->makeName(false));
                $order->setClientaddress($client->getAddress());
                $order->setClientphone($client->getPhone());
                $order->setClientemail($client->getEmail());
            } else {
                $comment = (($order->getOutcoming()) ? 'Поставщик' : 'Клиент').' удален.';
                $order->setUserid(0);
            }

            $order->update();

            // делаем запись в комментарий
            $this->addOrderChange($order, $user, $comment);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Изменить дату и время выполнения заказа.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $dateto
     */
    public function updateOrderDateto(ShopOrder $order, $user, $dateto, $noComment = false) {
        if ($dateto) {
            $dateto = DateTime_Formatter::DateTimeISO9075($dateto);
        }

        if ($dateto == $order->getDateto()) {
            return false;
        }

        try {
            SQLObject::TransactionStart();

            if (Checker::CheckDate($dateto)) {
                $dateto = DateTime_Formatter::DateTimeISO9075($dateto);
                $comment = 'Дата выполнения задачи перенесена на '.$dateto;
            } else {
                $dateto = false;
                $comment = 'Дата выполнения задачи удалена.';
            }

            $order->setDateto($dateto);
            $order->update();

            // делаем запись в комментарий
            if (!$noComment) {
                $this->addOrderChange($order, $user, $comment);
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Изменить дату и время И менеджера выполнения этапа.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $dateto
     */
    public function updateOrderEmployer(
        ShopOrder $order, ShopOrderStatus $status, User $user, $dateto, $manager, $noComment = false
    ) {

        $commentDate = true;
        $oldDate = '0000-00-00 00:00:00';

        // обновляем этап
        $employer = new ShopOrderEmployer();
        $employer->setOrderid($order->getId());
        $employer->setStatusid($status->getId());
        $employer = $employer->getNext();
        if ($employer) {

            $oldDate = $employer->getTerm();

            if (DateTime_Object::FromString($employer->getTerm())->__toString() ==
                DateTime_Object::FromString($dateto)->__toString()
            ) {
                $commentDate = false;
            }

            $employer->setTerm($dateto);
            $employer->setManagerid($manager);
            $employer->update();
        } elseif (($dateto && $dateto != '0000-00-00 00:00:00') || $manager) {
            if (!$dateto || $dateto == '0000-00-00 00:00:00') {
                $commentDate = false;
            }
            $employer = new ShopOrderEmployer();
            $employer->setOrderid($order->getId());
            $employer->setStatusid($status->getId());
            $employer->setTerm($dateto);
            $employer->setManagerid($manager);
            $employer->insert();
        } else {
            $commentDate = false;
        }

        if ($commentDate) {
            if (Checker::CheckDate($dateto)) {
                $dateto = DateTime_Formatter::DateTimeISO9075($dateto);
                $comment = 'Дата выполнения этапа "'.$order->getStatus()->getName().'" перенесена на '.$dateto;
            } else {
                $comment = 'Дата выполнения этапа "'.$order->getStatus()->getName().'" удалена.';
            }

            // делаем запись в комментарий
            if (!$noComment) {
                $this->addOrderChange($order, $user, $comment);
            }
        }


        if ($employer) {
            $event = Events::Get()->generateEvent('shopOrderEmployerUpdateAfter');
            $event->setOrder($order);
            $event->setEmployer($employer);
            $event->setEmployerOldDate($oldDate);
            $event->notify();
        }

    }


    /**
     * Обновить категорию (БП) заказа
     *
     * @param ShopOrder $order
     * @param User $user
     * @param ShopOrderCategory $category
     *
     * @todo добавить вызов updateOrderStatus ?
     */
    public function updateOrderCategory(ShopOrder $order, $user, ShopOrderCategory $category) {
        // проверка
        if ($category->getId() == $order->getCategoryid()) {
            return false;
        }

        try {
            SQLObject::TransactionStart();

            // ставим первый статус из этого workflow'a
            $status1 = $category->getStatusDefault();

            $order->setCategoryid($category->getId());
            $order->setIssue(($category->getType() == 'issue' || $category->getType() == 'project'));
            $order->setType($category->getType());
            $order->setOutcoming($category->getOutcoming());
            $order->update();

            $comment = 'Бизнес-процесс изменен на '.$category->getName().'.';

            // делаем запись в комментарий
            $this->addOrderChange($order, $user, $comment);

            Shop::Get()->getShopService()->updateOrderStatus($user, $order, $status1->getId());

            SQLObject::TransactionCommit();

            return true;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить категорию (бизнес-процесс)
     *
     * @param int $id
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getOrderCategoryByID($id) {
        return WorkflowService::Get()->getWorkflowByID($id);
    }

    /**
     * Получить категорию (бизнес-процесс)
     *
     * @param int $id
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getWorkflowByID($id) {
        return WorkflowService::Get()->getWorkflowByID($id);
    }

    /**
     * Получить все категории (бизнес-процессы)
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getOrderCategoryAll() {
        return WorkflowService::Get()->getWorkflowsAll();
    }

    /**
     * Получить все workflow
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getWorkflowsAll($user = false, $currentWorkflowID = false) {
        return WorkflowService::Get()->getWorkflowsAll($user, $currentWorkflowID);
    }

    /**
     * Получить все активные workflow
     *
     * @return ShopOrderCategory
     *
     * @deprecated
     */
    public function getWorkflowsActive($user = false) {
        return WorkflowService::Get()->getWorkflowsActive($user);
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
     * Экспортировать все бренды в XML и JSON.
     * Метод запускается в cron hour и нужен для интеграции с системами типа 1С.
     */
    public function exportBrands() {
        $host = Engine::Get()->getProjectURL();
        $cdate = date('Y-m-d H:i:s');

        $a = array();
        $brand = $this->getBrandsAll();
        while ($x = $brand->getNext()) {
            $image = $x->getImage();
            if (!Checker::CheckImageFormat(PackageLoader::Get()->getProjectPath().'/media/shop/'.$image)) {
                $image = false;
            }

            $a[] = array(
            'id' => $x->getId(),
            'name' => $x->getName(),
            'hidden' => $x->getHidden(),
            'description' => $x->getDescription(),
            'image' => $image ? $host.'/media/shop/'.$image : false,
            'wdate' => $cdate,
            );
        }

        $path = PackageLoader::Get()->getProjectPath().'/media/export/product/';

        file_put_contents($path.'brand.json', json_encode($a), LOCK_EX);

        PackageLoader::Get()->import('XML');
        $xml = XML_Creator::CreateFromArray(array('brand' => $a))->__toString();
        file_put_contents($path.'brand.xml', $xml, LOCK_EX);
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
     * Обновить настройки статуса
     *
     * @param ShopOrderStatus $status
     * @param string $name
     * @param string $description
     * @param string $term
     * @param unknown_type $period
     * @param string $roleID
     * @param unknown_type $managerID
     * @param unknown_type $jumpManager
     * @param string $colour
     * @param bool $onlyauto
     * @param unknown_type $onlyIssue
     * @param bool $notify_sms_client
     * @param bool $notify_sms_admin
     * @param bool $notify_sms_manager
     * @param bool $notify_email_client
     * @param bool $notify_email_admin
     * @param bool $notify_email_manager
     * @param bool $need_payment
     * @param bool $need_prepayment
     * @param bool $need_content
     * @param bool $need_document
     * @param bool $closed
     * @param bool $saled
     * @param bool $shipped
     * @param unknown_type $createXml
     * @param unknown_type $createCsv
     *
     * @todo
     */
    public function editStatus(ShopOrderStatus $status, $name,
    $description, $term, $period, $roleID, $managerID, $jumpManager,
    $colour, $onlyauto,
    $onlyIssue, $notify_sms_client, $notify_sms_admin, $notify_sms_manager,
    $notify_email_client, $notify_email_admin, $notify_email_manager,
    $need_payment, $need_prepayment, $need_content, $need_document,
    $done, $closed, $saled, $shipped, $orderSupplier,
    $createXml = false, $createCsv = false
    ) {
        try {
            SQLObject::TransactionStart();

            $name = trim(htmlspecialchars($name));
            $description = trim($description);

            $status->setName($name);
            $status->setContent($description);
            $status->setTerm($term);
            $status->setTermperiod($period);
            $status->setRoleid($roleID);
            $status->setManagerid($managerID);
            $status->setJumpmanager($jumpManager);
            $status->setColour($colour);
            $status->setOnlyauto($onlyauto);
            $status->setOnlyissue($onlyIssue);
            $status->setNotifysmsclient($notify_sms_client);
            $status->setNotifysmsadmin($notify_sms_admin);
            $status->setNotifysmsmanager($notify_sms_manager);
            $status->setNotifyemailclient($notify_email_client);
            $status->setNotifyemailadmin($notify_email_admin);
            $status->setNotifyemailmanager($notify_email_manager);
            $status->setPayed($need_payment);
            $status->setPrepayed($need_prepayment);
            $status->setNeedcontent($need_content);
            $status->setNeeddocument($need_document);
            $status->setDone($done);
            $status->setClosed($closed);
            $status->setSaled($saled);
            $status->setShipped($shipped);
            $status->setCreateOrderSupplier(0);
            $status->setCancelOrderSupplier(0);
            if ($orderSupplier == 'create') {
                $status->setCreateOrderSupplier(1);
            } elseif ($orderSupplier == 'cancel') {
                $status->setCancelOrderSupplier(1);
            }
            $status->setCreateXml($createXml);
            $status->setCreateCsv($createCsv);
            $status->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Закрыть задачу.
     * Метод находит закрывающий статус и переключает задачу в нее.
     *
     * @param ShopOrder $issue
     *
     * @return bool
     */
    function closeOrder(ShopOrder $issue, User $user = null) {
        if ($issue->isClosed()) {
            return false;
        }

        $statusClosed = $issue->getWorkflow()->getStatusClosed();

        if (!$user) {
            $user = Shop::Get()->getUserService()->getUserSecure();
        }

        Shop::Get()->getShopService()->updateOrderStatus(
            $user,
            $issue,
            $statusClosed->getId()
        );

        return true;
    }

    /**
     * Копирует задачу
     *
     * @param ShopOrder $order
     *
     * @return ShopOrder
     */
    public function cloneOrder (ShopOrder $order) {
        try{
            $author = $order->getAuthor();
            $newOrder = Shop::Get()->getShopService()->addOrder(
                $author,
                $order->getName(),
                $order->getComments(),
                $order->getManagerid(),
                $order->getCategoryid(),
                false,
                $order->getUserid(),
                $order->getParentid()
            );

            $newOrder->setClientmanagerid($order->getClientmanagerid());
            $newOrder->setClientname($order->getClientname());
            $newOrder->setClientemail($order->getClientemail());
            $newOrder->setClientphone($order->getClientphone());
            $newOrder->setClientaddress($order->getClientaddress());
            $newOrder->setClientcontacts($order->getClientcontacts());
            $newOrder->setCurrencyid($order->getCurrencyid());
            $newOrder->setDeliveryid($order->getDeliveryid());
            $newOrder->setDeliveryprice($order->getDeliveryprice());
            $newOrder->setPaymentid($order->getPaymentid());
            $newOrder->setDiscountid($order->getDiscountid());
            $newOrder->setContractorid($order->getContractorid());
            $newOrder->setSourceid($order->getSourceid());
            $newOrder->setIssue($order->getIssue());
            $newOrder->setOutcoming($order->getOutcoming());
            $newOrder->setParentid($order->getPaymentid());
            $newOrder->setParentstatusid($order->getParentstatusid());
            $newOrder->setResource($order->getResource());
            $newOrder->setEstimate($order->getEstimate());
            $newOrder->setMoney($order->getMoney());
            $newOrder->setForgift($order->getForgift());
            $newOrder->setSend_mail_comment($order->getSend_mail_comment());
            $newOrder->setType($order->getType());
            $newOrder->update();

            Shop::Get()->getShopService()->updateOrderStatus(
                $author,
                $newOrder,
                $newOrder->getStatusid()
            );

            return $newOrder;
        } catch (Exception $ue) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

    }

    /**
     * Получить все источники
     *
     * @return ShopSource
     */
    public function getSourceAll() {
        $x = $this->getObjectsAll('ShopSource');
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить источники по ID
     *
     * @return ShopSource
     */
    public function getSourceByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopSource');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('ShopSource by id not found');
    }

    /**
     * Получить источник по адресу (каналу)
     *
     * @param string $address
     *
     * @return ShopSource
     */
    public function getSourceByAddress($address) {
        try {
            return $this->getObjectByField('address', $address, 'ShopSource');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('ShopSource by address not found');
    }

    /**
     * Добавить источник или вернуть источник, если таковой уже имеется.
     *
     * @param string $name
     * @param string $address
     *
     * @return ShopSource
     */
    public function addSource($name, $address = false) {
        $name = trim($name);
        if (!$name) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            $source = new ShopSource();
            $source->setName($name);
            if (!$source->select()) {
                if ($address) {
                    $source->setAddress($address);
                }
                $source->insert();
            }

            SQLObject::TransactionCommit();

            return $source;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Разрешено ли пользователю просматривать заказ
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return bool
     */
    public function isOrderViewAllowed(ShopOrder $order, User $user) {
        $type = $order->getType();
        if (!$type || $type == 'order') {
            $type = 'orders';
        }

        // проверка на родительскую задачу
        try {
            if ($order->getId() != $order->getParentid() &&
            $this->isOrderViewAllowed($order->getParent(), $user)) {
                return true;
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        // умный ACL
        $smartACL = !Engine::Get()->getConfigFieldSecure('acl-smart-disabled');

        if ($smartACL) {
            // свои заказы видно всегда
            if ($order->getAuthorid() == $user->getId()
            || $order->getManagerid() == $user->getId()
            ) {
                return true;
            }

            if (!Engine::Get()->getConfigFieldSecure('acl-smart-employer-disabled')) {
                // проверка, является ли он участником заказа
                $oes = new XShopOrderEmployer();
                $oes->setOrderid($order->getId());
                $oes->setManagerid($user->getId());
                if ($oes->select()) {
                    return true;
                }
            }

        }

        if ($user->isDenied($type)) {
            $aclName = Shop::Get()->getAclService()->getNameByKey($type);
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - '.$type
                ),
                'acl'
            );

            return false;
        }

        if ($user->isAllowed($type.'-all-view')) {
            return true;
        }

        if ($type == 'orders') {
            if ($order->getOutcoming()) {
                if ($user->isDenied('orders-direction-out')) {
                    $aclName = Shop::Get()->getAclService()->getNameByKey('orders-direction-out');
                    LogService::Get()->add(
                        array(
                            'url' => Engine_URLParser::Get()->getCurrentURL(),
                            'user #'.$user->getId(),
                            'Acl: '.$aclName.' - orders-direction-out'
                        ),
                        'acl'
                    );

                    return false;
                }
            } else {
                if ($user->isDenied('orders-direction-in')) {
                    $aclName = Shop::Get()->getAclService()->getNameByKey('orders-direction-in');
                    LogService::Get()->add(
                        array(
                            'url' => Engine_URLParser::Get()->getCurrentURL(),
                            'user #'.$user->getId(),
                            'Acl: '.$aclName.' - orders-direction-in'
                        ),
                        'acl'
                    );

                    return false;
                }
            }
        }

        if ($user->isDenied($type.'-status-all-view')) {
            if ($user->isDenied($type.'-status-'.$order->getStatusid().'-view')) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-status-'.$order->getStatusid().'-view'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' - '.$type.'-status-'.$order->getStatusid().'-view'
                    ),
                    'acl'
                );

                return false;
            }
        }

        if ($user->isDenied($type.'-manager-all-view')) {
            if ($user->isDenied($type.'-manager-'.$order->getAuthorid().'-view')
            && $user->isDenied($type.'-manager-'.$order->getManagerid().'-view')
            ) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-manager-'.$order->getAuthorid().'-view'
                );
                $aclName2 = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-manager-'.$order->getManagerid().'-view'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' & '.$aclName2.' - '.$type.'-manager-'.
                        $order->getAuthorid().'-view & '.$type.'-manager-'.$order->getManagerid().'-view'
                    ),
                    'acl'
                );

                return false;
            }
        }

        if ($user->isDenied($type.'-category-all-view')) {
            if ($user->isDenied($type.'-category-'.$order->getCategoryid().'-view')) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-category-'.$order->getCategoryid().'-view'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' - '.$type.'-category-'.$order->getCategoryid().'-view'
                    ),
                    'acl'
                );

                return false;
            }
        }

        return true;
    }

    /**
     * Разрешено ли пользователю управлять заказом
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return bool
     */
    public function isOrderChangeAllowed(ShopOrder $order, User $user) {
        $type = $order->getType();
        if (!$type || $type == 'order') {
            $type = 'orders';
        }

        // проверка на родительскую задачу
        try {
            if ($order->getId() != $order->getParentid() &&
            $this->isOrderChangeAllowed($order->getParent(), $user)) {
                return true;
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        // умный ACL
        $smartACL = !Engine::Get()->getConfigFieldSecure('acl-smart-disabled');

        if ($smartACL) {
            // свои заказы видно всегда
            if ($order->getAuthorid() == $user->getId()
            || $order->getManagerid() == $user->getId()
            ) {
                return true;
            }

            if (!Engine::Get()->getConfigFieldSecure('acl-smart-employer-disabled')) {
                // проверка, является ли он участником заказа
                $oes = new XShopOrderEmployer();
                $oes->setOrderid($order->getId());
                $oes->setManagerid($user->getId());
                if ($oes->select()) {
                    return true;
                }
            }
        }

        if ($user->isDenied($type)) {
            $aclName = Shop::Get()->getAclService()->getNameByKey($type);
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - '.$type
                ),
                'acl'
            );

            return false;
        }

        if ($user->isAllowed($type.'-all-edit')) {
            return true;
        }

        if ($type == 'orders') {
            if ($order->getOutcoming()) {
                if ($user->isDenied('orders-direction-out')) {
                    $aclName = Shop::Get()->getAclService()->getNameByKey('orders-direction-out');
                    LogService::Get()->add(
                        array(
                            'url' => Engine_URLParser::Get()->getCurrentURL(),
                            'user #'.$user->getId(),
                            'Acl: '.$aclName.' - orders-direction-out'
                        ),
                        'acl'
                    );

                    return false;
                }
            } else {
                if ($user->isDenied('orders-direction-in')) {
                    $aclName = Shop::Get()->getAclService()->getNameByKey('orders-direction-in');
                    LogService::Get()->add(
                        array(
                            'url' => Engine_URLParser::Get()->getCurrentURL(),
                            'user #'.$user->getId(),
                            'Acl: '.$aclName.' - orders-direction-in'
                        ),
                        'acl'
                    );

                    return false;
                }
            }
        }

        if ($user->isDenied($type.'-status-all-change')) {
            if ($user->isDenied($type.'-status-'.$order->getStatusid().'-change')) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-status-'.$order->getStatusid().'-change'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' - '.$type.'-status-'.$order->getStatusid().'-change'),
                    'acl'
                );

                return false;
            }
        }

        if ($user->isDenied($type.'-manager-all-change')) {
            if ($user->isDenied($type.'-manager-'.$order->getAuthorid().'-change')
            && $user->isDenied($type.'-manager-'.$order->getManagerid().'-change')
            ) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-manager-'.$order->getAuthorid().'-change'
                );
                $aclName2 = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-manager-'.$order->getManagerid().'-change'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' & '.$aclName2.' - '.$type.'-manager-'.
                        $order->getAuthorid().'-change & '.$type.'-manager-'.$order->getManagerid().'-change'
                    ),
                    'acl'
                );

                return false;
            }
        }

        if ($user->isDenied($type.'-category-all-change')) {
            if ($user->isDenied($type.'-category-'.$order->getCategoryid().'-change')) {
                $aclName = Shop::Get()->getAclService()->getNameByKey(
                    $type.'-category-'.$order->getCategoryid().'-change'
                );
                LogService::Get()->add(
                    array(
                        'url' => Engine_URLParser::Get()->getCurrentURL(),
                        'user #'.$user->getId(),
                        'Acl: '.$aclName.' - '.$type.'-category-'.$order->getCategoryid().'-change'
                    ),
                    'acl'
                );

                return false;
            }
        }

        return true;
    }

    /**
     * Получить все баннера
     *
     * @return ShopBanner
     *
     * @deprecated
     */
    public function getBannerByID($id) {
        ModeService::Get()->debug('calling deprecated method getBannerByID!');
        return Shop::Get()->getBannerService()->getBannerByID($id);
    }

    /**
     * Получить все банера
     *
     * @return ShopBanner
     *
     * @deprecated
     */
    public function getBannerAll() {
        ModeService::Get()->debug('calling deprecated method getBannerAll!');
        return Shop::Get()->getBannerService()->getBannerAll();
    }

    /**
     * Получить все бренды
     *
     * @return ShopBrand
     */
    public function getBrandsAll() {
        $x = new ShopBrand();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить популярные бренды
     *
     * @return ShopBrand
     */
    public function getBrandsTop() {
        $x = $this->getBrandsAll();
        $x->setTop(1);
        return $x;
    }

    /**
     * Получить иконку по ID
     *
     * @return ShopProductIcon
     */
    public function getProductIconByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProductIcon');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
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
     * Дерево-массив объектов ShopCategory
     *
     * @param int $rootID
     *
     * @return array
     */
    public function makeCategoryTree($rootID = 0) {
        $category = $this->getCategoryAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = $x;
        }

        return $this->_makeCategoryTree($rootID, 0, $a);
    }

    private function _makeCategoryTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            // хитро дописываем поле level
            $x->setField('level', $level);

            $a[] = $x;
            $childs = $this->_makeCategoryTree($x->getId(), $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

    /**
     * Построить дерево задач начиная от нужного корня
     *
     * @param User $user
     * @param int $rootID
     *
     * @return array
     */
    public function makeOrderTreeArray($user = false, $rootID = 0) {
        // сначала рекурсивно получаем все внутренние IDшники
        $idArray = $this->_makeOrderTreeIDs($user, $rootID);
        $idArray[] = -1;

        $orders = $this->getOrdersAll($user, true);

        $orders->addWhereArray($idArray, 'id');

        $a = array();
        while ($x = $orders->getNext()) {
            $a[$x->getParentid()][] = $x;
        }

        return $this->_makeOrderTree($rootID, 0, $a);
    }

    private function _makeOrderTreeIDs($user, $rootID, $orders = false) {
        if (!$orders) {
            $orders = $this->getOrdersAll($user, true);
        }
        $ordersClone = clone $orders;
        $orders->setParentid($rootID);
        $a = array();
        while ($x = $orders->getNext()) {
            if ($x->getId() == $rootID) {
                continue;
            }

            $a[] = $x->getId();

            $tmp = $this->_makeOrderTreeIDs($user, $x->getId(), $ordersClone);
            foreach ($tmp as $tmpID) {
                if (in_array($tmpID, $a)) {
                    continue;
                }
                $a[] = $tmpID;
            }
        }
        return $a;
    }

    private function _makeOrderTree($parentID, $level, $orderArray) {
        $a = array();
        if (empty($orderArray[$parentID])) {
            return $a;
        }
        foreach ($orderArray[$parentID] as $x) {
            // пожалуйста, даже если вы не понимаете что значит эта безумная
            // строка - не удаляйте ее! Это не прикол!
            // Клонирование объекта нужно для того, чтобы в SQLObject Pool
            // осталась старая версия объекта. Потому что если дописать не существующее
            // поле level, то потом с этим объектом ничего нельзя сделать в базе -
            // ни вставить, ни удалить, ни изменить.
            $x = clone $x;

            // хитро дописываем поле level
            $x->setField('level', $level);

            $a[] = $x;

            $childs = $this->_makeOrderTree($x->getId(), $level + 1, $orderArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
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
     * Добавить значение фильтра
     *
     * @param ShopProduct $product
     * @param $filterId
     * @param $filterValue
     * @param $filterUse
     * @param $filterActual
     * @param $filterOption
     * @param $filterMarkup
     *
     * @return XShopProductFilterValue
     *
     * @throws SQLObject_Exception
     */
    public function addProductFilterValue (ShopProduct $product, $filterId, $filterValue, $filterUse,
                                           $filterActual, $filterOption, $filterMarkup
    ) {
        $filterMarkup = floatval(str_replace(',', '.', $filterMarkup));

        $filter = new XShopProductFilterValue();
        $filter->setProductid($product->getId());
        $filter->setFilterid($filterId);
        $filter->setFiltervalue($filterValue);

        if ($filter->select()) {
            $filter->setFilteruse($filterUse);
            $filter->setFilteractual($filterActual);
            $filter->setFilteroption($filterOption);
            $filter->setFiltermarkup($filterMarkup);

            $filter->update();
        } else {
            $filter->setFilteruse($filterUse);
            $filter->setFilteractual($filterActual);
            $filter->setFilteroption($filterOption);
            $filter->setFiltermarkup($filterMarkup);

            $filter->insert();
        }

        return $filter;
    }

    /**
     * Получить все фильтра для продукта
     *
     * @param ShopProduct $product
     *
     * @return XShopProductFilterValue
     */
    public function getProductFilterValues (ShopProduct $product) {
        $filter = new XShopProductFilterValue();
        $filter->setProductid($product->getId());
        $filter->addWhere('filterid', '0', '>');
        $filter->setOrder('id');

        return $filter;
    }

    /**
     * Получить максимальное количество фильтров у товаров
     *
     * @return int
     *
     * @throws ConnectionManager_Exception
     */
    public function getProductFilterValueMaxCount() {
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $sql = "SELECT `productid`, COUNT(`productid`) AS cnt
            FROM `shopproductfiltervalue` GROUP BY `productid` ORDER BY `cnt` DESC";
        $q = $connection->query($sql);
        $r = $connection->fetch($q);
        return (int) $r['cnt'];
    }

    /**
     * Полностью обновит фильтра товару
     *
     * @param ShopProduct $product
     * @param $arr
     * @param bool $deleted
     *
     * @throws Exception
     */
    public function updateProductFilterData (ShopProduct $product, $arr, $deleted = true) {
        try {
            SQLObject::TransactionStart();

            // проверка массива на повторение данных
            $arrDublicateTmp = array();
            foreach ($arr as $arrKey => $arrValue) {
                $filterId = $arrValue['filterId'];
                $filterValue = $arrValue['filterValue'];

                if (!$filterId) {
                    unset($arr[$arrKey]);
                    continue;
                }

                if (array_key_exists($filterId, $arrDublicateTmp) && $arrDublicateTmp[$filterId] == $filterValue) {
                    unset($arr[$arrKey]);
                    continue;
                }

                $arrDublicateTmp[$filterId] = $filterValue;
            }

            // затираем старые значения невалидными, что бы не было дубликатов
            $filters = $this->getProductFilterValues($product);

            $index = 0;
            $key = md5(time());
            while ($filterObj = $filters->getNext()) {
                $filterObj->setFiltervalue($index.$key);
                $filterObj->update();
                $index++;
            }

            // перебираем и обновляем все старые значения, если их больше чем надо, лишнее удалятся
            $filters = $this->getProductFilterValues($product);

            $index = 0;
            while ($x = $filters->getNext()) {
                if ($x->getFilterid() < 0) {
                    continue;
                }
                $dataArray = @$arr[$index];
                $filterId = @$dataArray['filterId'];

                try {
                    Shop::Get()->getShopService()->getProductFilterByID($filterId);

                    $x->setFilterid($filterId);
                    $x->setFiltervalue(@$dataArray['filterValue']);
                    $x->setFilteruse(@$dataArray['filterUse']);
                    $x->setFilteractual(@$dataArray['filterActual']);
                    $x->setFilteroption(@$dataArray['filterOption']);
                    $x->setFiltermarkup(@$dataArray['filterMarkup']);

                    $x->update();
                } catch (Exception $e) {
                    if ($deleted) {
                        $x->delete();
                    }
                }

                unset($arr[$index]);
                $index++;
            }

            // здесь перебор всех значений, которым не хватило уже сществующих filtervalue
            foreach ($arr as $dataArray) {
                try {
                    $filterId = $dataArray['filterId'];

                    Shop::Get()->getShopService()->getProductFilterByID($filterId);
                    $filterMarkup = $dataArray['filterMarkup'];

                    $filterMarkup = floatval(str_replace(',', '.', $filterMarkup));

                    $filter = new XShopProductFilterValue();
                    $filter->setProductid($product->getId());

                    $filter->setFilterid($filterId);
                    $filter->setFiltervalue($dataArray['filterValue']);
                    $filter->setFilteruse($dataArray['filterUse']);
                    $filter->setFilteractual($dataArray['filterActual']);
                    $filter->setFilteroption($dataArray['filterOption']);
                    $filter->setFiltermarkup($filterMarkup);

                    $filter->insert();
                } catch (Exception $efilter) {

                }
            }

            SQLObject::TransactionCommit();

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить список товаров по его ID
     *
     * @return ShopProductList
     */
    public function getProductsListByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopProductList');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('ShopProductList by id not found');
    }

    /**
     * Получить список товаров по его ключу linkkey
     *
     * @return ShopProductList
     */
    public function getProductsListByLinkKey($linkkey) {
        if ($linkkey) {
            try {
                return $this->getObjectByField('linkkey', $linkkey, 'ShopProductList', false);
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
        throw new ServiceUtils_Exception('ShopProductList by linkkey not found');
    }

    /**
     * Получение всех списков товаров
     *
     * @return ShopProductList
     */
    public function getProductsListAll() {
        $x = new ShopProductList();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить товары в указанном списке
     *
     * @param ShopProductList $list
     *
     * @return ShopProduct
     */
    public function getProductsInList(ShopProductList $list) {
        $logicclass = $list->getLogicclass();

        if ($logicclass && class_exists($logicclass)) {
            // получаем товары из smart-списка
            $object = new $logicclass();
            $products = $object->getProducts();
        } else {
            // просто получаем товары из списка
            $a = array(0);
            $links = new XShopProduct2List();
            $links->setListid($list->getId());

            // строим массив IDшников товаров
            while ($x = $links->getNext()) {
                $a[] = $x->getProductid();
            }

            $products = $this->getProductsAll();
            $products->addWhereArray($a);

            if ($products->getCount() == 0) {
                $products->clearWhere();
                $products->addWhereArray($a, 'code1c');
            }
        }

        return $products;
    }

    /**
     * Занести изменения товара в таблицу shopproductchange.
     *
     * @param ShopProduct $product
     */
    public function addProductChange(ShopProduct $product) {
        $tmp = new ShopProduct($product->getId());
        $oldValueArray = $tmp->getValues();

        try {
            $userID = Shop::Get()->getUserService()->getUser()->getId();
        } catch (Exception $e) {
            $userID = 0;

            return;
        }

        $date = date('Y-m-d H:i:s');

        foreach ($oldValueArray as $fieldName => $fieldValueOld) {
            if ($fieldName == 'udate') {
                continue;
            }

            if ($fieldName == 'viewed') {
                continue;
            }

            $fieldValueNew = $product->getField($fieldName);

            if ($fieldValueOld == $fieldValueNew) {
                continue;
            }

            if (!$fieldValueOld && !$fieldValueNew) {
                continue;
            }

            $x = new XShopProductChange();
            $x->setProductid($product->getId());
            $x->setUserid($userID);
            $x->setCdate($date);
            $x->setKey($fieldName);
            $x->setValueold($fieldValueOld);
            $x->setValuenew($fieldValueNew);
            $x->insert();
        }
    }

    /**
     * Проверить на добавление продукта в связанное к самому себе
     * @param ShopProduct $product
     * @param array $codes
     */
    public function checkProductRelatedDuplicate(ShopProduct $product, $codes) {
        if (preg_match_all("/([\d\w]+)/ius", $codes, $r)) {
            foreach ($r[1] as $code) {
                try {
                    // поиск товара по коду
                    $useCode1c = Shop::Get()->getSettingsService()->getSettingValue('use-code-1c');
                    if ($useCode1c) {
                        try {
                            $productInRelated = Shop::Get()->getShopService()->getProductByCode1c($code);
                        } catch (Exception $e) {
                            $productInRelated = Shop::Get()->getShopService()->getProductByID($code);
                        }
                    } else {
                        $productInRelated = Shop::Get()->getShopService()->getProductByID($code);
                    }
                    if ($productInRelated->getId() == $product->getId()) {
                        $ex = new ServiceUtils_Exception();
                        $ex->addError('duplicate');
                        throw $ex;
                    }

                } catch (ServiceUtils_Exception $ex) {
                    throw $ex;
                }
            }
        }
    }


    /**
     * Добавить товары в список
     *
     * @param ShopProductList $list
     * @param string $codes
     */
    public function addProductsToList(ShopProductList $list, $codes) {
        try {
            SQLObject::TransactionStart();

            $cnt = 0;
            if (preg_match_all("/([\d\w]+)/ius", $codes, $r)) {
                foreach ($r[1] as $code) {
                    try {
                        // поиск товара по коду
                        $useCode1c = Shop::Get()->getSettingsService()->getSettingValue('use-code-1c');
                        if ($useCode1c) {
                            try{
                                $product = Shop::Get()->getShopService()->getProductByCode1c($code);
                            } catch ( Exception $e )
                            {
                                $product = Shop::Get()->getShopService()->getProductByID($code);
                            }
                        } else {
                            $product = Shop::Get()->getShopService()->getProductByID($code);
                        }
                        // добовляем товар в список
                        $x = new XShopProduct2List();
                        $x->setListid($list->getId());
                        $x->setProductid($product->getId());
                        if (!$x->select()) {
                            $x->insert();
                        }
                        $cnt ++;
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }
            }

            if (!$cnt) {
                throw new ServiceUtils_Exception();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить товары из списка
     *
     * @param ShopProductList $list
     * @param string $codes
     */
    public function deleteProductsFromList(ShopProductList $list, $codes) {
        try {
            SQLObject::TransactionStart();

            $cnt = 0;
            if (preg_match_all("/([\d\w]+)/ius", $codes, $r)) {
                foreach ($r[1] as $code) {
                    try {
                        // поиск товара по коду
                        $product = Shop::Get()->getShopService()->getProductByID($code);

                        // удаляем товар из списка
                        $x = new XShopProduct2List();
                        $x->setListid($list->getId());
                        $x->setProductid($product->getId());
                        if ($x->select()) {
                            // если список - это связанные товары, то помечаем что больше
                            // не добавлять из общих заказов
                            if (preg_match('#product-(\d+?)-related#', $list->getLinkkey(), $r)) {
                                if (!empty($r[1])) {
                                    $z = new XProduct2OrderedProduct();
                                    $z->filterProductid($r[1]);
                                    $z->filterOrderedproductid($product->getId());
                                    if ($z->select()) {
                                        $z->setDeleted(1);
                                        $z->update();
                                    }
                                }
                            }

                            $x->delete();
                        }
                        $cnt ++;
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }
            }

            if (!$cnt) {
                throw new ServiceUtils_Exception();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить топ-товары
     *
     * @todo а нафиг он уже?
     *
     * @return ShopProduct
     */
    public function getProductsTop() {
        $x = $this->getProductsAll();
        $x->setTop(1);
        $x->setHidden(0);
        return $x;
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
     * Получить товары с актуальным сроком жизни
     *
     * @param ShopProduct $products
     *
     * @return ShopProduct
     */
    public function setProductsDateLifeFilter($products) {
        $dateNow = date('Y-m-d');
        $products->addWhereQuery('(`datelifefrom` = \'0000-00-00\' OR DATE(`datelifefrom`) <= \''.$dateNow.'\' )');
        $products->addWhereQuery('(`datelifeto` = \'0000-00-00\' OR DATE(`datelifeto`) >= \''.$dateNow.'\' )');
        return $products;
    }

    /**
     * Получить группированные тоары
     *
     * @param ShopProduct $products
     *
     * @return string
     */
    public function getProductsGroup($products) {
        if ($groupby = Engine::Get()->getConfigFieldSecure('product-grouped')) {
            if (in_array($groupby, $products->getFields())) {
                return $groupby;
            }
        }
        return "seriesname";
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
     * горит ли задача (dateto) ?
     *
     * @param ShopOrder $order
     *
     * @return bool
     */
    public function isFireOrder (ShopOrder $order) {
        $fire = false;
        if ($order->getDateto() && $order->getDateto() !== '0000-00-00 00:00:00' && !$order->isClosed()) {
            if (strpos($order->getDateto(), '00:00:00') || $order->getDateto() == $order->getCdate()) {
                $a = DateTime_Object::FromString($order->getDateto())->setFormat('Y-m-d')->__toString();
                $b = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();

                if ($a < $b) {
                    $fire  = true;
                }
            } elseif ($order->getDateto() < DateTime_Object::Now()) {
                $fire  = true;
            }
        }
        return $fire;
    }

    /**
     * Горит ли этап задачи?
     *
     * @param ShopOrder $order
     *
     * @return bool
     */
    public function isFireOrderStatus (ShopOrder $order, ShopOrderStatus $status = null) {
        $fire = false;

        if ($order->isClosed()) {
            return false;
        }
        if (!$order->getStatusid()) {
            return false;
        }

        if ($status) {
            $statusId = $status->getId();
            if ($statusId != $order->getStatusid()) {
                // если этап пройден, то false
                $statusChange = new XShopOrderChange();
                $statusChange->setOrderid($order->getId());
                $statusChange->setValue($statusId);
                $statusChange->setKey('statusid');
                if ($statusChange->getNext()) {
                    return false;
                }
            }
        } else {
            $statusId = $order->getStatusid();
        }

        if (!$statusId) {
            return false;
        }

        if ($order->getStatusid() || $status) {
            $employer = new XShopOrderEmployer();
            $employer->setOrderid($order->getId());
            $employer->setStatusid($statusId);
            $employer->addWhere('term', '0000-00-00 00:00:00', '!=');
            while ($tmp = $employer->getNext()) {
                if (strpos($tmp->getTerm(), '00:00:00')) {
                    $a = DateTime_Object::FromString($tmp->getTerm())->setFormat('Y-m-d')->__toString();
                    $b = DateTime_Object::Now()->setFormat('Y-m-d')->__toString();

                    if ($a < $b) {
                        $fire  = true;
                    }
                } elseif ($tmp->getTerm() < DateTime_Object::Now()) {
                    $fire  = true;
                }
                break;
            }
        }
        return $fire;

    }

    /**
     * Делает замену в письме
     *
     * @param $order
     * @param $user
     * @param $text
     *
     * @return mixed
     */
    public function emailVariableReplace ($order, $user, $tpl) {
        $orderId = false;
        $contractorDetails = false;
        $orderCurrency = false;
        $company = false;
        $name = false;
        $nameMiddle = false;
        $orderName = false;
        $orderDateto = false;
        $orderSum = false;
        $orderCdate = false;
        $nameSmart = false;
        $nameFirst = false;
        $nameLast = false;

        if ($order) {
            $orderName = $order->makeName(false);
            $orderDateto = $order->getDateto();
            $orderSum = $order->makeSum();
            $orderCdate = $order->getCdate();
            $orderId = $order->getId();

            if ($orderDateto == '0000-00-00 00:00:00') {
                $orderDateto = false;
            }

            if ($orderCdate == '0000-00-00 00:00:00') {
                $orderCdate = false;
            }

            if ($orderDateto) {
                $orderDateto = DateTime_Object::FromString($orderDateto)->setFormat('Y-m-d')->__toString();
            }

            if ($orderCdate) {
                $orderCdate = DateTime_Object::FromString($orderCdate)->setFormat('Y-m-d')->__toString();
            }

            try {
                $orderCurrency = $order->getCurrency()->getSymbol();
            } catch (Exception $ecurrency) {

            }

            try {
                $contractor = Shop::Get()->getShopService()->getContractorByID($order->getContractorid());
                $contractorDetails = $contractor->getDetails();
            } catch (Exception $e) {

            }
        }

        if ($user) {
            $company = $user->getCompany();
            $name = $user->makeName();

            $nameFirst =  trim($user->getName());
            $nameLast = trim($user->getNamelast());
            $nameMiddle = trim($user->getNamemiddle());

            if ($user->getTypesex() == 'company') {
                $nameSmart = $company;
            } else {
                $nameSmart = trim($nameFirst.' '.$nameMiddle);
            }
        }

        $tpl = str_replace('[company]', $company, $tpl);
        $tpl = str_replace('[name]', $name, $tpl);
        $tpl = str_replace('[name_middle]', $nameMiddle, $tpl);
        $tpl = str_replace('[name_smart]', $nameSmart, $tpl);
        $tpl = str_replace('[name_first]', $nameFirst, $tpl);
        $tpl = str_replace('[name_last]', $nameLast, $tpl);
        $tpl = str_replace('[name_first_last]', $nameFirst.' '.$nameLast, $tpl);

        $tpl = str_replace('[contractordetails]', $contractorDetails, $tpl);

        $tpl = str_replace('[orderid]', $orderId, $tpl);
        $tpl = str_replace('[ordercurrency]', $orderCurrency, $tpl);
        $tpl = str_replace('[ordername]', $orderName, $tpl);
        $tpl = str_replace('[orderdateto]', $orderDateto, $tpl);
        $tpl = str_replace('[ordersum]', $orderSum, $tpl);
        $tpl = str_replace('[ordercdate]', $orderCdate, $tpl);


        // подстановка картинок [file-<ID>]
        $tpl = preg_replace_callback("/\[file-(\d+)\]/ius", array($this, '_fileImage'), $tpl);
        return $tpl;
    }

    /**
     * Заменить картинку (callback)
     *
     * @param array $x
     *
     * @return string
     */
    private function _fileImage($x) {
        $fileID = $x[1];
        try {
            $file = Shop::Get()->getFileService()->getFileByID($fileID);
            $url = Shop::Get()->getFileService()->makeFileURLByHash($file->getFile());
            return Engine::Get()->getProjectURL().$url;
        } catch (Exception $e) {
            return $fileID;
        }
    }

    /**
     * Получить продукты по всем доступным категориям
     *
     * @param ShopCategory $category
     *
     * @return ShopProduct
     */
    public function getProductsByCategoryIDArray($categoryIDArray) {
        $x = $this->getProductsAll();

        if (!$categoryIDArray) {
            $categoryIDArray = array(-1);
        }

        $a = array();
        for ($j = 1; $j <= 10; $j++) {
            $a[] = "category{$j}id IN (".implode(',', $categoryIDArray).")";
        }

        $x->addWhereQuery("(".implode(' OR ', $a).")");
        return $x;
    }

    /**
     * получить ближайшую категорию с фильтрами по умолчанию
     * @param ShopProduct $product
     * @return ShopCategory $category
     */
    private function _getCategoryWithFilterDefault(ShopProduct $product) {
        for ($i = 10; $i >= 1; $i--) {
            try {
                $categoryId = $product->getField('category' . $i . 'id');
                $category = Shop::Get()->getShopService()->getCategoryByID($categoryId);

                try {
                    $filter_count = Engine::Get()->getConfigField('filter_count');
                } catch (Exception $e) {
                    $filter_count = 10;
                }

                for ($j = 1; $j <= $filter_count; $j++) {

                    $filter = $category->getField('filter' . $j . 'id');
                    if ($filter) {
                        return $category;
                    }
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Проставить товару фильтры по умолчанию
     *
     * @param ShopProduct $product
     */
    public function updateProductFilterDefault(ShopProduct $product) {

        try {
            $filter_count = Engine::Get()->getConfigField('filter_count');
        } catch (Exception $e) {
            $filter_count = 10;
        }
        try {
            $category = $this->_getCategoryWithFilterDefault($product);

            for ($j = 1; $j <= $filter_count; $j++) {

                $filterId = $category->getField('filter' . $j . 'id');

                $filters = Shop::Get()->getShopService()->getProductFilterValues($product);
                $filters->setFilterid($filterId);
                if ($filters->getNext()) {
                    continue;
                }

                if (!(int) $filterId) {
                    continue;
                }

                Shop::Get()->getShopService()->addProductFilterValue($product, $filterId, false, 1, 1, false, 1);
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
    }

    /**
     * Получить товары по поставщику $supplierID.
     * Опция $exclusive = true позволяет выбрать товары, у которых
     * установлен этот поставщик по умолчанию.
     *
     * @param bool $exclusive
     * @param int $supplierID
     *
     * @return ShopProduct
     *
     * @deprecated
     */
    public function getProductsBySupplierID($supplierID, $exclusive = false) {
        return Shop::Get()->getSupplierService()->getProductsBySupplierID($supplierID, $exclusive);
    }

    /**
     * Получить все фильтра-характеристики
     *
     * @return ShopProductFilter
     */
    public function getProductFiltersAll() {
        $x = new ShopProductFilter();
        return $x;
    }

    /**
     * Получить фильтр-характеристику по его ID
     *
     * @return ShopProductFilter
     */
    public function getProductFilterByID($filterID) {
        return $this->getObjectByID($filterID, 'ShopProductFilter');
    }


    /**
     * Получить фильтр-характеристику по его ключу
     *
     * @return ShopProductFilter
     */
    public function getProductFilterByLinkkey($key) {
        return $this->getObjectByField('linkkey', $key, 'ShopProductFilter');
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
     * Получить товары юзера
     *
     * @param int $userID
     *
     * @return ShopProduct
     */
    public function getProductsUser($userID) {
        $user = Shop::Get()->getUserService()->getUserByID($userID);
        $x = $this->getProductsAll();
        $x->setUserid($user->getId());
        return $x;
    }

    /**
     * Поиск товара по штрих-коду
     *
     * @param string $barcode
     *
     * @return ShopProduct
     */
    public function getProductByBarcode($barcode) {
        $barcode = trim($barcode);

        $product = new ShopProduct();
        $product->addWhere('barcode', $barcode, 'LIKE');
        $product->setLimitCount(1);

        return $product->getNext(true);
    }

    /**
     * Получить максимальную цену товара в текущей валюте
     *
     * @return type
     */
    public function getProductMaxPrice(ShopProduct $product, ShopCurrency $currencyDefault) {
        /*$product->leftJoinTable($currencyDefault->getTablename(),
        'currencyid='.$currencyDefault->getTablename().'.id');
        $product->addFieldQuery(' (price / '.$currencyDefault->getRate().' *
        '.$currencyDefault->getTablename().'.rate ) as pr');
        $product->setLimitCount(1);
        $product->setOrder(array('`pr` DESC'));*/

        // задача 67144, как правило у всех товаров одинаковая валюта, поэтому просто сортируем по цене
        $product->setOrder('price', 'DESC');
        $product->setLimitCount(1);
        if ($p = $product->getNext()) {
            return $p->makePrice($currencyDefault);
        }
        return 0;
    }

    /**
     * Поиск товаров
     *
     * @param string $query
     * @param bool $log
     *
     * @return ShopProduct
     */
    public function searchProducts($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $products = $this->getProductsAll();
        $connection = $products->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        $products->setDeleted(0);

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $products->setHidden(0);
        }


        foreach ($a as $part) {
            $w = array();
            $orderBy = array();

            if (is_numeric($part)) {
                $w[] = $products->getTablename().".id = '$part'";
                // если длинна строки == 13 - значит поиск по штрих-коду
                if (strlen($part) == 13) {
                    $w[] = $products->getTablename().".barcode = '$part'";
                }
            }
            if (Shop::Get()->getSettingsService()->getSettingValue('use-code-1c')) {
                $w[] = $products->getTablename().".code1c LIKE '%$part%'";
            }
            $w[] = $products->getTablename().".name LIKE '%$part%'";
            $w[] = $products->getTablename().".articul LIKE '%$part%'";
            $w[] = $products->getTablename().".seokeywords LIKE '%$part%'";
            $w[] = $products->getTablename().".description LIKE '%$part%'";
            $w[] = $products->getTablename().".tags LIKE '%$part%'";

            $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = $products->getTablename().".name LIKE '%$partTr%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partTr%'";
                $w[] = $products->getTablename().".description LIKE '%$partTr%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = $products->getTablename().".name LIKE '%$partRu%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partRu%'";
                $w[] = $products->getTablename().".description LIKE '%$partRu%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = $products->getTablename().".name LIKE '%$partEn%'";
                $w[] = $products->getTablename().".seokeywords LIKE '%$partEn%'";
                $w[] = $products->getTablename().".description LIKE '%$partEn%'";

                $orderBy[] = "(CASE WHEN {$products->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $products->addWhereQuery("(".implode(' OR ', $w).")");
        }

        $products->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $products->setOrder('`relevance`', 'DESC');

        // записываем в историю
        if ($log) {
            $log = new XShopSearchLog();
            $log->setCdate(date('Y-m-d H:i:s'));
            $log->setSid($this->_getSessionID());
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $log->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $log->setQuery($query);
            $log->setCountresult($products->getCount());
            $log->insert();
        }

        return $products;
    }

    /**
     * Найти страницу textpage
     *
     * @param $query
     * @param bool $log
     *
     * @return ShopTextPage
     *
     * @throws ServiceUtils_Exception
     *
     * @todo move to textpageservice
     */
    public function searchPage($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }

        $object = Shop::Get()->getTextPageService()->getTextPageAll();
        $connection = $object->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $object->setHidden(0);
        }

        $queryArray = array();
        $orderBy = array();
        foreach ($a as $part) {
            $w = array();
            $w[] = $object->getTablename().".name LIKE '%$part%'";
            $w[] = $object->getTablename().".content LIKE '%$part%'";

            $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$part%' THEN 5 ELSE 0 END)";
            $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);
                $partTr = $connection->escapeString($partTr);
                $w[] = $object->getTablename().".name LIKE '%$partTr%'";
                $w[] = $object->getTablename().".content LIKE '%$partTr%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);
                $partRu = $connection->escapeString($partRu);
                $w[] = $object->getTablename().".name LIKE '%$partRu%'";
                $w[] = $object->getTablename().".content LIKE '%$partRu%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);
                $partEn = $connection->escapeString($partEn);
                $w[] = $object->getTablename().".name LIKE '%$partEn%'";
                $w[] = $object->getTablename().".content LIKE '%$partEn%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $queryArray[] = "(".implode(' OR ', $w).")";
        }

        $object->addWhereQuery("(".implode(' OR ', $queryArray).")");
        $object->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $object->setOrder('`relevance`', 'DESC');

        // записываем в историю
        if ($log) {
            $log = new XShopSearchLog();
            $log->setCdate(date('Y-m-d H:i:s'));
            $log->setSid($this->_getSessionID());
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $log->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $log->setQuery($query);
            $log->setCountresult($object->getCount());
            $log->insert();
        }

        return $object;
    }

    /**
     * Поиск категории
     *
     * @param $query
     * @param bool $log
     *
     * @return ShopCategory
     * @throws ServiceUtils_Exception
     * @throws Exception
     */
    public function searchCategory($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }
        $object = $this->getCategoryAll();
        if (empty($object)) {
            throw new Exception();
        }
        $connection = $object->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $object->setHidden(0);
        }

        $queryArray = array();
        $orderBy = array();
        foreach ($a as $part) {
            $w = array();
            $w[] = $object->getTablename().".name LIKE '%$part%'";
            $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);
                $partTr = $connection->escapeString($partTr);
                $w[] = $object->getTablename().".name LIKE '%$partTr%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);
                $partRu = $connection->escapeString($partRu);
                $w[] = $object->getTablename().".name LIKE '%$partRu%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);
                $partEn = $connection->escapeString($partEn);
                $w[] = $object->getTablename().".name LIKE '%$partEn%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $queryArray[] = "(".implode(' OR ', $w).")";
        }

        $object->addWhereQuery("(".implode(' OR ', $queryArray).")");
        $object->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $object->setOrder('`relevance`', 'DESC');
        // записываем в историю
        if ($log) {
            $log = new XShopSearchLog();
            $log->setCdate(date('Y-m-d H:i:s'));
            $log->setSid($this->_getSessionID());
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $log->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $log->setQuery($query);
            $log->setCountresult($object->getCount());
            $log->insert();
        }

        return $object;
    }

    /**
     * Поиск бренда
     *
     * @param $query
     * @param bool $log
     *
     * @return ShopBrand
     * @throws ServiceUtils_Exception
     */
    public function searchBrand($query, $log = true) {
        $query = trim($query);
        if (strlen($query) < 3 && !is_numeric($query)) {
            throw new ServiceUtils_Exception();
        }
        $object = $this->getBrandsAll();
        $connection = $object->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        // Если user.level>=2 то искать даже hidden товары
        // issue #17016
        try {
            if (!Shop::Get()->getUserService()->getUser()->isAdmin()) {
                throw new ServiceUtils_Exception();
            }
        } catch (Exception $e) {
            $object->setHidden(0);
        }

        $queryArray = array();
        $orderBy = array();
        foreach ($a as $part) {
            $w = array();
            $w[] = $object->getTablename().".name LIKE '%$part%'";
            $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$part%' THEN 2 ELSE 0 END)";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);
                $partTr = $connection->escapeString($partTr);
                $w[] = $object->getTablename().".name LIKE '%$partTr%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partTr%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);
                $partRu = $connection->escapeString($partRu);
                $w[] = $object->getTablename().".name LIKE '%$partRu%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partRu%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);
                $partEn = $connection->escapeString($partEn);
                $w[] = $object->getTablename().".name LIKE '%$partEn%'";
                $orderBy[] = "(CASE WHEN {$object->getTablename()}.`name` LIKE '%$partEn%' THEN 1 ELSE 0 END)";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $queryArray[] = "(".implode(' OR ', $w).")";
        }

        $object->addWhereQuery("(".implode(' OR ', $queryArray).")");
        $object->addFieldQuery(implode('+', $orderBy).' AS relevance');
        $object->setOrder('`relevance`', 'DESC');
        // записываем в историю
        if ($log) {
            $log = new XShopSearchLog();
            $log->setCdate(date('Y-m-d H:i:s'));
            $log->setSid($this->_getSessionID());
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $log->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $log->setQuery($query);
            $log->setCountresult($object->getCount());
            $log->insert();
        }

        return $object;
    }

    /**
     * По запросу возвращает названия компаний пользователей
     * @param $query
     * @return array
     */
    public function searchCompany($query) {
        $connection = ConnectionManager::Get()->getConnectionDatabase();
        $query = $connection->escapeString($query);
        $query = str_replace(' ', '%', $query);

        $sql = "SELECT distinct company from users where company like '%$query%'";

        $result = array();
        $q = $connection->query($sql);
        while ($x = $connection->fetch($q)) {
            $tmp = explode(',', $x['company']);
            foreach ($tmp as $xtmp) {
                $result[$xtmp] = array('name' => $xtmp);
            }
        }

        usort($result, array($this, '_sortNameASC'));

        return $result;
    }


    /**
     * Поиск компаниии по названию
     *
     * @param $companyName
     *
     * @return User
     */
    public function getCompanyByName($companyName) {
        if (!$companyName) {
            throw new ServiceUtils_Exception();
        }

        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->setTypesex('company');
        $users->setCompany($companyName);
        $users->setLimitCount(1);

        if ($x = $users->getNext()) {
            return $x;
        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Получить список всех компаний
     *
     * @todo а где используется этот метод?
     *
     * @return array
     */
    public function getCompanyArray($users = false) {
        $a = array();

        if ($users) {
            $tmp = clone $users;
            $tmp->addWhere('company', '', '!=');
            while ($x = $tmp->getNext()) {
                $a[] = $x->getCompany();
            }
        } else {
            $connection = ConnectionManager::Get()->getConnectionDatabase();

            $sql = "SELECT distinct company from users where company <> '' ORDER BY company";

            $q = $connection->query($sql);
            while ($x = $connection->fetch($q)) {
                $a[] = $x['company'];
            }
        }

        $a = array_unique($a);
        sort($a);

        return $a;
    }

    /**
     * Записать в историю просмотр товара
     *
     * @deprecated see HistoryService::viewProduct()
     */
    public function viewProduct(ShopProduct $product) {
        return HistoryService::Get()->viewProduct($product);
    }

    /**
     * Получить доступные баннера для заданного места.
     * На выходе строковый массив
     *
     * @param string $place
     *
     * @return array
     *
     * @deprecated
     */
    public function getBanners($place = false) {
        ModeService::Get()->debug('calling deprecated method getBanners!');
        return Shop::Get()->getBannerService()->getBanners($place);
    }

    /**
     * Сохранить клик по баннеру
     *
     * @param ShopBanner $banner
     *
     * @deprecated
     */
    public function clickBanner(ShopBanner $banner) {
        ModeService::Get()->debug('calling deprecated method clickBanner!');
        Shop::Get()->getBannerService()->clickBanner($banner);
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
     * Получить все товары из корзин
     *
     * @return ShopBasket
     */
    public function getBasketAll() {
        $x = new ShopBasket();
        return $x;
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
     * Присваиваем корзину пользователю
     */
    public function makeBasketSmart() {
        try {
            $user = Shop::Get()->getUserService()->getUser();

            $baskets = $this->getBasketProducts();
            while ($x = $baskets->getNext()) {
                $x->setUserid($user->getId());
                $x->update();
            }

            // сбрасываем кеш
            $this->_basketArray = false;
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
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
     * Получить сумму товаров в корзине.
     *
     * @return float|int
     *
     * @throws ServiceUtils_Exception
     */
    public function getBasketSum() {
        $sum = 0;

        $basket = $this->getBasketProducts();
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($x = $basket->getNext()) {
            $sum += $x->makeSum($currencyDefault);
        }

        return $sum;
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
     * Добавить набор
     *
     * @param $setID
     * @param $count
     * @param bool $options
     * @param bool $datefrom
     * @param bool $dateto
     *
     * @return ShopBasket
     * @throws Exception
     */
    public function addSetToBasket ($setID, $count, $options = false, $datefrom = false, $dateto = false) {
        try {
            // @todo нафиг они надо
            $options = $options;

            SQLObject::TransactionStart();
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
            $count = (int) trim($count);

            if ($count <= 0) {
                throw new ServiceUtils_Exception();
            }

            $actionSet = $this->getActionSetById($setID);
            $productArray = array();
            $mainProduct = $this->getProductByID($actionSet->getProductid());
            $productArray[] = array(
                'id' => $mainProduct->getId(),
                'discount' => $actionSet->getDiscount(),
                'price' => $mainProduct->makePrice($currencyDefault),
                'actionPrice' => $this->makeActionPrice($mainProduct, $currencyDefault, $actionSet->getDiscount()),
            );
            $moreProduct = $this->getActionSetProduct($actionSet);
            if (!$moreProduct->getCount()) {
                throw new ServiceUtils_Exception();
            }
            while ($p = $moreProduct->getNext()) {
                $productArray[] = array(
                    'id' => $p->getId(),
                    'discount' => $p->getField('actiondiscount'),
                    'price' => $p->makePrice($currencyDefault),
                    'actionPrice' => $this->makeActionPrice($p, $currencyDefault, $p->getField('actiondiscount')),
                );
            }

            foreach ($productArray as $p) {
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
                $x->setProductid($p['id']);
                $x->setActionsetid($setID);
                $x->setActionsetprice($p['actionPrice']);
                $x->setProductprice($p['price']);

                if ($x->select()) {
                    $x->setProductcount($count + $x->getProductcount());
                    $x->setActionsetcount($count + $x->getActionsetcount());

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
                    $x->setActionsetcount($count);

                    if ($datefrom) {
                        $x->setDatefrom($datefrom);
                    }
                    if ($dateto) {
                        $x->setDateto($dateto);
                    }

                    $x->insert();
                }

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
     * Удаляем набор из корзины
     *
     * @param $setID
     *
     * @throws Exception
     */
    public function deleteSetFromBasket($setID) {
        try {
            SQLObject::TransactionStart();

            $basket = $this->getBasketAll();

            try {
                $userID = Shop::Get()->getUserService()->getUser()->getId();
                $basket->setUserid($userID);
            } catch (Exception $e) {
                $basket->setSid($this->_getSessionID());
                $basket->setUserid(0);
            }

            $basket->setActionsetid($setID);

            while ($b = $basket->getNext()) {
                $b->delete();
            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Изменить количество товара
     *
     * @param int $basketID
     * @param int $count
     *
     * @return Basket
     */
    public function changeBasketCount($basketID, $count) {
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

            $count = str_replace(',', '.', $count);
            $count = (float) trim($count);

            $count = $basket->getProduct()->getCountWithDivisibility($count);

            if ($count <= 0) {
                $this->deleteFromBasket($basketID);
            } else {
                $basket->setProductcount($count);
                $basket->update();
            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function changeSetBasketCount ($setID,$count) {
        try {
            SQLObject::TransactionStart();

            $basket = $this->getBasketAll();

            try {
                $userID = Shop::Get()->getUserService()->getUser()->getId();
                $basket->setUserid($userID);
            } catch (Exception $e) {
                $basket->setSid($this->_getSessionID());
                $basket->setUserid(0);
            }

            $basket->setActionsetid($setID);
            $count = (int) trim($count);

            if ($count <= 0) {
                $this->deleteSetFromBasket($setID);
            } else {
                while ($b = $basket->getNext()) {
                    $b->setProductcount($count);
                    $b->setActionsetcount($count);
                    $b->update();
                }
            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Изменить цену продукта в корзине
     *
     * @param ShopBasket $basket
     * @param float $price
     * @param bool $tax
     */
    public function changeBasketPrice(ShopBasket $basket, $price, $tax = false) {
        $tax; // не понятно откуда это и почему оно не юзается
        $basket->setProductprice($price);
        $basket->update();
    }

    /**
     * Изменить даты продукта в заказе.
     * На основе дат и типа услуги вычисляется и ставится count.
     *
     * @param ShopBasket $basket
     * @param string $from
     * @param string $to
     */
    public function changeBasketDates(ShopBasket $basket, $from, $to) {
        if (!Checker::CheckDate($from)) {
            throw new ServiceUtils_Exception('date-from');
        }
        if (!Checker::CheckDate($to)) {
            throw new ServiceUtils_Exception('date-to');
        }
        if ($from > $to) {
            throw new ServiceUtils_Exception('from-to');
        }

        $basket->setDatefrom($from);
        $basket->setDateto($to);

        try {
            $term = $basket->getProduct()->getTerm();
        } catch (Exception $e) {
            $term = 'month';
        }

        if (!$term) {
            $term = 'month';
        }

        if ($term == 'month') {
            $count = DateTime_Differ::DiffMonth($from, $to, false);
        } elseif ($term == 'day') {
            $count = DateTime_Differ::DiffDay($from, $to);
        } elseif ($term == 'year') {
            $count = DateTime_Differ::DiffYear($from, $to);
        } else {
            $count = 1;
        }
        $basket->setProductcount($count);

        $basket->update();
    }

    public function changeBasketOption($basketID, $filterID, $filterValue) {
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
            $product = $basket->getProduct();
            try {
                $filter_count = Engine::Get()->getConfigField('filter_count');
            } catch (Exception $e) {
                $filter_count = 10;
            }
            for ($j = 1; $j <= $filter_count; $j++) {
                if ($basket->getField('filter'.$j.'id') == $filterID) {
                    $basket->setField('filter'.$j.'value', $filterValue);
                    //находим наценку в товаре
                    $filters = Shop::Get()->getShopService()->getProductFilterValues($product);
                    $filters->setFilterid($filterID);
                    while ($objFilter = $filters->getNext()) {
                        if ($filterValue === '') {
                            $basket->setField('filter'.$j.'markup', 0);
                        } elseif ($objFilter->getFiltervalue() == $filterValue) {
                            $basket->setField('filter'.$j.'markup', $objFilter->getFiltermarkup());
                            break;
                        }
                    }

                    $basket->update();
                    break;
                }
            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Очистить корзину
     */
    public function clearBasket() {
        try {
            SQLObject::TransactionStart();

            $basket = $this->getBasketProducts();
            $basket->delete(true);

            SQLObject::TransactionCommit();

            // сбрасываем кеш
            $this->_basketArray = false;

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить количество товаров в корзине
     *
     * @return int
     */
    public function getBasketProductCount() {
        $basketArray = $this->getBasketProductsArray();
        return count($basketArray);
    }

    /**
     * Рекомендованные товары для корзины
     * Входной параметр - массив id товаров для которых ищем рекомедуемые
     *
     * @param $productIdArray
     *
     * @return array
     */
    public function getRecommendedProductByProductIDArray($productIdArray, $count = false) {
        $resultArray = array();
        if (!$productIdArray) {
            return $resultArray;
        }
        $productIdArray = array_unique($productIdArray);
        $recommendedProduct = new XProduct2RelatedProduct();
        $recommendedProduct->addWhereArray($productIdArray, '`product2relatedproduct`.`productid`');
        $recommendedProduct->addWhereArray($productIdArray, '`product2relatedproduct`.`relatedproductid`', '!=', 'AND');
        // RAND() сильно утяжеляет запрос, поэтому для псевдо случайной подбоки используем сортировку по разным полям
        $randFieldArray = array('id', 'productid', 'relatedproductid');
        $typeSortArray = array('ASC','DESC');
        $recommendedProduct->setOrder(
            '`product2relatedproduct`.`'.$randFieldArray[array_rand($randFieldArray)].'`',
            $typeSortArray[array_rand($typeSortArray)]
        );
        // берём с запасом чтобы откинуть возможные дубли (запрсос с GroupByQuery может быть тяжеловат)
        $recommendedProduct->setLimitCount(6);

        if ($count) {
            $maxCount = $count;
        } else {
            $maxCount = 3;
        }
        $counter = 1;
        $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
        while ($r = $recommendedProduct->getNext()) {
            if (!empty($resultArray[$r->getRelatedproductid()])) {
                continue;
            }
            try {
                $product = Shop::Get()->getShopService()->getProductByID($r->getRelatedproductid());
                if ($product->getHidden() || $product->getDeleted()) {
                    throw new Exception('');
                }
                $resultArray[$product->getId()] = array(
                    'id' => $product->getId(),
                    'name' => $product->makeName(),
                    'image' => $product->makeImageThumb(100),
                    'url' => $product->makeURL(),
                    'price' => $product->makePrice($currencyDefault, true),
                    'currency' => $currencyDefault->getSymbol(),
                );
                if (++$counter > $maxCount) {
                    break;
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
        return $resultArray;
    }

    /**
     * Блин я даже не понял что этот метод делает)
     *
     * @param ShopProduct $product
     *
     * @return array
     */
    public function getSameModelProductArray(ShopProduct $product, ShopCurrency $currency) {
        $resultArray = array();
        $maxSameModelProductCount = 3;
        $currentSameModelProductCount = 0;
        $randFieldArray = array('id','price','ordered','code1c');
        $typeSortArray = array('ASC','DESC');
        if ($product->getSeriesname()) {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->filterHidden(0);
            $products->filterDeleted(0);
            $products->filterAvail(1);
            $products->filterSeriesname($product->getSeriesname());
            $products->setOrder(
                '`shopproduct`.`'.$randFieldArray[array_rand($randFieldArray)].'`',
                $typeSortArray[array_rand($typeSortArray)]
            );
            while ($p = $products->getNext()) {
                if (++$currentSameModelProductCount > $maxSameModelProductCount) {
                    break;
                }
                $resultArray[$p->getId()] = array(
                    'id' => $p->getId(),
                    'name' => $p->getName(),
                    'image' => $p->makeImageThumb(100),
                    'price' => $p->makePrice($currency),
                    'url' => $p->makeURL(),
                );
            }
        }
        if ($currentSameModelProductCount < $maxSameModelProductCount) {
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->filterHidden(0);
            $products->filterDeleted(0);
            $products->filterAvail(1);
            $products->filterCategoryid($product->getCategoryid());
            // ценовой диапазон +-30%;
            $products->addWhereQuery(
                '(`price` >= '.(0.7*$product->getPrice()).' AND `price` <= '.(1.3*$product->getPrice()).')'
            );
            $products->setOrder(
                '`shopproduct`.`'.$randFieldArray[array_rand($randFieldArray)].'`',
                $typeSortArray[array_rand($typeSortArray)]
            );

            while ($p = $products->getNext()) {
                if (isset($resultArray[$p->getId()])) {
                    continue;
                }
                if (++$currentSameModelProductCount > $maxSameModelProductCount) {
                    break;
                }
                $resultArray[$p->getId()] = array(
                    'id' => $p->getId(),
                    'name' => $p->getName(),
                    'image' => $p->makeImageThumb(100),
                    'price' => $p->makePrice($currency),
                    'url' => $p->makeURL(),
                );
            }
        }
        return $resultArray;
    }

    /**
     * Оформить заказ.
     * Все суммы заказа фиксируются в системной валюте.
     * То есть, Order и все OrderProduct изначально будут в одной валюте.
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $address
     * @param string $contacts
     * @param string $comments
     * @param User $user
     * @param int $deliveryID
     * @param int $paymentID
     * @param boolean $isAdmin
     *
     * @return ShopOrder
     */
    public function makeOrder($name, $phone, $email, $address, $contacts, $comments, $user,
    $deliveryID, $paymentID, $isAdmin = false, $gift = false) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $phone = trim($phone);
            $email = trim($email);
            $address = trim($address);
            $contacts = trim($contacts);
            $comments = trim($comments);

            $ex = new ServiceUtils_Exception();

            if (empty($name)) {
                $ex->addError('name');
            }

            if ($phone) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if ($email) {
                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }
            }

            if (!$email && !$phone && !$isAdmin) {
                $ex->addError('email');
                $ex->addError('phone');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $categoryID = 0;
            $outcoming = false;
            $orderType = false;

            try {
                // поиск категории по умолчанию
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }

            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // поиск активного юридического лица
            try {
                $contractor = $this->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // если указан пользователь - оформляем заказ на него
            if ($user) {
                $order->setUserid($user->getId());
                $user->getPhone() ? false : $user->setPhone($phone);
                $user->getAddress() ? false : $user->setAddress($address);
                $user->getEmail() ? false : $user->setEmail($email);
                $user->update();
            }

            // параметры юзера из формы
            $order->setClientname($name);
            $order->setClientphone($phone);
            $order->setClientemail($email);
            $order->setClientaddress($address);
            $order->setClientcontacts($contacts);
            //$order->setStatusid($statusDefault->getId());
            $order->setType($orderType);
            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);
            $order->setComments($comments);
            // юрлицо (контрактор)
            $order->setContractorid($contractorID);
            // подарок
            if ($gift) {
                $order->setForgift(1);
                $order->setComments($comments.' Это для подарка.');
            }

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                // иначе автор - это клиент
                $order->setAuthorid($order->getUserid());
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            // если способ оплаты
            if ($paymentID) {
                try {
                    $payment = $this->getPaymentByID($paymentID);
                    $order->setPaymentid($payment->getId());
                } catch(Exception $ge){
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $ge;
                    }
                }
            }

            $needaddress = true;

            // если есть доставка
            $deliveryPrice = 0;
            if ($deliveryID) {
                try {
                    $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($deliveryID);
                    $deliveryPrice = $delivery->makePrice($currencyDefault);
                    $order->setDeliveryid($delivery->getId());
                    $order->setDeliveryprice($deliveryPrice);

                    $needaddress = ($delivery->getNeedaddress() || $delivery->getNeedcity());
                } catch(Exception $ge) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $ge;
                    }
                }
            }

            if (!$address && $needaddress && $deliveryID && !$isAdmin) {
                $ex->addError('address');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();

            // сумма заказа
            $sum = 0;
            $setSumArray = array();
            if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
                $personalSum = array();
            }
            $baskets = $this->getBasketProducts();
            $count = 0;
            $dateFrom = false;
            $dateTo = false;
            while ($x = $baskets->getNext()) {
                try {
                    $product = $x->getProduct();

                    // вставляем запись
                    $op = new ShopOrderProduct();

                    // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа
                    if (isset($personalSum)) {
                        $personalPrice = PersonalDiscountService::Get()->makePersonalPrice(
                            $product,
                            $currencyDefault
                        );
                        if ($personalPrice) {
                            $price = $personalPrice['price'];
                            $personalSum[$product->getId()] = $personalPrice;
                            $op->setPersonal_discountid($personalPrice['discountID']);
                        } else {
                            //теперь определяем стоимость товара используя метод корзины
                            $price = $x->makePrice($currencyDefault);
                        }
                    } else {
                        //теперь определяем стоимость товара используя метод корзины
                        $price = $x->makePrice($currencyDefault);
                    }


                    $op->setOrderid($order->getId());
                    $op->setProductid($x->getProductid());
                    $op->setProductcount($x->getProductcount());
                    $op->setDatefrom($x->getDatefrom());
                    $op->setDateto($x->getDateto());
                    $op->setStartprice($price);
                    $op->setSupplierid($product->getSupplierid());

                    if ($x->getDatefrom() < $dateFrom) {
                        $dateFrom = $x->getDatefrom();
                    }

                    if ($x->getDateto() > $dateTo) {
                        $dateTo = $x->getDateto();
                    }

                    if (strpos($product->getCode1c(), 'discountCoupon-') === 0 && !$x->getActionsetid()) {
                        // купон, используем
                        try{
                            $couponId = str_replace('discountCoupon-', '', $product->getCode1c());
                            $coupon = new XShopCoupon($couponId);

                            $couponCode = $coupon->getCode();
                            $couponCode = substr_replace($couponCode, '-', 4, 0);
                            $couponCode = substr_replace($couponCode, '-', 9, 0);
                            $couponCode = substr_replace($couponCode, '-', 14, 0);
                            $couponCode = strtoupper($couponCode);

                            $op->setProductname($product->getName().' '.$couponCode);
                            $op->setLinkkey('coupon');
                            $coupon->setDateused(DateTime_Object::Now());
                            $coupon->setOrderid($order->getId());
                            $coupon->update();

                        } catch (Exception $e) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $e;
                            }
                        }

                    } else {
                        // продукт
                        $op->setProductname($product->getName());
                    }
                    try {
                        $op->setCategoryname($product->getCategory()->makePathName());
                    } catch (Exception $categoryEx) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $categoryEx;
                        }
                    }
                    if ($x->getActionsetid()) { // позиция набора
                        @$setSumArray[$x->getActionsetid()]['total'] += $x->getActionsetprice()*$x->getActionsetcount();
                        @$setSumArray[$x->getActionsetid()]['one'] += $x->getActionsetprice();
                        @$setSumArray[$x->getActionsetid()]['count'] = $x->getActionsetcount();

                        $op->setProductprice($x->getActionsetprice());

                        $op->setComment(
                            'На товар установлена цена из набора (код '.$x->getActionsetid().
                            '), поэтому сумма товара не участвует в расчёте возможной накопительной скидки'
                        );
                    } else {
                        $op->setProductprice($price);
                        $op->setProducttax($product->getTax());
                        // устанавливаем комментарий согласно опций заказа
                        $productCommentArray = array();
                        if (isset($personalSum[$product->getId()])) {
                            $productCommentArray[] = 'Товар приобретён по персональной скидке "'.
                            $personalSum[$product->getId()]['discountName'].
                            '(№'.$personalSum[$product->getId()]['discountID'].
                            ')", накопительная скидка на товар не насчитывается';
                        }
                        try {
                            try {
                                $filter_count = Engine::Get()->getConfigField('filter_count');
                            } catch (Exception $e) {
                                $filter_count = 10;
                            }
                            for ($j = 1; $j <= $filter_count; $j++) {
                                $filter = $this->getProductFilterByID(
                                    $x->getField('filter'.$j.'id')
                                );

                                $productCommentArray[] = $filter->getName().': '.$x->getField('filter'.$j.'value');
                            }
                        } catch (Exception $optionEx) {
                            if (PackageLoader::Get()->getMode('debug')) {
                                print $optionEx;
                            }
                        }
                        $op->setComment(implode(', ', $productCommentArray));

                        $op->setParams($x->getParams());
                    }

                    $op->setCurrencyid($currencyDefault->getId());

                    $op->insert();

                    $count ++;

                    // считаем сумму заказа.
                    if (!$x->getActionsetid()) {
                        // при подсчете приводим цену к округлению НДС контрактора
                        $priceWithoutTax = $this->calculateSum(
                            $price,
                            $contractorTax,
                            0,
                            0,
                            true, // return sum
                            false, // + vat tax
                            false // without discount
                        );

                        $tmpSum = round($priceWithoutTax * $x->getProductcount(), 2);
                        $sum += $tmpSum;
                        if (isset($personalSum[$product->getId()])) {
                            $personalSum[$product->getId()]['sum'] = $tmpSum;
                        }
                    }

                    // увеличиваем счетчик заказа товаров на +1
                    $product->setOrdered($product->getOrdered() + 1);
                    $product->setLastordered(date('Y-m-d H:i:s'));
                    $product->update();

                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }

            }

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }

            if (isset($personalSum)) { // посчитаем сумму по всем товарам с персональной скидкой
                $personalSumValue = 0;
                foreach ($personalSum as $s) {
                    $personalSumValue += $s['sum'];
                }
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
                if (isset($personalSumValue)) {
                    $personalSumValue *= (1 + $contractorTax / 100);
                }
            }

            if (isset($personalSumValue)) { // не насчитываем скидку на товары с персональной скидкой
                $sum -= $personalSumValue;
            }

            // автоопределение скидки
            $value = 0;
            $discount = false;
            $discounts = $this->getDiscountAll();
            while ($x = $discounts->getNext()) {
                // если скидка может применятся автоматически
                if ($x->getMinstartsum() > 0) {
                    // конвертируем сумму заказа в валюту скидки
                    $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                        $sum,
                        $currencyDefault,
                        $x->getCurrency()
                    );

                    if ($x->getMinstartsum() <= $sumDiscount) {
                        // ищем максимально возможную скидку
                        $x_value = $x->makeDiscountValue($sum, $currencyDefault);
                        if ($x_value > $value) {
                            $value = $x_value;
                            $discount = clone $x;
                        }
                    }
                }
            }

            if ($user && $user->getDiscountid()) {
                try{
                    $discount = Shop::Get()->getShopService()->getDiscountByID($user->getDiscountid());
                } catch (Exception $edu) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $edu;
                    }
                }
            }

            if ($discount) {
                $order->setDiscountid($discount->getId());
                $order->setDiscountsum($discount->makeDiscountValue($sum, $currencyDefault));
                $sum = $discount->applyDiscount($sum, $currencyDefault);
                $sum = round($sum, 2);
            }

            // увеличиваем сумму на стоимость товаров с персональной скидкой
            if (isset($personalSumValue)) {
                $sum += $personalSumValue;
            }

            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // добавляем в общую сумму наборы
            $connection = ConnectionManager::Get()->getConnectionDatabase();
            foreach ($setSumArray as $setid => $s) {
                $sum += $s['total'];
            }

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            // сумма заказа в системной валюте
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getClientname().$order->getClientphone().$order->getCdate()));

            /*if ($dateFrom) {
                $order->getCdate($dateFrom);
            }*/
            if ($dateTo) {
                $order->setDateto($dateTo);
            }
            if (Shop_ModuleLoader::Get()->isImported('utm-label')) {
                $order->setUtm_campaign($_COOKIE['utm_campaign']);
                $order->setUtm_content($_COOKIE['utm_content']);
                $order->setUtm_term($_COOKIE['utm_term']);
                if ($_COOKIE['utm_date']) {
                    $order->setUtm_date(DateTime_Object::FromString($_COOKIE['utm_date'])->setFormat('Y-m-d'));
                }
                $order->setUtm_referrer($_COOKIE['utm_referrer']);
                $order->setUtm_medium($_COOKIE['utm_medium']);
                $order->setUtm_source($_COOKIE['utm_source']);
            }
            // обновляем заказ
            $order->update();

            // событие после добавления заказа
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($user);
            $event->notify();

            $orderManager = false;
            try{
                $orderManager = $order->getManagerOrAuthor();
            } catch (Exception $eordermanager) {
                try{
                    $orderManager = $order->getClient();
                } catch (Exception $eclient) {

                }
            }

            if ($orderManager) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $orderManager,
                    $order,
                    $statusDefault->getId()
                );
            } else {
                $order->setStatusid($statusDefault->getId());
                $order->update();

                // вставляем историю
                $change = new XShopOrderChange();
                if ($user) {
                    $change->setUserid($user->getId());
                }
                $change->setOrderid($order->getId());
                $change->setCdate($order->getCdate());
                $change->setKey('statusid');
                $change->setValue($order->getStatusid());
                $change->insert();
            }

            // очищаем корзину
            $this->clearBasket();

            try {
                Shop::Get()->getShopService()->updateUserInfoByOrder($order->getClient(), $order);

            } catch (Exception $euserInfo) {

            }

            SQLObject::TransactionCommit();

            // сбрасываем кеш корзины
            $this->_basketArray = false;

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
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
     * Добавить купон в заказ.
     *
     * @param ShopOrder $order
     * @param int $productID
     *
     * @return ShopOrderProduct
     */
    public function addCoupon(ShopOrder $order, $productID) {
        try {
            SQLObject::TransactionStart();

            $product = $this->getProductByID($productID);

            // использован?
            $couponId = str_replace('discountCoupon-', '', $product->getCode1c());
            $coupon = new XShopCoupon($couponId);
            if ($coupon->getDateused() != '0000-00-00 00:00:00') {
                return false;
            }

            // проверяем нет ли в заказе уже купонов
            $orderProducts = $order->getOrderProducts();
            while ($x = $orderProducts->getNext()) {
                if ($x->getLinkkey() == 'coupon') {
                    return false;
                }
            }

            // считаем скидку
            $couponCurrencyId = $coupon->getCurrencyid();

            if ($couponCurrencyId) {
                $productPrice = $coupon->getAmount();
            } else {
                $couponCurrencyId = $order->getCurrencyid();
                // процентный
                $productPrice = 0;
                // % скидка купона
                $sum = $order->getSum();
                $productPrice = $sum*$coupon->getAmount()/100;
            }


            $op = new ShopOrderProduct();
            $op->setOrderid($order->getId());
            $op->setProductprice($productPrice*(-1));
            $op->setCurrencyid($couponCurrencyId);
            $op->setProductcount(1);

            $op->setProductid($product->getId());
            $op->setProductname($product->getName().' '.$product->getLinkkey());
            $op->setSupplierid($product->getSupplierid());
            $op->setLinkkey('coupon');
            $op->insert();

            // используем купон
            $couponId = str_replace('discountCoupon-', '', $product->getCode1c());
            $coupon = new XShopCoupon($couponId);
            $coupon->setDateused(DateTime_Object::Now());
            $coupon->setOrderid($order->getId());
            $coupon->update();

            SQLObject::TransactionCommit();

            $this->recalculateOrderSums($order);

            return $op;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function addCouponToBasket($couponCode) {

        $couponCode = str_replace('-', '', $couponCode);
        $couponCode = strtolower($couponCode);

        $coupon = new XShopCoupon();
        $coupon->setCode($couponCode);

        // ищем/проверяем купон
        if ($coupon->select()) {
            if (!Checker::CheckDate($coupon->getDateused())) {
                // находим/создаем продукт-купон
                try {
                    $couponProduct = Shop::Get()->getShopService()->getProductByCode1c(
                        'discountCoupon-'.$coupon->getId()
                    );
                } catch (Exception $e) {
                    $couponProduct = Shop::Get()->getShopService()->addProduct('Использование скидочного купона');
                    $couponProduct->setCode1c('discountCoupon-'.$coupon->getId());
                    $couponProduct->setHidden(1);
                    $couponProduct->update();
                }

                if ($coupon->getCurrencyid() && !Shop::Get()->getShopService()->isProductInBasket($couponProduct)) {
                    // сумма
                    $couponProduct->setPrice($coupon->getAmount() * (-1));
                    $couponProduct->setCurrencyid($coupon->getCurrencyid());
                    $couponProduct->update();

                    Shop::Get()->getShopService()->addToBasket($couponProduct->getId(), 1);
                } elseif (!Shop::Get()->getShopService()->isProductInBasket($couponProduct)) {
                    // процент
                    $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();
                    $couponPrice = Shop::Get()->getShopService()->getBasketSum() * $coupon->getAmount() / 100;
                    $couponProduct->setPrice($couponPrice * (-1));
                    $couponProduct->setCurrencyid($currencyDefault->getId());
                    $couponProduct->update();
                    Shop::Get()->getShopService()->addToBasket($couponProduct->getId(), 1);
                }

            } else {
                // использован
                return 'couponUse';
            }

        } else {
            // не верный код
            return 'couponCodeFalse';
        }

        return false;

    }

    /**
     * Быстрое оформление заказа (на один товар)
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @param User $client
     * @param ShopProduct $product
     * @param string $name
     * @param string $email
     * @param string $phone
     *
     * @return ShopOrder
     */
    public function makeOrderQuick(User $client, ShopProduct $product, $name, $email, $phone) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $phone = trim($phone);
            $email = trim($email);

            $ex = new ServiceUtils_Exception();

            if (empty($name)) {
                $ex->addError('name');
            }

            if ($phone) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if ($email) {
                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }
            }

            if (!$email && !$phone) {
                $ex->addError('email');
                $ex->addError('phone');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $outcoming = false;
            $orderType = false;

            // поиск категории по умолчанию
            try {
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }

            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // поиск активного юридического лица
            try {
                $contractor = $this->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // оформляем заказ на клиента
            $order->setUserid($client->getId());

            $client->getPhone() ? false : $client->setPhone($phone);
            $client->getEmail() ? false : $client->setEmail($email);
            $client->update();

            // параметры юзера из формы
            $order->setClientname($name);
            $order->setClientphone($phone);
            $order->setClientemail($email);
            $order->setStatusid($statusDefault->getId());
            $order->setType($orderType);
            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);

            // дата до которой нужно выполнить заказ
            $date = Shop::Get()->getSettingsService()->getSettingValue('order-dateto-days');
            $order->setDateto(DateTime_Object::Now()->addDay((int) $date)->__toString());

            // юрлицо (контрактор)
            $order->setContractorid($contractorID);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                $order->setAuthorid($client->getId());
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();

            // сумма заказа
            $sum = 0;
            if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
                $personalSum = array();
            }
            $baskets = $this->getBasketProducts();
            $count = 0;

            // вставляем запись
            $op = new ShopOrderProduct();

            // приводим стоимость товара к НДС и скидке в самом товаре, к валюте заказа
            if (isset($personalSum)) {
                if ($personalPrice = PersonalDiscountService::Get()->makePersonalPrice($product, $currencyDefault)) {
                    $price = $personalPrice['price'];
                    $personalSum[$product->getId()] = $personalPrice;
                    $op->setPersonal_discountid($personalPrice['discountID']);
                    $op->setComment(
                        'Товар приобретён по персональной скидке "'.
                        $personalSum[$product->getId()]['discountName'].
                        '(№'.$personalSum[$product->getId()]['discountID'].
                        ')", накопительная скидка на товар не насчитывается'
                    );
                } else {
                    $price = $product->makePrice($currencyDefault);
                }
            } else {
                $price = $product->makePrice($currencyDefault);
            }

            $op->setOrderid($order->getId());
            $op->setProductid($product->getId());
            $op->setProductcount(1); // 1 штука
            $op->setProductname($product->getName());
            $op->setSupplierid($product->getSupplierid());
            try {
                $op->setCategoryname($product->getCategory()->makePathName());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $op->setProductprice($price);
            $op->setProducttax($product->getTax());
            $op->setCurrencyid($currencyDefault->getId());
            $op->insert();

            // считаем сумму заказа.
            // при подсчете приводим цену к округлению НДС контрактора
            $priceWithoutTax = $this->calculateSum(
                $price,
                $contractorTax,
                0,
                0,
                true, // return sum
                false, // + vat tax
                false // without discount
            );

            $sum = round($priceWithoutTax * $op->getProductcount(), 2);

            // увеличиваем счетчик заказа товаров на +1
            $product->setOrdered($product->getOrdered() + 1);
            $product->setLastordered(date('Y-m-d H:i:s'));
            $product->update();

            $count ++;

            // если нет строк - нет заказа
            if (!$count) {
                throw new ServiceUtils_Exception('count');
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
            }

            // автоопределение скидки
            if (empty($personalSum[$product->getId()])) {
                $value = 0;
                $discount = false;
                $discounts = $this->getDiscountAll();
                while ($x = $discounts->getNext()) {
                    // если скидка может применятся автоматически
                    if ($x->getMinstartsum() > 0) {
                        // конвертируем сумму заказа в валюту скидки
                        $sumDiscount = Shop::Get()->getCurrencyService()->convertCurrency(
                            $sum,
                            $currencyDefault,
                            $x->getCurrency()
                        );

                        if ($x->getMinstartsum() <= $sumDiscount) {
                            // ищем максимально возможную скидку
                            $x_value = $x->makeDiscountValue($sum, $currencyDefault);
                            if ($x_value > $value) {
                                $value = $x_value;
                                $discount = clone $x;
                            }
                        }
                    }
                }

                if ($client && $client->getDiscountid()) {
                    try{
                        $discount = Shop::Get()->getShopService()->getDiscountByID($client->getDiscountid());
                    } catch (Exception $edu) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $edu;
                        }
                    }
                }

                if ($discount) {
                    $order->setDiscountid($discount->getId());
                    $order->setDiscountsum($discount->makeDiscountValue($sum, $currencyDefault));
                    $sum = $discount->applyDiscount($sum, $currencyDefault);
                    $sum = round($sum, 2);
                }
            }

            // увеличиваем стоимость заказа на сумму доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $deliveryPrice;

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // формируем записываем Hash заказа
            // для трек-ссылки заказа
            $order->setHash(md5($order->getId().$order->getClientname().$order->getClientphone().$order->getCdate()));

            // обновляем заказ
            $order->update();

            try{
                // вставляем историю
                $change = new XShopOrderChange();
                if ($client) {
                    $change->setUserid($client->getId());
                }
                $change->setOrderid($order->getId());
                $change->setCdate($order->getCdate());
                $change->setKey('statusid');
                $change->setValue($order->getStatusid());
                $change->insert();
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // fire event
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($client);
            $event->notify();

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать новый пустой заказ
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @return ShopOrder
     */
    public function makeOrderEmpty(User $user = null) {
        try {
            SQLObject::TransactionStart();

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $outcoming = false;
            $orderType = false;

            // поиск категории по умолчанию
            try {
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }

            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // поиск активного юридического лица
            try {
                $contractor = $this->getContractorDefault();
                $contractorID = $contractor->getId();
                $contractorTax = $contractor->getTax();
            } catch (Exception $e) {
                $contractorID = 0;
                $contractorTax = 0;
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));
            $order->setCurrencyid($currencyDefault->getId());
            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);
            $order->setType($orderType);

            // если указан пользователь - оформляем заказ на него
            try {
                if (!$user) {
                    $user = Shop::Get()->getUserService()->getUser();
                }
                $order->setUserid($user->getId());

                $discount = false;
                if ($user->getDiscountid()) {
                    try{
                        $discount = Shop::Get()->getShopService()->getDiscountByID($user->getDiscountid());
                    } catch (Exception $edu) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $edu;
                        }
                    }
                }

                if ($discount) {
                    $order->setDiscountid($discount->getId());
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $order->setStatusid($statusDefault->getId());

            // дата до которой нужно выполнить заказ
            $date = Shop::Get()->getSettingsService()->getSettingValue('order-dateto-days');
            $order->setDateto(DateTime_Object::Now()->addDay((int) $date)->__toString());

            // юрлицо (контрактор)
            $order->setContractorid($contractorID);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $authorEx;
                }
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            // автоматически выставляем менеджера
            try {
                $user = Shop::Get()->getUserService()->getUser();
                if ($user->isAdmin()) {
                    $order->setManagerid($user->getId());
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // автоматически заполняем client-поля заказа
            try {
                $order->setClientname($order->getUser()->makeName(false));
                $order->setClientphone($order->getUser()->getPhone());
                $order->setClientemail($order->getUser()->getEmail());
            } catch (Exception $clientEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $clientEx;
                }
            }

            $order->insert();

            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать новый заказ
     *
     * @return ShopOrder
     */
    public function addOrder(User $user, $name, $content, $managerID, $categoryID,
    $dateto = false, $clientID = false, $parentID = false, $productArray = array()) {
        $name = trim($name);
        $content = trim($content);

        try {
            SQLObject::TransactionStart();

            // если не задан бизнес-процесс
            if (!$categoryID) {
                try {
                    $workflow = WorkflowService::Get()->getWorkflowDefault('order');
                } catch (Exception $workflowEx) {
                    throw new ServiceUtils_Exception('workflow');
                }
            } else {
                $workflow = WorkflowService::Get()->getWorkflowByID($categoryID);
            }

            try {
                $statusDefault = $workflow->getStatusDefault();
            } catch (Exception $e) {
                $statusDefault = false;
            }

            // проверка на имя
            // @todo: какой-то странный костыль :)
            if ($workflow->getType() == 'issue') {
                if (!$name) {
                    throw new ServiceUtils_Exception('name');
                }
            }

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));
            $order->setCategoryid($workflow->getId());
            $order->setIssue(($workflow->getType() == 'issue' || $workflow->getType() == 'project'));
            $order->setType($workflow->getType());
            $order->setOutcoming($workflow->getOutcoming());

            $order->setComments($content);

            // поиск активного юридического лица
            try {
                $contractor = Shop::Get()->getShopService()->getContractorDefault();
                $order->setContractorid($contractor->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // дата до которой нужно выполнить заказ
            if (Checker::CheckDate($dateto)) {
                $dateto = DateTime_Formatter::DateTimeISO9075($dateto);
                $order->setDateto($dateto);
            } elseif ($workflow->getTerm() >= 0 && !$workflow->getNoautodateto()) {
                $order->setDateto(DateTime_Object::Now()->addDay((int) $workflow->getTerm())->__toString());
            }

            // кто автор заказа
            $order->setAuthorid($user->getId());

            // кто менеджер заказа
            $order->setManagerid($managerID);

            // если есть привязка к родительской задаче
            if ($parentID) {
                $order->setParentid($parentID);

                try {
                    $parentIssue = $this->getOrderByID($parentID);
                    $order->setParentstatusid($parentIssue->getStatusid());
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            if ($name) {
                $order->setName($name);
            }

            try {
                $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                $order->setCurrencyid($currency->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $order->setPriority(0);
            $order->setUuserid($user->getId());
            $order->insert();

            // товары в заказ
            if ($productArray) {
                foreach ($productArray as $productInArray) {
                    $productID = @$productInArray['id'];
                    $productCount = @$productInArray['count'];
                    $productPrice = @$productInArray['price'];
                    $productSerial = @$productInArray['serial'];
                    $productLinkKey = @$productInArray['linkkey'];

                    if (!$productID) {
                        continue;
                    }

                    if (!$productCount) {
                        $productCount = 1;
                    }

                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    $orderProduct = Shop::Get()->getShopService()->addOrderProduct(
                        $order,
                        $product->getId(),
                        $productCount
                    );

                    if ($productPrice) {
                        $orderProduct->setProductprice($productPrice);
                    }

                    if ($productSerial) {
                        $orderProduct->setSerial($productSerial);
                    }

                    if ($productLinkKey && strpos($productLinkKey, 'supplier_') === 0) {
                        $orderProduct->setSupplierid(str_replace('supplier_', '', $productLinkKey));
                    }

                    if ($productLinkKey && strpos($productLinkKey, 'balance_') === 0) {
                        $orderProduct->setStorageid(str_replace('balance_', '', $productLinkKey));
                    }

                    $orderProduct->setLinkkey($productLinkKey);
                    $orderProduct->update();
                }

            }

            if ($parentID) {
                try {
                    $parentIssue = Shop::Get()->getShopService()->getOrderByID($parentID);
                    $orderComment = "Создана задача #".$order->getId();
                    if ($order->getName()) {
                        $orderComment.= " - ".$order->getName();
                    }
                    if ($order->getComments()) {
                        $orderComment.= "\n".$order->getComments();
                    }
                    $orderComment.= "\nдля ".$user->makeName(false, 'lfm');

                    Shop::Get()->getShopService()->addOrderComment(
                        $parentIssue,
                        $user,
                        $orderComment
                    );
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
            }

            // Если клеинт не задан, то пытаемся найти клиента, по родительской задаче.
            try {
                if (!$clientID) {
                    $parentOrder = $order->getParent();
                    $clientID = $parentOrder->getUserid();
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            if ($clientID) {
                $order->setUserid($clientID);

                // записываем данные клиента в заказ
                try {
                    $client = Shop::Get()->getUserService()->getUserByID($clientID);
                    $order->setClientname($client->makeName(false));
                    $order->setClientemail($client->getEmail());
                    $order->setClientphone($client->getPhone());
                    $order->setClientaddress($client->getAddress());
                } catch (Exception $clientEx) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $clientEx;
                    }
                }
            }

            // проставляем номер
            $order->setNumber($order->getId());
            $order->update();

            // парсим комментарий на предмет юзеров
            // и добавляем их в наблюдатели
            if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $content, $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $wUser = Shop::Get()->getUserService()->getUserByID($userID);
                        Shop::Get()->getShopService()->addOrderEmployer($order, $wUser);
                    } catch (Exception $watcherEx) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $watcherEx;
                        }
                    }
                }
            }

            // вставляем историю
            $change = new XShopOrderChange();
            $change->setUserid($user->getId());
            $change->setOrderid($order->getId());
            $change->setCdate($order->getCdate());
            $change->setKey('statusid');
            $change->setValue($order->getStatusid());
            $change->insert();

            if ($statusDefault) {
                Shop::Get()->getShopService()->updateOrderStatus(
                    $user,
                    $order,
                    $statusDefault->getId()
                );
            }

            // генерируем событие
            $event = Events::Get()->generateEvent('shopOrderAddAfter');
            $event->setOrder($order);
            $event->setUser($user);
            $event->notify();

            Shop::Get()->getShopService()->orderEmailNotification($order, $user, 'Создана новая задача');

            SQLObject::TransactionCommit();

            return $order;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить записи о просмотрах заказа
     *
     * @param ShopOrder $order
     *
     * @return XShopOrderLogView
     */
    public function getOrderLogViews(ShopOrder $order) {
        $logs = new XShopOrderLogView();
        $logs->setOrderid($order->getId());
        $logs->setOrder('id', 'ASC');
        return $logs;
    }

    /**
     * Добавить запись о том, что пользователь просмотрел заказ/задачу
     *
     * @param ShopOrder $order
     * @param User $user
     */
    public function addOrderLogView(ShopOrder $order, User $user) {
        try {
            SQLObject::TransactionStart();

            $logs = $this->getOrderLogViews($order);
            $logs->setUserid($user->getId());
            $logs->setLast(1);
            while ($log = $logs->getNext()) {
                $log->setLast(0);
                $log->update();
            }

            $log = new XShopOrderLogView();
            $log->setOrderid($order->getId());
            $log->setUserid($user->getId());
            $log->setCdate(date('Y-m-d H:i:s'));
            $log->setLast(1);
            $log->insert();

            // удаляем уведомления
            Shop::Get()->getShopService()->deleteNotification(
                $user,
                $order
            );

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Посчитать стоимости заказа и обновить его.
     * Метод используется при добавлении OrderProduct-ов внутрь заказа.
     *
     * @param ShopOrder $order
     */
    public function recalculateOrderSums(ShopOrder $order) {
        try {
            SQLObject::TransactionStart();

            // event
            $event = Events::Get()->generateEvent('shoprecalculateOrderSumsBefore');
            $event->setOrder($order);
            $event->notify();

            // пересчитываем заказ в валюту заказа
            $currencyDefault = $order->getCurrency();

            // пересчитываем доставку в валюту заказа
            if ($order->getDeliveryprice() != 0 && $order->getDeliveryid()) {
                try{
                    $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($order->getDeliveryid());
                    $deliveryPrice = Shop::Get()->getCurrencyService()->convertCurrency(
                        $delivery->getPrice(),
                        $delivery->getCurrency(),
                        $currencyDefault
                    );

                    $order->setDeliveryprice($deliveryPrice);
                } catch (Exception $de) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $de;
                    }
                }
            }


            // получаем процент скидки (заказ -> скидка -> %)
            $discountPercent = $order->getDiscountPercent();
            $discountValue = $order->getDiscountValue($currencyDefault);

            // сумма скидки
            $discountSum = 0;

            // процент налогообложения юрлица
            try {
                $contractorTax = $order->getContractor()->getTax();
            } catch (ServiceUtils_Exception $se) {
                $contractorTax = 0;
            }

            // полная сумма заказа
            $sum = 0;

            if (Shop_ModuleLoader::Get()->isImported('personal-discount')) {
                // для суммы по товарам с персональными скидками (на неё не накладывается общая скидка)
                $personalSum = 0;
            }

            // проходимся по каждому товарару в заказе
            $orderproducts = $order->getOrderProducts();
            while ($op = $orderproducts->getNext()) {
                $price = $op->makePrice($currencyDefault);

                // уменьшаем цену на ПДВ,
                // чтобы потом увеличить и суммы сошлись
                if ($op->getProducttax() && $contractorTax) {
                    $price = Shop::Get()->getShopService()->calculateSum(
                        $price,
                        $contractorTax,
                        0,
                        0,
                        true, // return sum
                        false, // - vat tax
                        false // without discount
                    );
                }

                $sum += round($price * $op->getProductcount(), 2);

                if (isset($personalSum)) {
                    if ($op->getPersonal_discountid()) {
                        $personalSum += round($price * $op->getProductcount(), 2);
                    }
                }
            }

            // добавляем ПДВ к заказу
            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
                if (!empty($personalSum)) {
                    $personalSum *= (1 + $contractorTax / 100);
                }
            }

            // увеличиваем сумму заказа на стоимость доставки
            // Внимание! Доставка в сумме заказа уже не фигурирует!
            // $sum += $order->getDeliveryprice();

            // накопительные скидки начситываем только на товары без персональной скидки
            if (!empty($personalSum)) {
                $sum -= $personalSum;
            }

            $discountSum = Shop::Get()->getShopService()->calculateSum(
                $sum,
                0,
                $discountPercent,
                $discountValue,
                false, // - sum
                false, // - tax vat
                true // + discount
            );

            $mysum = $sum;

            $sum = Shop::Get()->getShopService()->calculateSum(
                $sum,
                0,
                $discountPercent,
                $discountValue,
                true, // + sum
                true, // + tax vat
                false // - discount
            );

            // Пересчитываем сумму заказа с учетом максимальной скидки на товар

            if ($discountPercent > 0) {
                $mysum = Shop::Get()->getShopService()->calculateSum(
                    $mysum,
                    0,
                    $discountPercent,
                    $discountValue,
                    true, // + sum
                    true, // + tax vat
                    true // + discount
                );
                $orderproducts = $order->getOrderProducts();
                $discountSum = 0;
                while ($op = $orderproducts->getNext()) {

                    $prodMaxDiscount = $op->getProduct()->getMaxdiscount();
                    $discountProduct = $discountPercent;
                    if ($prodMaxDiscount > 0 && $prodMaxDiscount < $discountProduct) {
                        $discountProduct = $prodMaxDiscount;
                    }
                    $price = $op->makePrice($currencyDefault);
                    // Сначала отнимем от сумма старцую цену
                    if ($op->getProducttax() && $contractorTax) {
                        $price = Shop::Get()->getShopService()->calculateSum(
                            $price,
                            $contractorTax,
                            0,
                            0,
                            true, // return sum
                            false, // - vat tax
                            false // without discount
                        );
                    }

                    $mysum -= round($price * $op->getProductcount(), 2);

                    // теперь допишем новую цену
                    $priceNew = $op->getProduct()->makePrice($currencyDefault, false);
                    $priceNew *= (1 - $discountProduct / 100);
                    $discountSum += $op->getProduct()->makePrice($currencyDefault, false) - $priceNew;
                    $mysum += round($priceNew * $op->getProductcount(), 2);

                }
                $sum = $mysum;
            }
            // добавляем сумму товаров с персональными скидками
            if (!empty($personalSum)) {
                $sum += $personalSum;
            }

            // если заказ исходящий, сумма с минусом
            if ($order->getOutcoming() && ($sum > 0)) {
                $sum *=(-1);
            }
            // записываем суммы
            $order->setSum($sum);
            // сумма заказа в системной валюте

            $sumbase = Shop::Get()->getCurrencyService()->convertCurrency(
                $sum,
                $currencyDefault,
                Shop::Get()->getCurrencyService()->getCurrencySystem()
            );

            $order->setSumbase($sumbase);
            $order->setDiscountsum($discountSum);
            $order->update();

            // event
            $event = Events::Get()->generateEvent('shoprecalculateOrderSumsAfter');
            $event->setOrder($order);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Создать заказ с товарами, переданными в массиве
     * Без скидок.
     *
     * Внимание! Если бизнес-процесса и статуса не будет - заказы не оформляются!
     *
     * @param User $cuser
     * @param int $contractorID
     * @param int $userID
     * @param string $name
     * @param string $comments
     * @param array $productArray
     * @param bool $allowWithoutUserName разрешать делать заказ без имени пользователя
     *
     * @return array
     *
     * @todo рефакторинг метода, а то не ясно где и как юзается
     */
    public function makeOrderByProductArray($cuser, $contractorID, $userID,
    $name, $comments, $productArray, $allowWithoutUserName=false) {
        /**
         * Общий алгоритм оформления заказа:
         *
         * 1. При оформлении заказа все суммы товаров и сумма заказа будет
         * в системной валюте.
         * 2. Будет выбрано активное юрлицо по умолчанию - и оно будет выставлено
         * в заказ.
         * 3. Все стоимости товаров будут приведены к полной стоимости включая НДС
         * (если НДС указан в самом товаре). НДС контрактора не будет использоваться.
         *
         * Уже в управлении заказом чтобы посчитать НДС нужно будет от суммы заказа снять
         * процент НДС.
         */

        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $comments = trim($comments);

            $ex = new ServiceUtils_Exception();

            $contractorTax = 0;
            if ($contractorID) {
                try {
                    $contractor = Shop::Get()->getShopService()->getContractorByID($contractorID);
                    $contractorTax = $contractor->getTax();
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('contractor');
                }
            }

            if ($userID) {
                try {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                } catch (ServiceUtils_Exception $se) {
                    $ex->addError('client');
                }
            }

            if (!$userID && empty($name) && !$allowWithoutUserName) {
                $ex->addError('client');
            }

            // получаем системную валюту, в которой будем оформлять заказ
            $currencyDefault = Shop::Get()->getCurrencyService()->getCurrencySystem();

            $outcoming = false;
            $orderType = false;

            // поиск категории по умолчанию
            try {
                $category = WorkflowService::Get()->getWorkflowDefault('order');
            } catch (Exception $workflowEx) {
                throw new ServiceUtils_Exception('workflow');
            }

            $categoryID = $category->getId();
            $outcoming = $category->getOutcoming();
            $orderType = $category->getType();

            // поиск статуса заказа по умолчанию
            $statusDefault = $category->getStatusDefault();

            // оформление заказа
            $order = new ShopOrder();
            $order->setCdate(date('Y-m-d H:i:s'));

            // если указан пользователь - оформляем заказ на него
            if ($userID) {
                $order->setUserid($user->getId());

                $order->setClientname($user->getName());
                $order->setClientphone($user->getPhone());
                $order->setClientemail($user->getEmail());
                $order->setClientaddress($user->getAddress());
            } else {
                $order->setClientname($name);
            }

            //$order->setStatusid($statusDefault->getId());

            $order->setCategoryid($categoryID);
            $order->setOutcoming($outcoming);
            $order->setType($orderType);
            $order->setComments($comments);
            $order->setManagerid($cuser->getId());

            // дата до которой нужно выполнить заказ
            $date = Shop::Get()->getSettingsService()->getSettingValue('order-dateto-days');
            $order->setDateto(DateTime_Object::Now()->addDay((int) $date)->__toString());

            // юрлицо (контрактор)
            $order->setContractorid($contractorID);

            // кто автор заказа
            try {
                $order->setAuthorid(Shop::Get()->getUserService()->getUser()->getId());
            } catch (Exception $authorEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $authorEx;
                }
            }

            // кто менеджер заказа
            try {
                $manager = Shop::Get()->getUserService()->getUser();
                if ($manager->isManager()) {
                    $order->setManagerid($manager->getId());
                }
            } catch (Exception $managerEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $managerEx;
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // вставляем заказ
            $order->insert();


            // сумма заказа
            $sum = 0;
            $count = 0;
            foreach ($productArray as $k => $x) {
                try {
                    $product = $this->getProductByID($x['productid']);

                    $currency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                        $x['currencyid']
                    );

                    // приводим стоимость товара к НДС и  к валюте заказа
                    $price = Shop::Get()->getCurrencyService()->convertCurrency(
                        $x['price'],
                        $currency,
                        $currencyDefault
                    );

                    // вставляем запись
                    $op = new ShopOrderProduct();
                    $op->setOrderid($order->getId());
                    $op->setProductid($x['productid']);
                    $op->setProductcount($x['amount']);
                    $op->setProductname($product->getName());
                    $op->setProductprice($price);
                    $op->setSupplierid($product->getSupplierid());
                    if (isset($x['tax'])) {
                        $op->setProducttax($x['tax']);
                    } else {
                        $op->setProducttax($product->getTax());
                    }
                    try {
                        $op->setCategoryname($product->getCategory()->makePathName());
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                    $op->setCurrencyid($currencyDefault->getId());
                    $op->setSerial(@$x['serial']);
                    $op->setWarranty(@$x['warranty']);
                    $op->insert();

                    // записываем  товар заказа в массив, чтобы
                    // вернуть его
                    $productArray[$k]['orderproductid'] = $op->getId();

                    // считаем сумму заказа.
                    // при подсчете приводим цену к округлению НДС контрактора
                    $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
                        $price,
                        $contractorTax,
                        0,
                        0,
                        true, // return sum
                        false, // + vat tax
                        false // without discount
                    );

                    $sum += round($priceWithoutTax * $x['amount'], 2);

                    // увеличиваем счетчик заказа товаров на +1
                    $product->setOrdered($product->getOrdered() + 1);
                    $product->setLastordered(date('Y-m-d H:i:s'));
                    $product->update();

                    $count ++;
                } catch (ServiceUtils_Exception $se) {
                    $productArray[$k]['error'] = true;
                }
            }

            if ($contractorTax) {
                $sum *= (1 + $contractorTax / 100);
            }

            // записываем сумму заказа и валюту
            $order->setSum($sum);
            $order->setSumbase($sum);
            $order->setCurrencyid($currencyDefault->getId());

            // обновляем заказ
            $order->update();


            try {
                Shop_ShopService::Get()->updateOrderStatus($user, $order, $statusDefault->getId());
            } catch (Exception $ex) {

            }
            /*if ($comments) {
                PackageLoader::Get()->import('CommentsAPI');
                $commentKey = 'shop-order-'.$order->getId();

                if ($cuser) {
                    $userID = $cuser->getId();
                } else {
                    $userID = false;
                }

                CommentsAPI::Get()->addComment($commentKey, $comments, $userID);
            }*/

            SQLObject::TransactionCommit();

            return array('order' => $order, 'productArray' => $productArray);
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Оплатить заказ.
     * Заказ переходит в статус "Оплачено"
     *
     * @param int $orderID
     * @param float $amount
     *
     * @todo а нужен ли метод вообще?
     */
    public function payOrder($orderID, $amount) {
        try {
            SQLObject::TransactionStart();

            $order = $this->getOrderByID($orderID);
            $payAmount = round($amount, 2);
            $orderAmount = round($order->getSum(), 2);

            // несовпадение сумм
            if ($orderAmount != $payAmount) {
                throw new ServiceUtils_Exception();
            }

            // находим статус "Оплачено"

            $status = $order->getWorkflow()->getStatuses();
            $status->setPayed(1);
            if (!$status->select()) {
                // нет статуса "Оплачено"
                throw new ServiceUtils_Exception();
            }

            $cuser = $order->getManagerOrAuthor();
            $this->updateOrderStatus($cuser, $order, $status->getId());

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить заказ/задачу.
     * Фактически ставится пометка deleted=1
     *
     * @param ShopOrder $order
     * @param User $user
     */
    public function deleteOrder(ShopOrder $order, $user = false) {
        try {
            SQLObject::TransactionStart();

            // проверка ACL
            if ($user) {
                $type = $order->getType();
                if ($user->isDenied($type.'-delete')) {
                    throw new ServiceUtils_Exception('access denied');
                }
            }

            $event = Events::Get()->generateEvent('shopOrderDeleteBefore');
            $event->setOrder($order);
            $event->notify();

            // чистка заказаного товара
            // уже не надо, так как deleted=1
            //$orderproduct = $order->getOrderProducts();
            //$orderproduct->delete(true);

            try {
                if (!$user) {
                    $user = Shop::Get()->getUserService()->getUser();
                }

                $this->addOrderChange($order, $user, 'Заказ удален');
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // удаление подзадач - не нужно, так как ставится пометка deleted=1

            // удаляем заказ
            $order->setDeleted(1);
            $order->update();

            // событие
            $event = Events::Get()->generateEvent('shopOrderDeleteAfter');
            $event->setOrder($order);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Восстановить заказ/задачу.
     * Снимается пометка deleted=1
     *
     * @param ShopOrder $order
     */
    public function restoreOrder(ShopOrder $order, $user = false) {
        try {
            SQLObject::TransactionStart();

            try {
                if (!$user) {
                    $user = Shop::Get()->getUserService()->getUser();
                }

                $this->addOrderChange($order, $user, 'Заказ восстановлен');
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $order->setDeleted(0);
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удаление бизнес процесса
     * @param ShopOrderCategory $orderCategory
     * @throws Exception
     */
    public function deleteOrderCategory(ShopOrderCategory $orderCategory) {
        try {
            SQLObject::TransactionStart();

            // чистка статусов
            $statuses = $orderCategory->getStatuses();
            $statuses->delete(true);

            // чистка изменений статусов
            $changes = new XShopOrderStatusChange();
            $changes->setCategoryid($orderCategory->getId());
            $changes->delete(true);

            try {
                $user = Shop::Get()->getUserService()->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-ordercategory-'.$orderCategory->getId(),
                    'Удален бизнес процесс #'.$orderCategory->getId(),
                    $user->getId()
                );
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // удаляем процесс
            $orderCategory->delete();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить статус и бизнес-процесс
     *
     * @param User $user
     * @param ShopOrder $order
     * @param int $statusID
     */
    public function updateOrderStatusAndCategory(User $user, ShopOrder $order, $statusID) {
        try {
            SQLObject::TransactionStart();

            try {
                $status = WorkflowService::Get()->getStatusByID($statusID);

                $order->setCategoryid($status->getCategoryid());

                try {
                    $category = WorkflowService::Get()->getWorkflowByID(
                        $status->getCategoryid()
                    );
                    $order->setType($category->getType());
                    $order->setIssue(($order->isIssue() || $order->isProject()));
                    $order->setOutcoming($category->getOutcoming());
                } catch (ServiceUtils_Exception $se) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $se;
                    }
                }

                $order->update();
            } catch (ServiceUtils_Exception $se) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }

            Shop::Get()->getShopService()->updateOrderStatus(
                $user,
                $order,
                $statusID
            );

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сменить статус заказу.
     * Последний параметр говорит "проверять ACL или нет"
     *
     * @param User $user
     * @param ShopOrder $order
     * @param int $statusID
     */
    public function updateOrderStatus($user, ShopOrder $order, $statusID) {
        try {
            SQLObject::TransactionStart();

            if (!$user) {
                try{
                    $user = Shop::Get()->getUserService()->getUserByID(
                        Shop::Get()->getSettingsService()->getSettingValue('user-robot')
                    );
                } catch (Exception $eUser) {
                    throw new ServiceUtils_Exception('user-not-found');
                }
            }

            $status = WorkflowService::Get()->getStatusByID($statusID);

            if ($statusID != $order->getStatusid()) {
                $order->setStatusid($status->getId());
                $order->setCategoryid($status->getCategoryid());
                $order->setType($status->getWorkflow()->getType());
                // автоматически ставим менеджера, если менеджера нет
                if (!$order->getManagerid()) {
                    $order->setManagerid($user->getManagerid());
                }

                // записываем статус в историю
                $change = new XShopOrderChange();
                $change->setCdate(date('Y-m-d H:i:s'));
                $change->setOrderid($order->getId());
                $change->setKey('statusid');
                $change->setValue($status->getId());
                $change->setUserid($user->getId());
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

                // генерируем событие
                $event = Events::Get()->generateEvent('shopOrderStatusUpdateAfter');
                $event->setOrder($order);
                $event->setUser($user);
                $event->setStatus($status);
                $event->notify();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сменить доставку в заказе
     *
     * @param ShopOrder $order
     * @param string $status
     */
    public function updateOrderDelivery(ShopOrder $order, $deliveryID) {
        try {
            SQLObject::TransactionStart();

            // получаем валюту заказа
            $currencyOrder = $order->getCurrency();

            if (!$deliveryID) {
                $deliveryID = 0;
                $deliveryPrice = 0;
            } else {
                $delivery = Shop::Get()->getDeliveryService()->getDeliveryByID($deliveryID);
                $deliveryPrice = $delivery->makePrice($currencyOrder);
            }

            $order->setDeliveryid($deliveryID);
            $order->setDeliveryprice($deliveryPrice);
            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Сменить сопсоб оплаты в заказе
     *
     * @param ShopOrder $order
     * @param int $paymentID
     */
    public function updateOrderPayment(ShopOrder $order, $paymentID) {
        try {
            SQLObject::TransactionStart();

            if (!$paymentID) {
                $order->setPaymentid(0);
            } else {
                Shop::Get()->getShopService()->getPaymentByID($paymentID);
                $order->setPaymentid($paymentID);
            }

            $order->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Выгрузить заказ в XML
     *
     * @param ShopOrder $order
     */
    public function orderXML (ShopOrder $order) {
        $this->_orderXML($order);
    }

    /**
     * Выгрузить заказ в CSV
     *
     * @param ShopOrder $order
     */
    public function orderCSV (ShopOrder $order) {
        $this->_orderCSV($order);
    }

    /**
     * Выгрузить заказ в XML
     *
     * @param ShopOrder $order
     */
    protected function _orderXML(ShopOrder $order) {
        PackageLoader::Get()->import('XML');

        $info = array();
        $info['orderid'] = $order->getId();
        $info['ordernumber'] = $order->getNumber();
        $info['ordername'] = $order->getName();
        $info['datetime'] = $order->getCdate();
        $info['userid'] = $order->getUserid();
        $info['statusid'] = $order->getStatusid();
        try {
            $info['statusname'] = $order->getStatus()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        $info['clientname'] = $order->getClientname();
        $info['clientphone'] = $order->getClientphone();
        $info['clientemail'] = $order->getClientemail();
        $info['clientcontacts'] = $order->getClientcontacts();
        $info['clientaddress'] = $order->getClientaddress();
        $info['sum'] = $order->getSum();
        $info['discountSum'] = $order->getDiscountsum();
        $info['currency'] = $order->getCurrency()->getName();
        try {
            $info['deliveryprice'] = $order->getDeliveryprice();
            $info['deliveryid'] = $order->getDeliveryid();
            $info['deliveryname'] = $order->getDelivery()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        $a = array();
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            $currency = $op->getCurrency();

            try {
                $code1c = $op->getProduct()->getCode1c();
            } catch (Exception $e) {
                $code1c = false;
            }

            $a[] = array(
            'name' => $op->getProductname(),
            'count' => $op->getProductcount(),
            'price' => $op->getProductprice(),
            'productid' => $op->getProductid(),
            'code1c' => $code1c,
            'sum' => $op->makeSum($currency),
            'currency' => $currency->getName(),
            );
        }

        $info['products'] = $a;

        // сохранение xml в файл
        $xml = XML_Creator::CreateFromArray(array('order' => $info));

        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/export/order/order'.$order->getId().'.xml',
            $xml->__toString(),
            LOCK_EX
        );
    }

    /**
     * Выгрузить заказ в CSV
     *
     * @param ShopOrder $order
     */
    protected function _orderCSV(ShopOrder $order) {
        $csv = array();

        $csv[] = 'orderid; '.$order->getId();
        $csv[] = 'ordernumber; '.$order->getNumber();
        $csv[] = 'ordername; '.$order->getName();
        $csv[] = 'datetime; '.$order->getCdate();
        $csv[] = 'userid; '.$order->getUserid();
        $csv[] = 'statusid; '.$order->getStatusid();
        try {
            $csv[] = 'statusname; '.$order->getStatus()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        $csv[] = 'clientname; '.$order->getClientname();
        $csv[] = 'clientphone; '.$order->getClientphone();
        $csv[] = 'clientemail; '.$order->getClientemail();
        $csv[] = 'clientcontacts; '.$order->getClientcontacts();
        $csv[] = 'clientaddress; '.$order->getClientaddress();
        $csv[] = 'sum; '.$order->getSum();
        $csv[] = 'currency; '.$order->getCurrency()->getName();
        try {
            $csv[] = 'deliveryid; '.$order->getDeliveryid();
            $csv[] = 'deliveryprice; '.$order->getDeliveryprice();
            $csv[] = 'deliveryname; '.$order->getDelivery()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        $a = array();
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            $currency = $op->getCurrency();

            $csv[] = 'orderproduct; name; '.$op->getProductname();
            $csv[] = 'orderproduct; count; '.$op->getProductcount();
            $csv[] = 'orderproduct; price; '.$op->getProductprice();
            $csv[] = 'orderproduct; productid; '.$op->getProductid();
            $csv[] = 'orderproduct; sum; '.$op->makeSum($currency);
            $csv[] = 'orderproduct; currency; '.$op->getCurrency()->getName();
        }

        // сохранение xml в файл
        file_put_contents(
            PackageLoader::Get()->getProjectPath().'/media/export/order/order'.$order->getId().'.csv',
            implode("\r", $csv),
            LOCK_EX
        );
    }

    /**
     * Если у пользователя не прописаны данные, записываем их из заказа
     *
     * @param User $user
     * @param ShopOrder $order
     */
    public function updateUserInfoByOrder (User $user, ShopOrder $order) {
        if (!$user->getAddress()) {
            $user->setAddress($order->getClientaddress());
        }

        if (!$user->getPhone()) {
            $user->setPhone($order->getClientphone());
        }
        if (!$user->getEmail()) {
            $user->setEmail($order->getClientemail());
        }

        if (!$user->getName()) {
            $user->setName($order->getClientname());
        }

        $user->update();
    }

    /**
     * Обработать шаблон $tpl, подставить в него все необходимые переменные из заказа
     * и вернуть обработанный html.
     *
     * @param ShopOrder $order
     * @param string $tpl
     *
     * @return string
     */
    public function makeOrderTemplate(ShopOrder $order, $tpl) {
        $assignArray = array();

        // получаем валюту заказа
        $currencyDefault = $order->getCurrency();

        // оплачен ли заказ?
        $canDownload = $order->getStatus()->getDownloadable();

        /**
         * Важно:
         * Фактически, заказ может быть оформлен в гривне,
         * но внутри заказ могут быть строки в разных валютах.
         * В таком случае уведомления нужно высылать в валюте заказа, то есть
         * все конвертируем в гривны.
         */

        $a = array();
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            if ($op->getProductid()) {
                $url = false;
                if ($canDownload) {
                    try {
                        $url = $this->makeProductDownloadURL($op->getProduct());
                        $url = Engine::Get()->getProjectURL().'/'.$url;
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }

                try {
                    $code = $op->getProduct()->makeCode();
                } catch (Exception $e) {
                    $code = $op->getProductid();
                }

                $a[] = array(
                'name' => $op->getProductname(),
                'count' => $op->getProductcount(),
                'price' => $op->makePrice($currencyDefault),
                'productid' => $code,
                'sum' => $op->makeSum($currencyDefault),
                'url' => $url,
                'comment' => $op->getComment(),
                );
            }

        }

        $assignArray['basketsArray'] = $a;

        $assignArray['clientname'] = htmlspecialchars($order->getClientname());
        $assignArray['clientemail'] = htmlspecialchars($order->getClientemail());
        $assignArray['clientphone'] = htmlspecialchars($order->getClientphone());
        $assignArray['clientaddress'] = htmlspecialchars($order->getClientaddress());
        $assignArray['clientcontacts'] = nl2br(htmlspecialchars($order->getClientcontacts()));
        $assignArray['comments'] = nl2br(htmlspecialchars($order->getComments()));
        $assignArray['trackurl'] = Engine::Get()->getProjectURL().'/order/'.$order->getHash().'/';

        // проверим существование shop-admin-orders-control
        try {
            Engine::GetContentDriver()->getContent('shop-admin-orders-control');
            $assignArray['urledit'] = Engine::Get()->getProjectURL().$order->makeURLEdit();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        $assignArray['signature'] = Shop::Get()->getSettingsService()->getSettingValue('letter-signature');

        // накладная доставки
        $assignArray['deliveryNote'] = htmlspecialchars($order->getDeliverynote());

        if ($order->getManagerid()) {
            try {
                $manager = $order->getManager();
                $assignArray['managername'] = htmlspecialchars($manager->getName());
                $assignArray['manageremail'] = htmlspecialchars($manager->getEmail());
                $assignArray['managerphone'] = htmlspecialchars($manager->getPhone());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }

        $assignArray['status'] = $order->getStatus()->makeName();
        $assignArray['date'] = DateTime_Formatter::DateTimeRussianGOST($order->getCdate());
        $assignArray['projecturl'] = Engine::Get()->getProjectURL();
        $assignArray['orderid'] = $order->getId();
        $assignArray['name'] = htmlspecialchars($order->getName());
        $assignArray['shopname'] = Shop::Get()->getSettingsService()->getSettingValue('shop-name');

        // сумма и валюта заказа
        $assignArray['ordersum'] = $order->getSum() + $order->getDeliveryprice(); // c учетом доставки
        $assignArray['ordersumbase'] = $order->getSum(); // без учата доставки
        $assignArray['deliveryPrice'] = $order->getDeliveryprice(); // стоимость доставки
        $assignArray['discountSum'] = $order->getDiscountsum(); // скидка
        $assignArray['ordercurrency'] = $currencyDefault->getSymbol();

        $employers = $this->getEmployersByOrder($order);
        $employers->setStatusid($order->getStatusid());
        $employers = $employers->getNext();
        if ($employers) {
            $assignArray['employerTerm'] = $employers->getTerm();
        }

        // обрабатываем данные
        return Engine::GetSmarty()->fetchString($tpl, $assignArray);
    }

    /**
     * Сформировать список юзеров, которым надо отправить уведомление.
     * Комментарий нужен чтобы определять юзеров в тексте.
     *
     * @param ShopOrder $order
     * @param string $comment
     *
     * @deprecated
     */
    public function getOrderUserNotifyArray(ShopOrder $order, $comment) {
        return Shop::Get()->getNotificationService()->getOrderUserNotifyArray($order, $comment);
    }

    /**
     * Отправка уведомления о новом комментарии к заказу
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $excludeNotifyUserArray
     *
     * @deprecated
     */
    public function orderEmailNotification(ShopOrder $order, $user, $comment, $excludeNotifyUserArray = false) {
        Shop::Get()->getNotificationService()->orderEmailNotification($order, $user, $comment, $excludeNotifyUserArray);
    }

    /**
     * Получить уведомления для пользователя
     *
     * @param User $user
     *
     * @return ShopNotification
     *
     * @deprecated
     */
    public function getNotificationsByUser(User $user) {
        return Shop::Get()->getNotificationService()->getNotificationsByUser($user);
    }

    /**
     * Построить кеш уведомлений.
     * Кеш записывается в JSON-файлы.
     *
     * @param User $user
     *
     * @return array
     *
     * @deprecated
     */
    public function buildNotificationCache(User $user) {
        return Shop::Get()->getNotificationService()->buildNotificationCache($user);
    }

    /**
     * Добавить уведомления всем причастным пользователям о новом комментарии к заказу
     *
     * @param ShopOrder $order
     * @param CommentsAPI_XComment $comment
     *
     * @deprecated
     */
    public function addNotification(ShopOrder $order, CommentsAPI_XComment $comment, $user) {
        Shop::Get()->getNotificationService()->addNotification($order, $comment, $user);
    }

    /**
     * Удалить уведомления для пользователя по заказу
     *
     * @param User $user
     * @param ShopOrder $order
     *
     * @deprecated
     */
    public function deleteNotification(User $user, ShopOrder $order) {
        return Shop::Get()->getNotificationService()->deleteNotification($user, $order);
    }

    /**
     * Отправить группированные уведомления пользователю $user
     *
     * @param User $user
     *
     * @deprecated
     */
    public function orderEmailNotificationGroup(User $user) {
        Shop::Get()->getNotificationService()->orderEmailNotificationGroup($user);
    }

    /**
     * Получить имя типа задач
     *
     * @param $type
     *
     * @return string
     *
     * @deprecated
     */
    public function getTypeName($type) {
        return WorkflowService::Get()->getWorkflowTypeName($type);
    }

    /**
     * Получить все заказы.
     * $user нужен чтобы наложить права доступа (ACL)
     *
     * @param User $user
     *
     * @return ShopOrder
     */
    public function getOrdersAll($user = false, $includeIssues = false, $aclType = 'orders') {
        $orders = new ShopOrder();

        if (!$includeIssues) {
            $orders->setIssue(0);
        }

        $orders->setDeleted(0);
        $orders->setOrder('id', 'DESC');

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $orders;
            }

            if ($user->isAllowed($aclType.'-all-view')) {
                return $orders;
            }

            // умный ACL
            $smartACL = !Engine::Get()->getConfigFieldSecure('acl-smart-disabled');

            $userID = $user->getId();

            $whereArray = array();

            if ($aclType == 'orders') {
                $direction = array(-1);
                if ($user->isAllowed('orders-direction-in')) {
                    $direction[] = 0;
                }
                if ($user->isAllowed('orders-direction-out')) {
                    $direction[] = 1;
                }
                $whereArray[] ='(shoporder.outcoming IN ('.implode(',', $direction).'))';
            }

            // фильтр по менеджеру заказа
            if ($user->isDenied($aclType.'-manager-all-view')) {
                $managers = Shop::Get()->getUserService()->getUsersManagers();
                $managerIDArray = array($userID); // свои заказы видно всегда
                while ($m = $managers->getNext()) {
                    if ($user->isAllowed($aclType.'-manager-'.$m->getId().'-view')) {
                        $managerIDArray[] = $m->getId();
                    }
                }

                if ($smartACL) {
                    $strWhereSmartAcl = "(
                        shoporder.managerid IN (".implode(',', $managerIDArray).")
                        OR shoporder.authorid IN (".implode(',', $managerIDArray).")";

                    if (!Engine::Get()->getConfigFieldSecure('acl-smart-employer-disabled')) {
                        $strWhereSmartAcl .= " OR EXISTS (
                            SELECT *
                            FROM shoporderemployer
                            WHERE
                            shoporderemployer.orderid=shoporder.id
                            AND shoporderemployer.managerid IN (".implode(',', $managerIDArray).")
                            )";
                    }
                    $strWhereSmartAcl .= ")";

                    $whereArray[] = $strWhereSmartAcl;
                }
            }

            // фильтр по статусу
            if ($user->isDenied($aclType.'-status-all-view')) {
                $status = WorkflowService::Get()->getStatusAll();
                $statusIDs = array(-1);
                while ($s = $status->getNext()) {
                    if ($user->isAllowed($aclType.'-status-'.$s->getId().'-view')) {
                        $statusIDs[] = $s->getId();
                    }
                }
                $whereArray[] = '(shoporder.statusid IN ('.implode(', ', $statusIDs).'))';
            }

            // фильтр по категории (бизнес-процессу)
            if ($user->isDenied($aclType.'-category-all-view')) {
                $categoryIDArray = array(-1);
                if ($user->isAllowed($aclType.'-category-0-view')) {
                    $categoryIDArray[] = 0;
                }
                $categories = Shop::Get()->getShopService()->getOrderCategoryAll();
                while ($c = $categories->getNext()) {
                    if ($user->isAllowed($aclType.'-category-'.$c->getId().'-view')) {
                        $categoryIDArray[] = $c->getId();
                    }
                }
                $whereArray[] = '(shoporder.categoryid IN ('.implode(', ', $categoryIDArray).'))';
            }

            if ($whereArray) {
                $tmpArray = array();
                $tmpArray[] = "(".implode(' AND ', $whereArray).")";

                if ($smartACL) {
                    $tmpArray[] = "shoporder.authorid={$user->getId()}";
                    $tmpArray[] = "shoporder.managerid={$user->getId()}";
                }

                $orders->addWhereQuery("(".implode(' OR ', $tmpArray).")");
            }
        }

        return $orders;
    }

    /**
     * Получить заказ по ID
     *
     * @return ShopOrder
     */
    public function getOrderByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopOrder');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('ShopOrder by id not found');
    }

    /**
     * Получить заказ по linkkey (привязке)
     *
     * @return ShopOrder
     */
    public function getOrderByLinkkey($linkkey) {
        $order = new ShopOrder();
        $order->setDeleted(0);
        $order->setLinkkey($linkkey);
        if ($order->select()) {
            return $order;
        }
        throw new ServiceUtils_Exception('ShopOrder by linkkey not found');
    }

    /**
     * Получить order по code1c
     *
     * @param int $code1c
     *
     * @return ShopOrder
     */
    public function getOrderByCode1c($code1c) {
        try {
            return $this->getObjectByField('code1c', $code1c, 'XShopOrder');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('ShopOrder by code1c not found');
    }

    /**
     * Получить заказ по его md5-хешу
     *
     * @return ShopOrder
     */
    public function getOrderByHash($hash) {
        $order = new ShopOrder();
        $order->setHash($hash);
        if ($order->select()) {
            return $order;
        } else {
            throw new ServiceUtils_Exception();
        }
    }

    /**
     * Получить товары в заказе
     *
     * @param ShopOrder $order
     *
     * @return ShopOrderProduct
     */
    public function getOrderProducts(ShopOrder $order) {
        $x = new ShopOrderProduct();
        $x->setOrderid($order->getId());
        return $x;
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
     * Получить наблюдателей задачи
     *
     * @param ShopOrder $order
     *
     * @return ShopOrderEmployer
     */
    public function getEmployersByOrder(ShopOrder $order) {
        $x = new ShopOrderEmployer();
        $x->setOrderid($order->getId());
        return $x;
    }

    /**
     * Является ли $user наблюдателем в $order
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return bool
     */
    public function isEmployer(ShopOrder $order, User $user) {
        $x = new ShopOrderEmployer();
        $x->setOrderid($order->getId());
        $x->setManagerid($user->getId());
        if ($x->select()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Добавить наблюдателя в задачу
     *
     * @param ShopOrder $order
     * @param User $user
     *
     * @return ShopOrderEmployer
     */
    public function addOrderEmployer(ShopOrder $order, User $user) {
        try {
            SQLObject::TransactionStart();

            $x = new ShopOrderEmployer();
            $x->setOrderid($order->getId());
            $x->setManagerid($user->getId());
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
     * Удалить наблюдателя из задачи
     *
     * @param ShopOrder $order
     * @param User $user
     */
    public function deleteOrderEmployer(ShopOrder $order, User $user) {
        try {
            SQLObject::TransactionStart();

            $x = new ShopOrderEmployer();
            $x->setOrderid($order->getId());
            $x->setManagerid($user->getId());
            $x->delete(true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function formatComment($text, $fileKey, $firstComment = false, $type = false, $spaces = false) {

        $text = htmlspecialchars($text);
        PackageLoader::Get()->import('TextProcessor');
        $processor = new TextProcessor_ActionTextToHTML();
        $text = $processor->process($text, $spaces);

        $fileKey = trim($fileKey);
        $this->_fileReplaceCallbackKey = $fileKey;

        // получаем id всех файлов
        $filesArray = array();
        if (preg_match_all("/\[file\](\d+)\[\/file\]/ius", $text, $r)) {
            $filesArray = $r[1];
        }

        /*$filesArray[] = preg_replace_callback(
            "/\[file\](\d+)\[\/file\]/ius", array($this, '_filesGetIdCallback'), $text
        );*/
        $text = preg_replace_callback(
            "/\[file\](\d+)\[\/file\](<br \/>){0,2}/ius",
            array($this, '_fileReplaceCallback'),
            $text
        );

        $text = preg_replace_callback("/\[([\w\s]*)\#(\d+)\s*(\#\d+)*\]*]/ius", array($this, '_contactReplace'), $text);

        if ($type == 'document') {
            $text = preg_replace_callback("/\\#(\d+)/ius", array($this, '_documentReplace'), $text);
        } else {
            $text = preg_replace_callback("/\\#(\d+)/ius", array($this, '_orderReplace'), $text);
        }

        if (preg_match_all("/(?<!<span>)((?<=\s|^)F(\d+))($|\s)/ius", $text, $r)) {
            foreach ($r[2] as $code => $val) {
                $file = new ShopFile($r[2][$code]);
                $fileName = $file->getName();
                if (!$fileName) {
                    $fileName = 'NoName '.$r[2][$code];
                }
                if ($file->getId()) {
                    $makeUrl = '<a href="' . $file->makeURL() . '">' . $fileName .
                        '</a>'." <span>F" . $r[2][$code]."</span>";
                    $text = str_replace("F" . $r[2][$code], $makeUrl, $text);
                }
            }
        }

        // добавляем картинки в низ
        if ($filesArray) {
            $text = $this->_commentImagePreview($text, $filesArray, $firstComment);
        }

        // тег [code] ... [/code]
        $text = preg_replace_callback("/\[code\](.+?)\[\/code\]/ius", array($this, '_codeReplaceCallback'), $text);

        // тег [quote] ... [/quote]
        $text = preg_replace_callback("/\[quote\](.+?)\[\/quote\]/ius", array($this, '_quoteReplaceCallback'), $text);

        return $text;
    }

    private function _filesGetIdCallback($fileid) {
        return $fileid[1];
    }

    private function _codeReplaceCallback($x) {
        $x = str_replace("<br />\n", "\n", $x[1]);
        return '<code><pre>'.$x.'</pre></code>';
    }

    private function _quoteReplaceCallback($x) {
        $x = str_replace("<br />\n", "\n", $x[1]);
        return '<blockquote>'.$x.'</blockquote>';
    }

    private function _fileReplaceCallback($x) {
        return $this->_fileReplace(
            $x[1],
            $this->_fileReplaceCallbackKey
        );
    }

    private function _fileReplace($fileID, $fileKey) {
        return false;
        $tmp = new ShopFile($fileID);
        if (!$tmp->getId()) {
            return $fileID;
        }

        if ($fileKey && $tmp->getKey() != $fileKey) {
            $fileOrderID = false;
            $keyOrderID = false;

            // костыль, но что поделаешь

            if (preg_match("/^order-(\d+)$/ius", $tmp->getKey(), $r)) {
                $fileOrderID = $r[1];
            }

            if (preg_match("/^order-(\d+)$/ius", $fileKey, $r)) {
                $keyOrderID = $r[1];
            }

            if (!$fileOrderID || !$keyOrderID) {
                return $fileID;
            }

            $ok = false;

            try {
                $keyOrder = $this->getOrderByID($keyOrderID);

                while ($x = $keyOrder->getParent()) {
                    if ($x->getId() == $fileOrderID) {
                        $ok = true;
                        break;
                    } else {
                        $keyOrder = $x;
                    }
                }
            } catch (ServiceUtils_Exception $se) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }

            try {
                $fileOrder = $this->getOrderByID($fileOrderID);

                while ($x = $fileOrder->getParent()) {
                    if ($x->getId() == $keyOrderID) {
                        $ok = true;
                        break;
                    } else {
                        $fileOrder = $x;
                    }
                }
            } catch (ServiceUtils_Exception $se) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $se;
                }
            }

            if (!$ok) {
                return $fileID;
            }
        }

        return "<a href=\"{$tmp->makeURL()}\">{$tmp->getName()}</a> <span>F" . $fileID."</span>";
    }

    private function _commentImagePreview($text, $filesArray) {
        $first = 1;

        foreach ($filesArray as $fileId) {
            try{
                $tmp = new ShopFile($fileId);
                if (!$tmp->getId()) {
                    continue;
                }

                if (substr_count($tmp->getContenttype(), 'image/') && !substr_count($tmp->getName(), '.psd')) {
                    $path = str_replace(PackageLoader::Get()->getProjectPath(), '/', $tmp->makePath());
                    $result = "<a class='ob-image-preview js-colorbox-preview' href='{$tmp->makeURL()}'>
                    <span class='image' style='background-image: url({$path});'>
                    <span class='id'>F".$tmp->getId()."</span></span>
                    <span class='name'>{$tmp->getName()}</span></a>";

                    $text .= $result;
                } else {
                    $result = "<a class='ob-image-preview' href='{$tmp->makeURL()}'>
                    <span class='image file'><span class='id'>F".$tmp->getId()."</span>".
                        end(explode(".", $tmp->getName())).
                        "</span>
                    <span class='name'>{$tmp->getName()}</span></a>";

                    $text .= $result;
                }

            } catch (Exception $ef) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $ef;
                }
            }

        }
        return $text;

    }

    private function _contactReplace($x) {
        $contactName = $x[1];
        $contactID = $x[2];
        $contactName = trim($contactName);
        try {
            $contact = Shop::Get()->getUserService()->getUserByID($contactID);

            $result = "<a href=\"{$contact->makeURLEdit()}\" data-id=\"{$contact->getId()}\"";
            $result .= " class=\"js-contact-preview\">{$contactName}</a>";

            return $result;
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        return $contactName;
    }

    private function _orderReplace($x) {
        $orderID = $x[1];

        try {
            $order = Shop::Get()->getShopService()->getOrderByID($orderID);

            $result = "<a href=\"{$order->makeURLEdit()}\" data-id=\"{$order->getId()}\"";
            $result .= " class=\"js-issue-preview\">#{$orderID}</a>";

            return $result;

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        return '#'.$orderID;
    }

    private function _documentReplace($x) {
        $documentID = $x[1];

        try {
            $document = DocumentService::Get()->getDocumentByID($documentID);

            $result = "<a href=\"{$document->makeURLEdit()}\" data-id=\"{$document->getId()}\"";
            $result .= " class=\"js-issue-preview\">#{$documentID}</a>";

            return $result;

        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }

        return '#'.$documentID;
    }

    /**
     * Обновить товар
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
    public function updateProduct(ShopProduct $product, $name, $description, $categoryID, $brandID,
    $model, $price, $priceold, $currencyID, $unit, $barcode, $discount, $preorderDiscount,
    $warranty, $hidden, $deleted, $avail, $availText, $syncable, $url, $image, $deleteImage,
    $collectionID, $width, $height, $length, $weight, $unitbox, $delivery, $payment, $divisibility,
    $userID, $denycomments, $notdiscount, $maxdiscount, $siteURL, $tax, $descriptionshort, $name1, $name2, $code1c,
    $codesupplier, $characteristics, $share, $seotitle, $seodescription, $seocontent,
    $seokeywords, $icon = false, $downloadFile = false, $deleteDownloadFile = false,
    $datelifefrom = false, $datelifeto = false, $articul = false, $suppliered = false  ) {
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
            $url = preg_replace('/([\-&])/ius', '', $url);

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

            $url = preg_replace('/([\-]{2,})/ius', '-', $url);
            $url = preg_replace('/([\-&])/ius', '', $url);

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

    public function updateTypeOrders () {
        ModeService::Get()->verbose('Process workflow types...');

        $workflows = WorkflowService::Get()->getWorkflowsAll();
        $workflows->setChangeType(1);
        while ($w = $workflows->getNext()) {

            $workflowType = $w->getType();
            if (!$workflowType) {
                $workflowType = 'order';
            }

            $orders = Shop::Get()->getShopService()->getOrdersAll();
            $orders->setCategoryid($w->getId());
            $orders->addWhere('type', $workflowType, '<>');
            while ($x = $orders->getNext()) {
                $x->setType($workflowType);
                $x->update();
            }
        }
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
     * Обновить аватар/логотип контакта
     *
     * @param User $user
     * @param string $image
     *
     * @deprecated
     */
    public function updateUserAvatarImage(User $user, $image) {
        return Shop::Get()->getUserService()->updateUserImage($user, $image);
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
     * Сменить проект задачи и изменить клиента, из нового проекта(если есть)
     *
     * @param ShopOrder $order
     * @param User $user
     * @param ShopOrder $project
     *
     * @throws Exception
     */
    public function updateIssueParent(ShopOrder $order, User $user, ShopOrder $project) {
        $order->setParentid($project->getId());
        $order->update();

        $comment = 'Проект изменен на '.$project->makeName();
        // делаем запись в комментарий
        $this->addOrderChange($order, $user, $comment);

        if ($project->getUserid()) {
            try{
                $this->updateOrderUser($order, $user, $project->getClient());
            } catch (Exception $eu) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $eu;
                }
            }
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
     * Добавить изображение товару
     *
     * @param ShopProduct $product
     * @param string $image
     *
     * @deprecated
     *
     * @see addProductImage()
     *
     * @return ShopImage
     */
    public function addProductImageByImageUrl(ShopProduct $product, $image) {
        return $this->addProductImage($product, $image);
    }

    /**
     * Добавить главное изображение товару
     *
     * @param ShopProduct $product
     * @param string $image
     *
     * @deprecated
     *
     * @see updateProductImage()
     *
     * @return ShopProduct
     */
    public function addProductMainImageByImageUrl(ShopProduct $product, $image) {
        return $this->updateProductImage($product, $image);
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
     * Получить следующие статусы по Бизнес-процессу
     *
     * @param ShopOrderCategory $workflow
     * @param ShopOrderStatus $status
     *
     * @return ShopOrderStatus
     *
     * @deprecated
     */
    public function getStatusNextByWorkflow(ShopOrderCategory $workflow, ShopOrderStatus $status) {
        return WorkflowService::Get()->getStatusNextByWorkflow($workflow, $status);
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
     * Получить все расписание работы магазина
     *
     * @return XShopTimework
     */
    public function getTimeworkAll() {
        $x = new XShopTimework();
        $x->setOrder('datefrom', 'DESC');
        return $x;
    }

    /**
     * Получить расписание по ID
     *
     * @return XShopTimework
     */
    public function getTimeworkByID($id) {
        try {
            return $this->getObjectByID($id, 'XShopTimework');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить расписание работы системы
     *
     * @todo to module
     *
     * @return XShopTimework
     */
    public function getTimeworkCurrent() {
        $x = new XShopTimework();
        $x->addWhereQuery("(`datefrom` <= NOW())");
        $x->addWhereQuery("(`dateto` >= NOW())");
        return $x;
    }

    /**
     * Получить все логотипы
     *
     * @return ShopLogo
     */
    public function getLogoAll() {
        $x = new ShopLogo();
        return $x;
    }

    /**
     * Получить логотип по ID
     *
     * @return ShopLogo
     */
    public function getLogoByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopLogo');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить текущий логотип
     *
     * @return ShopLogo
     */
    public function getLogoCurrent() {
        // строим кеш логотипов
        if ($this->_logoArray === false) {
            $this->_logoArray = array();
            $logo = $this->getLogoAll();
            while ($x = $logo->getNext()) {
                $this->_logoArray[] = $x;
            }
        }

        $default = false;
        $dateNow = date('Y-m-d H:i:s');

        foreach ($this->_logoArray as $x) {

            // если логотип по умолчанию - это он
            if ($x->getDefault()) {
                $default = $x;
            }

            if ($x->getSdate() <= $dateNow
            && $x->getEdate() >= $dateNow
            ) {
                return $x;
            }
        }

        if (!$default) throw new ServiceUtils_Exception();

        // возвращаем логотип по умолчанию
        return $default;
    }

    /**
     * Получить массив подзадач и их подзадач и тд
     *
     * @param ShopOrder $order
     *
     * @return array
     */
    public function getOrderChilds(ShopOrder $order) {
        $a = array();
        $orderId = $order->getId();
        $orders = $this->getOrdersAll();
        $orders->setParentid($orderId);
        while ($x = $orders->getNext()) {
            $a[] = $x;

            $b = $this->getOrderChilds($x);
            if (count($b)) {
                $a = array_merge($a, $b);
            }

        }
        return $a;
    }

    /**
     * Получить все юр лица
     *
     * @return ShopContractor
     */
    public function getContractorsAll() {
        $x = new ShopContractor();
        return $x;
    }

    /**
     * Получить все активные юр лица
     *
     * @return ShopContractor
     */
    public function getContractorsActive() {
        $x = $this->getContractorsAll();
        $x->setActive(1);
        return $x;
    }

    /**
     * Получить юридическое лицо по ID
     *
     * @return ShopContractor
     */
    public function getContractorByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopContractor');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object(ShopContractor) by id not found');
    }

    /**
     * Получить активное юр лицо
     *
     * @return ShopContractor
     */
    public function getContractorDefault() {
        $x = $this->getContractorsActive();

        // ищем юр лицо по умолчанию
        $x->setDefault(1);
        if ($y = $x->getNext()) {
            return $y;
        }

        // если по умолчанию нет, ищем первого активного
        $x->setDefault(0);
        if ($y = $x->getNext()) {
            return $y;
        }

        // если активного нет - ошибка
        throw new ServiceUtils_Exception('Shop-object(ShopContractor setActive = 1) not found');

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
     * Построить URL-префикс исходя из текста
     *
     * @param string $text
     *
     * @return string
     */
    public function buildURL($text) {
        $text = trim($text);
        $text = StringUtils_Transliterate::TransliterateRuToEn($text);

        $text = preg_replace("/[^a-z0-9-_\s]/ius", '', $text);
        $text = preg_replace("/\s+/ius", '-', $text);

        $text = strtolower($text);

        if (!$text) {
            throw new ServiceUtils_Exception();
        }

        return $text;
    }

    /**
     * Проверка URL на уникальность.
     * false - если такой URL есть
     * true - если такого URL еще нет
     *
     * @param string $url
     *
     * @return bool
     */
    public function checkURLUnique($url) {
        $url = trim($url);

        if (!$url) {
            return false;
        }

        $tmp = new XShopProduct();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        $tmp = new XShopCategory();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        $tmp = new XShopBrand();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        $tmp = new XShopTextPage();
        $tmp->setUrl($url);
        if ($tmp->select()) {
            return false;
        }

        return true;
    }

    /**
     * Универсальный калькулятор стоимости.
     * Работает в одной валюте.
     *
     * Умеет учитывать и возвращать сумму и значения скидки, НДС.
     *
     * Метод внутри раскладывает сумму по правилам подсчета:
     * Снимает НДС, снимает скидки.
     *
     * @param float $sum
     * @param float $tax
     * @param float $discountPercent
     * @param float $discountSum
     * @param bool $resultSum
     * @param bool $resultTax
     * @param bool $resultDiscount
     *
     * @uses оформление заказа, печать документов, редактирование заказа
     *
     * @return float
     */
    public function calculateSum($sum, $tax = false, $discountPercent = false, $discountSum = false,
        $resultSum = true, $resultTax = true, $resultDiscount = true) {

        $sum = round($sum, 2);

        // от суммы сразу отнимаем VAT tax
        if ($tax > 0) {
            $sum_result = round($sum / (1 + $tax / 100), 2);
            $sum_tax = round($sum - $sum_result, 2);
        } else {
            $sum_result = $sum;
            $sum_tax = 0;
        }

        // снимаем процентную скидку
        if ($discountPercent > 0) {
            $x = round($sum_result * (1 - $discountPercent / 100), 2);
            if ($x > 0) {
                $sum_discount = round($sum_result - $x, 2);
                $sum_result = $x;
            } else {
                // ничего не осталось
                $sum_discount = $sum_result;
                $sum_result = 0;
            }
        } else {
            $sum_discount = 0;
        }

        // снимаем абсолютную скидку
        if ($discountSum) {
            $x = round($sum_result - $discountSum, 2);
            if ($x > 0) {
                // что-то осталось
                $sum_discount += $discountSum;
                $sum_result = $x;
            } else {
                // ничего не осталось
                $sum_result = 0;
                $sum_discount += ($discountSum + $x);
                $sum_discount = round($sum_discount, 2);
            }
        }

        $result = 0;
        if ($resultSum) {
            $result += $sum_result;
        }
        if ($resultDiscount) {
            $result += $sum_discount;
        }
        if ($resultTax) {
            $result += $sum_tax;
        }

        return round($result, 2);
    }

    /**
     * Посчитать сумму заказа с учетом всех подзадач
     *
     * @param ShopOrder $order
     *
     * @return float
     */
    public function calculateOrderSum(ShopOrder $order) {
        $sum = $order->getSum();

        $childs = $this->getOrdersAll(false, true);
        $childs->setParentid($order->getId());
        while ($x = $childs->getNext()) {
            if ($x->getId() == $x->getParentid()) {
                continue;
            }
            $tmp = $this->calculateOrderSum($x);

            $tmp = Shop::Get()->getCurrencyService()->convertCurrency(
                $tmp,
                $x->getCurrency(),
                $order->getCurrency()
            );

            $sum += $tmp;
        }

        return $sum;
    }

    /**
     * Получить шаблон (обертку, wrap) для письма.
     * В качестве template надо передавать имя файла.
     * Если параметр $template не передан - то возвращается обертка по умолчанию,
     * если она есть.
     *
     * @param string $template
     *
     * @return string
     */
    public function getMailTemplate($template = false) {
        if (!$template) {
            $template = Shop::Get()->getSettingsService()->getSettingValue('letter-template');
        }

        if (!$template) {
            return '';
        }

        $template = @file_get_contents(PROJECT_PATH.$template);
        if (!$template) {
            return '';
        }

        $assignArray = array();
        $phones = Shop::Get()->getSettingsService()->getSettingValue('header-phone');
        $phones = str_replace(';', ',', $phones);
        $phones = str_replace(',,', ',', $phones);
        $phones = explode(',', $phones);
        $email = Shop::Get()->getSettingsService()->getSettingValue('header-email');
        $name = Shop::Get()->getSettingsService()->getSettingValue('shop-company');
        $host = 'http://'.Engine::Get()->getProjectHost();

        $logoImage = false;
        try {
            $logo = Shop::Get()->getShopService()->getLogoCurrent();
            $logoImage = $logo->makeImage();
            $imageSize = getimagesize(PackageLoader::Get()->getProjectPath().$logoImage);

            if ($imageSize[0] > 60 || $imageSize[1] > 500) {
                $logoImage = ImageProcessor_Thumber::MakeThumbProportional(
                    PackageLoader::Get()->getProjectPath().$logoImage, 500, 60
                );
                $logoImage = str_replace(PackageLoader::Get()->getProjectPath(), '', $logoImage);
            }
        } catch (Exception $elogo) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $elogo;
            }
        }

        $assignArray['host'] = $host;
        $assignArray['logo'] = $logoImage;
        $assignArray['company_email'] = $email;
        $assignArray['company'] = $name;
        $assignArray['company_phone'] = $phones;

        $template = Engine::GetSmarty()->fetchString($template, $assignArray);
        return $template;
    }

    /**
     * Создать / обновить запись
     *
     * @param $linkkey
     * @param $data
     *
     * @return XShopSystemNotice
     *
     * @throws SQLObject_Exception
     * @throws ServiceUtils_Exception
     */
    public function addSystemNotice ($linkkey, $data) {
        if (!$linkkey) {
            throw new ServiceUtils_Exception('no-linkkey');
        }

        $notice = new XShopSystemNotice();
        $notice->setLinkkey($linkkey);
        if ($notice->select()) {
            $notice->setData($data);
            $notice->update();
        } else {
            $notice->setData($data);
            $notice->insert();
        }

        return $notice;
    }

    /**
     * Вернуть значение записи по linkkey
     *
     * @param $linkkey
     *
     * @return bool|string
     *
     * @throws ServiceUtils_Exception
     */
    public function getSystemNoticeData($linkkey) {
        if (!$linkkey) {
            throw new ServiceUtils_Exception('no-linkkey');
        }

        $notice = new XShopSystemNotice();
        $notice->setLinkkey($linkkey);
        if ($notice = $notice->getNext()) {
            return $notice->getData();
        }

        return false;
    }


    /**
     * Удалить запись
     *
     * @param $linkkey
     *
     * @throws SQLObject_Exception
     * @throws ServiceUtils_Exception
     */
    public function deleteSystemNotice ($linkkey) {
        if (!$linkkey) {
            throw new ServiceUtils_Exception('no-linkkey');
        }

        $notice = new XShopSystemNotice();
        $notice->setLinkkey($linkkey);
        if ($notice = $notice->getNext()) {
            $notice->delete();
        }
    }

    /**
     * Отправить тикет-уведомление
     *
     * @param $name
     * @param $email
     * @param $message
     *
     * @todo remake to sendEmail
     *
     * @throws ServiceUtils_Exception
     */
    public function sendTicketSupport($name, $email, $message) {
        $ex = new ServiceUtils_Exception();

        if (!$name) {
            $ex->addError('name');
        }

        if (!$message) {
            $ex->addError('message');
        }

        if (!Checker::CheckEmail($email)) {
            $ex->addError('email');
        }

        if ($ex->getCount()) {
            throw $ex;
        }

        // отправка напрямую
        MailUtils_Config::Get()->setSender(new MailUtils_SenderMail());

        $tpl = MEDIA_PATH.'/mail-templates/shop-ticket-support.html';
        $sender = new MailUtils_SmartySender($tpl);
        $sender->setEmailFrom($email);
        $sender->addEmail('support@webproduction.ua');
        $sender->assign('name', $name);
        $sender->assign('message', nl2br($message));
        $sender->assign('email', $email);
        $sender->assign('host', Engine::Get()->getProjectURL());
        $sender->send();
    }


    /**
     * Импортировать входящий файл заказов из XLS
     */
    public function importTaskOrderXLS() {
        $task = new XShopImportOrder();
        $task->setPdate('0000-00-00 00:00:00');
        if (!$task->select()) {
            return;
        } elseif ($task->getTrycnt() > 2) {
            $emailBody = "Не удалось выполнить загрузку xls файла";

            // Delete task
            $task->delete();

            // отправляем письмо администратору
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

            // получаем все емейлы на которые нужно отправить уведомление
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');

            // отправляем
            foreach ($emailToArray as $emailTo) {
                $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Import#'.$task->getId().' done', $emailBody);
                $letter->send();
            }
            return;
        } else {
            $task->setTrycnt($task->getTrycnt() + 1);
            $task->update();
        }

        PackageLoader::Get()->import('XLS');

        $data = new XLS_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read(PackageLoader::Get()->getProjectPath().'media/import/'.$task->getFile());

        // читаем заголовки таблицы
        $headerArray = array();
        for ($i = 1; $i <= $data->sheets[0]['numCols']; $i++) {
            $headerName = $data->sheets[0]['cells'][1][$i];
            $headerName = trim($headerName);
            if (!$headerName) {
                continue;
            }

            $headerArray[$headerName] = $i;
        }
        $statAddedArray = array();
        $statErrorArray = array();

        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
            $linkkey = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['linkkey']])
            );
            $orderName = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['name']])
            );
            $orderCdate = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['cdate']])
            );
            $orderClientname = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['clientname']])
            );
            $orderClientEmail = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['clientemail']])
            );
            $orderClientPhone = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['clientphone']])
            );
            $orderClientAddress = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['clientaddress']])
            );
            $orderManagerName = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['managername']])
            );
            // название БП
            $workflowname = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['workflowname']])
            );
            // название статуса
            $statusname = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['statusname']])
            );
            // валюта
            $orderCurrency = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['currency']])
            );
            // оплаченная сумма
            $financePayed = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['financepayed']])
            );
            // название источника заказа
            $sourceName = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['sourcename']])
            );
            $productOrderArray = array();
            for ($j = 1; $j <= 20; $j++) {
                // проверяем, чтобы столбцы реально были
                if (!isset($headerArray['product'.$j.'name'])) {
                    continue;
                }
                $tmpName = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['product'.$j.'name']])
                );
                $tmpCount = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['product'.$j.'count']])
                );
                $tmpPrice = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['product'.$j.'price']])
                );

                if (!$tmpName) {
                    continue;
                }

                $productOrderArray[$j] = array(
                'name' => $tmpName,
                'count' => $tmpCount,
                'price' => $tmpPrice,
                );
            }

            // работаем с полученными данными
            try {

                // БП должен быть
                if (!$workflowname || !$statusname) {
                    $statErrorArray[] = $statErrorArray[] = trim('#'.$workflowname.' '.$orderCdate.' '.$orderName);
                    continue;
                }

                $workflows = WorkflowService::Get()->getWorkflowsAll();
                $workflows->setName($workflowname);
                $w = $workflows->getNext();
                if (!$w) {
                    $statErrorArray[] = $statErrorArray[] = trim('#'.$workflowname.' '.$orderCdate.' '.$orderName);
                    continue;
                }

                $statusW = WorkflowService::Get()->getStatusAll();
                $statusW->setName($statusname);
                $statusW->setCategoryid($w->getId());
                $s = $statusW->getNext();
                if (!$s) {
                    $statErrorArray[] = $statErrorArray[] = trim('#'.$workflowname.' '.$orderCdate.' '.$orderName);
                    continue;
                }

                $order = new ShopOrder();

                if ($linkkey) {
                    $order->setLinkkey($linkkey);
                    $o = $order->getNext();
                    if ($o) {
                        continue;
                    }
                } else {
                    $linkkey = 'importxls';
                }

                if ($orderCurrency !== '' && isset($headerArray['currency'])) {
                    try {
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($orderCurrency);
                        $currencyID = $currency->getId();
                    } catch (Exception $ex) {
                        continue;
                    }
                } else {
                    $currency = Shop::Get()->getCurrencyService()->getCurrencySystem();
                    $currencyID = $currency->getId();
                }
                $order->setCurrencyid($currencyID);


                SQLObject::TransactionStart();

                $clientID = false;
                try {
                    $userClients = Shop::Get()->getUserService()->findUserByContact($orderClientEmail, 'email');
                    $clientID = $userClients->getId();
                } catch (Exception $e) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }

                if (!$clientID) {
                    try {
                        $userClients = Shop::Get()->getUserService()->findUserByContact($orderClientPhone, 'phone');
                        $clientID = $userClients->getId();
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }
                if (!$clientID) {
                    try {
                        $userName = Shop::Get()->getUserService()->getUsersAll();
                        $userName->setName($orderClientname);
                        $u = $userName->getNext(true);
                        $clientID = $u->getId();
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }

                if (!$clientID) {
                    // создаем клиента
                    $client = Shop::Get()->getUserService()->getUsersAll();
                    $client->setName($orderClientname);
                    $client->setEmail($orderClientEmail);
                    $orderClientPhone = preg_replace("/[^0-9]/ius", '', $orderClientPhone);
                    $client->setPhone($orderClientPhone);
                    $client->setAddress($orderClientAddress);
                    $client->insert();
                    $clientID = $client->getId();
                }

                $managerID = false;
                if ($orderManagerName) {
                    try {
                        $manager = Shop::Get()->getUserService()->getUsersAll();
                        $manager->setName($orderManagerName);
                        $m = $manager->getNext(true);
                        $managerID = $m->getId();
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }

                // добавляем продукты, если их нет
                $arrayProd = array();
                foreach ($productOrderArray as $p) {
                    $productID = false;
                    try {
                        $product = Shop::Get()->getShopService()->getProductsAll();
                        $product->setName($p['name']);
                        $pr = $product->getNext(true);
                        $productID = $pr->getId();
                    } catch (Exception $productEx) {
                        $product = Shop::Get()->getShopService()->addProduct(
                            $p['name']
                        );
                        $product->setPrice($p['price']);
                        $product->setHidden(0);
                        $product->update();
                        $productID = $product->getId();
                    }

                    $arrayProd[] = array(
                        'id' => $productID,
                        'count' => $p['count'],
                        'price' => $p['price'],
                    );
                }

                // ставим ему linkkey-привязку (защита от дублей)
                $order->setLinkkey($linkkey);
                if ($orderClientname !== '' && isset($headerArray['clientname'])) {
                    $order->setClientname($orderClientname);
                }
                if ($orderClientEmail !== '' && isset($headerArray['clientemail'])) {
                    $order->setClientemail($orderClientEmail);
                }
                if ($orderClientPhone !== '' && isset($headerArray['clientphone'])) {
                    $order->setClientphone($orderClientPhone);
                }
                if ($orderClientAddress !== '' && isset($headerArray['clientaddress'])) {
                    $order->setClientaddress($orderClientAddress);
                }
                if ($orderCdate !== '' && isset($headerArray['cdate'])) {
                    $order->setCdate($orderCdate);
                }
                if ($orderName !== '' && isset($headerArray['name'])) {
                    $order->setName($orderName);
                }
                if ($managerID && isset($headerArray['managername'])) {
                    $order->setManagerid($managerID);
                }

                $workflows = WorkflowService::Get()->getWorkflowsAll();
                $workflows->setName($workflowname);
                $w = $workflows->getNext();
                if ($w) {
                    $order->setCategoryid($w->getId());
                }

                $statusW = WorkflowService::Get()->getStatusAll();
                $statusW->setName($statusname);
                $statusW->setCategoryid($w->getId());
                $s = $statusW->getNext();
                if ($s) {
                    $order->setStatusid($s->getId());
                }

                if ($sourceName !== '' && isset($headerArray['sourcename'])) {
                    $source = Shop::Get()->getShopService()->addSource($sourceName);
                    $order->setSourceid($source->getId());
                }

                $order->insert();

                $financePayed = (float) $financePayed;
                if ($financePayed !== '' && $financePayed > 0) {

                    //$order->setSum($financePayed);

                    $cuser = Shop::Get()->getUserService()->getUsersAll();
                    $cuser->setLevel(3);
                    $c = $cuser->getNext();

                    // берем первый попавшийся аккаунт
                    $account = new XFinanceAccount();
                    $account->setOrderBy('id');
                    $acc = $account->getNext();
                    $accountID = $acc->getId();
                    $comment = 'Оплата '.$orderName;
                    $payment = PaymentService::Get()->addPayment(
                        $c,
                        $accountID,
                        $financePayed,
                        'fromclient',
                        'proceed',
                        $orderCdate,
                        $clientID,
                        $cuser->getId(),
                        1,
                        false,
                        false,
                        false,
                        $comment,
                        false,
                        false,
                        $linkkey,
                        false,
                        false,
                        $order->getId()
                    );
                }

                // добавляем товары в заказ
                if (isset($arrayProd)) {
                    foreach ($arrayProd as $item) {
                        Shop::Get()->getShopService()->addOrderProduct(
                            $order,
                            $item['id'],
                            $item['count'],
                            $item['price']
                        );
                    }
                }

                Shop::Get()->getShopService()->recalculateOrderSums($order);

                $statAddedArray[] = $order;
                SQLObject::TransactionCommit();

            } catch (Exception $ex) {
                SQLObject::TransactionRollback();
                $statErrorArray[] = trim('#'.$workflowname.' '.$orderCdate.' '.$orderName);
            }

        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';
        foreach ($statAddedArray as $x) {
            $bodyArray[] = 'Добавлен новый : #'.$x->getId().' '.$x->getName();
        }
        foreach ($statErrorArray as $x) {
            $bodyArray[] = 'Пропущен : #'.$x;
        }
        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->getNotificationEmailArray('email-tehnical');

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Import#'.$task->getId().' done', $emailBody);
            $letter->send();
        }

        // сбрасываем кеш сразу
        try {
            Engine::GetCache()->clearCache();
        } catch (Exception $cacheEx) {
            ModeService::Get()->debug($cacheEx);
        }
    }

     /**
     * Импортировать входящий файл из XLS
     */
    public function importTaskXLS() {
        // выполняем импорт
        $task = new XShopImport();
        $task->setPdate('0000-00-00 00:00:00');
        if (!$task->select()) {
            return;
        } elseif ($task->getTrycnt() > 2) {
            $emailBody = "Не удалось выполнить загрузку xls файла";

            // Delete task
            $task->delete();

            // отправляем письмо администратору
            $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

            // получаем все емейлы на которые нужно отправить уведомление
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');

            // отправляем
            foreach ($emailToArray as $emailTo) {
                $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Import#'.$task->getId().' done', $emailBody);
                $letter->send();
            }
            return;
        } else {
            $task->setTrycnt($task->getTrycnt() + 1);
            $task->update();
        }

        PackageLoader::Get()->import('XLS');
        PackageLoader::Get()->import('CSV');
        $data = new XLS_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read(PackageLoader::Get()->getProjectPath().'media/import/'.$task->getFile());

        // читаем заголовки таблицы
        $headerArray = array();
        for ($i = 1; $i <= $data->sheets[0]['numCols']; $i++) {
            $headerName = $data->sheets[0]['cells'][1][$i];
            $headerName = trim($headerName);
            if (!$headerName) {
                continue;
            }

            $headerArray[$headerName] = $i;
        }

        $statAddedArray = array();
        $statUpdatedArray = array();
        $statErrorArray = array();

        // читаем данные по заголовкам
        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
            $productID = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['id']])
            );
            $productCode1c = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['code1c']])
            );
            $productName = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['name']])
            );
            $productTmpImageUrl = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['tmpimageurl']])
            );
            $productPrice = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['price']])
            );
            $productUnit = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['unit']])
            );
            $productPriceold = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['priceold']])
            );
            $productDiscount = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['discount']])
            );
            $productCurrency = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['currency']])
            );
            $productAction = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['action']])
            );
            $productBrand = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['brand']])
            );
            $productModel = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['model']])
            );
            $productArticul = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['articul']])
            );
            $productSeries = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['series']])
            );
            $productTags = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['tags']])
            );
            $productDescription = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['description']])
            );
            $productDescriptionShort = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['descriptionshort']])
            );
            $productCharacteristics = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['characteristics']])
            );
            $productUnitBox = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['unitbox']])
            );
            $productCategoryArray = array();
            for ($j = 1; $j <= 10; $j++) {
                $tmp = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['category'.$j]]));
                if (!$tmp) {
                    continue;
                }
                $productCategoryArray[$j] = $tmp;
            }
            $productHidden = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['hidden']])
            );
            $productDeleted = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['deleted']])
            );
            $productAvail = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['avail']])
            );
            $productAvailtext = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['availtext']])
            );
            $productBarcode = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['barcode']])
            );
            $productWidth = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['width']])
            );
            $productLength = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['length']])
            );
            $productHeight = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['height']])
            );
            $productWeight = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['weight']])
            );
            $productDivisibility = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['divisibility']])
            );
            $productSeoTitle = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['seotitle']])
            );
            $productSeoDescription = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['seodescription']])
            );
            $productSeoKeywords = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['seokeywords']])
            );
            $productSeoContent = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['seocontent']])
            );
            $productPricebase = @trim(
                iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['pricebase']])
            );
            $productPriceArray = array();
            for ($j = 1; $j <= 5; $j++) {
                $productPriceArray[$j] = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['price'.$j]])
                );
            }

            $productFilterArray = array();

            $filter_count = 100;

            for ($j = 1; $j <= $filter_count; $j++) {
                // проверяем, чтобы столбцы реально были
                if (!isset($headerArray['filter'.$j.'name'])) {
                    continue;
                }
                if (!isset($headerArray['filter'.$j.'value'])) {
                    continue;
                }

                $tmpName = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['filter'.$j.'name']])
                );
                $tmpValue = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['filter'.$j.'value']])
                );
                $tmpUse = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['filter'.$j.'use']])
                );
                $tmpActual = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['filter'.$j.'actual']])
                );
                $tmpOption = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['filter'.$j.'option']])
                );

                $productFilterArray[] = array(
                    'filterName' => $tmpName,
                    'filterValue' => $tmpValue,
                    'filterUse' => $tmpUse,
                    'filterActual' => $tmpActual,
                    'filterOption' => $tmpOption,
                );
            }

            $supplierArray = array();

            // импорт- количество 10 штук
            $supplier_count = 10;

            for ($j = 1; $j <= $supplier_count; $j++) {
                $tmpName = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['supplier'.$j.'name']])
                );
                $tmpCode = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['supplier'.$j.'code']])
                );
                $tmpPrice = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['supplier'.$j.'price']])
                );
                $tmpCurrency = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['supplier'.$j.'currency']])
                );
                $tmpAvailtext = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['supplier'.$j.'availtext']])
                );

                if ($tmpName === '') {
                    continue;
                }

                if ($tmpCode === '' || $tmpPrice === '') {
                    continue;
                }

                $supplierArray[$j] = array(
                    'name' => $tmpName,
                    'code' => $tmpCode,
                    'price' => $tmpPrice,
                    'currency' => $tmpCurrency,
                    'availtext' => $tmpAvailtext,
                );
            }

            // ID или имя должны быть
            if (!$productID && !$productName) {
                continue;
            }

            // работаем с полученными данными
            try {
                SQLObject::TransactionStart();

                // если ID нет - вставляем
                if (!$productID) {
                    // проверяем такой товар по имени
                    $product = new ShopProduct();
                    $product->setName($productName);
                    if (!Shop::Get()->getSettingsService()->getSettingValue('product-name-doublicates')) {
                        if ($product->select()) {
                            // товар в таким именем уже есть
                            throw new ServiceUtils_Exception();
                        }
                    }

                    // вставляем товар
                    $product = new ShopProduct();
                    $product->insert();

                    $statAddedArray[] = $product;
                } else {
                    $product = Shop::Get()->getShopService()->getProductByID($productID);

                    $statUpdatedArray[] = $product;
                }

                // обновляем поля товара
                if ($productCode1c !== '' && isset($headerArray['code1c'])) {
                    $product->setCode1c($productCode1c);

                    if ($productCode1c === '-') {
                        $product->setCode1c('');
                    }
                }
                if ($productName !== '' && isset($headerArray['name'])) {
                    $product->setName($productName);

                    if ($productName === '-') {
                        $product->setName('');
                    }
                }
                if ($productTmpImageUrl!== '' && isset($headerArray['tmpimageurl'])) {
                    $product->setTmpimageurl($productTmpImageUrl);

                    if ($productTmpImageUrl === '-') {
                        $product->setTmpimageurl('');
                    }
                }
                if ($productPrice !== '' && isset($headerArray['price'])) {
                    $product->setPrice($productPrice);

                    if ($productPrice === '-') {
                        $product->setPrice(0);
                    }
                }
                if ($productPricebase !== '' && isset($headerArray['pricebase'])) {
                    $product->setPricebase($productPricebase);

                    if ($productPricebase === '-') {
                        $product->setPricebase(0);
                    }
                }
                if ($productPriceold !== '' && isset($headerArray['priceold'])) {
                    $product->setPriceold($productPriceold);

                    if ($productPriceold === '-') {
                        $product->setPriceold(0);
                    }
                }


                if ($productDiscount !== '' && isset($headerArray['discount'])) {
                    $product->setDiscount($productDiscount);

                    if ($productDiscount === '-') {
                        $product->setDiscount(0);
                    }
                }
                if ($productAction !== '' && isset($headerArray['action'])) {
                    $product->setShare($productAction);

                    if ($productAction === '-') {
                        $product->setShare('');
                    }
                }
                if ($productModel !== '' && isset($headerArray['model'])) {
                    $product->setModel($productModel);

                    if ($productModel === '-') {
                        $product->setModel('');
                    }
                }

                if ($productArticul !== '' && isset($headerArray['articul'])) {
                    $product->setArticul($productArticul);

                    if ($productArticul === '-') {
                        $product->setArticul('');
                    }
                }

                if ($productSeries !== '' && isset($headerArray['series'])) {
                    $product->setSeriesname($productSeries);

                    if ($productSeries === '-') {
                        $product->setSeriesname('');
                    }
                }

                if ($productTags !== '' && isset($headerArray['tags'])) {
                    $product->setTags($productTags);

                    if ($productTags === '-') {
                        $product->setTags('');
                    }
                }

                if ($productDescription !== '' && isset($headerArray['description'])) {
                    $product->setDescription($productDescription);

                    if ($productDescription === '-') {
                        $product->setDescription('');
                    }
                }

                if ($productDescriptionShort !== '' && isset($headerArray['descriptionshort'])) {
                    $product->setDescriptionshort($productDescriptionShort);

                    if ($productDescriptionShort === '-') {
                        $product->setDescriptionshort('');
                    }
                }

                if ($productCharacteristics !== '' && isset($headerArray['characteristics'])) {
                    $product->setCharacteristics($productCharacteristics);

                    if ($productCharacteristics === '-') {
                        $product->setCharacteristics('');
                    }
                }

                if ($productUnitBox !== '' && isset($headerArray['unitbox'])) {
                    $product->setUnitbox($productUnitBox);

                    if ($productUnitBox === '-') {
                        $product->setUnitbox('');
                    }
                }

                if ($productHidden !== '' && isset($headerArray['hidden'])) {
                    $product->setHidden($this->_processBoolValue($productHidden));

                    if ($productHidden === '-') {
                        $product->setHidden('');
                    }
                }
                if ($productDeleted !== '' && isset($headerArray['deleted'])) {
                    $product->setDeleted($this->_processBoolValue($productDeleted));

                    if ($productDeleted === '-') {
                        $product->setDeleted('');
                    }
                }
                if ($productAvail !== '' && isset($headerArray['avail'])) {
                    $product->setAvail($this->_processBoolValue($productAvail));

                    if ($productAvail === '-') {
                        $product->setAvail('');
                    }
                }
                if ($productAvailtext !== '' && isset($headerArray['availtext'])) {
                    $product->setAvailtext($productAvailtext);

                    if ($productAvailtext === '-') {
                        $product->setAvailtext('');
                    }
                }
                if ($productBarcode !== '' && isset($headerArray['barcode'])) {
                    $product->setBarcode($productBarcode);

                    if ($productBarcode === '') {
                        $product->setBarcode('');
                    }
                }
                if ($productWidth !== '' && isset($headerArray['width'])) {
                    $product->setWidth($productWidth);

                    if ($productWidth === '') {
                        $product->setWidth('');
                    }
                }
                if ($productHeight !== '' && isset($headerArray['height'])) {
                    $product->setHeight($productHeight);

                    if ($productHeight === '-') {
                        $product->setHeight('');
                    }
                }
                if ($productLength !== '' && isset($headerArray['length'])) {
                    $product->setLength($productLength);

                    if ($productLength === '-') {
                        $product->setLength('');
                    }
                }
                if ($productWeight !== '' && isset($headerArray['weight'])) {
                    $product->setWeight($productWeight);

                    if ($productWeight === '-') {
                        $product->setWeight('');
                    }
                }
                if ($productDivisibility !== '' && isset($headerArray['divisibility'])) {
                    $product->setDivisibility($productDivisibility);

                    if ($productDivisibility === '-') {
                        $product->setDivisibility('');
                    }
                }
                if ($productUnit !== '' && isset($headerArray['unit'])) {
                    $product->setUnit($productUnit);

                    if ($productUnit === '-') {
                        $product->setUnit('');
                    }
                }
                if ($productSeoTitle !== '' && isset($headerArray['seotitle'])) {
                    $product->setSeotitle($productSeoTitle);

                    if ($productSeoTitle === '-') {
                        $product->setSeotitle('');
                    }
                }
                if ($productSeoKeywords !== '' && isset($headerArray['seokeywords'])) {
                    $product->setSeokeywords($productSeoKeywords);

                    if ($productSeoKeywords === '-') {
                        $product->setSeokeywords('');
                    }
                }
                if ($productSeoContent !== '' && isset($headerArray['seocontent'])) {
                    $product->setSeocontent($productSeoContent);

                    if ($productSeoContent === '-') {
                        $product->setSeocontent('');
                    }
                }
                if ($productSeoDescription !== '' && isset($headerArray['seodescription'])) {
                    $product->setSeodescription($productSeoDescription);

                    if ($productSeoDescription == '-') {
                        $product->setSeodescription('');
                    }
                }

                if ($productCurrency !== '' && isset($headerArray['currency'])) {
                    try {
                        $currency = Shop::Get()->getCurrencyService()->getCurrencyByName($productCurrency);
                    } catch (Exception $brandEx) {
                        $currency = new XShopCurrency();
                        $currency->setName($productCurrency);
                        $currency->setSymbol($productCurrency);
                        $currency->setHidden(1);
                        $currency->setRate(1);
                        $currency->insert();
                    }
                    $product->setCurrencyid($currency->getId());
                }

                if ($productBrand !== '' && $productBrand != '-' && isset($headerArray['brand'])) {
                    try {
                        $brand = Shop::Get()->getShopService()->getBrandByName($productBrand);
                    } catch (Exception $brandEx) {
                        $brand = new ShopBrand();
                        $brand->setName($productBrand);
                        $brand->insert();
                    }
                    $product->setBrandid($brand->getId());
                }

                if ($productBrand === '-' && isset($headerArray['brand'])) {
                    $product->setBrandid(0);
                }

                // строим цепочку категорий
                $categoryObjectLast = false;
                foreach ($productCategoryArray as $index => $categoryName) {
                    try {
                        if ($categoryName == '-') {
                            $product->setField('category'.$index.'id', 0);
                            continue;
                        }

                        $categoryObjectCurrent = new XShopCategory();
                        $categoryObjectCurrent->setName($categoryName);
                        if ($categoryObjectLast) {
                            $categoryObjectCurrent->setParentid($categoryObjectLast->getId());
                        } else {
                            $categoryObjectCurrent->setParentid(0);
                        }
                        if (!$categoryObjectCurrent->select()) {
                            $categoryObjectCurrent->insert();
                        }

                        $product->setField('category'.$index.'id', $categoryObjectCurrent->getId());

                        $categoryObjectLast = clone $categoryObjectCurrent;
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }
                if ($categoryObjectLast) {
                    $product->setCategoryid($categoryObjectLast->getId());
                }

                // заполняем дополнительные цены
                foreach ($productPriceArray as $index => $price) {
                    $product->setField('price'.$index, (float) $price);
                }

                foreach ($productFilterArray as $key => $productFilter) {
                    $filter = new ShopProductFilter();
                    $filter->setName($productFilter['filterName']);
                    if (!$filter->select()) {
                        $filter->setType('checkbox');
                        $filter->insert();
                    }

                    $productFilterArray[$key]['filterId'] = $filter->getId();
                }
                // заполняем фильтры
                Shop::Get()->getShopService()->updateProductFilterData($product, $productFilterArray, false);

                $product->update();

                // заполняем поставщиков
                foreach ($supplierArray as $supplierData) {
                    $supplierName = $supplierData['name'];
                    $supplierCode = $supplierData['code'];
                    $supplierPrice = $supplierData['price'];
                    $supplierCurrency = $supplierData['currency'];
                    $supplierAvailtext = $supplierData['availtext'];

                    try {
                        $supplier = Shop::Get()->getSupplierService()->addSupplier($supplierName);

                        $supplierCurrency = Shop::Get()->getCurrencyService()->getCurrencyByName($supplierCurrency);

                        $productSupplier = new ShopProductSupplier();
                        $productSupplier->setSupplierid($supplier->getId());
                        $productSupplier->setProductId($product->getId());
                        if (!$productSupplier->select()) {
                            $productSupplier->insert();
                        }

                        $productSupplier->setCode($supplierCode);
                        $productSupplier->setPrice($supplierPrice);
                        $productSupplier->setCurrencyid($supplierCurrency->getId());
                        $productSupplier->setAvailtext($supplierAvailtext);
                        $productSupplier->setDate(date('Y-m-d H:i:s'));
                        $productSupplier->update();
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
                $statErrorArray[] = array(
                    'id' => $productID,
                    'name'=> $productName,
                );
            }
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';

        $a = array();
        foreach ($statAddedArray as $x) {
            $a[] = array(
                'id'=>$x->getId(),
                'name'=>$x->getName(),
                'url' =>$x->makeURL(),
                'status'=>Shop::Get()->getTranslateService()->getTranslateSecure('translate_a_new_product')
            );
            /* $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_a_new_product').
                ': #'.$x->getId().' '.$x->getName().' '.$x->makeURL();*/
        }
        foreach ($statUpdatedArray as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => $x->makeURL(),
                'status' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_a_new_product')
            );
            /*$bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_updated_product').
                ': #'.$x->getId().' '.$x->getName().' '.$x->makeURL();*/
        }
        foreach ($statErrorArray as $x) {
            $a[] = array(
                'id' => $x['id'],
                'name' => $x['name'],
                'url' => '',
                'status' => Shop::Get()->getTranslateService()->getTranslateSecure('translate_a_new_product')
            );
            /*$bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_missing_items').
                ': #'.$x;*/
        }
        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->getNotificationEmailArray('email-tehnical');

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter(
                $emailFrom,
                $emailTo,
                'Import#'.$task->getId().' done',
                $emailBody
            );
            $csv = CSV_Creator::CreateFromArray($a, true);
            $letter->addAttachment(
                file_get_contents($csv->__toFile()),
                'status_import_products.csv',
                'text/csv'
            );
            $letter->send();
        }

        // сбрасываем кеш сразу
        try {
            Engine::GetCache()->clearCache();
        } catch (Exception $cacheEx) {
            ModeService::Get()->debug($cacheEx);
        }
    }

    /**
     * експорт XLS
     */
    public function exportTaskXLS() {
        // выполняем импорт
        $task = new XShopExport();
        $task->setPdate('0000-00-00 00:00:00');
        if (!$task->select()) {
            return;
        }

        $categoryID = $task->getCategoryid();

        // получаем товары к экспорту
        if ($categoryID == 0) {
            // без категорий
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setOrder(array('categoryid', 'name', 'id'), 'ASC');
            $products->setCategoryid(0);
        } elseif ($categoryID == -1) {
            // все товары
            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->setOrder(array('categoryid', 'name', 'id'), 'ASC');
        } elseif ($categoryID > 0) {
            // категория
            $category = $this->getCategoryByID($categoryID);
            $products = $this->getProductsByCategory($category);
        }

        // стартовый номер файла
        $number = 1;

        // максимальное количество товаров в файле
        $maxProductsPerFile = 1000;

        // массив с именами отправленных файлов
        $numberFileArray = array();

        // массив с порцией товаров
        $productArray = array();
        while ($p = $products->getNext()) {
            $productArray[] = $p;

            // когда насобирали кучу товаров - сбрасываем их письмом
            if (count($productArray) >= $maxProductsPerFile) {
                $fileName = "products-".date('YmdHis')."-".$number.'.xls';
                $this->_exportTaskXLSPart($productArray, $task, $fileName);

                // очищаем массив
                $productArray = array();

                // увеличиваем номер файла
                $number ++;

                // запоминаем отправленный файл
                $numberFileArray[] = $fileName;
            }
        }

        // отправляем остатки, если таковые есть
        if ($productArray) {
            $fileName = "products-".date('YmdHis')."-".$number.'.xls';
            $this->_exportTaskXLSPart($productArray, $task, $fileName);

            // очищаем массив
            $productArray = array();

            // увеличиваем номер файла
            $number ++;

            // запоминаем отправленный файл
            $numberFileArray[] = $fileName;
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';
        $bodyArray[] = '';

        // в тело письма вкладываем все файлы (parts)
        foreach ($numberFileArray as $x) {
            $bodyArray[] = $x;
        }

        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export#'.$task->getId().' done', $emailBody);
            $letter->send();
        }
    }

    /**
     * Упаковать в XLS порцию и отправить ее на почту
     *
     * @param array $productArray
     * @param $task
     * @param int $partFileName
     */
    private function _exportTaskXLSPart($productArray, $task, $partFileName) {
        $fileName = PackageLoader::Get()->getProjectPath()."/media/export/".$partFileName;

        // подключение XLS Writer'a
        require_once(PackageLoader::Get()->getProjectPath()."/packages/XLS/Spreadsheet/Excel/Writer.php");

        // Создание XLS
        $xls = new Spreadsheet_Excel_Writer($fileName);

        // Отправка HTTP заголовков для сообщения обозревателю
        // @todo: а нужно ли?
        $xls->send($partFileName);
        $xls->setVersion(8);

        // Добавление листа к файлу
        $sheet = $xls->addWorksheet('Products');
        $sheet->setInputEncoding('utf-8');

        // заголовки таблицы
        $rowIndex = 0;
        $columnIndex = 0;

        $titleFormat = $xls->addFormat();
        $titleFormat->setBold();

        $rowFormatID = $xls->addFormat();
        $rowFormatID->setLocked();

        $columnWidth = 42; // 42 символа = 300px
        $columnNameWidth = 20;

        $sheet->write($rowIndex, $columnIndex++, 'id', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'code1c', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'name', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'image', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'tmpimageurl', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'price', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'pricebase', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'unit', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'priceold', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'discount', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'currency', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'action', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'brand', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'model', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'articul', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'series', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'tags', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'description', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'descriptionshort', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'characteristics', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'unitbox', $titleFormat);

        for ($i = 1; $i <= 10; $i++) {
            $sheet->write($rowIndex, $columnIndex++, 'category'.$i, $titleFormat);
            $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        }

        $sheet->write($rowIndex, $columnIndex++, 'hidden', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'deleted', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'avail', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'availtext', $titleFormat);

        $sheet->write($rowIndex, $columnIndex++, 'barcode', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'width', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'length', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'height', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'weight', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'divisibility', $titleFormat);

        $sheet->write($rowIndex, $columnIndex++, 'seotitle', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'seodescription', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'seokeywords', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'seocontent', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);

        // цены
        for ($j = 1; $j <= 5; $j++) {
            $sheet->write($rowIndex, $columnIndex++, 'price'.$j, $titleFormat);
        }

        // фильтры
        $maxFilterCount = $this->getProductFilterValueMaxCount()+5;

        for ($i = 1; $i <= $maxFilterCount; $i++) {
            $sheet->write($rowIndex, $columnIndex++, 'filter'.$i.'name', $titleFormat);
            $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
            $sheet->write($rowIndex, $columnIndex++, 'filter'.$i.'value', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'filter'.$i.'use', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'filter'.$i.'actual', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'filter'.$i.'option', $titleFormat);
            $sheet->setColumn($columnIndex-2, $columnIndex-1, 20);
        }

        // поставщики
        // 10 штук

        $supplier_count  = 10;

        for ($i = 1; $i <= $supplier_count; $i++) {
            $sheet->write($rowIndex, $columnIndex++, 'supplier'.$i.'name', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'supplier'.$i.'code', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'supplier'.$i.'price', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'supplier'.$i.'currency', $titleFormat);
            $sheet->write($rowIndex, $columnIndex++, 'supplier'.$i.'availtext', $titleFormat);
            $sheet->setColumn($columnIndex-2, $columnIndex-1, 20);
        }

        $rowIndex ++;

        foreach ($productArray as $p) {
            $columnIndex = 0;

            $sheet->write($rowIndex, $columnIndex++, $p->getId(), $rowFormatID);
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getCode1c()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getName()));
            $image = $p->getImage();
            if ( !empty($image) and file_exists(MEDIA_PATH.'/shop/'.$p->getImage())) {
                $sheet->write($rowIndex, $columnIndex++, MEDIA_DIR.'shop/'.$p->getImage());
            } else {
                $sheet->write($rowIndex, $columnIndex++, '');
            }
            $sheet->write($rowIndex, $columnIndex++, $p->getTmpimageurl());
            $sheet->write($rowIndex, $columnIndex++, $p->getPrice());
            $sheet->write($rowIndex, $columnIndex++, $p->getPricebase());
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getUnit()));
            $sheet->write($rowIndex, $columnIndex++, $p->getPriceold());
            $sheet->write($rowIndex, $columnIndex++, $p->getDiscount());
            try {
                $currencyName = $p->getCurrency()->getName();
            } catch (Exception $e) {
                $currencyName = '';
            }
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($currencyName));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getShare()));

            try {
                $brandName = $p->getBrand()->getName();
            } catch (Exception $e) {
                $brandName = '';
            }
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($brandName));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getModel()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getArticul()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getSeriesname()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getTags()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getDescription()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getDescriptionshort()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getCharacteristics()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getUnitbox()));

            for ($i = 1; $i <= 10; $i++) {
                try {
                    $category = Shop::Get()->getShopService()->getCategoryByID(
                        $p->getField('category'.$i.'id')
                    );
                    $categoryName = $category->getName();
                } catch (Exception $e) {
                    $categoryName = '';
                }

                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($categoryName));
            }

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getHidden() ? 'да' : 'нет'));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getDeleted() ? 'да' : 'нет'));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getAvail() ? 'да' : 'нет'));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getAvailtext()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getBarcode()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getWidth()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getLength()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getHeight()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getWeight()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getDivisibility()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getSeotitle()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getSeodescription()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getSeokeywords()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getSeocontent()));

            // цены
            for ($j = 1; $j <= 5; $j++) {
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($p->getField('price'.$j)));
            }

            $filters = Shop::Get()->getShopService()->getProductFilterValues($p);
            $indexFilter = 0;
            while ($objFilter = $filters->getNext()) {
                try {
                    $filter = Shop::Get()->getShopService()->getProductFilterByID(
                        $objFilter->getFilterid()
                    );

                    $filterName = $filter->getName();
                } catch (Exception $e) {
                    $filterName = '';
                }

                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($filterName));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($objFilter->getFiltervalue()));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($objFilter->getFilteruse()));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($objFilter->getFilteractual()));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($objFilter->getFilteroption()));

                $indexFilter++;
            }

            // догоняем количество
            for ($iFilter = $indexFilter; $iFilter <= $maxFilterCount; $iFilter++) {
                $sheet->write($rowIndex, $columnIndex++, '');
                $sheet->write($rowIndex, $columnIndex++, '');
                $sheet->write($rowIndex, $columnIndex++, '');
                $sheet->write($rowIndex, $columnIndex++, '');
                $sheet->write($rowIndex, $columnIndex++, '');
            }

            // поставщики
            $productSupplier = Shop::Get()->getSupplierService()->getProductSupplierFromProduct($p);
            // 10 штук
            $j = 1;
            while ($x = $productSupplier->getNext()) {
                if ($j >= 10) {
                    continue;
                }
                try {
                    $supplier = Shop::Get()->getSupplierService()->getSupplierByID(
                        $x->getSupplierid()
                    );

                    $supplierName = $supplier->getName();
                } catch (Exception $e) {
                    $supplierName = '';
                }

                try {
                    $supplierCurrency = Shop::Get()->getCurrencyService()->getCurrencyByID(
                        $x->getCurrencyid()
                    );

                    $supplierCurrencyName = $supplierCurrency->getName();
                } catch (Exception $e) {
                    $supplierCurrencyName = '';
                }

                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($supplierName));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($x->getCode()));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($x->getPrice()));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($supplierCurrencyName));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($x->getAvailtext()));

                $j++;
            }
            // свободные ячейки для добавления
            for ($i = $j; $i <= 10; $i++) {
                if ($i > 10) {
                    continue;
                }
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(0));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
            }

            $rowIndex ++;
        }

        // Конец листа, отправка обозревателю
        $xls->close();

        // memory leak clean
        unset($xls);
        unset($sheet);

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': part';

        $emailBody = implode("\n", $bodyArray);

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export '.$partFileName.' part', $emailBody);
            $letter->addAttachment(file_get_contents($fileName), $partFileName, 'application/vnd.ms-excel');
            $letter->send();
        }

        unlink($fileName);
    }

    /**
     * Экспорт контактов xls. Делает отправку по 1000 контактов в файле.
     */
    public function exportContactsTaskXLS() {
        // выполняем экспорт
        $task = new XShopExportContacts();
        $task->setPdate('0000-00-00 00:00:00');
        if (!$task->select()) {
            return;
        }

        $groupID = $task->getGroupid();

        // получаем контакты к экспорту
        if ($groupID == -1) {
            // без групп
            $users = Shop::Get()->getUserService()->getUsersAll();
            $u2g = new XShopUser2Group();
            $users->addWhereQuery("id NOT IN (SELECT userid FROM {$u2g->getTablename()})");
        } elseif ($groupID == 0) {
            // все контакты
            $users = Shop::Get()->getUserService()->getUsersAll();
        } elseif ($groupID > 0) {
            // по группе
            $group = Shop::Get()->getUserService()->getUserGroupByID($groupID);
            $users = Shop::Get()->getUserService()->getUsersByGroup($group);
        } elseif ($groupID == -2) {
            $users = Shop::Get()->getUserService()->getUsersAll();
            $users->setDistribution(1);
        } elseif ($groupID == -3) {
            $users = Shop::Get()->getUserService()->getUsersAll();
            $users->setDistribution(0);
        }

        // стартовый номер файла
        $number = 1;

        // максимальное количество контактов в файле
        $maxProductsPerFile = 1000;

        // массив с именами отправленных файлов
        $numberFileArray = array();

        // массив с порцией контактов
        $usersArray = array();
        while ($u = $users->getNext()) {
            $usersArray[] = $u;

            // когда насобирали кучу контактов - сбрасываем их письмом
            if (count($usersArray) >= $maxProductsPerFile) {
                $fileName = "users-".date('YmdHis')."-".$number.'.xls';
                $this->_exportTaskContactsXLSPart($usersArray, $task, $fileName);

                // очищаем массив
                $usersArray = array();

                // увеличиваем номер файла
                $number ++;

                // запоминаем отправленный файл
                $numberFileArray[] = $fileName;
            }
        }

        // отправляем остатки, если таковые есть
        if ($usersArray) {
            $fileName = "users-".date('YmdHis')."-".$number.'.xls';
            $this->_exportTaskContactsXLSPart($usersArray, $task, $fileName);

            // очищаем массив
            $usersArray = array();

            // увеличиваем номер файла
            $number ++;

            // запоминаем отправленный файл
            $numberFileArray[] = $fileName;
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';
        $bodyArray[] = '';
        // в тело письма вкладываем все файлы (parts)
        foreach ($numberFileArray as $x) {
            $bodyArray[] = $x;
        }

        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export#'.$task->getId().' done', $emailBody);
            $letter->send();
        }
    }


    private function _exportTaskContactsXLSPart( $usersArray, $task, $partFileName) {
        $fileName = PackageLoader::Get()->getProjectPath()."/media/export/".$partFileName;

        // подключение XLS Writer'a
        require_once(PackageLoader::Get()->getProjectPath()."/packages/XLS/Spreadsheet/Excel/Writer.php");

        // Создание XLS
        $xls = new Spreadsheet_Excel_Writer($fileName);

        // Отправка HTTP заголовков для сообщения обозревателю
        // @todo: а нужно ли?
        $xls->send($partFileName);
        $xls->setVersion(8);

        // Добавление листа к файлу
        $sheet = $xls->addWorksheet('Products');
        $sheet->setInputEncoding('utf-8');

        // заголовки таблицы
        $rowIndex = 0;
        $columnIndex = 0;

        $titleFormat = $xls->addFormat();
        $titleFormat->setBold();

        $rowFormatID = $xls->addFormat();
        $rowFormatID->setLocked();

        $columnWidth = 42; // 42 символа = 300px
        $columnNameWidth = 20;

        $sheet->write($rowIndex, $columnIndex++, 'id', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'name', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'namelast', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'namemiddle', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'image', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'phone', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'phones', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'address', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'bdate', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'urls', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'email', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'emails', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'skype', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);

        $sheet->write($rowIndex, $columnIndex++, 'jabber', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'whatsapp', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'time', $titleFormat);

        $sheet->write($rowIndex, $columnIndex++, 'commentadmin', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'company', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'post', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnNameWidth);
        $sheet->write($rowIndex, $columnIndex++, 'pricelevel', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'distribution', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'employer', $titleFormat);

        $sheet->write($rowIndex, $columnIndex++, 'tags', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'typesex', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'managerid', $titleFormat);
        $sheet->write($rowIndex, $columnIndex++, 'discountid', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);
        $sheet->write($rowIndex, $columnIndex++, 'groupid', $titleFormat);
        $sheet->setColumn($columnIndex-1, $columnIndex-1, $columnWidth);

        $fields = new XShopContactField();
        $fields->setHidden(0);
        $fields->setGroupByQuery('idkey');
        while ($x = $fields->getNext()) {
            $key = $x->getIdkey();
            if (!$key) {
                $key = $x->getId();
            }
            $customFieldArray[] = $key;
        }
        foreach ($customFieldArray as $namefield) {
            $sheet->write($rowIndex, $columnIndex++, $namefield, $titleFormat);
        }
        $rowIndex ++;

        foreach ($usersArray as $u) {
            $columnIndex = 0;

            $sheet->write($rowIndex, $columnIndex++, $u->getId(), $rowFormatID);
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getName()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getNamelast()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getNamemiddle()));
            $image = $u->getImage();
            if ( !empty($image) and file_exists(MEDIA_PATH.'/shop/'.$u->getImage())) {
                $sheet->write($rowIndex, $columnIndex++, $u->getImage());
            } else {
                $sheet->write($rowIndex, $columnIndex++, '');
            }
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getPhone()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getPhones()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getAddress()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getBdate()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getUrls()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getEmail()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getEmails()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getSkype()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getJabber()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getWhatsapp()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getTime()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getCommentadmin()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getCompany()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getPost()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getPricelevel()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getDistribution()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getEmployer()));

            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getTags()));
            $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($u->getTypesex()));

            if ($u->getManagerid()) {
                try {
                    $manager = Shop::Get()->getUserService()->getUserByID($u->getManagerid());
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($manager->getName()));
                } catch (Exception $emanager) {
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $emanager;
                    }
                }
            } else {
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
            }

            if ($u->getDiscountid()) {
                try{
                    $discount = Shop::Get()->getShopService()->getDiscountByID($u->getDiscountid());
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($discount->getName()));
                } catch (Exception $ediscount) {
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $ediscount;
                    }
                }
            } else {
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
            }

            // get user groups
            $grpId = array();
            $grpExportArr = array();
            $grpStr = '';
            $u2gr = new XShopUser2Group();
            $u2gr->filterUserid($u->getId());
            while ($x = $u2gr->getNext()) {
                $grpId[] = $x->getGroupid();
            }
            // get groups name
            if ($grpId) {
                foreach ($grpId as $k => $v) {
                    try {
                        $grpName = Shop::Get()->getUserService()->getUserGroupByID($v);
                        $grpExportArr[] = $grpName->getName();
                    } catch (Exception $eGroup) {

                    }
                }
                if ($grpExportArr) {
                    $grpStr = implode(", ", $grpExportArr);
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($grpStr));
                } else {
                    // if group not exist in ShopUserGroup
                    $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
                }
            } else {
                // if user not exist in ShopUser2Group
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode(''));
            }

            // custom fields in xls-doc
            foreach ($customFieldArray as $keys) {
                $tmp = new XShopCustomField();
                $tmp->setObjecttype(get_class($u));
                $tmp->setObjectid($u->getId());
                $tmp->setKey($keys);
                $tmp->select();
                $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($tmp->getValue()));
            }

            $rowIndex ++;
        }

        // Конец листа, отправка обозревателю
        $xls->close();

        // memory leak clean
        unset($xls);
        unset($sheet);

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': part';

        $emailBody = implode("\n", $bodyArray);

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export '.$partFileName.' part', $emailBody);
            $letter->addAttachment(file_get_contents($fileName), $partFileName, 'application/vnd.ms-excel');
            $letter->send();
        }

        unlink($fileName);
    }

    /**
     * Получить все шаблоны комментариев в массиве
     *
     * @return array
     */

    public function getCommentTemplatesArray() {
        $comments = new XShopCommentTemplate();
        $commentsArray = array();
        while ($x = $comments->getNext()) {
            $commentsArray[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'text' => htmlspecialchars($x->getText())
            );
        }
        return $commentsArray;
    }

    /**
     * импорт контактов эксель
     */
    public function importContactsTaskXLS() {
        // выполняем импорт
        $task = new XShopImportContacts();
        $task->setPdate('0000-00-00 00:00:00');
        if (!$task->select()) {
            return;
        }

        PackageLoader::Get()->import('XLS');
        PackageLoader::Get()->import('CSV');

        $data = new XLS_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read(PackageLoader::Get()->getProjectPath().'media/import/'.$task->getFile());

        // читаем заголовки таблицы
        $headerArray = array();
        for ($i = 1; $i <= $data->sheets[0]['numCols']; $i++) {
            $headerName = $data->sheets[0]['cells'][1][$i];
            $headerName = trim($headerName);
            if (!$headerName) {
                continue;
            }

            $headerArray[$headerName] = $i;
        }

        $statAddedArray = array();
        $statUpdatedArray = array();
        $statErrorArray = array();

        // читаем данные по заголовкам
        for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {
            $userID = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['id']]));
            $name = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['name']]));
            $namelast = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['namelast']]));
            $namemiddle = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['namemiddle']]));
            $image = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['image']]));
            $phone = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['phone']]));
            $phones = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['phones']]));
            $address = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['address']]));
            $bdate = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['bdate']]));
            $urls = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['urls']]));
            $email = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['email']]));

            $emails = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['emails']]));
            $skype = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['skype']]));
            $jabber = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['jabber']]));
            $whatsapp = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['whatsapp']]));
            $time = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['time']]));
            $commentadmin = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['commentadmin']]));
            $company = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['company']]));
            $post = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['post']]));
            $pricelevel = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['pricelevel']]));
            $distribution = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['distribution']]));
            $employer = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['employer']]));
            $tags = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['tags']]));
            $typesex = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['typesex']]));
            $managerid = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['managerid']]));
            $discountid = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['discountid']]));
            $groupid = @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['groupid']]));

            // группы
            $groupArray = array();
            for ($igroup = 1; $igroup <= 20; $igroup++) {
                if (!@$headerArray['group'.$igroup.'name']) {
                    break;
                }

                $groupArray[$igroup] = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray['group'.$igroup.'name']])
                );
            }

            $fields = new XShopContactField();
            $fields->setHidden(0);
            $fields->setGroupByQuery('idkey');
            while ($x = $fields->getNext()) {
                $key = $x->getIdkey();
                if (!$key) {
                    $key = $x->getId();
                }
                $customFieldArray[] = $key;
            }
            $fieldNameArr = false;
            foreach ($customFieldArray as $namefield) {
                $fieldNameArr[$namefield] =
                    @trim(iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray[$namefield]]));
            }

            // ID или имя должны быть
            if (!$userID && !$name) {
                continue;
            }

            // работаем с полученными данными
            try {
                SQLObject::TransactionStart();

                // если ID нет - вставляем
                if (!$userID) {
                    $newUser = true;
                    // проверяем такого пользователя по имени
                    $user = new User();
                    $user->setName($name);
                    $user->setNamelast($namelast);
                    $user->setNamemiddle($namemiddle);
                    $user->setEmail($email);
                    $user->setPhone($phone);
                    if ($user = $user->getNext()) {
                        // контакт с таким именем уже есть
                        $newUser = false;
                        $statUpdatedArray[] = $user;
                    }

                    if ($newUser && $typesex && $typesex == 'company') {
                        $user = new User();
                        $user->setCompany($name);
                        $user->setTypesex('company');
                        // компания должна быть без имени
                        $user->setName('');
                        $user->setEmail($email);
                        $user->setPhone($phone);
                        $user->setAddress($address);
                        if ($user = $user->getNext()) {
                            // такая компания уже есть
                            $newUser = false;
                            $statUpdatedArray[] = $user;
                        }
                    }

                    // вставляем контакт
                    if ($newUser) {
                        $user = new User();
                        $user->setCdate(DateTime_Object::Now());
                        $user->setLevel(1);
                        $user->insert();

                        $statAddedArray[] = $user;
                    }

                } else {
                    $user = Shop::Get()->getUserService()->getUserByID($userID);
                    $statUpdatedArray[] = $user;
                }

                // обновляем поля товара
                if ($user->getTypesex() != 'company' && !$user->getName()
                    && $name !== '' && isset($headerArray['name'])
                ) {
                    $user->setName($name);

                    if ($name === '-') {
                        $user->setName('');
                    }
                }

                if ($user->getTypesex() != 'company' && !$user->getNamelast()
                    && $namelast !== '' && isset($headerArray['namelast'])
                ) {
                    $user->setNamelast($namelast);

                    if ($namelast === '-') {
                        $user->setNamelast('');
                    }
                }

                if ($user->getTypesex() != 'company' && !$user->getNamemiddle()
                    && $namemiddle !== '' && isset($headerArray['namemiddle'])
                ) {
                    $user->setNamemiddle($namemiddle);

                    if ($namemiddle === '-') {
                        $user->setNamemiddle('');
                    }
                }

                if (!$user->getImage() && $image !== '' && isset($headerArray['image'])) {
                    $user->setImage($image);

                    if ($image=== '-') {
                        $user->setImage('');
                    }
                }

                if (!$user->getPhone() && $phone !== '' && isset($headerArray['phone'])) {
                    $user->setPhone($phone);

                    if ($phone === '-') {
                        $user->setPhone('');
                    }
                }

                if (!$user->getPhones() && $phones !== '' && isset($headerArray['phones'])) {
                    if ($phones && $phones != '-') {
                        $user->setPhones($phones);
                    }
                    if ($phones === '-') {
                        $user->setPhones('');
                    }
                }

                if (!$user->getAddress() && $address!== '' && isset($headerArray['address'])) {
                    $user->setAddress($address);

                    if ($address=== '-') {
                        $user->setAddress('');
                    }
                }

                if (!$user->getBdate() && $bdate !== '' && isset($headerArray['bdate'])) {
                    $user->setBdate($bdate);

                    if ($bdate === '-') {
                        $user->setBdate('');
                    }
                }

                if (!$user->getUrls() && $urls !== '' && isset($headerArray['urls'])) {
                    $user->setUrls($urls);

                    if ($urls  === '-') {
                        $user->setUrls('');
                    }
                }

                if (!$user->getEmail() && $email !== '' && isset($headerArray['email'])) {
                    $user->setEmail($email);

                    if ($email === '-') {
                        $user->setEmail('');
                    }
                }

                if (!$user->getEmails() && $emails !== '' && isset($headerArray['emails'])) {
                    if ($email && $email != '-') {
                        $replaceCount = 0;
                        $emails = preg_replace(
                            '/[\s,]+'.str_replace('.', '\.', $email).'/uis', '', $emails, null, $replaceCount
                        );
                        if (!$replaceCount) {
                            $emails =  preg_replace('/'.str_replace('.', '\.', $email).'[\s,]*/uis', '', $emails);
                        }
                    }

                    $user->setEmails($emails);

                    if ($emails === '-') {
                        $user->setEmails('');
                    }
                }

                if (!$user->getSkype() && $skype !== '' && isset($headerArray['skype'])) {
                    $user->setSkype($skype);

                    if ($skype === '-') {
                        $user->setSkype('');
                    }
                }

                if (!$user->getJabber() && $jabber !== '' && isset($headerArray['jabber'])) {
                    $user->setJabber($jabber);

                    if ($jabber === '-') {
                        $user->setJabber('');
                    }
                }

                if (!$user->getWhatsapp() && $whatsapp !== '' && isset($headerArray['whatsapp'])) {
                    $user->setWhatsapp($whatsapp);

                    if ($whatsapp === '-') {
                        $user->setWhatsapp('');
                    }
                }

                if (!$user->getTime() && $time !== '' && isset($headerArray['time'])) {
                    $user->setTime($time);

                    if ($time === '-') {
                        $user->setTime('');
                    }
                }

                if (!$user->getCommentadmin() && $commentadmin !== '' && isset($headerArray['commentadmin'])) {
                    $user->setCommentadmin($commentadmin);

                    if ($commentadmin === '-') {
                        $user->setCommentadmin('');
                    }
                }

                if ($post !== '' && isset($headerArray['post'])) {
                    $user->setPost($post);

                    if ($post === '-') {
                        $user->setPost('');
                    }
                }

                if (!$user->getPricelevel() && $pricelevel !== '' && isset($headerArray['pricelevel'])) {
                    $user->setPricelevel($pricelevel);

                    if ($pricelevel === '-') {
                        $user->setPricelevel('');
                    }
                }

                if (!$user->getDistribution() && $distribution !== '' && isset($headerArray['distribution'])) {
                    $user->setDistribution($distribution);

                    if ($distribution === '-') {
                        $user->setDistribution('');
                    }
                }

                if (!$user->getEmployer() && $employer !== '' && isset($headerArray['employer'])) {
                    $user->setEmployer($employer);

                    if ($employer === '-') {
                        $user->setEmployer('');
                    }
                }

                if (!$user->getTags() && $tags !== '' && isset($headerArray['tags'])) {
                    $user->setTags($tags);

                    if ($tags === '-') {
                        $user->setTags('');
                    }
                }

                if (!$user->getManagerid() && $managerid !== '' && isset($headerArray['managerid'])) {
                    $nameManager = new XUser();
                    $managerid = explode(' ', $managerid);
                    $nameManager->setName($managerid[1]);
                    $nameManager->setNamelast($managerid[0]);
                    $nameManager->setNamemiddle($managerid[2]);
                    if ($nameManager->select()) {
                        $user->setManagerid($nameManager->getId());
                    }
                    if ($managerid === '-') {
                        $user->setManagerid('');
                    }
                }

                if (!$user->getDiscountid() && $discountid !== '' && isset($headerArray['discountid'])) {
                    try {
                        $nameDisc = new XShopDiscount();
                        $nameDisc->setName($discountid);
                        $dis = $nameDisc->getNext();
                        if ($dis) {
                            $user->setDiscountid($dis->getId());
                        }
                        if ($discountid === '-') {
                            $user->setDiscountid('');
                        }
                    } catch (Exception $ex) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $ex;
                        }
                    }

                }

                // added group to user
                if ($groupid !== '' && isset($headerArray['groupid'])) {
                    $grpToImport = explode(', ', $groupid);
                    foreach ($grpToImport as $k => $v) {
                        try {
                            // add to ShopUser2Group only groups which exist on ShopUserGroup
                            $grpByName = Shop_UserService::Get()->getUserGroupByName($v);
                            Shop_UserService::Get()->addUserToGroup($user, $grpByName);
                        } catch (Exception $e) {

                        }
                    }
                }

                $user2 = false;

                if (!$user->getTypesex() && $typesex !== '' && isset($headerArray['typesex'])) {
                    $user->setTypesex($typesex);

                    if ($typesex === '-') {
                        $user->setTypesex('man');
                    }

                    if ($company !== '' && isset($headerArray['company'])) {
                        $user->setCompany($company);

                        if ($company === '-') {
                            $user->setCompany('');
                        }
                    }

                    if (!$company && $name && $typesex == 'company') {
                        $user->setCompany($name);
                        $user->setName('');
                        $user->setNamelast('');
                        $user->setNamemiddle('');
                        if ($name === '-') {
                            $user->setCompany('');
                        }
                    }
                } elseif (!$user->getTypesex()) {
                    // если есть и компания и имя, создаем 2 контакта
                    if ($company && ($name || $namelast || $namemiddle)) {
                        $user2 = clone $user;

                        $user->setCompany($company);
                        $user->setTypesex('company');
                        $user->setName('');
                        $user->setNamelast('');
                        $user->setNamemiddle('');

                        $user2->setTypesex('man');
                        $user2->setName($name);
                        $user2->setNamelast($namelast);
                        $user2->setNamemiddle($namemiddle);
                        $user2->setCompany($company);
                        $user2->unsetField('id');
                        $user2->insert();
                        $statAddedArray[] = $user2;
                    } else {
                        $user->setTypesex('man');
                    }

                }
                foreach ($fieldNameArr as $key => $value) {
                    if ( $value !== '' && isset($headerArray[$key])) {
                        $tmp = new XShopCustomField();
                        $tmp->setObjecttype(get_class($user));
                        $tmp->setObjectid($user->getId());
                        $tmp->setKey($key);

                        if ($tmp->select()) {
                            $tmp->setValue($value);
                            $tmp->update();
                        } else {
                            $tmp->setValue($value);
                            $tmp->insert();
                        }
                    }
                }

                if ($user2) {
                    foreach ($fieldNameArr as $key => $value) {
                        if ( $value !== '' && isset($headerArray[$key])) {
                            $tmp = new XShopCustomField();
                            $tmp->setObjecttype(get_class($user2));
                            $tmp->setObjectid($user2->getId());
                            $tmp->setKey($key);

                            if ($tmp->select()) {
                                $tmp->setValue($value);
                                $tmp->update();
                            } else {
                                $tmp->setValue($value);
                                $tmp->insert();
                            }
                        }
                    }
                }

                // update
                $user->update();

                // группы
                foreach ($groupArray as $group) {
                    try{
                        $groupObject = Shop::Get()->getUserService()->getUserGroupByName($group);

                    } catch (Exception $egroup) {

                        $groupObject = new ShopUserGroup();
                        $groupObject->setName($group);
                        $groupObject->insert();
                    }

                    Shop::Get()->getUserService()->addUserToGroup($user, $groupObject);

                    if ($user2) {
                        Shop::Get()->getUserService()->addUserToGroup($user2, $groupObject);

                    }

                }

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();

                $statErrorArray[] = array(
                    'id'=>$userID,
                    'name'=>$name.''.$namelast.' '.$namemiddle,
                );
            }
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = "Updated: ".count($statUpdatedArray);
        $bodyArray[] = "Added: ".count($statAddedArray);
        $bodyArray[] = "Missing: ".count($statErrorArray);
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';
        $a = array();
        foreach ($statAddedArray as $x) {
            $a[] = array(
                'id'=>$x->getId(),
                'name'=>$x->makeName(),
                'url' =>$x->makeURLEdit(),
                'status'=>'New user'
            );
            //$bodyArray[] = "New user".': #'.$x->getId().' '.$x->makeName().' '.$x->makeURLEdit();
        }
        foreach ($statUpdatedArray as $x) {
            $a[] = array(
                'id' => $x->getId(),
                'name' => $x->getName(),
                'url' => $x->makeURLEdit(),
                'status' => 'Updated user'
            );
            //$bodyArray[] = "Updated user".': #'.$x->getId().' '.$x->getName().' '.$x->makeURLEdit();
        }
        foreach ($statErrorArray as $x) {

            $a[] = array(
                'id' => $x['id'],
                'name' => $x['name'],
                'url' => '',
                'status' => 'Missing'
            );
            //$bodyArray[] = "Missing".': #'.$x;
        }
        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->getNotificationEmailArray('email-tehnical');

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Import#'.$task->getId().' done', $emailBody);
            $csv = CSV_Creator::CreateFromArray($a, true);
            $letter->addAttachment(
                file_get_contents($csv->__toFile()),
                'status_import_contacts.csv',
                'text/csv'
            );
            $letter->send();
        }

        // сбрасываем кеш сразу
        try {
            Engine::GetCache()->clearCache();
        } catch (Exception $cacheEx) {
            ModeService::Get()->debug($cacheEx);
        }
    }

    /**
     * Универсальный экспорт xls экспортит поля класса exportclassname указанные в XShopExportTask
     * кроме полей указанных в excludefields.
     * @throws ServiceUtils_Exception
     */
    public function exportMassiveTaskXLS() {

        // выполняем export
        $task = new XShopExportTask();
        $task->setPdate('0000-00-00 00:00:00');
        $task->addWhere('exportclassname', '', '<>');
        if (!$task->select()) {
            return;
        }
        $x = $task->getExportclassname();
        // получаем записи к экспорту
        $records = new $x;

        if (!is_object($records)) {
            throw new ServiceUtils_Exception('Bad exportclassname.');
        }

        // стартовый номер файла
        $number = 1;

        // максимальное количество записей в файле
        $maxRecordsPerFile = 500;

        // массив с именами отправленных файлов
        $numberFileArray = array();

        $fieldsArray = $records->getFields();
        // Удаляем ненужные поля
        if ($task->getExcludefields()) {
            $unsetFieldsArray = explode(',', $task->getExcludefields());
            foreach ($fieldsArray as $key => $fileName) {
                if ($fileName != 'id' && in_array($fileName, $unsetFieldsArray)) {
                    // поле ид оставляем
                    unset($fieldsArray[$key]);
                }
            }
        }

        // массив с порцией записей
        $recordsArray = array();
        while ($p = $records->getNext()) {
            $recordsArray[] = $p;

            // когда насобирали кучу товаров - сбрасываем их письмом
            if (count($recordsArray) >= $maxRecordsPerFile) {
                $fileName = "records-".date('YmdHis')."-".$number.'.xls';
                $this->_exportMassiveTaskXLSPart($recordsArray, $task, $fileName, $fieldsArray);

                // очищаем массив
                $recordsArray = array();

                // увеличиваем номер файла
                $number ++;

                // запоминаем отправленный файл
                $numberFileArray[] = $fileName;
            }
        }

        // отправляем остатки, если таковые есть
        if ($recordsArray) {
            $fileName = "records-".date('YmdHis')."-".$number.'.xls';
            $this->_exportMassiveTaskXLSPart($recordsArray, $task, $fileName, $fieldsArray);

            // очищаем массив
            $recordsArray = array();

            // увеличиваем номер файла
            $number ++;

            // запоминаем отправленный файл
            $numberFileArray[] = $fileName;
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';
        $bodyArray[] = '';
        // в тело письма вкладываем все файлы (parts)
        foreach ($numberFileArray as $x) {
            $bodyArray[] = $x;
        }

        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export#'.$task->getId().' done', $emailBody);
            $letter->send();
        }
    }

    /**
     * Универсальный экспорт части (задачи) в XLS
     *
     * @param $recordsArray
     * @param $task
     * @param $partFileName
     * @param $fieldsArray
     */
    private function _exportMassiveTaskXLSPart( $recordsArray, $task, $partFileName, $fieldsArray) {
        $fileName = PackageLoader::Get()->getProjectPath()."/media/export/".$partFileName;

        // подключение XLS Writer'a
        require_once(PackageLoader::Get()->getProjectPath()."/packages/XLS/Spreadsheet/Excel/Writer.php");

        // Создание XLS
        $xls = new Spreadsheet_Excel_Writer($fileName);

        // Отправка HTTP заголовков для сообщения обозревателю
        // @todo: а нужно ли?
        $xls->send($partFileName);
        $xls->setVersion(8);

        // Добавление листа к файлу
        $sheet = $xls->addWorksheet('Products');
        $sheet->setInputEncoding('utf-8');

        // заголовки таблицы
        $rowIndex = 0;
        $columnIndex = 0;

        $titleFormat = $xls->addFormat();
        $titleFormat->setBold();

        $rowFormatID = $xls->addFormat();
        $rowFormatID->setLocked();

        foreach ($fieldsArray as $fieldName) {
            $sheet->write($rowIndex, $columnIndex++, $fieldName, $titleFormat);
        }


        $rowIndex ++;

        $columnSizesArray = array(); // Массив с размерами колонок
        $maxColumnSize = 42; // Ограничиваем размер столбца 300px = 42 символа

        foreach ($recordsArray as $u) {
            $columnIndex = 0;
            foreach ($fieldsArray as $fieldName) {

                $fieldValue = $u->getField($fieldName);
                $length = 0;

                if (isset($columnSizesArray[$columnIndex]) && $columnSizesArray[$columnIndex] < $maxColumnSize) {
                    $length = strlen($fieldValue);
                } elseif (!isset($columnSizesArray[$columnIndex])) {
                    $fieldNameLength = strlen($fieldName);
                    $length = strlen($fieldValue);
                    if ($fieldNameLength > $length) {
                        $length = $fieldNameLength;
                    }
                }
                if ($length) {
                    if ($length > $maxColumnSize) {
                        $length = $maxColumnSize;
                    }

                    $columnSizesArray[$columnIndex] = $length;
                }

                switch ($fieldName) {
                    case 'id' :
                        $sheet->write($rowIndex, $columnIndex++, $fieldValue, $rowFormatID);
                        break;
                    case 'image' :
                        if ( !empty($fieldValue) and file_exists(MEDIA_PATH.'/shop/'.$fieldValue) ) {
                            $sheet->write($rowIndex, $columnIndex++, $fieldValue);
                        } else {
                            $sheet->write($rowIndex, $columnIndex++, '');
                        }
                        break;
                    default :
                        $sheet->write($rowIndex, $columnIndex++, $this->_xlsEncode($fieldValue));
                }

            }
            $rowIndex ++;
        }

        // Устанавливаем размеры колонок
        foreach ( $columnSizesArray as $columnIndex => $length) {
            $sheet->setColumn($columnIndex, $columnIndex, $length);
        }

        // Конец листа, отправка обозревателю
        $xls->close();

        // memory leak clean
        unset($xls);
        unset($sheet);

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': part';

        $emailBody = implode("\n", $bodyArray);

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->_extractEmailArray($task->getEmails());
        if (!$emailToArray) {
            $emailToArray = $this->getNotificationEmailArray('email-tehnical');
        }

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Export '.$partFileName.' part', $emailBody);
            $letter->addAttachment(file_get_contents($fileName), $partFileName, 'application/vnd.ms-excel');
            $letter->send();
        }

        unlink($fileName);
    }

    /**
     * Универсальный импорт xls. Импортит по классу importtclassname указанном в XShopImportTask
     */
    public function importMassiveTaskXLS() {
        // выполняем импорт
        $task = new XShopImportTask();
        $task->setPdate('0000-00-00 00:00:00');
        $task->addWhere('importtclassname', '', '<>');
        if (!$task->select()) {
            return;
        }
        $recordClass = $task->getImporttclassname();

        PackageLoader::Get()->import('XLS');

        $data = new XLS_Reader();
        $data->setOutputEncoding('UTF-8');
        $data->read(PackageLoader::Get()->getProjectPath().'media/import/'.$task->getFile());

        // читаем заголовки таблицы
        $headerArray = array();
        for ($i = 1; $i <= $data->sheets[0]['numCols']; $i++) {
            $headerName = $data->sheets[0]['cells'][1][$i];
            $headerName = trim($headerName);
            if (!$headerName) {
                continue;
            }

            $headerArray[$headerName] = $i;
        }

        $statRecordArray = array(); // Массив статистики результатов импорта

        $numRows = $data->sheets[0]['numRows'];

        // читаем данные по заголовкам
        for ($i = 2; $i <= $numRows; $i++) {
            $recordFieldsArray = array();
            foreach ($headerArray as $key => $value) {
                $recordFieldsArray[$key] = @trim(
                    iconv('utf-8', 'utf-8', $data->sheets[0]['cells'][$i][$headerArray[$key]])
                );
            }

            $recordId = $recordFieldsArray['id'];

            unset($recordFieldsArray['id']);

            // ID должен быть
            if (!$recordId) {
                continue;
            }


            // работаем с полученными данными
            try {
                SQLObject::TransactionStart();


                $record = new $recordClass;
                $record->setId($recordId);

                if (!$record->select()) {
                    $record->insert();
                    $statRecordArray[$recordId] = array('status' => 'New', 'id' => $recordId );
                }
                $statUpdatedArray[] = $record;

                foreach ($recordFieldsArray as $key => $value) {
                    try {
                        if ($value !== '') {
                            $record->setField($key, $value);

                            if ($value === '-') {
                                $record->setField('');
                            }
                        }
                    } catch (Exception $e) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $e;
                        }
                    }
                }

                // update
                $record->update();
                $statRecordArray[$recordId] = array('status' => 'Update', 'id' => $recordId );

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();

                $statRecordArray[$recordId] = array('status' => 'Error', 'id' => $recordId );
            }
        }

        // дата завершения задачи
        $pdate = date('Y-m-d H:i:s');

        $bodyArray = array();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_task').
            ' #'.$task->getId();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_created').
            ': '.$task->getCdate();
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_completed').
            ': '.$pdate;
        $bodyArray[] = Shop::Get()->getTranslateService()->getTranslateSecure('translate_status').
            ': done';

        ksort($statRecordArray);

        foreach ($statRecordArray as $x) {
            $bodyArray[] = $x['status'].': #'.$x['id'];
        }

        $emailBody = implode("\n", $bodyArray);

        // закрываем задачу
        $task->setPdate($pdate);
        $task->setComment($emailBody);
        $task->update();

        // отправляем письмо администратору
        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');

        // получаем все емейлы на которые нужно отправить уведомление
        $emailToArray = $this->getNotificationEmailArray('email-tehnical');

        // отправляем
        foreach ($emailToArray as $emailTo) {
            $letter = new MailUtils_Letter($emailFrom, $emailTo, 'Import#'.$task->getId().' done', $emailBody);
            $letter->send();
        }

        // сбрасываем кеш сразу
        try {
            Engine::GetCache()->clearCache();
        } catch (Exception $cacheEx) {
            ModeService::Get()->debug($cacheEx);
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
     * Создание адреса для записи файла
     * создаётся 4 папки которые вложены друг в друга
     * Имена папок определяются по md5-hash файла
     *
     * @param $image
     * @param string $folder
     * @param string $fileformat
     *
     * @todo метод использует только PaymentService
     *
     * @return string
     */
    public function makeFileUploadUrl($file, $folder = 'shop/') {
        $url = MEDIA_PATH.$folder;

        $imagemd5 = md5_file($file);
        $folder1 = substr($imagemd5, 0, 2);
        $folder2 = substr($imagemd5, 2, 2);

        @mkdir($url.$folder1);
        @mkdir($url.$folder1.'/'.$folder2);

        $imagemd5 = $folder1.'/'.$folder2.'/'.$imagemd5;

        return $imagemd5;
    }

    public function updateProductGrouped() {
        ModeService::Get()->verbose('Process grouped products and categories...');
        $category = Shop::Get()->getShopService()->getCategoryAll();
        $category->addWhere('showtype', '%grouped%', 'LIKE');
        while ($c = $category->getNext()) {
            $categoryProductsIdArray = array();

            // список наших товаров
            $grouped = new XShopProductGrouped();
            $grouped->setCategoryid($c->getId());
            while ($g = $grouped->getNext()) {
                $categoryProductsIdArray[$g->getProductid()] = $g;
                // стираем first
                if ($g->getFirst()) {
                    $g->setFirst(0);
                    $g->update();
                }
            }

            // формируем массив группировки
            $products = $c->getProducts();
            $products->setHidden(0);
            $products->setDeleted(0);
            $groupBy = Shop::Get()->getShopService()->getProductsGroup($products);

            $products->setOrderBy(array($groupBy.' DESC', 'avail <> 0 DESC', 'pricesell ASC'));
            //$products->setGroupByQuery($groupBy);
            $groupedFiled = false;
            while ($p = $products->getNext()) {
                $first = false;
                $image = false;
                // первый элемент каждой группы - ставим first
                if ($p->getField($groupBy) && $p->getField($groupBy) != $groupedFiled) {
                    $groupedFiled = $p->getField($groupBy);
                    $first = true;
                }

                $grouped = new XShopProductGrouped();
                $grouped->setCategoryid($c->getId());
                $grouped->setProductid($p->getId());
                if (!$grouped->select()) {
                    if ($first) {
                        $grouped->setFirst(1);
                        $grouped->setImage($p->getImage());
                    }
                    $grouped->setGroupedfield($p->getField($groupBy));
                    $grouped->insert();
                } elseif ($first) {
                    $grouped->setFirst(1);
                    $grouped->setImage($p->getImage());
                    $grouped->setGroupedfield($p->getField($groupBy));
                    $grouped->update();
                } else {
                    $grouped->setGroupedfield($p->getField($groupBy));
                    $grouped->update();
                }

                // если обновили - убираем из массива
                if (isset($categoryProductsIdArray[$p->getId()])) {
                    unset($categoryProductsIdArray[$p->getId()]);
                }
            }

            // удаляем все не актуальные
            foreach ($categoryProductsIdArray as $object) {
                $object->delete();
            }

            $products = Shop::Get()->getShopService()->getProductsAll();
            $products->addWhere('image', '', '<>');
            $products->setImagegrouped(1);
            while ($x = $products->getNext()) {
                $grouped = new XShopProductGrouped();
                $grouped->setCategoryid($x->getCategoryid());
                $grouped->setFirst(1);
                $grouped->setGroupedfield($x->getField($groupBy));
                if ($grouped = $grouped->getNext()) {
                    if ($x->getImagecrop()) {
                        $image = $x->getImagecrop();
                    } else {
                        $image = $x->getImage();
                    }
                    $grouped->setImage($image);
                    $grouped->update();
                }
            }

            // подтягиваем картинки, куда не подтянулись
            $grouped = new XShopProductGrouped();
            $grouped->setCategoryid($c->getId());
            $grouped->setFirst(1);
            $grouped->setImage('');
            while ($g = $grouped->getNext()) {
                if (!$g->getGroupedfield()) {
                    continue;
                }

                $products = Shop::Get()->getShopService()->getProductsAll();
                $products->addWhere('image', '', '<>');
                $products->setField($groupBy, $g->getGroupedfield());
                $products = $products->getNext();

                if ($products) {
                    if ($products->getImagecrop()) {
                        $image = $products->getImagecrop();
                    } else {
                        $image = $products->getImage();
                    }

                    $g->setImage($image);
                    $g->update();
                }

            }
        }
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
     * Получить всех поставщиков
     *
     * @return ShopSupplier
     *
     * @deprecated
     */
    public function getSuppliersAll() {
        return Shop::Get()->getSupplierService()->getSuppliersAll();
    }

    /**
     * Получить поставщика по его номеру
     *
     * @param int $supplierID
     *
     * @return ShopSupplier
     *
     * @deprecated
     */
    public function getSupplierByID($supplierID) {
        return Shop::Get()->getSupplierService()->getSupplierByID($supplierID);
    }

    /**
     * Получить правило наценки по ID
     *
     * @todo move to margin service
     *
     * @return ShopMarginRule
     */
    public function getMarginRuleByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopMarginRule');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить все правила автоматических наценок
     *
     * @todo move to margin service
     *
     * @return ShopMarginRule
     */
    public function getMarginRulesAll() {
        return $this->getObjectsAll('ShopMarginRule');
    }

    /**
     * Получить правило наценки по ID
     *
     * @todo перенести в margin service
     *
     * @return ShopMarginRuleLink
     */
    public function getMarginRuleLinkByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopMarginRuleLink');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
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
     * Поиск заказов
     *
     * @param string $query
     * @param User $cuser
     * @param string $aclType
     *
     * @return ShopOrder
     */
    public function searchOrders($query, $cuser = false, $aclType = false) {
        $query = trim($query);
        if (strlen($query) < 3) {
            throw new ServiceUtils_Exception();
        }

        $orders = $this->getOrdersAll($cuser, true, $aclType);

        $connection = $orders->getConnectionDatabase();

        // перестановки всех слов
        $a = array();
        if (preg_match_all("/([\.\d\pL]+)/ius", $query, $r)) {
            foreach ($r[1] as $part) {
                $a[] = $connection->escapeString($part);
            }
        }

        if (!$a) {
            throw new ServiceUtils_Exception();
        }

        foreach ($a as $part) {
            $w = array();

            $w[] = $orders->getTablename().".`id` ='$part'";
            $w[] = $orders->getTablename().".`number` ='$part'";
            $w[] = $orders->getTablename().".`name` LIKE '%$part%'";
            $w[] = $orders->getTablename().".`clientaddress` LIKE '%$part%'";
            $w[] = $orders->getTablename().".`deliverynote` LIKE '%$part%'";

            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);
                $partTr = $connection->escapeString($partTr);

                $w[] = $orders->getTablename().".`name` LIKE '%$partTr%'";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);
                $partRu = $connection->escapeString($partRu);

                $w[] = $orders->getTablename().".`name` LIKE '%$partRu%'";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);
                $partEn = $connection->escapeString($partEn);

                $w[] = $orders->getTablename().".`name` LIKE '%$partEn%'";
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }

            $orders->addWhereQuery("(" . implode(' OR ', $w) . ")");
        }

        return $orders;
    }

    /**
     * Добавить уведомление к заказу.
     * Уведомления будут показаны красным шрифтом как комментарии.
     * Пользователя передавать не обязательно.
     *
     * $notifyTerm - это минимальная дата до которой не дублировать уведомление.
     *
     * @param ShopOrder $order
     * @param string $comment
     * @param string $notifyTerm
     */
    public function addOrderNotify(ShopOrder $order, $user, $comment, $notifyTerm = false) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();
        $comment = trim($comment);

        try {
            SQLObject::TransactionStart();

            if ($user) {
                $userID = $user->getId();
            } else {
                $userID = 0;
            }

            if ($notifyTerm) {
                $tmp = CommentsAPI::Get()->getComments($commentKey);
                $tmp->addWhere('cdate', $notifyTerm, '>=');
                $tmp->setId_user($userID);
                $tmp->setLimitCount(1);
                if ($tmp->getNext()) {
                    throw new ServiceUtils_Exception('notify-term');
                }
            }

            // добавляем комментарий
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $userID
            );
            $object->setType('notify');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
                $order,
                null,
                $comment
            );

            // специально чтобы поставить udate
            $order->setUuserid($userID);
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            SQLObject::TransactionCommit();
            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить order-комментарий к заказу.
     * Изменение будет показано серыми шрифтом между комментариями.
     * Пользователя передавать не обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     */
    public function addOrderDocument(ShopOrder $order, $user, $comment) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            if ($user) {
                $userID = $user->getId();
            } else {
                $userID = 0;
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $userID
            );

            $object->setType('document');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
                $order,
                $user,
                $comment
            );

            // специально чтобы поставить udate
            $order->setUuserid($userID);
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить change-комментарий к заказу.
     * Изменение будет показано серыми шрифтом между комментариями.
     * Пользователя передавать не обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     */
    public function addOrderChange(ShopOrder $order, $user, $comment) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            if ($user) {
                $userID = $user->getId();
            } else {
                $userID = 0;
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $userID
            );

            $object->setType('change');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
                $order,
                $user,
                $comment
            );

            // специально чтобы поставить udate
            $order->setUuserid($userID);
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить email-комментарий к заказу.
     * Пользователя передавать не обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $fileIDArray
     */
    public function addOrderEmail(ShopOrder $order, $user, $comment, $fileIDArray = false) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);

            if (!$fileIDArray) {
                $fileIDArray = array();
            }

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            if ($user) {
                $userID = $user->getId();
            } else {
                $userID = 0;
            }

            // прицепляем файлы
            foreach ($fileIDArray as $fileID) {
                try {
                    $file = Shop::Get()->getFileService()->getFileByID($fileID);
                    if ($file->getKey()) {
                        $file = Shop::Get()->getFileService()->copyFile($file);
                    }
                    $file->setKey('order-'.$order->getId());
                    $file->update();

                    $comment .= "\n";
                    $comment .= '[file]'.$file->getId().'[/file]';
                    $comment .= "\n";
                } catch (ServiceUtils_Exception $se) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $se;
                    }
                }
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $userID
            );

            $object->setType('email');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // специально чтобы поставить udate
            $order->setUuserid($userID);
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить sms-комментарий к заказу.
     * Пользователя передавать не обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     */
    public function addOrderSMS(ShopOrder $order, $user, $comment) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            if ($user) {
                $userID = $user->getId();
            } else {
                $userID = 0;
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $userID
            );

            $object->setType('sms');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // специально чтобы поставить udate
            $order->setUuserid($userID);
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить комментарий к заказу.
     * Пользователя передавать обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $fileIDArray
     * @param bool $addOrderEmployer
     *
     * @return CommentsAPI_XComment
     */
    public function addOrderComment(ShopOrder $order, $user, $comment,
    $fileIDArray = false, $addOrderEmployer = true, $excludeNotifyUserArray = false) {

        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            if (!$user) {
                try{
                    $user = Shop::Get()->getUserService()->getUserByID(
                        Shop::Get()->getSettingsService()->getSettingValue('user-robot')
                    );
                } catch (Exception $eUser) {
                    throw new ServiceUtils_Exception('user-not-found');
                }
            }


            $comment = trim($comment);

            if (!$fileIDArray) {
                $fileIDArray = array();
            }

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            // прицепляем файлы
            foreach ($fileIDArray as $fileID) {
                try {
                    $file = Shop::Get()->getFileService()->getFileByID($fileID);
                    if ($file->getKey()) {
                        $file = Shop::Get()->getFileService()->copyFile($file);
                    }
                    $file->setKey('order-'.$order->getId());
                    $file->update();

                    $comment .= "\n";
                    $comment .= '[file]'.$fileID.'[/file]';
                    $comment .= "\n";
                } catch (ServiceUtils_Exception $se) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $se;
                    }
                }
            }

            // добавляем того кто пишет комментарий в наблюдатели автоматически
            if ($addOrderEmployer) {
                try {
                    Shop::Get()->getShopService()->addOrderEmployer($order, $user);
                } catch (Exception $watcherEx) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $watcherEx;
                    }
                }
            }

            // парсим комментарий на предмет юзеров
            // и добавляем их в наблюдатели
            if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $comment, $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $wUser = Shop::Get()->getUserService()->getUserByID($userID);
                        Shop::Get()->getShopService()->addOrderEmployer($order, $wUser);
                    } catch (Exception $watcherEx) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $watcherEx;
                        }
                    }
                }
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $user->getId()
            );
            $object->setType('comment');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
                $order,
                $user,
                $comment,
                $excludeNotifyUserArray
            );

            // специально чтобы поставить udate
            $order->setUuserid($user->getId());
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function addOrderCall(ShopOrder $order, ShopEvent $event) {

        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            // по умолчанию файла нет
            $fileSound = false;

            // если что-то есть, то это как минимум загрузка
            if ($event->getFile()) {
                $fileSound = 'load';
            }

            if ($event->getFile()) {
                try {
                    // пытаемся найти файл на хешу
                    $file = Shop::Get()->getFileService()->getFileByHash($event->getFile());
                    $fileSound = $file->makeURL();
                } catch (Exception $e) {

                }
            }

            if (preg_match("/^http/ius", $event->getFile())) {
                $fileSound = $event->getFile();
            }

            if (!$fileSound) {
                return false;
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $fileSound
            );

            $object->setIp($event->getId());
            $object->setType('ecall');
            $object->setCdate($event->getCdate());
            $object->update();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить конечный результат
     * Пользователя передавать обязательно.
     *
     * @param ShopOrder $order
     * @param User $user
     * @param string $comment
     * @param array $fileIDArray
     * @param bool $addOrderEmployer
     *
     * @return CommentsAPI_XComment
     */
    public function addOrderResult(ShopOrder $order, User $user, $comment, $fileIDArray = false) {
        PackageLoader::Get()->import('CommentsAPI');
        $commentKey = 'shop-order-'.$order->getId();

        try {
            SQLObject::TransactionStart();

            $comment = trim($comment);

            if (!$fileIDArray) {
                $fileIDArray = array();
            }

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddBefore');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            // прицепляем файлы
            foreach ($fileIDArray as $fileID) {
                try {
                    $file = Shop::Get()->getFileService()->getFileByID($fileID);
                    if ($file->getKey()) {
                        $file = Shop::Get()->getFileService()->copyFile($file);
                    }
                    $file->setKey('order-'.$order->getId());
                    $file->update();

                    $comment .= "\n";
                    $comment .= '[file]'.$fileID.'[/file]';
                    $comment .= "\n";
                } catch (ServiceUtils_Exception $se) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $se;
                    }
                }
            }

            // добавляем того кто пишет комментарий в наблюдатели автоматически
            try {
                Shop::Get()->getShopService()->addOrderEmployer($order, $user);
            } catch (Exception $watcherEx) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $watcherEx;
                }
            }


            // парсим комментарий на предмет юзеров
            // и добавляем их в наблюдатели
            if (preg_match_all("/\[(?:.+?)\#(\d+)\]/ius", $comment, $r)) {
                foreach ($r[1] as $userID) {
                    try {
                        $wUser = Shop::Get()->getUserService()->getUserByID($userID);
                        Shop::Get()->getShopService()->addOrderEmployer($order, $wUser);
                    } catch (Exception $watcherEx) {
                        if (PackageLoader::Get()->getMode('debug')) {
                            print $watcherEx;
                        }
                    }
                }
            }

            // добавляем комментарий как обычный (comment)
            $object = CommentsAPI::Get()->addComment(
                $commentKey,
                $comment,
                $user->getId()
            );
            $object->setType('commentresult');
            $object->update();

            // создаем уведомления
            Shop::Get()->getShopService()->addNotification(
                $order,
                $object,
                $user
            );

            // отправляем его по почте
            Shop::Get()->getShopService()->orderEmailNotification(
                $order,
                $user,
                $comment
            );

            // специально чтобы поставить udate
            $order->setUuserid($user->getId());
            $order->setUdate(date('Y-m-d H:i:s'));
            $order->update();

            // выбрасываем событие
            $event = Events::Get()->generateEvent('shopOrderCommentAddAfter');
            $event->setOrder($order);
            $event->setComment($comment);
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $object;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить массив данных по заказу для формирования документов
     *
     * @param ShopOrder $order
     *
     * @return array
     */
    public function makeOrderAssignArrayForDocument(ShopOrder $order) {
        try {
            $contractor = Shop::Get()->getShopService()->getContractorByID($order->getContractorid());
            $contractorTax = $contractor->getTax();
        } catch (Exception $e) {
            $contractorTax = 0;
        }
        $currencyOrder = $order->getCurrency();
        $printWarranty = false;
        $taxSum = 0;
        $orderSum = 0;
        $productsSum = 0;
        $orderSumWithoutTax = 0;
        $priceSum = 0;
        $minFrom = false;
        $maxTo = false;
        // формируем документ
        $productsArray = array();
        $productInfoArray = array();
        $hasWarranty = false;
        $orderproducts = $order->getOrderProducts();
        while ($op = $orderproducts->getNext()) {
            try {
                $priceWithoutTax = $op->makePrice($currencyOrder);
                if ($op->getProducttax() && $contractorTax) {
                    $priceWithoutTax = Shop::Get()->getShopService()->calculateSum(
                        $priceWithoutTax,
                        $contractorTax,
                        0,
                        0,
                        true,
                        false,
                        false
                    );
                }
                $unit = '';
                try {
                    $unit = $op->getProduct()->getUnit();
                } catch (ServiceUtils_Exception $ue) {
                    if (PackageLoader::Get()->getMode('debug')) {
                        print $e;
                    }
                }
                $productsArray[] = array(
                    'productid' => $op->getProductid(),
                    'name' => $op->getProductname(),
                    'serial' => $op->getSerial(),
                    'warranty' => $op->getWarranty(),
                    'warrantyDate' =>
                    DateTime_Object::FromString($order->getCdate())->addMonth(
                        $op->getWarranty()
                    )->setFormat('d-m-Y')->__toString(),
                    'warrantyDateNow' =>
                    DateTime_Object::Now()->addMonth($op->getWarranty())->setFormat('d-m-Y')->__toString(),
                    'price' => $priceWithoutTax,
                    'productprice' => $op->makePrice($order->getCurrency()),
                    'currency' => $currencyOrder->getSymbol(),
                    'count' => $op->getProductcount(),
                    'sum' => $op->makeSum($currencyOrder),
                    'productsumtax' => round($op->makePrice($order->getCurrency())*0.2, 2),
                    'productpricesumtax' => round($op->makePrice($order->getCurrency())*1.2, 2),
                    'comment' => $op->getComment(),
                    'pricenotax' => round($priceWithoutTax, 2),
                    'sumnotax' => round($priceWithoutTax * $op->getProductcount(), 2),
                    'unit' => $unit,
                    'categoryname' => $op->getCategoryname(),
                    'from' => $op->getDatefrom(),
                    'from_date' => DateTime_Formatter::DateISO8601($op->getDatefrom()),
                    'to' => $op->getDateto(),
                    'to_date' => DateTime_Formatter::DateISO8601($op->getDateto()),
                );
                if ($op->getWarranty()) {
                    $hasWarranty = true;
                }
                $priceSum += round($op->makePrice($order->getCurrency()), 2);
                // сумма всех товаров
                $productsSum += $op->getProductcount();
                $orderSumWithoutTax += round($priceWithoutTax * $op->getProductcount(), 2);
                if (!$minFrom || $minFrom > $op->getDatefrom()) {
                    $minFrom = $op->getDatefrom();
                }
                if (!$maxTo || $maxTo < $op->getDateto()) {
                    $maxTo = $op->getDateto();
                }
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            // информация о товарах (для перезентационных документах)
            try {
                $product = $op->getProduct();
                $imageArray = array();
                $images = $product->getImages();
                while ($i = $images->getNext()) {
                    $imageArray[] = $i->makeImageThumb(320, 240);
                }
                $productInfoArray[$product->getId()] = array(
                    'name' => $product->getName(),
                    'categoryname' => $op->getCategoryname(),
                    'price' => $product->getPrice(),
                    'currency' => $product->getCurrency()->getSymbol(),
                    'unit' => $product->getUnit(),
                    'description' => $product->getDescription(),
                    'image' => $product->getImage() ? $product->makeImageThumb(320, 240) : false,
                    'imageArray' => $imageArray,
                );
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
        }
        // цена доставки
        $deliveryPrice = $order->getDeliveryprice();
        try {
            if (!$order->getDelivery()->getPaydelivery()) {
                $deliveryPrice = '0.00';
            }
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        $a = array();
        $a['number'] = $order->getId();
        $a['name'] = $order->getName();
        $a['productsArray'] = $productsArray;
        $a['productsum'] = round($productsSum, 3);
        if (isset($contractor)) {
            $a['contractordetails'] = nl2br($contractor->getDetails());
            $a['contractorname'] = $contractor->getName();
            for ($j = 1; $j <= 10; $j++) {
                $a['contractorfield'.$j] = $contractor->getField('customfield'.$j);
            }
        }
        $a['ordercomment'] = htmlspecialchars($order->makeComment());
        $a['ordersum'] = $order->getSum();
        $a['orderdiscountsum'] = $order->getDiscountsum();
        $a['pricesum'] = $priceSum;
        //текстовая сумма с доставкой сумма заказа с доставкой
        $a['ordersumtext'] = StringUtils_Converter::FloatToMoney($order->getSum() + $deliveryPrice, 'ua');
        $a['ordersumtext_ru'] = StringUtils_Converter::FloatToMoney($order->getSum() + $deliveryPrice, 'ru');
        $a['ordersumtext_ua'] = StringUtils_Converter::FloatToMoney($order->getSum() + $deliveryPrice, 'ua');
        $a['ordercurrency'] = $order->getCurrency()->getSymbol();
        $a['clientname'] = $order->getClientname();
        $a['clientphone'] = $order->getClientphone();
        $a['clientemail'] = $order->getClientemail();
        $a['clientaddress'] = $order->getClientaddress();
        $a['clientid'] = $order->getUserid();
        $a['orderid'] = $order->getId();
        $a['orderdate'] = DateTime_Formatter::DateRussianGOST($order->getCdate()); // @todo: in multi-languages
        $a['orderCdate'] = date('d.m.Y');
        $a['orderdatetime'] = DateTime_Formatter::DateTimeRussianGOST($order->getCdate()); // @todo: in multi-languages
        $a['orderdateto'] = DateTime_Formatter::DateRussianGOST($order->getDateto()); // @todo: in multi-languages
        $a['orderdatetimeto'] = DateTime_Formatter::DateTimeRussianGOST($order->getDateto()); // @todo:
        $a['printwarranty'] = $printWarranty;
        $a['deliveryprice'] = $deliveryPrice;
        $a['productInfoArray'] = $productInfoArray;
        $a['hasWarranty'] = $hasWarranty;
        if ($minFrom) {
            $a['minFrom'] = DateTime_Formatter::DateISO8601($minFrom);
        }
        if ($maxTo) {
            $a['maxTo'] = DateTime_Formatter::DateISO8601($maxTo);
        }
        try {
            $a['ordercategory'] = $order->getCategory()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        try {
            $a['managername'] = $order->getManager()->makeName();
        } catch (Exception $ex) {

        }
        try {
            $a['authorname'] = $order->getAuthor()->makeName();
        } catch (Exception $ex) {

        }

        $taxSum = $order->makeTaxSum();
        $a['taxsum'] = round($taxSum, 2);
        $a['taxsumtext_ru'] = StringUtils_Converter::FloatToMoney(round($taxSum, 2), 'ru');
        $a['taxsumtext_ua'] = StringUtils_Converter::FloatToMoney(round($taxSum, 2), 'ua');
        $discountSum = $order->getDiscountsum();
        if ($contractorTax) {
            $discountSum /= (1 + $contractorTax/100);
        }
        $a['discountsum'] = round($discountSum, 2);
        //к общей сумме с НДС, добавляем стоимость доставки
        $a['ordersumwithtax'] = round($order->getSum() + $deliveryPrice, 2);
        $a['ordersumwithtaxtext_ru'] = StringUtils_Converter::FloatToMoney(
            round($order->getSum() + $deliveryPrice, 2),
            'ru'
        );
        $a['ordersumwithtaxtext_ua'] = StringUtils_Converter::FloatToMoney(
            round($order->getSum() + $deliveryPrice, 2),
            'ua'
        );
        $a['ordersumwithouttax'] = round($orderSumWithoutTax, 2);
        try{
            $a['deliveryName'] = $order->getDelivery()->getName();
            $a['deliveryPay'] = $order->getPayment()->getName();
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        try{
            $a['image'] = str_replace(
                PROJECT_PATH, '', Shop_ImageProcessor::MakeThumbProportional(
                    PROJECT_PATH.Shop::Get()->getShopService()->getLogoCurrent()->makeImage(),
                    180,
                    180
                )
            );
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        $a['orderBarcode'] = $order->makeBarcode();
        return $a;
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
     * Добавить(Обновить) ссылку на продукт конкурента, для парсинга цен.
     *
     * @param ShopProduct $product
     * @param $url
     *
     * @return XShopProductRival
     * @throws Exception
     *
     * @deprecated
     */
    public function addRival(ShopProduct $product, $url, $force = false, $frequency = false) {
        return RivalService::Get()->addRival($product, $url, $force, $frequency);
    }

    /**
     * Получить минимальную цену на товар по конкурентам
     *
     * @param ShopProduct $product
     *
     * @return float
     *
     * @deprecated
     */
    public function getRivalMinPrice(ShopProduct $product) {
        return RivalService::Get()->getRivalMinPrice($product);
    }

    /**
     * Спарись цену.
     *
     * @param XShopProductRival $rival
     *
     * @return XShopProductRival
     * @throws Exception
     *
     * @deprecated
     */
    public function processRival(XShopProductRival $rival) {
        return RivalService::Get()->processRival($rival);
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
     * Создать штрих-код
     *
     * @param string $file
     * @param string $text
     */
    public function createBarcodeImage($file, $text) {
        if (!file_exists($file)) {
            $fontSize = 60;
            $text = '*'.$text.'*';

            $bbox = imagettfbbox($fontSize, 0, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            $im = imagecreate($bbox[4] - $bbox[6] + 5, $bbox[3] - $bbox[5]);
            $background_color = imagecolorallocate($im, 255, 255, 255);
            $text_color = imagecolorallocate($im, 0, 0, 0);

            imagettftext($im, $fontSize, 0, -$bbox[6], -$bbox[5], $text_color, MEDIA_PATH.'/fonts/Code39.TTF', $text);

            imagepng($im, $file);
            imagedestroy($im);
        }
    }

    /**
     * Получить список notification-емейлов,
     * на которые будет выполняться отправка писем.
     *
     * @return array
     *
     * @deprecated
     */
    public function getNotificationEmailArray($emailKey = 'email-orders') {
        return Shop::Get()->getNotificationService()->getNotificationEmailArray($emailKey);
    }

     /**
     * Перелинковка текста если подключен модуль SEO
     *
     * @papam string $text
     *
     * @return string $text
     */
    public function relinkSeo($text) {
        if (!Shop_ModuleLoader::Get()->isImported('seo')) {
            return $text;
        }
        $text = str_replace("&nbsp;", ' ', $text);
        $relinks = new XShopSEOLink();
        $relinks->setOrder('keyword', 'DESC');
        while ($relink = $relinks->getNext()) {
            $keyword = ($relink->getKeyword());
            $url = trim($relink->getUrl());
            $text = preg_replace(
                "/([\(\s>]+)({$keyword})([\)\s<\.\:\;]+)/ius",
                "$1<a href=\"/{$url}/\">{$keyword}</a>$3",
                $text
            );
        }
        return $text;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_ShopService
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
     * Получить список notification-емейлов
     *
     * @param string $text
     *
     * @return array
     */
    protected function _extractEmailArray($text) {
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $orderEmailsArray = explode(' ', $text);
        $a = array();
        foreach ($orderEmailsArray as $x) {
            $x = trim($x);
            if (Checker::CheckEmail($x)) {
                $a[] = $x;
            }
        }
        return $a;
    }

    protected function _processBoolValue($value) {
        if (substr_count($value, 'y')
        || substr_count($value, '+')
        || substr_count($value, 'да')
        || substr_count($value, '1')
        ) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * Форматировать текст для письма.
     * Поправка ссылок [file]
     *
     * @param string $content
     *
     * @return string
     */
    public function formatCommentForEmail($content) {
        $content = preg_replace_callback(
            "/\[file\](\d+)\[\/file\]/ius",
            array($this, '_formatCommentFileReplace'),
            $content
        );

        return $content;
    }

    private function _formatCommentFileReplace($x) {
        $fileID = $x[1];
        $tmp = new ShopFile($fileID);
        if (!$tmp->getId()) {
            $fileID;
        }

        $text = '"'.$tmp->getName().'"';
        $text .= ' ';
        $text .= Engine::Get()->getProjectURL();
        $text .= $tmp->makeURL();

        return $text;
    }

    protected function _sortNameASC($a, $b) {
        return $a['name'] > $b['name'];
    }

    /**
     * Хитрый костыль-метод, который убирает левые для UTF-8 символы :)
     *
     * @param string $str
     *
     * @return string
     */
    private function _xlsEncode($str) {
        return iconv('utf-8', 'utf-8', $str);
    }

    /**
     * Кеш товаров, которые в корзине
     *
     * @var array
     */
    private $_basketArray = false;

    /**
     * Кеш логотипов
     *
     * @var array
     */
    private $_logoArray = false;

    /**
     * Кеш баннеров
     *
     * @var array
     */
    private $_bannerArray = false;

    /**
     * Временный кеш для дерева категорий.
     * Нужен когда быстро и много вызывается buildProductCategory()
     *
     * @var array
     */
    private $_categoryTreeArray = array();

    /**
     * Ключ файла.
     * Переменная используется в методах formatComment
     *
     * @var string
     */
    private $_fileReplaceCallbackKey;

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_ShopService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}