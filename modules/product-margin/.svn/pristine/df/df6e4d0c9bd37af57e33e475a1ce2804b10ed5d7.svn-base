<?php

class Margin_ContentLoadObserver implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/content/admin/marginrule/';

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-marginrule',
            array(
                'title' => 'Margin rules',
                'url' => '/admin/shop/marginrule/',
                'filehtml' => $path.'/marginrule_index.html',
                'filephp' => $path.'/marginrule_index.php',
                'filejs' => $path.'/marginrule_index.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('marginrule'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'product-margin',
            array(
                'url' => '/admin/shop/products/{id}/margin/',
                'filehtml' => $path.'/product_margin.html',
                'filephp' => $path.'/product_margin.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('marginrule'),
            ),
            'override'
        );


        Engine::GetContentDataSource()->registerContent(
            'shop-admin-marginrule-add',
            array(
                'url' => '/admin/shop/marginrule/add/',
                'filehtml' => $path.'/marginrule_add.html',
                'filephp' => $path.'/marginrule_add.php',
                'filejs' => $path.'/marginrule_add.js',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('marginrule'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-marginrule-control',
            array(
                'url' => '/admin/shop/marginrule/{id}/control/',
                'filehtml' => $path.'/marginrule_control.html',
                'filephp' => $path.'/marginrule_control.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('marginrule'),
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-admin-marginrule-reculc',
            array(
                'url' => '/admin/shop/marginrule/{id}/reculc/',
                'filehtml' => $path.'/marginrule_reculc.html',
                'filephp' => $path.'/marginrule_reculc.php',
                'moveto' => 'shop-admin-tpl',
                'moveas' => 'content',
                'level' => '2',
                'role' => array('marginrule'),
            ),
            'override'
        );
    }

}