<?php
/**
 * Сервис отвечает за понятие РОЛЬ в системе.
 * На основе ролей выстраивается орг структура компании.
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright RoleService
 * @package OneBox
 */
class RoleService {

    /**
     * Получить все роли
     *
     * @return XShopRole
     */
    public function getRoleAll() {
        $x = new XShopRole();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить роль по имени
     *
     * @param int $roleID
     *
     * @return XShopRole
     */
    public function getRoleByID($roleID) {
        $role = new XShopRole($roleID);
        if ($role->getId()) {
            return $role;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить роль по имени
     *
     * @param string $roleName
     *
     * @return XShopRole
     */
    public function getRoleByName($roleName) {
        if (!$roleName) {
            throw new ServiceUtils_Exception();
        }

        $role = new XShopRole();
        $role->setName($roleName);
        if ($role->select()) {
            return $role;
        }
        throw new ServiceUtils_Exception();
    }

    public function makeRoleTreeArray($rootID = 0) {
        $a = array();
        $role = RoleService::Get()->getRoleAll();
        $role->setParentid($rootID);
        while ($x = $role->getNext()) {
            $a[] = array(
            'name' => htmlspecialchars($x->getName()),
            'description' => nl2br(htmlspecialchars($x->getDescription())),
            'childArray' => $this->makeRoleTreeArray($x->getId()),
            );
        }
        return $a;
    }

    public function makeRoleListArray($rootID = 0) {
        $role = $this->getRoleAll();
        $a = array();
        while ($x = $role->getNext()) {
            $a[$x->getParentid()][] = array(
            'id' => $x->getId(),
            'name' => htmlspecialchars($x->getName()),
            'description' => nl2br(htmlspecialchars($x->getDescription())),
            );
        }

        return $this->_makeRoleTree($rootID, 0, $a);
    }

    private function _makeRoleTree($parentID, $level, $roleArray) {
        $a = array();
        if (empty($roleArray[$parentID])) {
            return $a;
        }
        foreach ($roleArray[$parentID] as $x) {
            $x['level'] = $level;
            $a[] = $x;
            $childs = $this->_makeRoleTree($x['id'], $level + 1, $roleArray);
            foreach ($childs as $y) {
                $a[] = $y;
            }
        }
        return $a;
    }

    /**
     * Получить всех пользователей по ролям
     *
     * @param string $roleName
     *
     * @return User
     */
    public function getUsersByRole($roleName) {
        $roleNameEsc = ConnectionManager::Get()->getConnectionDatabase()->escapeString($roleName);

        $a = array('1=0');
        if ($roleNameEsc) {
            $a[] = "`post` LIKE '{$roleNameEsc}'";
            $a[] = "`post` LIKE '{$roleNameEsc},%'";
            $a[] = "`post` LIKE '%,{$roleNameEsc}'";
            $a[] = "`post` LIKE '%,{$roleNameEsc},%'";
        }

        $users = Shop::Get()->getUserService()->getUsersAll();
        $users->addWhereQuery("(".implode(' OR ', $a).")");
        return $users;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return RoleService
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
     * @var RoleService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}