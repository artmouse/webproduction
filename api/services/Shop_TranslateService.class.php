<?php

class Shop_TranslateService extends ServiceUtils_AbstractService {

    /**
     * Подгрузить все переводы.
     * Метод срабатывает один раз, подгружая переводы через события
     * beforeTranslateLoad и afterTranslateLoad
     */
    private function _load() {
        if (!$this->_loaded) {
            // бросам событие для подключения контентов
            $event = Events::Get()->generateEvent('beforeTranslateLoad');
            $event->notify();

            $event = Events::Get()->generateEvent('afterTranslateLoad');
            $event->notify();

            $this->_loaded = true;
        }
    }

    /**
     * Получить перевод
     *
     * @param $key
     *
     * @return string
     * @throws Forms_Exception
     */
    public function getTranslate($key) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }

        $this->_load();

        $key = str_replace('-', '_', $key);

        if (isset($this->_translateArray[$key])) {
            return $this->_translateArray[$key];
        }
        throw new Forms_Exception("Empty value for key '{$key}'");
    }

    /**
     * Получить перевод (безопастно)
     *
     * @param $key
     *
     * @return string
     */
    public function getTranslateSecure($key) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }

        $this->_load();

        $key = str_replace('-', '_', $key);

        if (isset($this->_translateArray[$key])) {
            return $this->_translateArray[$key];
        }

        return $key;
    }

    /**
     * Задать переменную перевода
     *
     * @param $key
     * @param $value
     *
     * @throws Forms_Exception
     */
    public function setTranslate($key, $value) {
        if (!$key) {
            throw new Forms_Exception("Empty key");
        }
        $this->_translateArray[$key] = trim($value);
    }

    /**
     * Задать переменные массивом.
     * Метод быстрее, так как использует array merge или прямую замену
     *
     * @param $translateArray
     */
    public function setTranslateArray($translateArray) {
        if (!$this->_translateArray) {
            $this->_translateArray = $translateArray;
        } else {
            $this->_translateArray = array_merge($this->_translateArray, $translateArray);
        }
    }

    /**
     * Получить все переводы
     * (массив в формате key-value)
     *
     * @return array
     */
    public function getTranslateArray () {
        $this->_load();

        return $this->_translateArray;
    }

    /**
     * Добавить переводов в систему
     *
     * @param array $a
     */
    public function addTranslateArray($a) {
        if (!$a) {
            throw new Forms_Exception('Empty translate array');
        }

        $this->_translateArray = array_merge($this->_translateArray, $a);
    }

    /**
     * Добавить переводов из XML-файла
     *
     * @param string $file
     *
     * @deprecated see addTranslateFromPHP()
     */
    public function addTranslateFromXML($file) {
        $data = file_get_contents($file);
        $xml = (array) simplexml_load_string($data);

        foreach ($xml as $key => $value) {
            $key = trim($key.'');

            if (is_array($value)) {
                // issue #42291 - array bugfix
                $this->setTranslate($key, $value[0].'');
            } else {
                $this->setTranslate($key, $value.'');
            }
        }
    }

    /**
     * Добавить переводов из PHP-файла
     *
     * @param string $file
     */
    public function addTranslateFromPHP($file) {
        include_once($file);
        if (empty($translateArray)) {
            throw new Exception('No translates in php file');
        }
        $this->setTranslateArray($translateArray);
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_TranslateService
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
     * @var Shop_TranslateService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

    private $_translateArray = array();

    private $_loaded = false;

}