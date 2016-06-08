<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Shop_GuestBookService extends ServiceUtils_AbstractService {

    /**
     * Получить все записи с гостевой книге
     *
     * @return ShopGuestBook
     * @throws ServiceUtils_Exception
     */
    public function getGuestBookAll() {
        try {
            return $this->getObjectsAll('ShopGuestBook');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object (ShopGuestBook) by id not found');
    }
    /**
     * Получить зхапись по id
     *
     * @param integer $id
     *
     * @return ShopGuestBook
     *
     * @throws ServiceUtils_Exception
     */
    public function getGuestBookByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopGuestBook');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object (ShopGuestBook) by id not found');
    }

    /**
     * Добавить отзыв
     *@param string $response
     *@param User $user
     *@param int $orderNumber
     * @throws ServiceUtils_Exception
     */
    public function addGuestBook($response, $user, $orderNumber=false) {
        try {
            SQLObject::TransactionStart();

            $guestbook = $this->getGuestBookAll();
            $response = trim($response);

            $cdate = date('Y-m-d H:i:s');

            if (!$response) {
                throw new ServiceUtils_Exception();
            }

            $guestbook->setText($response);
            $guestbook->setCdate($cdate);
            if ($user) {
                $guestbook->setUserId($user->getId());
                $guestbook->setName($user->getName());
            }
            $guestbook->setDone(0);
            $guestbook->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-guestbook-response');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('email-guestbook'));
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());

                if ($user) {
                    $sender->setEmailFrom($user->getEmail());
                    $sender->assign('userUrl', Engine::Get()->getProjectURL().$user->makeURLEdit());
                }

                if (!$orderNumber) {
                    $orderNumber = 'Не указан';
                }
                $sender->assign('orderNumber', $orderNumber);

                $sender->assign('response', $response);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    public function updateGuestBook(ShopGuestBook $guestbook, $response, $userId, $level) {
        try {
            SQLObject::TransactionStart();

            $response = trim($response);
            $done = $level;

            $ex = new ServiceUtils_Exception();
            if (!$response) {
                $ex->addError('response');
            }

            if (!$done) {
                $ex->addError('done');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if ($response !== $guestbook->getText()) {
                $guestbook->setText($response);
            }
            if ($done !== $guestbook->getLevel()) {
                $guestbook->setDone($done);
            }
            $guestbook->update();

            if ($done > 0) {
                // sendmail
                $user = Shop::Get()->getUserService()->getUserByID($userId);
                $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-shop-guestbook-answer');
                if ($tpl) {
                    $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                    $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                    $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                    $sender->addEmail($user->getEmail());
                    $sender->assign('name', $user->getLogin());
                    $sender->assign('response', $response);
                    $sender->assign(
                        'signature',
                        Shop::Get()->getSettingsService()->getSettingValue('letter-signature')
                    );
                    $sender->send();
                }
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
     * @return Shop_GuestbookService
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
     * @var Shop_GuestbookService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}