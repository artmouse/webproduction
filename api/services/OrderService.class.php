<?php
/**
 * OrderService отвечает за работу с заказами
 *
 * @author    i.ustimenko <i.ustimenko@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class OrderService extends ServiceUtils_AbstractService {

    /**
     * Получить все объекты ShopOrder
     *
     * @param bool $deleted
     *
     * @return ShopOrder
     */
    public function getOrdersAll($deleted = false) {
        $x = new ShopOrder();
        $x->setDeleted((int) $deleted);
        return $x;
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return OrderService
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
     * @var OrderService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}