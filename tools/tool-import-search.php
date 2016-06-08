<?php
/**
 * Импорт из внешнего файла ключевых слов в базу поиска
 */
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

PackageLoader::Get()->setMode('debug', true);
Engine::Get()->enableErrorReporting();

$a = @file($argv[1]);
foreach ($a as $x) {
    $x = trim($x);
    if (!$x) {
        continue;
    }

    print $x."\n";

    try {
        SQLObject::TransactionStart();

        $search = new XShopSearchLog();
        $search->setQuery($x);
        if (!$search->select()) {
            $search->setCountresult(1);
            $search->insert();
        }

        SQLObject::TransactionCommit();
    } catch (Exception $ge) {
        SQLObject::TransactionRollback();
        print $ge;
    }
}

print "\n\ndone.\n\n";