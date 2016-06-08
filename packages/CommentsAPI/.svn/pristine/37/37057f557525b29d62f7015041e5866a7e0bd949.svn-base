<?php
/**
 * WebProduction Packages
 *
 * @copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * SQLObject comments api
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @package   CommentsAPI
 * @copyright WebProduction
 */
if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('SQLObject');
    PackageLoader::Get()->import('Events');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CommentsAPI.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CommentsAPI_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/CommentsAPI_DB.class.php');

    Events::Get()->observe('SQLObject.build.before', 'CommentsAPI_DB');
} else {
    throw new Exception("Cannot import CommentsAPI without PackageLoader", 0);
}