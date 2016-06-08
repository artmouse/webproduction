<?php
// подключаем движок
require(dirname(__FILE__).'/../../packages/Engine/include.2.6.php');

// массив кнтентов, /которые не требуют проверки
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

$datasource = PackageLoader::Get()->getFiles();
$datasource = $datasource['php'];

foreach ($datasource as $dataKey => $data) {
    if (strpos($dataKey, 'Datasource') === 0 || strpos($dataKey, 'DataSource') === 0) {
        $contents[$dataKey]['filephp'] = $data;
    }
}

$resultHtml = array();
$resultPhp = array();
$resultJs = array();

$commit = false;

$htmlPattern = '/((\/\/[\s\w0-9\:\"]*|\{\|\*[\s\w0-9\:\"]*)?([=|!]=\s?[\"|\'])?\(?[а-яА-ЯЁёъЪэЭьЬюЮ]{1}'.$commit.
    '[ 0-9\wЁёъЪэЭьЬюЮ\-\,\/\!\№\;\%\:\*\(\)\-\=\+\_\/\@\#\$\^]*[0-9\wЁёъЪэЭьЬюЮ \)]{1})([\"|\']?)/ius';
foreach ($contents as $key => $content) {
    /*if ($content['id'] != 'comment-block') {
        continue;
    }*/
    if (@in_array($content['id'], $immunityContentArray)) {
        continue;
    }

    $html = @$content['filehtml'];
    if ($html && $html = file_get_contents($html)) {
        if (
            preg_match_all(
                $htmlPattern,
                $html,
                $r
            )
        ) {
            foreach ($r[1] as $keyResult => $result) {
                $result = trim($result);

                // js комментарий в html файле - пропускаем
                if (strpos($result, '//') === 0 || strpos($result, '{|*') === 0) {
                    continue;
                }



                if (strpos($result, '!=') === 0) {
                    $result = trim(str_replace('!=', '', $result));
                    $result = substr($result, 1);
                } elseif (strpos($result, '==') === 0) {
                    $result = trim(str_replace('==', '', $result));
                    $result = substr($result, 1);
                }

                // если есть открывающая скобка, должна быть и закрывающая
                /*if (substr_count($result, '(') && !substr_count($result, ')')) {
                    $result = str_replace('(', '', $result);
                }
                // и наоборот
                if (substr_count($result, '(') && !substr_count($result, ')')) {
                    $result = str_replace('(', '', $result);
                }*/


                // скобка вначале скобка и вконце
                if (strpos($result, '(') === 0 && strpos($result, ')') === strlen($result)-1) {
                    $result = substr($result, 1);
                    $result = substr($result, 0, strlen($result)-1);
                } elseif (strpos($result, '(') === 0 && !substr_count($result, ')')) {
                    $result = substr($result, 1);
                } elseif (strpos($result, ')') === strlen($result)-1 && !substr_count($result, '(')) {
                    $result = substr($result, 0, strlen($result)-1);
                }

                if (strpos($result, ':') === strlen($result)-1) {
                    $result = substr($result, 0, strlen($result)-1);
                }



                $resultHtml[] = array(
                    'data' => $result,
                    'content' => $content['filehtml'],
                    'url' => $content['url']
                );
            }

        }
    }

    $php = @$content['filephp'];
    if ($php && $php = file_get_contents($php)) {
        if (
        preg_match_all(
            '/((\/\/[\w ]*| \*[\w ]*)?\'[а-яА-ЯЁёъЪэЭьЬюЮ]{1}'."".
            '[ 0-9\wЁёъЪэЭьЬюЮ\-\,\/\!\"\№\;\%\:\*\(\)\-\=\+\_\/\@\#\$\^\&]+\')/ius',
            $php,
            $r
        )
        ) {
            foreach ($r[1] as $result) {
                // комментарии пропускаем
                if (strpos($result, '//') === 0 || strpos($result, ' * ') === 0) {
                    continue;
                }

                // удаляем ковычку в начале и в конце
                $resultClear = substr($result, 1);
                $resultClear = substr($resultClear, 0, strlen($resultClear)-1);

                $resultPhp[] = array(
                    'data' => $result,
                    'dataClear' => $resultClear,
                    'content' => $content['filephp'],
                    'url' => @$content['url']
                );
            }

        }

        if (preg_match_all(
            '/((\/\/[\w ]*| \*[\w ]*)?\"[а-яА-ЯыЫЁёъЪэЭьЬюЮ]{1}'."".
            '[ 0-9\wыЫЁёъЪэЭьЬюЮ\-\,\/\!\'\№\;\%\:\*\(\)\-\=\+\_\/\@\#\$\^\&]+\")/ius',
            $php,
            $r
        )) {
            // комментарии пропускаем
            foreach ($r[1] as $result) {
                if (strpos($result, '//') === 0 || strpos($result, ' * ') === 0) {
                    continue;
                }

                // удаляем ковычку в начале и в конце
                $resultClear = substr($result, 1);
                $resultClear = substr($resultClear, 0, strlen($resultClear)-1);

                $resultPhp[] = array(
                    'data' => $result,
                    'dataClear' => $resultClear,
                    'content' => $content['filephp'],
                    'url' => $content['url']
                );
            }

        }

        /*if (preg_match_all(
            '/((\/\/[\w ]*| \*[\w ]*)?\"[^\'\{\$;\"]*[а-яА-ЯыЫЁёъЪэЭьЬюЮ]{1}'."".
            '[ 0-9\wыЫЁёъЪэЭьЬюЮ\-\,\.\/\!\№\;\%\:\*\(\)\-\=\+\_\/\@\#\^\&]+[^\'\{\$;\"]*\")/iusU',
            $php,
            $r
        )) {
            // комментарии пропускаем
            foreach ($r[1] as $result) {
                if (strpos($result, '//') === 0 || strpos($result, ' * ') === 0) {
                    continue;
                }

                $result = trim($result);
                $result = strip_tags($result);
                print ($result)."\n";
                // удаляем ковычку в начале и в конце
                $resultClear = substr($result, 1);
                $resultClear = substr($resultClear, 0, strlen($resultClear)-1);

                $resultPhp[] = array(
                    'data' => $result,
                    'dataClear' => $resultClear,
                    'content' => $content['filephp'],
                    'url' => $content['url']
                );
            }

        }*/
    }

    /*$js2 = @$content['filejs'];
    foreach ($js2 as $js) {
        if ($js ) {
            $pattern = '/([\/\/|\*]*[\w\s]*[а-яА-ЯЁёъЪэЭьЬюЮ]{1}[0-9\wЁёъЪэЭьЬюЮ \-\,\/]*)/us';
            if (preg_match_all($pattern, file_get_contents($js), $r)) {

                foreach ($r[1] as $resultStr) {
                    if (strpos($resultStr, '//') === 0 || strpos($resultStr, '*') === 0) {
                        continue;
                    }

                    if (!array_search($resultStr, $resultDataJs)) {
                        $resultJs[] = array('data' => $resultStr, 'content' => $js);
                        $resultDataJs[] = $resultStr;
                    }
                }


            }
        }
    }*/

}

global $htmlKeysArray;

// перебираем полученный текст из html
foreach ($resultHtml as $key => $data) {
    $ruText = $data['data'];
    $contentId = $data['content'];
    $translateKey = array_search($ruText, $translateArray);
    if (!$translateKey) {
        // такого слова нету, добавляем
        $enText = StringUtils_Transliterate::TransliterateRuToEn($ruText);
        // сотавляем только бкувы цифры и пробелы
        $enText = preg_replace('/[^\w\d ]/uis', ' ', $enText);
        // больше одного пробела меняем на один
        $enText = preg_replace('/[ ]{2,}/uis', ' ', $enText);
        $enText = str_replace(' ', '_', $enText);
        $enText = 'translate_'.strtolower($enText);

        $translateArray[$enText] = $ruText;

        $translateKey = $enText;
        print "add key to ru.php ({$enText} - {$ruText})\n";
    }

    $htmlKeysArray[$ruText] = $translateKey;
}
foreach ($resultHtml as $key => $data) {
    // заменяем в html на translate ключ
    $ruText = $data['data'];
    $contentId = $data['content'];

    $content = file_get_contents($contentId);

    $GLOBALS['contents'] = $content;

    $content = preg_replace_callback(
        $htmlPattern,
        function ($match) {
            $result = trim($match[1]);

            if (strpos($result, '//') === 0 || strpos($result, '{|*') === 0) {
                return $match[0];
            }

            $inSmarty = false;
            if (strpos($result, '!=') === 0) {
                $result = trim(str_replace('!=', '', $result));
                $result = substr($result, 1);
                $inSmarty = true;
            } elseif (strpos($result, '==') === 0) {
                $result = trim(str_replace('==', '', $result));
                $result = substr($result, 1);
                $inSmarty = true;
            }

            // если есть открывающая скобка, должна быть и закрывающая
            /*if (substr_count($result, '(') && !substr_count($result, ')')) {
                $result = str_replace('(', '', $result);
            }
            // и наоборот
            if (substr_count($result, '(') && !substr_count($result, ')')) {
                $result = str_replace('(', '', $result);
            }*/

            // скобка вначеле скобка и вконце
            if (strpos($result, '(') === 0 && strpos($result, ')') === strlen($result)-1) {
                $result = substr($result, 1);
                $result = substr($result, 0, strlen($result)-1);
            } elseif (strpos($result, '(') === 0 && !substr_count($result, ')')) {
                $result = substr($result, 1);
            } elseif (strpos($result, ')') === strlen($result)-1 && !substr_count($result, '(')) {
                $result = substr($result, 0, strlen($result)-1);
            }

            if (strpos($result, ':') === strlen($result)-1) {
                $result = substr($result, 0, strlen($result)-1);
            }

            if ($inSmarty) {
                // определить, smarty или js
                $pos = strpos($GLOBALS['contents'], $result);
                $js = true;
                if ($pos !== false) {
                    $lastStr = substr($GLOBALS['contents'], $pos-1);
                    $posClosed = strpos($lastStr, '|}');
                    $posOpen = strpos($lastStr, '{|');
                    if ($posClosed && !$posOpen) {
                        $js = false;
                    } elseif ($posClosed && $posClosed < $posOpen) {
                        $js = false;
                    }
                }

                if ($js) {
                    return str_replace($result, '{|$'.$GLOBALS['htmlKeysArray'][$result].'|}'.$match[4], $match[1]);
                } else {
                    return str_replace($match[4].$result.$match[4], '$'.$GLOBALS['htmlKeysArray'][$result], $match[0]);
                }
            } else {
                return str_replace($result, '{|$'.$GLOBALS['htmlKeysArray'][$result].'|}'.$match[4], $match[1]);
            }

        },
        $content
    );
    //$content = str_replace($ruText, '{|$'.$translateKey.'|}', $content);
    file_put_contents($contentId, $content);

    print "replace \"{$ruText}\" on key \"{$translateKey}\" in html file: "
        .str_replace($projectPath, '', $contentId)." url: ".$data['url']."\n\n";

}

// перебираем полученный текст из php
foreach ($resultPhp as $key => $data) {
    $ruText = $data['data'];
    $ruTextClear = $data['dataClear'];
    $contentId = $data['content'];
    $translateKey = array_search($ruTextClear, $translateArray);
    if (!$translateKey) {
        // такого слова нету, добавляем
        $enText = StringUtils_Transliterate::TransliterateRuToEn($ruTextClear);
        // оставляем только бкувы цифры и пробелы
        $enText = preg_replace('/[^\w\d ]/uis', '', $enText);
        // больше одного пробела меняем на один
        $enText = preg_replace('/[ ]{2,}/uis', ' ', $enText);
        $enText = str_replace(' ', '_', $enText);
        $enText = 'translate_'.strtolower($enText);

        $translateArray[$enText] = $ruTextClear;

        $translateKey = $enText;
        print "add key to ru.php ({$enText} - {$ruTextClear})\n";
    }

    // заменяем в php на translate ключ
    $content = file_get_contents($contentId);
    $content = str_replace(
        $ruText,
        "Shop::Get()->getTranslateService()->getTranslateSecure('{$translateKey}')",
        $content
    );
    file_put_contents($contentId, $content);

    print "replace \"{$ruTextClear}\" on key \"{$translateKey}\" in php file: "
        .str_replace($projectPath, '', $contentId)." url: ".@$data['url']."\n\n";

}

// замена и сортировка массива ru.php
asort($translateArray);
// запись нового массива в ru.php
$strRuPhp = "<?php\n";
$strRuPhp .= "\n\$translateArray = array();";

foreach ($translateArray as $key => $translate) {
    $translate = str_replace("'", "\'", $translate);
    $str = "\n\$translateArray['{$key}'] = '{$translate}';";
    if (strlen($str) > 124) {
        $str = "\n\$translateArray['{$key}'] =\n    '{$translate}';";
    }
    $strRuPhp .= $str;
}

file_put_contents($pathPhpFile, $strRuPhp);

exit;