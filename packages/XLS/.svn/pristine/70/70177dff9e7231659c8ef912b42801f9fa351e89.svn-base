<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * @package XLS
 * @copyright WebProduction
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/XLS_Reader.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/XLS_OLERead.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/XLS_Creator.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/XLS_Exception.class.php');
} else {
    include_once(dirname(__FILE__).'/XLS_Reader.class.php');
    include_once(dirname(__FILE__).'/XLS_OLERead.class.php');
    include_once(dirname(__FILE__).'/XLS_Creator.class.php');
    include_once(dirname(__FILE__).'/XLS_Exception.class.php');
}

set_include_path(dirname(__FILE__).'/');