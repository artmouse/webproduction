<?php
/**
 * Проходимся по всем картинкам в /media/shop/
 * и приводим их к формату 1200x1200.
 */
require(dirname(__FILE__).'/../packages/Engine/include.2.6.php');

$path = PackageLoader::Get()->getProjectPath().'media/shop/';

// получаем все файлы
$fileArray = _scandirTree($path);
foreach ($fileArray as $x) {
    // удаляем thumbы
    if (substr_count($x, '.ipthumb')) {
        print "Deleting thumb ".$x."\n";
        unlink($x);
        continue;
    }

    if (preg_match('/\.jpg$/ius', $x)
    || preg_match('/\.png$/ius', $x)) {
        print "Optimize image ".$x."\n";
        _optimizeImage($x);
    }
}

print "\n\ndone.\n\n";

function _scandirTree($path) {
    $fileArray = scandir($path);
    $a = array();
    foreach ($fileArray as $x) {
        $file = $path.'/'.$x;
        if (is_file($file)) {
            $a[] = $file;
        } elseif ($x != '.' && $x != '..' && is_dir($file)) {
            $tmp = _scandirTree($file);
            $a = array_merge($a, $tmp);
        }
    }
    return $a;
}

function _optimizeImage($filepath) {
    // получаем предельные размеры изображения
    $maxWidth = 1200;
    $maxHeight = 1200;

    // получаем текущий размер изображения
    $imageSize = @getimagesize($filepath);
    if (!$imageSize) {
        return $filepath;
    }
    $width = $imageSize[0];
    $height = $imageSize[1];

    // определяем, до какого размера уменьшать?
    if ($width > $maxWidth) {
        $width = $maxWidth;
    }
    if ($height > $maxHeight) {
        $height = $maxHeight;
    }

    // обработка изображения
    $ip = new ImageProcessor($filepath);
    $ip->addAction(new ImageProcessor_ActionResizeProportional($width, $height));
    if ($imageSize['mime'] == 'image/png') {
        $ip->addAction(new ImageProcessor_ActionToPNG($filepath));
    } else {
        $ip->addAction(new ImageProcessor_ActionToJPEG($filepath));
    }

    $ip->process();
}