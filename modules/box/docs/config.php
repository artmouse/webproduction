<?php

$pageArray = array();

/*
 * ONEBOX GLOSSARY
 */
$pageArray[] = array(
    'key' => 'box_glossary',
    'filename' => 'glossary.html',
    'title' => 'OneBox. Терминология',
    'parent' => '',
    'sort' => 1
);

$pageArray[] = array(
    'key' => 'glossary_menu_icons',
    'filename' => 'glossary_menu_icons.html',
    'title' => 'Иконки вертикального меню',
    'parent' => 'box_glossary',
);

/*
 * CALENDAR
 */
$pageArray[] = array(
    'key' => 'calendar',
    'filename' => 'calendar.html',
    'title' => 'Календарь',
    'parent' => '',
    'sort' => 31
);

$pageArray[] = array(
    'key' => 'ways_of_display',
    'filename' => 'calen_displays.html',
    'title' => 'Способы отображения',
    'parent' => 'calendar',
);

$pageArray[] = array(
    'key' => 'view_calendar',
    'filename' => 'view_calendar.html',
    'title' => 'Способ отображения «Календарем»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_list',
    'filename' => 'view_list.html',
    'title' => 'Способ отображения «Списком»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_chart_gannt',
    'filename' => 'view_chart_gannt.html',
    'title' => 'Способ отображения «Диаграммой Гантта»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_vortex',
    'filename' => 'view_vortex.html',
    'title' => 'Способ отображения «Воронкой»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_status',
    'filename' => 'view_status.html',
    'title' => 'Способ отображения «Статусами»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_levels',
    'filename' => 'view_levels.html',
    'title' => 'Способ отображения «Статистикой этапов»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_mind_map',
    'filename' => 'view_mind_map.html',
    'title' => 'Способ отображения «Mind Map»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'view_on_map',
    'filename' => 'view_on_map.html',
    'title' => 'Способ отображения «На карте»',
    'parent' => 'ways_of_display',
);

$pageArray[] = array(
    'key' => 'calen_filter',
    'filename' => 'calen_filter.html',
    'title' => 'Панель фильтрации',
    'parent' => 'calendar',
);

$pageArray[] = array(
    'key' => 'calen_add_tasks_and_orders',
    'filename' => 'calen_add_tasks_and_orders.html',
    'title' => 'Добавление задач и заказов через календарь',
    'parent' => 'calendar',
);

/*
 * TASKS
 */
$pageArray[] = array(
    'key' => 'tasks',
    'filename' => 'tasks.html',
    'title' => 'Задачи',
    'parent' => '',
    'sort' => 51
);

$pageArray[] = array(
    'key' => 'show_all_tasks',
    'filename' => 'show_all_tasks.html',
    'title' => 'Просмотр всех задач',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_edit',
    'filename' => 'tasks_edit.html',
    'title' => 'Редактирование задачи',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_adding',
    'filename' => 'tasks_adding.html',
    'title' => 'Добавление задачи',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_adding_subtasks',
    'filename' => 'tasks_adding_subtasks.html',
    'title' => 'Создание подзадач',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_send_letter',
    'filename' => 'tasks_send_letter.html',
    'title' => 'Написать письмо из задачи',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_fast_manage_panel',
    'filename' => 'tasks_fast_manage_panel.html',
    'title' => 'Панель быстрого управления задачами',
    'parent' => 'tasks',
);

$pageArray[] = array(
    'key' => 'tasks_filtration',
    'filename' => 'tasks_filtration.html',
    'title' => 'Панель фильтрации задач',
    'parent' => 'tasks',
);

/*
 * PROJECTS
 */
$pageArray[] = array(
    'key' => 'projects',
    'filename' => 'projects.html',
    'title' => 'Проекты',
    'parent' => '',
    'sort' => 41
);

$pageArray[] = array(
    'key' => 'projects_list',
    'filename' => 'projects_list.html',
    'title' => 'Просмотр всех проектов',
    'parent' => 'projects',
);

$pageArray[] = array(
    'key' => 'projects_info_and_edit',
    'filename' => 'projects_info_and_edit.html',
    'title' => 'Просмотр информации о проекте и редактирование проекта',
    'parent' => 'projects',
);

$pageArray[] = array(
    'key' => 'projects_tasks_manage',
    'filename' => 'projects_tasks_manage.html',
    'title' => 'Управление задачами проекта',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_orders_manage',
    'filename' => 'projects_orders_manage.html',
    'title' => 'Управление заказами проекта',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_product_manage',
    'filename' => 'projects_product_manage.html',
    'title' => 'Управление продуктами проекта',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_document_manage',
    'filename' => 'projects_document_manage.html',
    'title' => 'Управление документами проекта',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_storage',
    'filename' => 'projects_storage.html',
    'title' => 'Просмотр складов',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_finance',
    'filename' => 'projects_finance.html',
    'title' => 'Просмотр финансов',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_events',
    'filename' => 'projects_events.html',
    'title' => 'События',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_performers',
    'filename' => 'projects_performers.html',
    'title' => 'Исполнители',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_contacts',
    'filename' => 'projects_contacts.html',
    'title' => 'Контакты',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_history',
    'filename' => 'projects_history.html',
    'title' => 'История',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_files',
    'filename' => 'projects_files.html',
    'title' => 'Файлы',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_business_proc_manage',
    'filename' => 'projects_business_proc_manage.html',
    'title' => 'Управление бизнес-процессом проекта',
    'parent' => 'projects_info_and_edit',
);

$pageArray[] = array(
    'key' => 'projects_add',
    'filename' => 'projects_add.html',
    'title' => 'Добавление проекта',
    'parent' => 'projects',
);

$pageArray[] = array(
    'key' => 'projects_fast_manage_panel',
    'filename' => 'projects_fast_manage_panel.html',
    'title' => 'Панель быстрого управления проектами',
    'parent' => 'projects',
);

$pageArray[] = array(
    'key' => 'projects_filtration_panel',
    'filename' => 'projects_filtration_panel.html',
    'title' => 'Панель фильтрации проектов',
    'parent' => 'projects',
);

/*
 * BUSINESS-PROCESS
 */
$pageArray[] = array(
    'key' => 'business_proc',
    'filename' => 'business_proc.html',
    'title' => 'Бизнес-процессы',
    'parent' => '',
    'sort' => 21
);

$pageArray[] = array(
    'key' => 'business_proc_show_all',
    'filename' => 'business_proc_show_all.html',
    'title' => 'Просмотр всех бизнес-процессов',
    'parent' => 'business_proc',
);

$pageArray[] = array(
    'key' => 'business_proc_create',
    'filename' => 'business_proc_create.html',
    'title' => 'Создание бизнес-процесса',
    'parent' => 'business_proc',
);

$pageArray[] = array(
    'key' => 'business_proc_common_settings',
    'filename' => 'business_proc_common_settings.html',
    'title' => 'Общие настройки бизнес-процесса',
    'parent' => 'business_proc',
);

$pageArray[] = array(
    'key' => 'business_proc_level_add',
    'filename' => 'business_proc_level_add.html',
    'title' => 'Добавление этапов бизнес-процесса',
    'parent' => 'business_proc',
);

$pageArray[] = array(
    'key' => 'business_proc_setup_level',
    'filename' => 'business_proc_setup_level.html',
    'title' => 'Настройка этапов бизнес-процесса',
    'parent' => 'business_proc',
);

$pageArray[] = array(
    'key' => 'business_proc_interface',
    'filename' => 'business_proc_interface.html',
    'title' => 'Настройка этапов бизнес-процесса: интерфейс',
    'parent' => 'business_proc_setup_level',
);

$pageArray[] = array(
    'key' => 'business_proc_action',
    'filename' => 'business_proc_action.html',
    'title' => 'Настройка этапов бизнес-процесса: действие',
    'parent' => 'business_proc_setup_level',
);

$pageArray[] = array(
    'key' => 'business_proc_types',
    'filename' => 'business_proc_types.html',
    'title' => 'Типы бизнес-процессов',
    'parent' => 'business_proc',
);

/*
 * STRUCTURE
 */
$pageArray[] = array(
    'key' => 'structure',
    'filename' => 'structure.html',
    'title' => 'Структура',
    'parent' => '',
    'sort' => 71
);

$pageArray[] = array(
    'key' => 'structure_view',
    'filename' => 'structure_view.html',
    'title' => 'Просмотр структуры',
    'parent' => 'structure',
);

$pageArray[] = array(
    'key' => 'structure_role_manage',
    'filename' => 'structure_role_manage.html',
    'title' => 'Управление ролями',
    'parent' => 'structure',
);

/*
 * EVENTS
 */
$pageArray[] = array(
    'key' => 'events',
    'filename' => 'events.html',
    'title' => 'События',
    'parent' => '',
    'sort' => 61
);

$pageArray[] = array(
    'key' => 'events_show_all_and_actions',
    'filename' => 'events_show_all_and_actions.html',
    'title' => 'Просмотр всех событий и действия над событием',
    'parent' => 'events',
);

$pageArray[] = array(
    'key' => 'events_filtration_panel',
    'filename' => 'events_filtration_panel.html',
    'title' => 'Панель фильтрации',
    'parent' => 'events',
);

/*
 * REPORTS
 */
$pageArray[] = array(
    'key' => 'reports',
    'filename' => 'reports.html',
    'title' => 'Отчеты',
    'parent' => '',
    'sort' => 151
);

$pageArray[] = array(
    'key' => 'reports_constructor',
    'filename' => 'reports_constructor.html',
    'title' => 'Конструктор отчетов',
    'parent' => 'reports',
);

$pageArray[] = array(
    'key' => 'reports_order_levels',
    'filename' => 'reports_order_levels.html',
    'title' => 'Этапы заказов',
    'parent' => 'reports',
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