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
 * Полный тест класса Checker
 *
 * @author Max
 * @copyright WebProduction
 * @package Randomer
 */
class Test_Randomer extends TestKit_TestClass {

    public function setUp() {

    }

    public function test1() {
        $x = strlen(Randomer_Password::Randomer());
        $this->assertTrue($x >= 5);
        $this->assertTrue($x <= 10);

        $x = mb_strlen(Randomer_Password::Randomer(5, 5));
        $this->assertTrue($x == 5);
        // $this->assertEquals('13.10.2010, среда, 07:04', DateTime_Formatter::DateTimePhonetic('2010-10-13 07:04'));
    }

    public function tearDown() {

    }

}