<?php

class Storage_Contents implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // HELP
        Engine::GetContentDataSource()->registerContent(
            'shop-storage-help',
            array(
                'url' => array(
                    '/admin/shop/storage/help/',
                    '/admin/shop/storage/help/{file}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/help/help_index.html',
                'filephp' => dirname(__FILE__) . '/contents/help/help_index.php',
                'filecss' => dirname(__FILE__) . '/contents/help/help_index.css',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        // TPLs
        Engine::GetContentDataSource()->registerContent(
            'shop-storage-tpl',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/tpl_storage.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tpl_storage.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/tpl_storage.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        // Settings
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-name',
            array(
                'title' => 'Warehouse',
                'url' => '/admin/shop/storage/settings/names/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/storagenames/storage_name_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/storagenames/storage_name_index.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-settings'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-name-control',
            array(
                'title' => 'Warehouse',
                'url' => array(
                    '/admin/shop/storage/settings/names/add/',
                    '/admin/shop/storage/settings/names/{key}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/storagenames/storage_name_control.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/storagenames/storage_name_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-settings'),
            ),
            'override'
        );

        // Links
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-linkwindow',
            array(
                'url' => '/admin/shop/storage/linkwindow/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/linkwindow/linkwindow_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/linkwindow/linkwindow_index.php',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-api-link-add',
            array(
                'url' => '/api/storage/link/add/',
                'filephp' => dirname(__FILE__) . '/contents/admin/linkwindow/link_add.php',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-api-link-delete',
            array(
                'url' => '/api/storage/link/delete/',
                'filephp' => dirname(__FILE__) . '/contents/admin/linkwindow/link_delete.php',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        // Reserve
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-reserve',
            array(
                'title' => 'Reserve',
                'url' => '/admin/shop/storage/reserve/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/reserve/storage_reserve.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/reserve/storage_reserve.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-reserve-ajax',
            array(
                'url' => '/storage/reserve/ajax/',
                'filephp' => dirname(__FILE__) . '/contents/admin/reserve/reserve_ajax.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-reserve-cancel-ajax',
            array(
                'url' => '/storage/reserve/cancel/ajax/',
                'filephp' => dirname(__FILE__) . '/contents/admin/reserve/reserve_cancel_ajax.php',
                'level' => '2',
            ),
            'override'
        );

        // Balance reports
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-balance',
            array(
                'title' => 'Balance',
                'url' => array(
                    '/admin/shop/storage/balance/',
                    '/admin/shop/storage/balance/warehouses/',
                    '/admin/shop/storage/balance/warehouses/{storagenameid}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/balance/storage_balance.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/balance/storage_balance.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-balance-sales',
            array(
                'title' => 'Sales',
                'url' => '/admin/shop/storage/balance/sales/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_sales.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_sales.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance-sales'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-balance-employees',
            array(
                'title' => 'Balance',
                'url' => array(
                    '/admin/shop/storage/balance/employees/',
                    '/admin/shop/storage/balance/employees/{storagenameid}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_employees.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_employees.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-balance-vendors',
            array(
                'title' => 'Balance',
                'url' => array(
                    '/admin/shop/storage/balance/vendors/',
                    '/admin/shop/storage/balance/vendors/{storagenameid}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_vendors.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_vendors.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance-vendors'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-balance-product',
            array(
                'title' => 'Balance',
                'url' => '/admin/shop/storage/balance/product/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_product.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_product.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/balance/storage_balance_product.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        // Журнал
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-list',
            array(
                'title' => 'Motion log',
                'url' => array(
                    '/admin/shop/storage/motionlog/',
                    '/admin/shop/storage/motionlog/{type}/'
                ),
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_list.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-view',
            array(
                'title' => 'Motion log',
                'url' => '/admin/shop/storage/motion/{id}/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_view.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_view.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-edit',
            array(
                'title' => 'Motion log',
                'url' => '/admin/shop/storage/motion/{id}/edit/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_edit.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_edit.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog-edit'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-delete',
            array(
                'title' => 'Motion log',
                'url' => '/admin/shop/storage/motion/{id}/delete/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_delete.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_delete.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog-delete'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-delete-transaction',
            array(
                'title' => 'Motion',
                'url' => '/admin/shop/storage/motion/{id}/delete/transaction/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_delete_transaction.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_delete_transaction.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog-delete'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-return',
            array(
                'title' => 'Return',
                'url' => '/admin/shop/storage/motion/{id}/return/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_return.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_return.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog-return'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-product',
            array(
                'title' => 'Motion history of product',
                'url' => '/admin/shop/storage/product/{code}/history/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_product.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_product.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-balance-history',
            array(
                'title' => 'Motion history of balance',
                'url' => '/admin/shop/storage/balance/{balanceid}/history/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_balance_history.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_balance_history.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-motionlog'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-motion-block-list',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_block_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/motionlog/storage_motion_block_list.php',
            ),
            'override'
        );

        // ajax product
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-ajax-product-form-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_form_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_form_block.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-ajax-product-list',
            array(
                'url' => '/admin/shop/storage/ajax/product/list/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_list.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-ajax-product-storage-list',
            array(
                'url' => '/admin/shop/storage/ajax/product/storage/list/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_storage_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_storage_list.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-ajax-product-passport-list',
            array(
                'url' => '/admin/shop/storage/ajax/product/passport/list/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_passport_list.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/ajaxproduct/storage_ajaxproduct_passport_list.php',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-ajax-product-autocomplete',
            array(
                'url' => '/admin/shop/storage/ajax/product/filter/autocomplete/',
                'filephp' => dirname(__FILE__).
                    '/contents/admin/ajaxproduct/storage_product_search_json_autocomplete.php',
                'level' => '2',
            ),
            'override'
        );

        // orders
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-incoming',
            array(
                'title' => 'Orders',
                'url' => '/admin/shop/storage/orders/incoming/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_incoming.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_incoming.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-index',
            array(
                'title' => 'Orders',
                'url' => '/admin/shop/storage/orders/{type}/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_index.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-add',
            array(
                'title' => 'Order',
                'url' => '/admin/shop/storage/order/{type}/add/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_add.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_add.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-control',
            array(
                'title' => 'Order',
                'url' => '/admin/shop/storage/order/{id}/edit/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_control.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_control.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/order/storage_order_control.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-delete',
            array(
                'title' => 'Order',
                'url' => '/admin/shop/storage/order/{id}/delete/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_delete.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_delete.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-ajax-add',
            array(
                'url' => '/admin/shop/storage/order/ajax/addproduct/',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_ajax_add.php',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-ajax-update',
            array(
                'url' => '/admin/shop/storage/order/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_ajax_update.php',
                'level' => '2',
                'role' => array('storage-orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-table-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_table_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-message-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_message_block.html',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-toincoming',
            array(
                'title' => 'Incoming',
                'url' => '/admin/shop/storage/order/{id}/toincoming/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_toincoming.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_toincoming.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders', 'storage-incoming'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-totransfer',
            array(
                'title' => 'Transfer',
                'url' => '/admin/shop/storage/order/{id}/totransfer/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_totransfer.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_totransfer.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders', 'storage-transfer'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-toproduction',
            array(
                'title' => 'Production',
                'url' => '/admin/shop/storage/order/{id}/toproduction/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/order/storage_order_toproduction.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/order/storage_order_toproduction.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-orders', 'storage-production'),
            ),
            'override'
        );

        // storage basket
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-block-form',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_form.html',
                'filejs' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_form.js',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-block-import',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_import.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_import.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-add-ajax',
            array(
                'url' => '/admin/shop/storage/basket/add/ajax/',
                'filephp' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_add_ajax.php',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-ajax-update',
            array(
                'url' => '/admin/shop/storage/basket/update/ajax/',
                'filephp' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_update_ajax.php',
                'level' => '2',
                'role' => array('storage'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-block-table',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_table.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_table.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-basket-block-message',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/basket/storage_basket_block_message.html',
            ),
            'override'
        );

        // incoming
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-incoming',
            array(
                'title' => 'Incoming',
                'url' => '/admin/shop/storage/incoming/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/incoming/storage_incoming.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/incoming/storage_incoming.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-incoming'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-incoming-barcode-ajax-get-product',
            array(
                'url' => '/admin/shop/storage/incoming/barcode/ajax/get/product/',
                'filephp' => dirname(__FILE__).'/contents/admin/incoming/storage_incoming_barcode_ajax_get_product.php',
                'level' => '2',
                'role' => array('storage-incoming'),
            ),
            'override'
        );

        // transfer
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-transfer',
            array(
                'title' => 'Transfer',
                'url' => '/admin/shop/storage/transfer/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/transfer/storage_transfer.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/transfer/storage_transfer.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-transfer'),
            ),
            'override'
        );

        // outcoming
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-outcoming',
            array(
                'title' => 'Outcoming',
                'url' => '/admin/shop/storage/outcoming/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/outcoming/storage_outcoming.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/outcoming/storage_outcoming.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-outcoming'),
            ),
            'override'
        );

        // sale
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-order-tosale',
            array(
                'title' => 'Sale',
                'url' => '/admin/shop/storage/order/{id}/tosale/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/sale/storage_order_tosale.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_order_tosale.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-sale', 'orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale',
            array(
                'title' => 'Sale',
                'url' => '/admin/shop/storage/sale/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/sale/storage_sale.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_sale.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/sale/storage_sale.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-sale', 'orders'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale-quick',
            array(
                'title' => 'Quick sale',
                'url' => '/admin/shop/storage/sale/quick/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_quick.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_quick.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_quick.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-sale-quick'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale-ajax-add',
            array(
                'url' => '/admin/shop/storage/sale/ajax/add/',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_ajax_add.php',
                'level' => '2',
                'role' => array('storage-sale-quick'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale-ajax-update',
            array(
                'url' => '/admin/shop/storage/sale/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_ajax_update.php',
                'level' => '2',
                'role' => array('storage-sale-quick'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale-table-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_table_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-sale-message-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/sale/storage_sale_message_block.html',
            ),
            'override'
        );

        // production
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production',
            array(
                'title' => 'Production',
                'url' => '/admin/shop/storage/production/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/production/storage_production.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/production/storage_production.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/production/storage_production.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-production'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production-ajax-add',
            array(
                'url' => '/admin/shop/storage/production/ajax/add/',
                'filephp' => dirname(__FILE__) . '/contents/admin/production/storage_production_ajax_add.php',
                'level' => '2',
                'role' => array('storage-production'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production-ajax-update',
            array(
                'url' => '/admin/shop/storage/production/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/production/storage_production_ajax_update.php',
                'level' => '2',
                'role' => array('storage-production'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production-table-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/production/storage_production_table_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/production/storage_production_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production-passport-table-block',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/production/storage_production_passport_table_block.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/production/storage_production_passport_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-production-message-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/production/storage_production_message_block.html',
            ),
            'override'
        );

        // passports
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-product-passports',
            array(
                'title' => 'Passports',
                'url' => '/admin/shop/storage/passports/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_index.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_index.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-product-passport-add',
            array(
                'title' => 'Passports',
                'url' => '/admin/shop/storage/passport/add/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_add.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_add.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-product-passport-edit',
            array(
                'title' => 'Passports',
                'url' => '/admin/shop/storage/passport/{id}/edit/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_edit.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_edit.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_edit.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-passport-ajax-add',
            array(
                'url' => '/admin/shop/storage/passport/ajax/addproduct/',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_ajax_add.php',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-passport-ajax-update',
            array(
                'url' => '/admin/shop/storage/passport/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_ajax_update.php',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-passport-table-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_table_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-passport-message-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_message_block.html',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-product-passport-delete',
            array(
                'title' => 'Passports',
                'url' => '/admin/shop/storage/passport/{id}/delete/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_delete.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_delete.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-passports'),
            ),
            'override'
        );

        // reports
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-report-sales',
            array(
                'title' => 'Sale report',
                'url' => '/admin/shop/storage/report/sales/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/storage_report_sales.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/storage_report_sales.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/report/storage_report_sales.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-report-sales'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-report-motion',
            array(
                'title' => 'Motion report',
                'url' => '/admin/shop/storage/report/motion/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/storage_report_motion.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/storage_report_motion.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-report-motion'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-report-reserve',
            array(
                'title' => 'Reserve report',
                'url' => '/admin/shop/storage/report/reserve/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/report/storage_report_reserve.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/storage_report_reserve.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/report/storage_report_reserve.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-report-reserve-update-ajax',
            array(
                'url' => '/admin/shop/storage/report/reserve/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/report/storage_report_reserve_update_ajax.php',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        // штрих-кодирование
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-barcode-print',
            array(
                'title' => 'Barcodes',
                'url' => '/admin/shop/storage/barcode/print/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/barcode/storage_barcode_print.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/barcode/storage_barcode_print.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-barcode'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-barcode-read',
            array(
                'title' => 'Barcodes',
                'url' => '/admin/shop/storage/barcode/read/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/barcode/storage_barcode_read.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/barcode/storage_barcode_read.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/barcode/storage_barcode_read.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-barcode'),
            ),
            'override'
        );

        // ценники
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-pricecode-print',
            array(
                'title' => 'Price codes',
                'url' => '/admin/shop/storage/pricecode/print/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/pricecode/storage_pricecode_print.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/pricecode/storage_pricecode_print.php',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-barcode'),
            ),
            'override'
        );

        // переучет
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking',
            array(
                'title' => 'Stocktaking',
                'url' => '/admin/shop/storage/stocktaking/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking.js',
                'moveto' => 'shop-storage-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking-ajax-add',
            array(
                'url' => '/admin/shop/storage/stocktaking/ajax/add/',
                'filephp' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_ajax_add.php',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking-ajax-load',
            array(
                'url' => '/admin/shop/storage/stocktaking/ajax/load/',
                'filephp' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_ajax_load.php',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking-ajax-update',
            array(
                'url' => '/admin/shop/storage/stocktaking/ajax/update/',
                'filephp' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_ajax_update.php',
                'level' => '2',
                'role' => array('storage-balance'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking-table-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_table_block.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_table_block.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-stocktaking-message-block',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/stocktaking/storage_stocktaking_message_block.html',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-logicblock-stepper',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/logicblock/logicblock_stepper.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/logicblock/logicblock_stepper.php',
            ),
            'override'
        );

        // Tabs
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-tab-order',
            array(
                'title' => 'Storage records of order',
                'url' => array('/admin/shop/orders/{id}/storage/', '/admin/customorder/{type}/{id}/storage/'),
                'filehtml' => dirname(__FILE__) . '/contents/admin/tab/orders_storage.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tab/orders_storage.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-tab-product',
            array(
                'title' => 'Storage records of product',
                'url' => '/admin/shop/products/{id}/storage/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/tab/products_storage.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tab/products_storage.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-tab-product-passport',
            array(
                'title' => 'Product passport',
                'url' => '/admin/shop/products/{id}/passport/',
                'filehtml' => dirname(__FILE__) . '/contents/admin/tab/products_passport.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/tab/products_passport.php',
                'filejs' => dirname(__FILE__) . '/contents/admin/passport/storage_passport_edit.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
            ),
            'override'
        );

        // Blocks
        Engine::GetContentDataSource()->registerContent(
            'shop-admin-storage-block-workflow-status-edit',
            array(
                'filehtml' => dirname(__FILE__) . '/contents/admin/block/workflow_status_edit_block_storage.html',
                'filephp' => dirname(__FILE__) . '/contents/admin/block/workflow_status_edit_block_storage.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-debit-order-auto',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_debit_order_auto.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_debit_order_auto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-reserve-unset',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_reserve_unset.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_reserve_unset.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-product-return',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_product_return.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_product_return.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-order-sale-auto',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_order_sale.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_order_sale.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-product-reserve-auto',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_reserve_auto.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_reserve_auto.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'storage-order-status-action-block-production-passport',
            array(
                'filehtml' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_production_passport.html',
                'filephp' => dirname(__FILE__) .
                    '/contents/admin/block-action/storage_order_status_action_block_production_passport.php',
            ),
            'override'
        );

    }
}