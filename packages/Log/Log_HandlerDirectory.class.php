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
 * Обработчик логов по файлам в директории
 *
 * @author Max
 * @copyright WebProduction
 * @package Log
 */
class Log_HandlerDirectory implements Log_IHandler {

    private $_path;
    private $_datetimePattern;

    /**
     * Записывать логи в директорию
     *
     * @param string $path Полный путь к директории
     * @param string $datetimePattern Шаблон имени log-файла
     */
	public function __construct($path, $datetimePattern = 'Y-m-d') {
        if (!file_exists($path)) {
        	throw new Log_Exception("Path '{$path}' is not exists");
        }
        if (!is_dir($path)) {
        	throw new Log_Exception("Path '{$path}' is not directory");
        }
        $datetimePattern = trim($datetimePattern);
        if (!$datetimePattern) {
        	throw new Log_Exception("'{$datetimePattern}' is not datetime pattern");
        }
        $this->_path = $path;
        $this->_datetimePattern = $datetimePattern;
	}

	public function addString($string) {
        $cdate = date('Y-m-d H:i:s');

        $f = fopen($this->_path.'/'.date($this->_datetimePattern).'.log', 'a+');
        flock($f, LOCK_EX);
        fwrite($f, $cdate.': '.$string."\n");
        flock($f, LOCK_UN);
        fclose($f);
	}

}