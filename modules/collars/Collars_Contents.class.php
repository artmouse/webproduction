<?php

class Collars_Contents implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        Engine::GetContentDataSource()->registerContent(
            'shop-tpl',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_tpl.html',
                'filephp' => dirname(__FILE__).'/contents/shop_tpl.php',
                'filecssremove' => true,
                'filecss' => array(
                    dirname(__FILE__).'/contents/shop_tpl.css',
                    dirname(__FILE__).'/contents/shop_tpl_basic.css',
                    dirname(__FILE__).'/contents/shop_tpl_ie.css'
                ),
                'filejs' => array(
                    dirname(__FILE__).'/_js/select2.js',
                    dirname(__FILE__).'/_js/main.js',
                ),
            ),
            'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-tpl-column', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_tpl_column.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'index',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_index.html',
                'moveto' => 'shop-tpl-column',
                'moveas' => 'content',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-category',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_category.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-list',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product_list.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-basket',
            array(
                'url' => '/basket/',
                'filehtml' => dirname(__FILE__).'/contents/shop_basket.html',
                'filephp' => dirname(__FILE__).'/contents/shop_basket.php',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-list-thumbs',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product_list_thumbs.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-carousel',
            array(
                'filephp' => dirname(__FILE__).'/contents/shop_product_carousel.php',
                'filehtml' => dirname(__FILE__).'/contents/shop_product_carousel.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-list-subcategory',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product_list_subcategory.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-list-table',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product_list_table.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product.html',
                'filephp' => dirname(__FILE__).'/contents/shop_product.php',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-products-quick-order',
            array(
            'filehtml' => dirname(__FILE__).'/contents/shop_products_quick_order.html',
            'filephp' => dirname(__FILE__).'/contents/shop_products_quick_order.php'
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-basket-makeorder',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_basket_makeorder.html',
                'filephp' => dirname(__FILE__).'/contents/shop_basket_makeorder.php',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-basket-success',
            array(
                'url' => '/basket/success/',
                'filehtml' => dirname(__FILE__).'/contents/shop_basket_success.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            '401',
            array(
                'filehtml' => dirname(__FILE__).'/contents/error/error401.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            '403',
            array(
                'filehtml' => dirname(__FILE__).'/contents/error/error403.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-add',
            array(
                'filehtml' => dirname(__FILE__).'/contents/products_add.html',
                'filephp' => dirname(__FILE__).'/contents/products_add.php',
            ),
            'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products-edit',
            array(
                'filehtml' => dirname(__FILE__).'/contents/products_edit.html',
                'filephp' => dirname(__FILE__).'/contents/products_edit.php',
            ),
            'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'sale-page', array(
                'url' => '/sale/',
                'filehtml' => dirname(__FILE__).'/contents/sale_page.html',
                'filephp' => dirname(__FILE__).'/contents/sale_page.php',
                'moveto' => 'shop-tpl-column',
                'moveas' => 'content',
            ), 'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'review-page', array(
            'url' => '/review/{id}/',
            'filehtml' => dirname(__FILE__).'/contents/review.html',
            'filephp' => dirname(__FILE__).'/contents/review.php',
            'moveto' => 'shop-tpl-column',
            'moveas' => 'content',
            ), 'extend'
        );



        Engine::GetContentDataSource()->registerContent(
            'registration',
            array(
                'filehtml' => dirname(__FILE__).'/contents/auth/auth_registration.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'remindpassword',
            array(
                'filehtml' => dirname(__FILE__).'/contents/auth/auth_remindpassword.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-guestbook',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_guestbook.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-page',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_page.html',
            ), 'extend'
        );


        // клиентская часть
        Engine::GetContentDataSource()->registerContent(
            'shop-client-tpl',
            array(
                'filehtml' => dirname(__FILE__).'/contents/client/admin_client_tpl.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-client-profile',
            array(
                'filehtml' => dirname(__FILE__).'/contents/client/client_shop_profile.html',
            ), 'extend'
        );


        // blocks
        Engine::GetContentDataSource()->registerContent(
            'block-search',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_search.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-menu-category',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_menu_category.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-delivery-default',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_delivery_default.html',
                'filephp' => dirname(__FILE__).'/contents/block/block_delivery_default.php',
            ), 'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'block-basket',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_basket.html',
                'filephp' => dirname(__FILE__).'/contents/block/block_basket.php',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-footer-textpage',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_footer_textpage.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-banner-wide',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_banner_wide.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-productfilter',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_productfilter.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-banner-left',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_banner_left.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-banner-right',
            array(
                'filehtml' => dirname(__FILE__).'/contents/block/block_banner_right.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-brands-control',
            array(
                'filehtml' => dirname(__FILE__).'/contents/admin/brands_control.html',
                'filephp' => dirname(__FILE__).'/contents/admin/brands_control.php',
            ), 'extend'
        );

    }

}