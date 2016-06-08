<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.com.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class User extends XUser {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Get
     *
     * @return User
     */
    public static function Get($key) {
        return self::GetObject("User", $key);
    }

    /**
     * Next
     *
     * @return User
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить массив с данными пользователя
     *
     * @return array
     */
    public function makeInfoArray() {
        $a = array();
        $a['id'] = $this->getId();
        $a['login'] = $this->getLogin();
        $a['name'] = $this->makeName();
        $a['nameonly'] = $this->getName();
        $a['phone'] = htmlspecialchars($this->getPhone());
        $a['email'] = htmlspecialchars($this->getEmail());

        try {
            $a['url'] = $this->makeURLEdit();
        } catch (Exception $e) {

        }

        $a['logo'] = $this->makeImageThumb(50, 50, 'crop');
        return $a;
    }

    public function makeURLEdit() {
        try {
            return Engine::GetLinkMaker()->makeURLByContentIDParam(
                'shop-admin-users-control',
                $this->getId()
            );
        } catch (Exception $e) {
            return false;
        }

    }

    /**
     * Ссылка на страницу "События"
     *
     * @deprecated
     */
    public function makeURLHistory() {
        return $this->makeURLEvent();
    }

    public function makeURLEvent() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'shop-admin-users-event',
            $this->getId()
        );
    }

    /**
     * Является ли юзер менеджером или админом?
     *
     * @todo admin - not manager!
     *
     * @return bool
     */
    public function isAdmin() {
        return ($this->getLevel() >= 2);
    }

    /**
     * Является ли юзер менеджером?
     *
     * @return bool
     */
    public function isManager() {
        return ($this->getEmployer() == 1);
    }

    /**
     * Проверить, разрешен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param string $permissionKey
     *
     * @return bool
     */
    public function isAllowed($permissionKey, $cache = true) {
        return Shop::Get()->getAclService()->isUserAllowed($this, $permissionKey, $cache);
    }

    /**
     * Проверить, запрещен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param string $permissionKey
     *
     * @return bool
     */
    public function isDenied($permissionKey) {
        return Shop::Get()->getAclService()->isUserDenied($this, $permissionKey);
    }

    /**
     * Построить URL на Gravatar
     *
     * @param int $size
     *
     * @return bool|string
     *
     * @deprecated
     */
    public function makeImageGravatar($size = 50, $default = false) {
        if ($this->getEmail() && Checker::CheckEmail($this->getEmail())) {
            return "http://www.gravatar.com/avatar/".
                    md5(strtolower($this->getEmail()))."?s=".$size.'&d='.urlencode($default);
        }

        return false;
    }

    /**
     * Получить валюту пользователя.
     * Если валюта не указана - будет выставлена системная.
     *
     * @return ShopCurrency
     */
    public function getCurrency() {
        $currencyID = $this->getCurrencyid();
        if (!$currencyID) {
            try {
                SQLObject::TransactionStart();

                $currencyID = Shop::Get()->getCurrencyService()->getCurrencySystem()->getId();
                $this->setCurrencyid($currencyID);
                $this->update();

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
                throw $ge;
            }
        }

        return Shop::Get()->getCurrencyService()->getCurrencyByID($currencyID);
    }

    /**
     * Получить финансовые транзакции пользователя
     *
     * @deprecated
     *
     * @return ShopCash
     */
    public function getCashTransactions() {
        return Shop::Get()->getCashService()->getUserTransactions($this);
    }

    /**
     * Получить пользователя
     *
     * @return User
     */
    public function getManager() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getManagerid()
        );
    }

    /**
     * Получить автора
     *
     * @return User
     */
    public function getAuthor() {
        return Shop::Get()->getUserService()->getUserByID(
            $this->getAuthorid()
        );
    }

    /**
     * Получить менеджера или автора
     *
     * @return User
     */
    public function getManagerOrAuthor() {
        try {
            return $this->getManager();
        } catch (Exception $e) {

        }

        try {
            return $this->getAuthor();
        } catch (Exception $e) {

        }

        throw new ServiceUtils_Exception();
    }

    /**
     * Построить имя пользователя
     *
     * ПАРАМЕТРЫ И ЛОГИКУ РАБОТЫ МЕНЯТЬ ЗАПРЕЩЕНО! ТОЛЬКО С РАЗРЕШЕНИЯ max 
     * 
     * @param bool $escape
     *
     * @return string
     */
    public function makeName($escape = true, $format = false, $postOnly = false, $companyAndPost = false) {
        $namefirst = $this->getName();
        $namelast = $this->getNamelast();
        $namemiddle = $this->getNamemiddle();

        if ($format === 'lmf' || $format == 'lfm') {
            $name = trim($namelast.' '.$namefirst.' '.$namemiddle);
        } elseif ($format == 'fl') {
            $name = trim($namefirst.' '.$namelast);
        } elseif ($format == 'fm') {
            $name = trim($namefirst.' '.$namemiddle);
        } else {
            $name = trim($namefirst.' '.$namemiddle.' '.$namelast);
            if (!$name) {
                $name = $this->getCompany();
            }
        }

        $name = str_replace('  ', ' ', $name);

        // формат по умолчанию - полный (format == true)
        if ($format === true) {
            if ($this->getCompany() && !$postOnly && !$companyAndPost) {
                if ($name) {
                    $name .= ' (' . $this->getCompany() . ')';
                } else {
                    $name = $this->getCompany();
                }
            } elseif ($this->getCompany() && !$postOnly && $companyAndPost) {
                if ($name) {
                    $name .= ' (' . $this->getCompany();
                    if ($this->getCompany() && $this->getPost()) {
                        $name .= ' ';
                    }
                    $name .= $this->getPost() . ')';
                } else {
                    $name = $this->getCompany();
                    if ($this->getCompany() && $this->getPost()) {
                        $name .= ' ';
                    }
                    $name .= $this->getPost();
                }
            } elseif ($this->getPost()) {
                $name .= ' ('.$this->getPost().')';
            }

            if (!$name && $this->getLogin()) {
                $name .= ' @'.$this->getLogin();
            }
        }

        $name = str_replace(',', ', ', $name);
        $name = str_replace('  ', ' ', $name);
        if ($name) {
            if ($escape) {
                $name = htmlspecialchars($name);
            }
            return $name;
        }

        if ($format === true) {
            return '#'.$this->getId();
        }
    }

    /**
     * Получить группу пользователя
     *
     * @return ShopUserGroup
     */
    public function getUserGroup() {
        return Shop::Get()->getUserService()->getUserGroupByID(
            $this->getGroupid()
        );
    }

    /**
     * Получить массив данных для формирования документов
     *
     * @return array
     */
    public function makeAssignArrayForDocument() {
        return Shop::Get()->getUserService()->makeUserAssignArrayForDocument($this);
    }

    /**
     * Получить реквизиты
     *
     * @return XShopUserLegal
     */
    public function makeLegalForDocument() {
        $legal = new XShopUserLegal();
        $legal->setUserid($this->getId());
        $legal->setOrder('name', 'ASC');
        return $legal;
    }

    /**
     * Получить источник
     *
     * @return ShopSource
     */
    public function getSource() {
        return Shop::Get()->getShopService()->getSourceByID(
            $this->getSourceid()
        );
    }

    /**
     * Получить массив всех email пользователя
     *
     * @return array
     */
    public function getEmailArray() {
        $text = $this->getEmail();
        $text .= ' ';
        $text .= $this->getEmails();

        $text = strtolower($text);

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

    /**
     * Получить массив всех skype пользователя
     *
     * @return array
     */
    public function getSkypeArray() {
        $text = $this->getSkype();
        $text = strtolower($text);
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $tmp = explode(' ', $text);
        $a = array();
        foreach ($tmp as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Получить массив всех whatsapp пользователя
     *
     * @return array
     */
    public function getWhatsappArray() {
        $text = $this->getWhatsapp();
        $text = strtolower($text);
        $text = str_replace(array("\r", "\n", "\t"), ' ', $text);
        $text = preg_replace("/([\s\,\;]+)/ius", ' ', $text);
        $tmp = explode(' ', $text);
        $a = array();
        foreach ($tmp as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Получить изображение
     *
     * @param int $width
     * @param bool $height
     * @param string $method
     * @param bool $changeStubs
     *
     * @return string
     */
    public function makeImageThumb($width = 50, $height = false, $method = 'prop', $changeStubs = false) {
        $src = MEDIA_PATH.'/shop/'.$this->getImage();
        if (!file_exists($src) || is_dir($src)) {

            if ($changeStubs) {
                if ($this->getTypesex() == 'company') {
                    $src =  MEDIA_PATH.'/shop/stub-company.jpg';
                } elseif ($this->getTypesex() == 'woman') {
                    $src =  MEDIA_PATH.'/shop/stub-woman.jpg';
                } else {
                    $src = MEDIA_PATH . '/shop/stub-man.jpg';
                }
            } else {
                if ($this->getTypesex() == 'company') {
                    return '/media/shop/stub-company.jpg';
                } elseif ($this->getTypesex() == 'woman') {
                    return '/media/shop/stub-woman.jpg';
                } else {
                    return '/media/shop/stub-man.jpg';
                }
            }

        }

        // получаем формат
        $format = Shop::Get()->getSettingsService()->getSettingValue('image-format');
        $format = strtolower($format);
        if ($format != 'png' && $format != 'jpg') {
            $format = 'jpg';
        }

        return Shop_ImageProcessor::MakeThumbUniversal($src, $width, $height, $method, $format);
    }


    /**
     * Получить массив всех телефонов пользователя
     *
     * @return array
     */
    public function getPhoneArray() {
        $text = $this->getPhone();
        $text .= "\n";
        $text .= $this->getPhones();

        $text = strtolower($text);

        $text = str_replace(',', "\n", $text);
        $text = str_replace(';', "\n", $text);
        $text = str_replace(array("\r", "\t"), "\n", $text);
        $text = str_replace('-', '', $text);
        $text = str_replace('(', '', $text);
        $text = str_replace(')', '', $text);
        $phoneArray = explode("\n", $text);
        $a = array();
        foreach ($phoneArray as $x) {
            $x = preg_replace('/\D/', '', $x);
            if (strlen($x) >= 2) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Получить первый номер телефона контакта,
     * на который можно отправить SMS.
     *
     * @return string
     */
    public function getPhoneSMS() {
        $a = $this->getPhoneArray();
        foreach ($a as $x) {
            if (strlen($x) >= 11) {
                return $x;
            }
        }
        return false;
    }

    /**
     * Получить события
     *
     * @return ShopEvent
     */
    public function getEvents($company = false, $direction = 'all') {
        $contactArray = array();
        $contactID = -1;

        $connection = ConnectionManager::Get()->getConnectionDatabase();

        if ($company && $this->getCompany()) {
            // реквизиты всех контактов этой компании

            $tmp = new User();
            $tmp->setCompany($this->getCompany());
            while ($x = $tmp->getNext()) {
                $contactArray[] = $x->getId();
            }
            if (count($contactArray) == 1) {
                $contactID = $contactArray[0];
                $contactArray = array();
            } elseif (count($contactArray) == 0) {
                $contactID = -1;
                $contactArray = array();
            }
        } else {
            // реквизиты текущего контакта
            $contactID = $this->getId();
        }

        // находим все события от или на юзера
        $events = new ShopEvent();
        $events->setOrder('cdate', 'DESC');
        if ($direction == 'all') {
            if ($contactArray) {
                $events->addWhereQuery(
                    "(`fromuserid` IN (".implode(',', $contactArray).
                    ") OR `touserid` IN (".implode(',', $contactArray)."))"
                );
            } else {
                $events->addWhereQuery("(`fromuserid`='{$contactID}' OR `touserid`='{$contactID}')");
            }
        } elseif ($direction == 'from') {
            if ($contactArray) {
                $events->addWhereArray($contactArray, 'fromuserid');
            } else {
                $events->setFromuserid($contactID);
            }
        } elseif ($direction == 'to') {
            if ($contactArray) {
                $events->addWhereArray($contactArray, 'touserid');
            } else {
                $events->setTouserid($contactID);
            }
        } else {
            $events->addWhereQuery('1=0');
        }

        return $events;

        // старый код, умное определение на ходу
        /*$contactArray[] = -1;
        $connection = ConnectionManager::Get()->getConnectionDatabase();

        if ($company && $this->getCompany()) {
        // реквизиты всех контактов этой компании
        $tmp = new User();
        $tmp->setCompany($this->getCompany());
        while ($x = $tmp->getNext()) {
        $contactArray = array_merge($contactArray, $x->getEmailArray());
        $contactArray = array_merge($contactArray, $x->getPhoneArray());
        $contactArray = array_merge($contactArray, $x->getSkypeArray());
        if ($x->getWhatsapp()) {
        $contactArray[] = $x->getWhatsapp();
        }
        // @todo: viber
        $contactArray[] = 'contact-'.$x->getId(); // meeting
        }
        } else {
        // реквизиты текущего контакта
        $contactArray = array_merge($contactArray, $this->getEmailArray());
        $contactArray = array_merge($contactArray, $this->getPhoneArray());
        $contactArray = array_merge($contactArray, $this->getSkypeArray());
        if ($this->getWhatsapp()) {
        $contactArray[] = $this->getWhatsapp();
        }
        // @todo: viber
        $contactArray[] = 'contact-'.$this->getId(); // meeting
        }

        $contactArrayEscaped = array();
        foreach ($contactArray as $x) {
        $contactArrayEscaped[] = "'".$connection->escapeString($x)."'";
        }

        // находим все события от или на юзера
        $events = new ShopEvent();
        $events->setOrder('cdate', 'DESC');
        if ($direction == 'all') {
        $events->addWhereQuery("(`from` IN (".implode(',', $contactArrayEscaped).")
        OR `to` IN (".implode(',', $contactArrayEscaped)."))");
        } elseif ($direction == 'from') {
        $events->addWhereQuery("`from` IN (".implode(',', $contactArrayEscaped).")");
        } elseif ($direction == 'to') {
        $events->addWhereQuery("`to` IN (".implode(',', $contactArrayEscaped).")");
        }

        return $events;*/
    }

    public function insert() {
        if (!$this->getAuthorid()) {
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $this->setAuthorid($user->getId());
            } catch (Exception $e) {

            }
        }

        $result = parent::insert();

        Shop::Get()->getUserService()->buildUserEmails($this);
        Shop::Get()->getUserService()->buildUserPhones($this);

        return $result;
    }

    /**
     * Получить заказы клиента
     *
     * @return ShopOrder
     */
    public function getOrders() {
        $x = Shop::Get()->getShopService()->getOrdersAll();
        $x->setUserid($this->getId());
        return $x;
    }

    /**
     * Получить юрлицо данного заказа
     *
     * @return ShopContractor
     */
    public function getContractor() {
        return Shop::Get()->getShopService()->getContractorByID(
            $this->getContractorid()
        );
    }

    /**
     * Получить список номеров, на которые можно отправлять SMS
     *
     * @return array
     */
    public function getPhoneArrayForSMS() {
        $a = $this->getPhoneArray();
        $b = array();
        foreach ($a as $x) {
            $x = preg_replace("/[^0-9]/ius", '', $x);
            if (strlen($x) < 12) {
                continue;
            }
            $b[] = $x;
        }
        return $b;
    }

    /**
     * Получить список ролей
     *
     * @return array
     */
    public function getRoleArray() {
        // получаем список ролей
        $title = trim($this->getPost());
        $titleArray = explode(',', $title);

        $a = array();
        foreach ($titleArray as $x) {
            $x = trim($x);
            if ($x) {
                $a[] = $x;
            }
        }
        return $a;
    }

    public function makeColor() {
        $colorArray = array();
        $colorArray[] = 'aqua';
        $colorArray[] = 'greenyellow';
        $colorArray[] = 'blue';
        $colorArray[] = 'brown';
        $colorArray[] = 'coral';
        $colorArray[] = 'green';
        $colorArray[] = 'gold';
        $colorArray[] = 'silver';
        $colorArray[] = 'crimson';
        $colorArray[] = 'violet';

        $s = $this->getId().'';
        $digit = substr($s, strlen($s) - 1, 1);

        return $colorArray[$digit];
    }

    /**
     * Посчитать баланс контакта.
     * Баланс контакта это сумма платежей минус сумма заказов с финансовыми обязательствами.
     * balance = +payments - orders
     *
     * @return float
     */
    public function makeSumBalance() {
        return Shop::Get()->getUserService()->makeUserBalance($this);
    }

    /**
     * ДР или не ДР
     *
     * @return bool
     */
    public function isBirthday() {
        $bdate = $this->getBdate();
        if ($bdate != "0000-00-00" && date("m-d", strtotime($bdate)) == date("m-d")) {
            return true;
        }
        return false;
    }

    /**
     * Получить группы
     *
     * @return ShopUserGroup
     */
    public function getGroups() {
        return Shop::Get()->getUserService()->getUserGroupsByUser($this);
    }

    public function update($massUpdate = false) {
        $updateEmail = false;
        $updatePhone = false;

        if (!$massUpdate) {
            $a = $this->getValueUpdateArray();

            // обновляем телефоны
            $updatePhone = isset($a['phone']) || isset($a['phones']);

            // обновляем email
            $updateEmail = isset($a['email']) || isset($a['emails']);
        }

        $result = parent::update($massUpdate);

        if (!$massUpdate && $updateEmail) {
            Shop::Get()->getUserService()->buildUserEmails($this);
        }

        if (!$massUpdate && $updatePhone) {
            Shop::Get()->getUserService()->buildUserPhones($this);
        }

        return $result;
    }

}