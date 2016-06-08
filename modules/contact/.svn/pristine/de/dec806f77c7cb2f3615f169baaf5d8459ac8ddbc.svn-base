<?php

$pageArray = array();

$pageArray[] = array(
    'key' => 'contact',
    'filename' => 'contact.html',
    'title' => 'Контакты',
    'parent' => '',
    'sort' => 91
);

$pageArray[] = array(
    'key' => 'contact_view_all',
    'filename' => 'contact_view_all.html',
    'title' => 'Просмотр всех контактов',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_private_and_legal_persons',
    'filename' => 'contact_private_and_legal_persons.html',
    'title' => 'Физические и юридические лица',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_filtration_panel',
    'filename' => 'contact_filtration_panel.html',
    'title' => 'Панель фильтрации контактов',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_fast_manage_panel',
    'filename' => 'contact_fast_manage_panel.html',
    'title' => 'Панель быстрого управления контактами',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_add',
    'filename' => 'contact_add.html',
    'title' => 'Добавление контакта',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_mass_mailing',
    'filename' => 'contact_mass_mailing.html',
    'title' => 'Массовая рассылка',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_templates_for_letters',
    'filename' => 'contact_templates_for_letters.html',
    'title' => 'Добавление шаблонов для писем',
    'parent' => 'contact_mass_mailing',
);

$pageArray[] = array(
    'key' => 'contact_import_export_excel',
    'filename' => 'contact_import_export_excel.html',
    'title' => 'Импорт и экспорт Excel',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_edit',
    'filename' => 'contact_edit.html',
    'title' => 'Редактирование контакта',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_common_info',
    'filename' => 'contact_common_info.html',
    'title' => 'Общая информация о контакте',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_events',
    'filename' => 'contact_events.html',
    'title' => 'События',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_schedule',
    'filename' => 'contact_schedule.html',
    'title' => 'Рабочий график',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_related_processes',
    'filename' => 'contact_related_processes.html',
    'title' => 'Проекты, задачи, заказы, связанные с контактом',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_statistic',
    'filename' => 'contact_statistic.html',
    'title' => 'Статистика контакта',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_legal',
    'filename' => 'contact_legal.html',
    'title' => 'Юридические реквизиты контакта',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_permissions',
    'filename' => 'contact_permissions.html',
    'title' => 'Права доступа',
    'parent' => 'contact_edit',
);

$pageArray[] = array(
    'key' => 'contact_groups',
    'filename' => 'contact_groups.html',
    'title' => 'Группы контактов',
    'parent' => 'contact',
);

$pageArray[] = array(
    'key' => 'contact_fields',
    'filename' => 'contact_fields.html',
    'title' => 'Поля контактов',
    'parent' => 'contact',
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