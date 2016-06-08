<?php

class Box_Contents implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/contents/';
        $pathProject = PackageLoader::Get()->getProjectPath();

        if (!Engine::Get()->getConfigFieldSecure('oneclick-enable')) {
            Engine::GetContentDataSource()->registerContent(
                'shop-tpl',
                array(
                    'filehtml' => $path.'/shop_tpl.html',
                    'filejsremove' => true,
                    'filephp' => $path.'/shop_tpl.php',
                    'filecssremove' => true,
                    'filecss' => array(
                        $pathProject.'/contents/shop/admin/admin_shop_tpl.css',
                        $path.'/box_auth_tpl.css'
                    )
                ), 'extend'
            );

            Engine::GetContentDataSource()->registerContent(
                '403',
                array(
                'filehtml' => $path.'/error403.html',
                'filephp' => $path.'/error4xx.php',
                'moveto' => 'shop-tpl',
                'moveas' => 'content',
                ),
                'extend'
            );

            Engine::GetContentDataSource()->registerContent(
                '401',
                array(
                'filehtml' => $path.'/error401.html',
                'filephp' => $path.'/error4xx.php',
                'moveto' => 'shop-tpl',
                'moveas' => 'content',
                ),
                'extend'
            );
        }

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-tpl',
            array(
            'filehtml' => $path.'/admin/admin_shop_tpl.html',
            'filephp' => $path.'/admin/admin_shop_tpl_box.php',
            'filecss' => $path.'/admin/admin_shop_tpl_box.css',
            'filejs' => $path.'/admin/admin_shop_tpl.js',
            ),
            'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-menu-block',
            array(
                'filephp' => $path.'/admin/menu/box_admin_menu_block.php',
                'filehtml' => $path.'/admin/menu/box_admin_menu_block.html',
                'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('user')),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-ajax',
            array(
            'url' => '/admin/shop/search/custom/ajax/',
            'filephp' => $path.'/admin/search/admin_search_ajax.php',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-user',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_user.php',
            'filehtml' => $path.'/admin/search/admin_search_block_user.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-order',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_order.php',
            'filehtml' => $path.'/admin/search/admin_search_block_order.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-event',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_event.php',
            'filehtml' => $path.'/admin/search/admin_search_block_event.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-issue',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_issue.php',
            'filehtml' => $path.'/admin/search/admin_search_block_issue.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-product',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_product.php',
            'filehtml' => $path.'/admin/search/admin_search_block_product.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-search-block-document',
            array(
            'filephp' => $path.'/admin/search/admin_search_block_document.php',
            'filehtml' => $path.'/admin/search/admin_search_block_document.html'
            ),
            'override'
        );

        // настройка подзадач в workflow
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-subworkflow-block-workflow-status-edit',
            array(
                'filephp' => $path.'/admin/orderstatus/admin_sub_workflow_block.php',
                'filehtml' => $path.'/admin/orderstatus/admin_sub_workflow_block.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-workflow-status-interface',
            array(
                'title' => 'Workflows',
                'url' => '/admin/shop/workflowstatus/{id}/interface/',
                'filehtml' => $path.'/admin/orderstatus/workflow_status_interface.html',
                'filejs' => $path.'/admin/orderstatus/workflow_status_interface.js',
                'filephp' => $path.'/admin/orderstatus/workflow_status_interface.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        // настройка дополнительных полей в workflow
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-fields-block-workflow-status-edit',
            array(
                'filephp' => $path.'/admin/orderstatus/admin_fields_workflow_block.php',
                'filehtml' => $path.'/admin/orderstatus/admin_fields_workflow_block.html'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-notification-block',
            array(
            'filephp' => $path.'/admin/notification/admin_notification_block.php',
            'filehtml' => $path.'/admin/notification/admin_notification_block.html',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-notification-close-ajax',
            array(
            'url' => '/admin/notification/close/',
            'filephp' => $path.'/admin/notification/admin_notification_close_ajax.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-designer',
            array(
            'title' => 'Report Designer',
            'url' => '/admin/report/designer/',
            'filehtml' => $path.'/admin/report/admin_report_designer.html',
            'filejs' => $path.'/admin/report/admin_report_designer.js',
            'filephp' => $path.'/admin/report/admin_report_designer.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-worktime',
            array(
            'title' => 'Report work time',
            'url' => '/admin/report/worktime/',
            'filehtml' => $path.'/admin/report/admin_report_worktime.html',
            'filephp' => $path.'/admin/report/admin_report_worktime.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-massemailsend',
            array(
            'title' => 'Report mass send email',
            'url' => '/admin/report/massemailsend/',
            'filehtml' => $path.'/admin/report/admin_report_massemailsend.html',
            'filephp' => $path.'/admin/report/admin_report_massemailsend.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-daycalendar',
            array(
            'title' => 'Report day calendar',
            'url' => '/admin/report/daycalendar/',
            'filehtml' => $path.'/admin/report/admin_report_daycalendar.html',
            'filephp' => $path.'/admin/report/admin_report_daycalendar.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-comparekpi',
            array(
                'title' => 'Compare KPI',
                'url' => '/admin/report/comparekpi/',
                'filehtml' => $path.'/admin/report/report_comparekpi.html',
                'filephp' => $path.'/admin/report/report_comparekpi.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-comparekpi'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-projectcheck',
            array(
                'title' => 'Project check',
                'url' => '/admin/report/projectcheck/',
                'filehtml' => $path.'/admin/report/report_projectcheck.html',
                'filephp' => $path.'/admin/report/report_projectcheck.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-projectcheck'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-managermonitor',
            array(
                'title' => 'Report manager monitor',
                'url' => '/admin/report/managermonitor/',
                'filehtml' => $path.'/admin/report/report_managermonitor.html',
                'filephp' => $path.'/admin/report/report_managermonitor.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-report-callrouting',
            array(
            'title' => 'Report call routing',
            'url' => '/admin/shop/report/callrouting/',
            'filehtml' => $path.'/admin/report/report_callrouting.html',
            'filephp' => $path.'/admin/report/report_callrouting.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-holdusersperiod',
            array(
                'title' => 'Report hold users',
                'url' => '/admin/shop/report/holdusersperiod/',
                'filehtml' => $path.'/admin/report/report_holdusersperiod.html',
                'filephp' => $path.'/admin/report/report_holdusersperiod.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-performersorders',
            array(
                'title' => 'Исполнители заказов',
                'url' => '/admin/shop/report/performersorders/',
                'filehtml' => $path.'/admin/report/report_performersorders.html',
                'filephp' => $path.'/admin/report/report_performersorders.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => 2,
                'role' => array('performersorders-acl'),
            ),
            'override'
        );        
        
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-user-tab-files',
            array(
            'title' => 'Contact files',
            'url' => array('/admin/shop/users/{id}/files/'),
            'filehtml' => $path.'/admin/contacts/tab/user_files.html',
            'filephp' => $path.'/admin/contacts/tab/user_files.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-files',
            array(
            'title' => 'Files',
            'url' => '/admin/files/',
            'filehtml' => $path.'/admin/file/file_index.html',
            'filephp' => $path.'/admin/file/file_index.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-file-block-list',
            array(
            'filehtml' => $path.'/admin/file/file_block_list.html',
            'filephp' => $path.'/admin/file/file_block_list.php',
            'filejs' => $path.'/admin/file/file_block_list.js',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-file-control', array(
            'title' => 'Files',
            'url' => '/admin/file/{id}/',
            'filehtml' => $path.'/admin/file/file_control.html',
            'filephp' => $path.'/admin/file/file_control.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'kpi-index',
            array(
                'title' => 'KPI',
                'url' => '/admin/kpi/',
                'filehtml' => $path.'/kpi/kpi_index.html',
                'filephp' => $path.'/kpi/kpi_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'kpi-control',
            array(
                'title' => 'KPI',
                'url' => array('/admin/kpi/add/', '/admin/kpi/{key}/'),
                'filehtml' => $path.'/kpi/kpi_control.html',
                'filephp' => $path.'/kpi/kpi_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-user-tab-kpi',
            array(
                'title' => 'Contact KPI',
                'url' => array('/admin/shop/users/{id}/kpi/'),
                'filehtml' => $path.'/admin/contacts/tab/user_kpi.html',
                'filephp' => $path.'/admin/contacts/tab/user_kpi.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users_kpi')
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-user-tab-worktime',
            array(
                'title' => 'WorkTime',
                'url' => array('/admin/shop/users/{id}/worktime/'),
                'filehtml' => $path.'/admin/contacts/tab/user_worktime.html',
                'filephp' => $path.'/admin/contacts/tab/user_worktime.php',
                'filejs' => $path.'/admin/contacts/tab/user_worktime.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-role',
            array(
                'title' => 'role',
                'url' => '/admin/role/',
                'filehtml' => $path.'/role/role_index.html',
                'filephp' => $path.'/role/role_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-role-add',
            array(
                'title' => 'Add role',
                'url' => array('/admin/role/add/'),
                'filehtml' => $path.'/role/role_add.html',
                'filephp' => $path.'/role/role_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-role-control',
            array(
                'title' => 'Role',
                'url' => array('/admin/role/{key}/'),
                'filehtml' => $path.'/role/role_control.html',
                'filephp' => $path.'/role/role_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-productview-order-block',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_productview_order_block.html',
                'filephp' => $path.'/admin/block-order/box_block_productview_order_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-timelog-order-block',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_timelog_order_block.html',
                'filephp' => $path.'/admin/block-order/box_block_timelog_order_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-time-log',
            array(
                'title' => 'Time log',
                'url' => '/admin/shop/report/timelog/',
                'filehtml' => $path.'/admin/report/report_timelog.html',
                'filephp' => $path.'/admin/report/report_timelog.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-time-log'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-name',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_name.html',
                'filephp' => $path.'/admin/block-order/box_block_name.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-description',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_description.html',
                'filephp' => $path.'/admin/block-order/box_block_description.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-stage-instruction',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_stage_instruction.html',
                'filephp' => $path.'/admin/block-order/box_block_stage_instruction.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-stage-history',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_stage_history.html',
                'filephp' => $path.'/admin/block-order/box_block_stage_history.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-active-order',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_active_order.html',
                'filephp' => $path.'/admin/block-order/box_block_active_order.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-project-order',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_project_order.html',
                'filephp' => $path.'/admin/block-order/box_block_project_order.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-my-order',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_my_order.html',
                'filephp' => $path.'/admin/block-order/box_block_my_order.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-product-list',
            array(
                'url' => array('/admin/shop/customorder/add/product/ajax/'),
                'filehtml' => $path.'/admin/block-order/box_block_product_list.html',
                'filephp' => $path.'/admin/block-order/box_block_product_list.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-project-tree',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_project_tree.html',
                'filephp' => $path.'/admin/block-order/box_block_project_tree.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-comment-list',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_comment_list.html',
                'filephp' => $path.'/admin/block-order/box_block_comment_list.php',
                'filejs' => $path.'/admin/block-order/box_block_comment_list.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-info',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_info.html',
                'filephp' => $path.'/admin/block-order/box_block_info.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-client-info',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_client_info.html',
                'filephp' => $path.'/admin/block-order/box_block_client_info.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-status-info',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_status_info.html',
                'filephp' => $path.'/admin/block-order/box_block_status_info.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-graph-activities',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_graph_activities.html',
                'filephp' => $path.'/admin/block-order/box_block_graph_activities.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-graph-load',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_graph_load.html',
                'filephp' => $path.'/admin/block-order/box_block_graph_load.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-workflow-visual',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_workflow_visual.html',
                'filephp' => $path.'/admin/block-order/box_block_workflow_visual.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-product-list-short',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_product_list_short.html',
                'filephp' => $path.'/admin/block-order/box_block_product_list_short.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-files',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_files.html',
                'filephp' => $path.'/admin/block-order/box_block_files.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-client-info-full',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_client_info_full.html',
                'filephp' => $path.'/admin/block-order/box_block_client_info_full.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-make-result',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_make_result.html',
                'filephp' => $path.'/admin/block-order/box_block_make_result.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-write-letter',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_write_letter.html',
                'filephp' => $path.'/admin/block-order/box_block_write_letter.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-call',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_call.html',
                'filephp' => $path.'/admin/block-order/box_block_call.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-info-short',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_info_short.html',
                'filephp' => $path.'/admin/block-order/box_block_info_short.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-user-card-fill',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_user_card_fill.html',
                'filephp' => $path.'/admin/block-order/box_block_user_card_fill.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-issue-structure',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_issues_structure.html',
                'filephp' => $path.'/admin/block-order/box_block_issues_structure.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-issues-add',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_issues_add.html',
                'filephp' => $path.'/admin/block-order/box_block_issues_add.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-issues-like',
            array(
                'filehtml' => $path.'/admin/block-order/box_block_issues_like.html',
                'filephp' => $path.'/admin/block-order/box_block_issues_like.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-admin-block-issues-add-ajax',
            array(
                'url' => '/admin/block/issue/add/ajax/',
                'filehtml' => $path.'/admin/block-order/ajax/box_block_issues_add_ajax.html',
                'filephp' => $path.'/admin/block-order/ajax/box_block_issues_add_ajax.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-issue-no-on-time',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_issue_no_on_time.html',
                'filephp' => $path.'/admin/block-action/action_block_issue_no_on_time.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-change-status-overdue-dateto',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_change_status_overdue_dateto.html',
                'filephp' => $path.'/admin/block-action/action_block_change_status_overdue_dateto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-timelog-add',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_timelog_add.html',
                'filephp' => $path.'/admin/block-action/action_block_timelog_add.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-order-copy',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_order_copy.html',
                'filephp' => $path.'/admin/block-action/action_block_order_copy.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-client-notification-payment',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_client_notification_payment.html',
                'filephp' => $path.'/admin/block-action/action_block_client_notification_payment.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-order-closed-by-dateto',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_order_closed_by_dateto.html',
                'filephp' => $path.'/admin/block-action/action_block_order_closed_by_dateto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-role',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_role.html',
                'filephp' => $path.'/admin/block-action/action_block_role.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-auto-change-status-after-days',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_auto_change_status_after_days.html',
                'filephp' => $path.'/admin/block-action/action_block_auto_change_status_after_days.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-switch-status',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_switch_status.html',
                'filephp' => $path.'/admin/block-action/action_block_switch_status.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-status-change-auto',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_status_change_auto.html',
                'filephp' => $path.'/admin/block-action/action_block_status_change_auto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-manager-change',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_manager_change.html',
                'filephp' => $path.'/admin/block-action/action_block_manager_change.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-status-change-by-hand',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_status_change_by_hand.html',
                'filephp' => $path.'/admin/block-action/action_block_status_change_by_hand.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-status-not-change',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_status_not_change.html',
                'filephp' => $path.'/admin/block-action/action_block_status_not_change.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-notification-client-no-link',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_notification_client_no_link.html',
                'filephp' => $path.'/admin/block-action/action_block_notification_client_no_link.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-notification-client-no-link-phone',
            array(
                'filehtml' => $path.
                    '/admin/block-action/action_block_notification_client_no_link_phone.html',
                'filephp' => $path.'/admin/block-action/action_block_notification_client_no_link_phone.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-notification-client-no-link-email',
            array(
                'filehtml' => $path.
                    '/admin/block-action/action_block_notification_client_no_link_email.html',
                'filephp' => $path.'/admin/block-action/action_block_notification_client_no_link_email.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-auto-repeat-day',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_auto_repeat_day.html',
                'filephp' => $path.'/admin/block-action/action_block_auto_repeat_day.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-auto-repeat-week',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_auto_repeat_week.html',
                'filephp' => $path.'/admin/block-action/action_block_auto_repeat_week.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-auto-repeat-month',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_auto_repeat_month.html',
                'filephp' => $path.'/admin/block-action/action_block_auto_repeat_month.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-auto-transfer',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_auto_transfer.html',
                'filephp' => $path.'/admin/block-action/action_block_auto_transfer.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-sub-workflow2',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_sub_workflow.html',
                'filephp' => $path.'/admin/block-action/action_block_sub_workflow.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-client-order-send-email',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_client_order_send_email.html',
                'filephp' => $path.'/admin/block-action/action_block_client_order_send_email.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-notify-overdue',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_notify_overdue.html',
                'filephp' => $path.'/admin/block-action/action_block_notify_overdue.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'box-order-status-action-block-notice-overdue-dateto',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_notice_overdue_dateto.html',
                'filephp' => $path.'/admin/block-action/action_block_notice_overdue_dateto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-imap-config',
            array(
                'title' => 'IMAP config',
                'url' => '/admin/imap/',
                'filehtml' => $path.'/imap/imap_index.html',
                'filephp' => $path.'/imap/imap_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => 3,
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-forms-ithem',
            array(
                'title' => 'Forms',
                'url' => '/admin/forms/',
                'filehtml' => $path.'/admin/forms/forms_index.html',
                'filephp' => $path.'/admin/forms/forms_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => 2,
                'role' => array('forms-settings-control'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-forms-settings-edit',
            array(
                'title' => 'Forms edit',
                'url' => '/admin/forms/{id}/edit/',
                'filehtml' => $path.'/admin/forms/forms_index_edit.html',
                'filephp' => $path.'/admin/forms/forms_index_edit.php',
                'filejs' => $path.'/admin/forms/forms_index_edit.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => 2,
                'role' => array('forms-settings-control'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-form-order-page',
            array(
                'title' => 'Forms input',
                'url' => '/form/{id}/{key}/',
                'filehtml' => $path.'/admin/forms/form_order_page.html',
                'filecss' => $path.'/admin/forms/form_order_page.css',
                'filephp' => $path.'/admin/forms/form_order_page.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-imap-config-control',
            array(
                'title' => 'IMAP config control',
                'url' => array('/admin/imap/add/', '/admin/imap/{key}/'),
                'filehtml' => $path.'/imap/imap_control.html',
                'filephp' => $path.'/imap/imap_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => 3,
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call',
            array(
                'url' => '/admin/voip-call/',
                'filehtml' => $path.'/admin/voip/voip_call.html',
                'filephp' => $path.'/admin/voip/voip_call.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-callcenter',
            array(
                'url' => '/admin/voip-callcenter/',
                'filehtml' => $path.'/admin/voip/voip_callcenter.html',
                'filephp' => $path.'/admin/voip/voip_callcenter.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        // блок для вывода данных контакта
        Engine::GetContentDataSource()->registerContent(
            'voip-call-contact',
            array(
                'url' => '/admin/voip-call/contact/',
                'filehtml' => $path.'/admin/voip/voip_call_contact.html',
                'filephp' => $path.'/admin/voip/voip_call_contact.php',
                'level' => '2',
            ),
            'override'
        );

        // блок для вывода данных контакта
        Engine::GetContentDataSource()->registerContent(
            'voip-call-contact-edit-phone',
            array(
                'url' => '/admin/voip-call/contact/edit/phone/',
                'filehtml' => $path.'/admin/voip/voip_call_contact_edit_phone.html',
                'filephp' => $path.'/admin/voip/voip_call_contact_edit_phone.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call-close',
            array(
                'url' => '/admin/voip-call/close/',
                'filephp' => $path.'/admin/voip/voip_call_close.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call-save',
            array(
                'url' => '/admin/voip-call/save/',
                'filephp' => $path.'/admin/voip/voip_call_save.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call-originate',
            array(
                'url' => '/admin/voip-call/originate/',
                'filephp' => $path.'/admin/voip/voip_call_originate.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call-reject',
            array(
                'url' => '/admin/voip-call/reject/',
                'filephp' => $path.'/admin/voip/voip_call_reject.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'voip-call-transfer',
            array(
                'url' => '/admin/voip-call/transfer/',
                'filephp' => $path.'/admin/voip/voip_call_transfer.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-employer',
            array(
                'title' => 'Employer of order',
                'url' => array(
                    '/admin/shop/orders/{id}/employer/',
                    '/admin/issue/{id}/employer/', '/admin/customorder/{type}/{id}/employer/'
                ),
                'filehtml' => $path.'/admin/order/tab/orders_employer.html',
                'filephp' => $path.'/admin/order/tab/orders_employer.php',
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
                'filehtml' => $path.'/admin/order/tab/orders_contacts.html',
                'filephp' => $path.'/admin/order/tab/orders_contacts.php',
                'filejs' => $path.'/admin/order/tab/orders_contact.js',
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
                'filehtml' => $path.'/admin/order/tab/order_event.html',
                'filephp' => $path.'/admin/order/tab/order_event.php',
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
                'filehtml' => $path.'/admin/order/tab/orders_log.html',
                'filephp' => $path.'/admin/order/tab/orders_log.php',
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
                'filehtml' => $path.'/admin/order/tab/orders_files.html',
                'filephp' => $path.'/admin/order/tab/orders_files.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-status-index',
            array(
                'filehtml' => $path.'/admin/order/mode/status/issue_status_index.html',
                'filephp' => $path.'/admin/order/mode/status/issue_status_index.php',
                'filejs' => $path.'/admin/order/mode/status/issue_status_index.js',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'calendar-block',
            array(
                'filehtml' => $path.'/admin/order/mode/calendar/calendar_block.html',
                'filephp' => $path.'/admin/order/mode/calendar/calendar_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'calendar-block-issue', array(
                'filehtml' => $path.'/admin/order/mode/calendar/calendar_block_issue.html',
                'filephp' => $path.'/admin/order/mode/calendar/calendar_block_issue.php',
            ),
            'override'
        );

        // обновление задачи в календаре
        Engine::GetContentDataSource()->registerContent(
            'calendar-issue-update-ajax',
            array(
                'url' => '/calendar/issue/update/',
                'filephp' => $path.'/admin/order/mode/calendar/calendar_issue_update.php',
                'level' => '2',
            ),
            'override'
        );

        // ajax переключатель месяцев календаря
        Engine::GetContentDataSource()->registerContent(
            'calendar-block-load-ajax',
            array(
                'url' => '/admin/shop/calendal/load/month/ajax/',
                'filephp' => $path.'/admin/order/mode/calendar/calendar_block_load_ajax.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'gantt-index',
            array(
                'filehtml' => $path.'/admin/order/mode/gantt/gantt_index.html',
                'filephp' => $path.'/admin/order/mode/gantt/gantt_index.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'gantt-row-block', array(
                'filehtml' => $path.'/admin/order/mode/gantt/gantt_row_block.html',
                'filephp' => $path.'/admin/order/mode/gantt/gantt_row_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'gantt-update', array(
                'url' => '/admin/gantt/update/',
                'filephp' => $path.'/admin/order/mode/gantt/gantt_update.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'gantt-update-parent',
            array(
                'url' => '/admin/gantt/update/parent/',
                'filephp' => $path.'/admin/order/mode/gantt/gantt_update_parent.php',
                'level' => '2',
            ),
            'override'
        );


        Engine::GetContentDataSource()->registerContent(
            'maps-index',
            array(
                'title' => 'Maps',
                'url' => '/admin/maps/',
                'filehtml' => $path.'/admin/order/mode/maps/maps_index.html',
                'filephp' => $path.'/admin/order/mode/maps/maps_index.php',
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
                'filehtml' => $path.'/admin/order/mode/funnel/funnel_index.html',
                'filephp' => $path.'/admin/order/mode/funnel/funnel_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'funnel-chart-index',
            array(
                'filehtml' => $path.'/admin/order/mode/funnel/funnel_chart_index.html',
                'filephp' => $path.'/admin/order/mode/funnel/funnel_chart_index.php',
                'filejs' => $path.'/admin/order/mode/funnel/funnel_chart_index.js',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'mind-index',
            array(
                'title' => 'Mind',
                'url' => '/admin/mind/{id}/',
                'filehtml' => $path.'/admin/order/mode/mind/mind_index.html',
                'filephp' => $path.'/admin/order/mode/mind/mind_index.php',
                'filejs' => array(
                    $path.'/admin/order/mode/mind/d3.v3.min.js',
                    $path.'/admin/order/mode/mind/mind_index.js',
                    $path.'/admin/order/mode/mind/issue.api.js'
                ),
                'filecss' => $path.'/admin/order/mode/mind/mind_index.css',
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
                'filephp' => $path.'/admin/order/mode/mind/issue_ajax_add.php',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-ajax-update',
            array(
                'url' => '/admin/mind/issue/ajax/update/',
                'filephp' => $path.'/admin/order/mode/mind/issue_ajax_update.php',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-ajax-delete',
            array(
                'url' => '/admin/mind/issue/ajax/delete/',
                'filephp' => $path.'/admin/order/mode/mind/issue_ajax_delete.php',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-ajax-get', array(
                'url' => '/admin/mind/issue/ajax/get/',
                'filephp' => $path.'/admin/order/mode/mind/issue_ajax_get.php',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-ajax-edit',
            array(
                'url' => '/admin/mind/issue/ajax/edit/',
                'filephp' => $path.'/admin/order/mode/mind/issue_ajax_edit.php',
                'level' => '2'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'settings-project-index',
            array(
                'title' => 'Projects',
                'url' => '/admin/settings/project/',
                'filehtml' => $path.'/admin/project/settings_project_index.html',
                'filephp' => $path.'/admin/project/settings_project_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'settings-project-control',
            array(
                'title' => 'Projects',
                'url' => array('/admin/settings/project/add/', '/admin/settings/project/{key}/'),
                'filehtml' => $path.'/admin/project/settings_project_control.html',
                'filephp' => $path.'/admin/project/settings_project_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'project-index',
            array(
                'title' => 'Projects',
                'url' => '/admin/projects/',
                'filehtml' => $path.'/admin/project/project_index.html',
                'filejs' => $path.'/admin/project/project_index.js',
                'filephp' => $path.'/admin/project/project_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-add',
            array(
                'title' => 'Projects',
                'url' => '/admin/project/add/',
                'filehtml' => $path.'/admin/project/project_add.html',
                'filejs' => $path.'/admin/project/project_add.js',
                'filephp' => $path.'/admin/project/project_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-control',
            array(
                'title' => 'Projects',
                'url' => '/admin/project/{id}/',
                'filehtml' => $path.'/admin/project/project_control.html',
                'filejs' => $path.'/admin/project/project_control.js',
                'filephp' => $path.'/admin/project/project_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-info',
            array(
                'title' => 'Project Info',
                'url' => array('/admin/project/{id}/info/'),
                'filehtml' => $path.'/admin/project/project_info.html',
                'filephp' => $path.'/admin/project/project_info.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-block-info',
            array(
                'filehtml' => $path.'/admin/project/project_block_info.html',
                'filephp' => $path.'/admin/project/project_block_info.php',
                'filejs' => $path.'/admin/project/project_block_info.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-block-statistics',
            array(
                'filehtml' => $path.'/admin/project/project_block_statistics.html',
                'filephp' => $path.'/admin/project/project_block_statistics.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-block-managers',
            array(
                'filehtml' => $path.'/admin/project/project_block_managers.html',
                'filephp' => $path.'/admin/project/project_block_managers.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-products',
            array(
                'title' => 'Project product',
                'url' => array('/admin/project/{id}/products/', '/admin/customorder/{type}/{id}/products/'),
                'filehtml' => $path.'/admin/project/project_products.html',
                'filephp' => $path.'/admin/project/project_products.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-project-orders',
            array(
                'title' => 'Project orders',
                'url' => array('/admin/project/{id}/order/', '/admin/customorder/{type}/{id}/order/'),
                'filehtml' => $path.'/admin/project/project_orders.html',
                'filephp' => $path.'/admin/project/project_orders.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('project'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-customorder-calendar-popup',
            array(
                'url' => '/admin/customorder/smarty/workflow/',
                'filehtml' => $path.'/admin/customorder/issue_calendar_popup.html',
                'filephp' => $path.'/admin/customorder/issue_calendar_popup.php',
                'level' => '2',
            ),
            'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'custom-issue-shop-index', array(
                'title' => 'Issues',
                'url' => '/admin/customorder/{type}/',
                'filehtml' => $path.'/admin/customorder/issue_index.html',
                'filephp' => $path.'/admin/customorder/issue_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'custom-issue-shop-add', array(
                'title' => 'Issue',
                'url' => '/admin/customorder/{type}/add/',
                'filehtml' => $path.'/admin/customorder/custom_issue_add.html',
                'filejs' => $path.'/admin/customorder/custom_issue_add.js',
                'filephp' => $path.'/admin/customorder/custom_issue_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-customorders-child',
            array(
                'title' => 'Issue',
                'url' => '/admin/list/customorder/{type}/{id}/{orderType}/',
                'filehtml' => $path.'/admin/customorder/custom_child.html',
                'filephp' => $path.'/admin/customorder/custom_child.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-shop-control', array(
                'title' => 'Issue',
                'url' => '/admin/customorder/{type}/{id}/edit/',
                'filehtml' => $path.'/admin/customorder/issue_control.html',
                'filephp' => $path.'/admin/customorder/issue_control.php',
                'filejs' => $path.'/admin/customorder/issue_control.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-shop-list', array(
                'title' => 'Issue',
                'filehtml' => $path.'/admin/customorder/issue_list.html',
                'filephp' => $path.'/admin/customorder/issue_list.php',
                'filejs' => $path.'/admin/customorder/issue_list.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-project-add', array(
                'filehtml' => $path.'/admin/customorder/project_add.html',
                'filejs' => $path.'/admin/customorder/project_add.js',
                'filephp' => $path.'/admin/customorder/project_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-order-add', array(
                'filehtml' => $path.'/admin/customorder/order_add.html',
                'filejs' => $path.'/admin/customorder/order_add.js',
                'filephp' => $path.'/admin/customorder/order_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-add', array(
                'filehtml' => $path.'/admin/customorder/issue_add.html',
                'filejs' => $path.'/admin/customorder/issue_add.js',
                'filephp' => $path.'/admin/customorder/issue_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-printing', array(
                'title' => 'Printing',
                'url' => '/admin/customorder/{type}/{id}/edit/printing/',
                'filehtml' => $path.'/admin/customorder/issue_printing.html',
                'filephp' => $path.'/admin/customorder/issue_printing.php',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-delete', array(
                'url' => '/admin/customorder/{type}/{id}/delete/',
                'filehtml' => $path.'/admin/customorder/issue_delete.html',
                'filephp' => $path.'/admin/customorder/issue_delete.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'custom-issue-restore', array(
                'url' => '/admin/customorder/{type}/{id}/restore/',
                'filehtml' => $path.'/admin/customorder/issue_restore.html',
                'filephp' => $path.'/admin/customorder/issue_restore.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ), 'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'admin-project-user-block',
            array(
                'filehtml' => $path.'/admin/project/block/user_project_block.html',
                'filephp' => $path.'/admin/project/block/user_project_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-index', array(
            'title' => 'Issues',
            'url' => '/admin/issue/',
            'filehtml' => $path.'/admin/issue/issue_index.html',
            'filephp' => $path.'/admin/issue/issue_index.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            'role' => array('issue'),
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-add', array(
            'title' => 'Issues',
            'url' => '/admin/issue/add/',
            'filehtml' => $path.'/admin/issue/issue_add.html',
            'filejs' => $path.'/admin/issue/issue_add.js',
            'filephp' => $path.'/admin/issue/issue_add.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            'role' => array('issue'),
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'issue-add-mail', array(
            'title' => 'Issues',
            'url' => '/admin/issue/addmail/',
            'filehtml' => $path.'/admin/issue/issue_add_mail.html',
            'filejs' => $path.'/admin/issue/issue_add_mail.js',
            'filephp' => $path.'/admin/issue/issue_add_mail.php',
            'moveto' => 'shop-admin-tpl',
            'moveas' => 'content',
            'level' => '2',
            'role' => array('issue'),
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-issue-control', array(
                'title' => 'Issue',
                'url' => '/admin/issue/{id}/',
                'filehtml' => $path.'/admin/issue/issue_control.html',
                'filephp' => $path.'/admin/issue/issue_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('issue'),
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-issue-block-info', array(
            'filehtml' => $path.'/admin/issue/issue_block_info.html',
            'filephp' => $path.'/admin/issue/issue_block_info.php',
            'filejs' => $path.'/admin/issue/issue_block_info.js',
            'level' => '2',
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-issue-user-block', array(
            'filehtml' => $path.'/admin/issue/block/user_issue_block.html',
            'filephp' => $path.'/admin/issue/block/user_issue_block.php',
            ), 'override'
        );

        // standards
        Engine::GetContentDataSource()->registerContent(
            'standard-tpl',
            array(
                'title' => 'Standards',
                'url' => array('/admin/standards/', '/admin/standards/{id}/'),
                'filehtml' => $path.'/standard/standard_tpl.html',
                'filejs' => $path.'/standard/standard_tpl.js',
                'filephp' => $path.'/standard/standard_tpl.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-standard-edit', array(
                'title' => 'Standards edit',
                'url' => '/admin/standards/{id}/edit/',
                'filehtml' => $path.'/standard/standard_edit.html',
                'filejs' => $path.'/standard/standard_tpl.js',
                'filephp' => $path.'/standard/standard_edit.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('control-standard'),
            ), 'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-standard-create', array(
                'title' => 'Standards create',
                'url' => '/admin/standard/create/',
                'filehtml' => $path.'/standard/standard_create.html',
                'filejs' => $path.'/standard/standard_tpl.js',
                'filephp' => $path.'/standard/standard_create.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('control-standard'),
            ), 'override'
        );
    }
}