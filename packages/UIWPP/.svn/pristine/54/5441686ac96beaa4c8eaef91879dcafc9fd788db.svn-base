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
 * @package UIWPP
 * @author Max
 * @copyright WebProduction
 */
class UIWPP_Loader implements PackageLoader_ILoader {

    public function __construct($paramsArray) {
        $uiPrefix = @$paramsArray['prefix'];
        if (!$uiPrefix) {
            $uiPrefix = 'wpp-';
        }

        // подключаем UI_WPP.css
        $data = file_get_contents(dirname(__FILE__).'/UIWPP.css');
        $data = str_replace('PREFIX-', $uiPrefix, $data);
        $path = dirname(__FILE__).'/';
        // @todo: возможно стоит у PackageLoader'a спрашивать DOCUMENT_DIR
        $path = str_replace(PROJECT_PATH, '/', $path);
        $data = str_replace('PATH', $path, $data);
        PackageLoader::Get()->registerCSSData($data, true);

        // регистрируем контенты
        $data = file_get_contents(dirname(__FILE__).'/wpp.contents.xml');
        $data = str_replace('PREFIX-', $uiPrefix, $data);
        Engine::GetContentDataSource()->registerContentsFromXML(
        $data,
        dirname(__FILE__).'/contents/'
        );
    }

}