<?php
/**
 * Превращение путей в media в правильный формат.
 * Было: /media/aa/bb/cccc/hash
 * Стало: /media/aa/bb/hash
 *
 * Как работает?
 * Идем по всем shopfile, если находим файл по старому пути - то перекидываем его на новый путь.
 */

$mediaPath = PackageLoader::Get()->getProjectPath().'media/';

$files = Shop::Get()->getFileService()->getFilesAll();
while ($x = $files->getNext()) {
    // пропускаем не-md5, на случай если там есть такой тупняк
    if (substr_count($x->getFile(), '/')) {
        continue;
    }

    print 'Simplify file hash '.$x->getId().' '.$x->getFile()."... ";

    // строим старый путь

    $hash = $x->getFile(); // really hash
    $hash1 = substr($hash, 0, 2);
    $hash2 = substr($hash, 2, 2);
    $hash3 = substr($hash, 4, 4);

    $pathOld = $mediaPath.$hash1.'/'.$hash2.'/'.$hash3.'/'.$hash;
    $pathNew = $mediaPath.$hash1.'/'.$hash2.'/'.$hash;

    if (file_exists($pathOld)) {
        // есть файл по старому пути - перемещаем его

        print "\n";
        print "move from ".$pathOld."\n";
        print "move to ".$pathNew."\n";

        // перемещаем файл
        rename($pathOld, $pathNew);

        // проверяем на пустоту директорию, если она пустая - удаляем
        $tmpDir = $mediaPath.$hash1.'/'.$hash2.'/'.$hash3.'/';
        $tmp = scandir($tmpDir);
        if (count($tmp) <= 2) {
            print "remove directory {$tmpDir}\n";
            rmdir($tmpDir);
        }
    } elseif (file_exists($pathNew)) {
        print "File ok";
    } else {
        print "File ERROR - no file";
    }

    print "\n";
}