<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Сервис, отвечающий за работу с правами доступа (ACL).
 * Все ключи ACL хранятся в базе, потому что их формировать это долго и
 * сервер делает кучу лишних SQL запросов.
 *
 * @copyright WebProduction
 * @package   OneBox
 */
class Shop_AclService extends ServiceUtils_AbstractService {

    /**
     * Получить список прав доступа.
     * Метод вернет 2D-массив.
     * Параметр $cache по умолчанию true,
     * и это означает что данные можно достать из кеша.
     * По умолчанию данные кешируются навечно.
     *
     * @param bool $cache
     *
     * @return array
     */
    public function getACLPermissions($cache = true) {
        if ($cache) {
            try {
                $a = Engine::GetCache()->getData('acl');
                return unserialize($a);
            } catch (Exception $e) {

            }
        }

        $acl = new XUserACLKey();
        $acl->setOrder('name', 'ASC');
        $a = array();
        while ($x = $acl->getNext()) {
            $a[$x->getKey()] = array(
                'name' => $x->getName(),
                'key' => $x->getKey(),
            );
        }

        try {
            Engine::GetCache()->setData('acl', serialize($a));
        } catch (Exception $e) {

        }

        return $a;
    }

    /**
     * Зарегистрировать ACL-permission.
     * Метод используется модулями для регистрации своих ACL.
     * Если повторно вызвать метод с теми же параметрами,
     * то он заменит ACL, а не допишет дубликат.
     *
     * Метод хранит список ключей в базе, поэтому достаточно
     * добавить ключ один раз и он сохранится в проекте навсегда.
     *
     * @param string $key
     * @param string $name
     */
    public function addACLPermission($key, $name) {
        $key = trim($key);
        $name = trim($name);

        if (!$key) {
            throw new ServiceUtils_Exception('key');
        }

        if (!$name) {
            throw new ServiceUtils_Exception('name');
        }

        try {
            SQLObject::TransactionStart();

            $acl = new XUserACLKey();
            $acl->setKey($key);
            if ($acl->select()) {
                $acl->setName($name);
                $acl->setDeleted(0);
                $acl->update();
            } else {
                $acl->setName($name);
                $acl->insert();
            }

            SQLObject::TransactionCommit();

            // чистим кеш
            try {
                Engine::GetCache()->removeData('acl');
            } catch (Exception $e) {

            }
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Начало синхронизации ACL - пометить все сущности
     */
    public function syncStart() {
        ModeService::Get()->verbose('Start ACL sync...');

        $acl = new XUserACLKey();
        $acl->setDeleted(1, true);
        $acl->update(true);
    }

    public function getNameByKey($key) {
        if (!$key) {
            return false;
        }

        $acl = new XUserACLKey();
        $acl->setKey($key);
        $acl = $acl->getNext();
        if ($acl) {
            return $acl->getName();
        } else {
            return false;
        }
    }
    /**
     * Конец синхронизации ACL - очистить все сущности
     * и перестроить кеш
     */
    public function syncEnd() {
        ModeService::Get()->verbose('End ACL sync...');

        // удаление необновленных ACL ключей
        $acl = new XUserACLKey();
        $acl->setDeleted(1);
        $acl->delete(true);

        // запись в кэш
        Shop::Get()->getAclService()->getACLPermissions(false);

        // записываем в кеш ACL для каждого сотрудника
        $employers = Shop::Get()->getUserService()->getUsersManagers();
        while ($user = $employers->getNext()) {
            ModeService::Get()->verbose('Cache ACL for user '.$user->getLogin().'...');

            // кешируем все
            $this->_getUserACL($user, false);

            // кешируем поправленный assoc-массив
            $this->getUserACLArray($user, false);
        }
    }

    /**
     * Получить ACL для юзера.
     * Метод вернет массив всех ключей, которые доступны юзеру.
     * Метод кешируется, кеш сбрасывается по требованию при перестройке ACL.
     *
     * @param User $user
     *
     * @return array
     */
    private function _getUserACL(User $user, $cache = true) {
        if (isset($this->_aclArray[$user->getId()])) {
            return $this->_aclArray[$user->getId()];
        }

        // пытаемся найти данные из кеша
        if ($cache) {
            try {
                $a = Engine::GetCache()->getData('acl-user'.$user->getId());
                $this->_aclArray[$user->getId()] = unserialize($a);
                return $this->_aclArray[$user->getId()];
            } catch (Exception $e) {

            }
        }

        $list = new XUserACL();
        $list->setUserid($user->getId());
        while ($x = $list->getNext()) {
            $this->_aclArray[$user->getId()][] = $x->getAcl();
        }

        // Дописываем один "левый ключ", когда у пользователя вообще нет ACL.
        // Это нужно чтобы система все закешировала и не тупила.
        if (empty($this->_aclArray[$user->getId()])) {
            $this->_aclArray[$user->getId()][] = 'no-acl-empty';
        }

        // записываем данные в кеш навечно
        try {
            Engine::GetCache()->setData(
                'acl-user'.$user->getId(),
                serialize($this->_aclArray[$user->getId()])
            );
        } catch (Exception $e) {

        }

        return $this->_aclArray[$user->getId()];
    }

    /**
     * Получить список прав юзера в виде 2D-assoc массива.
     * Метод вернет все ключи со значениями 1 (allow) 0 (deny)
     *
     * @param User $user
     *
     * @return array
     */
    public function getUserACLArray(User $user, $cache = true) {
        // пытаемся найти данные из кеша
        if ($cache) {
            try {
                $a = Engine::GetCache()->getData('acl-full-user'.$user->getId());
                return unserialize($a);
            } catch (Exception $e) {

            }
        }

        $acl = $this->getACLPermissions();
        $a = array();
        foreach ($acl as $x) {
            $key = str_replace('-', '_', $x['key']);
            $a[$key] = $this->isUserAllowed($user, $x['key']);
        }

        // записываем данные в кеш навечно
        try {
            Engine::GetCache()->setData(
                'acl-full-user'.$user->getId(),
                serialize($a)
            );
        } catch (Exception $e) {

        }

        return $a;
    }

    /**
     * Проверить, разрешен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param User $user
     * @param string $permissionKey
     *
     * @return bool
     */
    public function isUserAllowed(User $user, $permissionKey, $cache = true) {
        // Временный cache, чтобы не приходилось 100500 раз спрашивать getLevel, который
        // вызовет getField, а там события.
        if ($cache && isset($this->_levelCache[$user->getId()])) {
            $level = $this->_levelCache[$user->getId()];
        } else {
            $level = $user->getLevel();
            $this->_levelCache[$user->getId()] = $level;
        }

        // админам всегда можно
        if ($level >= 3) {
            return true;
        }

        // клиентам всегда нельзя
        if ($level <= 1) {
            return false;
        }

        $result = (bool) in_array($permissionKey, $this->_getUserACL($user, $cache));

        if (!$result) {
            Engine_HTMLHead::Get()->addInfoToConsole('UserAclFalse: '.$permissionKey);
        }

        return $result;
    }

    /**
     * Проверить, запрещен ли пользователю доступ к ACL-ключу $permissionKey
     *
     * @param User $user
     * @param string $permissionKey
     *
     * @return bool
     */
    public function isUserDenied(User $user, $permissionKey) {
        $result = !$user->isAllowed($permissionKey);
        if ($result) {
            Engine_HTMLHead::Get()->addInfoToConsole('UserAclFalse: '.$permissionKey);
        }
        return $result;
    }

    /**
     * Обновить ACL пользователя
     *
     * @param User $user
     * @param int $level
     * @param array $aclArray
     * @param string $edate
     */
    public function updateUserACL(User $user, $level, $aclArray, $edate = false) {
        if (!$aclArray) {
            $aclArray = array();
        }

        $level = (int) $level;
        if ($level < 0) {
            throw new ServiceUtils_Exception();
        }

        if ($edate && Checker::CheckDate($edate)) {
            $edate = DateTime_Formatter::DateTimeISO9075($edate);
        } else {
            $edate = '0000-00-00 00:00:00';
        }

        try {
            SQLObject::TransactionStart();

            $user->setEdate($edate);
            $user->setLevel($level);
            $user->setUdate(date('Y-m-d H:i:s'));
            $user->update();

            // убираем старые ACL
            $acl = new XUserACL();
            $acl->setUserid($user->getId());
            $acl->delete(true);

            // вставляем новые ACL
            foreach ($aclArray as $x) {
                $acl = new XUserACL();
                $acl->setUserid($user->getId());
                $acl->setAcl($x);
                $acl->insert();
            }

            SQLObject::TransactionCommit();

            // заставим перестроиться весь ACL в фоне и его кеши
            ProcessorQueService::Get()->addProcessor('Shop_Processor_BuildACL');
            Engine::GetCache()->removeData('contentbox-admin-menu-block-'.$user->getId());

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Метод который проверяет есть ли доступ к заданному контенту у текущего юзера.
     *
     * @param Events_Event $event
     *
     * @return
     */
    public function checkACLObserver(Events_Event $event) {
        $contentObject = $event->getContent();
        $role = $contentObject->getContentData();
        $rolesArray = @$role['role'];
        if ($rolesArray) {
            $user = Shop::Get()->getUserService()->getUser();
            foreach ($rolesArray as $resource) {
                if ($user->isDenied($resource)) {
                    // пишем в лог
                    $aclName = Shop::Get()->getAclService()->getNameByKey($resource);
                    LogService::Get()->add(
                        array(
                            'url' => Engine_URLParser::Get()->getCurrentURL(),
                            'user #'.$user->getId(),
                            'Acl CONTENT: '.$aclName.' - '.$resource
                        ),
                        'acl'
                    );

                    // вычисляем путь к шаблону
                    $templateName = Engine::Get()->getConfigFieldSecure('shop-template');
                    $templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

                    $contentObject->setField('filehtml', $templatePath.'/error/error_deny.html');
                    $contentObject->setField('filephp', false);
                    return;
                }
            }
        }
    }


    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_AclService
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
     * Массив ключей для конкретного пользователя.
     *
     * @var array
     */
    private $_aclArray = array();

    /**
     * Временный cache, чтобы не приходилось 100500 раз спрашивать getLevel, который
     * вызовет getField, а там события.
     *
     * @var array
     */
    private $_levelCache = array();

    /**
     * Подменяемый объект сервиса
     *
     * @var Shop_AclService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}