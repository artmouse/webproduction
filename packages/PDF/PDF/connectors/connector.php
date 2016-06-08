<?php
/**
 * XCMS engine
 * Copyright (C) 2006-2010  WebProduction <webproduction.com.ua>
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

function convert_to_pdf($path_to_html, $path_to_pdf) {
    $file = dirname(__FILE__).'/connector-exec.php';
    // print PHP_CGI_PATH." -d memory_limit=128M -f {$file} {$path_to_html} {$path_to_pdf}";
    exec(XCMS::GET()->getConfigField('php-cgi-path')." -d memory_limit=128M -f {$file} {$path_to_html} {$path_to_pdf}", $r);
    //print_r($r);
    //$r = implode("\n", $r);
}
