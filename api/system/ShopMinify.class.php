<?php
/**
 * OneBox
 * @copyright (C) 2011-2015 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * "Склеить" и минимизировать все javascript и css файлы
 *
 * @copyright WebProduction
 * @author Andrii Andriiets
 */
class ShopMinify {

    /**
     * @param string $cachePath // путь для сохранения файлов
     * @param bool $minify // сжатие файлов
     */
    public function __construct($jsCachePath = '/_js/cache/', $cssCachePath = '/_css/cache/', $minify = true) {
        $this->init($jsCachePath, $cssCachePath, $minify);
    }


    /**
     * Запустить сжатие файлов
     */
    public function process() {

        $list = PackageLoader::Get()->getJSFiles();
        foreach ($list as $key => $value) {
            $value = str_replace('//', '/', $this->getRootPath().$value);
            $this->_jsFilesArray[md5($value)] = $value;
        }

        $list = PackageLoader::Get()->getCSSFiles();
        foreach ($list as $key => $value) {
            $value = str_replace('//', '/', $this->getRootPath().$value);
            $this->_cssFilesArray[md5($value)] = $value;
        }

        $this->getFilesArray($this->getRootPath().'/_css/');
        $this->getFilesArray($this->getRootPath().'/_js/');
        $this->getFilesArray($this->getRootPath().'/contents/');

        // Ищем файлы в шаблонах
        try {
            $template = Engine::Get()->getConfigFieldSecure('shop-template');
            $this->getFilesArray(PackageLoader::Get()->getProjectPath().'/templates/'.$template, false);
        } catch (Exception $e) {

        }

        // Ищем в модулях
        try {
            $modulesArray = Engine::Get()->getConfigField('shop-module');
            foreach ($modulesArray as $moduleName) {
                $this->getFilesArray(PackageLoader::Get()->getProjectPath().'/modules/'.$moduleName, true, false);
            }
        } catch (Exception $e) {

        }

        $this->minifyJsFiles();
        $this->minifyCssFiles();
    }

    /**
     * "Склеить" и минимизировать все javascript файлы
     */
    public function minifyJsFiles() {
        $this->minifyFiles($this->_jsFilesArray, 'js');
    }

    /**
     * "Склеить" и минимизировать все css файлы
     */
    public function minifyCssFiles() {
        $this->minifyFiles($this->_cssFilesArray, 'css');
    }

    /**
     * @param $cachePath
     * @param $minify
     */
    protected function init($jsCachePath ,$cssCachePath, $minify) {
        $this->setMinify($minify);

        $rootPath = PackageLoader::Get()->getProjectPath();
        $this->setRootPath($rootPath);

        $rev = false;
        $revInfoFile = $this->getRootPath().'rev.info';
        if (file_exists($revInfoFile)) {
            $rev = file_get_contents($revInfoFile);
        }
        $this->setRevision($rev);

        $cachedir = $this->getRootPath().$jsCachePath;
        if (!file_exists($cachedir)) {
            mkdir($cachedir);
        }
        $this->setJsCachePath($jsCachePath);

        $cachedir = $this->getRootPath().$cssCachePath;
        if (!file_exists($cachedir)) {
            mkdir($cachedir);
        }
        $this->setCssCachePath($cssCachePath);
    }

    /**
     * @param $files
     * @param $type
     * @return bool
     * @throws ServiceUtils_Exception
     */
    protected function minifyFiles($files, $type) {
        if (empty($files)) {
            return false;
        }

        $types = array_fill(0,sizeof($files), $type);

        // Добавляем разширение для переданных файлов
        $files = array_map('addExtension', $files, $types);

        // Проверяем существуют ли переданные файлы
        // и получаем время последнего редактирования
        foreach ($files as $file) {
            $path = realpath($file);
            if (!file_exists($path)) {
                throw new ServiceUtils_Exception("file {$path} not exist");
            }
        }

        if ($this->getMinify()) {
            require_once('Minifier.php');
        }

        // Get contents of the files
        $contents = '';
        foreach ($files as $file) {
            $path = realpath($file);
            if ($type === 'css') {
                $contents .= file_get_contents($path);
            } else {
                if ($contents) {
                    $contents .= ";";
                    if ($this->getMinify() && strpos($path, '.min') === false) {
                        $contents .= \JShrink\Minifier::minify(file_get_contents($path));
                    } else {
                        $contents .= file_get_contents($path);
                    }
                } else {
                    if ($this->getMinify() && strpos($path, '.min') === false) {
                        $contents = \JShrink\Minifier::minify(file_get_contents($path));
                    } else {
                        $contents = file_get_contents($path);
                    }
                }
            }
        }

        if ($type === 'css') {
            if ($this->getMinify()) {
                // Remove comments
                $contents = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $contents);
                // Remove tabs, spaces, newlines, etc...
                $contents = str_replace(array("\r", "\n", "\t", '  ', '   '), '', $contents);
            }
            file_put_contents("{$this->getRootPath()}{$this->getCssCachePath()}client-{$this->getRevision()}.min.{$type}", $contents);
        } else if ($type === 'js') {
            file_put_contents("{$this->getRootPath()}{$this->getJsCachePath()}client-{$this->getRevision()}.min.{$type}", $contents);
        }

    }

    private function getFilesArray($path) {
        $handle = opendir($path);

        // Защищаемся от рекурсии
        if (in_array($path, $this->_checkPathArray)) {
            return;
        }
        $this->_checkPathArray[] = $path;

        // Пропускаем папки, в которых не может быть файлов
        while(($file = readdir($handle))) {
            // В папках .svn точно не может  файлов
            if ($file == '.' || $file == '..' || $file == '.svn') {
                continue;
            }
            if (is_file ($path."/".$file) && $this->_getExtension($file) == "css" ) {
                $value = str_replace('//', '/', $path ."/".$file);
                $this->_cssFilesArray[md5($value)] = $value;
            }
            if (is_file ($path."/".$file) && $this->_getExtension($file) == "js" ) {
                $value = str_replace('//', '/', $path ."/".$file);
                $this->_jsFilesArray[md5($value)] = $value;
            }

            if (is_dir ($path."/".$file) && ($file != ".") &&
                ($file != "..") && strpos($file, 'cache') === false &&
                strpos($file, 'admin') === false ) {
                $this->getFilesArray($path."/".$file);
            }
        }
        closedir($handle);
    }

    private function _compressing ($buffer) {
        $buffer = $this->_deleteComents($buffer);
        $buffer = str_replace(array("\r\n", "\r", "\n", "\t", '  ', '    ', '    '), '', $buffer);
        return $buffer;
    }

    private function _deleteComents ($buffer) {

        $buffer = preg_replace('!/\*[^*]*\*+([^/][^*]*\*+)*/!', '', $buffer);

        return $buffer;

    }


    private function _getExtension ($filename) {
        return substr($filename, strrpos($filename, '.') + 1);
    }

    /**
     * @param string $revision
     */
    public function setRevision($revision)
    {
        $this->_revision = $revision;
    }

    /**
     * @return string
     */
    public function getRevision()
    {
        return $this->_revision;
    }

    /**
     * @param string $rootPath
     */
    public function setRootPath($rootPath)
    {
        $this->_rootPath = $rootPath;
    }

    /**
     * @return string
     */
    public function getRootPath()
    {
        return $this->_rootPath;
    }

    /**
     * @param boolean $minify
     */
    public function setMinify($minify)
    {
        $this->_minify = $minify;
    }

    /**
     * @return boolean
     */
    public function getMinify()
    {
        return $this->_minify;
    }


    /**
     * @param string $cssCachePath
     */
    public function setCssCachePath($cssCachePath)
    {
        $this->cssCachePath = $cssCachePath;
    }

    /**
     * @return string
     */
    public function getCssCachePath()
    {
        return $this->cssCachePath;
    }

    /**
     * @param string $jsCachePath
     */
    public function setJsCachePath($jsCachePath)
    {
        $this->jsCachePath = $jsCachePath;
    }

    /**
     * @return string
     */
    public function getJsCachePath()
    {
        return $this->jsCachePath;
    }

    private $_checkPathArray = array();

    private $_jsFilesArray = array();

    private $_cssFilesArray = array();

    private $_rootPath = '';

    private $jsCachePath = '';

    private $cssCachePath = '';

    private $_revision = '';

    private $_minify = true;

}

/**
 * Функция добавляет разширение файла в зависимости от типа
 */
function addExtension($file,$type)
{
    if ($type == 'javascript' && substr($file, -3) !== '.js'){
        $file .= '.js';
    }
    elseif($type == 'css' && substr($file, -4) !== '.css') {
        $file .= '.css';
    }

    return $file;
}