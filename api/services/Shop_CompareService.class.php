<?php
/**
 * Сервис сравнения
 *
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_CompareService extends ServiceUtils_AbstractService {

    public function __construct() {
        // чистка корзины сравнений
        if (rand(1, 100) == 1) {
            $x = new ShopCompare();
            $x->addWhere('cdate', DateTime_Object::Now()->addDay(-1)->__toString(), '<');
            while ($y = $x->getNext()) {
                $y->delete();
            }
        }
    }

    /**
     * Получить корзину сравнения по ID
     *
     * @param int $compareID
     *
     * @return ShopCompare
     */
    public function getCompareByID($compareID) {
        $x = new ShopCompare($compareID);
        if (!$x->getId()) {
            throw new ServiceUtils_Exception('incorrectCompareID');
        }
        return $x;
    }

    /**
     * Получить идентификатор сесии
     * с проверкой его состояния
     *
     * @return string
     */
    private function _getSessionID() {
        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }

    /**
     * Получить все сожержимое корзины
     * для текущего пользователя
     *
     * @return ShopCompare
     */
    public function getCompareProducts() {
        $x = new ShopCompare();
        if (!session_id()) {
            @session_start();
        }
        $x->setSid($this->_getSessionID());
        return $x;
    }

    /**
     * Добавить товар в корзину
     *
     * @return ShopCompare
     */
    public function addToCompare($productID) {
        try {
            SQLObject::TransactionStart();

            $product = Shop::Get()->getShopService()->getProductByID($productID);

            $x = new ShopCompare();

            // session basket
            @session_start();
            $x->setSid($this->_getSessionID());

            // product
            $x->setProductid($productID);

            if (!$x->select()) {
                $x->setCdate(date('Y-m-d H:i:s'));
                $x->insert();
            }

            SQLObject::TransactionCommit();

            // возвращаем элемент корзины
            return $x;
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * удалить товар с корзины
     *
     * @param int $productID
     */
    public function deleteFromCompare($productID) {
        try {
            SQLObject::TransactionStart();

            $compare = new ShopCompare();
            @session_start();
            $compare->setSid($this->_getSessionID());
            $compare->setProductid($productID);
            if ($compare->select()) {
                $compare->delete();
            }

            SQLObject::TransactionCommit();

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Очистить корзину
     */
    public function clearCompare() {
        try {
            SQLObject::TransactionStart();

            $basket = $this->getCompareProducts();
            while ($x = $basket->getNext()) {
                $x->delete();
            }

            SQLObject::TransactionCommit();

        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_CompareService
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
     * @var Shop_CompareService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}