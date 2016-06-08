<?php
Engine::GetContentDataSource()->registerContent(
    'shop-admin-statistics-search', 
    array(
        'title' => 'Search history',
        'url' => '/admin/shop/statistics/search/',
        'filehtml' => dirname(__FILE__).'/statistics_search.html',
        'filephp' => dirname(__FILE__).'/statistics_search.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
        'role' => array('statistic'),
    ),
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-statistics-users-online', 
    array(
        'title' => 'Users online',
        'url' => '/admin/shop/online/',
        'filehtml' => dirname(__FILE__).'/statistics_online.html',
        'filephp' => dirname(__FILE__).'/statistics_online.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '3',
        'role' => array('users-online'),
    ), 
    'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-history-change-product', 
    array(
        'title' => 'History change',
        'url' => '/admin/shop/history-change-product/',
        'filehtml' => dirname(__FILE__).'/change_of_product.html',
        'filephp' => dirname(__FILE__).'/change_of_product.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '3',
        'role' => array('users-online'),
    ),
    'override'
);