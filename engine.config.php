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
 * В этом файле определяются дополнительные константы, подключаются пакеты, API,
 * подключается автоматат состояний
 * описываются дополнительные вызовы в зависимости от режима работы Engine.
 */

// опраделяемся с языком по умолчанию (ru)
if (!Engine::Get()->getConfigFieldSecure('language-site')) {
    Engine::Get()->setConfigField('language-site', 'ru');
}

// определение темы по умолчанию, если она еще не задана
$template = Engine::Get()->getConfigFieldSecure('shop-template');
if (!$template) {
    Engine::Get()->setConfigField('shop-template', 'default');
}

// подключаем API
include(dirname(__FILE__).'/api/include.php');

// подключаем help
include(dirname(__FILE__).'/docs/config.php');

// contents
Events::Get()->observe(
    'beforeContentLoad',
    'Shop_ContentLoadObserver'
);

// дергаем один раз ради инициализации
Shop_ModuleLoader::Get();

// menu (основное меню OneBox)
Events::Get()->observe(
    'beforeBoxAdminMenuLoad',
    'Shop_AdminMenu'
);

// подключение модулей
try {
    $moduleArray = Engine::Get()->getConfigField('shop-module');
    if ($moduleArray) {
        foreach ($moduleArray as $moduleName) {
            ModeService::Get()->verbose('import module '.$moduleName);
            Shop_ModuleLoader::Get()->import($moduleName);
        }
    }
} catch (Engine_Exception $me) {

}

if (PackageLoader::Get()->getMode('build')) {
    // перестройка БД (новое событие)
    ModeService::Get()->verbose('Start DB sync...');
    try {
        ConnectionManager::Get()->getConnectionMySQL()->connect();
    } catch (Exception $ex) {
        ModeService::Get()->check('Cannot connect to database!');
        exit;
    }            
    SQLObject_Config::Get()->process();
    include_once(dirname(__FILE__).'/api/db/index.php');

    // генератор страниц
    ModeService::Get()->verbose('Engine_Generator...');
    Engine::GetGenerator()->process();

    // Workflow Action
    ModeService::Get()->verbose('Event buildActionBlock...');
    WorkflowStatusLoader::Get()->startBuildActionBlocks();
    $event = Events::Get()->generateEvent('buildActionBlock');
    $event->notify();
    WorkflowStatusLoader::Get()->endBuildActionBlocks();

    // Workflow UI
    ModeService::Get()->verbose('Event buildInterfaceBlock...');
    $event = Events::Get()->generateEvent('buildInterfaceBlock');
    $event->notify();

    // Чистка кэша контентов
    $processor = new Shop_Processor_CacheContents();
    $processor->process();

    // Чистка кэша settings
    $processor = new Shop_Processor_CacheSettings();
    $processor->process();

    // перестройка Menu
    $processor = new Shop_Processor_BuildMenu();
    $processor->process();

    // удаляем css+js cache
    ModeService::Get()->verbose('Remove css+js cache...');
    $cacheDir = PackageLoader::Get()->getProjectPath().'/cache/';
    $a = scandir($cacheDir);
    foreach ($a as $x) {
        if (!preg_match("/.css$/iu", $x) && !preg_match("/.js$/iu", $x)) {
            continue;
        }
        $dateModification = date('Y-m-d', filemtime($cacheDir.$x));

        if (
            DateTime_Differ::DiffDay(
                DateTime_Object::Now()->setFormat('Y-m-d'),
                DateTime_Object::FromString($dateModification)
            ) > 7
        ) {
            ModeService::Get()->verbose('Remove file '.$x);
            unlink($cacheDir.$x);
        }
    }
}

if (PackageLoader::Get()->getMode('build-acl')) {
    // перестройка ACL + Sync
    $processor = new Shop_Processor_BuildACL();
    $processor->process();
}

// проверка deprecated событий в режиме check.
// @todo: в 2016м году можно удалить этот код.
if (PackageLoader::Get()->getMode('check')) {
    $eventArray = Events::Get()->getEventArray();
    $match = '(InsertBefore|InsertAfter|UpdateBefore|UpdateAfter|DeleteBefore|DeleteAfter)$';
    foreach ($eventArray as $eventName => $eventObject) {
        if (
            $eventObject instanceof SQLObject_Event
            && preg_match("/{$match}/i", $eventName)) {
            ModeService::Get()->check("ERROR! Using old-style SQLObject event naming ".$eventName);
        }
    }
}