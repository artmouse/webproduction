<?php

class SupplierPrice_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/contents/admin/';

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-supplier-import',
            array(
                'title' => 'Supplier price upload',
                'url' => '/admin/shop/products/supplier/import/',
                'filehtml' => $path.'/products_supplier_import.html',
                'filephp' => $path.'/products_supplier_import.php',
                'filejs' => $path.'/products_supplier_import.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('products', 'products-suppliers', 'products-import'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-supplier-binding',
            array(
                'title' => 'Связывание продуктов',
                'url' => '/admin/shop/products/supplier/binding/',
                'filehtml' => $path.'/products_supplier_binding.html',
                'filecss' => $path . '/products_supplier_binding.css',
                'filephp' => $path.'/products_supplier_binding.php',
                'filejs' => $path.'/products_supplier_binding.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('products', 'products-suppliers', 'products-import'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-supplier-ignore',
            array(
                'title' => 'Список игнорируемых товаров ЗПП',
                'url' => '/admin/shop/products/supplier/ignore/',
                'filehtml' => $path.'/products_supplier_ignore.html',
                'filejs' => $path.'/products_supplier_ignore.js',
                'filephp' => $path.'/products_supplier_ignore.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('products', 'products-suppliers', 'products-import'),
            ),
            'override'
        );



        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-supplier-import-history',
            array(
                'title' => 'Supplier price upload history',
                'url' => '/admin/shop/products/supplier/import/history',
                'filehtml' => $path.'/products_supplier_import_history.html',
                'filephp' => $path.'/products_supplier_import_history.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('products', 'products-suppliers', 'products-import'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-supplier-prew',
            array(
                'url' => '/admin/shop/supplier/import/prew',
                'filephp' => $path.'/ajax_supplier_import_prew.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-ajax-supplier-binding-products',
            array(
                'url' => '/admin/shop/supplier/binding/products',
                'filephp' => $path.'/ajax_supplier_binding_products.php',
                'level' => '2',
                'role' => array('products', 'products-suppliers', 'products-import'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-ajax-supplier-search-products',
            array(
                'url' => '/admin/shop/supplier/search/products',
                'filephp' => $path.'/ajax_supplier_search_products.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-supplier-import-config',
            array(
                'url' => '/supplier/import/config/',
                'filephp' => $path.'/products_supplier_import_config.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-status-supplier-import',
            array(
                'filehtml' => $path.'/status_import.html',
                'filephp' => $path.'/status_import.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-supplier-import-prew',
            array(
                'filehtml' => $path.'/import_prew.html',
                'filephp' => $path.'/import_prew.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-supplier-import-status-print',
            array(
                'url' => '/supplier/import/status/print',
                'filephp' => $path.'/supplier_import_status_print.php',
            ),
            'override'
        );


        Engine::GetContentDataSource()->registerContent(
            'shop-order-status-action-block-supplier-order',
            array(
                'filehtml' => $path.'/block-action/action_block_supplier_order.html',
                'filephp' => $path.'/block-action/action_block_supplier_order.php',
            ),
            'override'
        );
    }

}