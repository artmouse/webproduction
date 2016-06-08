<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can redistribute it and/or
 * modify it.
 */

/**
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @author EngineDebug
 */
class EngineDebug_ListenerPackageLoader implements EngineDebug_IListener {

    public function getName() {
        return 'PackageLoader';
    }

    public function notify() {
        $a = array();
        $a['packagesArray'] = PackageLoader::Get()->getImportedPackagesStatistics();
        $time = 0;
        foreach ($a['packagesArray'] as $p) {
        	$time += $p['time'];
        }
        $a['packagesTime'] = $time;

        $a['classesArray'] = PackageLoader::Get()->getLoadedClassesStatistics();
        $time = 0;
        foreach ($a['classesArray'] as $p) {
        	$time += $p['time'];
        }
        $a['classesTime'] = $time;

        return Engine::GetSmarty()->fetch(
        dirname(__FILE__).'/EngineDebug_ListenerPackageLoader.html',
        $a
        );
    }

}