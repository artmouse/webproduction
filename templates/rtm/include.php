<?php

include_once(dirname(__FILE__).'/api/include.php');

Engine::GetContentDataSource()->registerContent(
    'shop-admin-orders-utm', array(
    'title' => 'UTM of order',
    'url' => array('/admin/shop/orders/{id}/utm/'),
    'filehtml' => dirname(__FILE__).'/contents/admin/orders/orders_utm.html',
    'filephp' => dirname(__FILE__).'/contents/admin/orders/orders_utm.php',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'report-utm', array(
    'title' => 'Report UTM',
    'url' => '/admin/shop/report/utm/',
    'filehtml' => dirname(__FILE__).'/contents/admin/report/report_utm.html',
    'filephp' => dirname(__FILE__).'/contents/admin/report/report_utm.php',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    'role' => array('report_utm'),
    ), 'override'
);
Engine::GetContentDataSource()->registerContent(
    'report-image', array(
    'title' => 'Report Image',
    'url' => '/admin/shop/report/image/',
    'filehtml' => dirname(__FILE__).'/contents/admin/report/report_image.html',
    'filephp' => dirname(__FILE__).'/contents/admin/report/report_image.php',
    'moveto' => 'shop-admin-tpl',
    'moveas' => 'content',
    'level' => '2',
    ), 'override'
);
Engine::GetContentDataSource()->registerContent(
    'shop-news-view', array(
    'filehtml' => dirname(__FILE__).'/contents/shop_news_view.html',
    'filephp' => dirname(__FILE__).'/contents/shop_news_view.php',
    ), 'extend'
);

Engine::GetContentDataSource()->registerContent(
    'shop-forms-bonus-cart', array(
    'filehtml' => dirname(__FILE__).'/contents/shop_forms_bonus_cart.html',
    'filephp' => dirname(__FILE__).'/contents/shop_forms_bonus_cart.php',
    ), 'extend'
);

Engine::GetContentDataSource()->registerContent(
    'shop-captcha', array(
    'url' => '/captcha/',
    'filephp' => dirname(__FILE__).'/contents/shop_captcha.php',
    ), 'extend'
);

Events::Get()->observe(
    'shopOrderAddAfter',
    new Utm_Order()
);


// переопределяем контенты
$fileContents = file_get_contents(dirname(__FILE__).'/contents.xml');

Engine::GetContentDataSource()->registerContentsFromXML(
    $fileContents,
    dirname(__FILE__).'/contents/'
);