<?php
/**
 * Created by PhpStorm.
 * User: kyryll
 * Date: 24.11.15
 * Time: 12:20
 */


class Collars_DB implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $table = SQLObject_Config::Get()->addClass('XShopProduct', 'shopproduct');
        $table->addField('sale', 'tinyint(1)');
        $table->addField('advertise', 'text');
        $table->addField('delivery_price', 'decimal(15,2)');


        $table = SQLObject_Config::Get()->addClass('XShopBrand', 'shopbrand');
        $table->addField('delete', 'tinyint(1)');

    }


}