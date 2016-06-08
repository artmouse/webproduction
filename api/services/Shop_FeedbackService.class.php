<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2012 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

class Shop_FeedbackService extends ServiceUtils_AbstractService {

    /**
     * Получить всех сообщений из обратной связи
     *
     * @return XShopFeedback
     */
    public function getFeedbackAll() {
        try {
            return $this->getObjectsAll('XShopFeedback');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object(XShopFeedback) by id not found');
    }

    /**
     * Получить запись по id
     *
     * @return XShopFeedback
     */

    public function getFeedbackByID($id) {
        try {
            return $this->getObjectByID($id, 'XShopFeedback');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object(XShopFeedback) by id not found');
    }

    /**
     *  Add Feedback
     *
     * @param string $name
     * @param string $phone
     * @param string $email
     * @param string $message
     * @param User $user
     */
    public function addFeedback($name, $phone, $email, $message, $user = false, $url = false) {
        try {
            SQLObject::TransactionStart();

            $f = $this->getFeedbackAll();

            $name = trim($name);
            $phone = trim($phone);
            $email = trim($email);
            $message = nl2br(trim($message));
            $cdate = date('Y-m-d H:i:s');
            $ip = false;

            $ex = new ServiceUtils_Exception();

            // @todo
            if (!$name || $name == 'Имя') {
                $ex->addError('name');
            }

            if (!$message) {
                $ex->addError('message');
            }

            if ($phone == 'Телефон') {
                $phone = '';
            }

            if (!empty($phone)) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if (!Checker::CheckEmail($email)) {
                $ex->addError('email');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $f->setName($name);
            $f->setPhone($phone);
            $f->setCdate($cdate);
            $f->setEmail($email);
            $f->setMessage($message);
            $f->setPageurl($url);
            if ($user) {
                $f->setUserid($user->getId());
                $auth = new XUserAuth();
                $auth->setUserid($user->getId());
                if ($auth->select()) {
                    $ip = $auth->getIp();
                }
            }
            $f->insert();
            
            // sendmail
            $tpl = MEDIA_PATH.'/mail-templates/add-feedback.html';
            if ($tpl) {
                $sender = new MailUtils_SmartySender($tpl);
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());

                $sender->addEmail(Shop::Get()->getSettingsService()->getSettingValue('feed-back-email'));
                $sender->setEmailFrom($email);

                $sender->assign('name', $name);
                $sender->assign('phone', $phone);
                $sender->assign('email', $email);
                $sender->assign('date', $cdate);
                $sender->assign('message', $message);
                $sender->assign('url', $url);
                if ($user) {
                    $sender->assign('userUrl', Engine::Get()->getProjectURL().$user->makeURLEdit());
                    $sender->assign('ip', $ip);
                }
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                $sender->send();
            }

            // добавляем комментарий в заказ
            $ok = false;

            if ($user) {
                $orders = Shop::Get()->getShopService()->getOrdersAll();
                $orders->setUserid($user->getId());
                $orders->setIssue(0);
                $orders->setDateclosed('0000-00-00 00:00:00');
                while ($x = $orders->getNext()) {
                    $ok = true;
                    Shop::Get()->getShopService()->addOrderComment(
                        $x,
                        $user,
                        "Клиент написал письмо: ".$message."\nФ.И.О.: ".$name.
                        "\nТелефон: ".$phone."\n Со страницы: ".$url,
                        false,
                        false
                    );
                    break;
                }
            }


            if (!$ok && $user) {
                // создаем новый заказ
                $order = Shop::Get()->getShopService()->makeOrderEmpty($user);
                $order->setUserid($user->getId());
                $order->setClientname($user->makeName(false, 'lfm'));
                $order->setClientphone($user->getPhone());
                $order->setClientemail($user->getEmail());
                $order->setClientaddress($user->getAddress());
                $order->update();

                Shop::Get()->getShopService()->addOrderComment(
                    $order,
                    $user,
                    "Клиент написал письмо: ".$message."\nФ.И.О.: ".$name.
                    "\nТелефон: ".$phone."\n Со страницы: ".$url,
                    false,
                    false
                );
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
     * @return Shop_FeedbackService
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
     * @var Shop_FeedbackService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}