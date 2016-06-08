<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @package SQLObjectSync
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('ConnectionManager');
    try {
        PackageLoader::Get()->import('DebugException');
    } catch (Exception $e) {}
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObjectSync.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObjectSync_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObjectSync_Table.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObjectSync_Field.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObjectSync_Data.class.php');
} else {
    include_once(dirname(__FILE__).'/SQLObjectSync.class.php');
    include_once(dirname(__FILE__).'/SQLObjectSync_Exception.class.php');
    include_once(dirname(__FILE__).'/SQLObjectSync_Table.class.php');
    include_once(dirname(__FILE__).'/SQLObjectSync_Field.class.php');
    include_once(dirname(__FILE__).'/SQLObjectSync_Data.class.php');
}