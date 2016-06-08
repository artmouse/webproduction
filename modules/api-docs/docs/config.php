<?php

$pageArray = array();

/*
 * STANDARDS
 */
$pageArray[] = array(
    'key' => 'standards',
    'filename' => 'standards.html',
    'title' => 'Стандарты',
    'parent' => '',
    'sort' => 901
);

$pageArray[] = array(
    'key' => 'standard_developer_issue',
    'filename' => 'standard_developer_issue.html',
    'title' => 'Стандарт: Правила выполнения задач для разработчиков',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_issue',
    'filename' => 'standard_issue.html',
    'title' => 'Стандарт: Правила постановки технических задач',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_issue_integration',
    'filename' => 'standard_issue_integration.html',
    'title' => 'Стандарт: Как правильно ставить задачи по интеграциям?',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_issue_report',
    'filename' => 'standard_issue_report.html',
    'title' => 'Стандарт: Как правильно ставить задачи по разработке отчетов?',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_issue_block',
    'filename' => 'standard_issue_block.html',
    'title' => 'Стандарт: Как правильно ставить задачи по разработке блоков (block) для OneBox?',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_issue_action',
    'filename' => 'standard_issue_action.html',
    'title' => 'Стандарт: Как правильно ставить задачи по разработке действий (Action) для OneBox?',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_codestyle_php',
    'filename' => 'standard_codestyle_php.html',
    'title' => 'Стандарт: Стиль кодирования PHP',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_codestyle_db',
    'filename' => 'standard_codestyle_db.html',
    'title' => 'Стандарт: Стиль именований в БД (MySQL, MariaDB)',
    'parent' => 'standards',
);

$pageArray[] = array(
    'key' => 'standard_codestyle_frontend',
    'filename' => 'standard_codestyle_frontend.html',
    'title' => 'Стандарт: Стиль кодирования HTML, CSS, JavaScript',
    'parent' => 'standards',
);
$pageArray[] = array(
    'key' => 'standard_graceful_degradation',
    'filename' => 'standard_graceful_degradation.html',
    'title' => 'Стандарт: Graceful degradation',
    'parent' => 'standards',
);

/*
 * INSTRUCTIONS
 */
$pageArray[] = array(
    'key' => 'instructions',
    'filename' => 'instructions.html',
    'title' => 'Инструкции',
    'parent' => '',
    'sort' => 901
);

$pageArray[] = array(
    'key' => 'onebox-architecture',
    'filename' => 'onebox_architecture.html',
    'title' => 'Общая архитектура системы OneBox',
    'parent' => 'instructions',
    'tagArray' => array('архитектура', 'сервисы')
);

$pageArray[] = array(
    'key' => 'onebox-mode',
    'filename' => 'onebox_mode.html',
    'title' => 'Режимы работы движка и OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'how-to-make-documentation',
    'filename' => 'how_to_make_documentation.html',
    'title' => 'Правила разработки документации для OneBox. Как писать документацию?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'license',
    'filename' => 'license.html',
    'title' => 'Лицензия и ограничения OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'how_to_unload_onebox',
    'filename' => 'how_to_unload_onebox.html',
    'title' => 'Как правильно выгрузить OneBox со всеми модулями',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'how_add_module_to_svn',
    'filename' => 'how_add_module_to_svn.html',
    'title' => 'Как добавить свой модуль в репозиторий svn',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'category-logicclass',
    'filename' => 'category_logicclass.html',
    'title' => 'Поле "Класс-обработчик" в категории',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'acl-in-onebox',
    'filename' => 'acl_in_onebox.html',
    'title' => 'Что такое ACL в OneBox?',
    'parent' => 'instructions',
    'tagArray' => array('acl', 'права доступа'),
);

$pageArray[] = array(
    'key' => 'howto-kpi',
    'filename' => 'howto_kpi.html',
    'title' => 'Что такое KPI и как их разрабатывать?',
    'parent' => 'instructions',
    'tagArray' => array('KPI'),
);

$pageArray[] = array(
    'key' => 'howto-smartgroups',
    'filename' => 'howto_smartgroups.html',
    'title' => 'Что такое умные группы контактов контактов и как их разрабатывать (smart-обработчики)?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'howto-import-onebox',
    'filename' => 'howto_import_onebox.html',
    'title' => 'Инструкция по вливанию данных клиентов в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'howto_create_individual_doc_tamplates',
    'filename' => 'howto_create_individual_doc_tamplates.html',
    'title' => 'Инструкция по созданию индивидуальных шаблонов документов для OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'status-action',
    'filename' => 'status_action.html',
    'title' => 'Как правильно писать действия (Workflow Action)?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'status-ui',
    'filename' => 'status_ui.html',
    'title' => 'Как правильно писать блоки к OneBox Block UI',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'oneclick_blocks',
    'filename' => 'oneclick_blocks.html',
    'title' => 'Как правильно писать блоки к интерфейсу интернет-магазина? (shop blocks)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'howto_delete_data_onebox',
    'filename' => 'howto_delete_data_onebox.html',
    'title' => 'Как правильно удалять данные в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'settings_howto',
    'filename' => 'settings_howto.html',
    'title' => 'Управление глобальными настройками (Settings)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'engine_config',
    'filename' => 'engine_config.html',
    'title' => 'Что такое конфиг-параметры engine.mode.php?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'packages_types',
    'filename' => 'packages_types.html',
    'title' => 'Типы пакетов в packages',
    'parent' => 'instructions',
    'tagArray' => array('wpp', 'package', 'packages', 'пакет', 'пакеты'),
);

$pageArray[] = array(
    'key' => 'updater_howto',
    'filename' => 'updater_howto.html',
    'title' => 'Как правильно обновлять систему (updater)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'updater_migrations',
    'filename' => 'updater_migrations.html',
    'title' => 'Как правильно писать миграции (updater, обновления)',
    'parent' => 'instructions',
    'tagArray' => array('updater', 'updater.sh'),
);

$pageArray[] = array(
    'key' => 'sqlobject_field_override',
    'filename' => 'sqlobject_field_override.html',
    'title' => 'SQLObject: подмена полей. override getField() и setField()',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'sqlobject_events',
    'filename' => 'sqlobject_events.html',
    'title' => 'SQLObject: события (events)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'onebox_comment_types',
    'filename' => 'onebox_comment_types.html',
    'title' => 'OneBox: система комментариев и типы комментариев',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'howto_parsers',
    'filename' => 'howto_parsers.html',
    'title' => 'Как правильно разрабатывать парсера данных и вливать данные в OneBox?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'services_override',
    'filename' => 'services_override.html',
    'title' => 'Подмена/переопределение сервисов (services) в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'contents_override',
    'filename' => 'contents_override.html',
    'title' => 'Подмена/переопределение контентов (contents) в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'create_modules',
    'filename' => 'create_modules.html',
    'title' => 'Как создать модуль OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'add_cron_notify',
    'filename' => 'add_cron_notify.html',
    'title' => 'Работа с cron-скриптами в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'override_menu_modules',
    'filename' => 'override_menu_modules.html',
    'title' => 'Как переопределять меню OneBox из под модулей? И как создать контент?',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'view_tasks_and_contacts',
    'filename' => 'view_tasks_and_contacts.html',
    'title' => 'Способы отображения задач и контактов в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'substitute_user_sudo',
    'filename' => 'substitute_user_sudo.html',
    'title' => 'Подмена пользователя в OneBox (sudo)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'onebox_server_requirements',
    'filename' => 'onebox_server_requirements.html',
    'title' => 'Требования к серверу для OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'onebox_deploy_amazino',
    'filename' => 'onebox_deploy_amazino.html',
    'title' => 'Как выгружать OneBox на Amazino',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'onebox_custom_banners',
    'filename' => 'onebox_custom_banners.html',
    'title' => 'Как добавлять кастомные баннера в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'transfer_from_oneserver_to_another',
    'filename' => 'transfer_from_oneserver_to_another.html',
    'title' => 'Инструкция по переносу с сервера на сервер',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'instruction_image_size',
    'filename' => 'instruction_image_size.html',
    'title' => 'Задать размер картинок в карточке товара',
    'parent' => 'instructions',
);



/*
 * INTEGRATIONS BOX WITH OTHER SYSTEMS
 */

$pageArray[] = array(
    'key' => 'integration_code1c_onebox',
    'filename' => 'integration_code1c_onebox.html',
    'title' => 'Интеграция 1С и OneBox по заказам и пользователям используя code1c',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration',
    'filename' => 'integration.html',
    'title' => 'Интеграции',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'integration_1c',
    'filename' => 'integration_1c.html',
    'title' => 'Инструкция интеграции OneBox и сторонних систем (1С)',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_smtp',
    'filename' => 'integration_smtp.html',
    'title' => 'Интеграция OneBox и SMTP',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_telephony_define_context',
    'filename' => 'integration_telephony_define_context.html',
    'title' => 'Определение контекстов для интеграции с телефонией',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_originate_calls',
    'filename' => 'integration_originate_calls.html',
    'title' => 'Интеграция OneBox и телефонии - оригинация звонков',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_imap',
    'filename' => 'integration_imap.html',
    'title' => 'Интеграция OneBox с IMAP',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_history_calls_cdr_ftp_http',
    'filename' => 'integration_history_calls_cdr_ftp_http.html',
    'title' => 'Интеграция OneBox и телефонии - история звонков (CDR, FTP, HTTP)',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'integration_asterisk_popup_window',
    'filename' => 'integration_asterisk_popup_window.html',
    'title' => 'Интеграция OneBox и Asterisk: всплывающее окошко',
    'parent' => 'integration',
);

$pageArray[] = array(
    'key' => 'mail_templates',
    'filename' => 'mail_templates.html',
    'title' => 'Как создавать шаблоны для писем в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'work_userservice',
    'filename' => 'work_userservice.html',
    'title' => 'Работа с пользователями и контактами в OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'work_currencyservice',
    'filename' => 'work_currencyservice.html',
    'title' => 'Работа с валютой в системе OneBox',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'work_translateservice',
    'filename' => 'work_translateservice.html',
    'title' => 'Система переводов (TranslateService)',
    'parent' => 'instructions',
);

$pageArray[] = array(
    'key' => 'work_processorque',
    'filename' => 'work_processorque.html',
    'title' => 'Отложенные обрабочики, очередь ProcessorQue',
    'parent' => 'instructions',
);

/*
 * OneBox UI
 */

$pageArray[] = array(
    'key' => 'box_ui',
    'filename' => 'box_ui.html',
    'title' => 'OneBox UI',
    'parent' => '',
    'sort' => 909
);

$pageArray[] = array(
    'key' => 'box_ui_tables',
    'filename' => 'box_ui_tables.html',
    'title' => 'Таблицы',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_buttons',
    'filename' => 'box_ui_buttons.html',
    'title' => 'Кнопки',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_progressbar',
    'filename' => 'box_ui_progressbar.html',
    'title' => 'Прогрессбар',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_icons',
    'filename' => 'box_ui_icons.html',
    'title' => 'Иконки и ссылки',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_statuses',
    'filename' => 'box_ui_statuses.html',
    'title' => 'Статусы и идентификаторы',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_tabs',
    'filename' => 'box_ui_tabs.html',
    'title' => 'Вкладки',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_radiogroup',
    'filename' => 'box_ui_radiogroup.html',
    'title' => 'Радиогруппы',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_stepper',
    'filename' => 'box_ui_stepper.html',
    'title' => 'Пагинация',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_elements',
    'filename' => 'box_ui_elements.html',
    'title' => 'Основные элементы форм',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_elements_marked',
    'filename' => 'box_ui_elements_marked.html',
    'title' => 'Элементы для выделения контента',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_dropdown_option',
    'filename' => 'box_ui_dropdown_option.html',
    'title' => 'Выпадающие опции',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_messages',
    'filename' => 'box_ui_messages.html',
    'title' => 'Сообщения',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_rating',
    'filename' => 'box_ui_rating.html',
    'title' => 'Рейтинг',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_doubleform',
    'filename' => 'box_ui_doubleform.html',
    'title' => 'Двойные формы',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_form',
    'filename' => 'box_ui_form.html',
    'title' => 'Обычные формы',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_block',
    'filename' => 'box_ui_block.html',
    'title' => 'Логические блоки',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_dataelement',
    'filename' => 'box_ui_dataelement.html',
    'title' => 'Дата блоки',
    'parent' => 'box_ui',
);

$pageArray[] = array(
    'key' => 'box_ui_avatar',
    'filename' => 'box_ui_avatar.html',
    'title' => 'Аватар пользователя',
    'parent' => 'box_ui',
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