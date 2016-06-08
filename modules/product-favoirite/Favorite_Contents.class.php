<?php

class Favorite_Contents implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $path = dirname(__FILE__).'/contents/';        

        Engine::GetContentDataSource()->registerContent(
            'shop-ajax-favorite-check',
            array(
                'url' => '/ajax/favorite_check/',
                'filephp' => $path.'/ajax_favorite_check.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-ajax-favorite-toggle',
            array(
                'url' => '/ajax/favorite_toggle/',
                'filephp' => $path.'/ajax_favorite_toggle.php',
            ),
            'override'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-client-favorite',
            array(
                'title' => 'Profile',
                'url' => '/client/favorite/',
                'filehtml' => $path.'/client/client_shop_favorite.html',
                'filephp' => $path.'/client/client_shop_favorite.php',
                'moveto' => 'shop-client-tpl',
                'moveas' => 'content',
                'level' => 1,
            ),
            'override'
        );
    }

}