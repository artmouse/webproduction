#!/usr/bin/php
<?php
require(dirname(__FILE__).'/packages/PackageLoader/include.php');

PackageLoader::Get()->setMode('build');
PackageLoader::Get()->setMode('build-acl');
PackageLoader::Get()->setMode('build-scss');
PackageLoader::Get()->setMode('check');
PackageLoader::Get()->setMode('verbose');

require(dirname(__FILE__).'/packages/Engine/include.2.6.php');

Engine::Get()->enableErrorReporting();

print "\n";

try {
    Engine::GetCache()->clearCache();

    print "Cache cleared.\n";
} catch (Exception $e) {
    print "Cache clear error!\n";
}

file_put_contents(dirname(__FILE__).'/rev.info', date('YmdHis'));

 //$minify = new ShopMinify('/_js/cache/', '/_css/cache/', true);
// $minify->process();

try {
    print_r(Storage::Get('shop-cache'));
} catch (Exception $storageEx) {

}

$rev = @$argv[1];

if (!$rev) {
    $rev = false;
    while (1) {
        print "From what revision you updates? Please, input number:\n";
        $rev = fgets(STDIN);
        $rev = trim($rev);

        if ($rev > 0) {
            break;
        }
    }
}

if ($rev != 'force' && $rev > 15000) {
    print "\n\n";
    print "Running convert tools from rev #{$rev} ...\n\n";

    $dir = dirname(__FILE__).'/updater/';
    $a = _scandir($dir, 'php');
    try {
        $moduleArray = Engine::Get()->getConfigField('shop-module');
        if ($moduleArray) {
            foreach ($moduleArray as $moduleName) {
                // module
                $modulesUpdaterPath = PackageLoader::Get()->getProjectPath() . '/modules/' . $moduleName . '/updater/';
                if (file_exists($modulesUpdaterPath)) {
                    $filesArray = _scandir($modulesUpdaterPath, 'php');
                    if ($filesArray) {
                        $a = array_merge($a, $filesArray);
                    }
                }

            }
        }
    } catch (Engine_Exception $me) {

    }

    // сортируем по ревизиям, независимо от модуля
    usort($a, "_cmp");

    $toolArray = array();
    foreach ($a as $script) {
        if (preg_match("/\/(\d+)-(.+)\.php$/i", $script, $r)) {
            if ($r[1] >= $rev) {
                $toolArray[] = array(
                'path' => $script,
                'rev' => $r[1],
                );
            }
        }
    }

    foreach ($toolArray as $x) {
        $script = $x['path'];
        print "Running {$script} ...\n";
        include($script);
        print "\n\n";
    }
}

$modulesName = Engine::Get()->getConfigFieldSecure('dependency-module');
if ($modulesName) {
    $svnRevisionCustom = 0;
    exec('svnversion '.dirname(__FILE__).'/modules/'.$modulesName.'/', $arr);
    if ($arr) {
        $svnRevisionCustom = (int) @$arr[0];
    }

    $svnRevisionCore = 0;
    exec('svnversion '.dirname(__FILE__), $arr2);
    if ($arr2) {
        $svnRevisionCore = (int) @$arr2[0];
    }

    if ($svnRevisionCustom && $svnRevisionCore && $svnRevisionCore > $svnRevisionCustom) {
        print "\n\nWARNING: THERE IS NO GUARANTEE THE MODULE kazka WILL WORKS CORRECTLY!";
        print "\nCore revision: ".$svnRevisionCore;
        print "\n".$modulesName." revision: ".$svnRevisionCustom;
    }
}

print "\ndone.\n\n";

function _scandir($path, $ext = 'html') {
    $tmp = scandir($path);
    $a = array();
    foreach ($tmp as $x) {
        if ($x == '.') {
            continue;
        }
        if ($x == '..') {
            continue;
        }

        if (preg_match("/\.{$ext}$/i", $x)) {
            $a[] = $path.$x;
        } elseif (is_dir($path.$x)) {
            $a = array_merge($a, _scandir($path.$x.'/'));
        }
    }

    return $a;
}

function _cmp($a, $b) {
    if (preg_match("/\/(\d+)-(.+)\.php$/i", $a, $r) && preg_match("/\/(\d+)-(.+)\.php$/i", $b, $r2)) {
        if ($r[1] == $r2[1]) {
            return 0;
        }
        return ($r[1] < $r2[1]) ? -1 : 1;
    }
    return 0;
}