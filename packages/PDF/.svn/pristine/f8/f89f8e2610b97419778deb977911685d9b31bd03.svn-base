<?php
/**
 * WebProduction Packages.
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
 * PDF-конвертор
 *
 * @author Max
 * @copyright WebProduction
 * @package PDF
 */
class PDF_Container {

    private function __construct() {

    }

    private static $_Instance = false;

    /**
     * @return PDF_Container
     */
    public static function Get() {
        if (!self::$_Instance) {
            self::$_Instance = new PDF_Container();
        }
        return self::$_Instance;
    }

    /**
     * Выполнить безопастную внешнюю конвертацию файла.
     * Необходим safe_mode = Off
     *
     * @param string $filehtml
     * @param string $filepdf
     * @param string $phpcgipath
     */
    public function html2pdf_extenal($filehtml, $filepdf, $phpcgipath = false) {
        if (!$phpcgipath) {
            $phpcgipath = Engine::Get()->getConfigField('php-cgi-path');
        }
        $file = dirname(__FILE__).'/PDF/connectors/connector-external.php';
        //print $phpcgipath." -d memory_limit=128M -f {$file} {$filehtml} {$filepdf}";
        exec($phpcgipath." -d memory_limit=128M -f {$file} {$filehtml} {$filepdf}", $r);
        //print_r($r);
        //$r = implode("\n", $r);
    }

    /**
     * Выполнить конвертацию файла
     * Для частых преобразований лучше использовать внешнюю конвертацию
     * @see html2pdf_extenal()
     *
     * @param string $filehtml
     * @param string $filepdf
     */
    public function html2pdf_internal($filehtml, $filepdf) {
    	require_once(dirname(__FILE__).'/PDF/connectors/connector-internal.php');
    	convert_to_pdf($filehtml, $filepdf);
    }

}