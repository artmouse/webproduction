<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2011 WebProduction <webproduction.com.ua>
 *
 * This program is free software; you can redistribute it and/or
 * modify it under the terms of the GNU LESSER GENERAL PUBLIC LICENSE
 * as published by the Free Software Foundation.
 *
 * This program is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 * GNU Lesser General Public License for more details.
 *
 * You should have received a copy of the GNU Lesser General Public License
 * along with this program; if not, write to the Free Software
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA 02110-1301, USA.
 */

/**
 * Сущность объекта в файловой системе.
 * Это может быть файл, директория.
 *
 * ООП-паттерн: VO
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
abstract class FS_AEntity {

    /**
     * Удалить сущность
     *
     * @throws FS_Exception
     */
    abstract public function delete();

    /**
     * Узнать размер сущности FS
     *
     * @return FS_SizeObject
     * @throws FS_Exception
     */
    abstract public function getSize();

    /**
     * Создать сущность
     *
     * @param string $path
     */
    public function __construct($path, $lightmode = false) {
        if (!$path) throw new FS_Exception("Entity path is empty");
        if (!$lightmode && file_exists($path)) $path = realpath($path);
        $this->_path = $path;
    }

    /**
     * Проверить существование
     *
     * @return bool
     */
    public function isExists() {
        return file_exists($this->getPath());
    }

    /**
     * Проверить сущность на существование.
     * Если существует - true,
     * иначе FS_Exception
     *
     * @see isExists()
     *
     * @throws FS_Exception
     * @return bool
     */
    public function checkExists() {
        if ($this->isExists()) {
            return true;
        }
        throw new FS_Exception("FS_Entity not exists");
    }

    /**
     * Получить имя файла/директории (полное)
     *
     * @return string
     */
    public function getName() {
        return basename($this->getPath());
    }

    /**
     * Получить полный путь к объекту ФС
     *
     * @return string
     */
    public function getPath() {
        return $this->_path;
    }

    /**
     * Получить www-путь к файлу, если таковой доступен.
     *
     * @throws FS_Exception
     * @return string
     */
    public function extractWWWPath() {
        if (!class_exists('PackageLoader')) {
            throw new FS_Exception("Extraction of www-path need package PackageLoader");
        }

        $pathFile = $this->getPath();
        $pathWWW = PackageLoader::Get()->getProjectPath();
        if (!substr_count($pathFile, $pathWWW)) {
            throw new FS_Exception("Cannot extract www-path for entity '{$pathFile}'");
        }

        return str_replace($pathWWW, '/', $pathFile);
    }

    /**
     * @return string
     */
    public function __toString() {
        return $this->getPath().'';
    }

    /**
     * Получить дату создания сущности
     *
     * @return DateTime_Object
     */
    public function getDatetimeCreation() {
        $this->checkExists();
        return DateTime_Object::FromTimeStamp(filectime($this->getPath()));
    }

    /**
     * Получить дату модификации сущности
     *
     * @return DateTime_Object
     */
    public function getDatetimeModification() {
        $this->checkExists();
        return DateTime_Object::FromTimeStamp(filemtime($this->getPath()));
    }

    /**
     * Получить дату последнего доступа к сущности
     *
     * @return DateTime_Object
     */
    public function getDatetimeAccess() {
        $this->checkExists();
        return DateTime_Object::FromTimeStamp(fileatime($this->getPath()));
    }

    private $_path = '';

}