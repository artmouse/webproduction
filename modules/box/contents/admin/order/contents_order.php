<?php
Engine::GetContentDataSource()->registerContent(
    'shop-admin-orders-employer',
    array(
        'title' => 'Employer of order',
        'url' => array(
            '/admin/shop/orders/{id}/employer/',
            '/admin/issue/{id}/employer/', '/admin/customorder/{type}/{id}/employer/'
        ),
        'filehtml' => dirname(__FILE__).'/tab/orders_employer.html',
        'filephp' => dirname(__FILE__).'/tab/orders_employer.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-orders-contacts',
    array(
        'title' => 'Contacts of order',
        'url' => array(
            '/admin/shop/orders/{id}/contact/',
            '/admin/issue/{id}/contact/',
            '/admin/customorder/{type}/{id}/contact/'
        ),
        'filehtml' => dirname(__FILE__).'/tab/orders_contacts.html',
        'filephp' => dirname(__FILE__).'/tab/orders_contacts.php',
        'filejs' => dirname(__FILE__).'/tab/orders_contact.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-order-event',
    array(
        'title' => 'Events of order',
        'url' => array('/admin/shop/orders/{id}/event/', '/admin/customorder/{type}/{id}/event/'),
        'filehtml' => dirname(__FILE__).'/tab/order_event.html',
        'filephp' => dirname(__FILE__).'/tab/order_event.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-orders-log',
    array(
        'title' => 'Log of order',
        'url' => array('/admin/shop/orders/{id}/log/', '/admin/customorder/{type}/{id}/log/'),
        'filehtml' => dirname(__FILE__).'/tab/orders_log.html',
        'filephp' => dirname(__FILE__).'/tab/orders_log.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-orders-files',
    array(
        'title' => 'Order files',
        'url' => array('/admin/shop/orders/{id}/files/', '/admin/customorder/{type}/{id}/files/'),
        'filehtml' => dirname(__FILE__).'/tab/orders_files.html',
        'filephp' => dirname(__FILE__).'/tab/orders_files.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-status-index',
    array(
        'filehtml' => dirname(__FILE__).'/mode/status/issue_status_index.html',
        'filephp' => dirname(__FILE__).'/mode/status/issue_status_index.php',
        'filejs' => dirname(__FILE__).'/mode/status/issue_status_index.js',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'calendar-block',
    array(
        'filehtml' => dirname(__FILE__).'/mode/calendar/calendar_block.html',
        'filephp' => dirname(__FILE__).'/mode/calendar/calendar_block.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'calendar-block-issue', array(
        'filehtml' => dirname(__FILE__).'/mode/calendar/calendar_block_issue.html',
        'filephp' => dirname(__FILE__).'/mode/calendar/calendar_block_issue.php',
    ),
    'override'
);

// обновление задачи в календаре
Engine::GetContentDataSource()->registerContent(
    'calendar-issue-update-ajax',
    array(
        'url' => '/calendar/issue/update/',
        'filephp' => dirname(__FILE__).'/mode/calendar/calendar_issue_update.php',
        'level' => '2',
    ),
    'override'
);

// ajax переключатель месяцев календаря
Engine::GetContentDataSource()->registerContent(
    'calendar-block-load-ajax',
    array(
        'url' => '/admin/shop/calendal/load/month/ajax/',
        'filephp' => dirname(__FILE__).'/mode/calendar/calendar_block_load_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'gantt-index',
    array(
        'filehtml' => dirname(__FILE__).'/mode/gantt/gantt_index.html',
        'filephp' => dirname(__FILE__).'/mode/gantt/gantt_index.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'gantt-row-block', array(
        'filehtml' => dirname(__FILE__).'/mode/gantt/gantt_row_block.html',
        'filephp' => dirname(__FILE__).'/mode/gantt/gantt_row_block.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'gantt-update', array(
        'url' => '/admin/gantt/update/',
        'filephp' => dirname(__FILE__).'/mode/gantt/gantt_update.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'gantt-update-parent',
    array(
        'url' => '/admin/gantt/update/parent/',
        'filephp' => dirname(__FILE__).'/mode/gantt/gantt_update_parent.php',
        'level' => '2',
    ),
    'override'
);


Engine::GetContentDataSource()->registerContent(
    'maps-index',
    array(
        'title' => 'Maps',
        'url' => '/admin/maps/',
        'filehtml' => dirname(__FILE__).'/mode/maps/maps_index.html',
        'filephp' => dirname(__FILE__).'/mode/maps/maps_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'funnel-index',
    array(
        'title' => 'Funnel',
        'url' => '/admin/funnel/',
        'filehtml' => dirname(__FILE__).'/mode/funnel/funnel_index.html',
        'filephp' => dirname(__FILE__).'/mode/funnel/funnel_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'funnel-chart-index',
    array(
        'filehtml' => dirname(__FILE__).'/mode/funnel/funnel_chart_index.html',
        'filephp' => dirname(__FILE__).'/mode/funnel/funnel_chart_index.php',
        'filejs' => dirname(__FILE__).'/mode/funnel/funnel_chart_index.js',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'mind-index',
    array(
        'title' => 'Mind',
        'url' => '/admin/mind/{id}/',
        'filehtml' => dirname(__FILE__).'/mode/mind/mind_index.html',
        'filephp' => dirname(__FILE__).'/mode/mind/mind_index.php',
        'filejs' => array(
            dirname(__FILE__).'/mode/mind/d3.v3.min.js',
            dirname(__FILE__).'/mode/mind/mind_index.js',
            dirname(__FILE__).'/mode/mind/issue.api.js'
        ),
        'filecss' => dirname(__FILE__).'/mode/mind/mind_index.css',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-add',
    array(
        'url' => '/admin/mind/issue/ajax/add/',
        'filephp' => dirname(__FILE__).'/mode/mind/issue_ajax_add.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-update',
    array(
        'url' => '/admin/mind/issue/ajax/update/',
        'filephp' => dirname(__FILE__).'/mode/mind/issue_ajax_update.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-delete',
    array(
        'url' => '/admin/mind/issue/ajax/delete/',
        'filephp' => dirname(__FILE__).'/mode/mind/issue_ajax_delete.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-get', array(
        'url' => '/admin/mind/issue/ajax/get/',
        'filephp' => dirname(__FILE__).'/mode/mind/issue_ajax_get.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-edit',
    array(
        'url' => '/admin/mind/issue/ajax/edit/',
        'filephp' => dirname(__FILE__).'/mode/mind/issue_ajax_edit.php',
        'level' => '2'
    ),
    'override'
);