<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'storage',
    'filename' => 'storage.html',
    'title' => 'Склады',
    'parent' => '',
    'sort' => 121
);

$pageArray[] = array(
    'key' => 'storage_add_and_edit',
    'filename' => 'storage_add_and_edit.html',
    'title' => 'Добавление и редактирование складов',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_receipt',
    'filename' => 'storage_receipt.html',
    'title' => 'Оприходование продуктов',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_movement',
    'filename' => 'storage_movement.html',
    'title' => 'Переместить продукты',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_write_off',
    'filename' => 'storage_write_off.html',
    'title' => 'Списание со склада',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_shipment',
    'filename' => 'storage_shipment.html',
    'title' => 'Отгрузить заказ',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_production',
    'filename' => 'storage_production.html',
    'title' => 'Производство продуктов',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_product_passport',
    'filename' => 'storage_product_passport.html',
    'title' => 'Паспорта продуктов',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_balance',
    'filename' => 'storage_balance.html',
    'title' => 'Остатки на складах',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_balance_employees',
    'filename' => 'storage_balance_employees.html',
    'title' => 'Остатки у сотрудников',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_balance_report',
    'filename' => 'storage_balance_report.html',
    'title' => 'Отчет об изменении баланса',
    'parent' => 'storage',
);

$pageArray[] = array(
    'key' => 'storage_journal',
    'filename' => 'storage_journal.html',
    'title' => 'Журнал',
    'parent' => 'storage',
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