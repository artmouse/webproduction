<?php
class Shop_NovaPoshtaApiService extends ServiceUtils_AbstractService {

    /**
     * Получить все города
     *
     * @return array
     */
    public function getCityAll() {
        $key = $this->getKey();
        if (!$key) {
            return 'key API empty';
        }
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<file>';
        $xml .= '<auth>'.$key.'</auth>';
        $xml .= '<citywarehouses/>';
        $xml .= '</file>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://orders.novaposhta.ua/xml.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($response);

        //заходим на необходимые поиции внутри xml
        $responseArray = $xml->xpath('result/cities/city');

        $resultArray = array();

        //формируем массивы данных из XML
        foreach ($responseArray as $city) {
            $resultArray[] = (string) $city->{'nameRu'};
        }

        sort($resultArray);

        return $resultArray;
    }

    /**
     * Получить все отделения Города
     *
     * @param $city
     *
     * @return array
     */
    public function getOfficesByCity ($city) {
        $key = $this->getKey();
        if (!$key) {
            return 'key API empty';
        }
        $xml = '<?xml version="1.0" encoding="utf-8"?>';
        $xml .= '<file>';
        $xml .= '<auth>'.$key.'</auth>';
        $xml .= '<warenhouse/>';
        if ($city) {
            $xml .= '<filter>'.$city.'</filter>';
        }
        $xml .= '</file>';

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, 'http://orders.novaposhta.ua/xml.php');
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array("Content-Type: text/xml"));
        curl_setopt($ch, CURLOPT_HEADER, 0);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $xml);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        $response = curl_exec($ch);
        curl_close($ch);

        $xml = simplexml_load_string($response);

        //заходим на необходимые поиции внутри xml
        $responseArray = $xml->xpath('result/whs/warenhouse');

        $resultArray = array();

        //формируем массивы данных из XML
        foreach ($responseArray as $city) {
            $resultArray[] = (string) $city->{'addressRu'};
        }

        return $resultArray;
    }

    /**
     * Получить key API
     * @return mixed
     */
    public function getKey() {
        return Shop::Get()->getSettingsService()->getSettingValue('api-key-novaposhta');
    }

    /**
     * Получить сервис.
     * Сервис можно подменивать через метод ::Set()
     *
     * @return Shop_NovaPoshtaApiService
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
     * @var Shop_NovaPoshtaApiService
     */
    private static $_Instance = null;

    /**
     * Подменяемое имя класса
     *
     * @var string
     */
    private static $_Classname = false;

}