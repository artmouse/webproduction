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
if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('DateTime');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_AEntity.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_File.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_Directory.class.php');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_FileXML.class.php');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_ISizeFormat.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_SizeFormatDefault.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_SizeFormatMegabytes.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/FS_SizeObject.class.php');
} else {
    if (!class_exists('DateTime_Object')) {
        throw new Exception("Package FS need package DateTime", 0);
    }

    include_once(dirname(__FILE__).'/FS_AEntity.class.php');
    include_once(dirname(__FILE__).'/FS_Exception.class.php');
    include_once(dirname(__FILE__).'/FS_File.class.php');
    include_once(dirname(__FILE__).'/FS_Directory.class.php');

    include_once(dirname(__FILE__).'/FS_FileXML.class.php');

    include_once(dirname(__FILE__).'/FS_ISizeFormat.class.php');
    include_once(dirname(__FILE__).'/FS_SizeFormatDefault.class.php');
    include_once(dirname(__FILE__).'/FS_SizeFormatMegabytes.class.php');
    include_once(dirname(__FILE__).'/FS_SizeObject.class.php');
}