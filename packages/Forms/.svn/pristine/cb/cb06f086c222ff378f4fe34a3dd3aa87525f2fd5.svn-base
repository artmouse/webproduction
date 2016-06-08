<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2013 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentFieldFile extends Forms_ContentField {

    public function __construct($key, $filemd5 = true) {
        PackageLoader::Get()->import('StringUtils');

        parent::__construct($key);

        $this->_filemd5 = $filemd5;

        $this->getContentView()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
        $this->getContentControl()->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'_Control.html');
    }

    /**
     * Отрисовать поле для просмотра (в табличном выводе, например).
     *
     * @param int $rowIndex
     * @param array $cellsArray
     * @return string
     */
    public function renderView($rowIndex, $cellsArray) {
        $assigns = array();

        $assigns['key'] = $this->getKey();
        $value = @$cellsArray[$this->getKey()];
        if ($value) {
            $assigns['value'] = $this->getMediaDirectory().$value;
        }

        return $this->getContentView()->render($assigns);
    }

    /**
     * Отрисовать контрол поля
     * для форм редактирования / добавления
     *
     * @param mixed $value
     * @return string
     */
    public function renderControl($value = false) {
        $assigns = array();

        $assigns['name'] = $this->getName();
        $assigns['key'] = $this->getKey();
        $assigns['disabled'] = $this->getDisabled();
        if ($value && !is_array($value)) {
            $assigns['value'] = $this->getMediaDirectory().$value;
        }

        return $this->getContentControl()->render($assigns);
    }

    public function getValue() {
        $deleteFlag = Engine::GetURLParser()->getArgumentSecure($this->getKey().'-delete');
        if ($deleteFlag) {
            // если установлен флаг delete - значит
            // вложенный файл нужно удалить
            return '';
        }

        $x = parent::getValue();

        $tmpName = @$x['tmp_name'];
        $fileName = @$x['name'];
        if ($tmpName) {
            $ext = pathinfo($x['name'], PATHINFO_EXTENSION);

            if ($this->getFileInMD5()) {
                $file = $this->_makeImagesUploadUrl($tmpName, $ext);
            } else {
                $file = $fileName;

                // превращаем имя файла в латинские символы
                // убираем все левое
                // дописываем в начало дату загрузки файла
                $file = StringUtils_Transliterate::TransliterateRuToEn($file);
                $file = preg_replace("/([^0-9a-z\.\-\_])/is", '-', $file);
                $file = date('YmdHis').'_'.$file;
            }

            // перемещаем файл в медиа-хранилище
            copy(
            $tmpName,
            PackageLoader::Get()->getProjectPath().$this->getMediaDirectory().$file
            );

            // возвращаем имя файла
            return $file;
        }

        // иначе мы должны вернуть те-же данные что и обычно!
        throw new Forms_Exception();
    }

    /**
     * Создания адреса для записи картинки
     * создаётся 3 папки которые вложены друг в друга
     * Имена папок определяется по хешу файла
     *
     * @param $image
     * @return string
     */
    private function _makeImagesUploadUrl($image, $fileformat) {
        $imagemd5 = md5_file($image);
        $url = PackageLoader::Get()->getProjectPath().$this->getMediaDirectory();
        $folder1 = substr($imagemd5, 0, 2);
        $folder2 = substr($imagemd5, 2, 2);

        @mkdir($url.$folder1);
        @mkdir($url.$folder1.'/'.$folder2);

        $imagemd5 = $folder1.'/'.$folder2.'/'.$imagemd5.'.'.$fileformat;

        return $imagemd5;
    }

    /**
     * Задать путь для медиа-директории, в которой
     * храниться
     *
     * @param string $dir
     */
    public function setMediaDirectory($dir) {
        $this->_mediaDir = $dir;
    }

    public function getMediaDirectory() {
        return $this->_mediaDir.'/';
    }

    /**
     * @return bool
     */
    public function getFileInMD5() {
        return $this->_filemd5;
    }

    private $_mediaDir = '';

    private $_filemd5 = true;

}