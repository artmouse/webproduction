<?php

class Shop_ModuleLoader {

    /**
     * Подключить модуль
     *
     * @param strind $moduleName
     * @param bool $isTemplate //deprecated
     *
     * @return bool
     */
    public function import($moduleName, $isTemplate = false) {
        // проверяем, подключен ли модуль
        if ($this->isImported($moduleName)) {
            return false;
        }

        if ($isTemplate) {
            // @deprecated
            $includePath = PackageLoader::Get()->getProjectPath() . '/templates/' . $moduleName . '/include.php';
        } else {
            // module
            $includePath = PackageLoader::Get()->getProjectPath() . '/modules/' . $moduleName . '/include.php';
        }

        include_once($includePath);

        // запоминаем, какие модули подключены
        if (!isset($this->_importedArray[$moduleName])) {
            $this->_importedArray[$moduleName] = $moduleName;
        }

        return true;
    }

    /**
     * Проверить, подключен ли модуль
     *
     * @param string $packageName
     *
     * @return bool
     */
    public function isImported($moduleName) {
        return (isset($this->_importedArray[$moduleName]));
    }

    /**
     * Получить массив зарегистрированных модулей
     *
     * @return array
     */
    public function getImportedModules() {
        return $this->_importedArray;
    }

    /**
     * Получить пункты верхнего меню
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getTopMenuArray(User $cuser) {
        $this->_loadMenu();

        return $this->_checkMenuACL($cuser, $this->_topMenuItemArray);
    }

    /**
     * Получить пункты меню "Настройки"
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getSettingMenuArray(User $cuser) {
        $this->_loadMenu();

        $result = $this->_checkMenuACL($cuser, $this->_settingMenuItemArray);
        usort($result, array($this, '_sortMenu'));
        return $result;
    }

    /**
     * Получить пункты меню "Отчеты"
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getReportMenuArray(User $cuser) {
        $this->_loadMenu();

        $result = $this->_checkMenuACL($cuser, $this->_reportMenuItemArray);
        usort($result, array($this, '_sortMenu'));
        return $result;
    }

    /**
     * Получить пункты табов юзера
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getUserTabArray(User $cuser) {
        return $this->_checkMenuACL($cuser, $this->_userTabItemArray);
    }

    /**
     * Получить пункты табов профайла
     *
     * @return array
     */
    public function getProfileTabArray () {
        return $this->_profileTabItemArray;
    }

    /**
     * Получить пункты табов товара
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getProductTabArray(User $cuser) {
        return $this->_checkMenuACL($cuser, $this->_productTabItemArray);
    }

    /**
     * Получить дополнительные поля товара
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getProductCustomFieldArray() {
        return $this->_productCustomFieldArray;
    }

    /**
     * Получить пункты табов заказа
     *
     * @param User $cuser
     *
     * @return array
     */
    public function getOrderTabArray(User $cuser) {
        return $this->_checkMenuACL($cuser, $this->_orderTabItemArray);
    }

    /**
     * Получить способы отображения заказов
     *
     * @return array
     */
    public function getOrderViewModeArray() {
        return $this->_orderViewModeArray;
    }

    /**
     * Получить способы отображения юзеров
     *
     * @return array
     */
    public function getUserViewModeArray() {
        return $this->_userViewModeArray;
    }

    /**
     * Получить блоки в карточке контакта
     *
     * @return array
     */
    public function getUserStatisticsBlockArray() {
        return $this->_userStatisticsBlockArray;
    }

    /**
     * Получить страницы документации
     *
     * @return array
     */
    public function getHelpItemArray() {
        return $this->_helpItemArray;
    }

    /**
     * Добавить пункт в верхнее меню
     *
     * @param string $name
     * @param string $url
     * @param string $acl
     * @param string $class
     * @param array $childArray
     */
    public function registerTopMenuItem(
        $name, $url, $acl = false, $class = false, $childArray = array(), $icon = false, $top = false
    ) {
        $this->_topMenuItemArray[] = array(
            'name' => $name,
            'url' => $url,
            'acl' => $acl,
            'class' => $class,
            'icon' => $icon,
            'childArray' => $childArray,
            'top' => $top,
        );
    }

    /**
     * Вернуть массив модулей
     *
     * @return mixed
     */
    public function getModulesArray() {
        return Engine::Get()->getConfigFieldSecure('shop-module');
    }

    /**
     * Проверить, есть ли указанный модуль в массиве моделй
     * p.s. max не ставь deprecated, т.к. isImported возвращает true только когда модуль подключен
     * и если есть необходимость проверить в модуле(include.php) contact есть ли модуль box то isImported вернет false
     *
     * @param $name
     *
     * @return bool
     */
    public function isModuleInModulesArray($name) {
        $modules = Engine::Get()->getConfigFieldSecure('shop-module');
        return in_array($name, $modules);
    }

    /**
     * Добавить пункт в "Настройки"
     *
     * @param string $name
     * @param string $url
     * @param string $acl
     */
    public function registerSettingMenuItem($name, $url, $acl = false) {
        $this->_settingMenuItemArray[] = array(
            'name' => $name,
            'url' => $url,
            'acl' => $acl
        );
    }

    /**
     * Добавить пункт в "Отчеты"
     *
     * @param string $name
     * @param string $url
     * @param string $acl
     */
    public function registerReportMenuItem($name, $url, $acl = false) {
        $this->_reportMenuItemArray[] = array(
            'name' => $name,
            'url' => $url,
            'acl' => $acl
        );
    }

    /**
     * Добавить пункт в табы юзера
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     * @param string $acl
     */
    public function registerUserTabItem($name, $contentID, $moduleName, $acl = false) {
        $this->_userTabItemArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'moduleName' => $moduleName,
            'acl' => $acl
        );
    }

    /**
     * Добавить пункт в табы кабинет клиента
     *
     * @param $name
     * @param $contentID
     * @param $moduleName
     */
    public function registerProfileTabItem($name, $contentID, $moduleName) {
        $this->_profileTabItemArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'moduleName' => $moduleName,
        );
    }

    /**
     * Добавить пункт в табы товара
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     * @param string $acl
     */
    public function registerProductTabItem($name, $contentID, $moduleName, $acl = false) {
        $this->_productTabItemArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'moduleName' => $moduleName,
            'acl' => $acl
        );
    }

    /**
     * Добавить поле в карточку товара
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     * @param string $acl
     */
    public function registerProductCustomField($name, $field, $type) {
        $this->_productCustomFieldArray[] = array(
            'name' => $name,
            'field' => $field,
            'type' => $type,
        );
    }

    /**
     * Добавить пункт в табы заказа
     *
     * @param string $name
     * @param string $contentID
     * @param string $moduleName
     * @param string $acl
     */
    public function registerOrderTabItem($name, $contentID, $moduleName, $acl = false) {
        $this->_orderTabItemArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'moduleName' => $moduleName,
            'acl' => $acl
        );
    }

    /**
     * Добавить способ отображения юзеров
     *
     * @param string $name
     * @param string $contentID
     * @param string $modeName
     */
    public function registerUserViewMode($name, $contentID, $modeName) {
        $this->_userViewModeArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'modeName' => $modeName
        );
    }

    /**
     * Добавить способ отображения заказов
     *
     * @param string $name
     * @param string $contentID
     * @param string $modeName
     */
    public function registerOrderViewMode($name, $contentID, $modeName) {
        $this->_orderViewModeArray[] = array(
            'name' => $name,
            'contentID' => $contentID,
            'modeName' => $modeName
        );
    }

    /**
     * Добавить блок в карточку контакта
     *
     * @param string $contentID
     */
    public function registerUserStatisticsBlock($contentID) {
        $this->_userStatisticsBlockArray[] = $contentID;
    }

    /**
     * Добавить страницу документации
     *
     * @param string $key
     * @param string $file
     * @param string $title
     * @param string $parent
     * @param integer $sort
     */
    public function registerHelpItem($key, $file, $title, $parent, $sort) {
        $this->_helpItemArray[] = array(
            'key' => $key,
            'file' => $file,
            'title' => $title,
            'parent' => $parent,
            'sort' => $sort
        );
    }

    /**
     * Список модулей, которые уже подключены
     *
     * @var array
     */
    private $_importedArray = array();

    /**
     * Зарегистрированные пункты меню
     *
     * @var array
     */
    private $_topMenuItemArray = array();

    private $_settingMenuItemArray = array();

    private $_reportMenuItemArray = array();

    /**
     * Зарегистрированные табы
     *
     * @var array
     */
    private $_userTabItemArray = array();
    private $_profileTabItemArray = array();
    private $_productTabItemArray = array();
    private $_productCustomFieldArray = array();
    private $_orderTabItemArray = array();

    /**
     * Способы отображения списков объектов
     *
     * @var array
     */
    private $_userViewModeArray = array();
    private $_orderViewModeArray = array();

    /**
     * Зарегистрированные блоки
     *
     * @var array
     */
    private $_userStatisticsBlockArray = array();

    /**
     * Зарегистрированные страницы документации
     *
     * @var array
     */
    private $_helpItemArray = array();

    /**
     * Внутренний метод для сортировки usort()
     *
     * @param array $a
     * @param array $b
     *
     * @return bool
     */
    private function _sortMenu($a, $b) {
        return $a['name'] > $b['name'];
    }

    /**
     * Удалить из меню пункты, которые запрещено видеть пользователю
     *
     * @param User $user
     * @param array $menuArray
     *
     * @return array
     */
    private function _checkMenuACL(User $user, $menuArray) {
        foreach ($menuArray as $k => $v) {
            if ($v['acl'] && $user->isDenied($v['acl'])) {
                unset($menuArray[$k]);
            } elseif (!empty($v['childArray'])) {
                $childArray = $v['childArray'];
                foreach ($childArray as $ck => $cv) {
                    if ($cv['acl'] && $user->isDenied($cv['acl'])) {
                        unset($menuArray[$k]['childArray'][$ck]);
                    }
                }
            }
        }

        return $menuArray;
    }

    /**
     * Инициировать событие и загрузить все меню
     */
    private function _loadMenu() {
        if ($this->_menuLoaded) {
            return;
        }

        // бросаем событие
        $event = Events::Get()->generateEvent('beforeBoxAdminMenuLoad');
        $event->notify();

        $this->_menuLoaded = true;
    }

    private function __construct() {
        // регистрируем событие для меню
        Events::Get()->addEvent('beforeBoxAdminMenuLoad', 'Events_Event');
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_ModuleLoader
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
     * @var Shop_MpduleLoader
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

    private $_menuLoaded = false;

}