<?php
/**
 * WebProduction Packages. SQLObject.
 * Copyright (C) 2007-2016 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */
if (class_exists('PackageLoader')) {
    PackageLoader::Get()->import('SQLObjectSync');
    PackageLoader::Get()->import('Events');
    PackageLoader::Get()->import('ConnectionManager');

    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Config.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_ConfigClass.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Exception.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Pool.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_RevertPool.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_FieldValue.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_Event.class.php');
    PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/SQLObject_EventField.class.php');

    Events::Get()->addEvent('SQLObject.build.before', 'Events_Event');
    Events::Get()->addEvent('SQLObject.build.after', 'Events_Event');
} else {
    throw new Exception('Can not use SQLObject without PackageLoader', 0);
}