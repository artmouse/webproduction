<?php

$pageArray = array();

/*
 * PRODUCT
 */
$pageArray[] = array(
    'key' => 'product',
    'filename' => 'product.html',
    'title' => 'Продукты',
    'parent' => '',
    'sort' => 81
);

$pageArray[] = array(
    'key' => 'product_show_all',
    'filename' => 'product_show_all.html',
    'title' => 'Просмотр всех продуктов',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_filtration_panel',
    'filename' => 'product_filtration_panel.html',
    'title' => 'Панель фильтрации',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_fast_edit_panel',
    'filename' => 'product_fast_edit_panel.html',
    'title' => 'Панель быстрого редактирования продуктов',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_add',
    'filename' => 'product_add.html',
    'title' => 'Добавление продукта',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_copy',
    'filename' => 'product_copy.html',
    'title' => 'Создание копии продукта',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_edit',
    'filename' => 'product_edit.html',
    'title' => 'Редактирование продукта',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_supplier_manage',
    'filename' => 'product_supplier_manage.html',
    'title' => 'Управление поставщиками',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_history',
    'filename' => 'product_history.html',
    'title' => 'История просмотров и редактирования продукта',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_single_comment',
    'filename' => 'product_single_comment.html',
    'title' => 'Комментарии',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_shipment_price_platform',
    'filename' => 'product_shipment_price_platform.html',
    'title' => 'Выгрузка товара на прайс-площадки',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_related',
    'filename' => 'product_related.html',
    'title' => 'Связанные продукты',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_special_lists',
    'filename' => 'product_special_lists.html',
    'title' => 'Списки',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_promotional_complects',
    'filename' => 'product_promotional_complects.html',
    'title' => 'Акционные наборы',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_order_info',
    'filename' => 'product_order_info.html',
    'title' => 'Информация о заказах с продуктом',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_storage_info',
    'filename' => 'product_storage_info.html',
    'title' => 'Информация о наличии продукта на складах',
    'parent' => 'product_edit',
);

$pageArray[] = array(
    'key' => 'product_import_export_excel',
    'filename' => 'product_import_export_excel.html',
    'title' => 'Импорт и экспорт Excel',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_filter',
    'filename' => 'product_filter.html',
    'title' => 'Фильтры товаров',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_filter_create_and_edit',
    'filename' => 'product_filter_create_and_edit.html',
    'title' => 'Просмотр фильтров для товаров и их создание',
    'parent' => 'product_filter',
);

$pageArray[] = array(
    'key' => 'product_special_lists_create',
    'filename' => 'product_special_lists_create.html',
    'title' => 'Списки продуктов',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'product_all_comments',
    'filename' => 'product_all_comments.html',
    'title' => 'Комментарии',
    'parent' => 'product',
);

/*
 * CATEGORY PRODUCT
 */
$pageArray[] = array(
    'key' => 'category_product',
    'filename' => 'category_product.html',
    'title' => 'Категории продуктов',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'category_manager',
    'filename' => 'category_manager.html',
    'title' => 'Менеджер категорий',
    'parent' => 'category_product',
);

$pageArray[] = array(
    'key' => 'category_tree',
    'filename' => 'category_tree.html',
    'title' => 'Дерево категорий',
    'parent' => 'category_manager',
);

$pageArray[] = array(
    'key' => 'category_fast_edit_and_manage',
    'filename' => 'category_fast_edit_and_manage.html',
    'title' => 'Быстрое редактирование и управление категориями',
    'parent' => 'category_manager',
);

$pageArray[] = array(
    'key' => 'category_fast_add',
    'filename' => 'category_fast_add.html',
    'title' => 'Быстрое добавление категории',
    'parent' => 'category_manager',
);

$pageArray[] = array(
    'key' => 'category_list',
    'filename' => 'category_list.html',
    'title' => 'Просмотр списка категорий',
    'parent' => 'category_product',
);

$pageArray[] = array(
    'key' => 'category_filtration_panel',
    'filename' => 'category_filtration_panel.html',
    'title' => 'Панель фильтрации',
    'parent' => 'category_list',
);

$pageArray[] = array(
    'key' => 'category_add',
    'filename' => 'category_add.html',
    'title' => 'Добавление категории',
    'parent' => 'category_product',
);

/*
 * BRANDS
 */
$pageArray[] = array(
    'key' => 'brands',
    'filename' => 'brands.html',
    'title' => 'Бренды',
    'parent' => 'product',
);

$pageArray[] = array(
    'key' => 'brands_view',
    'filename' => 'brands_view.html',
    'title' => 'Просморт всех брендов',
    'parent' => 'brands',
);

$pageArray[] = array(
    'key' => 'brands_add',
    'filename' => 'brands_add.html',
    'title' => 'Добавление бренда',
    'parent' => 'brands',
);

$pageArray[] = array(
    'key' => 'brands_fast_manage_panel',
    'filename' => 'brands_fast_manage_panel.html',
    'title' => 'Панель быстрого управления брендами',
    'parent' => 'brands',
);

$pageArray[] = array(
    'key' => 'brands_panel_filter',
    'filename' => 'brands_panel_filter.html',
    'title' => 'Панели фильтрации брендов',
    'parent' => 'brands',
);

/*
 * ONEBOX MENU
 */
$pageArray[] = array(
    'key' => 'menu_onebox',
    'filename' => 'menu_onebox.html',
    'title' => 'OneBox меню',
    'parent' => '',
    'sort' => 11
);

$pageArray[] = array(
    'key' => 'menu_onebox_search',
    'filename' => 'menu_onebox_search.html',
    'title' => 'Поиск',
    'parent' => 'menu_onebox',
);

$pageArray[] = array(
    'key' => 'menu_onebox_notifications',
    'filename' => 'menu_onebox_notifications.html',
    'title' => 'Уведомления',
    'parent' => 'menu_onebox',
);

$pageArray[] = array(
    'key' => 'menu_onebox_quick_search',
    'filename' => 'menu_onebox_quick_search.html',
    'title' => 'Быстрый поиск',
    'parent' => 'menu_onebox',
);

$pageArray[] = array(
    'key' => 'menu_onebox_support',
    'filename' => 'menu_onebox_support.html',
    'title' => 'Написать в техподдержку',
    'parent' => 'menu_onebox',
);

$pageArray[] = array(
    'key' => 'menu_onebox_quick_start_panel',
    'filename' => 'menu_onebox_quick_start_panel.html',
    'title' => 'Панель быстрого старта',
    'parent' => 'menu_onebox',
);

$pageArray[] = array(
    'key' => 'menu_onebox_logout',
    'filename' => 'menu_onebox_logout.html',
    'title' => 'Выход из системы',
    'parent' => 'menu_onebox',
);

/*
 * HOW ONEBOX AND VAT WORKS
 */
$pageArray[] = array(
    'key' => 'onebox_and_vat',
    'filename' => 'onebox_and_vat.html',
    'title' => 'Как работает OneBox и НДС/VAT',
    'parent' => '',
    'sort' => 141
);

/*
 * SETTINGS
 */
$pageArray[] = array(
    'key' => 'settings',
    'filename' => 'settings.html',
    'title' => 'Настройки',
    'parent' => '',
    'sort' => 901
);

$pageArray[] = array(
    'key' => 'set_logo',
    'filename' => 'set_logo.html',
    'title' => 'Логотип',
    'parent' => 'settings',
);

$pageArray[] = array(
    'key' => 'set_pages',
    'filename' => 'set_pages.html',
    'title' => 'Страницы',
    'parent' => 'settings',
);

$pageArray[] = array(
    'key' => 'set_news',
    'filename' => 'set_news.html',
    'title' => 'Новости, статьи, блог',
    'parent' => 'settings',
);

$pageArray[] = array(
    'key' => 'set_banners',
    'filename' => 'set_banners.html',
    'title' => 'Баннера',
    'parent' => 'settings',
);

$pageArray[] = array(
    'key' => 'post',
    'filename' => 'post.html',
    'title' => 'Почта',
    'parent' => '',
    'sort' => 152
);


$pageArray[] = array(
    'key' => 'post_variables',
    'filename' => 'post_variables.html',
    'title' => 'Переменные',
    'parent' => 'post',
    'sort' => 152
);

foreach ($pageArray as $page) {
    Shop_ModuleLoader::Get()->registerHelpItem(
        $page['key'],
        dirname(__FILE__) . '/' . $page['filename'],
        $page['title'],
        $page['parent'],
        @$page['sort']
    );
}