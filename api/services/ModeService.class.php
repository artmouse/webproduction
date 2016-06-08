<?php
/**
 * Сервис, отвечающий за режимы работы OneBox,
 * и помогаютщий отлаживать систему (debug)
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   OneBox
 */
class ModeService {

    /**
     * Узнать включен ли режим работы $modeName
     *
     * @param string $modeName
     *
     * @return bool
     */
    public function getMode($modeName) {
        return PackageLoader::Get()->getMode($modeName);
    }

    /**
     * Задать (включить) режим работы.
     *
     * Включать режимы debug, development, build, verbose
     * можно ТОЛЬКО для localhost (для всех)
     * или ТОЛЬКО для заданного юзера или IP.
     *
     * @param string $modeName
     * @param strong $loginOrIP
     */
    public function setMode($modeName, $loginOrIP = false) {
        PackageLoader::Get()->setMode($modeName, true, $loginOrIP);
    }

    /**
     * Вывести данные для режима build
     *
     * @param string $data
     */
    public function build($data) {
        $this->prints($data, 'build');
    }

    /**
     * Вывести данные для режима verbose
     *
     * @param string $data
     */
    public function verbose($data) {
        $this->prints($data, 'verbose');
    }

    /**
     * Вывести данные для режима debug
     *
     * @param string $data
     */
    public function debug($data) {
        $this->prints($data, 'debug');
    }

    /**
     * Вывести данные для режима check
     *
     * @param string $data
     */
    public function check($data) {
        $this->prints($data, 'check');
    }

    /**
     * Универсальный print в зависимости от работы движка
     *
     * @param mixed $data
     * @param string $modeName
     */
    public function prints($data, $modeName) {
        $print = false;
        if (!$modeName) {
            $print = true;
        } elseif ($this->getMode($modeName)) {
            $print = true;
        }

        if (!$print) {
            return;
        }

        if ($modeName) {
            echo $modeName.': ';
        }

        if (is_bool($data) || !$data) {
            var_dump($data);
            echo "\n";
            return;
        }

        if ($data instanceof SQLObject) {
            print $data->__toString()."\n";
            print_r($data->getValues());
            echo "\n";
            return;
        }

        if (is_object($data)) {
            print_r($data);
            echo "\n";
            return;
        }

        if (is_array($data)) {
            print_r($data);
            echo "\n";
            return;
        }

        if (is_int($data)) {
            var_dump($data);
        }

        print $data;
        echo "\n";
    }

    /**
     * Автоматически включить режимы по аргументам командной строки
     * или по массиву GET, если они там есть.
     *
     * Инструкция по режимам:
     * https://box.webproduction.ua/doc/onebox-mode
     */
    public function autoEnableModes() {
        global $argv;

        // режимы для проверки
        $modeArray = array();
        $modeArray[] = 'build';
        $modeArray[] = 'build-acl';
        $modeArray[] = 'build-scss';
        $modeArray[] = 'debug';
        $modeArray[] = 'xdebug';
        $modeArray[] = 'check';
        $modeArray[] = 'verbose';
        $modeArray[] = 'no-cache';
        $modeArray[] = 'force';

        // проверяем аргументы командной строки
        if (!empty($argv)) {
            foreach ($argv as $x) {
                if (in_array($x, $modeArray)) {
                    $this->setMode($x);
                }
            }
        }

        // проверяем массив get
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return ModeService
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
     * @var ModeService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;


}