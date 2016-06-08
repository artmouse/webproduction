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
 * Класс-обертка над понятием "размер файла/директории".
 * Позволяет удобно превращать и выводить размер в МБ, КБ, ...
 * По умолчанию - просто байты.
 * Паттерн - VO.
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
class FS_SizeObject {

    // @todo - возможно он перейдет в пакет StringUtils

    public function __toString() {
        return $this->getFormat()->format($this->_size);
    }

    /**
     * Задать форматтер.
     * Например, new FS_SizeFormatMB()
     *
     * @param FS_ISizeFormat $format
     * @return FS_SizeObject
     */
    public function setFormat(FS_ISizeFormat $format) {
        $this->_format = $format;
        return $this;
    }

    /**
     * Получить текущий форматтер
     *
     * @return FS_ISizeFormat
     */
    public function getFormat() {
        return $this->_format;
    }

    public function __construct($size) {
        $this->_size = (int) $size; // @todo bigint?!
        $this->setFormat(new FS_SizeFormatDefault());
    }

    private $_size = 0;

    private $_format;

}