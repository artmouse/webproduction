<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

/**
 * Поиск русских фраз в HTML-файлах contents, api, templates
 */

$a = array();
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/contents/'));
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/api/'));
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/templates/'));

$keyArray = array();
foreach ($a as $file) {
    $data = file_get_contents($file);

    if (preg_match_all("/([а-я]+)/ius", $data, $r)) {
        if ($r[1]) {
        	print $file."\n";
        	foreach ($r[1] as $x) {
        		print $x."\n";
        	}
        	print "\n";
        }
    }
}

print "\n\ndone.\n\n";

function _scan($dir) {
    $r = array();

    $a = scandir($dir);
    foreach ($a as $x) {
        if ($x == '.') {
            continue;
        }
        if ($x == '..') {
            continue;
        }

        $x = $dir.'/'.$x;

        if (is_dir($x)) {
            $tmp = _scan($x);
            foreach ($tmp as $tmpx) {
                $r[] = $tmpx;
            }
        } else {
            if (preg_match("/\.html$/ius", $x)) {
                $r[] = $x;
            }
        }
    }

    return $r;
}