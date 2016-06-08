<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Сервис для работы сущностями доставки в OneBox
 *
 * @author Igor Ustimenko <i.ustimenko@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_DeliveryService extends ServiceUtils_AbstractService {

    /**
     * Получить все варианты доставки
     *
     * @return ShopDelivery
     */
    public function getDeliveryAll() {
        try {
            $delivery = $this->getObjectsAll('ShopDelivery');
            $delivery->setOrder('sort', 'ASC');
            return  $delivery;
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить способ доставки по ID
     *
     * @return ShopDelivery
     */
    public function getDeliveryByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopDelivery');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить службы доставки с таким классом
     *
     * @param string $logicclass
     *
     * @return ShopDelivery
     */
    public function getDeliveryByLogicclass($logicclass) {
        $x = $this->getDeliveryAll();
        $x->setLogicclass($logicclass);
        return $x;
    }

    /**
     * Добавить вариант доставки или вернуть вариант,
     * если такой уже есть.
     *
     * @param string $name
     *
     * @return ShopDelivery
     */
    public function addDelivery($name) {
        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            if (!$name) {
                throw new ServiceUtils_Exception('name');
            }

            $delivery = $this->getDeliveryAll();
            $delivery->setName($name);
            if (!$delivery->select()) {
                $delivery->setCurrencyid(Shop::Get()->getCurrencyService()->getCurrencySystem()->getId());
                $delivery->insert();
            }

            SQLObject::TransactionCommit();

            return $delivery;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить вариант доставки
     *
     * @param ShopDelivery $delivery
     * @param $name
     * @param $price
     * @param $currencyID
     * @param $needcity
     * @param $needaddress
     * @param $description
     * @param $sort
     * @param $image
     * @param $deleteImage
     * @param bool $payDelivery
     * @param bool $logicclass
     * @param bool $needcountry
     *
     * @throws Exception
     */
    public function updateDelivery(ShopDelivery $delivery, $name, $price, $currencyID, $needcity, $needaddress,
                                   $description, $sort, $image, $deleteImage, $payDelivery = false, $logicclass = false,
                                   $needcountry = false, $default = false) {
        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $price = (float) trim($price);
            $price = str_replace(',', '.', $price);
            $currency = trim($currencyID);
            $description = trim($description);
            $sort = trim($sort);
            $logicclass = trim($logicclass);

            $ex = new ServiceUtils_Exception();
            if (!$name) {
                $ex->addError('name');
            }
            if ($price < 0) {
                $ex->addError('price');
            }

            if ($image) {
                if (!Checker::CheckImageFormat($image)) {
                    $ex->addError('image');
                }
            }
            if ($ex->getErrorsArray()) {
                throw $ex;
            }

            $delivery->setName($name);
            $delivery->setPrice($price);
            $delivery->setCurrencyid($currency);
            $delivery->setNeedaddress($needaddress);
            $delivery->setNeedcity($needcity);
            $delivery->setNeedcountry($needcountry);
            $delivery->setDefault($default);
            $delivery->setPaydelivery($payDelivery);
            $delivery->setDescription($description);
            $delivery->setSort($sort);
            $delivery->setLogicclass($logicclass);
            if ($deleteImage) {
                $delivery->setImage('');
            } elseif ($image) {
                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $image,
                    '/shop/',
                    false, // format
                    'delivery-'.$name
                );
                copy($image, MEDIA_PATH.'/shop/'.$file);
                $delivery->setImage($file);
            }

            $delivery->update();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }   

    /**
     * Удалить доставку
     *
     * @param ShopDelivery $product
     */
    public function deleteDelivery(ShopDelivery $delivery) {
        try {
            SQLObject::TransactionStart();

            // удаляем доставку
            $delivery->delete();

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
     * @return Shop_DeliveryService
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
     * Подменяемый объект сервиса
     *
     * @var Shop_DeliveryService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}