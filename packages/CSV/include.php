<?php
/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @package CSV
 * @copyright WebProduction
 */

if (class_exists('PackageLoader')) {
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CSV_Creator.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CSV_Parser.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CSV_Exception.class.php');
} else {
    include_once(dirname(__FILE__).'/CSV_Creator.class.php');
    include_once(dirname(__FILE__).'/CSV_Parser.class.php');
    include_once(dirname(__FILE__).'/CSV_Exception.class.php');
}