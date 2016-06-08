<?php
Engine::GetContentDataSource()->registerContent(
    'shop-admin-products',
    array(
        'title' => 'Products',
        'url' => array('/admin/shop/products/', '/admin/shop/products/list-table/'),
        'filehtml' => dirname(__FILE__).'/products_index.html',
        'filephp' => dirname(__FILE__).'/products_index.php',
        'filejs' => dirname(__FILE__).'/products_index.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

// Продукты таблицей
Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-table',
    array(
        'filehtml' => dirname(__FILE__).'/products_index_table.html',
        'filephp' => dirname(__FILE__).'/products_index_table.php',
    ),
    'override'
);

// Продукты папками (проводником)
Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-inlist',
    array(
        'filehtml' => dirname(__FILE__).'/products_index_inlist.html',
        'filephp' => dirname(__FILE__).'/products_index_inlist.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-menu',
    array(
        'filehtml' => dirname(__FILE__).'/products_menu.html',
        'filephp' => dirname(__FILE__).'/products_menu.php',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-edit',
    array(
        'title' => 'Edit products',
        'url' => '/admin/shop/products/{id}/edit/',
        'filehtml' => dirname(__FILE__).'/products_edit.html',
        'filephp' => dirname(__FILE__).'/products_edit.php',
        'filejs' => dirname(__FILE__).'/products_add.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-image-upload-ajax',
    array(
        'url' => '/admin/shop/products/imageupload/',
        'filephp' => dirname(__FILE__).'/ajax/products_image_upload_ajax.php',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'add-new-category-ajax',
    array(
        'url' => '/admin/add/new/category/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/add_new_category_ajax.php'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'admin-product-filter-value-ajax',
    array(
        'url' => '/admin/product/filter/value/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/admin_product_filter_value_ajax.php'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'admin-products-json-autocomtlite-ajax',
    array(
        'url' => '/admin/products/json/autocomtlite/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/products_json_autocomplete_select2.php'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'admin-project-json-autocomtlite-ajax',
    array(
        'url' => '/admin/project/json/autocomtlite/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/project_json_autocomplete_select2.php'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-manage-ajax',
    array(
        'url' => '/admin/shop/manage/products/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/products_manage_ajax.php',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ckeditor-image-upload-ajax',
    array(
        'url' => '/admin/shop/ckeditor/imageupload/',
        'filephp' => dirname(__FILE__).'/ajax/ckeditor_image_upload_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'rebuild-category-tree-ajax',
    array(
        'url' => '/admin/shop/rebuild/categorytree/',
        'filephp' => dirname(__FILE__).'/ajax/rebuild_category_tree_ajax.php'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'product-category-tree',
    array(
        'filephp' => dirname(__FILE__).'/product_category_tree.php',
        'filehtml' => dirname(__FILE__).'/product_category_tree.html'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-copy',
    array(
        'title' => 'Copy product',
        'url' => '/admin/shop/products/copy/',
        'filehtml' => dirname(__FILE__).'/copy/products_copy.html',
        'filephp' => dirname(__FILE__).'/copy/products_copy.php',
        'filejs' => dirname(__FILE__).'/copy/products_copy.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-copy'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-filters',
    array(
        'title' => 'Filters',
        'url' => '/admin/shop/products/{id}/filters/',
        'filehtml' => dirname(__FILE__).'/products_filters.html',
        'filephp' => dirname(__FILE__).'/products_filters.php',
        'filejs' => dirname(__FILE__).'/products_filters.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-filters'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-suppliers',
    array(
        'title' => 'Suppliers',
        'url' => '/admin/shop/products/{id}/supplier/',
        'filehtml' => dirname(__FILE__).'/products_supplier.html',
        'filephp' => dirname(__FILE__).'/products_supplier.php',
        'filejs' => dirname(__FILE__).'/products_supplier.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-suppliers'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-view',
    array(
        'title' => 'Product #{id}',
        'url' => '/admin/shop/products/{id}/view/',
        'filehtml' => dirname(__FILE__).'/products_view.html',
        'filephp' => dirname(__FILE__).'/products_view.php',
        'filejs' => dirname(__FILE__).'/products_view.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-views'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-history',
    array(
        'title' => 'Views history',
        'url' => '/admin/shop/products/{id}/history/',
        'filehtml' => dirname(__FILE__).'/products_history.html',
        'filephp' => dirname(__FILE__).'/products_history.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-history'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-related',
    array(
        'title' => 'Related',
        'url' => '/admin/shop/products/{id}/related/',
        'filehtml' => dirname(__FILE__).'/products_related.html',
        'filephp' => dirname(__FILE__).'/products_related.php',
        'filejs' => dirname(__FILE__).'/products_related.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-related'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-delete',
    array(
        'title' => 'Delete product',
        'url' => '/admin/shop/products/{id}/delete/',
        'filehtml' => dirname(__FILE__).'/products_delete.html',
        'filephp' => dirname(__FILE__).'/products_delete.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-delete'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-comments',
    array(
        'title' => 'Comments',
        'url' => '/admin/shop/products/{id}/comments/',
        'filehtml' => dirname(__FILE__).'/products_comments.html',
        'filephp' => dirname(__FILE__).'/products_comments.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-comments'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-comments-control',
    array(
        'title' => 'Comments',
        'url' => '/admin/shop/products/comments/{key}/',
        'filehtml' => dirname(__FILE__).'/products_comments_control.html',
        'filephp' => dirname(__FILE__).'/products_comments_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-noticeavailability'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-noticeavailability',
    array(
        'title' => 'Notice of avail',
        'url' => '/admin/shop/products/noticeavailability/',
        'filehtml' => dirname(__FILE__).'/noticeavailability/products_noticeavailability.html',
        'filephp' => dirname(__FILE__).'/noticeavailability/products_noticeavailability.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-noticeavailability'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-noticeavailability-control',
    array(
        'title' => 'Notice of avail',
        'url' => '/admin/shop/products/noticeavailability/{id}/',
        'filehtml' => dirname(__FILE__).'/noticeavailability/products_noticeavailability_control.html',
        'filephp' => dirname(__FILE__).'/noticeavailability/products_noticeavailability_control.php',
        'filejs' => dirname(__FILE__).'/noticeavailability/products_noticeavailability.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-noticeavailability'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-icon',
    array(
        'title' => 'Icons',
        'url' => '/admin/shop/products/icon/',
        'filehtml' => dirname(__FILE__).'/icon/products_icon.html',
        'filephp' => dirname(__FILE__).'/icon/products_icon.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-icon'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-icon-control',
    array(
        'title' => 'Icons',
        'url' => array('/admin/shop/products/icon/add/', '/admin/shop/products/icon/{id}/'),
        'filehtml' => dirname(__FILE__).'/icon/products_icon_control.html',
        'filephp' => dirname(__FILE__).'/icon/products_icon_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-icon'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-lists',
    array(
        'title' => 'Product lists',
        'url' => '/admin/shop/products/{id}/lists/',
        'filehtml' => dirname(__FILE__).'/products_lists.html',
        'filephp' => dirname(__FILE__).'/products_lists.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-lists'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'admin-product-merge',
    array(
        'title' => 'Merge products',
        'url' => '/admin/product/merge/',
        'filehtml' => dirname(__FILE__).'/product_merge.html',
        'filephp' => dirname(__FILE__).'/product_merge.php',
        'filejs' => dirname(__FILE__).'/product_merge.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-action-set',
    array(
        'title' => 'Action sets',
        'url' => '/admin/shop/products/{id}/sets/',
        'filehtml' => dirname(__FILE__).'/action_sets_index.html',
        'filephp' => dirname(__FILE__).'/action_sets_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-lists'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-action-set-add',
    array(
        'title' => 'Action sets',
        'url' => '/admin/shop/products/{id}/sets/add/',
        'filehtml' => dirname(__FILE__).'/action_sets_add.html',
        'filephp' => dirname(__FILE__).'/action_sets_add.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-lists'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-action-set-control',
    array(
        'title' => 'Action sets',
        'url' => '/admin/shop/products/sets/{id}/',
        'filehtml' => dirname(__FILE__).'/action_sets_control.html',
        'filejs' => dirname(__FILE__).'/action_sets_control.js',
        'filephp' => dirname(__FILE__).'/action_sets_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-lists'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-add',
    array(
        'title' => 'Add product',
        'url' => '/admin/shop/products/add/',
        'filehtml' => dirname(__FILE__).'/products_add.html',
        'filephp' => dirname(__FILE__).'/products_add.php',
        'filejs' => dirname(__FILE__).'/products_add.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'products-add'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-list',
    array(
        'title' => 'List management',
        'url' => '/admin/shop/products/list/',
        'filehtml' => dirname(__FILE__).'/products_list.html',
        'filephp' => dirname(__FILE__).'/products_list.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-list'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-list-control',
    array(
        'title' => 'List managemnt',
        'url' => array('/admin/shop/products/list/add/', '/admin/shop/products/list/{key}/'),
        'filehtml' => dirname(__FILE__).'/products_list_control.html',
        'filephp' => dirname(__FILE__).'/products_list_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-list'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-in-list',
    array(
        'title' => 'Products in lists',
        'url' => '/admin/shop/products/productslist/',
        'filehtml' => dirname(__FILE__).'/products_in_list.html',
        'filephp' => dirname(__FILE__).'/products_in_list.php',
        'filejs' => dirname(__FILE__).'/products_in_list.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-list'),
    ),
    'override'
);


Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-exchange-xls',
    array(
        'title' => 'Products exchange with Excel',
        'url' => '/admin/shop/products/exchange-xls/',
        'filehtml' => dirname(__FILE__).'/products_exchange_xls.html',
        'filephp' => dirname(__FILE__).'/products_exchange_xls.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-import'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-filters-index',
    array(
        'title' => 'Filters and characteristics',
        'url' => '/admin/shop/products/filters/',
        'filehtml' => dirname(__FILE__).'/products_filters_index.html',
        'filephp' => dirname(__FILE__).'/products_filters_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-filters'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-filters-control',
    array(
        'title' => 'Filters and characteristics',
        'url' => array('/admin/shop/products/filters/{id}/control/', '/admin/shop/products/filters/add/'),
        'filehtml' => dirname(__FILE__).'/products_filters_control.html',
        'filephp' => dirname(__FILE__).'/products_filters_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products-filters'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-product-nameformula',
    array(
        'url' => '/admin/shop/product/nameformula/',
        'filehtml' => dirname(__FILE__).'/products_nameformula.html',
        'filephp' => dirname(__FILE__).'/products_nameformula.php',
        'level' => '2',
        'role' => array('products'),
    ),
    'override'
);



Engine::GetContentDataSource()->registerContent(
    'shop-admin-products-priceplaces',
    array(
        'title' => 'Prices places',
        'url' => '/admin/shop/products/{id}/priceplaces/',
        'filehtml' => dirname(__FILE__).'/products_priceplaces.html',
        'filephp' => dirname(__FILE__).'/products_priceplaces.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('products', 'priceplaces'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-preview',
    array(
        'url' => '/admin/product/preview/',
        'filehtml' => dirname(__FILE__).'/product_preview.html',
        'filephp' => dirname(__FILE__).'/product_preview.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-barcode',
    array(
        'url' => '/admin/product/{id}/barcode/',
        'filehtml' => dirname(__FILE__).'/product_barcode.html',
        'filephp' => dirname(__FILE__).'/product_barcode.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-pricecode',
    array(
        'url' => '/admin/product/{id}/pricecode/',
        'filehtml' => dirname(__FILE__).'/product_pricecode.html',
        'filephp' => dirname(__FILE__).'/product_pricecode.php',
        'level' => '2',
    ),
    'override'
);