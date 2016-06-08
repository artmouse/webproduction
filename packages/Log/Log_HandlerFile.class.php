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
 * Хранитель логов в одном файле
 *
 * @author Max
 * @copyright WebProduction
 * @package Log
 */
class Log_HandlerFile implements Log_IHandler {

    private $_path;

	public function __construct($path) {
	    $dirname = dirname($path);
        if (!file_exists($dirname)) {
        	throw new Log_Exception("Log: path '{$dirname}' is not exists");
        }
        $this->_path = $path;
	}

	public function addString($string) {
        $cdate = date('Y-m-d H:i:s');

        $f = fopen($this->_path, 'a+');
        flock($f, LOCK_EX);
        fwrite($f, $cdate.': '.$string."\n");
        flock($f, LOCK_UN);
        fclose($f);
	}

}