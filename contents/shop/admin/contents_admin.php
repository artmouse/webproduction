<?php
Engine::GetContentDataSource()->registerContent(
    'datasource-filter',
    array(
        'filehtml' => dirname(__FILE__).'/datasource_filter.html',
        'filephp' => dirname(__FILE__).'/datasource_filter.php',
        'filejs' => dirname(__FILE__).'/datasource_filter.js',
        'level' => '1',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-selectwindow',
    array(
        'url' => '/admin/selectwindow/',
        'filehtml' => dirname(__FILE__).'/selectwindow/selectwindow_index.html',
        'filephp' => dirname(__FILE__).'/selectwindow/selectwindow_index.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-welcome',
    array(
        'title' => 'Welcome',
        'url' => '/admin/welcome/',
        'filehtml' => dirname(__FILE__).'/welcome/welcome_index.html',
        'filejs' => dirname(__FILE__).'/welcome/welcome_index.js',
        'filephp' => dirname(__FILE__).'/welcome/welcome_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-dashboard',
    array(
        'title' => 'Dashboard',
        'url' => '/admin/',
        'filehtml' => dirname(__FILE__).'/dashboard/dashboard_index.html',
        'filephp' => dirname(__FILE__).'/dashboard/dashboard_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-delivery',
    array(
        'title' => 'Delivery',
        'url' => '/admin/shop/delivery/',
        'filehtml' => dirname(__FILE__).'/delivery/delivery_index.html',
        'filephp' => dirname(__FILE__).'/delivery/delivery_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('delivery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-delivery-edit',
    array(
        'title' => 'Edit delivery',
        'url' => '/admin/shop/delivery/{id}/edit/',
        'filehtml' => dirname(__FILE__).'/delivery/delivery_edit.html',
        'filephp' => dirname(__FILE__).'/delivery/delivery_edit.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('delivery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-delivery-delete',
    array(
        'title' => 'Delete delivery',
        'url' => '/admin/shop/delivery/{id}/delete/',
        'filehtml' => dirname(__FILE__).'/delivery/delivery_delete.html',
        'filephp' => dirname(__FILE__).'/delivery/delivery_delete.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('delivery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-delivery-add',
    array(
        'title' => 'Add delivery',
        'url' => '/admin/shop/delivery/add/',
        'filehtml' => dirname(__FILE__).'/delivery/delivery_add.html',
        'filephp' => dirname(__FILE__).'/delivery/delivery_add.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('delivery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-comments',
    array(
        'title' => 'Comments',
        'url' => '/admin/shop/comments/',
        'filehtml' => dirname(__FILE__).'/comments/comments_index.html',
        'filephp' => dirname(__FILE__).'/comments/comments_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('comments'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-comments-control',
    array(
        'title' => 'Comments',
        'url' => array('/admin/shop/comments/add/', '/admin/shop/comments/{id}/'),
        'filehtml' => dirname(__FILE__).'/comments/comments_control.html',
        'filephp' => dirname(__FILE__).'/comments/comments_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('comments'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-block',
    array(
        'title' => 'Blocks',
        'url' => '/admin/shop/block/',
        'filehtml' => dirname(__FILE__).'/block/block_index.html',
        'filephp' => dirname(__FILE__).'/block/block_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('block'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-contractors',
    array(
        'title' => 'Contractors',
        'url' => '/admin/shop/contractors/',
        'filehtml' => dirname(__FILE__).'/contractors/contractors_index.html',
        'filephp' => dirname(__FILE__).'/contractors/contractors_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('contractors'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-contractors-control',
    array(
        'title' => 'Contractors',
        'url' => array('/admin/shop/contractors/add/', '/admin/shop/contractors/{id}/'),
        'filehtml' => dirname(__FILE__).'/contractors/contractors_control.html',
        'filephp' => dirname(__FILE__).'/contractors/contractors_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('contractors'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-feedback',
    array(
        'title' => 'Feedback',
        'url' => '/admin/shop/feedback/',
        'filehtml' => dirname(__FILE__).'/feedback/feedback_index.html',
        'filephp' => dirname(__FILE__).'/feedback/feedback_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('feedback'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-feedback-control',
    array(
        'title' => 'Feedback',
        'url' => '/admin/shop/feedback/{id}/',
        'filehtml' => dirname(__FILE__).'/feedback/feedback_control.html',
        'filephp' => dirname(__FILE__).'/feedback/feedback_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('feedback'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-category',
    array(
        'title' => 'Categories list',
        'url' => '/admin/shop/category/',
        'filehtml' => dirname(__FILE__).'/category/category_index.html',
        'filephp' => dirname(__FILE__).'/category/category_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('category'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-manage',
    array(
        'title' => 'Categories manager',
        'url' => '/admin/shop/category/manage/',
        'filehtml' => dirname(__FILE__).'/category/category_manage.html',
        'filephp' => dirname(__FILE__).'/category/category_manage.php',
        'filejs' => dirname(__FILE__).'/category/category_manage.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('category'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-category-control',
    array(
        'title' => 'Manage category',
        'url' => array('/admin/shop/category/add/', '/admin/shop/category/{key}/'),
        'filehtml' => dirname(__FILE__).'/category/category_control.html',
        'filephp' => dirname(__FILE__).'/category/category_control.php',
        'filejs' => dirname(__FILE__).'/category/category_control.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('category'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-redirect',
    array(
        'title' => 'URL and redirects',
        'url' => '/admin/shop/redirect/',
        'filehtml' => dirname(__FILE__).'/redirect/redirect_index.html',
        'filephp' => dirname(__FILE__).'/redirect/redirect_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('redirect'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-redirect-control',
    array(
        'title' => 'URL and redirects',
        'url' => array('/admin/shop/redirect/add/', '/admin/shop/redirect/{key}/'),
        'filehtml' => dirname(__FILE__).'/redirect/redirect_control.html',
        'filephp' => dirname(__FILE__).'/redirect/redirect_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('redirect'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-source',
    array(
        'title' => 'Order/user source',
        'url' => '/admin/shop/source/',
        'filehtml' => dirname(__FILE__).'/source/source_index.html',
        'filephp' => dirname(__FILE__).'/source/source_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-source-control',
    array(
        'title' => 'Order/user source',
        'url' => array('/admin/shop/source/add/', '/admin/shop/source/{key}/'),
        'filehtml' => dirname(__FILE__).'/source/source_control.html',
        'filephp' => dirname(__FILE__).'/source/source_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-gallery',
    array(
        'title' => 'Gallery',
        'url' => '/admin/shop/gallery/',
        'filehtml' => dirname(__FILE__).'/gallery/gallery_index.html',
        'filephp' => dirname(__FILE__).'/gallery/gallery_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('gallery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-gallery-control',
    array(
        'title' => 'Gallery',
        'url' => array('/admin/shop/gallery/add/', '/admin/shop/gallery/{key}/'),
        'filehtml' => dirname(__FILE__).'/gallery/gallery_control.html',
        'filephp' => dirname(__FILE__).'/gallery/gallery_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('gallery'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-smslog',
    array(
        'title' => 'SMS history',
        'url' => '/admin/shop/smslog/',
        'filehtml' => dirname(__FILE__).'/smslog/smslog_index.html',
        'filephp' => dirname(__FILE__).'/smslog/smslog_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-settings',
    array(
        'title' => 'Settings',
        'url' => array('/admin/shop/settings/', '/admin/shop/settings/{tabname}/'),
        'filehtml' => dirname(__FILE__).'/settings/settings_index.html',
        'filephp' => dirname(__FILE__).'/settings/settings_index.php',
        'filejs' => dirname(__FILE__).'/settings/settings_index.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-news',
    array(
        'title' => 'News',
        'url' => '/admin/shop/news/',
        'filehtml' => dirname(__FILE__).'/news/news_index.html',
        'filephp' => dirname(__FILE__).'/news/news_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('news'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-news-control',
    array(
        'title' => 'News',
        'url' => '/admin/shop/news/{id}/',
        'filehtml' => dirname(__FILE__).'/news/news_control.html',
        'filephp' => dirname(__FILE__).'/news/news_control.php',
        'filejs' => dirname(__FILE__).'/news/news_control.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('news'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-news-add',
    array(
        'title' => 'Add news',
        'url' => '/admin/shop/addnews/',
        'filehtml' => dirname(__FILE__).'/news/news_add.html',
        'filephp' => dirname(__FILE__).'/news/news_add.php',
        'filejs' => dirname(__FILE__).'/news/news_control.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('news'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-banner',
    array(
        'title' => 'Banners',
        'url' => '/admin/shop/banner/',
        'filehtml' => dirname(__FILE__).'/banner/banner_index.html',
        'filephp' => dirname(__FILE__).'/banner/banner_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('banner'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-banner-control',
    array(
        'title' => 'Banners',
        'url' => array('/admin/shop/banner/add/', '/admin/shop/banner/{id}/edit/'),
        'filehtml' => dirname(__FILE__).'/banner/banner_control.html',
        'filephp' => dirname(__FILE__).'/banner/banner_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('banner'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-banner-clicks',
    array(
        'url' => '/admin/shop/banner/{id}/clicks/',
        'filehtml' => dirname(__FILE__).'/banner/banner_clicks.html',
        'filephp' => dirname(__FILE__).'/banner/banner_clicks.php',
        'filejs' => dirname(__FILE__).'/banner/banner_clicks.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('banner'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-faq',
    array(
        'title' => 'FAQ',
        'url' => '/admin/shop/faq/',
        'filehtml' => dirname(__FILE__).'/faq/faq_index.html',
        'filephp' => dirname(__FILE__).'/faq/faq_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('faq'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-faq-control',
    array(
        'title' => 'FAQ',
        'url' => array('/admin/shop/faq/add/', '/admin/shop/faq/{id}/'),
        'filehtml' => dirname(__FILE__).'/faq/faq_control.html',
        'filephp' => dirname(__FILE__).'/faq/faq_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('faq'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-brands',
    array(
        'title' => 'Brands',
        'url' => '/admin/shop/brands/',
        'filehtml' => dirname(__FILE__).'/brands/brands_index.html',
        'filephp' => dirname(__FILE__).'/brands/brands_index.php',
        'filejs' => dirname(__FILE__).'/brands/brands_index.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('brands'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-brands-control',
    array(
        'title' => 'Brands',
        'url' => array('/admin/shop/brands/add/', '/admin/shop/brands/{id}/'),
        'filehtml' => dirname(__FILE__).'/brands/brands_control.html',
        'filephp' => dirname(__FILE__).'/brands/brands_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('brands'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-currency',
    array(
        'title' => 'Currencies',
        'url' => '/admin/shop/currency/',
        'filehtml' => dirname(__FILE__).'/currency/currency_index.html',
        'filephp' => dirname(__FILE__).'/currency/currency_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-coupon',
    array(
        'title' => 'Coupons',
        'url' => '/admin/shop/coupon/',
        'filehtml' => dirname(__FILE__).'/coupon/coupon_index.html',
        'filephp' => dirname(__FILE__).'/coupon/coupon_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-coupon-control',
    array(
        'title' => 'Coupons',
        'url' => array('/admin/shop/coupon/add/', '/admin/shop/coupon/{id}/'),
        'filehtml' => dirname(__FILE__).'/coupon/coupon_control.html',
        'filephp' => dirname(__FILE__).'/coupon/coupon_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-currency-control',
    array(
        'title' => 'Currencies',
        'url' => array('/admin/shop/currency/add/', '/admin/shop/currency/{id}/'),
        'filehtml' => dirname(__FILE__).'/currency/currency_control.html',
        'filephp' => dirname(__FILE__).'/currency/currency_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-textpages',
    array(
        'title' => 'Pages',
        'url' => '/admin/shop/textpages/',
        'filehtml' => dirname(__FILE__).'/textpages/textpages_index.html',
        'filephp' => dirname(__FILE__).'/textpages/textpages_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('pages'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-textpages-control',
    array(
        'url' => array('/admin/shop/textpages/add/', '/admin/shop/textpages/{id}/'),
        'filehtml' => dirname(__FILE__).'/textpages/textpages_control.html',
        'filephp' => dirname(__FILE__).'/textpages/textpages_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('pages'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-tpl',
    array(
        'filehtml' => dirname(__FILE__).'/admin_shop_tpl.html',
        'filephp' => dirname(__FILE__).'/admin_shop_tpl.php',
        'filecss' => dirname(__FILE__).'/admin_shop_tpl.css',
        'filejs' => array(
            dirname(__FILE__).'/old-browser.js',
            dirname(__FILE__).'/admin_shop_tpl.js'
        ),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-svg',
    array(
        'filehtml' => dirname(__FILE__).'/admin_shop_svg.html',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-activity',
    array(
        'title' => 'Activity',
        'url' => '/admin/shop/activity/',
        'filehtml' => dirname(__FILE__).'/activity/activity_index.html',
        'filephp' => dirname(__FILE__).'/activity/activity_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('activity'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-payment',
    array(
        'title' => 'Payments',
        'url' => '/admin/shop/payment/',
        'filehtml' => dirname(__FILE__).'/payment/payment_index.html',
        'filephp' => dirname(__FILE__).'/payment/payment_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('payment'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-payment-control',
    array(
        'title' => 'Payments',
        'url' => array('/admin/shop/payment/add/', '/admin/shop/payment/{id}/'),
        'filehtml' => dirname(__FILE__).'/payment/payment_control.html',
        'filephp' => dirname(__FILE__).'/payment/payment_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('payment'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-supplier',
    array(
        'url' => '/admin/shop/supplier/',
        'filehtml' => dirname(__FILE__).'/supplier/supplier_index.html',
        'filephp' => dirname(__FILE__).'/supplier/supplier_index.php',
        'filejs' => dirname(__FILE__).'/supplier/supplier_index.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('supplier'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-supplier-control',
    array(
        'url' => array('/admin/shop/supplier/add/', '/admin/shop/supplier/{id}/'),
        'filehtml' => dirname(__FILE__).'/supplier/supplier_control.html',
        'filephp' => dirname(__FILE__).'/supplier/supplier_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('supplier'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-callback',
    array(
        'title' => 'Callbacks',
        'url' => '/admin/shop/callback/',
        'filehtml' => dirname(__FILE__).'/callback/callback_index.html',
        'filephp' => dirname(__FILE__).'/callback/callback_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('callback'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-callback-control',
    array(
        'title' => 'Callbacks',
        'url' => '/admin/shop/callback/{id}/control/',
        'filehtml' => dirname(__FILE__).'/callback/callback_control.html',
        'filephp' => dirname(__FILE__).'/callback/callback_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('callback'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-timework',
    array(
        'title' => 'Work time',
        'url' => '/admin/shop/timework/',
        'filehtml' => dirname(__FILE__).'/timework/timework_index.html',
        'filephp' => dirname(__FILE__).'/timework/timework_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('timework'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-timework-control',
    array(
        'title' => 'Work time',
        'url' => array('/admin/shop/timework/add/', '/admin/shop/timework/{key}/'),
        'filehtml' => dirname(__FILE__).'/timework/timework_control.html',
        'filephp' => dirname(__FILE__).'/timework/timework_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('timework'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-logo',
    array(
        'title' => 'Logo',
        'url' => '/admin/shop/logo/',
        'filehtml' => dirname(__FILE__).'/logo/logo_index.html',
        'filephp' => dirname(__FILE__).'/logo/logo_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('logo'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-logo-control',
    array(
        'title' => 'Logo',
        'url' => array('/admin/shop/logo/add/', '/admin/shop/logo/{key}/'),
        'filehtml' => dirname(__FILE__).'/logo/logo_control.html',
        'filephp' => dirname(__FILE__).'/logo/logo_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('logo'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-discount',
    array(
        'title' => 'Discounts',
        'url' => '/admin/shop/discount/',
        'filehtml' => dirname(__FILE__).'/discount/discount_index.html',
        'filephp' => dirname(__FILE__).'/discount/discount_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('discount'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-discount-control',
    array(
        'title' => 'Discounts',
        'url' => array('/admin/shop/discount/add/', '/admin/shop/discount/{key}/'),
        'filehtml' => dirname(__FILE__).'/discount/discount_control.html',
        'filephp' => dirname(__FILE__).'/discount/discount_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('discount'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-guestbook',
    array(
        'title' => 'Guestbook',
        'url' => '/admin/shop/guestbook/',
        'filehtml' => dirname(__FILE__).'/guestbook/guestbook_index.html',
        'filephp' => dirname(__FILE__).'/guestbook/guestbook_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('guestbook'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-guestbook-control',
    array(
        'url' => array('/admin/shop/guestbook/add/', '/admin/shop/guestbook/{id}/'),
        'filehtml' => dirname(__FILE__).'/guestbook/guestbook_control.html',
        'filephp' => dirname(__FILE__).'/guestbook/guestbook_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('guestbook'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-quickedit',
    array(
        'url' => '/admin/shop/quickedit/',
        'filehtml' => dirname(__FILE__).'/quickedit/quickedit_index.html',
        'filephp' => dirname(__FILE__).'/quickedit/quickedit_index.php',
        'level' => '2',
        'role' => array('products-edit-quick'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ticket-support',
    array(
        'title' => 'Support ticket',
        'url' => '/admin/shop/ticket/support/',
        'filehtml' => dirname(__FILE__).'/ticket/ticket_index.html',
        'filephp' => dirname(__FILE__).'/ticket/ticket_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('ticket-support'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-support-order',
    array(
        'title' => 'Support order',
        'url' => '/admin/shop/support/order/',
        'filehtml' => dirname(__FILE__).'/ticket/ticket_order.html',
        'filephp' => dirname(__FILE__).'/ticket/ticket_order.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-clear-cache',
    array(
        'url' => '/admin/shop/clear/cache/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_clear_cache.php',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-user-post-search',
    array(
        'url' => '/admin/shop/ajax/post/search/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_user_post_search.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-storage-select-init-ajax',
    array(
        'url' => '/shop/storage/select/init/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/shop_storage_select_init_ajax.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-novaposhta-get-offices-ajax',
    array(
        'url' => '/shop/novapostha/get/offices/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/novaposhta/novaposhta_get_offices_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-novaposhta-get-cities-ajax',
    array(
        'url' => '/shop/novapostha/get/cities/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/novaposhta/novaposhta_get_cities_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-search',
    array(
        'url' => '/admin/shop/search/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_search.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-emails-search',
    array(
        'url' => '/admin/shop/ajax/emails/search/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_emails_search.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-send-email',
    array(
        'url' => '/admin/shop/sendemail/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_send_email.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-send-sms',
    array(
        'url' => '/admin/shop/sendsms/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_send_sms.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-create-issue',
    array(
        'url' => '/admin/shop/createissue/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_create_issue.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-edit-comment',
    array(
        'url' => '/admin/shop/edit-comment/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_admin_edit_comment.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-category-manager',
    array(
        'url' => '/admin/shop/ajax/category/manager/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_category_manager.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-ajax-load-releted-categories',
    array(
        'url' => '/admin/shop/load/releted/categories/ajax/',
        'filephp' => dirname(__FILE__).'/ajax/ajax_load_releted_categories.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-uplodify',
    array(
        'url' => '/admin/shop/uplodify/',
        'filephp' => dirname(__FILE__).'/uplodify.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'imagecropper',
    array(
        'filehtml' => dirname(__FILE__).'/imagecropper/imagecropper_include.html',
        'filephp' => dirname(__FILE__).'/imagecropper/imagecropper_include.php',
        'filejs' => dirname(__FILE__).'/imagecropper/imagecropper_include.js',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'imagecropper-image-ajax',
    array(
        'url' => '/imagecropper/upload/ajax/',
        'filephp' => dirname(__FILE__).'/imagecropper/imagecropper_upload_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'imagecropper-saveimage-ajax',
    array(
        'url' => '/imagecropper/saveimage/ajax/',
        'filephp' => dirname(__FILE__).'/imagecropper/imagecropper_saveimage_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'callcenter-index',
    array(
        'title' => 'Call-center',
        'url' => '/admin/shop/callcenter/',
        'filehtml' => dirname(__FILE__).'/callcenter/callcenter_index.html',
        'filephp' => dirname(__FILE__).'/callcenter/callcenter_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_callcenter'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'callcenter-ajax',
    array(
        'url' => '/admin/shop/callcenter/ajax/',
        'filehtml' => dirname(__FILE__).'/callcenter/callcenter_ajax.html',
        'filephp' => dirname(__FILE__).'/callcenter/callcenter_ajax.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-summary',
    array(
        'title' => 'Summary report',
        'url' => '/admin/shop/report/summary/',
        'filehtml' => dirname(__FILE__).'/report/report_summary.html',
        'filephp' => dirname(__FILE__).'/report/report_summary.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_summary'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-sourceclients',
    array(
        'title' => 'Client sources',
        'url' => '/admin/shop/report/sourceclients/',
        'filehtml' => dirname(__FILE__).'/report/report_sourceclients.html',
        'filephp' => dirname(__FILE__).'/report/report_sourceclients.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_sourceclients'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-notify',
    array(
        'title' => 'Notify report',
        'url' => '/admin/shop/report/notify/',
        'filehtml' => dirname(__FILE__).'/report/report_notify.html',
        'filephp' => dirname(__FILE__).'/report/report_notify.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_notify'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-eventdate',
    array(
        'title' => 'Events on date',
        'url' => '/admin/shop/report/eventdate/',
        'filehtml' => dirname(__FILE__).'/report/report_eventdate.html',
        'filephp' => dirname(__FILE__).'/report/report_eventdate.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_eventdate'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-event',
    array(
        'title' => 'Events',
        'url' => '/admin/shop/report/event/',
        'filehtml' => dirname(__FILE__).'/report/report_event.html',
        'filephp' => dirname(__FILE__).'/report/report_event.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_event'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-eventtree',
    array(
        'title' => 'Events tree',
        'url' => '/admin/shop/report/eventtree/',
        'filehtml' => dirname(__FILE__).'/report/report_eventtree.html',
        'filephp' => dirname(__FILE__).'/report/report_eventtree.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_eventtree'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-contacttree',
    array(
        'title' => 'Contact tree',
        'url' => '/admin/shop/report/contacttree/',
        'filehtml' => dirname(__FILE__).'/report/report_contacttree.html',
        'filephp' => dirname(__FILE__).'/report/report_contacttree.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_contacttree'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'event-list-block',
    array(
        'filehtml' => dirname(__FILE__).'/event/event_list_block.html',
        'filephp' => dirname(__FILE__).'/event/event_list_block.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'event-load',
    array(
        'url' => '/admin/shop/event/load/',
        'filehtml' => dirname(__FILE__).'/event/event_load.html',
        'filephp' => dirname(__FILE__).'/event/event_load.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'event-rating',
    array(
        'url' => '/admin/shop/event/rating/',
        'filephp' => dirname(__FILE__).'/event/event_rating.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'event-view',
    array(
        'url' => '/admin/shop/event/{id}/',
        'filehtml' => dirname(__FILE__).'/event/event_view.html',
        'filejs' => dirname(__FILE__).'/event/event_view.js',
        'filephp' => dirname(__FILE__).'/event/event_view.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-paymentdate',
    array(
        'title' => 'Payments on date',
        'url' => '/admin/shop/report/paymentdate/',
        'filehtml' => dirname(__FILE__).'/report/report_paymentdate.html',
        'filephp' => dirname(__FILE__).'/report/report_paymentdate.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('finance'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'file-download',
    array(
        'url' => '/admin/shop/file/download/{id}/',
        'filephp' => dirname(__FILE__).'/file/file_download.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'file-upload-ajax',
    array(
        'url' => '/admin/shop/file/upload/ajax/',
        'filephp' => dirname(__FILE__).'/file/file_upload_ajax.php',
        'level' => '2',
    ),
    'override'
);

// блок фильтров по статусам и workflow'ам
Engine::GetContentDataSource()->registerContent(
    'workflow-filter-block',
    array(
        'filehtml' => dirname(__FILE__).'/workflow/workflow_filter_block.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_filter_block.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'workflow-status-list-ajax',
    array(
        'url' => '/workflow/status/list/ajax/',
        'filephp' => dirname(__FILE__).'/workflow/workflow_status_list_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflow/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_index.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-type',
    array(
        'title' => 'Workflow Type',
        'url' => '/admin/shop/workflowtype/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_type.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_type.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-type-edit',
    array(
        'title' => 'Workflow Type',
        'url' => '/admin/shop/workflowtype/{id}/edit/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_type_edit.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_type_edit.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-type-add',
    array(
        'title' => 'Workflow Type',
        'url' => '/admin/shop/workflowtype/add/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_type_add.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_type_add.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-smarty-workflow',
    array(
        'url' => '/admin/order/smarty/workflow/',
        'filehtml' => dirname(__FILE__).'/workflow/smarty/smarty_workflow.html',
        'filephp' => dirname(__FILE__).'/workflow/smarty/smarty_workflow.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-edit',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflow/{id}/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_edit.html',
        'filejs' => dirname(__FILE__).'/workflow/workflow_edit.js',
        'filephp' => dirname(__FILE__).'/workflow/workflow_edit.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-status-edit',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflowstatus/{id}/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_status_edit.html',
        'filejs' => dirname(__FILE__).'/workflow/workflow_status_edit.js',
        'filephp' => dirname(__FILE__).'/workflow/workflow_status_edit.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-status-action',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflowstatus/{id}/action/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_status_action.html',
        'filejs' => dirname(__FILE__).'/workflow/workflow_status_action.js',
        'filephp' => dirname(__FILE__).'/workflow/workflow_status_action.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-status-action-new',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflowstatus/{id}/action/new/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_status_action_new.html',
        'filejs' => dirname(__FILE__).'/workflow/workflow_status_action_new.js',
        'filephp' => dirname(__FILE__).'/workflow/workflow_status_action_new.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-workflow-delete',
    array(
        'title' => 'Workflows',
        'url' => '/admin/shop/workflow/{id}/delete/',
        'filehtml' => dirname(__FILE__).'/workflow/workflow_delete.html',
        'filephp' => dirname(__FILE__).'/workflow/workflow_delete.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('settings'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-smart-closed-ajax',
    array(
        'url' => '/admin/issue/smart/closed/ajax/',
        'filephp' => dirname(__FILE__).'/issue/issue_smart_closed_ajax.php',
    ),
    'override'
);

// блок списка задач
Engine::GetContentDataSource()->registerContent(
    'issue-list',
    array(
        'filehtml' => dirname(__FILE__).'/issue/issue_list.html',
        'filephp' => dirname(__FILE__).'/issue/issue_list.php',
        'filejs' => dirname(__FILE__).'/issue/issue_list.js',
    ),
    'override'
);

// блок списка задач
Engine::GetContentDataSource()->registerContent(
    'issue-add-quick',
    array(
        'filehtml' => dirname(__FILE__).'/issue/issue_add_quick.html',
        'filephp' => dirname(__FILE__).'/issue/issue_add_quick.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-add-products-list',
    array(
        'url' => '/issue/add/products/list/',
        'filehtml' => dirname(__FILE__).'/issue/issue_add_products_list.html',
        'filephp' => dirname(__FILE__).'/issue/issue_add_products_list.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-add-ajax',
    array(
        'url' => '/admin/issue/ajax/add/',
        'filephp' => dirname(__FILE__).'/issue/issue_ajax_add.php',
        'level' => '2',
        'role' => array('issue'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-add-search-ajax-select2',
    array(
        'url' => '/admin/issue/searchajax/select2/',
        'filephp' => dirname(__FILE__).'/issue/search_issue_ajax_select2.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-add-workflow-preview',
    array(
        'url' => '/admin/issue/workflow-preview/',
        'filephp' => dirname(__FILE__).'/issue/issue_add_workflow_preview.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-add-workflow-fields',
    array(
        'url' => '/admin/issue/workflow-fields/',
        'filephp' => dirname(__FILE__).'/issue/issue_add_workflow_fields.php',
        'filehtml' => dirname(__FILE__).'/issue/issue_add_workflow_fields.html',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-checklist-block',
    array(
        'filephp' => dirname(__FILE__).'/issue/issue_checklist_block.php',
        'filehtml' => dirname(__FILE__).'/issue/issue_checklist_block.html',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-workflow-preview',
    array(
        'filehtml' => dirname(__FILE__).'/issue/issue_workflow_preview.html',
        'filephp' => dirname(__FILE__).'/issue/issue_workflow_preview.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-issue-preview',
    array(
        'url' => '/admin/issue/preview/',
        'filehtml' => dirname(__FILE__).'/issue/issue_preview.html',
        'filephp' => dirname(__FILE__).'/issue/issue_preview.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'ignore-index',
    array(
        'title' => 'Ignore',
        'url' => '/admin/ignore/',
        'filehtml' => dirname(__FILE__).'/ignore/ignore_index.html',
        'filephp' => dirname(__FILE__).'/ignore/ignore_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'ignore-add',
    array(
        'title' => 'Ignore',
        'url' => '/admin/ignore/add/',
        'filehtml' => dirname(__FILE__).'/ignore/ignore_add.html',
        'filephp' => dirname(__FILE__).'/ignore/ignore_add.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'ignore-control',
    array(
        'title' => 'Ignore',
        'url' => '/admin/ignore/{id}/',
        'filehtml' => dirname(__FILE__).'/ignore/ignore_control.html',
        'filephp' => dirname(__FILE__).'/ignore/ignore_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('report_event'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'meeting-add',
    array(
        'title' => 'Meeting',
        'url' => '/admin/meeting/add/',
        'filehtml' => dirname(__FILE__).'/meeting/meeting_add.html',
        'filephp' => dirname(__FILE__).'/meeting/meeting_add.php',
        'filejs' => dirname(__FILE__).'/meeting/meeting_add.js',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('users'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-meeting-index',
    array(
        'title' => 'Meeting',
        'url' => '/admin/meeting/{id}/',
        'filehtml' => dirname(__FILE__).'/meeting/meeting_index.html',
        'filephp' => dirname(__FILE__).'/meeting/meeting_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('users'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-add-comment',
    array(
        'url' => '/admin/issue/ajax/add/comment/',
        'filephp' => dirname(__FILE__).'/issue/issue_ajax_add_comment.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'issue-ajax-init-products',
    array(
        'url' => '/admin/issue/ajax/init/products/',
        'filephp' => dirname(__FILE__).'/issue/issue_ajax_init_products.php',
        'level' => '2'
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-contact-autocomplete',
    array(
        'url' => '/admin/contact/autocomplete/',
        'filephp' => dirname(__FILE__).'/contact/contact_autocomplete.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-source-autocomplete',
    array(
        'url' => '/admin/source/autocomplete/',
        'filephp' => dirname(__FILE__).'/source/source_autocomplete.php',
        'level' => '2',
    ),
    'override'
);

// блок списка users
Engine::GetContentDataSource()->registerContent(
    'contact-list',
    array(
        'filehtml' => dirname(__FILE__).'/contact/contact_list.html',
        'filephp' => dirname(__FILE__).'/contact/contact_list.php',
        'filejs' => dirname(__FILE__).'/contact/contact_list.js',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'comment-block',
    array(
        'filehtml' => dirname(__FILE__).'/comment/comment_block.html',
        'filejs' => dirname(__FILE__).'/comment/comment_block.js',
        'filephp' => dirname(__FILE__).'/comment/comment_block.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'comment-template',
    array(
        'title' => 'Comment template',
        'url' => '/admin/comment/template/',
        'filehtml' => dirname(__FILE__).'/comment/comment_template.html',
        'filephp' => dirname(__FILE__).'/comment/comment_template.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('comment_template')
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'comment-template-add',
    array(
        'title' => 'Comment template',
        'url' => '/admin/comment/template/add/',
        'filehtml' => dirname(__FILE__).'/comment/comment_template_add.html',
        'filephp' => dirname(__FILE__).'/comment/comment_template_add.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('comment_template')
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'comment-template-control',
    array(
        'title' => 'Comment template',
        'url' => '/admin/comment/template/{id}/',
        'filehtml' => dirname(__FILE__).'/comment/comment_template_control.html',
        'filephp' => dirname(__FILE__).'/comment/comment_template_control.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('comment_template')
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'notify-block',
    array(
        'filehtml' => dirname(__FILE__).'/notify/notify_block.html',
        'filephp' => dirname(__FILE__).'/notify/notify_block.php',
        'level' => '2',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'structure',
    array(
        'title' => 'Structure',
        'url' => '/admin/structure/',
        'filehtml' => dirname(__FILE__).'/structure/structure_index.html',
        'filejs' => dirname(__FILE__).'/structure/structure_index.js',
        'filephp' => dirname(__FILE__).'/structure/structure_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('structure')
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'structure-block',
    array(
        'filehtml' => dirname(__FILE__).'/structure/structure_block.html',
        'filephp' => dirname(__FILE__).'/structure/structure_block.php',
    ),
    'override'
);

// тестовый контент, на котором можно понять базовую скорость админки
Engine::GetContentDataSource()->registerContent(
    'admin-test', array(
        'url' => '/admin/test/',
        'filehtml' => dirname(__FILE__).'/test_index.html',
        'filephp' => dirname(__FILE__).'/test_index.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-order-closed',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_order_closed.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_order_closed.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-order-closed',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_order_closed.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_order_closed.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-order-saled',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_order_saled.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_order_saled.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-order-shipped',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_order_shipped.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_order_shipped.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-awaiting-verification',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_awaiting_verification.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_awaiting_verification.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-term',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_term.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_term.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-status-change',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_status_change.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_status_change.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notice-client-sms',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notice_client_sms.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notice_client_sms.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notice-manager-sms',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notice_manager_sms.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notice_manager_sms.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notice-client-email',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notice_client_email.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notice_client_email.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notice-manager-email',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notice_manager_email.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notice_manager_email.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notification-email-clients-all',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notification_email_clients_all.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notification_email_clients_all.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-notification-sms-clients-all',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_notification_sms_clients_all.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_notification_sms_clients_all.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-upload-xml',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_upload_xml.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_upload_xml.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-upload-csv',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_upload_csv.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_upload_csv.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-content-need',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_content_need.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_content_need.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-payment-need',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_payment_need.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_payment_need.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-prepayment-need',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_prepayment_need.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_prepayment_need.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-status-action-block-check-sub-issue',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_check_sub_issue.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_check_sub_issue.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order-action-block-ajax',
    array(
        'url' => '/admin/workflow/actionblock/ajax/',
        'filephp' => dirname(__FILE__).'/block-action/action_block_ajax.php',
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-issue-status-action-day-move',
    array(
        'filehtml' => dirname(__FILE__).'/block-action/action_block_issue_day_move.html',
        'filephp' => dirname(__FILE__).'/block-action/action_block_issue_day_move.php',
    ),
    'override'
);