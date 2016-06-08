<?php
Engine::GetContentDataSource()->registerContent('shop-api-product-search', array(
'url' => '/api/product/search',
'filephp' => dirname(__FILE__).'/product_search.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-api-product-add', array(
'url' => '/api/product/add',
'filephp' => dirname(__FILE__).'/product_add.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-api-user-search', array(
'url' => '/api/user/search',
'filephp' => dirname(__FILE__).'/user_search.php',
'level' => '2',
), 'override');

Engine::GetContentDataSource()->registerContent('shop-api-user-add', array(
'url' => '/api/user/add',
'filephp' => dirname(__FILE__).'/user_add.php',
'level' => '2',
), 'override');