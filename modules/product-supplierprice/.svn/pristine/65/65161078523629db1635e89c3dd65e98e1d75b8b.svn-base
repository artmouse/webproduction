<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'supplierprice',
    'filename' => 'supplierprice.html',
    'title' => 'Загрузка прайсов поставщиков',
    'parent' => '',
    'sort' => 161
);

foreach ($pageArray as $page) {
    Shop_ModuleLoader::Get()->registerHelpItem(
        $page['key'],
        dirname(__FILE__) . '/' . $page['filename'],
        $page['title'],
        $page['parent'],
        @$page['sort']
    );
}