<?php

class Document_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/contents/';

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-index',
            array(
                'title' => 'Documents',
                'url' => '/admin/document/',
                'filehtml' => $path.'/document/document_index.html',
                'filephp' => $path.'/document/document_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-control',
            array(
                'title' => 'Documents',
                'url' => array('/admin/document/{id}/control/', '/admin/customorder/document/{type}/{id}/control/'),
                'filehtml' => $path.'/document/document_control.html',
                'filecss' => $path.'/document_tpl.css',
                'filephp' => $path.'/document/document_control.php',
                'filejs' => $path.'/document/document_control.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-fieldeditor',
            array(
                'url' => '/admin/document/{id}/fieldeditor/',
                'filehtml' => $path.'/document/document_fieldeditor.html',
                'filephp' => $path.'/document/document_fieldeditor.php',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-debug',
            array(
                'title' => 'Documents debug',
                'url' => '/admin/document/debug/',
                'filehtml' => $path.'/document/document_debug.html',
                'filephp' => $path.'/document/document_debug.php',
                'level' => '2',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-table-block',
            array(
                'filehtml' => $path.'/document/document_table_block.html',
                'filephp' => $path.'/document/document_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-list-block',
            array(
                'url' => '/admin/shop/document/list/',
                'filehtml' => $path.'/document/document_list_block.html',
                'filephp' => $path.'/document/document_list_block.php',
                'filejs' => $path.'/document/document_list_block.js',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-documents-block',
            array(
                'url' => '/admin/shop/document/list/',
                'filehtml' => $path.'/document/document_list_block.html',
                'filephp' => $path.'/document/document_list_block.php',
                'filejs' => $path.'/document/document_list_block.js',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-pdf',
            array(
                'url' => '/admin/shop/document/{id}/pdf/',
                'filephp' => $path.'/document/document_pdf.php',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-download',
            array(
                'url' => '/admin/shop/document/{id}/download/',
                'filephp' => $path.'/document/document_download.php',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-print',
            array(
                'url' => '/admin/shop/document/{id}/print/',
                'filehtml' => $path.'/document/document_print.html',
                'filephp' => $path.'/document/document_print.php',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-templates-view-ajax',
            array(
                'url' => array('/admin/shop/document/templates/view/ajax/'),
                'filephp' => $path.'/document_template/document_template_view_ajax.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-templates',
            array(
                'title' => 'Document templates',
                'url' => '/admin/shop/document/templates/',
                'filehtml' => $path.'/document_template/document_template_index.html',
                'filephp' => $path.'/document_template/document_template_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-templates-control',
            array(
                'title' => 'Document templates',
                'url' => array('/admin/shop/document/templates/{id}/control/'),
                'filehtml' => $path.'/document_template/document_template_control.html',
                'filecss' => $path.'/document_tpl.css',
                'filephp' => $path.'/document_template/document_template_control.php',
                'filejs' => $path.'/document_template/document_template_control.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-templates-add',
            array(
                'title' => 'Document templates',
                'url' => array('/admin/shop/document/templates/add/'),
                'filehtml' => $path.'/document_template/document_template_add.html',
                'filephp' => $path.'/document_template/document_template_add.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('documents'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-tab-order',
            array(
                'title' => 'Documents of order',
                'url' => array('/admin/shop/orders/{id}/document/', '/admin/customorder/{type}/{id}/document/'),
                'filehtml' => $path.'/tab/orders_document.html',
                'filephp' => $path.'/tab/orders_document.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-document-tab-user',
            array(
                'title' => 'Documents of users',
                'url' => '/admin/shop/users/{id}/document/',
                'filehtml' => $path.'/tab/users_document.html',
                'filephp' => $path.'/tab/users_document.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'document-order-status-action-block-document-writing',
            array(
                'filehtml' => $path.
                    '/admin/block-action/document_order_status_action_block_document_writing.html',
                'filephp' => $path.
                    '/admin/block-action/document_order_status_action_block_document_writing.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-order-status-action-block-document-need',
            array(
                'filehtml' => $path.'/admin/block-action/action_block_document_need.html',
                'filephp' => $path.'/admin/block-action/action_block_document_need.php',
            ),
            'override'
        );
    }

}