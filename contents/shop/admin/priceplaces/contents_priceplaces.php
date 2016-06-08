<?php
Engine::GetContentDataSource()->registerContent('shop-admin-priceplaces', array(
'title' => 'Prices places',
'url' => '/admin/shop/priceplaces/',
'filehtml' => dirname(__FILE__).'/priceplaces_index.html',
'filephp' => dirname(__FILE__).'/priceplaces_index.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('priceplaces'),
), 'override');

Engine::GetContentDataSource()->registerContent('shop-admin-priceplaces-view', array(
'title' => 'Prices places',
'url' => '/admin/shop/priceplaces/{id}/',
'filehtml' => dirname(__FILE__).'/priceplaces_view.html',
'filephp' => dirname(__FILE__).'/priceplaces_view.php',
'moveto' => 'shop-admin-tpl',
'moveas' => 'content',
'level' => '2',
'role' => array('priceplaces'),
), 'override');

