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
class Order_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop::Get()->getAclService()->addACLPermission(
            'orders',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'order-delete',
            'Заказы :: Удаление и восстановление заказов'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'orders-all-view',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_all_view')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'orders-all-edit',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_all_edit')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'orders-direction-in',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_direction_in')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'orders-direction-out',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_direction_out')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'orders-add',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_add')
        );
        
        Shop::Get()->getAclService()->addACLPermission(
            'orders-import',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_orders_import')
        );

        Shop::Get()->getAclService()->addACLPermission(
            'report-productmatrix',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_productmatrix')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-topproducts',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_topproducts')
        );

        $a = array();

        // ACL по статусам заказов
        $a[] = array(
            'name' => 'Заказы :: Доступ по статусу ::  Все статусы :: Просмотр',
            'key' => 'orders-status-all-view',
        );

        $a[] = array(
            'name' => 'Заказы :: Доступ по статусу ::  Все статусы :: Управление',
            'key' => 'orders-status-all-change',
        );

        $status = WorkflowService::Get()->getStatusAll();
        $index = 0;
        while ($s = $status->getNext()) {
            try {
                $categoryName = 'Без категории';
                $category = $s->getCategory();
                $categoryName = $category->getName();
                if ($category->getType() == 'issue' || $category->getType() == 'project') {
                    continue;
                }
            } catch (Exception $e) {

            }

            $name = 'Заказы :: Доступ по статусу :: '.$categoryName.' :: #'.$index.' / '.$s->getName().' :: Просмотр';
            $a[] = array(
                'name' => $name,
                'key' => 'orders-status-'.$s->getId().'-view',
            );

            $a[] = array(
                'name' => 'Заказы :: Доступ по статусу :: '.$categoryName.' :: #'.$index.' / '.$s->getName().
                          ' :: Управление',
                'key' => 'orders-status-' . $s->getId() . '-change',
            );

            $index ++;
        }

        // ACL по менеджерам заказов
        $a[] = array(
            'name' => 'Заказы :: Доступ по сотруднику ::  Все сотрудники :: Просмотр',
            'key' => 'orders-manager-all-view',
        );

        $a[] = array(
            'name' => 'Заказы :: Доступ по сотруднику ::  Все сотрудники :: Управление',
            'key' => 'orders-manager-all-change',
        );

        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $a[] = array(
                'name' => 'Заказы :: Доступ по сотруднику :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                'key' => 'orders-manager-'.$s->getId().'-view',
            );

            $a[] = array(
                'name' => 'Заказы :: Доступ по сотруднику :: '.$s->makeName(false, 'lmf').' :: Управление',
                'key' => 'orders-manager-' . $s->getId() . '-change',
            );
        }

        // ACL по категориям заказов
        $a[] = array(
            'name' => 'Заказы :: Доступ по категории ::  Все категории :: Просмотр',
            'key' => 'orders-category-all-view'
        );
        $a[] = array(
            'name' => 'Заказы :: Доступ по категории ::  Все категории :: Управление',
            'key' => 'orders-category-all-change'
        );

        $categories = WorkflowService::Get()->getWorkflowsActive();
        while ($s = $categories->getNext()) {
            $a[] = array(
                'name' => 'Заказы :: Доступ по категории :: '.$s->getName().' :: Просмотр',
                'key' => 'orders-category-'.$s->getId().'-view',
            );

            $a[] = array(
                'name' => 'Заказы :: Доступ по категории :: '.$s->getName().' :: Управление',
                'key' => 'orders-category-'.$s->getId().'-change',
            );
        }
        $a[] = array(
            'name' => 'Заказы :: Доступ по категории :: Без категории :: Просмотр',
            'key' => 'orders-category-0-view'
        );
        $a[] = array(
            'name' => 'Заказы :: Доступ по категории :: Без категории :: Управление',
            'key' => 'orders-category-0-change'
        );

        // уведомления по бизнес-процессам
        /*$categories = WorkflowService::Get()->getWorkflowsActive();
        $categories->filterType('order', '!=');
        while ($s = $categories->getNext()) {
            $a[] = array(
                'name' => 'Автоматический наблюдатель :: Заказы :: '.$s->getName(),
                'key' => 'notify-order-category-'.$s->getId(),
            );
        }*/

        foreach ($a as $acl) {
            Shop::Get()->getAclService()->addACLPermission($acl['key'], $acl['name']);
        }
    }

}