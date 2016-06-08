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
 * Полный тест класса CSV_Creator
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package CSV
 */
class Test_CSV_Creator extends TestKit_TestClass {

    public function testCreate1() {
        $a = array();
        $a[] = array(
        'id' => 1,
        'name' => 'Name enote',
        'price' => 10.2,
        );
        $a[] = array(
        'id' => 2,
        'name' => 'Name ololo',
        'price' => 3.2,
        );
        $a[] = array(
        'id' => 3,
        'name' => 'Name bugaga',
        'price' => 5.002,
        );
        $a[] = array(
        'id' => 4,
        'name' => 'Name kote',
        'price' => 10.1,
        );
        $a[] = array(
        'id' => 5,
        'name' => 'Name 5 trololo',
        );
        $a[] = array(
        'id' => 6,
        'price' => 124,
        );

        $csv = '';
        $csv .= "id;name;price;\n";
        $csv .= "1;Name enote;10.2;\n";
        $csv .= "2;Name ololo;3.2;\n";
        $csv .= "3;Name bugaga;5.002;\n";
        $csv .= "4;Name kote;10.1;\n";
        $csv .= "5;Name 5 trololo;;\n";
        $csv .= "6;;124;\n";

        $this->assertEquals($csv, CSV_Creator::CreateFromArray($a));
    }

}