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
 * Сервис по работе с настройками системы
 *
 * @author Golub Oleksii <avator@webproduction.com.ua>
 * 
 * @copyright WebProduction
 *
 * @package Shop
 */
class Shop_SettingsService extends ServiceUtils_AbstractService {

    /**
     * Получить заказные звонки
     *
     * @return XShopSettings
     */
    public function getSettingsAll() {
        $x = new XShopSettings();
        $x->setOrder('name', 'ASC');
        return $x;
    }

    /**
     * Получить настройку по ID
     *
     * @return XShopSettings
     */
    public function getSettingsByID($id) {
        return $this->getObjectByID($id, 'XShopSettings');
    }

    /**
     * Получить значение по ключу.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function getSettingValue($key, $cache = true) {
        $key = trim($key);

        // если уже есть кеш
        if ($this->_settingsArray !== 0) {
            if (isset($this->_settingsArray[$key])) {
                return $this->_settingsArray[$key];
            } else {
                return false;
            }
        }

        // пытаемся найти данные из кеша
        if ($cache) {
            try {
                $a = Engine::GetCache()->getData('setting-keys');
                $this->_settingsArray = unserialize($a);
                return $this->_settingsArray[$key];
            } catch (Exception $e) {

            }
        }

        // вычитываем кеш
        $a = array();

        $settings = new XShopSettings();
        while ($x = $settings->getNext()) {
            $a[$x->getKey()] = $x->getValue();
        }
        $this->_settingsArray = $a;

        // записываем данные в кеш
        try {
            Engine::GetCache()->setData(
                'setting-keys',
                serialize($this->_settingsArray),
                false,
                3600
            );
        } catch (Exception $e) {

        }

        if (isset($a[$key])) {
            return $a[$key];
        } else {
            return false;
        }
    }

    /**
     * Обновить значение настройки
     *
     * @param XShopSettings $setting
     * @param string $value
     * @param bool $checkImage
     */
    public function updateSettings(XShopSettings $setting, $value, $checkImage = true) {
        try {
            SQLObject::TransactionStart();

            $value = trim($value);
            $oldValue = $setting->getValue();

            if ($setting->getType() == 'image' && $checkImage) {
                if ($setting->getKey() == 'favicon') {
                    $format = 'ico';
                } elseif ($setting->getKey() == 'background') {
                    $format = 'jpg';
                } else {
                    $format = false;
                }

                $file = Shop::Get()->getShopService()->makeImagesUploadUrl(
                    $value,
                    '/upload/',
                    $format
                );

                copy($value, MEDIA_PATH.'/upload/'.$file);
                $value = '/media/upload/'.$file;
            }

            if ($setting->getKey() == 'autoupdate') {
                if (file_exists(PackageLoader::Get()->getProjectPath().'/autoupdate.conf')) {
                    if ($oldValue != $value) {
                        $fp = @fopen(PackageLoader::Get()->getProjectPath().'/autoupdate.conf', 'r+');
                        while (($string = fgets($fp)) !== false) {
                            if (strpos($string, 'autoupdate=') === 0) {
                                fseek($fp, -2, SEEK_CUR);
                                fwrite($fp, (int) $value);
                                break;
                            }
                        }
                    }
                } else {
                    $fp = @fopen(PackageLoader::Get()->getProjectPath().'/autoupdate.conf', 'w');
                    fwrite($fp, "autoupdate=".(int) $value."\n");
                }
                @fclose($fp);
            }

            $setting->setValue($value);
            $setting->update();

            // Если есть кеш, обновляем значение
            if ($this->_settingsArray !== 0) {
                $this->_settingsArray[$setting->getKey()] = $setting->getValue();
            }

            try {
                Engine::GetCache()->removeData('setting-keys');
            } catch (Exception $ecache) {

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить значение свойства
     */
    public function deleteSettingsValue($settingID) {
        try {
            SQLObject::TransactionStart();

            $settings = $this->getSettingsByID($settingID);

            $settings->setValue('');
            $settings->update();

            // Если есть кеш, удаляем значение
            if ($this->_settingsArray !== 0) {
                $this->_settingsArray[$settings->getKey()] = '';
            }

            try {
                Engine::GetCache()->removeData('setting-keys');
            } catch (Exception $ecache) {

            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Добавить setting-поле в глобальные настройки.
     * Если такой ключ (key) уже есть, то данные обновятся.
     * Значение по умолчанию (defaultValue) используется только в момент создания новых ключей.
     *
     * @param string $key
     * @param string $name
     * @param string $tabName
     * @param string $description
     * @param string $type
     * @param string $defaultValue
     */
    public function addSetting($key, $name, $tabName, $description, $defaultValue = false, $type = false) {
        $key = trim($key);
        $name = trim($name);
        $tabName = trim($tabName);
        $description = trim($description);

        if (!$key) {
            throw new ServiceUtils_Exception();
        }
        if (!$name) {
            throw new ServiceUtils_Exception();
        }
        if (!$tabName) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            $setting = new XShopSettings();
            $setting->setKey($key);
            if ($setting->select()) {
                // обновляем
                $setting->setName($name);
                $setting->setTabname($tabName);
                $setting->setDescription($description);
                $setting->setType($type);
                // value пропускаем специально
                $setting->update();
            } else {
                // добавляем
                $setting->setName($name);
                $setting->setTabname($tabName);
                $setting->setDescription($description);
                $setting->setType($type);
                $setting->setValue($defaultValue);
                $setting->insert();
            }

            SQLObject::TransactionCommit();

            // сброс кеша
            $this->_settingsArray = 0;
            try {
                Engine::GetCache()->removeData('setting-keys');
            } catch (Exception $ecache) {

            }
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Удалить setting полностью
     *
     * @param string $key
     */
    public function deleteSetting($key) {
        try {
            SQLObject::TransactionStart();

            $x = new XShopSettings();
            $x->setKey($key);
            if ($x->select()) {
                $x->delete();
            }

            SQLObject::TransactionCommit();

            // сброс кеша
            $this->_settingsArray = 0;

            try {
                Engine::GetCache()->removeData('setting-keys');
            } catch (Exception $ecache) {

            }
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    private $_settingsArray = 0;

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_SettingsService
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
     * @var Shop_SettingsService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}