<?php
/**
 * Сервис по работе с прайс-площадками
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class PricePlaceService {

    public function processExports() {
        ModeService::Get()->verbose('Process exports to price-places...');

        $pps = new XShopExportPlace();
        while ($pp = $pps->getNext()) {
            try {
                $categoryArray = array();
                $productsArray = array();

                $links = new XShopExportPlaceCategory();
                $links->setPlaceid($pp->getId());
                while ($x = $links->getNext()) {
                    if ($x->getCategoryid()) {
                        $categoryArray[] = $x->getCategoryid();
                    } elseif ($x->getProductid()) {
                        try {
                            $productID = $x->getProductid();
                            $product = Shop::Get()->getShopService()->getProductByID($productID);
                            if (!$product->getHidden() && !$product->getDeleted()) {
                                $productsArray[] = $productID;
                            }
                        } catch (Exception $productEx) {


                        }
                    }
                }

                if (!$categoryArray && !$productsArray) {
                    continue;
                }

                $class = $pp->getLogicclass();
                $exporter = new $class();
                $xml = $exporter->process($categoryArray, $productsArray);

                file_put_contents(
                    PackageLoader::Get()->getProjectPath().'/media/export/'.$pp->getId().'.xml',
                    $xml,
                    LOCK_EX
                );
            } catch (Exception $ge) {
                print $ge;
            }
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return PricePlaceService
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
     * @var PricePlaceService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}