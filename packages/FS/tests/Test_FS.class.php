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
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package FS
 */
class Test_FS extends TestKit_TestClass {

    public function testFS1() {
        $dir = FS_Directory::Open(dirname(__FILE__).'/media/');
        $a = $dir->getContentsArray();
        $this->assertEquals(3 + 1 + 1, count($a));
    }

    public function testFS2() {
        $file = FS_File::Open(dirname(__FILE__).'/media/1.txt');
        $this->assertEquals(9, $file->getSize()->__toString());
    }

    public function testFSRealPath() {
        $file = FS_File::Open(dirname(__FILE__).'/media/../media/1.txt');
        $this->assertEquals(dirname(__FILE__).'/media/1.txt', $file->getPath());

        $file = FS_File::Open(dirname(__FILE__).'/media/./1.txt');
        $this->assertEquals(dirname(__FILE__).'/media/1.txt', $file->getPath());
    }

    public function testDS() {
        $dir = FS_Directory::Open(dirname(__FILE__).'/media');
        $this->assertEquals(dirname(__FILE__).'/media/', $dir->getPath());

        $dir = FS_Directory::Open(dirname(__FILE__).'/media/');
        $this->assertEquals(dirname(__FILE__).'/media/', $dir->getPath());

        $dir = FS_Directory::Open(dirname(__FILE__).'///////media/');
        $this->assertEquals(dirname(__FILE__).'/media/', $dir->getPath());

        try {
            $file = FS_File::Open(dirname(__FILE__).'/media/');
            $this->fail();
        } catch (FS_Exception $e) {

        }

        try {
            $file = FS_File::Open(dirname(__FILE__).'/media/1.txt/');
            $this->fail();
        } catch (FS_Exception $e) {

        }
    }

}