<?php
/**
 * Сервис, отвечающий за работу с баннерами.
 *
 * @copyright WebProduction
 * @package   OneBox
 */

class Shop_BannerService extends ServiceUtils_AbstractService {

    /**
     * Получить все банера
     *
     * @return ShopBanner
     */
    public function getBannerAll() {
        try {
            $banner = $this->getObjectsAll('ShopBanner');
            $banner->setOrder('sort', 'ASC');
            return  $banner;
        } catch (Exception $e) {

        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить баннер по id
     *
     * @return ShopBanner
     */
    public function getBannerByID($id) {
        try {
            return $this->getObjectByID($id, 'ShopBanner');
        } catch (Exception $e) {
            if (PackageLoader::Get()->getMode('debug')) {
                print $e;
            }
        }
        throw new ServiceUtils_Exception('Shop-object by id not found');
    }

    /**
     * Получить доступные баннера для заданного места.
     * На выходе строковый массив
     *
     * @param string $place
     *
     * @return array
     */
    public function getBanners($place = false) {
        if ($this->_bannerArray === false) {
            $this->_bannerArray = array();
            $banners = $this->getBannerAll();
            $banners->setHidden(0);

            $now = DateTime_Object::Now();
            $banners->addWhereQuery(
                '(`sdate`="0000-00-00 00:00:00" OR `sdate` <= "'.$now.'") AND (`edate`="0000-00-00 00:00:00"
                OR `edate` >= "'.$now.'")'
            );

            $banners->setOrder(array('sort', 'id'), 'ASC');

            while ($x = $banners->getNext()) {
                $this->_bannerArray[] = $x;
            }
        }

        $a = array();
        $url = Engine::Get()->GetURLParser()->getCurrentURL();

        foreach ($this->_bannerArray as $x) {
            if ($place && $x->getPlace() == $place) {
                if ($x->getCategoryid()) {
                    $categoryurl = '/';
                    $categoryurl .= Shop::Get()->getShopService()->getCategoryByID($x->getCategoryid())->getUrl();
                    $categoryurl .= '/';
                    if ($categoryurl == '//') {
                        $categoryurl = '/category/'.$x->getCategoryid().'/';
                    }
                    if ($url == $categoryurl) {
                        $a[] = $x->makeInfoArray();
                        continue;
                    } else {
                        continue;
                    }
                }

                $a[] = $x->makeInfoArray();
            } elseif (!$place) {
                $a[] = $x->makeInfoArray();
            }
        }
        return $a;
    }

    /**
     * Сохранить клик по баннеру
     *
     * @param ShopBanner $banner
     */
    public function clickBanner(ShopBanner $banner) {
        try {
            SQLObject::TransactionStart();

            $view = new XShopBannerStatistics();
            $view->setSessionid($this->_getSessionID());
            $view->setIp(@$_SERVER['REMOTE_ADDR']);
            try {
                $user = Shop::Get()->getUserService()->getUser();
                $view->setUserid($user->getId());
            } catch (Exception $e) {
                if (PackageLoader::Get()->getMode('debug')) {
                    print $e;
                }
            }
            $view->setCdate(date('Y-m-d H:i:s'));
            $view->setBannerid($banner->getId());
            $view->insert();

            SQLObject::TransactionCommit();
        } catch (Exception $ge) {
            SQLObject::TransactionRollback();
            throw $ge;
        }
    }

    /**
     * Получить идентификатор сесии
     * с проверкой его состояния
     *
     * @return string
     */
    private function _getSessionID() {
        if (!session_id()) {
            @session_start();
        }

        $sid = @session_id();
        if (!$sid) {
            throw new ServiceUtils_Exception('empty SessionID!');
        }
        return $sid;
    }

    private $_bannerArray = false;

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_BannerService
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
     * @var Shop_BannerService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

    /**
     * Кеш баннеров
     *
     * @var array
     */
}