<?php
/**
 * WebProduction Packages
 * Copyright (C) 2007-2012 WebProduction <webproduction.ua>
 *
 * This program is commercial software; you can not redistribute it and/or
 * modify it.
 */

/**
 * Универсальный stepper (paginator)
 *
 * @author Maxim Miroshnichenko <max@webproduction.com.ua>
 * @copyright WebProduction
 * @package Forms
 */
class Forms_ContentStepper extends Forms_Content {

    public function __construct() {
        $this->setFileHTML(dirname(__FILE__).'/'.__CLASS__.'.html');
    }

    public function render($page, $onPage, $count) {
        $assignsArray = array();

        $a = array();
        $cnt = ceil($count / $onPage);

        $stop = $page + 3;
        $start = $page - 3;

        if ($stop > $cnt) {
            $stop = $cnt;
            $start = $stop - 5;
        }

        if ($start < 0) {
            $start = 0;
            $stop = $start + 5;
        }
        if ($stop > $cnt) {
            $stop = $cnt;
        }

        for ($j = $start; $j < $stop; $j++) {
            $a[] = array(
            'name' => ($j + 1),
            'url' => Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $j)),
            'selected' => $j == $page,
            );
        }

        $assignsArray['pagesArray'] = $a;

        // текущая страница
        $assignsArray['pageCurrent'] = $page;

        if ($page + 1 < $cnt) {
            $assignsArray['urlnext'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $page + 1));
        }

        if ($page - 1 >= 0) {
            $assignsArray['urlprev'] = Engine::GetLinkMaker()->makeURLCurrentByReplaceParams(array('page' => $page - 1));
        }

        if ($stop - $start > 0) {
            $assignsArray['hellip'] = true;
        }

        return parent::render($assignsArray);
    }

}