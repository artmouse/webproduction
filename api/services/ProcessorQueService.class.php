<?php
/**
 * ProcessorQueService отвечает за формирование и обработку очереди отложенных процессоров.
 * Эта очередь обрабатывается по cron-minute, в нее можно дописать любой класс один раз,
 * и он будет запущен в отложенном режиме.
 *
 * Delayed Processor Que.
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Package
 */
class ProcessorQueService {

    /**
     * Добавить обработчик в очередь.
     * Параметр $unique отвечает за то - проверять чтобы были дубликаты в очереди или нет.
     * С $unique = true дубликатов в очереди не будет.
     *
     * @param string $eventName
     * @param bool $unique
     */
    public function addProcessor($eventName, $unique = true) {
        if (!$eventName) {
            throw new ServiceUtils_Exception();
        }

        try {
            $que = new XShopProcessorQue();
            $que->setLogicclass($eventName);
            if ($unique) {
                if (!$que->select()) {
                    $que->insert();
                }
            } else {
                $que->insert();
            }
        } catch (Exception $ge) {
            // nothing todo if error
        }
    }

    /**
     * Запустить обработку отложенной очереди процессоров.
     * Из очереди достается процессор в ASC-порядке, выполняется,
     * затем удаляется.
     *
     * Если очередь становится пустой - дополнительно делается truncate,
     * чтобы не закончились IDшники.
     */
    public function processQue() {
        ModeService::Get()->verbose('Process ProcessorQue...');

        $flagTruncate = false;

        $que = new XShopProcessorQue();
        $que->setOrder('id', 'ASC');
        while ($x = $que->getNext()) {
            $flagTruncate = true;

            $classname = $x->getLogicclass();

            if (!$classname) {
                ModeService::Get()->debug('Empty processor classname in ProcessorQue');

                // удаляем объект
                $x->delete();

                continue;
            }

            if (!class_exists($classname)) {
                ModeService::Get()->debug('Invalid processor classname "'.$classname.'" in ProcessorQue');

                // удаляем объект
                $x->delete();

                continue;
            }

            // запускаем и обрабатываем
            ModeService::Get()->verbose('Run processor "'.$classname.'" in ProcessorQue...');
            $object = new $classname();

            if (!method_exists($object, 'process')) {
                ModeService::Get()->debug('Invalid processor method "'.$classname.'"::process() in ProcessorQue');

                // удаляем объект
                $x->delete();

                continue;
            }

            // удаляем объект
            $x->delete();

            $object->process();
            
        }

        // пытаемся очистить таблицу
        if ($flagTruncate) {
            try {
                SQLObject::TransactionStart();

                $que = new XShopProcessorQue();
                if (!$que->getCount()) {
                    ModeService::Get()->verbose('Trying to truncate ProcessorQue...');
                    $que->getConnectionDatabase()->query("TRUNCATE ".$que->getTablename());
                }

                SQLObject::TransactionCommit();
            } catch (Exception $ge) {
                SQLObject::TransactionRollback();
                print $ge;
            }
        }
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return ProcessorQueService
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