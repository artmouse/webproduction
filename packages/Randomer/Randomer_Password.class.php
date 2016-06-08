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
 * Генератор паролей
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Randomer
 */
class Randomer_Password {

    /**
     * Сгенерировать случайный пароль по дефолтному алгоритму
     *
     * @deprecated
     * @see Random()
     *
     * @param int $lengthMin
     * @param int $lengthMax
     * @return string
     */
    public static function Randomer($lengthMin = 5, $lengthMax = 10) {
        return self::Random($lengthMin, $lengthMax);
    }

    /**
     * Сгенерировать случайный пароль по дефолтному алгоритму
     *
     * @param int $lengthMin
     * @param int $lengthMax
     * @return string
     */
    public static function Random($lengthMin = 5, $lengthMax = 10) {
        $password = '';
        // @todo: если min > max - exception?
        $length = rand($lengthMin, $lengthMax);
        for ($i = 0; $i < $length; $i++) {
            $x = array();
            $x[] = chr(rand(ord('A'),ord('Z')));
            $x[] = chr(rand(ord('a'),ord('z')));
            $x[] = chr(rand(ord('0'),ord('9')));
            $a = rand(0, 2);
            $password .= $x[$a];
        }
        return $password;
    }

    /**
     * Получить счастливый запоминаемый пароль по словарю
     *
     * @return string
     */
    public static function RandomHappy() {
        PackageLoader::Get()->import('StringUtils');

        $base = file(dirname(__FILE__).'/happy.txt');
        $password = trim($base[array_rand($base)]);
        return StringUtils_Converter::Transcription($password);
    }

    // @todo: пароль с русскими буквами

}