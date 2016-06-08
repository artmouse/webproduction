<?php

class Order_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/contents/admin/';

        // табы
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-tab-product',
            array(
                'title' => 'Orders',
                'url' => '/admin/shop/products/{id}/orders/',
                'filehtml' => $path.'/tab/products_orders.html',
                'filephp' => $path.'/tab/products_orders.php',
                'filejs' => $path.'/tab/products_orders.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('products', 'products-orders'),
            ),
            'override'
        );

        // отчеты
        Engine::GetContentDataSource()->registerContent(
            'report-clientbalance',
            array(
                'title' => 'Client balance',
                'url' => '/admin/shop/report/clientbalance/',
                'filehtml' => $path.'/report/report_clientbalance.html',
                'filephp' => $path.'/report/report_clientbalance.php',
                'filejs' => $path.'/report/report_clientbalance.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-clientbalance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-clientorders',
            array(
                'title' => 'Client orders',
                'url' => '/admin/shop/report/clientorders/',
                'filehtml' => $path.'/report/report_clientorders.html',
                'filephp' => $path.'/report/report_clientorders.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-clientorder'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-compareorderplan',
            array(
                'title' => 'Order plan compare',
                'url' => '/admin/shop/report/compareorderplan/',
                'filehtml' => $path.'/report/report_compareorderplan.html',
                'filephp' => $path.'/report/report_compareorderplan.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-compareorderplan'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-managercompare',
            array(
                'title' => 'Managers compare',
                'url' => '/admin/shop/report/managercompare/',
                'filehtml' => $path.'/report/report_managercompare.html',
                'filephp' => $path.'/report/report_managercompare.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-managercompare'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-orderdate',
            array(
                'title' => 'Orders on date',
                'url' => '/admin/shop/report/orderdate/',
                'filehtml' => $path.'/report/report_orderdate.html',
                'filephp' => $path.'/report/report_orderdate.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-orderdate'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-orderpayment',
            array(
                'title' => 'Order payments',
                'url' => '/admin/shop/report/orderpayment/',
                'filehtml' => $path.'/report/report_orderpayment.html',
                'filephp' => $path.'/report/report_orderpayment.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'role' => array('report-orderpayment'),
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-probation-order',
            array(
                'title' => 'Order probation payments',
                'url' => '/admin/shop/report/orderprobation/',
                'filehtml' => $path.'/report/report_orderprobation.html',
                'filephp' => $path.'/report/report_orderprobation.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'role' => array('report-orderprobation'),
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-orderstatus',
            array(
                'title' => 'Orders status',
                'url' => '/admin/shop/report/orderstatus/',
                'filehtml' => $path.'/report/report_orderstatus.html',
                'filephp' => $path.'/report/report_orderstatus.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-orderstatus'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-sourceorders',
            array(
                'title' => 'Order sources',
                'url' => '/admin/shop/report/sourceorders/',
                'filehtml' => $path.'/report/report_sourceorders.html',
                'filephp' => $path.'/report/report_sourceorders.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-sourceorders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-topproducts',
            array(
                'title' => 'Top products',
                'url' => '/admin/shop/report/topproducts/',
                'filehtml' => $path.'/report/report_topproducts.html',
                'filephp' => $path.'/report/report_topproducts.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-topproducts'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-priceinsupplier',
            array(
                'title' => 'Report price supplier',
                'url' => '/admin/shop/report/priceinsupplier/',
                'filehtml' => $path.'/report/report_priceinsupplier.html',
                'filephp' => $path.'/report/report_priceinsupplier.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-priceinsupplier-model-ajax',
            array(
                'url' => '/admin/shop/report/priceinsupplier/model/ajax/',
                'filephp' => $path.'/report/report_priceinsupplier_model_ajax.php',
            )
        );

        Engine::GetContentDataSource()->registerContent(
            'report-clientonproduct',
            array(
                'title' => 'Clients order products',
                'url' => '/admin/shop/report/clientonproduct/',
                'filehtml' => $path.'/report/report_clientonproduct.html',
                'filephp' => $path.'/report/report_clientonproduct.php',
                'filejs' => $path.'/report/report_clientonproduct.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-topproducts'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-mapclientonstatus',
            array(
                'title' => 'Карта клиентов по статусам',
                'url' => '/admin/shop/report/mapclientonstatus/',
                'filehtml' => $path.'/report/report_mapclientonstatus.html',
                'filephp' => $path.'/report/report_mapclientonstatus.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'admin-products-report-autocomtlite-ajax',
            array(
                'url' => '/admin/products/report/autocomtlite/ajax/',
                'filephp' => $path.'/block/ajax/products_report_autocomplete.php'
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'report-orderedproducts',
            array(
                'title' => 'Ordered products',
                'url' => '/admin/shop/report/orderedproducts/',
                'filehtml' => $path.'/report/report_orderedproducts.html',
                'filephp' => $path.'/report/report_orderedproducts.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report-topproducts'),
            ),
            'override'
        );

        // Blocks

        Engine::GetContentDataSource()->registerContent(
            'admin-order-user-block',
            array(
                'filehtml' => $path.'/block/user_order_block.html',
                'filephp' => $path.'/block/user_order_block.php',
            ),
            'override'
        );

        // дальше идут контенты, которые, похоже, уже нигде не используются

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-ordercategory',
            array(
                'title' => 'Order categories',
                'url' => '/admin/shop/ordercategory/',
                'filehtml' => $path.'/ordercategory/ordercategory_index.html',
                'filephp' => $path.'/ordercategory/ordercategory_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-ordercategory-control',
            array(
                'title' => 'Order categories',
                'url' => array('/admin/shop/ordercategory/add/', '/admin/shop/ordercategory/{key}/'),
                'filehtml' => $path.'/ordercategory/ordercategory_control.html',
                'filephp' => $path.'/ordercategory/ordercategory_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orderstatus',
            array(
                'title' => 'Order statuses',
                'url' => '/admin/shop/orderstatus/',
                'filehtml' => $path.'/orderstatus/orderstatus_index.html',
                'filephp' => $path.'/orderstatus/orderstatus_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orderstatus-control',
            array(
                'title' => 'Order statuses',
                'url' => array('/admin/shop/orderstatus/add/', '/admin/shop/orderstatus/{key}/'),
                'filehtml' => $path.'/orderstatus/orderstatus_control.html',
                'filephp' => $path.'/orderstatus/orderstatus_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('settings'),
            ),
            'override'
        );

        // --- orders ---

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders',
            array(
                'title' => 'Orders',
                'url' => '/admin/shop/orders/',
                'filehtml' => $path.'/orders/orders_index.html',
                'filephp' => $path.'/orders/orders_index.php',
                'filejs' => $path.'/orders/orders_index.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-add',
            array(
                'title' => 'Add order',
                'url' => array('/admin/order/add/', '/admin/shop/orders/add/'),
                'filehtml' => $path.'/orders/order_add.html',
                'filephp' => $path.'/orders/order_add.php',
                'filejs' => $path.'/orders/order_add.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('orders-add'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-exchange-xls',
            array(
                'title' => 'Orders exchange with Excel',
                'url' => '/admin/orders/exchange-xls/',
                'filehtml' => $path.'/orders/orders_exchange_xls.html',
                'filephp' => $path.'/orders/orders_exchange_xls.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('orders-import'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-add-product-list',
            array(
                'url' => array('/admin/order/add/product/list/'),
                'filehtml' => $path.'/orders/order_add_product_list.html',
                'filephp' => $path.'/orders/order_add_product_list.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-report',
            array(
                'title' => 'Orders: products to clients',
                'url' => '/admin/shop/orders/report/',
                'filehtml' => $path.'/orders/orders_report.html',
                'filephp' => $path.'/orders/orders_report.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('report_productmatrix'),
            ),
            'override'
        );

        // страница полного управления заказом
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control',
            array(
                'title' => 'Orders management',
                'url' => array('/admin/shop/orders/{id}/'),
                'filehtml' => $path.'/orders/orders_control.html',
                'filephp' => $path.'/orders/orders_control.php',
                'filejs' => $path.'/orders/orders_control.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-info',
            array(
                'title' => 'Orders management',
                'url' => array('/admin/shop/orders/{id}/info/', '/admin/customorder/{type}/{id}/info/'),
                'filehtml' => $path.'/orders/orders_info.html',
                'filephp' => $path.'/orders/orders_info.php',
                'filejs' => $path.'/orders/orders_info.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control-block-info',
            array(
                'filehtml' => $path.'/orders/orders_control_block_info.html',
                'filephp' => $path.'/orders/orders_control_block_info.php',
                'filejs' => $path.'/orders/orders_control_block_info.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control-block-workflow',
            array(
                'filehtml' => $path.'/orders/orders_control_block_workflow.html',
                'filephp' => $path.'/orders/orders_control_block_workflow.php',
                'filejs' => $path.'/orders/orders_control_block_workflow.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control-block-product-list',
            array(
                'url' => array('/admin/shop/orders/add/product/ajax/'),
                'filehtml' => $path.'/orders/orders_control_block_product_list.html',
                'filephp' => $path.'/orders/orders_control_block_product_list.php',
                'filejs' => $path.'/orders/orders_control_block_product_list.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control-block-comment',
            array(
                'filehtml' => $path.'/orders/orders_control_block_comment.html',
                'filephp' => $path.'/orders/orders_control_block_comment.php',
                'filejs' => $path.'/orders/orders_control_block_comment.js',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-control-block-processorform',
            array(
                'filehtml' => $path.'/orders/orders_control_block_processorform.html',
                'filephp' => $path.'/orders/orders_control_block_processorform.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-delete',
            array(
                'title' => 'Delete order',
                'url' => '/admin/shop/orders/{id}/delete/',
                'filehtml' => $path.'/orders/orders_delete.html',
                'filephp' => $path.'/orders/orders_delete.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-restore',
            array(
                'title' => 'Restore order',
                'url' => '/admin/shop/orders/{id}/restore/',
                'filehtml' => $path.'/orders/orders_restore.html',
                'filephp' => $path.'/orders/orders_restore.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-issue',
            array(
                'title' => 'Issue',
                'url' => array('/admin/shop/orders/{id}/issue/', '/admin/customorder/{type}/{id}/issue/'),
                'filehtml' => $path.'/orders/orders_issue.html',
                'filephp' => $path.'/orders/orders_issue.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-menu',
            array(
                'filehtml' => $path.'/orders/order_menu.html',
                'filephp' => $path.'/orders/order_menu.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-printing',
            array(
                'title' => 'Printing order',
                'url' => '/admin/shop/orders/{id}/printing/',
                'filehtml' => $path.'/orders/orders_printing.html',
                'filephp' => $path.'/orders/orders_printing.php',
                'role' => array('orders'),
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-barcode',
            array(
                'url' => '/admin/shop/orders/{id}/barcode/',
                'filehtml' => $path.'/orders/order_barcode.html',
                'filephp' => $path.'/orders/order_barcode.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-workflow-info',
            array(
                'url' => '/admin/order/workflow-info/',
                'filehtml' => $path.'/orders/order_workflow_info.html',
                'filephp' => $path.'/orders/order_workflow_info.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-workflow-setting-info',
            array(
                'url' => '/admin/order/workflow-setting-info/',
                'filehtml' => $path.'/orders/order_workflow_setting_info.html',
                'filephp' => $path.'/orders/order_workflow_setting_info.php',
                'level' => '2',
            ),
            'override'
        );

        // блок списка заказов
        Engine::GetContentDataSource()->registerContent(
            'order-list',
            array(
                'filehtml' => $path.'/orders/order_list.html',
                'filephp' => $path.'/orders/order_list.php',
                'filejs' => $path.'/orders/order_list.js',
            ),
            'override'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-add-product-list-category-filter',
            array(
                'url' => array('/admin/order/add/product/list/category/filter/'),
                'filehtml' => $path.'/orders/order_add_product_list_category_filter.html',
                'filephp' => $path.'/orders/order_add_product_list_category_filter.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-order-json-autocomplete-select2',
            array(
                'url' => '/admin/shop/order/jsonautocomplete/select2/',
                'filephp' => $path.'/orders/orders_json_autocomplete_select2.php',
                'level' => '2',
                'role' => array('orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-contact-json-autocomplete-select2',
            array(
                'url' => '/admin/shop/orders/contact/jsonautocomplete/select2/',
                'filephp' => $path.'/orders/users_json_autocomplete_select2.php',
                'level' => '2',
                'role' => array('users'),
            ),
            'override'
        );

        // Ajax перестановка товаров в заказе
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders-sort-products-ajax',
            array(
                'url' => '/admin/shop/orders/products/sort/ajax/',
                'filephp' => $path.'/orders/ajax_orders_products_sort.php',
                'level' => '2',
            ),
            'override'
        );

        if (Shop_ModuleLoader::Get()->isImported('box')
            && !Engine::Get()->getConfigFieldSecure('static-shop-menu')
        ) {
            Engine::GetContentDataSource()->registerContent(
                'shop-admin-order-menu',
                array(
                    'filehtml' => $path.'/orders/custom_order_menu.html',
                    'filephp' => $path.'/orders/custom_order_menu.php',
                ),
                'extend'
            );
        }
    }

}