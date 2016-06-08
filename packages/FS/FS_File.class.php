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
 * Файл
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
class FS_File extends FS_AEntity {

    /**
     * Создать файл на основе существующего пути.
     * Обязательно выполняется проверка на существование.
     *
     * @throws FS_Exception
     * @param string $path
     * @return FS_File
     */
    public static function Open($path) {
        $x = new self($path);
        $x->checkExists();
        return $x;
    }

    /**
     * Создать файл на основе любого пути.
     * Даже если файл не существует - объект все равно создастся,
     * но большинство методов будут кидать FS_Exception.
     *
     * Чтобы записать что-то в файл - вызовите contentWrite()
     * или contentAppend()
     *
     * @param string $path
     * @param bool $lightmode
     * @return FS_File
     */
    public static function Create($path, $lightmode = false) {
        $x = new self($path, $lightmode);
        return $x;
    }

    /**
     * Проверить существование файла
     *
     * @override
     * @return bool
     */
    public function isExists() {
        return is_file($this->getPath());
    }

    /**
     * Проверить возможность записи в файл
     *
     * @return bool
     */
    public function isWritable() {
        return is_writable($this->getPath());
    }

    /**
     * Получить размер объекта ФС в байтах
     *
     * @throws FS_Exception
     * @return FS_SizeObject
     */
    public function getSize() {
        $this->checkExists();
        return new FS_SizeObject(filesize($this->getPath()));
    }

    /**
     * Получить расширение файла (.ext).
     * Без точки.
     *
     * @throws FS_Exception
     * @return string
     */
    public function getExtension() {
        return pathinfo($this->getPath(), PATHINFO_EXTENSION);
    }

    /**
     * Удалить файл
     *
     * @throws FS_Exception
     */
    public function delete() {
        $this->checkExists();

        unlink($this->getPath());
    }

    /**
     * Записать в файл даные $content
     *
     * @param string $content
     */
    public function contentWrite($content) {
        file_put_contents($this->getPath(), $content, LOCK_EX);
    }

    /**
     * Дописать в конец файла данные $content
     * Если файла нет - он создатся.
     *
     * @param string $content
     */
    public function contentAppend($content) {
        $f = fopen($this->getPath(), 'a+');
        flock($f, LOCK_EX);
        fwrite($f, $content);
        flock($f, LOCK_UN);
        fclose($f);
    }

    /**
     * Прочитать содержимое файла
     *
     * @throws FS_Exception
     * @return string
     */
    public function contentRead() {
        $this->checkExists();
        return file_get_contents($this->getPath());
    }

}