<?php
// перемещаем файлы из директории media/file в новую структуру
$dirMedia = PackageLoader::Get()->getProjectPath().'/media/';
$dirCurrent = PackageLoader::Get()->getProjectPath().'/media/file/';

$a = scandir($dirCurrent);
foreach ($a as $file) {
    if (!preg_match("/^([a-z0-9]{32})$/ius", $file)) {
        continue;
    }

    $folder1 = substr($file, 0, 2);
    $folder2 = substr($file, 2, 2);
    $folder3 = substr($file, 4, 4);

    @mkdir($dirMedia.$folder1);
    @mkdir($dirMedia.$folder1.'/'.$folder2);
    @mkdir($dirMedia.$folder1.'/'.$folder2.'/'.$folder3);

    rename($dirCurrent.$file, $dirMedia.$folder1.'/'.$folder2.'/'.$folder3.'/'.$file);

    print "Move file ".$dirCurrent.$file."\n";
}

// конвертируем записи в базе shopfile
$shopfile = Shop::Get()->getFileService()->getFilesAll();
$shopfile->setOrder('id', 'DESC');
while ($x = $shopfile->getNext()) {
    if (preg_match("/\/([a-z0-9]{32})$/ius", $x->getFile(), $r)) {
        print "Convert file ".$x->getFile()." to hash ".$r[1]."\n";
        $x->setFile($r[1]);
        $x->update();
    }
}

// перемещаем файлы из директории media/email в новую структуру
// доливаем и конвертируем в базе email attachment
$dirCurrent = PackageLoader::Get()->getProjectPath().'/media/email/';
$date = date('Y-m-d H:i:s');
$attachment = new XShopEventAttachment();
$attachment->setOrder('id', 'DESC');
while ($x = $attachment->getNext()) {
    if (preg_match("/\/([a-z0-9]{32})$/ius", $x->getFile(), $r)) {
        if ($x->getFile() != $r[1]) {
            $file = new ShopFile();
            $file->setKey('event-'.$x->getEventid());
            $file->setFile($r[1]);
            if (!$file->select()) {
                print "Move attachment#".$x->getId()." to file ".$r[1]."\n";

                $file->setCdate($date);
                $file->setName($x->getName());
                $file->setContenttype($x->getContenttype());
                $file->insert();

                $file = $r[1];
                $folder1 = substr($file, 0, 2);
                $folder2 = substr($file, 2, 2);
                $folder3 = substr($file, 4, 4);

                @mkdir($dirMedia.$folder1);
                @mkdir($dirMedia.$folder1.'/'.$folder2);
                @mkdir($dirMedia.$folder1.'/'.$folder2.'/'.$folder3);

                if (!file_exists($dirMedia.$folder1.'/'.$folder2.'/'.$folder3.'/'.$file)) {
                    rename($dirCurrent.$x->getFile(), $dirMedia.$folder1.'/'.$folder2.'/'.$folder3.'/'.$file);
                } else {
                    print "already exists\n";
                }
            }
        }
    }
}