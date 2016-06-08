<?php
/**
 * OneBox
 *
 * @copyright (C) 2011-2016 WebProduction (tm) <webproduction.ua>
 *
 * This program is commercial software;
 * you cannot redistribute it and/or modify it.
 */

/**
 * Подгрузка ACL по требованию
 *
 * @author    Maxim Miroshnichenko <max@webproduction.ua>
 * @copyright WebProduction
 * @package   Shop
 */
class Shop_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        $a = array();
        $a[] = 'discount';
        $a[] = 'brands';
        $a[] = 'category';
        $a[] = 'products';
        $a[] = 'products-owner-edit';
        $a[] = 'products-edit';
        $a[] = 'products-edit-quick';
        $a[] = 'products-noticeavailability';
        $a[] = 'products-copy';
        $a[] = 'products-lists';
        $a[] = 'products-delete';
        $a[] = 'products-add';
        $a[] = 'products-related';
        $a[] = 'products-views';
        $a[] = 'products-comments';
        $a[] = 'products-orders';
        $a[] = 'products-history';
        $a[] = 'products-filters';
        $a[] = 'products-suppliers';
        $a[] = 'products-import';
        $a[] = 'products-keywords-import';
        $a[] = 'products-icon';
        $a[] = 'settings';
        $a[] = 'comments';
        $a[] = 'pages';
        $a[] = 'priceplaces';
        $a[] = 'prices';
        $a[] = 'activity';
        $a[] = 'statistic';
        $a[] = 'news';
        $a[] = 'products-list';
        $a[] = 'callback';
        $a[] = 'feedback';
        $a[] = 'timework';
        $a[] = 'logo';
        $a[] = 'contractors';
        $a[] = 'faq';
        $a[] = 'delivery';
        $a[] = 'banner';
        $a[] = 'payment';
        $a[] = 'supplier';
        $a[] = 'guestbook';
        $a[] = 'ticket-support';
        $a[] = 'block';
        $a[] = 'redirect';
        $a[] = 'gallery';
        $a[] = 'report_callcenter';
        $a[] = 'report_notify';
        $a[] = 'report_summary';
        $a[] = 'role';
        $a[] = 'comment_template';
        $a[] = 'structure';

        foreach ($a as $key) {
            // переводим ключ
            // если ключ не переведется - то будет такой-же $key
            $name = Shop::Get()->getTranslateService()->getTranslateSecure('acl-' . $key);

            // добавляем в ACL
            Shop::Get()->getAclService()->addACLPermission($key, $name);
        }

        Shop::Get()->getAclService()->addACLPermission(
            'table-export',
            'Экспорт таблиц'
        );
    }

}