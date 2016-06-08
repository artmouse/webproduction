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
 * @package Log
 */
class Test_Log extends TestKit_TestClass {

    public function testLogFile1() {
        $logFile = dirname(__FILE__).'/testdir/test.log';
        @unlink($logFile);

        $testString = 'test string';

        Log::Get()->clearHandlers();
        Log::Get()->addHandler(new Log_HandlerFile($logFile));
        Log::Get()->addString($testString);

        $content = file_get_contents($logFile);
        $this->assertTrue(substr_count($content, $testString));
        $this->assertTrue(preg_match("/(.+?): {$testString}\n/is", $content));
    }

    public function testLogFile2() {
        $logFile = dirname(__FILE__).'/testdir/test.log';
        @unlink($logFile);

        $testString = 'test string '.rand();

        Log::Initialize('default', new Log_HandlerFile($logFile));
        Log::Get()->addString($testString);

        $content = file_get_contents($logFile);
        $this->assertTrue(substr_count($content, $testString));
        $this->assertTrue(preg_match("/(.+?): {$testString}\n/is", $content));
    }

    public function testLogDirectory1() {
        $logDir = dirname(__FILE__).'/testdir/';

        $testString = 'test string '.rand();

        Log::Get()->clearHandlers();
        Log::Get()->addHandler(new Log_HandlerDirectory($logDir));
        Log::Get()->addString($testString);

        $content = file_get_contents($logDir.date('Y-m-d').'.log');
        $this->assertTrue(preg_match("/(.+?): {$testString}\n/is", $content));
    }

    public function testLogMultiplyHandlers1() {
        $logFile = dirname(__FILE__).'/testdir/test.log';
        $logDir = dirname(__FILE__).'/testdir/';

        $testString = 'test string '.rand();

        Log::Initialize('default', new Log_HandlerFile($logFile));
        Log::Get()->addHandler(new Log_HandlerDirectory($logDir));
        Log::Get()->addString($testString);

        $content = file_get_contents($logDir.date('Y-m-d').'.log');
        $this->assertTrue(preg_match("/(.+?): {$testString}\n/is", $content));

        $content = file_get_contents($logFile);
        $this->assertTrue(preg_match("/(.+?): {$testString}\n/is", $content));
    }

    public function tearDown() {

    }

}