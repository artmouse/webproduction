<?php
class help_tpl extends Engine_Class {

    public function process() {
        PackageLoader::Get()->registerJSFile('/_js/jQueryFilter.js');
        PackageLoader::Get()->registerJSFile('/_js/help/highlight.min.js');

        $menu = Engine::Get()->GetContentDriver()->getContent('help-menu');
        $this->setValue('menu', $menu->render());

        $contentID = Engine::Get()->getRequest()->getContentID();
        $contentID = preg_replace('/^help-/uis', '', $contentID, 1);
        $pageArray = Shop_ModuleLoader::Get()->getHelpItemArray();

        $pathArray = $this->_makePath($pageArray, $contentID);
        $this->setValue('pathArray', $pathArray);

        $this->setValue('favicon', Shop::Get()->getSettingsService()->getSettingValue('favicon'));
        $this->setValue('title', Engine::GetHTMLHead()->getTitle());
        $this->setValue('year', date('Y'));
        $this->setValue('engine_includes', Engine::GetHTMLHead()->render());
        
        $content = $this->getValue('content');
        $faq = '';
        if (Engine::GetURLParser()->getMatchURL() == '/doc/') {
            preg_match('/faq[\S\s]+$/ius', $content, $m);
            $faq = $m[0];
            $content = str_replace($faq, '', $content);
        }
        $content = $this->_relinkContent($content, 'https://webproduction');
        $content .= $faq;
        $k = 0;
        if (preg_match_all('/[^(Смотрите также:)](<h2>.+?<\/h2>)/ius', $content, $r)) {
            
            foreach ($r[1] as $index => $x) {
                $content = preg_replace('/(<h2>)/ius', '<h2 id="block'.$k++.'">', $content, 1);
            }
        }

        if (preg_match_all('/<boxui (.+?)>(.+?)<\/boxui>/ius', $content, $r)) {
            $css = '<link rel="stylesheet" type="text/css" href="/contents/shop/admin/admin_shop_tpl.css">
            <link rel="stylesheet" type="text/css" href="/_css/perfect-scrollbar.css" />
            <link rel="stylesheet" type="text/css" href="/_css/select2-modern.css" />
            <link rel="stylesheet" type="text/css" href="/_css/jquery.tagit.css" />
            <link rel="stylesheet" type="text/css" href="/_css/jquery-ui.css" />
            <link rel="stylesheet" type="text/css" href="/_css/jquery.ui.timepicker.addon.css" />';
            $css .= '<script type="text/javascript" src="/_js/jquery-1.8.2.min.js"></script>
            <script type="text/javascript" src="/_js/jquery-ui.min.js"></script>
            <script type="text/javascript" src="/_js/jquery.ui.timepicker.addon.js"></script>
            <script type="text/javascript" src="/_js/jquery.cookie.js"></script>
            <script type="text/javascript" src="/_js/no-conflict.js"></script>
            <script type="text/javascript" src="/_js/os-detection.js"></script>
            <script type="text/javascript" src="/_js/perfect-scrollbar.js"></script>
            <script type="text/javascript" src="/_js/jquery.tag.it.js"></script>
            <script type="text/javascript" src="/_js/jquery.maskedinput.js"></script>
            <script type="text/javascript" src="/_js/jquery.tablesorter.js"></script>
            <script type="text/javascript" src="/contents/shop/admin/admin_shop_tpl.js"></script>
            <script type="text/javascript" src="/modules/box/contents/admin/admin_shop_tpl.js"></script>
            <script type="text/javascript" src="/_js/select2.js"></script>
            <script type="text/javascript" src="/_js/jquery.autosize.js"></script>
            <script type="text/javascript" src="/_js/jquery.tooltipster.js"></script>';

            $k = 1;
            foreach ($r[2] as $index => $x) {
                $content = str_replace('<boxui data-id="'.$k.'"', '<iframe data-id="'.$k.'"', $content);
                $content = str_replace('</boxui', '</iframe', $content);
                $html = '<html><head>'.$css.'</head><body>'.$r[2][$index].'</body></html>';
                $content = preg_replace('/'.$r[1][$index].'/ius', $r[1][$index]." srcdoc='".$html."'", $content, 1);
                $k++;
            }
        }

        $this->setValue('content', $content);

        // block "See also"
        $chapterArr = $menu->getValue('newMenuArray');
        $selected = false;
        $links = array();
        // setting number of chapters in block
        $cntLinks = 10;

        // getting current chapter
        foreach ($chapterArr as $k => $v) {
            foreach ($v as $childKey => $childVal) {
                if (1 == $childVal['selected']) {
                    $selected = true;
                    $curChapterVal = $childVal;
                    $curChapterKey = $childKey;
                }
            }
        }

        // code work if any chapter was selected
        if ($selected) {
            // if parent exist
            // checking subchapters
            if ($curChapterVal['parent']) {
                if (array_key_exists($curChapterVal['key'], $chapterArr)) {
                    foreach ($chapterArr[$curChapterVal['key']] as $k => $v) {
                        $val['name'] = $v['name'];
                        $val['url'] = $v['url'];
                        $links[] = $val;
                        if ($cntLinks == count($links)) break;
                    }
                } else {
                    // check neighbour chapters
                    foreach ($chapterArr as $k => $v) {
                        if ($k == $curChapterVal['parent']) {
                            // unset element cause current chapter shouldn't be able in block "See also"
                            unset($v[$curChapterKey]);
                            if (0 === count($v)) {
                                // if no neighbour chapters go to parent
                                $mainParent = false;

                                foreach ($chapterArr[1] as $k => $v) {
                                    // if parent chapter main
                                    if ($curChapterVal['parent'] == $v['key']) {
                                        $mainParent = true;
                                        // if quantity of elements which should be chosen more than quantity of
                                        // elements in array system generate warning - that`s why check it
                                        if (count($chapterArr[1]) < $cntLinks) {
                                            $rand_keys = array_rand($chapterArr[1], count($chapterArr[1]));
                                        } else {
                                            $rand_keys = array_rand($chapterArr[1], $cntLinks);
                                        }

                                        foreach ($rand_keys as $k => $v) {
                                            $val['name'] = $chapterArr[1][$v]['name'];
                                            $val['url'] = $chapterArr[1][$v]['url'];
                                            $links[] = $val;
                                            if ($cntLinks == count($links)) break;
                                        }
                                    }
                                }

                                // if parent chapter NOT main getting parent element
                                if (!$mainParent) {
                                    foreach ($chapterArr as $k => $v) {
                                        foreach ($v as $childKey => $childVal) {
                                            if ($curChapterVal['parent'] == $childVal['key']) {
                                                $keyChap = ($childVal['parent']);
                                            }
                                        }
                                    }
                                    foreach ($chapterArr[$keyChap] as $k => $v) {
                                        $val['name'] = $v['name'];
                                        $val['url'] = $v['url'];
                                        $links[] = $val;
                                        if ($cntLinks == count($links)) break;
                                    };
                                }
                            } else {
                                // neighbour chapters exist - view them
                                // unset element cause current chapter shouldn't be able in block "See also"
                                unset($v[$curChapterKey]);
                                foreach ($v as $childK => $childV) {
                                    $val['name'] = $childV['name'];
                                    $val['url'] = $childV['url'];
                                    $links[] = $val;
                                    if ($cntLinks == count($links)) break;
                                }
                            }
                        }
                    }
                }
            } else {
                // if parent not exist
                // check subchapters
                if (array_key_exists($curChapterVal['key'], $chapterArr)) {
                    foreach ($chapterArr[$curChapterVal['key']] as $k => $v) {
                        $val['name'] = $v['name'];
                        $val['url'] = $v['url'];
                        $links[] = $val;
                        if ($cntLinks == count($links)) break;
                    }
                } else {
                    // unset element cause current chapter shouldn't be able in block "See also"
                    unset($chapterArr[1][$curChapterKey]);

                    // if quantity of elements which should be chosen more than quantity of elements in array
                    // system generate warning - that`s why check it
                    if (count($chapterArr[1]) < $cntLinks) {
                        $rand_keys = array_rand($chapterArr[1], count($chapterArr[1]));
                    } else {
                        $rand_keys = array_rand($chapterArr[1], $cntLinks);
                    }

                    foreach ($rand_keys as $k => $v) {
                        $val['name'] = $chapterArr[1][$v]['name'];
                        $val['url'] = $chapterArr[1][$v]['url'];
                        $links[] = $val;
                        if ($cntLinks == count($links)) break;
                    }
                }
            }
        }

        // checker for template if any chapter wasn`t selected
        $this->setValue('selected', $selected);
        $this->setValue('chapterLinks', $links);
    }

    private function _relinkContent ($text, $defaultHost = 'https://webproduction') {
        $text = str_replace("&nbsp;", ' ', $text);

        $projectHost = explode('.', Engine::Get()->getProjectHost());
        $endHost = $projectHost[count($projectHost)-1];
        $filename = 'media/relink.xml';
        if (file_exists($filename)) {
            if ($xml = simplexml_load_file($filename)) {
                $zonesArray = array();
                foreach ($xml->zones[0] as $zone) {
                    $zonesArray[] = (string) $zone;
                }
                if (!in_array($endHost, $zonesArray)) {
                    $endHost = $zonesArray[0];
                }
                $host = $defaultHost.'.'.$endHost;
                foreach ($xml->relink as $x) {
                    $relinkUrl = trim($x->url);
                    
                    if (strpos($relinkUrl, '{zone}') && $endHost != 'ua') {
                        $relinkUrl = str_replace('https', 'http', $relinkUrl);
                    }
                    $relinkUrl = str_replace('{zone}', $endHost, $relinkUrl);
                    //$relinkPage = trim($x->relinkContent);
                    $keyword = trim($x->name);
                    if (!$relinkUrl) {
                        $relinkUrl = $host;
                    }
                    
                    /*if ($relinkPage) {
                        $relinkUrl .= '/'.$relinkPage;
                    }*/
                    $text = preg_replace(
                        "/([\(\s>])({$keyword})([\)\s<\,\.\:\;\?]+)/ius",
                        "$1<a href=\"{$relinkUrl}\">$2</a>$3",
                        $text
                    );
                }
            }
        }
        return $text;
    }

    private function _makePath ($pageArray, $key) {
        $a = array();
        foreach ($pageArray as $page) {
            if ($key == $page['key']) {
                $a[] = $page;

                if ($page['parent']) {
                    $result =  $this->_makePath($pageArray, $page['parent']);
                    $a = array_merge($result, $a);
                } else {
                    return $a;
                }

                break;
            }
        }

        return $a;
    }

}