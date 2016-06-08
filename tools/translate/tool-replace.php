<?php
// подключаем движок
require(dirname(__FILE__).'/../../packages/Engine/include.2.6.php');

$translateKey1 = @$argv[1];
$translateKey2 = @$argv[2];
$replace = @$argv[3];

if ($replace != 'replace') {
    $replace = false;
}

if (!$translateKey1) {
    print "\n\nKey1 empty\n\n";
    return;
}

if (!$translateKey2) {
    print "\n\nKey2 empty\n\n";
    return;
}
// массив кнтентов, которые не требуют проверки
$helpContentArray = Shop_ModuleLoader::Get()->getHelpItemArray();

$immunityContentArray = array(
    'install-tpl',
    'install',
    'help-index',
    'help-menu',
    'help-tpl'
);

foreach ($helpContentArray as $help) {
    $immunityContentArray[] = 'help-'.$help['key'];
}

$projectPath = PackageLoader::Get()->getProjectPath();
$projectPath = substr($projectPath, 0, -1);

// подключаем ru.php
$translateArray = array();
$pathPhpFile = $projectPath.'/media/translate/ru.php';
include($pathPhpFile);

// идем по контентам, и ищем русские слова
$contents = Engine_ContentDataSource::Get()->getData();

$resultHtml = array();
$resultPhp = array();
$resultJs = array();

$commit = false;

$count = 0;

foreach ($contents as $key => $content) {
    /*if ($content['id'] != 'block-callback') {
        continue;
    }*/
    if (in_array($content['id'], $immunityContentArray)) {
        continue;
    }

    $html = @$content['filehtml'];
    if ($html && $html = file_get_contents($html)) {
        if (preg_match(
            '/\{\|\$'.$translateKey1.'\|\}/uis',
            $html
        )

        ) {
            $count++;
            if ($replace) {

                $str = preg_replace(
                    '/\{\|\$'.$translateKey1.'\|\}/uis',
                    '{|$'.$translateKey2.'|}',
                    $html
                );

                file_put_contents($content['filehtml'], $str);
                print "replace in: ".$content['filehtml']."\n";
            } else {
                print "find in: ".$content['filehtml']."\n";
            }

        }
    }

    $php = @$content['filephp'];
    if ($php && $php = file_get_contents($php)) {
        if (preg_match('/\''.$translateKey1.'\'/uis', $php)) {
            $count++;
            if ($replace) {
                $str = preg_replace(
                    '/\''.$translateKey1.'\'/uis',
                    '\''.$translateKey2.'\'',
                    $php
                );

                file_put_contents($content['filephp'], $str);
                print "replace in: ".$content['filephp']."\n";
            } else {
                print "find in: ".$content['filephp']."\n";
            }

        }
    }

    $php = @$content['filephp'];
    if ($php && $php = file_get_contents($php)) {
        if (preg_match('/\"'.$translateKey1.'\"/uis', $php)) {
            $count++;
            if ($replace) {
                $str = preg_replace(
                    '/\"'.$translateKey1.'\"/uis',
                    '\"'.$translateKey2.'\"',
                    $php
                );

                file_put_contents($content['filephp'], $str);
                print "replace in: ".$content['filephp']."\n";
            } else {
                print "find in: ".$content['filephp']."\n";
            }

        }
    }

}

if (!$count) {
    print "\nWarning: key is not found\n";
}

print "\n\ndone\n\n";
exit;