<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class Shop_UserService extends ServiceUtils_UserService {

    public function __construct() {
        parent::__construct();

        // Задаем соль для шифрования пароля.
        // Соль не должна меняться, поскольку не кто потом не зайдёт в систему
        // желательное значение соли это названия проекта
        // Например: WebProduction
        // если соль false то шифрование производится md5()
        $this->setPasswordSalt('WebProduction');
    }

    /**
     * Получить всех пользователей
     *
     * @return User
     */
    public function getUsersAll($user = false) {
        $x = parent::getUsersAll();
        $x->setDeleted(0); // не удаленные
        $x->setOrder(array('namelast', 'name'), 'ASC');

        if ($user) {
            // накладываем ACL
            if ($user->getLevel() >= 3) {
                return $x;
            }

            // фильтр по уровню
            $levelArray = array(-1);
            for ($j = 0; $j <= 3; $j++) {
                if ($user->isAllowed('users-level-'.$j.'-view')) {
                    $levelArray[] = $j;
                }
            }
            if (count($levelArray) < 5) {
                $x->addWhereArray($levelArray, 'level');
            }

            if ($user->isAllowed('users-all-view')) {
                return $x;
            }

            $userID = $user->getId();

            $whereArray = array();

            // фильтр по группе
            /*$groups = $this->getUserGroupsAll();
            $groupIDArray = array(-1);
            while ($group = $groups->getNext()) {
                if ($user->isAllowed('users-group-'.$group->getId().'-view')) {
                    $groupIDArray[] = $group->getId();
                }
            }
            if ($user->isAllowed('users-group-0-view')) {
                $groupIDArray[] = 0;
            }
            $x->addWhereArray($groupIDArray, 'groupid');
            $whereArray[] = 'groupid IN ('.implode(',', $groupIDArray).')';*/

            // фильтр по менеджеру
            $managers = $this->getUsersManagers();
            $managerIDArray = array($userID); // свои видно всегда
            while ($m = $managers->getNext()) {
                if ($user->isAllowed('users-manager-'.$m->getId().'-view')) {
                    $managerIDArray[] = $m->getId();
                }
            }
            if ($user->isAllowed('users-manager-0-view')) {
                $managerIDArray[] = 0;
            }
            $whereArray[] = 'managerid IN ('.implode(',', $managerIDArray).')';

            $x->addWhereQuery("((employer=1) OR (".implode(' AND ', $whereArray)."))");
        }

        return $x;
    }

    /**
     * Добавить пользователя
     *
     * @param string $login
     * @param string $password
     * @param string $email
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param string $bdate
     * @param int $parentid
     * @param int $level
     * @param string $commentadmin
     * @param int $groupid
     * @param int $pricelevel
     * @param string $distribution
     * @param string $tags
     * @param string $namelast
     * @param string $namemiddle
     * @param string $typesex
     *
     * @return User
     */
    public function addUser($login, $password, $email, $name, $phone, $address, $bdate, $parentid,
    $level = false, $commentadmin = false, $groupid = false, $pricelevel = 0, $distribution = false,
    $tags = false, $namelast = false, $namemiddle = false, $typesex = false) {
        $selfRegister = false;
        try {
            $this->getUser();
        } catch (Exception $e) {
            $selfRegister = true;
        }
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

            $tags = $this->_checkTags($tags);

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
            $activate = Shop::Get()->getSettingsService()->getSettingValue('user-account-activate');

            $ex = new ServiceUtils_Exception();
            if ($login) {
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
            if ($selfRegister) {
                if (!$password) {
                    $ex->addError('easy-password');
                }
            } elseif ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
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

            // Разрешены ли дубликаты phone при создании контакта
            $allow_phone_doubl = Shop::Get()->getSettingsService()->getSettingValue('phone-doublicates');

            // поиск пользователя по email
            if ($email) {

                if (!Checker::CheckEmail($email)) {
                    $ex->addError('email');
                }

                try {
                    $this->findUserByContact($email, 'email');
                    $ex->addError('email-exists');
                } catch (Exception $userEx) {

                }

            } else if (!$email  && $password) {
                $ex->addError('email');
            }

            // поиск пользователя по телефону
            if ($phone) {
                try {
                    $this->findUserByContact($phone, 'call');
                    if (!$allow_phone_doubl) {
                        $ex->addError('phone-exists');
                    }
                } catch (Exception $userEx) {

                }
            }
            $checkname = Shop::Get()->getSettingsService()->getSettingValue('verifying-name');
            if (!empty($name) && !Checker::CheckWord($name) && $checkname) {
                $ex->addError('name');
            }
            if (!empty($namelast) && !Checker::CheckWord($namelast) && $checkname) {
                $ex->addError('name');
            }
            if (!empty($namemiddle) && !Checker::CheckWord($namemiddle) && $checkname) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user = new User();
            $user->setCdate(date('Y-m-d H:i:s'));
            $user->setEmail($email);
            if ($login) {
                $user->setLogin($login);
            }
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
            $user->setTypesex($typesex);

            // контрактор по умолчанию
            try {
                $user->setContractorid(Shop::Get()->getShopService()->getContractorDefault()->getId());
            } catch (Exception $contractorEx) {

            }

            if ($level) {
                $level = (int) $level;
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

            if (Shop::Get()->getSettingsService()->getSettingValue('manager-auto-author')) {
                try{
                    $user->setManagerid($this->getUser()->getId());
                } catch (Exception $euser) {

                }
            }

            $user->insert();

            // sendmail
            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-registration');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('header-email'));
                $sender->addEmail($email);
                $sender->assign('id', $user->getId());
                $sender->assign('login', $login);
                $sender->assign('password', $password);
                $sender->assign('signature', Shop::Get()->getSettingsService()->getSettingValue('letter-signature'));
                if (isset($random) && $activate && $level < 3) {
                    $sender->assign(
                        'activateURL',
                        Engine::Get()->getProjectURL() . Engine::GetLinkMaker()->makeURLByContentIDParams(
                            'shop-account-activate',
                            array('email' => $email, 'code' => $random)
                        )
                    );
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
     * Выслать новый пароль на почту
     *
     * @param string $login_email
     */
    public function remindPassword($login_email) {
        try {
            SQLObject::TransactionStart();

            $login_email = trim($login_email);

            try {
                $user = $this->getUserByLogin($login_email);
            } catch (Exception $e) {
                $user = $this->getUserByEmail($login_email);
            }

            PackageLoader::Get()->import('Randomer');
            $password = Randomer_Password::Random(6);
            $user->setPassword($this->createHash($password));
            $user->update();

            $tpl = Shop::Get()->getSettingsService()->getSettingValue('letter-remindpassword');
            if ($tpl) {
                $sender = MailUtils_SmartySender::CreateFromTemplateData($tpl);
                $sender->setTemplate(Shop::Get()->getShopService()->getMailTemplate());
                $sender->setEmailFrom(Shop::Get()->getSettingsService()->getSettingValue('reverse-email'));
                $sender->addEmail($user->getEmail());
                $sender->assign('login', $user->getLogin());
                $sender->assign('password', $password);
                $sender->assign('email', $user->getEmail());
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
     * Сгенерировать и выслать новый пароль на почту
     *
     * @param User $user
     */
    public  function generateUserPassword($user) {
        PackageLoader::Get()->import('Randomer');
        $random = Randomer_Password::Random(6, 9);
        $user->setPassword($this->createHash($random));
        $user->update();

        // sendmail

        $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
        $emailTo = $user->getEmail();
        $subject = 'Новый пароль';
        $text = '';
        $text .= "Здравствуйте, " .$user->getName() . ". \n";
        $text .= "Ваш доступ в систему ";
        $text .= '<a href='.Engine::Get()->getProjectURL().'>'.Engine::Get()->getProjectURL().'</a>' .": \n";
        if ($user->getLogin()) {
            $text .= "Ваш логин: " . $user->getLogin() ."\n";
        }
        $text .= "Ваш еmail: " .$user->getEmail() ."\n";
        $text .= "Ваш новый пароль: " .$random ."\n";
        $text .= "Спасибо.\n";

        $this->sendEmail(
            $emailFrom, $emailTo, $subject, $text, 'text', false,
            Shop::Get()->getShopService()->getMailTemplate()
        );
    }

    /**
     * Обновить картинку (логотип, аватар) контакта
     *
     * @param User $user
     * @param string $image
     */
    public function updateUserImage(User $user, $image) {
        if (!$image) {
            throw new ServiceUtils_Exception('image');
        }

        if (!Checker::CheckImageFormat($image)) {
            throw new ServiceUtils_Exception('image');
        }

        // конвертация изображения в необходимый формат
        // и допустимый размер
        $image = Shop::Get()->getShopService()->convertImage($image);

        $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
            $image,
            '/shop/'
        );

        copy($image, MEDIA_PATH.'shop/'.$file);

        $user->setImage($file);
        $user->update();
    }

    /**
     * Добавить телефон(ы) контакту
     *
     * @param User $user
     * @param $phone
     */
    public function addUserPhones(User $user, $phone) {
        $phones = $user->getPhoneArray();

        if (is_array($phone)) {
            $phones = array_merge($phones, $phone);
        } else {
            $phones[] = $phone;
        }

        $phones = array_unique($phones);

        if ($phones) {
            $user->setPhone(array_shift($phones));
            $user->setPhones(implode("\n", $phones));
            $user->update();
        }

    }

    /**
     * Обновить профайл юзера
     *
     * @param User $user
     * @param string $email
     * @param string $password
     * @param string $name
     * @param string $phone
     * @param string $address
     * @param string $bdate
     * @param string $phones
     * @param string $emails
     * @param string $urls
     * @param string $time
     * @param int $parentid
     * @param bool $check
     * @param string $commentadmin
     * @param int $managerid
     * @param array $groupArray
     * @param string $login
     * @param string $company
     * @param int $pricelevel
     * @param string $distribution
     * @param string $tags
     * @param string $cdate
     * @param string $namelast
     * @param string $namemiddle
     * @param string $post
     * @param string $typesex
     * @param string $skype
     * @param string $jabber
     * @param string $whatsapp
     * @param bool $employer
     * @param bool $allowreferal
     * @param int $discountid
     * @param int $sourceid
     * @param int $contractorid
     */
    public function updateUserProfile(User $user, $email, $password, $name, $phone, $address, $bdate,
    $phones, $emails, $urls, $time, $parentid, $check = true, $commentadmin = false, $managerid = false,
    $groupArray = false, $login = false, $company = false, $pricelevel = 0,
    $distribution = false, $tags = false, $cdate = false, $namelast=false, $namemiddle=false, $post=false,
    $typesex = false, $skype = false, $jabber = false, $whatsapp = false, $employer = false, $allowreferal = false,
    $discountid = false, $sourceid = false, $contractorid = false) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $name = trim($name);
            $email = trim($email);
            $address = trim($address);
            $bdate = trim($bdate);
            $phones = trim($phones);
            $phones = str_replace(",", "\n", $phones);
            $phones = str_replace(" ", '', $phones);
            $emails = trim($emails);
            $urls = trim($urls);
            $time = trim($time);
            $post = trim($post);
            $parentid = trim($parentid);
            $company = trim($company);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);
            $typesex = trim($typesex);

            $skype = trim($skype);
            $jabber = trim($jabber);
            $whatsapp = trim($whatsapp);

            $tags = $this->_checkTags($tags);

            $pricelevel = (int) $pricelevel;
            if ($pricelevel < 0) {
                $pricelevel = 0;
            }
            if ($pricelevel > 5) {
                $pricelevel = 5;
            }

            // из телефона убираем всякий мусор, оставляем только цифры
            $phone = preg_replace("/[^0-9]/ius", '', $phone);

            $isCompany = $typesex == 'company';

            $ex = new ServiceUtils_Exception();

            if (empty($phone) && empty($email) && empty($skype) && empty($jabber) && empty($whatsapp) && !$isCompany) {
                $ex->addError('nocontact');
            }

            if ($isCompany) { // проверка на уникальность компании
                try {
                    $samecompany = Shop::Get()->getShopService()->getCompanyByName($company);
                    if ( $samecompany && $samecompany->getId() != $user->getId() ) {
                        $ex->addError('notUnicCompany');
                    }
                } catch (Exception $exx) {

                }

            }

            // проверка на существование такой компании
            if (!$isCompany && $company) {
                $companyArray = explode(',', $company);

                foreach ($companyArray as $tmpCompanyName) {
                    $tmpCompanyName = trim($tmpCompanyName);

                    $tmp = $this->getUsersAll();
                    $tmp->setTypesex('company');
                    $tmp->setCompany($tmpCompanyName);
                    if (!$tmp->select()) {
                        $tmp->setCdate(date('Y-m-d H:i:s'));
                        try {
                            $cuser = $this->getUser();
                            $tmp->setAuthorid($cuser->getId());
                        } catch (Exception $authEx) {

                        }
                        $tmp->setDistribution(1);
                        $tmp->insert();
                    }
                }
            }

            if ( empty($name) && empty($company) && empty($namelast)) {
                $ex->addError('noname');
            }

            if ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
            }

            if ($check && !Checker::CheckEmail($email) || ($email && !Checker::CheckEmail($email))) {
                $ex->addError('email');
            } elseif ($email) {
                $tmp = $this->getUsersAll();
                $tmp->setEmail($email);
                if ($tmp->select() && $tmp->getId() != $user->getId() ) {
                    $ex->addError('email-exists');
                }
            }

            if (!empty($parentid)) {
                try {
                    !$this->getUserByID($parentid);
                } catch (Exception $e) {
                    $ex->addError('parentid');
                }
            }

            if (!empty($phone)) {
                if (!Checker::CheckPhone($phone)) {
                    $ex->addError('phone');
                }
            }

            if (!empty($bdate)) {
                $data_arr = explode('-', $bdate);
                if (!checkdate($data_arr[1], $data_arr[2], $data_arr[0])) {
                    $ex->addError('bdate');
                }
            }

            if (!empty($cdate)) {
                if (!Checker::CheckDate($cdate)) {
                    $ex->addError('cdate');
                }
            }

            if ($groupArray && !is_array($groupArray)) {
                $groupArray = array($groupArray);
            }

            /*if ($groupid) {
                try {
                    $group = $this->getUserGroupByID($groupid);
                } catch (Exception $e) {
                    $ex->addError('groupid');
                }
            }*/

            if ($login) {
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user_test = new User();
                    $user_test->setLogin($login);
                    if ($user_test->select() && $user->getId() != $user_test->getId()) {
                        $ex->addError('login-exists');
                    }
                }
            }
            $checkname = Shop::Get()->getSettingsService()->getSettingValue('verifying-name');
            if (!empty($name) && !Checker::CheckWord($name) && $checkname) {
                $ex->addError('name');
            }
            if (!empty($namelast) && !Checker::CheckWord($namelast) && $checkname) {
                $ex->addError('name');
            }
            if (!empty($namemiddle) && !Checker::CheckWord($namemiddle) && $checkname) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user->setEmail($email);
            $user->setName($name);
            $user->setNamelast($namelast);
            $user->setNamemiddle($namemiddle);
            $user->setAddress($address);
            $user->setPhone($phone);
            $user->setPhones($phones);
            $user->setEmails($emails);
            $user->setBdate($bdate);
            $user->setCdate($cdate);
            $user->setTime($time);
            if ($post) {
                $post = str_replace(', ', ',', $post);
                $post = str_replace(' ,', ',', $post);
                $user->setPost($post);
            } else {
                $user->setPost('');
            }
            //$user->setGroupid($groupid);
            $user->setPricelevel($pricelevel);
            $user->setDiscountid($discountid);
            $user->setTags($tags);
            $user->setUdate(date('Y-m-d H:i:s'));
            $user->setTypesex($typesex);
            if ($typesex == 'company' && $company) {
                $user->setName('');
                $user->setNamelast('');
                $user->setNamemiddle('');
            }
            $user->setSkype($skype);
            $user->setJabber($jabber);
            $user->setWhatsapp($whatsapp);

            if ($commentadmin) {
                $user->setCommentadmin($commentadmin);
            }

            $user->setParentid($parentid);
            $user->setCompany($company);

            $user->setUrls($urls);
            if ($password && Checker::CheckPassword($password)) {
                $user->setPassword($this->createHash($password));
            }
            if ($managerid !== false) {
                $managerid = (int) $managerid;
                $user->setManagerid($managerid);
            }

            if ($login) {
                $user->setLogin($login);
            }


            if ($distribution) {
                $user->setDistribution(1);
            } else {
                $user->setDistribution(0);
            }

            if ($employer) {
                $user->setEmployer(1);
            } else {
                $user->setEmployer(0);
            }

            if ($sourceid) {
                $user->setSourceid($sourceid);
            }

            if ($contractorid) {
                $user->setContractorid($contractorid);
            }

            $user->setAllowreferal($allowreferal);

            $user->update();

            // убираем все группы которых нет в массиве
            $links = new XShopUser2Group();
            $links->filterUserid($user->getId());
            if ($groupArray) {
                $links->addWhereQuery("id NOT IN (".implode(',', $groupArray).")");
            }
            $links->delete(true);

            // добавляем группы
            foreach ($groupArray as $groupID) {
                $links = new XShopUser2Group();
                $links->setUserid($user->getId());
                $links->setGroupid($groupID);
                if (!$links->select()) {
                    $links->insert();
                }
            }

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить пользователя в группу
     *
     * @param User $user
     * @param ShopUserGroup $group
     */
    public function addUserToGroup(User $user, ShopUserGroup $group) {
        try {
            SQLObject::TransactionStart();

            $link = new XShopUser2Group();
            $link->setUserid($user->getId());
            $link->setGroupid($group->getId());
            if (!$link->select()) {
                $link->insert();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить пользователя из группы
     *
     * @param User $user
     * @param ShopUserGroup $group
     */
    public function removeUserFromGroup(User $user, ShopUserGroup $group) {
        try {
            SQLObject::TransactionStart();

            $link = new XShopUser2Group();
            $link->setUserid($user->getId());
            $link->setGroupid($group->getId());
            $link->delete(true);

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить логин/пароль
     *
     * @param User $user
     * @param string $login
     * @param string $password
     */
    public function updateUserAuth(User $user, $login, $password = false) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $ex = new ServiceUtils_Exception();
            if ($password && !Checker::CheckPassword($password)) {
                $ex->addError('password');
            }

            if ($login) {
                if (!Checker::CheckLogin($login)) {
                    $ex->addError('login');
                } else {
                    $user_test = new User();
                    $user_test->setLogin($login);
                    if ($user_test->select() && $user->getId() != $user_test->getId()) {
                        $ex->addError('login-exists');
                    }
                }
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            $user->setLogin($login);
            if ($password) {
                $user->setPassword($this->createHash($password));
            }

            $user->setUdate(date('Y-m-d H:i:s'));
            $user->update();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить разрешенный IP
     *
     * @param User $user
     * @param string $ip
     */
    public function updateUserControlIP(User $user, $ip) {
        try {
            SQLObject::TransactionStart();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditBefore');
            $event->setUser($user);
            $event->notify();

            $user->setControlip($ip);
            $user->update();

            // fire event
            $event = Events::Get()->generateEvent('shopUserEditAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить способы уведомлений пользователя
     *
     * @param User $user
     * @param bool $notify_email_one
     * @param bool $notify_email_group
     * @param bool $notify_sms
     *
     * @deprecated
     */
    public function updateUserNotifications(User $user, $notify_email_one,
    $notify_email_group, $notify_sms) {
        Shop::Get()->getNotificationService()->updateUserNotifications(
            $user,
            $notify_email_one,
            $notify_email_group,
            $notify_sms
        );
    }

    /**
     * Обновить ACL
     *
     * @param User $user
     * @param int $level
     * @param array $aclArray
     * @param string $edate
     *
     * @deprecated
     * @see        ACLService
     */
    public function updateUserACL(User $user, $level, $aclArray, $edate = false) {
        return Shop::Get()->getAclService()->updateUserACL($user, $level, $aclArray, $edate);
    }

    /**
     * Получить список прав юзера в виде 2D-assoc массива
     *
     * @param User $user
     *
     * @return array
     *
     * @deprecated
     * @see        ACLService
     */
    public function getUserACLArray(User $user) {
        return Shop::Get()->getAclService()->getUserACLArray($user);
    }

    /**
     * Получить список прав доступа.
     * Метод вернет 2D-массив
     *
     * @deprecated
     *
     * @see ACLService
     *
     * @return array
     */
    public function getACLPermissions() {
        return Shop::Get()->getAclService()->getACLPermissions();
    }

    /**
     * Зарегистрировать ACL-permission.
     * Метод используется модулями для регистрации своих ACL.
     *
     * @param string $key
     * @param string $name
     *
     * @deprecated
     *
     * @see ACLService
     */
    public function addACLPermission($key, $name) {
        Shop::Get()->getAclService()->addACLPermission($key, $name);
    }

    /**
     * Зарегистрировать пользователя-клиента.
     *
     * @param string $clientName
     * @param string $namelast
     * @param string $namemiddle
     * @param string $typesex
     * @param string $company
     * @param string $post
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $commentAdmin
     * @param string $login
     * @param string $password
     *
     * @return User
     *
     * @deprecated
     *
     * @uses 5+
     */
    public function addUserClient(
        $clientName, $namelast = false, $namemiddle = false, $typesex = false,
        $company = false, $post = false, $email = false, $phone = false,
        $address = false, $commentAdmin = false, $login = false, $password = false,
        $action = 'writing'
    ) {
        return $this->addClient(
            $clientName, $namelast, $namemiddle, $typesex, $company, $post, $email,
            $phone, $address, $commentAdmin, $login, $password, $action
        );
    }

    /**
     * Зарегистрировать пользователя-клиента.
     * Если action - exception, выдавать ошибку если есть дубликат по емейл или тел
     * Если action - writing, дописывать значения
     *
     * @param string $clientName
     * @param string $namelast
     * @param string $namemiddle
     * @param string $typesex
     * @param string $company
     * @param string $post
     * @param string $email
     * @param string $phone
     * @param string $address
     * @param string $commentAdmin
     * @param string $login
     * @param string $password
     * @param string $action
     *
     * @return User
     *
     * @uses 5+
     */
    public function addClient(
        $clientName, $namelast = false, $namemiddle = false, $typesex = false,
        $company = false, $post = false, $email = false, $phone = false,
        $address = false, $commentAdmin = false, $login = false, $password = false, $action = 'writing'
    ) {
        try {
            SQLObject::TransactionStart();

            $clientName = trim($clientName);
            $namelast = trim($namelast);
            $namemiddle = trim($namemiddle);
            $login = trim($login);
            $email = trim($email);
            $phone = trim($phone);
            $address = trim($address);
            $company = trim($company);
            $post = trim($post);
            $commentAdmin = trim($commentAdmin);

            $ex = new ServiceUtils_Exception();

            $phoneArray = array();
            if ($phone) {
                $tmp = explode("\n", $phone);
                foreach ($tmp as $x) {
                    // из телефона убираем всякий мусор, оставляем только цифры
                    $x = preg_replace("/[^0-9]/ius", '', $x);
                    if (Checker::CheckPhone($x)) {
                        $phoneArray[] = $x;
                    } else {
                        $ex->addError('phone');
                    }
                }
            }

            $phoneArrayFull = $phoneArray;

            if ($phoneArray) {
                $a = array();
                foreach ($phoneArray as $key => $p) {
                    $p = trim($p);
                    if (strlen($p) >= 10) {
                        $p = substr($p, -10);
                    }
                    if (!in_array($p, $a)) {
                        $a[$key] = trim($p);
                    } else {
                        unset($phoneArray[$key]);
                    }
                }
                $phone = $phoneArray[0];
                unset($phoneArray[0]);
            }
            $phones = implode("\n", $phoneArray);

            $emailArray = array();
            if ($email) {
                $tmp = explode("\n", $email);
                foreach ($tmp as $x) {
                    // из телефона убираем всякий мусор, оставляем только цифры
                    if (Checker::CheckEmail($x)) {
                        $emailArray[] = $x;
                    } else {
                        $ex->addError('email');
                    }
                }
            }

            $emailArrayFull = $emailArray;

            if ($emailArray) {
                $email = $emailArray[0];
                unset($emailArray[0]);
            }
            $emails = implode("\n", $emailArray);

            // Разрешены ли дубликаты phone при создании контакта
            $allow_phone_doubl = Shop::Get()->getSettingsService()->getSettingValue('phone-doublicates');

            /* в задаче #35282 описаны критерии поиска */

            $findUserByContact = Shop::Get()->getSettingsService()->getSettingValue('find-user-by-contact');
            // поиск пользователя по email
            $user = false;

            if ($findUserByContact) {
                if ($email) {
                    try {
                        $user = $this->findUserByContact($email, 'email');
                    } catch (Exception $userEx) {

                    }
                }

                if (!$user && $phone && !$allow_phone_doubl) {
                    try {
                        $user = $this->findUserByContact($phone, 'call');
                    } catch (Exception $userEx) {

                    }
                }
            }

            $isCompany = ($typesex == 'company');

            // проверка компании на уникальность
            if ($isCompany) {
                try {
                    Shop::Get()->getShopService()->getCompanyByName($company);
                    $ex->addError('notUnicCompany');
                } catch (Exception $e) {

                }
            }

            if (!$clientName && !$namelast && !$namemiddle && !$company) {
                $ex->addError('name');
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            if ($user && $action == 'exception') {
                // выдавать ошибку если есть дубликат по емейл или тел
                $ex->addError('duplicate');
                throw $ex;
            } elseif ($user && (!$action || $action == 'writing')) {
                // обновляем данные пользователя
                if ($clientName && !$user->getName()) {
                    $user->setName($clientName);
                }
                if ($namelast && !$user->getNamelast()) {
                    $user->setNamelast(trim($namelast));
                }
                if ($namemiddle && !$user->getNamemiddle()) {
                    $user->setNamemiddle($namemiddle);
                }
                if ($phoneArrayFull) {
                    // дополняем телефоны
                    $tmp = $user->getPhoneArray();
                    $tmp = array_merge($tmp, $phoneArrayFull);
                    $tmp = array_unique($tmp);

                    $user->setPhone(@$tmp[0]);
                    unset($tmp[0]);
                    $user->setPhones(implode("\n", $tmp));
                }

                if ($emailArrayFull && !$user->getEmail()) {
                    // дополняем емейлы
                    $tmp = $user->getEmailArray();
                    $tmp = array_merge($tmp, $emailArrayFull);
                    $tmp = array_unique($tmp);

                    $user->setEmail(@$tmp[0]);
                    unset($tmp[0]);
                    $user->setEmails(implode("\n", $tmp));
                }

                if ($address && !$user->getAddress()) {
                    $user->setAddress($address);
                }
                if ($commentAdmin && !$user->getCommentadmin()) {
                    $user->setCommentadmin($commentAdmin);
                }
                if ($company && !$user->getCompany()) {
                    $user->setCompany($company);
                }
                if ($post && !$user->getPost()) {
                    $user->setPost($post);
                }

                if ($typesex && !$user->getTypesex()) {
                    $user->setTypesex($typesex);
                }

                if ($typesex == 'company' && $company) {
                    $user->setName('');
                    $user->setNamelast('');
                    $user->setNamemiddle('');
                }

                $user->setUdate(date('Y-m-d H:i:s'));
                $user->update();
            } else {
                // добавлять без проверки
                // пользователя нужно создавать нового
                if (!($login || $email)) { // если нет логина или мыла создаём логин
                    if (!empty($phone)) {
                        $login = $phone;
                    } elseif (!empty($skype)) {
                        $login = $skype;
                    } elseif (!empty($jabber)) {
                        $login = $jabber;
                    } elseif (!empty($whatsapp)) {
                        $login = $whatsapp;
                    }
                }

                $user = new User();
                $user->setName($clientName);
                $user->setPhone($phone);
                $user->setPhones($phones);
                $user->setEmail($email);
                $user->setEmails($emails);
                $user->setAddress($address);
                $user->setCommentadmin($commentAdmin);
                $user->setCompany($company);
                $user->setPost($post);
                $user->setLevel(1);
                $user->setDistribution(1);
                // данные для авторизации
                if ($login) {
                    $user->setLogin($login);
                }

                if ($namelast) {
                    $user->setNamelast(trim($namelast));
                }
                if ($namemiddle) {
                    $user->setNamemiddle($namemiddle);
                }
                if ($typesex) {
                    $user->setTypesex($typesex);
                } else {
                    //для пользователей что не указали свой пол
                    $user->setTypesex('man');
                }

                // пароль всегда
                if (!$password) {
                    PackageLoader::Get()->import('Randomer');
                    $password = Randomer_Password::Random(6, 9);
                }
                $user->setPassword($this->createHash($password));

                // дата создания
                $user->setCdate(date('Y-m-d H:i:s'));

                // контрактор по умолчанию
                try {
                    $user->setContractorid(Shop::Get()->getShopService()->getContractorDefault()->getId());
                } catch (Exception $contractorEx) {

                }

                // отправляем письмо на почту юзеру,
                // только если это само-регистрация
                $selfRegister = false;
                try {
                    $this->getUser();
                } catch (Exception $e) {
                    $selfRegister = true;
                }

                if ($selfRegister && $user->getEmail()) {
                    $emailFrom = Shop::Get()->getSettingsService()->getSettingValue('reverse-email');
                    $emailTo = $user->getEmail();
                    $subject = 'Авторегистрация';
                    $text = '';
                    $text .= "Здравствуйте, ".$user->makeName(true, 'lfm')."! <br />";
                    $text .= "Вы успешно зарегистрированы на ";
                    $text .= '<a href='.Engine::Get()->getProjectURL().'>'.Engine::Get()->getProjectURL().'</a>';
                    $text .= ": <br />";
                    $text .= "Ваш доступ: <br />";
                    $text .= "<br />";
                    if ($user->getLogin()) {
                        $text .= "Логин: ".$user->getLogin()."<br />";
                    }
                    $text .= "Email: ".$user->getEmail()."<br />";
                    $text .= "Пароль: ".$password."<br />";
                    $text .="<br />";
                    $text .= "Спасибо. <br />";

                    try{
                        // отправка письма
                        $this->sendEmail(
                            $emailFrom, $emailTo, $subject, $text,
                            'text', false,
                            Shop::Get()->getShopService()->getMailTemplate()
                        );
                    } catch (Exception $eem) {

                    }

                }

                if ($typesex == 'company' && $company) {
                    $user->setName('');
                    $user->setNamelast('');
                    $user->setNamemiddle('');
                }

                if (Shop::Get()->getSettingsService()->getSettingValue('manager-auto-author')) {
                    try {
                        $user->setManagerid($this->getUser()->getId());
                    } catch (Exception $emanager) {

                    }
                }

                $user->setUdate(date('Y-m-d H:i:s'));
                $user->insert();
            }

            // проверка на существования такой компании
            if (!$isCompany && $company && $typesex) {
                $companyArray = explode(',', $company);

                foreach ($companyArray as $tmpCompanyName) {
                    $tmpCompanyName = trim($tmpCompanyName);

                    $tmp = $this->getUsersAll();
                    $tmp->setTypesex('company');
                    $tmp->setCompany($tmpCompanyName);
                    if (!$tmp->select()) {
                        $tmp->setCdate(date('Y-m-d H:i:s'));
                        try {
                            $cuser = $this->getUser();
                            $tmp->setAuthorid($cuser->getId());
                        } catch (Exception $authEx) {

                        }
                        $tmp->insert();
                    }
                }
            }

            try {
                $userDo = $this->getUser();

                CommentsAPI::Get()->addComment(
                    'shop-history-user-add'.$user->getId(),
                    Shop::Get()->getTranslateService()->getTranslateSecure('translated_adeded_user').
                    ' #'.$user->getId().' '.$user->makeName(),
                    $userDo->getId()
                );
            } catch (Exception $e) {

            }

            // fire event
            $event = Events::Get()->generateEvent('shopUserAddAfter');
            $event->setUser($user);
            $event->notify();

            SQLObject::TransactionCommit();

            // возвращаем пользователя
            return $user;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить список всех контактов, который работаю, в определенный день
     * Если день не передан, берется текущее время
     *
     * @param bool $date
     *
     * @return User
     *
     * @throws Exception
     * @throws SQLObject_Exception
     */
    public function getUsersWorkingByDate ($date = false) {
        if (!$date) {
            $date = DateTime_Object::Now()->setFormat('Y-m-d h:m:s');
        } else {
            $date = DateTime_Object::FromString($date)->setFormat('Y-m-d h:m:s');

        }

        $dateLast = DateTime_Object::FromString($date)->setFormat('Y-m-d 23:59:59');

        $workTime = new XShopUserWorkTime();
        $workTime->addWhere('cdate', $date, '>');
        $workTime->addWhere('cdate', $dateLast, '<');

        $usersIdArray = array();
        while ($workTimeTmp = $workTime->getNext()) {
            $usersIdArray[] = $workTimeTmp->getUserid();
        }

        if ($usersIdArray) {
            $users = Shop::Get()->getUserService()->getUsersAll();
            $users->addWhereArray($usersIdArray);
            return $users;
        } else {
            throw new Exception;
        }
    }

    /**
     * Поиск пользователей и клиентов
     *
     * @param string $query
     * @param User $cuser
     *
     * @return User
     */
    public function searchUsers($query, $cuser = false) {
        $query = trim($query);
        if (strlen($query) < 3) {
            throw new ServiceUtils_Exception();
        }

        $users = $this->getUsersAll($cuser);
        $connection = $users->getConnectionDatabase();

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

            $w[] = "id ='$part'";
            $w[] = "name LIKE '%$part%'";
            $w[] = "namelast LIKE '%$part%'";
            $w[] = "namemiddle LIKE '%$part%'";
            $w[] = "login LIKE '%$part%'";
            $w[] = "email LIKE '%$part%'";
            $w[] = "emails LIKE '%$part%'";
            $w[] = "phone LIKE '%$part%'";
            $w[] = "phones LIKE '%$part%'";
            $w[] = "address LIKE '%$part%'";
            $w[] = "company LIKE '%$part%'";
            $w[] = "post LIKE '%$part%'";
            $w[] = "commentadmin LIKE '%$part%'";
            $w[] = "skype LIKE '%$part%'";
            $w[] = "whatsapp LIKE '%$part%'";
            $w[] = "jabber LIKE '%$part%'";


            // превращаем в en транскрипцию
            try {
                $partTr = StringUtils_Transliterate::TransliterateRuToEn($part);

                $partTr = $connection->escapeString($partTr);

                $w[] = "name LIKE '%$partTr%'";
            } catch (Exception $e) {

            }

            // превращаем ru
            try {
                $partRu = StringUtils_Transliterate::TransliterateCorrectTo('ru', $part);

                $partRu = $connection->escapeString($partRu);

                $w[] = "name LIKE '%$partRu%'";
            } catch (Exception $e) {

            }

            // превращаем en
            try {
                $partEn = StringUtils_Transliterate::TransliterateCorrectTo('en', $part);

                $partEn = $connection->escapeString($partEn);

                $w[] = "name LIKE '%$partEn%'";
            } catch (Exception $e) {

            }

            $users->addWhereQuery("(" . implode(' OR ', $w) . ")");
        }

        return $users;
    }

    /**
     * Поиск должностей
     * (для автокомплита)
     *
     * @param string $post
     *
     * @return array
     */
    public function searchPosts($post) {
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        $post = $connection->escapeString($post);
        $post = str_replace(' ', '%', $post);

        $result = array();

        if (class_exists('RoleService')) {
            $roles = RoleService::Get()->getRoleAll();
            $roles->addWhere('name', '%'.$post.'%', 'LIKE');
            while ($role = $roles->getNext()) {
                $result[$role->getName()] = $role->getName();
            }
        }

        $sql = "SELECT DISTINCT `post` FROM `users` WHERE `post` LIKE '%$post%' LIMIT 20";
        $q = $connection->query($sql);
        while ($x = $connection->fetch($q)) {
            $postArray = explode(',', $x['post']);
            foreach ($postArray as $p) {
                $p = trim($p);
                $result[$p] = $p;
            }
        }

        return $result;

    }

    /**
     * Получить группу пользователей по id
     *
     * @param int $id
     *
     * @return ShopUserGroup
     */
    public function getUserGroupByID($id) {
        return $this->getObjectByID($id, 'ShopUserGroup');
    }

    /**
     * Получить группу пользователей по имени группы
     *
     * @param string $name
     *
     * @return ShopUserGroup
     */
    public function getUserGroupByName($name) {
        return $this->getObjectByField('name', $name, 'ShopUserGroup');
    }

    /**
     * Получить все группы пользователей
     *
     * @return ShopUserGroup
     */
    public function getUserGroupsAll() {
        $x = new ShopUserGroup();
        $x->setOrder(array('sort', 'name'), 'ASC');
        return $x;
    }

    /**
     * Получить пользователей по группе
     *
     * @param ShopUserGroup $group
     * @param User $user
     *
     * @return User
     */
    public function getUsersByGroup(ShopUserGroup $group, $user = false) {
        $users = $this->getUsersAll($user);

        // проверяем есть ли у группы родители
        $a = array($group->getId());
        $tmp = $this->makeUserGroupTree($group->getId());
        foreach ($tmp as $x) {
            $a[] = $x->getId();
        }

        $u2g = new XShopUser2Group();

        $users->innerJoinTable($u2g->getTablename(), $u2g->getTablename().'.userid='.$users->getTablename().'.id');
        $users->addWhereQuery($u2g->getTablename().'.groupid IN ('.implode(',', $a).')');
        $users->setGroupByQuery($users->getTablename().'.id');

        return $users;
    }

    /**
     * Получить всех пользователей по ролям
     *
     * @param string $roleName
     *
     * @return User
     */
    public function getUsersByRole($roleName) {
        return RoleService::Get()->getUsersByRole($roleName);
    }

    /**
     * Получить массив групп пользователей
     *
     * @todo remove this method (deprecate)
     *
     * @deprecated
     *
     * @return array
     */
    public function getUsersGroups() {
        $groups = $this->getUserGroupsAll();
        $groupsArray = array();
        while ($group = $groups->getNext()) {
            $groupsArray[] = array(
                'id' => $group->getId(),
                'name' => $group->getName(),
                'url' => Engine::Get()->GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-users',
                    $group->getId(),
                    'groupid'
                )
            );
        }
        return $groupsArray;
    }

    /**
     * Разрешено ли пользователю видеть пользователя
     *
     * @param User $user
     * @param User $cuser
     *
     * @return bool
     */
    public function isUserViewAllowed(User $user, User $cuser) {
        if ($cuser->isDenied('users')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users'
                ),
                'acl'
            );

            return false;
        }

        // фильтр по уровню
        if ($cuser->isDenied('users-level-'.$user->getLevel().'-view')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-level-'.$user->getLevel().'-view');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-level-'.$user->getLevel().'-view'
                ),
                'acl'
            );

            return false;
        }

        if ($cuser->isAllowed('users-all-view')) {
            return true;
        }

        // своих юзеров и себя видно всегда
        if ($cuser->getId() == $user->getId()) {
            return true;
        }

        // тех у кого я менеджер - видно всегда
        if ($cuser->getId() == $user->getManagerid()) {
            return true;
        }

        // тех кого я создал - видно всегда
        if ($cuser->getId() == $user->getAuthorid()) {
            return true;
        }

        // фильтр по группе
        if ($cuser->isDenied('users-group-'.$user->getGroupid().'-view')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-group-'.$user->getGroupid().'-view');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-group-'.$user->getGroupid().'-view'
                ),
                'acl'
            );

            return false;
        }

        // фильтр по менеджеру
        if ($cuser->isDenied('users-manager-'.$user->getManagerid().'-view')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-manager-'.$user->getManagerid().'-view');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-manager-'.$user->getManagerid().'-view'
                ),
                'acl'
            );

            return false;
        }

        return true;
    }

    /**
     * Разрешено ли пользователю редактировать пользователя
     *
     * @param User $user
     * @param User $cuser
     *
     * @return bool
     */
    public function isUserChangeAllowed(User $user, User $cuser) {
        if ($cuser->isDenied('users')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users'
                ),
                'acl'
            );

            return false;
        }

        // фильтр по уровню
        if ($cuser->isDenied('users-level-'.$user->getLevel().'-change')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-level-'.$user->getLevel().'-change');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-level-'.$user->getLevel().'-change'
                ),
                'acl'
            );

            return false;
        }

        if ($cuser->isAllowed('users-all-edit')) {
            return true;
        }

        /*if ($cuser->getId() == $user->getId()) {
        return true;
        }*/

        /*if ($cuser->getId() == $user->getManagerid()) {
        return true;
        }*/

        // фильтр по группе
        if ($cuser->isDenied('users-group-'.$user->getGroupid().'-change')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-group-'.$user->getGroupid().'-change');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-group-'.$user->getGroupid().'-change'
                ),
                'acl'
            );

            return false;
        }

        // фильтр по менеджеру
        if ($cuser->isDenied('users-manager-'.$user->getManagerid().'-change')) {
            $aclName = Shop::Get()->getAclService()->getNameByKey('users-manager-'.$user->getManagerid().'-change');
            LogService::Get()->add(
                array(
                    'url' => Engine_URLParser::Get()->getCurrentURL(),
                    'user #'.$user->getId(),
                    'Acl: '.$aclName.' - users-manager-'.$user->getManagerid().'-change'
                ),
                'acl'
            );

            return false;
        }

        return true;
    }

    /**
     * Скопировать рабочий график пользователей с предидущей недели
     */
    public function workTimeUsers() {
        ModeService::Get()->verbose("Process time of users...");

        try {
            $workTimeUser = new XShopUserWorkTime();
            $workTimeUser->setGroupByQuery('userid');
            for ($i = 1; $i <= 7; $i++) {
                while ($currentWork = $workTimeUser->getNext()) {
                    $workTime = new XShopUserWorkTime();
                    $nextDay = DateTime_Formatter::DateISO9075(DateTime_Object::Now()->addDay(+$i));
                    $workTime->addWhere('cdate', $nextDay, '>=');
                    $workTime->addWhere('cdate', $nextDay . ' 23:59:59', '<=');
                    $workTime->setUserid($currentWork->getUserid());
                    $workTime->setLimitCount(1);
                    $workTime = $workTime->getNext();

                    if ($workTime) {
                        continue;
                    } else {
                        $prevDate = DateTime_Formatter::DateISO9075(DateTime_Object::Now()->addDay(-7 + $i));
                        $workTimeOld = new XShopUserWorkTime();
                        $workTimeOld->addWhere('cdate', $prevDate, '>=');
                        $workTimeOld->addWhere('cdate', $prevDate . ' 23:59:59', '<=');
                        $workTimeOld->setUserid($currentWork->getUserid());

                        while ($wOld = $workTimeOld->getNext()) {
                            $oldTime = $wOld->getCdate();
                            $oldTime = explode(' ', $oldTime);
                            $worktimeNew = new XShopUserWorkTime();
                            $worktimeNew->setUserid($wOld->getUserid());
                            $worktimeNew->setCdate($nextDay . " " . $oldTime[1]);
                            $worktimeNew->insert();
                        }
                    }
                }
            }
        } catch (Exception $e) {

        }
    }

    /**
     * Объединить пользователей в одного
     *
     * @param array $userIDArray
     */
    public function mergeUsers($userIDArray) {
        try {
            SQLObject::TransactionStart();
            $userArray = array();
            $tuser = false;

            foreach ($userIDArray as $id) {
                try {
                    $user = $this->getUserByID($id);

                    /*if ($user->getAdate() && $user->getAdate() != '0000-00-00 00:00:00') {
                        // можно допустить только одного пользователя,
                        // который авторизировался в системе
                        if ($tuser) {
                            throw new ServiceUtils_Exception('access');
                        } else {
                            $tuser = clone $user;
                        }
                    }*/

                    $a = $user->getValues();

                    foreach ($a as $k => $v) {
                        $userArray[$k][$user->getId()] = $v;
                    }
                } catch (ServiceUtils_Exception $se) {
                    if (!$se->getErrorsArray()) {
                        throw new ServiceUtils_Exception('notfound');
                    } else {
                        throw $se;
                    }
                }
            }

            if (!$tuser && isset($user)) {
                $tuser = clone $user;
            }

            if ($tuser) {
                $email = '';
                $phone = '';

                foreach ($userArray as $field => $valueArray) {
                    if ($field == 'id') {
                        continue;
                    }

                    // минимальное значение
                    if ($field == 'cdate') {
                        $min = '';
                        foreach ($valueArray as $value) {
                            if (($value < $min || !$min) && $value != '0000-00-00 00:00:00') {
                                $min = $value;
                            }
                        }

                        $tuser->setCdate($min);

                    } elseif (in_array($field, array('bdate', 'edate', 'level'))) {
                        // максимальное значение

                        $max = '';
                        foreach ($valueArray as $value) {
                            if (($value > $max || !$max) && $value != '0000-00-00 00:00:00') {
                                $max = $value;
                            }
                        }

                        $tuser->setField($field, $max);

                    } elseif ($field == 'email') {

                        $set = false;
                        foreach ($valueArray as $value) {
                            if (Checker::CheckEmail($value) && !$set) {
                                $tuser->setEmail($value);
                                $set = true;
                            } else {
                                $email .= $value.', ';
                            }
                        }

                    } elseif ($field == 'phone') {
                        $set = false;
                        foreach ($valueArray as $value) {
                            if (Checker::CheckPhone($value) && !$set) {
                                $tuser->setPhone($value);
                                $set = true;
                            } else {
                                $phone .= $value.', ';
                            }
                        }

                    } elseif (in_array($field, array('emails', 'phones', 'address'))) {
                        $x = '';
                        foreach ($valueArray as $value) {
                            if (trim($value)) {
                                $x .= $value.', ';
                            }
                        }

                        if ($field == 'emails') {
                            $x .= $email;
                        }

                        if ($field == 'phones') {
                            $x .= $phone;
                        }

                        $tuser->setField($field, $x);

                    } else {
                        foreach ($valueArray as $value) {
                            if (trim($value)) {
                                $tuser->setField($field, $value);
                            }
                        }
                    }
                }

                $tuser->update();

                foreach ($userIDArray as $id) {
                    try {
                        $user2 = $this->getUserByID($id);

                        if ($user2->getId() != $tuser->getId()) {
                            $orders = Shop::Get()->getShopService()->getOrdersAll();
                            $orders->setUserid($user2->getId());
                            while ($order = $orders->getNext()) {
                                $order->setUserid($tuser->getId());
                                $order->update();
                            }
                        }

                        if ($user2->getId() != $tuser->getId() && Shop_ModuleLoader::Get()->isImported('finance')) {
                            $payments = PaymentService::Get()->getPaymentsAll();
                            $payments->setClientid($user2->getId());
                            while ($payment = $payments->getNext()) {
                                $payment->setClientid($tuser->getId());
                                $payment->update();
                            }

                            $invoices = InvoiceService::Get()->getInvoicesAll();
                            $invoices->setClientid($user2->getId());
                            while ($invoice = $invoices->getNext()) {
                                $invoice->setClientid($tuser->getId());
                                $invoice->update();
                            }
                        }

                        if ($user2->getId() != $tuser->getId()) {
                            $user2->delete();
                        }

                    } catch (ServiceUtils_Exception $se) {

                    }
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Выслать письмо пользователю на почту
     * с сохранением в ShopEvent (только в режиме OneBox).
     *
     * Отправка всех емейлов в системе делается только через этот метод.
     *
     * Письмо отправляется в HTML-формате, поэтому переменную $content
     * передавайте в HTML-формате с тегами <br>.
     *
     * Параметр $sendDate определяет стартовую дату, когда нужно отправить письмо.
     *
     * Параметр $user нужен чтобы добавить к письму подпись, если это потребуется.
     * Параметр $user так же добавляет в email-from имя отправителя "кто шлет письмо", например,
     * Max M <max@webproduction.ua>
     *
     * Параметр $wrap отвечает за то, в какой шаблон завернуть письмо. Нужно указать путь к HTML-шаблону.
     *
     * Параметр $html отвечает за то, какое письмо отправлять: HTML или TXT.
     *
     * Параметр $boxSignature разрешает дописывать подпись OneBox, если она конечно не запрещена
     * глобально.
     *
     * @param $emailFrom
     * @param $emailTo
     * @param $subject
     * @param $content
     * @param string $bodyType
     * @param bool $fileArray
     * @param bool $template
     * @param bool $signatureUser
     * @param bool $sendDate
     * @param bool $boxSignature
     * @param bool $signatureText
     *
     * @throws Exception
     */
    public function sendEmail($emailFrom, $emailTo, $subject, $content, $bodyType  = 'text', $fileArray = false,
        $template = false, $signatureUser = false, $sendDate = false, $boxSignature = true, $signatureText = false
    ) {
        try {
            SQLObject::TransactionStart();

            $signatureBoxDefault =
                "Отправлено через OneBox - систему управления бизнесом, ".''.
                "больше чем crm и erp. http://webproduction.ua/onebox";

            $subject = trim($subject);
            $content = trim($content);
            $emailFrom = trim($emailFrom);
            if (!is_array($emailTo)) {
                $emailTo = trim($emailTo);
                $emailTo = array($emailTo);
            }

            if (!$fileArray) {
                $fileArray = array();
            }

            if (!$emailTo) {
                throw new ServiceUtils_Exception();
            }
            if (!Checker::CheckEmail($emailFrom)) {
                throw new ServiceUtils_Exception();
            }
            if (!$subject && !$content) {
                throw new ServiceUtils_Exception();
            }

            if (!Checker::CheckDate($sendDate)) {
                $sendDate = false;
            }

            // если в параметр template передат четкий true - то берем шаблон по умолчанию
            if ($template === true) {
                $template = Shop::Get()->getShopService()->getMailTemplate();
            }

            if ($template) {
                if ($bodyType == 'text') {
                    $content = nl2br($content);
                }
                $bodyType = 'html';
            }

            if ($signatureUser) {
                $signature = Shop::Get()->getSettingsService()->getSettingValue('box-email-signature');

                // ставим название компании исходя из настроек box'a
                $companyName = Shop::Get()->getSettingsService()->getSettingValue('shop-company');
                $signature = str_replace('[company]', $companyName, $signature);

                // пытаемся поставить ФИО отправителя
                $signature = str_replace('[name]', $signatureUser->makeName(true, 'lfm'), $signature);
                $signature = str_replace('[name_first]', $signatureUser->getName(), $signature);
                $signature = str_replace('[name_middle]', $signatureUser->getNamemiddle(), $signature);
                $signature = str_replace('[name_last]', $signatureUser->getNamelast(), $signature);

                if ($bodyType == 'html') {
                    $signature = nl2br($signature);
                    if ($signature) {
                        $content .= "<br><br>";
                        $content .= $signature;
                        $content .= "<br><br>";
                    }
                } else {
                    $signature = strip_tags($signature);
                    if ($signature) {
                        $content .= "\n\n";
                        $content .= $signature;
                        $content .= "\n\n";
                    }
                }
            }

            if ($boxSignature && Shop::Get()->getSettingsService()->getSettingValue('box-slogan-email-signature')) {
                if ($bodyType == 'html') {
                    $signatureBoxDefault = nl2br($signatureBoxDefault);
                    if ($signatureBoxDefault) {
                        if (!$signatureUser) {
                            $content .= "<br><br>";
                        }
                        $content .= $signatureBoxDefault;
                        $content .= "<br><br>";
                    }
                } else {
                    $signatureBoxDefault = strip_tags($signatureBoxDefault);
                    if ($signatureBoxDefault) {
                        if (!$signatureUser) {
                            $content .= "\n\n";
                        }
                        $content .= $signatureBoxDefault;
                        $content .= "\n\n";
                    }
                }
            }

            $contentForEvent = $content;
            if ($template) {
                $content = str_replace('[content]', $content, $template);
            }

            /*if ($bodyType = 'text') {
                $content = trim(strip_tags($content));
                // убираем title и пробелы после strip_tags
                if (strpos($content, 'Mail') === 0) {
                    $content = trim(substr_replace($content, '', 0, strlen('Mail')));
                    $content = str_replace($originalContent, '', $content);
                    $content = preg_replace('/\s{4,}/uis', "\n", $content);
                    $content = $originalContent."\n\n\n".$content;
                }
            }*/

            if ($signatureText) {
                $emailFromSignatured = '"'.$signatureText.'" <'.$emailFrom.'>';
            } elseif ($signatureUser) {
                $userName = $signatureUser->makeName();
                $emailFromSignatured = '"'.$userName.'" <'.$emailFrom.'>';
            } else {
                $emailFromSignatured = $emailFrom;
            }

            foreach ($emailTo as $x) {
                $sender = new MailUtils_Letter($emailFromSignatured, $x, $subject, $content);
                if ($bodyType == 'html') {
                    $sender->setBodyType('text/html');
                } else {
                    $sender->setBodyType('text/plain');
                }

                foreach ($fileArray as $file) {
                    $fileName = $file['name'];
                    $type = $file['type'];
                    $file = $file['tmp_name'];

                    $sender->addAttachment(file_get_contents($file), $fileName, $type);
                }
                $sender->send($sendDate);
            }

            // @todo: move to event
            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $subjectGroup = EventService::Get()->parseSubjectGroup($subject);

                $text = $contentForEvent;

                // меняем текст для события
                $text = preg_replace("/<br\s*(.{0,1})>/ius", "\n", $text);
                //$text = preg_replace("/((\r)*\n){2,}/ius", "\n", $text);

                $text = strip_tags($text);

                // сохраняем событие
                foreach ($emailTo as $to) {

                    $event = new ShopEvent();
                    $event->setCdate(date('Y-m-d H:i:s'));
                    $event->setType('email');
                    $event->setFrom($emailFrom);
                    $event->setTo($to);
                    $event->setSubject($subject);
                    $event->setSubjectgroup($subjectGroup);
                    $event->setContent($text);
                    $event->setMailbox('sent');
                    $event->insert();

                    // добавляем аттачменты
                    foreach ($fileArray as $file) {
                        Shop::Get()->getFileService()->addFile(
                            $file['tmp_name'],
                            $file['name'],
                            $file['type'],
                            false, // no user
                            'event-'.$event->getId()
                        );
                    }

                    EventService::Get()->processEventParameters($event);
                }
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Отправить SMS на заданный номер.
     * From (отправитель) подставляется автоматически.
     *
     * Отправка SMS в системе выполняется только через этот метод.
     *
     * Параметр $user не обязательный, указывает на того, кто отправляет SMS.
     *
     * @param string $phone
     * @param string $content
     * @param User $user
     *
     * @return bool
     */
    public function sendSMS($phone, $content, $user = false) {
        $phone = preg_replace("/[^0-9]/ius", '', $phone);

        try {
            SQLObject::TransactionStart();

            $ex = new ServiceUtils_Exception();

            if (strlen($phone) < 9) {
                $ex->addError("invalid-number-format");
            }

            $apiLogin = Shop::Get()->getSettingsService()->getSettingValue('sms-login');
            $apiPassword = Shop::Get()->getSettingsService()->getSettingValue('sms-password');
            $apiSender = Shop::Get()->getSettingsService()->getSettingValue('sms-sender');

            $content = trim($content);
            if (!$content) {
                $ex->addError("content");
            }

            if (!$apiLogin || !$apiPassword || !$apiSender) {
                $ex->addError("no-sms-integration");
            }

            if ($ex->getCount()) {
                throw $ex;
            }

            // отправка sms
            PackageLoader::Get()->import('SMSUtils');
            $sender = new SMSUtils(new SMSUtils_SenderQueDB());
            $sender->send($apiSender, $phone, $content);

            // сохранение sms в события
            if (Engine::Get()->getConfigFieldSecure('project-box')) {
                $event = new ShopEvent();
                $event->setCdate(date('Y-m-d H:i:s'));
                $event->setType('sms');
                $event->setFrom($apiSender); // подпись
                if ($user) {
                    $event->setFromuserid($user->getId()); // кто реально шлет sms
                }
                $event->setTo($phone);
                $event->setContent($content);
                $event->insert();

                EventService::Get()->processEventParameters($event);
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Активация аккаунта
     *
     * @param $email
     * @param $code
     *
     * @throws Exception
     * @throws ServiceUtils_Exception
     */
    public function activateUser($email, $code) {
        try {
            $user = new User();
            $user->setEmail($email);
            $user->setActivatecode($code);
            $user->setLevel(0);
            $user->setLimitCount(1);

            if (!$user->select()) {
                throw new ServiceUtils_Exception();
            }

            $user->setLevel(1);
            $user->setActivatecode('');

            $user->update();

            return $user;
        } catch (Exception $ge) {
            throw $ge;
        }
    }

    /**
     * Вход
     *
     * @param string $login
     * @param string $password
     *
     * @throws ServiceUtils_Exception
     *
     * @return User
     */
    public function login($login, $password, $cookie = false, $indm5 = false) {
        try {
            $user = parent::login($login, $password, $cookie, $indm5);
        } catch (Exception $ex) {
            Engine_HTMLHead::Get()->addInfoToConsole($ex->getMessage());
            throw $ex;
        }
        $this->_checkUserEdate($user);

        // issue #34973
        // сразу после входа делаем корзину умной
        Shop::Get()->getShopService()->makeBasketSmart();

        return $user;
    }

    /**
     * автоматически логиним пользователя
     * только для пользователей level = 1
     *
     * @param User $user
     *
     * @return User
     *
     * @throws ServiceUtils_Exception
     */
    public function automaticalLogin (User $user) {
        if ($user->getLevel() != 1) {
            throw new ServiceUtils_Exception();
        }
        return $this->login(
            $user->getLogin() ? $user->getLogin() : $user->getEmail(),
            $user->getPassword(),
            false, // $cookie
            true // не криптить пароль
        );
    }

    /**
     * Получить пользователя по Identifier
     *
     * @param $identifier
     *
     * @return User
     */
    public function getUserByIdentifier($identifier) {
        return $this->getObjectByField('identifier', $identifier);
    }

    /**
     * Найти пользователя по code1c.
     *
     * @param int $code1c
     *
     * @throws ServiceUtils_Exception
     * @return User
     */
    public function getUserByCode1c($code1c) {
        try {
            return $this->getObjectByField('code1c', $code1c, 'XUser');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('User-object by code1c not found');
    }


    /**
     * Получить Identifier
     *
     * @param User $user
     *
     * @return string
     */
    public function getUserIdentifier(User $user) {
        if ($user->getIdentifier()) {
            return $user->getIdentifier();
        }
        $str = md5($user->getId().microtime(true));
        $user->setIdentifier($str);
        $user->update();
        return $str;
    }

    /**
     * Получить сотрудников
     *
     * @param User $user
     *
     * @return User
     */
    public function getUsersManagers($user = false) {
        $users = $this->getUsersAll($user);
        $users->setEmployer(1);
        $users->addWhere('typesex', 'company', '!=');

        return $users;
    }


    /**
     * Возвращает массив с Email-ами контактов
     *
     * @return array
     */
    public function getUsersEmails() {
        $users = $this->getUsersAll();
        $emails = array();

        while ($user = $users->getNext()) {
            $emailsArray = $user->getEmailArray();

            if (!empty($emailsArray)) {
                $emails = array_merge($emails, $emailsArray);
            }
        }

        return $emails;

    }

    /**
     * Получить массив данных по пользователю для формирования документов
     *
     * @param User $user
     *
     * @return array
     */
    public function makeUserAssignArrayForDocument(User $user) {
        try {
            $contractor = Shop::Get()->getShopService()->getContractorByID(
                $user->getContractorid()
            );

            $contractorTax = $contractor->getTax();
        } catch (Exception $e) {
            $contractorTax = 0;
        }

        $a['userid'] = $user->getId();

        if (isset($contractor)) {
            $a['contractordetails'] = nl2br($contractor->getDetails());
            $a['contractorname'] = $contractor->getName();
            for ($j = 1; $j <= 10; $j++) {
                $a['contractorfield'.$j] = $contractor->getField('customfield'.$j);
            }
        }

        // все поля
        $tmp = $user->getValues();
        foreach ($tmp as $key => $value) {
            $a['user_'.$key] = nl2br(htmlspecialchars($value));
        }

        return $a;
    }

    /**
     * Получить пользователей по email
     *
     * @param string $email
     * @param User $user
     *
     * @return User
     */
    public function getUsersByEmail($email, $user = false) {
        if (!Checker::CheckEmail($email)) {
            throw new ServiceUtils_Exception();
        }

        $tmp = new XShopUserEmail();
        $tmp->setEmail($email);
        $a = array();
        while ($x = $tmp->getNext()) {
            $a[] = $x->getUserid();
        }

        $users = $this->getUsersAll($user);
        $users->setOrder(array('employer DESC', 'id ASC'), false);
        if (count($a) == 1) {
            $users->setId($a[0]);
        } elseif (count($a) == 0) {
            $users->setId(-1);
        } else {
            $users->addWhereArray($a);
        }
        return $users;
    }

    /**
     * Получить пользователей по номеру телефона
     *
     * @param string $phone
     * @param User $user
     *
     * @return User
     */
    public function getUsersByPhone($phone, $user = false, $noexmatch = false) {
        $phone = trim($phone);
        if (!$phone) {
            throw new ServiceUtils_Exception();
        }

        $tmp = new XShopUserPhone();

        if (Engine::Get()->getConfigFieldSecure('phone-search-no-exact-match') || $noexmatch) {
            // в таком случае мы найдём юзера с телефоном 063....
            // даже если в его карточке контакта написано 38063..
            $ctn = strlen($phone);
            if ($ctn > 7) {
                $phone = substr($phone, -10);
                $tmp->addWhere('phone', '%'.$phone.'%', 'LIKE');
            } else {
                $tmp->setPhone($phone);
            }
        } else {
            $tmp->setPhone($phone);
        }
        $a = array();
        while ($x = $tmp->getNext()) {
            $a[] = $x->getUserid();
        }

        $users = $this->getUsersAll($user);
        $users->setOrder(array('employer DESC', 'id ASC'), false);
        if (count($a) == 1) {
            $users->setId($a[0]);
        } elseif (count($a) == 0) {
            $users->setId(-1);
        } else {
            $users->addWhereArray($a);
        }
        return $users;
    }

    /**
     * Найти пользователя по контакту
     *
     * @param string $contact
     * @param string $type
     *
     * @return User
     */
    public function findUserByContact($contact, $type) {
        if (!$contact) {
            throw new ServiceUtils_Exception();
        }

        if (!$type) {
            throw new ServiceUtils_Exception();
        }

        $contact = strtolower($contact);

        if (!empty($this->_findCacheArray[$contact][$type])) {
            return $this->_findCacheArray[$contact][$type];
        }

        if (isset($this->_findCacheArray[$contact][$type])) {
            throw new ServiceUtils_Exception();
        }

        if ($type == 'call' || $type == 'phone' || $type == 'sms') {
            $users = $this->getUsersByPhone($contact);
            $users->setLimitCount(1);
            $users->setDeleted(0);
            if ($x = $users->getNext()) {
                return $x;
            }
        } elseif ($type == 'email') {
            $users = $this->getUsersByEmail($contact);
            $users->setLimitCount(1);
            $users->setDeleted(0);
            if ($x = $users->getNext()) {
                return $x;
            }
        } elseif ($type == 'skype') {
            $e = ConnectionManager::Get()->getConnectionDatabase()->escapeString($contact);

            $users = $this->getUsersAll();
            $users->addWhereQuery("(skype='{$e}' OR skype LIKE '%{$e}%')");
            $users->setDeleted(0);
            while ($x = $users->getNext()) {
                $a = $x->getSkypeArray();
                if (in_array($contact, $a)) {
                    $this->_findCacheArray[$contact][$type] = $x;
                    return $x;
                }
            }
        } elseif ($type == 'whatsapp') {
            $e = ConnectionManager::Get()->getConnectionDatabase()->escapeString($contact);

            $users = $this->getUsersAll();
            $users->addWhereQuery("(whatsapp='{$e}' OR whatsapp LIKE '%{$e}%')");
            $users->setDeleted(0);
            while ($x = $users->getNext()) {
                $a = $x->getWhatsappArray();
                if (in_array($contact, $a)) {
                    $this->_findCacheArray[$contact][$type] = $x;
                    return $x;
                }
            }
        } elseif ($type == 'meeting') {
            if (preg_match("/^contact-(\d+)$/ius", $contact, $r)) {
                $users = $this->getUsersAll();
                $users->setId($r[1]);
                $users->setLimitCount(1);
                $users->setDeleted(0);
                while ($x = $users->getNext()) {
                    return $x;
                }
            }
        } elseif ($type == 'viber') {
            // @todo
            $z = 1; // do smth for code sniffer
        }

        $this->_findCacheArray[$contact][$type] = false;

        throw new ServiceUtils_Exception();
    }

    /**
     * Обновить все необходимые email-поля юзера
     */
    public function buildUserEmails(User $user) {
        try {
            SQLObject::TransactionStart();

            // получаем массив всех emaail по данному юзеру
            $tmp = new XShopUserEmail();
            $tmp->setUserid($user->getId());
            $a = array();
            while ($x = $tmp->getNext()) {
                $a[$x->getId()] = $x;
            }

            $emailArray = $user->getEmailArray();

            // обновляем или добавляем FVC
            foreach ($emailArray as $email) {
                try {
                    $tmp = new XShopUserEmail();
                    $tmp->setUserid($user->getId());
                    $tmp->setEmail($email);
                    if (!$tmp->select()) {
                        $tmp->insert();
                    }

                    // если обновили - убираем из массива
                    if (isset($a[$tmp->getId()])) {
                        unset($a[$tmp->getId()]);
                    }
                } catch (Exception $e) {

                }
            }

            // удаляем все не актуальне FVC данные
            foreach ($a as $id => $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Обновить все необходимые phones-поля юзера
     */
    public function buildUserPhones(User $user) {
        try {
            SQLObject::TransactionStart();

            // получаем массив всех emaail по данному юзеру
            $tmp = new XShopUserPhone();
            $tmp->setUserid($user->getId());
            $a = array();
            while ($x = $tmp->getNext()) {
                $a[$x->getId()] = $x;
            }

            $phoneArray = $user->getPhoneArray();

            // обновляем или добавляем FVC
            foreach ($phoneArray as $phone) {
                try {
                    $tmp = new XShopUserPhone();
                    $tmp->setUserid($user->getId());
                    $tmp->setPhone($phone);
                    if (!$tmp->select()) {
                        $tmp->insert();
                    }

                    // если обновили - убираем из массива
                    if (isset($a[$tmp->getId()])) {
                        unset($a[$tmp->getId()]);
                    }
                } catch (Exception $e) {

                }
            }

            // удаляем все не актуальне FVC данные
            foreach ($a as $id => $object) {
                $object->delete();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Проверить дату актуальности юзера (user.edate)
     *
     * @param User $user
     */
    private function _checkUserEdate(User $user) {
        if ($this->_checkUserEdateFlag) {
            return;
        }

        // issue #42002 - user edate
        if (Checker::CheckDate($user->getEdate())) {
            if ($user->getEdate() < date('Y-m-d H:i:s')) {
                // выход
                $this->logout($user);

                throw new ServiceUtils_Exception();
            }
        }

        $this->_checkUserEdateFlag = true;
    }

    /**
     * Убираем косяки и дубликаты из тегов
     *
     * @param string $tags
     *
     * @return string
     */
    private function _checkTags($tags) {
        $tags = explode(',', $tags);
        $a = array();
        foreach ($tags as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return implode(',', $a);
    }

    /**
     * Получить друзей
     *
     * @param int $id
     *
     * @return array
     */
    public function getFriends($id) {
        $tmp = new XShopUserLink();
        $tmp->addWhere('user1id', $id, '=');
        $returnArray = array();
        while ($x = $tmp->getNext()) {
            $id1 = $x->getUser1id();
            $id2 = $x->getUser2id();
            if ($id1 != $id) {
                $returnArray[] = $id1;
            } elseif ($id2 != $id) {
                $returnArray[] = $id2;
            }
        }

        $tmp = new XShopUserLink();
        $tmp->addWhere('user2id', $id, '=');
        while ($x = $tmp->getNext()) {
            $id1 = $x->getUser1id();
            $id2 = $x->getUser2id();
            if ($id1 != $id) {
                $returnArray[] = $id1;
            } elseif ($id2 != $id) {
                $returnArray[] = $id2;
            }
        }
        $returnArray = array_unique($returnArray);
        return $returnArray;
    }

    /**
     * Получить группы юзера
     *
     * @param User $user
     *
     * @return ShopUserGroup
     */
    public function getUserGroupsByUser(User $user) {
        $a = array(-1);
        $links = new XShopUser2Group();
        $links->setUserid($user->getId());
        while ($x = $links->getNext()) {
            $a[] = $x->getGroupid();
        }

        $group = $this->getUserGroupsAll();
        $group->addWhereArray($a);
        return $group;
    }

    /**
     * Автоматическое распределение контактов по smart-группам
     */
    public function processUserGroups() {
        ModeService::Get()->verbose("Process user groups...");

        $groups = $this->getUserGroupsAll();
        while ($x = $groups->getNext()) {
            try {
                $classname = $x->getLogicclass();
                if (!$classname) {
                    continue;
                }

                if (!class_exists($classname)) {
                    continue;
                }

                ModeService::Get()->verbose("Group ".$x->getId()." ".$x->getName()." (class ".$classname.")");

                // получаем все контакты из этой группы
                $contacts = $this->getUsersByGroup($x);
                $contactIDArray = array();
                while ($c = $contacts->getNext()) {
                    $contactIDArray[$c->getId()] = $c->getId();
                }

                // создаем процессор
                $processor = new $classname();
                if (!method_exists($processor, 'process')) {
                    throw new ServiceUtils_Exception('no method process()');
                }
                $contacts = $processor->process($x);

                // процессор вернет список контактов для этой группы.
                // добавляем в группу
                while ($c = $contacts->getNext()) {
                    $this->addUserToGroup($c, $x);

                    // исключаем из текущего списка
                    unset($contactIDArray[$c->getId()]);
                }

                // убираем все лишнее из группы
                foreach ($contactIDArray as $contactID) {
                    try {
                        $c = $this->getUserByID($contactID);

                        $this->removeUserFromGroup($c, $x);
                    } catch (Exception $contactEx) {

                    }
                }
            } catch (Exception $groupEx) {
                ModeService::Get()->debug($groupEx);
            }
        }
    }

    /**
     * Дерево-массив объектов ShopUserGroup
     *
     * @param int $rootID
     *
     * @return array
     */
    public function makeUserGroupTree($rootID = 0) {
        $category = $this->getUserGroupsAll();
        $a = array();
        while ($x = $category->getNext()) {
            $a[$x->getParentid()][] = $x;
        }

        return $this->_makeUserGroupTree($rootID, 0, $a);
    }

    /**
     * Получить текущего авторизированного юзера или Exception.
     *
     * Метод перегружен (override) для sudo.
     *
     * @param User $user
     *
     * @return User
     * @throws ServiceUtils_Exception
     */
    public function getUser(User $user = null) {
        $x = parent::getUser($user);

        $sudoArray = Engine::Get()->getConfigFieldSecure('user-sudo');
        if (isset($sudoArray[$x->getLogin()])) {
            $sudoLogin = $sudoArray[$x->getLogin()];
            return $this->getUserByLogin($sudoLogin);
        }

        return $x;
    }

    /**
     * Посчитать балас пользователя.
     * Баланс это разница между оплатами и заказами/проектами/..., которые находятся
     * в состоянии payed или prepayed (по которым предполагается оплата)
     * balance = +payments -ordres
     *
     * @param User $user
     *
     * @return float
     */
    public function makeUserBalance(User $user) {
        $sum = 0;

        // получаем ID юзеров и подюзеров
        $userIDArray = array($user->getId());
        if ($user->getTypesex() == 'company' && $user->getCompany()) {
            $other = $this->getUsersAll();
            $other->filterCompany($user->getCompany());
            while ($x = $other->getNext()) {
                $userIDArray[] = $x->getId();
            }
        }

        // платежи с плюсом
        if (Shop_ModuleLoader::Get()->isImported('finance')) {
            $payments = PaymentService::Get()->getPaymentsAll();
            $payments->filterClientid($userIDArray);
            while ($x = $payments->getNext()) {
                $sum += $x->getAmountbase();
            }
        }

        // отбираем статусы для shoporder
        $statusIDArray = array(-1);
        $statuses = Shop::Get()->getShopService()->getStatusAll();
        $statuses->addWhereQuery('(payed=1 OR prepayed=1)');
        while ($x = $statuses->getNext()) {
            $statusIDArray[] = $x->getId();
        }

        // все shoporder с минусом
        $orders = new ShopOrder();
        $orders->filterUserid($userIDArray);
        $orders->filterStatusid($statusIDArray);
        while ($x = $orders->getNext()) {
            $sum -= $x->getSumbase();
        }

        return $sum;
    }

    /**
     * Удалить конкретного пользователя (контакта)
     *
     * $user - кого удаляем
     * $cuser - кто удаляет (не обязательно)
     *
     * @param User $user
     * @param User $cuser
     */
    public function deleteUser(User $user, $cuser = false) {
        // если это не текущий пользователь
        if ($cuser && $cuser->getId() == $user->getId()) {
            throw new ServiceUtils_Exception('You can not delete yourself');
        }

        if ($user->getDeleted()) {
            throw new ServiceUtils_Exception('You can not delete already deleted user');
        }

        try {
            SQLObject::TransactionStart();

            if ($cuser && !$this->isUserChangeAllowed($user, $cuser)) {
                throw new ServiceUtils_Exception('access denied');
            }

            $user->setDeleted(1);
            $user->update();

            // записываем данные об активности пользователя
            try {
                $text = Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_deleted');
                $text .= ' #'.$user->getId();
                $text .=' '.$user->makeName();

                CommentsAPI::Get()->addComment(
                    'shop-history-user-del'.$user->getId(),
                    $text,
                    $cuser->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Встанновить удаленного пользователя (контакта)
     *
     * $user - кого удаляем
     * $cuser - кто удаляет (не обязательно)
     *
     * @param User $user
     * @param User $cuser
     */
    public function restoreUser(User $user, $cuser = false) {
        // если это не текущий пользователь
        if ($cuser && $cuser->getId() == $user->getId()) {
            throw new ServiceUtils_Exception('You can not delete yourself');
        }

        if (!$user->getDeleted()) {
            throw new ServiceUtils_Exception('You can not restore undeleted user');
        }

        try {
            SQLObject::TransactionStart();

            if ($cuser && !$this->isUserChangeAllowed($user, $cuser)) {
                throw new ServiceUtils_Exception('access denied');
            }

            $user->setDeleted(0);
            $user->update();

            // записываем данные об активности пользователя
            try {
                $text = Shop::Get()->getTranslateService()->getTranslateSecure('translate_user_restored');
                $text .= ' #'.$user->getId();
                $text .=' '.$user->makeName();

                CommentsAPI::Get()->addComment(
                    'shop-history-user-restore-'.$user->getId(),
                    $text,
                    $cuser->getId()
                );
            } catch (Exception $e) {

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    private function _makeUserGroupTree($parentID, $level, $categoryArray) {
        $a = array();
        if (empty($categoryArray[$parentID])) {
            return $a;
        }
        foreach ($categoryArray[$parentID] as $x) {
            $x = clone $x;

            // хитро дописываем поле level
            $x->setField('level', $level);

            $a[] = $x;
            $childs = $this->_makeUserGroupTree($x->getId(), $level + 1, $categoryArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }


    private $_checkUserEdateFlag = false;

    private $_findCacheArray = array();

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_UserService
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
     * @var Shop_UserService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}