<?php
/**
 * Сервис отвечает за генерацию форм в системе.
 *
 * @author Igor Ustimenko <max@webproduction.ua>
 * 
 * @copyright FormSettingsService
 * 
 * @package OneBox
 */
class FormSettingsService {

    /**
     * Получить все формы
     *
     * @return XShopFormsSettings
     */
    public function getFormSettingsAll() {
        $x = new XShopFormsSettings();
        return $x;
    }

    /**
     * Получить форму по id
     *
     * @param int $formID
     *
     * @return XShopFormsSettings
     */
    public function getFormSettingsByID($formID) {
        $form = new XShopFormsSettings($formID);
        if ($form->getId()) {
            return $form;
        }
        throw new ServiceUtils_Exception();
    }

    /**
     * Получить поля формы по id
     *
     * @param int $formID
     *
     * @return XShopFormsSettingsItem
     */
    public function getFormItemsByIdForm($formID) {
        $field = new XShopFormsSettingsItem();
        $field->setFormid($formID);
        return $field;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return XShopFormsSettings
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
     * @var ShopFormsSettings
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}