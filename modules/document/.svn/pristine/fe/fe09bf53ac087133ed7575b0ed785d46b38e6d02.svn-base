<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'document',
    'filename' => 'document.html',
    'title' => 'Документы',
    'parent' => '',
    'sort' => 111
);

$pageArray[] = array(
    'key' => 'document_show_all',
    'filename' => 'document_show_all.html',
    'title' => 'Просмотр документов',
    'parent' => 'document',
);

$pageArray[] = array(
    'key' => 'document_filtration_panel',
    'filename' => 'document_filtration_panel.html',
    'title' => 'Панель фильтрации',
    'parent' => 'document',
);

$pageArray[] = array(
    'key' => 'document_templates',
    'filename' => 'document_templates.html',
    'title' => 'Шаблоны документов',
    'parent' => 'document',
);

$pageArray[] = array(
    'key' => 'document_add',
    'filename' => 'document_add.html',
    'title' => 'Добавление документов',
    'parent' => 'document',
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