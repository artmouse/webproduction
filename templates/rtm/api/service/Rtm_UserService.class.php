<?php
class Rtm_UserService extends Shop_UserService {

    public function CheckPassword($password, $min = 6, $max = false) {
        $f = 'mb_strlen';
        if (!function_exists($f)) $f = 'strlen';
        if ($min && $f($password) < $min) {
            return false;
        }
        if ($max && $f($password) > $max) {
            return false;
        }
        if (!$password && $min > 0) {
            return false;
        }
        $strongOfPassword = 0;
        //Проверяем наличие чисел
        /*if(preg_match("/([0-9]+)/", $password))
        {
            $strongOfPassword++;
        }
        //Проверяем наличие больших букв
        if(preg_match("/([A-Z]+)/", $password))
        {
            $strongOfPassword++;
        }
        //Проверяем наличие маленьких букв
        if(preg_match("/([a-z]+)/", $password))
        {
            $strongOfPassword++;
        }
        //Проверяем наличие спецсимволов
        if(preg_match("/\W/", $password))
        {
            $strongOfPassword++;
        }
        if($strongOfPassword < 2) {
            return false;
        }*/

        return true;
    }

    /**
     * @return User
     */
    public function addUser($login, $password, $email, $name, $phone, $address, $bdate, $parentid,
                            $level = false, $commentadmin = false, $groupid = false, $pricelevel = 0, $distribution = false,
                            $tags = false, $namelast=false, $namemiddle=false) {
        try {
            SQLObject::TransactionStart();

            $name = trim($name);
            $login = trim($login);
            $email = trim($email);
            $address = trim($address);
            $bdate = trim($bdate);
            $parentid = trim($parentid);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);

            //$tags = $this->_checkTags($tags);

            $pricelevel = (int) $pricelevel;
            if ($pricelevel < 0) {
                $pricelevel = 0;
            }
            if ($pricelevel > 5) {
                $pricelevel = 5;
            }

            // из телефона убираем всякий мусор, оставляем только цифры
            $phone = preg_replace("/[^0-9]/ius", '', $phone);

            // нужно ли активировать аккаунты?
            //$activate = Shop::Get()->getSettingsService()->getSettingValue('user-account-activate');
            $activate = false;

            $ex = new ServiceUtils_Exception();
            if($login){
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user = new User();
                    $user->setLogin($login);
                    if ($user->select()) {
                        $ex->addError('login-exists');
                    }
                }
            }

            if (!$this->CheckPassword($password)) {
                $ex->addError('password');
            }

            $insert = true;

            if (!Checker::CheckEmail($email)) {
                $ex->addError('email');
            } else {
                $user = new User();
                $user->setEmail($email);
                $select = $user->select();
                if ($select && is_object($user) && $user->getLogin()) {
                    $ex->addError('email-exists');
                } else if ($select){
                    $insert = false;
                }
            }

            if (!empty($parentid)) {
                try {
                    !$this->getUserByID($parentid);
                } catch (Exception $e) {
                    $ex->addError('parentid');
                }
            }

            // Проверка даты рожения
            if ($bdate && !Checker::CheckDate($bdate)) {
                $ex->addError('bdate');
            }

            if (!empty($phone)) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user = new User();

            $user->setEmail($email);

            if (!$insert) {
                $user->select();
            }

            $user->setCdate(date('Y-m-d H:i:s'));
            $user->setEmail($email);
            if ($login) {
                $user->setLogin($login);
            }
            //инициализируем траханую соль
            $this->setPasswordSalt('WebProduction');

            $user->setPassword($this->createHash($password));
            $user->setName($name);
            if ($namelast) {
                $user->setNamelast($namelast);
            }
            if ($namemiddle) {
                $user->setNamemiddle($namemiddle);
            }
            $user->setAddress($address);
            $user->setPhone($phone);
            $user->setBdate($bdate);
            $user->setGroupid($groupid);
            $user->setPricelevel($pricelevel);
            $user->setDistribution($distribution);
            $user->setTags($tags);
            $user->setUdate(date('Y-m-d H:i:s'));

            // контрактор по умолчанию
            try {
                $user->setContractorid(Shop::Get()->getShopService()->getContractorDefault()->getId());
            } catch (Exception $contractorEx) {

            }

            if ($level) {
                $level = (int)$level;
                $user->setLevel($level);
            } elseif ($activate) {
                $user->setLevel(0);

                PackageLoader::Get()->import('Randomer');
                $random = Randomer_Password::Random(16, 16);
                $user->setActivatecode($random);
            } else {
                $user->setLevel(1);
            }

            if ($commentadmin) {
                $user->setCommentadmin($commentadmin);
            }

            if ($insert) {
                $user->insert();
            } else {
                $user->update();
            }

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-registration');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('header-email'));
                $sender->addEmail($email);
                $sender->assign('id', $user->getId());
                $sender->assign('login', $login);
                $sender->assign('password', $password);
                $sender->assign('clientUrl', Engine::Get()->getProjectURL()."/client/profile/");
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                if (isset($random) && $activate && $level < 3) {
                    $sender->assign('activateURL', Engine::Get()->getProjectURL() . Engine::GetLinkMaker()->makeURLByContentIDParams('shop-account-activate', array('email' => $email, 'code' => $random)));
                }
                $sender->send();
            }

            // fire event
            $event = Events::Get()->generateEvent('shopUserAddAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            return $user;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * @return Rtm_UserService
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __clone() {

    }

    private static $_Instance = null;
}