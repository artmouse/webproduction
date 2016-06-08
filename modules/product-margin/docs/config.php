<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'product_margin',
    'filename' => 'product_margin.html',
    'title' => 'Наценки и пересчет цен',
    'parent' => '',
    'sort' => 171
);

$pageArray[] = array(
    'key' => 'product_margin_recalculation',
    'filename' => 'product_margin_recalculation.html',
    'title' => 'Пересчет цен',
    'parent' => 'product_margin',
);

$pageArray[] = array(
    'key' => 'product_margin_add_rule',
    'filename' => 'product_margin_add_rule.html',
    'title' => 'Добавить правило наценки',
    'parent' => 'product_margin',
);

$pageArray[] = array(
    'key' => 'product_margin_global_settings',
    'filename' => 'product_margin_global_settings.html',
    'title' => 'Глобальные настройки',
    'parent' => 'product_margin',
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