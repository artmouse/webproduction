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
 * Сервис управления блоками OneBox
 *
 * @author Egor Gerasimchuk <milhous@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_BlockService extends ServiceUtils_AbstractService {

    /**
     * Получить все блоки
     *
     * @return ShopBlock
     */
    public function getBlocksAll() {
        $x = new ShopBlock();
        return $x;
    }

    /**
     * Получить блок по ID
     *
     * @param $id
     *
     * @return ShopBlock
     * @throws ServiceUtils_Exception
     */
    public function getBlockByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopBlock');
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('ShopBlock by id not found');
    }

    /**
     * Получить все активные блоки
     *
     * @return ShopBlock
     */
    public function getBlocksActive() {
        $x = $this->getBlocksAll();
        $x->setActive(1);
        return $x;
    }

    /**
     * Зарегистрировать блок (добавить и или обновить)
     *
     * @param string $name
     * @param string $contentID
     * @param string $position Точка в системе, куда нужно вставлять блок
     * @param int $positionSort
     */
    public function addBlock($name, $contentID, $position = false, $positionSort = 0) {
        if (!$name || !$contentID) {
            throw new ServiceUtils_Exception();
        }

        try {
            SQLObject::TransactionStart();

            $block = new XShopBlock();
            $block->setContentid($contentID);
            if (!$block->select()) {
                $block->setActive(1);
                $block->setName($name);
                $block->insert();
            }

            if ($position) {
                // если позиции нет - ставим
                if (!$block->getPosition()) {
                    $block->setPosition($position);
                    $block->setPositionsort($positionSort);
                    $block->update();
                }
            } elseif ($block->getPosition()) {
                $block->setPosition(false);
                $block->update();
            }

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
    * Получить блок по его ContentId
    *
    * @param string $contentID
    */
    public function getBlockByContentId($contentID) {
        if (!$contentID) {
            throw new ServiceUtils_Exception();
        }
        try {
            $block = $this->getBlocksAll();
            $block->setContentid($contentID);
            if ($x = $block->getNext(true)) {
                return $x;
            }            
        } catch (Exception $ge) {
            throw $ge;
        }
    }
    
    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_BlockService
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
     * @var Shop_BlockService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}