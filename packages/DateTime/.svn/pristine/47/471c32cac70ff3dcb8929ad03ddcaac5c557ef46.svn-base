<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2010  WebProduction <webproduction.com.ua>
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
 * Foundation, Inc., 51 Franklin Street, Fifth Floor, Boston, MA  02110-1301, USA.
 */

/**
 * Фонетическое форматирование дат в будущем
 *
 * @author Max
 * @author DFox
 * @copyright WebProduction
 * @package DateTime
 */
class DateTime_ClassFormatPhoneticFuture implements DateTime_IClassFormat {

    public function __construct($language = 'ru') {
        $this->_language = $language;
    }

    public function setFormat($format) {
        $this->_format = $format;
    }

    public function setDate($timestamp) {
        $this->_timestamp = $timestamp;
    }

    public function __toString() {
        $a = DateTime_Object::FromTimeStamp($this->_timestamp)->setFormat('l, d F Y, H:i');

        $a = str_replace('January', DateTime_Translate::Get()->getTranslate('january'), $a);
        $a = str_replace('February', DateTime_Translate::Get()->getTranslate('february'), $a);
        $a = str_replace('March', DateTime_Translate::Get()->getTranslate('march'), $a);
        $a = str_replace('April', DateTime_Translate::Get()->getTranslate('april'), $a);
        $a = str_replace('May', DateTime_Translate::Get()->getTranslate('may'), $a);
        $a = str_replace('June', DateTime_Translate::Get()->getTranslate('june'), $a);
        $a = str_replace('July', DateTime_Translate::Get()->getTranslate('july'), $a);
        $a = str_replace('August', DateTime_Translate::Get()->getTranslate('august'), $a);
        $a = str_replace('September', DateTime_Translate::Get()->getTranslate('september'), $a);
        $a = str_replace('October', DateTime_Translate::Get()->getTranslate('october'), $a);
        $a = str_replace('November', DateTime_Translate::Get()->getTranslate('november'), $a);
        $a = str_replace('December', DateTime_Translate::Get()->getTranslate('december'), $a);

        $a = str_replace('Monday', DateTime_Translate::Get()->getTranslate('monday'), $a);
        $a = str_replace('Tuesday', DateTime_Translate::Get()->getTranslate('tuesday'), $a);
        $a = str_replace('Wednesday', DateTime_Translate::Get()->getTranslate('wednesday'), $a);
        $a = str_replace('Thursday', DateTime_Translate::Get()->getTranslate('thursday'), $a);
        $a = str_replace('Friday', DateTime_Translate::Get()->getTranslate('friday'), $a);
        $a = str_replace('Saturday', DateTime_Translate::Get()->getTranslate('saturday'), $a);
        $a = str_replace('Sunday', DateTime_Translate::Get()->getTranslate('sunday'), $a);

        return $a;
    }

    private $_format;

    private $_timestamp;

    private $_language;

}
