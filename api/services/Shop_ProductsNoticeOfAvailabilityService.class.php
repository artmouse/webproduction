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
 * Doc
 *
 * @author Golub Oleksii <avator@webproduction.ua>
 *
 * @copyright WebProduction
 *
 * @package Shop
 */
class Shop_ProductsNoticeOfAvailabilityService extends ServiceUtils_AbstractService {

    /**
     * Получить все вопросы и ответы
     *
     * @return XShopProductsNoticeOfAvailability
     */
    public function getProductsNoticeOfAvailabilityAll() {
        try {
            return $this->getObjectsAll('XShopProductsNoticeOfAvailability');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Doc
     *
     * @return XShopProductsNoticeOfAvailability
     */
    public function getProductsNoticeOfAvailabilityID($id) {
        try {
            return $this->getObjectByID($id, 'XShopProductsNoticeOfAvailability');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Добавить уведомление о дуступности продукта.
     *
     * @param ShopProduct $product
     * @param $name
     * @param $email
     *
     * @throws Exception
     */

    public function addProductNoticeOfAvailability(ShopProduct $product, $name, $email) {
        try {
            SQLObject::TransactionStart();

            $x = $this->getProductsNoticeOfAvailabilityAll();

            $name = trim($name);
            $cdate = date('Y-m-d H:i:s');

            if (!$name || $name == 'Ваше имя') {
                throw new ServiceUtils_Exception('name');
            }

            if (!Checker::CheckEmail($email)) {
                throw new ServiceUtils_Exception('email');
            }

            $x->setCdate($cdate);
            $x->setName($name);
            $x->setEmail($email);
            $x->setProductid($product->getId());
            $x->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Doc
     *
     * @param XShopProductsNoticeOfAvailability $pr
     * @param $name
     * @param $email
     * @param $statys
     * @param $cdate
     * @param $senddate
     * @param $productid
     *
     * @throws ServiceUtils_Exception
     * @throws Exception
     */
    public function updateProductsNoticeOfAvailability(
        XShopProductsNoticeOfAvailability $pr,
        $name, $email, $statys, $cdate, $senddate, $productid
    ) {
        try {
            SQLObject::TransactionStart();
            $ex = new ServiceUtils_Exception();

            if (!$name) {
                $ex->addError('name');
            }

            if (!Checker::CheckDate($cdate)) {
                $ex->addError('cdate');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $pr->setName($name);
            $pr->setEmail($email);
            $pr->setStatus($statys);
            $pr->setCdate($cdate);
            $pr->setSenddate($senddate);
            $pr->setProductid($productid);

            $pr->update();

            SQLObject::TransactionCommit();
        } catch (Exception $e) {
            SQLObject::TransactionRollback();
            throw $e;
        }
    }

    public function deleteProductsNoticeOfAvailability(XShopProductsNoticeOfAvailability $pr) {
        try {
            $pr->delete();
            return true;
        } catch(Exception $e) {
            throw $e;
        }
    }

    public function sendMail(XShopProductsNoticeOfAvailability $x) {
        try {
            SQLObject::TransactionStart();

            $product = Shop::Get()->getShopService()->getProductByID($x->getProductid());
            if (!$product->getAvail()) {
                throw new ServiceUtils_Exception();
            }

            $senddate = date('Y-m-d H:i:s');

            $x->setSenddate($senddate);
            $x->setStatus(1);
            $x->update();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-products-notice-of-availability');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail($x->getEmail());
                $sender->assign('productName', $product->getName());
                $sender->assign('productUrl', $product->makeURL());
                $sender->assign('name', $x->getName());
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();

            return true;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();

            if (PackageLoader::Get()->getMode('debug')) {
                print $ge;
            }
            throw $ge;
        }
    }

    public function processNoticeOfAvail() {
        ModeService::Get()->verbose('Send product notice of avail...');

        $n = $this->getProductsNoticeOfAvailabilityAll();
        $n->setStatus(0);
        while ($x = $n->getNext()) {
            try {
                Shop::Get()->getProductsNoticeOfAvailabilityService()->sendMail($x);
            } catch (Exception $e) {
                ModeService::Get()->debug($e);
            }
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_ProductsNoticeOfAvailabilityService
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
     * @var Shop_ProductsNoticeOfAvailabilityService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}