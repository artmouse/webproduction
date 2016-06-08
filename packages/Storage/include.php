<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2013 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @package Storage
 * @copyright WebProduction
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_IHandler.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_HandlerArray.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_HandlerCacheFiles.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_HandlerFiles.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_HandlerMemcache.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/Storage_HandlerSession.class.php');
} else {
    include_once(dirname(__FILE__).'/Storage.class.php');
    include_once(dirname(__FILE__).'/Storage_Exception.class.php');
    include_once(dirname(__FILE__).'/Storage_IHandler.class.php');
    include_once(dirname(__FILE__).'/Storage_HandlerArray.class.php');
    include_once(dirname(__FILE__).'/Storage_HandlerCacheFiles.class.php');
    include_once(dirname(__FILE__).'/Storage_HandlerFiles.class.php');
    include_once(dirname(__FILE__).'/Storage_HandlerMemcache.class.php');
    include_once(dirname(__FILE__).'/Storage_HandlerSession.class.php');
}