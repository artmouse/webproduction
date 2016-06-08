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
 * Объектная обертка над XML-файлом
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
class FS_FileXML extends FS_File {

	/**
     * Создать файл на основе существующего пути.
     * Обязательно выполняется проверка на существование.
     *
     * @throws FS_Exception
     * @param string $path
     * @return FS_FileXML
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
     * @return FS_FileXML
     */
    public static function Create($path, $lightmode = false) {
        $x = new self($path, $lightmode);
        return $x;
    }

    /**
     * Прочитать и распарсить XML
     *
     * @return SimpleXMLElement
     */
    public function contentParse() {
        // @todo: use package XML

        if (!function_exists('simplexml_load_string')) {
        	throw new FS_Exception("Cannot load php-extension 'simplexml_load_string'");
        }
        $xml = @simplexml_load_string($this->contentRead());
        if (!$xml) {
        	throw new FS_Exception("Invalid XML content in file '{$this->getPath()}'");
        }
        return $xml;
    }

}