<?php
/**
 * WebProduction Packages
 *
 * @copyright (C) 2007-2014 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * Источник контент-данных для Engine.
 * Хранит в себе набор всех конентов, с которыми работает
 * Engine_ContentDriver
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Engine
 */
class Engine_ContentDataSource {

    /**
     * Получить все данные
     *
     * @return array
     */
    public function getData() {
        $this->_loadContents();

        return $this->_data;
    }

    /**
     * Получить все поля контента по его ID.
     * ID - это строковый contentID.
     *
     * @param string $id
     *
     * @return Engine_ContentDataArray
     */
    public function getDataByID($id) {
        $this->_loadContents();

        if (!empty($this->_data[$id])) {
            return $this->_data[$id];
        }
        return false;
    }

    /**
     * Возвращает зачение поля контента
     *
     * @param string $id
     * @param string $key
     *
     * @return mixed
     */
    public function getDataValueByID($id, $key) {
        $data = $this->getDataByID($id);
        return @$data[$key];
    }

    /**
     * Зарегистрировать контент в системе.
     * Метод вернет заполненные поля контента.
     *
     * @param int $id
     * @param array $fieldsArray Набор полей
     *
     * @return Engine_ContentDataArray
     */
    public function registerContent($id, $fieldsArray, $registerMethod = 'override') {
        $level = @trim($fieldsArray['level'].'');

        $argumentsArray = @$fieldsArray['arguments'];
        if (!$argumentsArray) {
            $argumentsArray = array();
        }

        // автоматически определяем fileclass контента
        $fileClass = trim(@$fieldsArray['fileclass'].'');
        $filePHP = trim(@$fieldsArray['filephp'].'');
        if (!$fileClass && $filePHP) {
            $fileClass = basename($filePHP, '.php');
        }
        if (!$fileClass) {
            $fileClass = Engine::Get()->getContentClass();
        }

        $fileHTML = trim(@$fieldsArray['filehtml'].'');

        $fileCSSArray = @$fieldsArray['filecss'];
        if (!$fileCSSArray) {
            $fileCSSArray = array();
        } else {
            $fileCSSArray = (array) $fileCSSArray;
        }

        $fileJSArray = @$fieldsArray['filejs'];
        if (!$fileJSArray) {
            $fileJSArray = array();
        } else {
            $fileJSArray = (array) $fileJSArray;
        }

        $data = array(
            'id' => $id,
            'title' => trim(@$fieldsArray['title'].''), // заголовок страницы
            'url' => @$fieldsArray['url'], // URLы контента
            'filehtml' => $fileHTML, // html-отображение
            'filephp' => $filePHP, // php-файл
            'fileclass' => $fileClass, // php-класс в этом файле (extends @see Engine_Content)
            'filecss' => $fileCSSArray, // css-файлы
            'filecssremove' => @$fieldsArray['filecssremove'], // удалять ли css при extend'e
            'filejs' => $fileJSArray, // js-файлы
            'filejsremove' => @$fieldsArray['filejsremove'], // удалять ли js при extend'e
            'moveto' => trim(@$fieldsArray['moveto'].''), // в какой контент отправлять
            'moveas' => trim(@$fieldsArray['moveas'].''), // в какую переменную контента отправлять
            'level' => $level, // уровень доступа (минимальный)
            'role' => @$fieldsArray['role'], // ролевая привелегия
            'arguments' => $argumentsArray, // массив обязательных аргументов
            'cache' => @$fieldsArray['cache'], // настройки кеширования
        );

        if ($registerMethod == 'override' || ($registerMethod == 'extend' && !@$this->_data[$id])) {
            $this->_data[$id] = $data;
        } elseif ($registerMethod == 'extend') {
            // расширение свойств объекта
            $currentData = @$this->_data[$id];

            if ($data['filecssremove']) {
                $currentData['filecss'] = array();
            }

            if ($data['filejsremove']) {
                $currentData['filejs'] = array();
            }

            if ($data['filephp']) {
                $currentData['filephp'] = $data['filephp'];

                if ($data['fileclass']) {
                    $currentData['fileclass'] = $data['fileclass'];
                }
            }
            if ($data['filehtml']) {
                $currentData['filehtml'] = $data['filehtml'];
            }
            if ($data['moveas']) {
                $currentData['moveas'] = $data['moveas'];
            }
            if ($data['moveto']) {
                $currentData['moveto'] = $data['moveto'];
            }
            if ($data['url']) {
                $currentData['url'] = $data['url'];
            }
            if ($data['title']) {
                $currentData['title'] = $data['title'];
            }
            if ($data['level']) {
                $currentData['level'] = $data['level'];
            }
            if ($data['arguments']) {
                $currentData['arguments'] = $data['arguments'];
            }
            if ($data['filecss']) {
                foreach ($data['filecss'] as $x) {
                    $currentData['filecss'][] = $x;
                }
            }
            if ($data['filejs']) {
                foreach ($data['filejs'] as $x) {
                    $currentData['filejs'][] = $x;
                }
            }
            if (!empty($data['argument'])) {
                foreach ($data['argument'] as $x) {
                    $currentData['argument'][] = $x;
                }
            }
            if ($data['cache']) {
                $currentData['cache'] = $data['cache'];
            }

            $this->_data[$id] = $currentData;
        } else {
            throw new Engine_Exception('Unknown register content method "'.$registerMethod.'"');
        }
        return $this->_data[$id];
    }

    /**
     * Зарегистрировать все контенты, которые есть в XML-данных.
     * Метод вернет массив всех зарегистрированных контентов
     *
     * @param string $xmldata
     * @param string $contentPath
     *
     * @return array
     *
     * @deprecated see registerContent()
     */
    public function registerContentsFromXML($xmldata, $contentPath = false) {
        if (!is_dir($contentPath)) {
            throw new Engine_Exception(
                "Content path '{$contentPath}' not found or is not directory"
            );
        }

        $xmldata = @simplexml_load_string($xmldata);

        // проверяем данные на корректность
        if (!$xmldata) {
            throw new Engine_Exception('Cannot parse XML data: invalid XML data');
        }

        $serData = array();
        foreach ($xmldata->content as $d) {
            if (trim($d->arguments.'')) {
                $args = explode(',', trim($d->arguments.''));
            } else {
                $args = array();
            }

            $id = trim($d['id'].'');

            // метод регистрации контента
            $register = trim($d['register'].'');
            if (!$register) {
                $register = 'override';
            }

            $role = trim($d->role.'');
            if ($role) {
                $role = explode(',', $role);
            } else {
                $role = array();
            }

            $urlsArray = array();
            foreach ($d->url as $url) {
                $urlsArray[] = trim($url.'');
            }
            if (count($urlsArray) == 1) {
                $urlsArray = $urlsArray[0];
            }

            $cssArray = array();
            foreach ($d->filecss as $css) {
                $css = trim($css.'');
                if (!$css) {
                    continue;
                }

                $cssArray[] = $contentPath.$css;
            }

            if (isset($d->filecssremove)) {
                $removeCSS = true;
            } else {
                $removeCSS = false;
            }

            $jsArray = array();
            foreach ($d->filejs as $js) {
                $js = trim($js.'');
                if (!$js) {
                    continue;
                }

                $jsArray[] = $contentPath.$js;
            }

            if (isset($d->filejsremove)) {
                $removeJS = true;
            } else {
                $removeJS = false;
            }

            $filephp = trim($d->filephp.'');
            if ($filephp) {
                $filephp = $contentPath.$filephp;
            }

            $filehtml = trim($d->filehtml.'');
            if ($filehtml) {
                $filehtml = $contentPath.$filehtml;
            }

            $cacheArray = @(array) $d->cache;

            if (!empty($cacheArray)) {
                if (!empty($cacheArray['ttl'])) {
                    $ttl = $cacheArray['ttl'];
                } else {
                    $ttl = 0;
                }

                if (!empty($cacheArray['type'])) {
                    $type = $cacheArray['type'];
                } else {
                    $type = false;
                }

                if (!empty($cacheArray['modifier'])) {
                    $modifiersArray = $cacheArray['modifier'];
                } else {
                    $modifiersArray = array();
                }

                if (!$modifiersArray) {
                    $modifiersArray = array();
                } elseif (!is_array($modifiersArray)) {
                    $modifiersArray = array($modifiersArray);
                }

                if (!$type) $type = 'content-url';

                if ($type == 'page') {
                    // кешировать всю страницу полностью
                    if (!$modifiersArray) {
                        $modifiersArray[] = 'language';
                        $modifiersArray[] = 'url';
                        $modifiersArray[] = 'no-auth';
                    }
                } elseif ($type == 'page-content') {
                    // кешировать всю страницу полностью,
                    // если есть юзер - то только контент (для всех)
                    if (!$modifiersArray) {
                        $modifiersArray[] = 'language';
                        $modifiersArray[] = 'url';
                    }
                } elseif ($type == 'content-url') {
                    // контент в зависимости от URL
                    $type = 'content';
                    if (!$modifiersArray) {
                        $modifiersArray[] = 'language';
                        $modifiersArray[] = 'url';
                    }
                } elseif ($type == 'content') {
                    // контент
                    if (!$modifiersArray) {
                        $modifiersArray[] = 'language';
                    }
                } else {
                    throw new Engine_Exception("Unknown cache-type '{$type}'");
                }
                $cacheArray = array();
                $cacheArray['ttl'] = $ttl;
                $cacheArray['type'] = $type;
                $cacheArray['modifiers'] = $modifiersArray;
            }

            $fieldsArray = array(
            'title' => trim($d->title.''),
            'url' => $urlsArray,
            'filehtml' => $filehtml, // html-отображение
            'filephp' => $filephp, // php-файл
            'fileclass' => trim($d->fileclass.''), // php-class (@see SClass or Engine_Class)
            'filecss' => $cssArray, // css-файлы
            'filecssremove' => $removeCSS,
            'filejs' => $jsArray, // js-файлы
            'filejsremove' => $removeJS,
            'moveto' => trim($d->moveto.''), // в какой контент отправлять
            'moveas' => trim($d->moveas.''), // в какую переменную контента отправлять
            'level' => trim($d->level.''), // уровень доступа (минимальный)
            'role' => $role, // ролевая привелеия
            'arguments' => $args, // массив аргументов
            'cache' => $cacheArray, // настройки кеширования
            );

            $serData[] = array(
            'id' => $id,
            'fields' => $fieldsArray,
            'register' => $register,
            );
        }

        // @todo: а что и зачем возвращается?
        $a = array();
        if ($serData) {
            foreach ($serData as $x) {
                $a[$x['id']] = $this->registerContent($x['id'], $x['fields'], $x['register']);
            }
        }
        return $a;
    }

    /**
     * Подгрузить все контенты.
     * Метод срабатывает один раз, подгружая контенты через события
     * beforeContentLoad и afterContentLoad
     */
    private function _loadContents() {
        if (!$this->_loaded) {

            // пытаемся найти данные из кеша
            try {
                $a = Engine::GetCache()->getData(Engine::Get()->getProjectHost().'contents-data');
                $this->_data = unserialize($a);
                $this->_loaded = true;

                return;
            } catch (Exception $e) {

            }

            // регистрируем автоматический контент движка
            $path = dirname(__FILE__).'/contents/';
            $this->registerContent(
                'engine-include',
                array(
                    'filehtml' => $path.'/engine_include.html',
                    'filephp' => $path.'/engine_include.php',
                ),
                'override'
            );

            // бросам событие для подключения контентов
            $event = Events::Get()->generateEvent('beforeContentLoad');
            $event->notify();

            $event = Events::Get()->generateEvent('afterContentLoad');
            $event->notify();

            $this->_loaded = true;

            // записываем данные в кеш
            try {
                Engine::GetCache()->setData(
                    Engine::Get()->getProjectHost().'contents-data',
                    serialize($this->_data),
                    false,
                    3600
                );
            } catch (Exception $e) {

            }
        }
    }

    /**
     * Получить объект ContentDataSource'ф
     *
     * @return Engine_ContentDataSource
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new self();
        }
        return self::$_Instance;
    }

    private function __construct() {

    }

    private function __clone() {

    }

    private $_data = array();

    private $_loaded = false;

    /**
     * Объект-хранилище (Instance)
     *
     * @var Engine_ContentDataSource
     */
    private static $_Instance = false;

}