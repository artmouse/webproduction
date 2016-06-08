<?php
/**
 * HistoryService отвечает за логгирование и обработку всего, что просиходит
 * внутри OneBox.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Package
 */
class HistoryService {

    /**
     * Записать лог происходящего в историю hour.
     * Позже она перенесется в основную историю.
     */
    public function addHistoryLog() {
        $history = new XShopHistoryHour();

        try {
            $history->setUserid(Shop::Get()->getUserService()->getUser()->getId());
        } catch (Exception $userEx) {

        }

        $history->setCdate(date('Y-m-d H:i:s'));
        $history->setUrl(Engine::GetURLParser()->getTotalURL());
        $history->setIp(@$_SERVER['REMOTE_ADDR']);

        $post = '';
        $a = Engine::GetURLParser()->getArguments();
        foreach ($a as $key => $value) {
            if (is_array($value)) {
                foreach ($value as $v) {
                    @$post .= $key.'='.$v."\n";
                }
            } else {
                $post .= $key.'='.$value."\n";
            }
        }

        $history->setPost($post);
        $history->insert();
    }

    /**
     * Перенести history log из hour в основную таблицу
     */
    public function processHistoryLog() {
        ModeService::Get()->verbose('process HistoryLog...');

        $history = new XShopHistory();
        $historyHour = new XShopHistoryHour();

        $connection = ConnectionManager::Get()->getConnectionMySQL();

        try {
            SQLObject::TransactionStart();

            // перемещаем данные
            $query = "INSERT INTO {$history->getTablename()} (userid, cdate, url, ip, post)
            SELECT userid, cdate, url, ip, post FROM {$historyHour->getTablename()}";
            $connection->query($query);

            // удаляем данные
            $connection->query("TRUNCATE ".$historyHour->getTablename());

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
        }
    }

    /**
     * Отметить товар как +1 к просмотренным.
     * Запись пишется во временную таблицу. Позже она перенесется в основную историю.
     *
     * @param ShopProduct $product
     */
    public function viewProduct(ShopProduct $product, $user = false) {
        $view = new XShopProductViewHour();
        $view->setSessionid(@session_id());
        $view->setIp(@$_SERVER['REMOTE_ADDR']);

        if ($user) {
            $view->setUserid($user->getId());
        } else {
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $view->setUserid($user->getId());
            } catch (Exception $e) {

            }
        }

        $view->setCdate(date('Y-m-d H:i:s'));
        $view->setProductid($product->getId());
        $view->insert();
    }

    /**
     * Перенести product view из hour в основную таблицу
     */
    public function processProductView() {
        ModeService::Get()->verbose('process ProductView...');

        $history = new XShopProductView();
        $historyHour = new XShopProductViewHour();

        $connection = ConnectionManager::Get()->getConnectionMySQL();

        try {
            SQLObject::TransactionStart();

            // перемещаем данные
            $query = "INSERT INTO {$history->getTablename()} (sessionid, ip, userid, cdate, productid)
            SELECT sessionid, ip, userid, cdate, productid FROM {$historyHour->getTablename()}";
            $connection->query($query);

            // удаляем данные
            $connection->query("TRUNCATE ".$historyHour->getTablename());

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return HistoryService
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
     * @var SEOService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}