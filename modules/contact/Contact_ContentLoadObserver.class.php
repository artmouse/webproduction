<?php

class Contact_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users',
            array(
                'title' => 'Users',
                'url' => '/admin/shop/users/',
                'filehtml' => dirname(__FILE__).'/contents/users_index.html',
                'filephp' => dirname(__FILE__).'/contents/users_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-mass-mailing',
            array(
                'title' => 'Direct mail',
                'url' => '/admin/shop/users/mailing/',
                'filehtml' => dirname(__FILE__).'/contents/users_mailing.html',
                'filephp' => dirname(__FILE__).'/contents/users_mailing.php',
                'filejs' => dirname(__FILE__).'/contents/users_mailing.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users-mass-mailing'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-mass-sms-mailing',
            array(
                'title' => 'Direct sms',
                'url' => '/admin/shop/users/smsmailing/',
                'filehtml' => dirname(__FILE__).'/contents/users_sms_mailing.html',
                'filephp' => dirname(__FILE__).'/contents/users_sms_mailing.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users-mass-mailing'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-add',
            array(
                'title' => 'Add user',
                'url' => '/admin/shop/users/add/',
                'filehtml' => dirname(__FILE__).'/contents/users_add.html',
                'filephp' => dirname(__FILE__).'/contents/users_add.php',
                'filejs' => dirname(__FILE__).'/contents/users_add.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-addto',
            array(
                'title' => 'Add to user',
                'url' => '/admin/shop/users/addto/',
                'filehtml' => dirname(__FILE__).'/contents/users_addto.html',
                'filephp' => dirname(__FILE__).'/contents/users_addto.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-exchange-xls',
            array(
                'title' => 'users exchange with Excel',
                'url' => '/admin/shop/users/exchange-xls/',
                'filehtml' => dirname(__FILE__).'/contents/users_exchange_xls.html',
                'filephp' => dirname(__FILE__).'/contents/users_exchange_xls.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users_import_export'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-control',
            array(
                'title' => 'User #{id}',
                'url' => '/admin/shop/users/{id}/',
                'filehtml' => dirname(__FILE__).'/contents/users_control.html',
                'filecss' => dirname(__FILE__).'/contents/admin_shop_tpl_contact.css',
                'filephp' => dirname(__FILE__).'/contents/users_control.php',
                'filejs' => dirname(__FILE__).'/contents/users_control.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        // блок статистики в юзере
        Engine::GetContentDataSource()->registerContent(
            'user-block-statistic',
            array(
                'filehtml' => dirname(__FILE__).'/contents/user_block_statistic.html',
                'filephp' => dirname(__FILE__).'/contents/user_block_statistic.php',
            ),
            'override'
        );

        // блок графиков в юзере
        Engine::GetContentDataSource()->registerContent(
            'user-block-charts',
            array(
                'filehtml' => dirname(__FILE__).'/contents/user_block_charts.html',
                'filephp' => dirname(__FILE__).'/contents/user_block_charts.php',
                'filejs' => dirname(__FILE__).'/contents/user_block_charts.js',
            ),
            'override'
        );

        // блок workflow
        Engine::GetContentDataSource()->registerContent(
            'user-block-workflow',
            array(
                'filehtml' => dirname(__FILE__).'/contents/user_block_workflow.html',
                'filephp' => dirname(__FILE__).'/contents/user_block_workflow.php',
            ),
            'override'
        );

        // блок списка сотрудников в компании
        Engine::GetContentDataSource()->registerContent(
            'user-block-company',
            array(
                'filehtml' => dirname(__FILE__).'/contents/user_block_company.html',
                'filephp' => dirname(__FILE__).'/contents/user_block_company.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-permissions',
            array(
                'title' => 'Permissions',
                'url' => '/admin/shop/users/permissions/{id}/',
                'filehtml' => dirname(__FILE__).'/contents/users_permissions.html',
                'filephp' => dirname(__FILE__).'/contents/users_permissions.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-legal',
            array(
                'title' => 'Permissions',
                'url' => '/admin/shop/users/{id}/legal/',
                'filehtml' => dirname(__FILE__).'/contents/users_legal.html',
                'filephp' => dirname(__FILE__).'/contents/users_legal.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-event',
            array(
                'title' => 'Events of contact',
                'url' => '/admin/shop/users/{id}/event/',
                'filehtml' => dirname(__FILE__).'/contents/user_event.html',
                'filephp' => dirname(__FILE__).'/contents/user_event.php',
                'filejs' => dirname(__FILE__).'/contents/user_event.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-issue',
            array(
                'title' => 'Issues',
                'url' => array('/admin/shop/users/{id}/issue/', '/admin/shop/users/custom/{id}/{type}/'),
                'filehtml' => dirname(__FILE__).'/contents/users_issue.html',
                'filephp' => dirname(__FILE__).'/contents/users_issue.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-project',
            array(
                'title' => 'Projects',
                'url' => '/admin/shop/users/{id}/project/',
                'filehtml' => dirname(__FILE__).'/contents/users_project.html',
                'filephp' => dirname(__FILE__).'/contents/users_project.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-order',
            array(
                'title' => 'Orders',
                'url' => '/admin/shop/users/{id}/order/',
                'filehtml' => dirname(__FILE__).'/contents/users_order.html',
                'filephp' => dirname(__FILE__).'/contents/users_order.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-graphics',
            array(
                'title' => 'Graphics',
                'url' => '/admin/shop/users/{id}/graphics/',
                'filehtml' => dirname(__FILE__).'/contents/users_graphics.html',
                'filephp' => dirname(__FILE__).'/contents/users_graphics.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-groups',
            array(
                'title' => 'Groups',
                'url' => '/admin/shop/usergroups/',
                'filehtml' => dirname(__FILE__).'/contents/users_groups_index.html',
                'filephp' => dirname(__FILE__).'/contents/users_groups_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users', 'users-groups'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-groups-control',
            array(
                'title' => 'Groups edit',
                'url' => array('/admin/shop/usergroups/add/', '/admin/shop/usergroups/{key}/'),
                'filehtml' => dirname(__FILE__).'/contents/users_groups_control.html',
                'filephp' => dirname(__FILE__).'/contents/users_groups_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users', 'users-groups'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-menu',
            array(
                'filehtml' => dirname(__FILE__).'/contents/users_menu.html',
                'filephp' => dirname(__FILE__).'/contents/users_menu.php',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-users-delete',
            array(
                'title' => 'Delete user',
                'url' => '/admin/shop/users/{id}/delete/',
                'filehtml' => dirname(__FILE__).'/contents/users_delete.html',
                'filephp' => dirname(__FILE__).'/contents/users_delete.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-user-tile',
            array(
                'filehtml' => dirname(__FILE__).'/contents/user_tile.html',
                'filephp' => dirname(__FILE__).'/contents/user_tile.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-contactfield',
            array(
                'title' => 'Contact fields',
                'url' => '/admin/shop/contactfield/',
                'filehtml' => dirname(__FILE__).'/contents/contactfield_index.html',
                'filephp' => dirname(__FILE__).'/contents/contactfield_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );


        Engine::GetContentDataSource()->registerContent(
            'contact-mode-maps',
            array(
                'filehtml' => dirname(__FILE__).'/contents/mode/contact_list_mode_maps.html',
                'filephp' => dirname(__FILE__).'/contents/mode/contact_list_mode_maps.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'contact-mode-listing',
            array(
                'filehtml' => dirname(__FILE__).'/contents/mode/contact_list_mode_listing.html',
                'filephp' => dirname(__FILE__).'/contents/mode/contact_list_mode_listing.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-contactfield-control',
            array(
                'title' => 'Contact field edit',
                'url' => array('/admin/shop/contactfield/add/', '/admin/shop/contactfield/{key}/'),
                'filehtml' => dirname(__FILE__).'/contents/contactfield_control.html',
                'filephp' => dirname(__FILE__).'/contents/contactfield_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '3',
            ),
            'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-user-tab-view-products',
            array(
                'title' => 'Viewe products',
                'url' => array('/admin/shop/users/{id}/viewproducts/'),
                'filehtml' => dirname(__FILE__).'/contents/tab/user_view_products.html',
                'filephp' => dirname(__FILE__).'/contents/tab/user_view_products.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );
    }

}