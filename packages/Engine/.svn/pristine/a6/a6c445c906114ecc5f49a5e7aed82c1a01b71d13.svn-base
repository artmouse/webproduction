<?php
/**
 * WebProduction Packages
 * @copyright (C) 2007-2012 WebProduction <webproduction.com.ua>
 *
 * This program is commercial software;
 * you can not distribute it and/or modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Engine
 */

/**
 * Стартер Engine в режиме 2.6
 * - В этом режиме неоходимы директории contents и файлы contents.*
 * - В этом режиме по умолчанию НЕ доступны FClasses
 * - В этом режиме по умолчанию НЕ подключаются все css и js файлы
 */

// подключаем PackageLoader
if (!class_exists('PackageLoader')) {
    if (file_exists(dirname(__FILE__).'/../PackageLoader/include.php')) {
        include_once(dirname(__FILE__).'/../PackageLoader/include.php');
    }
}

// определяем project path
try {
    PackageLoader::Get()->getProjectPath();
} catch (Exception $e) {
    PackageLoader::Get()->setProjectPath(dirname(dirname(dirname(__FILE__))));
}

if (!defined('PROJECT_PATH')) {
    // @todo: разобраться как полностью избавиться от этой константы
    define('PROJECT_PATH', PackageLoader::Get()->getProjectPath());
}

// подключаем пакет движка
PackageLoader::Get()->import('Engine');

// инициализируем движок, пусть он подгрузит все что ему нужно,
// в том числе файлы engine.mode.php, engine.config.php, структуру contents
Engine::Initialize();