<?php
// вычисляем путь к шаблону
$templateName = Engine::Get()->getConfigFieldSecure('shop-template');
$templatePath = PackageLoader::Get()->getProjectPath().'/templates/'.$templateName.'/';

$pathContent = dirname(__FILE__);

// переопределение engine include блока
Engine::GetContentDataSource()->registerContent(
    'engine-include',
    array(
        'filehtml' => $pathContent.'/engine_include.html',
        'filephp' => $pathContent.'/engine_include.php',
    ),
    'override'
);

// инсталлятор
Engine::GetContentDataSource()->registerContent(
    'install-tpl', array(
        'filehtml' => $pathContent.'/install/install_tpl.html',
        'filephp' => $pathContent.'/install/install_tpl.php',
        'filecss' => $pathContent.'/install/install_tpl.css',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'install', array(
        'title' => 'Install OneBox',
        'url' => '/install/',
        'filehtml' => $pathContent.'/install/install.html',
        'filephp' => $pathContent.'/install/install.php',
        'filejs' => $pathContent.'/install/install.js',
        'moveto' => 'install-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '401', array(
        'title' => 'Error 401',
        'filehtml' => $templatePath.'error/error401.html',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '403', array(
        'title' => 'Error 403',
        'url' => '/login/',
        'filehtml' => $templatePath.'error/error403.html',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '500', array(
        'title' => '500 Internal Server Error',
        'filehtml' => $templatePath.'error/error500.html',
        'filephp' => $pathContent.'/errors/error500.php',
    ), 'override'
);

// авторизация и регистрация
Engine::GetContentDataSource()->registerContent(
    'logout', array(
        'url' => '/logout/',
        'filehtml' => $templatePath.'/auth/auth_logout.html',
        'filephp' => $pathContent.'/auth/auth_logout.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'registration', array(
        'url' => '/registration/',
        'filehtml' => $templatePath.'/auth/auth_registration.html',
        'filephp' => $pathContent.'/auth/auth_registration.php',
        'filejs' => $templatePath.'/auth/auth_ajs.js',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'remindpassword', array(
        'url' => '/remindpassword/',
        'filehtml' => $templatePath.'/auth/auth_remindpassword.html',
        'filephp' => $pathContent.'/auth/auth_remindpassword.php',
        'filejs' => $templatePath.'/auth/auth_ajs.js',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-account-activate', array(
        'url' => '/activate/{email}/{code}/',
        'filehtml' => $templatePath.'/auth/account_activate.html',
        'filephp' => $pathContent.'/auth/account_activate.php',
        'filejs' => $templatePath.'/auth/account_activate.js',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'automatic-authorization-redirect', array(
        'url' => '/automatic_authorization/{identifier}/{redirect}/',
        'filephp' => $pathContent.'/auth/automatic_authorization_redirect.php',
    ), 'override'
);

// шаблоны
Engine::GetContentDataSource()->registerContent(
    'index', array(
        'url' => '/index.html',
        'filehtml' => $templatePath.'/shop_index.html',
        'filephp' => $pathContent.'/shop/shop_index.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-tpl', array(
        'filehtml' => $templatePath.'/shop_tpl.html',
        'filephp' => $pathContent.'/shop/shop_tpl.php',
        'filecss' => array($templatePath.'/shop_tpl.css', $templatePath.'/shop_tpl.ie.css'),
        'filejs' => $templatePath.'/shop_tpl.js',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-tpl-column', array(
        'filehtml' => $templatePath.'/shop_tpl_column.html',
        'filephp' => $pathContent.'/shop/shop_tpl_column.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

// основные контенты (морда)
Engine::GetContentDataSource()->registerContent(
    'shop-basket', array(
        'url' => '/basket/',
        'filehtml' => $templatePath.'/shop_basket.html',
        'filephp' => $pathContent.'/shop/shop_basket.php',
        'filejs' => $templatePath.'/shop_basket.js',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-basket-makeorder', array(
        'url' => '/basket/makeorder/',
        'filehtml' => $templatePath.'/shop_basket_makeorder.html',
        'filephp' => $pathContent.'/shop/shop_basket_makeorder.php',
        'filejs' => $templatePath.'/shop_basket_makeorder.js',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-basket-success', array(
        'url' => '/basket/success/',
        'filehtml' => $templatePath.'/shop_basket_success.html',
        'filephp' => $pathContent.'/shop/shop_basket_success.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-basket-ajax', array(
        'url' => '/ajax/basket/',
        'filephp' => $pathContent.'/shop/shop_basket_ajax.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-content-delivery-ajax', array(
        'url' => '/ajax/content/delivery/',
        'filephp' => $pathContent.'/shop/ajax/shop_content_delivery_ajax.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-payment-interkassa', array(
        'url' => array('/payment/interkassa/', '/payment/interkassa/{result}/'),
        'filehtml' => $templatePath.'/shop_payment_interkassa.html',
        'filephp' => $pathContent.'/shop/shop_payment_interkassa.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-payment-liqpay', array(
        'url' => array('/payment/liqpay/', '/payment/liqpay/{result}/'),
        'filehtml' => $templatePath.'/shop_payment_liqpay.html',
        'filephp' => $pathContent.'/shop/shop_payment_liqpay.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-payment-liqpay-success', array(
    'url' => array('/liqpay/payment/success/'),
    'filehtml' => $templatePath.'/shop_payment_liqpay.html',
    'moveto' => 'shop-tpl',
    'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-compare', array(
        'url' => '/compare/',
        'filehtml' => $templatePath.'/shop_compare.html',
        'filephp' => $pathContent.'/shop/shop_compare.php',
        'filejs' => $templatePath.'/shop_compare.js',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-compare-ajax', array(
        'url' => '/ajax/compare/',
        'filephp' => $pathContent.'/shop/shop_compare_ajax.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-search-company-autocomplete', array(
        'url' => '/search/companyautocomplete/',
        'filephp' => $pathContent.'/shop/shop_search_company_autocomplete.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-search-autocomplete-json', array(
        'url' => '/search/jsonautocomplete/',
        'filephp' => $pathContent.'/shop/shop_search_json_autocomplete.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-search-autocomplete', array(
        'url' => array('/search/autocomplete/{type}/', '/search/autocomplete/'),
        'filehtml' => $templatePath.'/shop_search_autocomplete.html',
        'filephp' => $pathContent.'/shop/shop_search_autocomplete.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-search', array(
        'url' => array('/search/', '/search/{categoryid}/{queryfixed}/', '/search/{queryfixed}/'),
        'filehtml' => $templatePath.'/shop_search.html',
        'filephp' => $pathContent.'/shop/shop_search.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-faq', array(
        'filehtml' => $templatePath.'/shop_faq.html',
        'filephp' => $pathContent.'/shop/shop_faq.php',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-faq-read-answer', array(
        'url' => '/faq/{id}/',
        'filehtml' => $templatePath.'/shop_faq_read_answer.html',
        'filephp' => $pathContent.'/shop/shop_faq_read_answer.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-delivery', array(
        'filehtml' => $templatePath.'/shop_delivery.html',
        'filephp' => $pathContent.'/shop/shop_delivery.php',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-payment', array(
        'filehtml' => $templatePath.'/shop_payment.html',
        'filephp' => $pathContent.'/shop/shop_payment.php',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-news', array(
        'url' => '/news/',
        'filehtml' => $templatePath.'/shop_news.html',
        'filephp' => $pathContent.'/shop/shop_news.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-news-rss', array(
        'url' => '/news/rss/',
        'filehtml' => $templatePath.'/shop_news_rss.html',
        'filephp' => $pathContent.'/shop/shop_news_rss.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-news-view', array(
        'url' => '/news/{id}/',
        'filehtml' => $templatePath.'/shop_news_view.html',
        'filephp' => $pathContent.'/shop/shop_news_view.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-news-view-key', array(
        'url' => '/news/{id}/',
        'filehtml' => $templatePath.'/shop_news_view_key.html',
        'filephp' => $pathContent.'/shop/shop_news_view_key.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-gallery', array(
        'url' => '/gallery/',
        'filehtml' => $templatePath.'/shop_gallery.html',
        'filephp' => $pathContent.'/shop/shop_gallery.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-gallery-view', array(
        'url' => '/gallery/{id}/',
        'filehtml' => $templatePath.'/shop_gallery_view.html',
        'filephp' => $pathContent.'/shop/shop_gallery_view.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-category', array(
        'url' => '/category/{id}/',
        'filehtml' => $templatePath.'/shop_category.html',
        'filephp' => $pathContent.'/shop/shop_category.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-set', array(
        'url' => '/product/set/{id}/',
        'filehtml' => $templatePath.'/shop_product_set.html',
        'filephp' => $pathContent.'/shop/shop_product_set.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-tag', array(
        'url' => '/tag/{id}/',
        'filehtml' => $templatePath.'/shop_tag.html',
        'filephp' => $pathContent.'/shop/shop_tag.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-brand', array(
        'url' => '/brand/{id}/',
        'filehtml' => $templatePath.'/shop_brand.html',
        'filephp' => $pathContent.'/shop/shop_brand.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-click', array(
        'url' => '/click/{id}/',
        'filephp' => $pathContent.'/shop/shop_click.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-page', array(
        'url' => '/page/{id}/',
        'filehtml' => $templatePath.'/shop_page.html',
        'filephp' => $pathContent.'/shop/shop_page.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '404', array(
        'title' => 'Error 404',
        'filehtml' => $templatePath.'error/error404.html',
        'filephp' => $pathContent.'/errors/error404.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '404-product', array(
        'title' => 'Product Error 404',
        'filehtml' => $templatePath.'error/error404_product.html',
        'filephp' => $pathContent.'/errors/error404_product.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth'))
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '404-category', array(
        'title' => 'Category Error 404',
        'filehtml' => $templatePath.'error/error404_category.html',
        'filephp' => $pathContent.'/errors/error404_category.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth'))
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    '404-brand', array(
        'title' => 'Brand Error 404',
        'filehtml' => $templatePath.'error/error404_brand.html',
        'filephp' => $pathContent.'/errors/error404_brand.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth'))
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-page-html', array(
        'filehtml' => $templatePath.'/shop_page_html.html',
        'filephp' => $pathContent.'/shop/shop_page_html.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-page-yandex-map', array(
        'filehtml' => $templatePath.'/shop_page_yandex_map.html',
        'filephp' => $pathContent.'/shop/shop_page_yandex_map.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product', array(
        'url' => '/product/{id}/',
        'filehtml' => $templatePath.'/shop_product.html',
        'filejs' => $templatePath.'/shop_product.js',
        'filephp' => $pathContent.'/shop/shop_product.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-block-comment-product', array(
        'filephp' => $pathContent.'/shop/block/block_comment_product.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list', array(
        'filehtml' => $templatePath.'/shop_product_list.html',
        'filephp' => $pathContent.'/shop/shop_product_list.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-thumbs', array(
        'filehtml' => $templatePath.'/shop_product_list_thumbs.html',
        'filephp' => $pathContent.'/shop/shop_product_list_thumbs.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-thumbsgrouped', array(
        'filehtml' => $templatePath.'/shop_product_list_thumbsgrouped.html',
        'filephp' => $pathContent.'/shop/shop_product_list_thumbsgrouped.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-table', array(
        'filehtml' => $templatePath.'/shop_product_list_table.html',
        'filephp' => $pathContent.'/shop/shop_product_list_table.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-tablegrouped', array(
        'filehtml' => $templatePath.'/shop_product_list_tablegrouped.html',
        'filephp' => $pathContent.'/shop/shop_product_list_tablegrouped.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-subcategory', array(
        'filehtml' => $templatePath.'/shop_product_list_subcategory.html',
        'filephp' => $pathContent.'/shop/shop_product_list_subcategory.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-subcategoryproduct', array(
        'filehtml' => $templatePath.'/shop_product_list_subcategoryproduct.html',
        'filephp' => $pathContent.'/shop/shop_product_list_subcategoryproduct.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-ajax', array(
        'url' => '/shop-product-list/ajax/',
        'filephp' => $pathContent.'/shop/shop_product_list_ajax.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-list-key', array(
        'filehtml' => $templatePath.'/shop_product_list_key.html',
        'filephp' => $pathContent.'/shop/shop_product_list_key.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-products-found-cheaper', array(
        'filehtml' => $templatePath.'/shop_products_found_cheaper.html',
        'filephp' => $pathContent.'/shop/shop_products_found_cheaper.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-products-quick-order', array(
        'filehtml' => $templatePath.'/shop_products_quick_order.html',
        'filephp' => $pathContent.'/shop/shop_products_quick_order.php',
        'filejs' => $templatePath.'/shop_products_quick_order.js',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-products-notice-of-availability', array(
        'filehtml' => $templatePath.'/shop_products_notice_of_availability.html',
        'filephp' => $pathContent.'/shop/shop_products_notice_of_availability.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-products-notice-of-availability-ajax', array(
        'url' => '/noticeofavailabilityajax/',
        'filephp' => $pathContent.'/shop/shop_products_notice_of_availability_ajax.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-order', array(
        'url' => '/order/{hash}/',
        'filehtml' => $templatePath.'/shop_order.html',
        'filephp' => $pathContent.'/shop/shop_order.php',
        'moveto' => 'shop-tpl-column',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'unsubscribe', array(
        'url' => '/unsubscribe/',
        'filehtml' => $templatePath.'/user_unsubscribe.html',
        'filephp' => $pathContent.'/shop/user_unsubscribe.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-carousel', array(
        'filehtml' => $templatePath.'/shop_product_carousel.html',
        'filephp' => $pathContent.'/shop/shop_product_carousel.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-guestbook', array(
        'url' => '/guestbook/',
        'filehtml' => $templatePath.'/shop_guestbook.html',
        'filephp' => $pathContent.'/shop/shop_guestbook.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'robots-txt', array(
        'url' => '/robots.txt',
        'filephp' => $pathContent.'/robots_txt.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-product-download', array(
        'url' => '/product/download/{hash}/',
        'filephp' => $pathContent.'/shop/shop_product_download.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'brand-all', array(
        'url' => '/brands/',
        'filehtml' => $templatePath.'/shop_brands.html',
        'filephp' => $pathContent.'/shop/shop_brands.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
        'cache' => array('ttl' => 3600, 'type' => 'page', 'modifiers' => array('url', 'no-auth')),
    ), 'override'
);

// клиентская часть
Engine::GetContentDataSource()->registerContent(
    'shop-client-tpl', array(
        'filehtml' => $templatePath.'client/admin_client_tpl.html',
        'filephp' => $pathContent.'/shop/client/admin_client_tpl.php',
        'moveto' => 'shop-tpl',
        'moveas' => 'content',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-client-profile', array(
        'title' => 'Profile',
        'url' => '/client/profile/',
        'filehtml' => $templatePath.'client/client_shop_profile.html',
        'filephp' => $pathContent.'/shop/client/client_shop_profile.php',
        'moveto' => 'shop-client-tpl',
        'moveas' => 'content',
        'level' => '1',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-client-products-viewed', array(
        'title' => 'Viewed products',
        'url' => '/client/products/viewed/',
        'filehtml' => $templatePath.'client/client_shop_products_viewed.html',
        'filephp' => $pathContent.'/shop/client/client_shop_products_viewed.php',
        'moveto' => 'shop-client-tpl',
        'moveas' => 'content',
        'level' => '1',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-client-products-ordered', array(
        'title' => 'Ordered products',
        'url' => '/client/products/ordered/',
        'filehtml' => $templatePath.'client/client_shop_products_ordered.html',
        'filephp' => $pathContent.'/shop/client/client_shop_products_ordered.php',
        'moveto' => 'shop-client-tpl',
        'moveas' => 'content',
        'level' => '1',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-client-orders', array(
        'title' => 'My orders',
        'url' => '/client/orders/',
        'filehtml' => $templatePath.'client/client_shop_orders.html',
        'filephp' => $pathContent.'/shop/client/client_shop_orders.php',
        'moveto' => 'shop-client-tpl',
        'moveas' => 'content',
        'level' => '1',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-admin-change-password', array(
        'title' => 'Change Password',
        'url' => '/client/change/password/',
        'filehtml' => $templatePath.'client/shop_admin_change_password.html',
        'filephp' => $pathContent.'/shop/client/shop_admin_change_password.php',
        'moveto' => 'shop-admin-tpl',
        'moveas' => 'content',
        'level' => '2',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'shop-client-orders-view', array(
        'title' => 'My order',
        'url' => '/client/orders/{id}/',
        'filehtml' => $templatePath.'client/client_shop_orders_view.html',
        'filephp' => $pathContent.'/shop/client/client_shop_orders_view.php',
        'moveto' => 'shop-client-tpl',
        'moveas' => 'content',
        'level' => '1',
    ), 'override'
);

// блоки
Engine::GetContentDataSource()->registerContent(
    'block-mymanager', array(
        'filehtml' => $templatePath.'/block/block_mymanager.html',
        'filephp' => $pathContent.'/shop/block/block_mymanager.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'host', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-productfilter', array(
        'filehtml' => $templatePath.'/block/block_productfilter.html',
        'filephp' => $pathContent.'/shop/block/block_productfilter.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-compare', array(
        'filehtml' => $templatePath.'/block/block_compare.html',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-news', array(
        'filehtml' => $templatePath.'/block/block_news.html',
        'filephp' => $pathContent.'/shop/block/block_news.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-currency', array(
        'filehtml' => $templatePath.'/block/block_currency.html',
        'filephp' => $pathContent.'/shop/block/block_currency.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-subscribe', array(
        'filehtml' => $templatePath.'/block/block_subscribe.html',
        'filephp' => $pathContent.'/shop/block/block_subscribe.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-guestbook', array(
        'filehtml' => $templatePath.'/block/block_guestbook.html',
        'filephp' => $pathContent.'/shop/block/block_guestbook.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-faq', array(
        'filehtml' => $templatePath.'/block/block_faq.html',
        'filephp' => $pathContent.'/shop/block/block_faq.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-facebook', array(
        'filehtml' => $templatePath.'/block/block_facebook.html',
        'filephp' => $pathContent.'/shop/block/block_facebook.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-left', array(
        'filehtml' => $templatePath.'/block/block_banner_left.html',
        'filephp' => $pathContent.'/shop/block/block_banner_left.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-right', array(
        'filehtml' => $templatePath.'/block/block_banner_right.html',
        'filephp' => $pathContent.'/shop/block/block_banner_right.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-bottom', array(
        'filehtml' => $templatePath.'/block/block_banner_bottom.html',
        'filephp' => $pathContent.'/shop/block/block_banner_bottom.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-pageinterval', array(
        'url' => '/block/ajax/banner/pageinterval/',
        'filehtml' => $templatePath.'/block/block_banner_pageinterval.html',
        'filephp' => $pathContent.'/shop/block/block_banner_pageinterval.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-top', array(
        'filehtml' => $templatePath.'/block/block_banner_top.html',
        'filephp' => $pathContent.'/shop/block/block_banner_top.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-top-index', array(
        'filehtml' => $templatePath.'/block/block_banner_top_index.html',
        'filephp' => $pathContent.'/shop/block/block_banner_top_index.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-banner-wide', array(
    'filehtml' => $templatePath.'/block/block_banner_wide.html',
    'filephp' => $pathContent.'/shop/block/block_banner_wide.php',
    'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-timework', array(
        'filehtml' => $templatePath.'/block/block_timework.html',
        'filephp' => $pathContent.'/shop/block/block_timework.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-basket', array(
        'filehtml' => $templatePath.'/block/block_basket.html',
        'filephp' => $pathContent.'/shop/block/block_basket.php',
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-search', array(
        'filehtml' => $templatePath.'/block/block_search.html',
        'filephp' => $pathContent.'/shop/block/block_search.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-menu-category', array(
        'filehtml' => $templatePath.'/block/block_menu_category.html',
        'filephp' => $pathContent.'/shop/block/block_menu_category.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-menu-brand', array(
        'filehtml' => $templatePath.'/block/block_menu_brand.html',
        'filephp' => $pathContent.'/shop/block/block_menu_brand.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-menu-textpage', array(
        'filehtml' => $templatePath.'/block/block_menu_textpage.html',
        'filephp' => $pathContent.'/shop/block/block_menu_textpage.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-brand-top', array(
        'filehtml' => $templatePath.'/block/block_brand_top.html',
        'filephp' => $pathContent.'/shop/block/block_brand_top.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-brand-alphabet', array(
        'filehtml' => $templatePath.'/block/block_brand_alphabet.html',
        'filephp' => $pathContent.'/shop/block/block_brand_alphabet.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-category-top', array(
        'filehtml' => $templatePath.'/block/block_category_top.html',
        'filephp' => $pathContent.'/shop/block/block_category_top.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-feedback', array(
        'filehtml' => $templatePath.'/block/block_feedback.html',
        'filephp' => $pathContent.'/shop/block/block_feedback.php',
        'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'host', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-callback', array(
    'filehtml' => $templatePath.'/block/block_callback.html',
    'filephp' => $pathContent.'/shop/block/block_callback.php',
    'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'host', 'no-auth')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-footer-category', array(
    'filehtml' => $templatePath.'/block/block_footer_category.html',
    'filephp' => $pathContent.'/shop/block/block_footer_category.php',
    'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-footer-textpage', array(
    'filehtml' => $templatePath.'/block/block_footer_textpage.html',
    'filephp' => $pathContent.'/shop/block/block_footer_textpage.php',
    'cache' => array('ttl' => 3600, 'type' => 'content', 'modifiers' => array('language', 'url', 'template')),
    ), 'override'
);

Engine::GetContentDataSource()->registerContent(
    'block-delivery-default', array(
        'filehtml' => $templatePath.'/block/block_delivery_default.html',
        'filephp' => $pathContent.'/shop/block/block_delivery_default.php',
    ), 'override'
);