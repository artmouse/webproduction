<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2014 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */
class ShopFile extends XShopFile {

    public function __construct($id = 0) {
        parent::__construct($id);
        $this->setClassname(__CLASS__);
    }

    /**
     * Получить следующий объект
     *
     * @return ShopFile
     */
    public function getNext($exception = false) {
        1;
        return parent::getNext($exception);
    }

    /**
     * Получить объект по ключу
     *
     * @return ShopFile
     */
    public static function Get($key) {
        return self::GetObject('ShopFile', $key);
    }

    /**
     * Построить имя события
     *
     * @return string
     */
    public function makeName() {
        return htmlspecialchars($this->getName());
    }

    /**
     * Получить полный путь на файл
     *
     * @return sting
     */
    public function makePath() {
        return Shop::Get()->getFileService()->makeFilePathByHash(
            $this->getFile()
        );
    }

    /**
     * Получить размер файла в мб/кб/б
     *
     * @return string
     */
    public function makeSize() {
        $filePath = $this->makePath();
        $size = @filesize($filePath);
        if (!$size) {
            return false;
        }
        if ($size < 1024) {
            return $size.'b';
        }
        if ($size < 1024*1024) {
            return round($size / 1024).'K';
        }
        if ($size < 1024*1024*1024) {
            return round($size / 1024 / 1024).'M';
        }
        return 0;
    }

    /**
     * Получить URL на файл
     *
     * @return string
     */
    public function makeURL() {
        return Engine::GetLinkMaker()->makeURLByContentIDParam(
            'file-download',
            $this->getId()
        );
    }

}