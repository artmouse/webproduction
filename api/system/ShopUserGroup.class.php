<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * Группа контактов
 */
class ShopUserGroup extends XShopUserGroup {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующую группу
     *
     * @return ShopUserGroup
     */
    public function getNext($exception = false) {
        $exception = $exception;
        return parent::getNext($exception);
    }

    /**
     * Получить объект
     *
     * @return ShopUserGroup
     */
    public static function Get($key) {
        return self::GetObject('ShopUserGroup', $key);
    }

    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    public function makeNamePath($separator = ' > ') {
        $a = array();
        $x = clone $this;

        while (1) {
            try {
                $a[$x->getId()] = $x->getName();
                $x = $x->getParent();
                if (isset($a[$x->getId()])) {
                    break;
                }
            } catch (Exception $e) {
                break;
            }
        }

        $a = array_reverse($a);
        return implode($separator, $a);
    }
    /**
     * Получить родительскую группу
     *
     * @return ShopUserGroup
     */
    public function getParent() {
        return Shop::Get()->getUserService()->getUserGroupByID(
            $this->getParentid()
        );
    }

}