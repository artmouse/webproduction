<?php
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

// берем первый язык за основной и сравниваем чтобы все ключи были во втором языке
$languageDefault = $argv[1];
$languageCompare = $argv[2];

// загружаем default
include($argv[1]);
$defaultArray = $translateArray;

// очищаем массив
$translateArray = array();
// загружаем для сравнения
include($argv[2]);

// идем по первому и проверяем
print "Not found keys in {$argv[2]}:\n";

$a = array();
foreach ($defaultArray as $key => $value) {
    if (empty($translateArray[$key])) {
        print $key."\n";

        $a[$key] = $value;
    }
}

print "\n\n";

foreach ($a as $key => $value) {
    print '$translateArray[\''.$key.'\'] = '."'".$value."';\n";
}

print "\n\ndone.\n\n";