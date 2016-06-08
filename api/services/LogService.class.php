<?php

class LogService {

    /**
     * Добавить запись в лог.
     * $data - в качестве данных можно передавать строку, число, объект или массив.
     * $filePrefix - префикс файла, в который писать данные.
     *
     * @param mixed $data
     * @param string $filePrefix
     */
    public function add($data = false, $filePrefix = false) {
        $date = date("Y-m-d");

        $log = '';
        $log .= '['.date("Y-m-d H:i:s")."]\n";
        $log .= 'host: '.Engine::GetURLParser()->getHost()."\n";
        $log .= 'url: '.Engine::GetURLParser()->getCurrentURL()."\n";
        $log .= 'contentID: '.Engine::Get()->getRequest()->getContentID()."\n";
        $log .= 'point: '.$_SERVER['PHP_SELF']."\n";

        if ($data) {
            $log .= 'data: ';
        }
        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $log .= $key.'='.$value."\n";
            }
        } elseif (is_object($data)) {
            $log .= print_r($data, true);
        } else {
            $log .= $data;
        }
        $log .= "\n\n";

        if ($filePrefix) {
            $filePrefix .= '-';
        }

        // пишем в файл
        $fp = fopen(PackageLoader::Get()->getProjectPath().'/log/'.$filePrefix.$date.'.log', 'a+');
        fwrite($fp, $log);
        fclose($fp);
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return LogService
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