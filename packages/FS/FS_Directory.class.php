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
 * Директория
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
class FS_Directory extends FS_AEntity {

    /**
     * Создать директорию на основе существующего пути.
     * Обязательно выполняется проверка на существование.
     *
     * @param string $path
     * @return FS_Directory
     */
    public static function Open($path) {
        $x = new self($path);
        $x->checkExists();
        return $x;
    }

    /**
     * Проверить существование директории
     *
     * @override
     * @return bool
     */
    public function isExists() {
        return is_dir($this->getPath());
    }

    /**
     * Получить размер объекта ФС в байтах
     *
     * @throws FS_Exception
     * @return FS_SizeObject
     */
    public function getSize() {
        $this->checkExists();

        $contentsArray = $this->getContentsArray();
        $size = 0;
        foreach ($contentsArray as $x) {
            $size += ($x->getSize()->__toString() + 0);
        }
        return new FS_SizeObject($size);
    }

    /**
     * Получить путь к директории.
     * Путь всегда со слешом (directory_separator) в конце
     *
     * @return string
     */
    public function getPath() {
        $x = parent::getPath();
        if (substr($x, strlen($x) - 1) != '/') {
            $x .= '/';
        }
        return $x;
    }

    /**
     * Получить содержимое директории (файлы и директории)
     *
     * @return array of FS_File/FS_Directory
     */
    public function getContentsArray() {
        // @todo: FS_Collection?
        $this->checkExists();

        $a = array();
        $dir = opendir($this->getPath());
        while ($x = readdir($dir)) {
            if ($x == '.' || $x == '..') {
                continue;
            }

            $path = $this->getPath().DIRECTORY_SEPARATOR.$x;

            if (is_dir($path)) {
                $a[] = self::Open($path);
            } else {
                $a[] = FS_File::Open($path);
            }
        }
        closedir($dir);
        return $a;
    }

    /**
     * Получить список файлов в директории
     *
     * @return array of FS_File
     */
    public function getFilesArray() {
        // @todo: FS_Collection?
        $contentsArray = $this->getContentsArray();
        $a = array();
        foreach ($contentsArray as $x) {
            if ($x instanceof FS_File) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Получить список вложенных директорий
     *
     * @return array of FS_Directory
     */
    public function getDirectoriesArray() {
        // @todo: FS_Collection?
        $contentsArray = $this->getContentsArray();
        $a = array();
        foreach ($contentsArray as $x) {
            if ($x instanceof FS_Directory) {
                $a[] = $x;
            }
        }
        return $a;
    }

    /**
     * Удалить директорию
     * вместе со всеми вложениями в директории
     */
    public function delete() {
        $this->checkExists();

        $contentsArray = $this->getContentsArray();
        foreach ($contentsArray as $x) {
            $x->delete();
        }
        rmdir($this->getPath());
    }

    // @todo: создать рандомный FS_File в директории

}