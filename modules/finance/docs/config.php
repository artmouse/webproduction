<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'finance',
    'filename' => 'finance.html',
    'title' => 'Финансы',
    'parent' => '',
    'sort' => 131
);

$pageArray[] = array(
    'key' => 'finance_view_all',
    'filename' => 'finance_view_all.html',
    'title' => 'Просмотр платежей',
    'parent' => 'finance',
);

$pageArray[] = array(
    'key' => 'finance_filtration_panel',
    'filename' => 'finance_filtration_panel.html',
    'title' => 'Панель фильтрации',
    'parent' => 'finance',
);

$pageArray[] = array(
    'key' => 'finance_add',
    'filename' => 'finance_add.html',
    'title' => 'Добавление платежа',
    'parent' => 'finance',
);

$pageArray[] = array(
    'key' => 'finance_categories_and_funds',
    'filename' => 'finance_categories_and_funds.html',
    'title' => 'Финансы: категории и фонды',
    'parent' => 'finance',
);

$pageArray[] = array(
    'key' => 'finance_accounts',
    'filename' => 'finance_accounts.html',
    'title' => 'Финансы: кошельки и счета',
    'parent' => 'finance',
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