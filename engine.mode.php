<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software; you cannot redistribute it and/or
 * modify.
 */

/**
 * В этом файле определяются устанавливается режим работы Engine
 */

// список режимов и документация по ним доступна по ссылке
// https://box.webproduction.ua/doc/onebox-mode
// по умолчанию все отключите
// PackageLoader::Get()->setMode('build');
// PackageLoader::Get()->setMode('build-acl');
// PackageLoader::Get()->setMode('build-scss');
// PackageLoader::Get()->setMode('debug');
// PackageLoader::Get()->setMode('xdebug');
// PackageLoader::Get()->setMode('verbose');
// PackageLoader::Get()->setMode('check');
// PackageLoader::Get()->setMode('no-cache');
PackageLoader::Get()->setMode('no-minify');
//Engine_Cache::Get()->disableCache();
//Engine::Get()->enableErrorReporting();
Engine::Get()->setConfigField('project-host', 'shop.local');

// connection to database
ConnectionManager::Get()->addConnectionDatabase(
new ConnectionManager_MySQLi(
'localhost',
'root',
'728159',
'webproduction'
));


// подключение темы
//Engine::Get()->setConfigField('shop-template', 'kazakhfilm-adaptive');

// подключение модулей
Engine::Get()->setConfigField('shop-module', array(
    'quiz',
    'contact',
    //'box',
    'order',
    'document',
    'finance',
    'storage',
    //'seo',
    'seotags',
    'product-supplierprice',
    'product-favoirite',
    'product-margin',
    //'collars',
    //'kazakhfilm-adaptive',
    //'api-docs'

));

