<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package Shop
 */
class Shop_CacheHandler implements Storage_IHandler {

    public function __construct() {
        // чистка старого кеша,
        // только ночью
        if (rand(1, 100) == 1
        && date('g') <= 6
        ) {
            $cache = new XShopCache();
            $cache->addWhere('edate', date('Y-m-d H:i:s'), '<');
            $cache->addWhere('edate', '0000-00-00 00:00:00', '!=');
            $cache->delete(true);
        }
    }

    /**
     * Записать данные в хранилище.
     * TTL поддерживается.
     * ParentKey не поддерживается.
     *
     * @param string $key Ключ
     * @param string $parentKey Родительский ключ
     * @param mixed $value Полный путь к файлу
     * @param int $ttl
     */
    public function set($key, $value, $ttl = false, $parentKey = false) {
        if ($parentKey) {
            throw new Storage_Exception("ParentKey not supported for this handler");
        }

        $cacheObject = new XShopCache();
        $cacheObject->setKey($key);
        if ($cacheObject->select()) {
            if ($ttl) {
                $cacheObject->setEdate(DateTime_Object::Now()->addSeconds($ttl)->__toString());
            }
            $cacheObject->setData($value);
            $cacheObject->update();
        } else {
            $cacheObject->setCdate(date('Y-m-d H:i:s'));
            if ($ttl) {
                $cacheObject->setEdate(DateTime_Object::Now()->addSeconds($ttl)->__toString());
            }
            $cacheObject->setData($value);
            $cacheObject->insert();
        }
    }

    /**
     * Получить полный путь к файлу
     * по его ключу
     *
     * @param string $key
     */
    public function get($key) {
        $cacheObject = new XShopCache();
        $cacheObject->setKey($key);
        if ($cacheObject->select()) {
            if ($cacheObject->getEdate() == '0000-00-00 00:00:00'
            || $cacheObject->getEdate() >= date('Y-m-d H:i:s')
            ) {
                return $cacheObject->getData();
            }
        }
        throw new Storage_Exception("Data not found in storage by key '{$key}'");
    }

    /**
     * Узнать, есть ли такой ключ
     *
     * @param string $key
     * @return bool
     */
    public function has($key) {
        $cacheObject = new XShopCache();
        $cacheObject->setKey($key);
        if ($cacheObject->select()) {
            if ($cacheObject->getEdate() == '0000-00-00 00:00:00'
            || $cacheObject->getEdate() >= date('Y-m-d H:i:s')
            ) {
                return true;
            }
        }
        return false;
    }

    /**
     * Удалить данные по ключу
     *
     * @param string $key
     */
    public function remove($key) {
        $cache = new XShopCache();
        $cache->setKey($key);
        $cache->delete(true);
    }

    /**
     * Очистить все хранилище.
     */
    public function clean() {
        $connection = $this->_getConnection();
        $connection->query("TRUNCATE shopcache");
    }

    /**
     * @return ConnectionManager_IDatabaseAdapter
     */
    private function _getConnection() {
        return ConnectionManager::Get()->getConnectionDatabase();
    }

}