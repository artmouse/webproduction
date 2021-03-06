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
 * Утилита для быстрого форматирования дат в нужный формат
 * (формально - оболочка над DateTime_Object)
 *
 * Все что начинается на Date - только дата
 * Все что начинается на Time - только время
 * Все что начинается на DateTime - дата и время
 * Все что начинается на TimeDate - время и дата (обратный порядок)
 *
 * @author Max
 * @copyright WebProduction
 * @package DateTime
 */
class DateTime_Formatter {

    /**
     * Формат даты в соответсвии с ГОСТ Р 6.30-2003 (п. 3.11).
     * 31.12.1986
     *
     * @param string $date
     * @return string
     */
    public static function DateRussianGOST($date) {
        return DateTime_Object::FromString($date)->setFormat('d.m.Y')->__toString();
    }

    /**
     * Формат даты в соответсвии с ГОСТ Р 6.30-2003 (п. 3.11).
     * 31.12.1986 11:22:33
     *
     * @param string $date
     * @return string
     */
    public static function DateTimeRussianGOST($date) {
        return DateTime_Object::FromString($date)->setFormat('d.m.Y H:i:s')->__toString();
    }

    /**
     * Формат даты в соответсвии с ISO 8601 (допускается в ГОСТ Р 6.30-2003 (п. 3.11))
     * 1986.12.31
     *
     * @param string $date
     * @return string
     */
    public static function DateISO8601($date) {
        if ($date == '0000-00-00 00:00:00') {
            return false;
        }
        return DateTime_Object::FromString($date)->setFormat('Y.m.d')->__toString();
    }

    /**
     * Формат даты в соответсвии с ISO 9075 (SQL)
     * 1986-12-31
     *
     * @param string $date
     * @return string
     */
    public static function DateISO9075($date) {
        return DateTime_Object::FromString($date)->setFormat('Y-m-d')->__toString();
    }

    /**
     * Формат даты и времени в соответсвии с ISO 9075 (SQL)
     * 1986-12-31 12:00:55
     *
     * @param string $date
     * @return string
     */
    public static function DateTimeISO9075($date) {
        return DateTime_Object::FromString($date)->setFormat('Y-m-d H:i:s')->__toString();
    }
    
    /**
     * Фонетическое форматирование даты.
     * Пример: понедельник, 31.12.1986, 12:20
     * Пример: вчера, 31.12.1986, 12:20
     * Пример: 5 мин. назад, 31.12.1986, 12:20
     *
     * @param string $datetime
     * @return string
     */
    public static function DateTimePhonetic($datetime) {
        return DateTime_Object::FromString($datetime)->setClassFormat(new DateTime_ClassFormatPhonetic())->__toString();
    }

    /**
     * Фонетическое форматирование даты.
     * Пример: понедельник, 31.12.1986
     * Пример: вчера, 31.12.1986
     * Пример: 5 мин. назад, 31.12.1986
     *
     * @param string $date
     * @return string
     */
    public static function DatePhonetic($date) {
        $f = new DateTime_ClassFormatPhonetic();
        $f->setFormatMode('date');
        return DateTime_Object::FromString($date)->setClassFormat($f)->__toString();
    }

    /**
     * Фонетическое форматирование даты в будущем времени.
     * Пример: Январь, 31.12.2012, 12:20
     *
     * @param string $datetime
     * @return string
     */
    public static function DateTimePhoneticFuture($datetime) {
        return DateTime_Object::FromString($datetime)->setClassFormat(new DateTime_ClassFormatPhoneticFuture())->__toString();
    }
    
    /**
     * Формат времени без даты
     * 14:32:25
     *
     * @param string $datetime
     * @return string
     */
    public static function TimeISO8601($datetime) {
        return DateTime_Object::FromString($datetime)->setFormat('H:i')->__toString();
    }

    public static  function  DatePhoneticMonthRus($date) {
        $date = DateTime_Object::FromString($date)->setFormat('d-m-Y');
        $date = explode('-', $date);
        $str = @$date[0];
        $month = @$date[1];
        if ($month == 1) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('january');
        } elseif ($month == 2) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('february');
        } elseif ($month == 3) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('march');
        } elseif ($month == 4) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('april');
        } elseif ($month == 5) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('may');
        } elseif ($month == 6) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('june');
        } elseif ($month == 7) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('july');
        } elseif ($month == 8) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('august');
        } elseif ($month == 9) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('september');
        } elseif ($month == 10) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('october');
        } elseif ($month == 11) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('november');
        } elseif ($month == 12) {
            $str.= ' '.DateTime_Translate::Get()->getTranslate('december');
        }
        $str .= ' '.@$date[2];
        return $str;
    }

}