<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package EngineDebug
 */
class EngineDebug_Loader implements PackageLoader_ILoader {

    public function __construct($paramsArray) {
        PackageLoader::Get()->import('DateTime');

        $autoRegister = @$paramsArray[0];

        // @todo:
        // код не сработает, так как загрузка пакета выполняется до
        // определения контента
        if (Engine::Get()->getRequest()->getContentID() == 'EngineDebug') {
            return;
        }

        // import files
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_IListener.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_EngineOnFinal.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerPHPInfo.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerVars.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerURLParser.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerLA.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerPackageLoader.class.php');
        PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerMessages.class.php');
        if (PackageLoader::Get()->isImported('SQLObject')) {
            PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerSQLObject.class.php');
        }
        if (PackageLoader::Get()->isImported('ConnectionManager')) {
            PackageLoader::Get()->registerPHPClass(dirname(__FILE__).'/EngineDebug_ListenerConnectionManagerMySQL.class.php');
        }

        // register Engine content
        Engine::GetContentDataSource()->registerContentsFromXML(
        file_get_contents(dirname(__FILE__).'/EngineDebug.contents.xml'),
        dirname(__FILE__).'/'
        );

        // register JS-button
        if (PackageLoader::Get()->isImported('jQuery')) {
            $code = file_get_contents(dirname(__FILE__).'/EngineDebug_Code.jquery.js');
        } elseif (PackageLoader::Get()->isImported('JSPrototype')) {
            $code = file_get_contents(dirname(__FILE__).'/EngineDebug_Code.prototype.js');
        } else {
            throw new PackageLoader_Exception('Import jQuery or JSPrototype package first.');
        }

        $code = str_replace('{|$key|}', EngineDebug::Get()->getKey(), $code);
        PackageLoader::Get()->registerJSData($code);
        PackageLoader::Get()->registerCSSFile(dirname(__FILE__).'/EngineDebug_Code.css', true);

        // register Engine event observer
        Events::Get()->observe(
        'afterEngineFinal',
        new EngineDebug_EngineOnFinal()
        );

        // register listeners
        if ($autoRegister) {
            EngineDebug::Get()->addListener(new EngineDebug_ListenerLA());
            if (PackageLoader::Get()->isImported('SQLObject')) {
                EngineDebug::Get()->addListener(new EngineDebug_ListenerSQLObject());
            }
            EngineDebug::Get()->addListener(new EngineDebug_ListenerPackageLoader());
            if (PackageLoader::Get()->isImported('ConnectionManager')) {
                EngineDebug::Get()->addListener(new EngineDebug_ListenerConnectionManagerMySQL());
            }
            // EngineDebug::Get()->addListener(new EngineDebug_ListenerURLParser());
            // EngineDebug::Get()->addListener(new EngineDebug_ListenerVars());
            // EngineDebug::Get()->addListener(EngineDebug_ListenerMessages::Get());
            // EngineDebug::Get()->addListener(new EngineDebug_ListenerPHPInfo());
        }
    }

}