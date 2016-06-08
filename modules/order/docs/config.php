<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'orders',
    'filename' => 'orders.html',
    'title' => 'Заказы',
    'parent' => '',
    'sort' => 101
);

$pageArray[] = array(
    'key' => 'orders_show_all',
    'filename' => 'orders_show_all.html',
    'title' => 'Просмотр всех заказов',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_filtration_panel',
    'filename' => 'orders_filtration_panel.html',
    'title' => 'Панель фильтрации заказов',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_fast_manage_panel',
    'filename' => 'orders_fast_manage_panel.html',
    'title' => 'Панель быстрого управления заказами',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_add',
    'filename' => 'orders_add.html',
    'title' => 'Добавление нового заказа',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_import_export_excel',
    'filename' => 'orders_import_export_excel.html',
    'title' => 'Импорт и экспорт Excel',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_edit_and_inspect',
    'filename' => 'orders_edit_and_inspect.html',
    'title' => 'Просмотр и редактирование заказа',
    'parent' => 'orders',
);

$pageArray[] = array(
    'key' => 'orders_tasks_manage',
    'filename' => 'orders_tasks_manage.html',
    'title' => 'Управление задачами заказа',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_products_manage',
    'filename' => 'orders_products_manage.html',
    'title' => 'Управление продуктами заказа',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_docs_manage',
    'filename' => 'orders_docs_manage.html',
    'title' => 'Управление документами заказа',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_storage',
    'filename' => 'orders_storage.html',
    'title' => 'Просмотр складов',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_finance',
    'filename' => 'orders_finance.html',
    'title' => 'Просмотр финансов',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_events',
    'filename' => 'orders_events.html',
    'title' => 'События',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_performers',
    'filename' => 'orders_performers.html',
    'title' => 'Исполнители',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_contacts',
    'filename' => 'orders_contacts.html',
    'title' => 'Контакты',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_history',
    'filename' => 'orders_history.html',
    'title' => 'История',
    'parent' => 'orders_edit_and_inspect',
);

$pageArray[] = array(
    'key' => 'orders_files',
    'filename' => 'orders_files.html',
    'title' => 'Файлы',
    'parent' => 'orders_edit_and_inspect',
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