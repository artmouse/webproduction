<?php

class Kazakhfilm_Content implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;
        Engine::GetContentDataSource()->registerContent(
            'shop-tpl',
            array(
                'filehtml' => dirname(__FILE__).'/contents/shop_tpl.html',
                'filephp' => dirname(__FILE__).'/contents/shop_tpl.php',
                'filejs' => dirname(__FILE__).'/contents/shop_tpl.js',
                'filecssremove' => true,
                'filejsremove' => true,
                'filecss' => array(
                    dirname(__FILE__).'/contents/shop_tpl.css',
                    dirname(__FILE__).'/contents/shop_tpl_adaptive_960.css',
                    dirname(__FILE__).'/contents/shop_tpl_adaptive_640.css',
                    dirname(__FILE__).'/contents/shop_tpl_adaptive_480.css'
                ),
            ),
            'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'block-menu-textpage', array(
            'filehtml' => dirname(__FILE__).'/contents/block/block_menu_textpage.html',
            'filephp' => dirname(__FILE__).'/contents/block/block_menu_textpage.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-kazakh-order', array(
            'filehtml' => dirname(__FILE__).'/contents/block/block_kazakh_order.html',
            'filephp' => dirname(__FILE__).'/contents/block/block_kazakh_order.php',
            'filejs' => dirname(__FILE__).'/contents/block/block_kazakh_order.js',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-callback', array(
            'filehtml' => dirname(__FILE__).'/contents/block/block_callback.html',
            'filephp' => dirname(__FILE__).'/contents/block/block_callback.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-feedback', array(
            'filehtml' => dirname(__FILE__).'/contents/block/block_feedback.html',
            'filephp' => dirname(__FILE__).'/contents/block/block_feedback.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'block-banner-top', array(
            'filehtml' => dirname(__FILE__).'/contents/block/block_banner_top.html',
            'filephp' => dirname(__FILE__).'/contents/block/block_banner_top.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'index', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_index.html',
            'filephp' => dirname(__FILE__).'/contents/shop_index.php',
            'moveto' => 'shop-tpl',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-page', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_page.html',
            'moveto' => 'shop-tpl',
        ), 'extend'
        );


        Engine::GetContentDataSource()->registerContent(
            'shop-page', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_page.html',
            'moveto' => 'shop-tpl',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'kzh-contacts', array(
            'url' => '/contacts/',
            'filehtml' => dirname(__FILE__).'/contents/kzh_contacts.html',
            'filephp' => dirname(__FILE__).'/contents/kzh_contacts.php',
            'moveto' => 'shop-tpl',
            'moveas' => 'content',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'kzh-transfer', array(
            'url' => '/transfer/',
            'filehtml' => dirname(__FILE__).'/contents/kzh_transfer.html',
            'filephp' => dirname(__FILE__).'/contents/kzh_transfer.php',
            'moveto' => 'shop-tpl',
            'moveas' => 'content',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'booking', array(
            'url' => '/booking/',
            'title' =>'Номера и цены',
            'filehtml' => dirname(__FILE__).'/contents/booking.html',
            'filephp' => dirname(__FILE__).'/contents/booking.php',
            'filejs' => dirname(__FILE__).'/contents/booking.js',
            'moveto' => 'shop-tpl',
            'moveas' => 'content',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-guestbook', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_guestbook.html',
            'filephp' => dirname(__FILE__).'/contents/shop_guestbook.php',
            'moveto' => 'shop-tpl',
            'moveas' => 'content',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'how-get', array(
            'title' => "Как добраться",
            'filehtml' => dirname(__FILE__).'/contents/how_get.html',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-products', array(
            'filehphp' => dirname(__FILE__).'/contents/admin/products_index.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-orders', array(
            'filehphp' => dirname(__FILE__).'/contents/admin/orders_index.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-guestbook', array(
            'filehphp' => dirname(__FILE__).'/contents/admin/guestbook_index.php',
        ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-currency', array(
            'filehtml' => dirname(__FILE__).'/contents/admin/currency_index.html',
            'filehphp' => dirname(__FILE__).'/contents/admin/currency_index.php',
        ), 'extend'
        );


    }

}

