<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Shop_CallbackService extends ServiceUtils_AbstractService {

    /**
     * Получить заказные звонки
     *
     * @return XShopCallBack
     */
    public function getCallbackAll() {
        try {
            return $this->getObjectsAll('XShopCallBack');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object(XShopCallBack) by id not found');
    }

    /**
     * Получить запись по id
     * @return XShopCallBack
     */
    public function getCallbackByID($id) {
        try {
            return $this->getObjectByID($id, 'XShopCallBack');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object(XShopCallBack) by id not found');
    }

    /**
     * Добавить обратный звонок
     *
     * @param string $name
     * @param string $phone
     * @param string $question
     * @param User $user
     */
    public function addCallback($name, $phone, $question, $user = null, $url = false, $linkkey = false) {
        try {
            SQLObject::TransactionStart();

            $call = $this->getCallbackAll();

            $name = trim($name);
            $phone = trim($phone);
            $question = nl2br(trim($question));
            $cdate = DateTime_Object::Now();

            $ex = new ServiceUtils_Exception();

            // @todo: убрать костыли placeholder'a
            if (!$name || $name == 'Имя') {
                $ex->addError('name');
            }

            if (!Checker::CheckPhone($phone)) {
                $ex->addError('phone');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $call->setName($name);
            $call->setPhone($phone);
            $call->setCdate($cdate);
            $call->setAnswer($question);
            $call->setUrl($url);
            $call->setLinkkey($linkkey);
            if ($user) {
                $call->setUserid($user->getId());
            }
            $call->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-add-callback');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('call-back-email'));
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->assign('name', $name);
                $sender->assign('phone', $phone);
                $sender->assign('question', $question);
                $sender->assign('url', $url);
                if ($user) {
                    $sender->assign('userUrl', Engine::Get()->getProjectURL().$user->makeURLEdit());
                }
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
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
     * @return Shop_CallbackService
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
     * @var Shop_CallbackService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}