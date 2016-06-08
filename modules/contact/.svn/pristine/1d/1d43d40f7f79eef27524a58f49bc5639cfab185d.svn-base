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
class Contact_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        Shop::Get()->getAclService()->addACLPermission(
            'users',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-online',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_online')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-mass-mailing',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_mass_mailing')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-groups',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_groups')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-add',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_add')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-all-view',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_all_view')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users-all-edit',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_all_edit')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users_kpi',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_kpi')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'users_import_export',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_users_import_export')
        );

        $a = array();

        // ACL по группам контактов
        $userGroups = Shop::Get()->getUserService()->getUserGroupsAll();
        while ($group = $userGroups->getNext()) {
            $a[] = array(
                'name' => 'Контакты :: Доступ по группе :: '.$group->makeNamePath().' :: Просмотр',
                'key' => 'users-group-' . $group->getId().'-view',
            );

            $a[] = array(
                'name' => 'Контакты :: Доступ по группе :: '.$group->makeNamePath().' :: Управление',
                'key' => 'users-group-' . $group->getId().'-change',
            );
        }

        $a[] = array(
            'name' => 'Контакты :: Доступ по группе ::  Без группы :: Просмотр', // лишний пробел для сортировки
            'key' => 'users-group-0-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по группе ::  Без группы :: Управление', // лишний пробел для сортировки
            'key' => 'users-group-0-change',
        );

        // ACL по менеджерам контактов
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $a[] = array(
                'name' => 'Контакты :: Доступ по сотруднику :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                'key' => 'users-manager-'.$s->getId().'-view',
            );

            $a[] = array(
                'name' => 'Контакты :: Доступ по сотруднику :: '.$s->makeName(false, 'lmf').' :: Управление',
                'key' => 'users-manager-' . $s->getId() . '-change',
            );
        }

        $a[] = array(
            'name' => 'Контакты :: Доступ по сотруднику :: Без менеджера :: Просмотр',
            'key' => 'users-manager-0-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по сотруднику :: Без менеджера :: Управление',
            'key' => 'users-manager-0-change',
        );

        // ACL по уровню доступа к контактам
        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Заблокированные :: Просмотр',
            'key' => 'users-level-0-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Заблокированные :: Управление',
            'key' => 'users-level-0-change',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Клиенты и контакты :: Просмотр',
            'key' => 'users-level-1-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Клиенты и контакты :: Управление',
            'key' => 'users-level-1-change',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Менеджеры :: Просмотр',
            'key' => 'users-level-2-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Менеджеры :: Управление',
            'key' => 'users-level-2-change',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Администраторы :: Просмотр',
            'key' => 'users-level-3-view',
        );

        $a[] = array(
            'name' => 'Контакты :: Доступ по уровню :: Администраторы :: Управление',
            'key' => 'users-level-3-change',
        );

        $a[] = array(
            'name' => 'События',
            'key' => 'report_event',
        );

        // ACL по менеджерам контактов - чтение истории
        $managers = Shop::Get()->getUserService()->getUsersManagers();
        while ($s = $managers->getNext()) {
            $a[] = array(
                'name' => 'События :: '.$s->makeName(false, 'lmf').' :: Просмотр событий',
                'key' => 'users-manager-'.$s->getId().'-history',
            );

            $a[] = array(
                'name' => 'События :: '.$s->makeName(false, 'lmf').' :: Рейтинг событий',
                'key' => 'users-manager-'.$s->getId().'-history-rating',
            );
        }

        foreach ($a as $acl) {
            Shop::Get()->getAclService()->addACLPermission($acl['key'], $acl['name']);
        }

    }

}