<?php
/**
 * Description of ShopLand_ContentLoadObserver
 *
 * @author i.ustimenko
 */
class ShopLand_ContentLoadObserver implements Events_IEventObserver{
    public function notify(Events_Event $event) {
        $event;
        Engine::GetContentDataSource()->registerContent(
            'shop-tpl', array(
                'filehtml' => dirname(__FILE__).'/contents/shop_tpl.html',
                'filecss' => dirname(__FILE__) . '/shop_tpl_extended.css'
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-product-list-thumbsgrouped', array(
                'filehtml' => dirname(__FILE__).'/contents/shop_product_list_thumbsgrouped.html',
            ), 'extend'
        );

        Engine::GetContentDataSource()->registerContent(
            'shop-basket-makeorder', array(
            'filehtml' => dirname(__FILE__).'/contents/shop_basket_makeorder.html',
            ), 'extend'
        );
        
        Engine::GetContentDataSource()->registerContent(
            'block-subscribe', array(
                'filehtml' => dirname(__FILE__).'/contents/block_subscribe.html',
            ), 'extend'
        );
    }
}