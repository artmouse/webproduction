<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

/**
 * Поиск $tranlate в HTML-файлах и проверка, есть ли такие ключи
 * в переводах.
 *
 * Язык берется из настроек системы.
 */

$a = array();
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/contents/'));
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/api/'));
$a = array_merge($a, _scan(PackageLoader::Get()->getProjectPath().'/templates/'));

$keyArray = array();
foreach ($a as $file) {
    $data = file_get_contents($file);

    if (preg_match_all('/\$translate_([a-z0-9-_]+)/ius', $data, $r)) {
        // проверяем, есть ли такой перевод
        foreach ($r[1] as $x) {
            $x = 'translate_'.$x;
            try {
                Shop::Get()->getTranslateService()->getTranslate($x);
            } catch (Exception $e) {
                print $x."\n";
            }
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