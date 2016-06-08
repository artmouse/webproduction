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
class Box_ACL implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // переопределяем название основного ACL
        $workflowTypes = WorkflowService::Get()->getWorkflowTypesAll();
        $workflowTypeArray = array();
        while ($x = $workflowTypes->getNext()) {
            $type = $x->getType();

            if ($type == 'order') {
                $type = 'orders';
            }

            $workflowTypeArray[] = array(
                'type' => $type,
                'name' => $x->getMultiplename() ? $x->getMultiplename() : $x->getName()
            );
        }

        // ACL
        $a = array();

        foreach ($workflowTypeArray as $dataType) {
            Shop::Get()->getAclService()->addACLPermission(
                $dataType['type'],
                $dataType['name']
            );

            Shop::Get()->getAclService()->addACLPermission(
                $dataType['type'].'-delete',
                $dataType['name'].' :: Удаление и восстановление заказов'
            );

            // ACL по статусам
            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по статусу ::  Все статусы :: Просмотр',
                'key' => $dataType['type'].'-status-all-view',
            );

            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по статусу ::  Все статусы :: Управление',
                'key' => $dataType['type'].'-status-all-change',
            );

            $workflows = WorkflowService::Get()->getWorkflowsActive();
            $workflows->setType($dataType['type']);
            while ($w = $workflows->getNext()) {
                $status = $w->getStatuses();
                while ($s = $status->getNext()) {
                    $name =  $dataType['name'].' :: Доступ по статусу :: '.$w->getName().
                        ' :: #'.$s->getId().' / '.$s->getName().' :: Просмотр';
                    $a[] = array(
                        'name' => $name,
                        'key' => $dataType['type'].'-status-'.$s->getId().'-view',
                    );

                    $name = $dataType['name'].' :: Доступ по статусу :: '.$w->getName().
                        ' :: #'.$s->getId().' / '.$s->getName().' :: Управление';
                    $a[] = array(
                        'name' => $name,
                        'key' => $dataType['type'].'-status-' . $s->getId() . '-change',
                    );
                }
            }

            // ACL по менеджерам
            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по сотруднику ::  Все сотрудники :: Просмотр',
                'key' => $dataType['type'].'-manager-all-view',
            );

            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по сотруднику ::  Все сотрудники :: Управление',
                'key' => $dataType['type'].'-manager-all-change',
            );

            $managers = Shop::Get()->getUserService()->getUsersManagers();
            while ($s = $managers->getNext()) {
                $a[] = array(
                    'name'=> $dataType['name'].' :: Доступ по сотруднику :: '.$s->makeName(false, 'lmf').' :: Просмотр',
                    'key' => $dataType['type'].'-manager-'.$s->getId().'-view',
                );

                $a[] = array(
                    'name' => $dataType['name'].' :: Доступ по сотруднику :: '.
                    $s->makeName(false, 'lmf').' :: Управление',
                    'key' => $dataType['type'].'-manager-' . $s->getId() . '-change',
                );
            }

            // ACL по категориям
            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по бизнес-процессу ::  Все категории :: Просмотр',
                'key' => $dataType['type'].'-category-all-view'
            );
            $a[] = array(
                'name' => $dataType['name'].' :: Доступ по бизнес-процессу ::  Все категории :: Управление',
                'key' => $dataType['type'].'-category-all-change'
            );

            $categories = WorkflowService::Get()->getWorkflowsActive();
            $categories->setType($dataType['type']);
            while ($s = $categories->getNext()) {
                $a[] = array(
                    'name' => $dataType['name'].' :: Доступ по бизнес-процессу :: '.$s->getName().' :: Просмотр',
                    'key' => $dataType['type'].'-category-'.$s->getId().'-view',
                );

                $a[] = array(
                    'name' => $dataType['name'].' :: Доступ по бизнес-процессу :: '.$s->getName().' :: Управление',
                    'key' => $dataType['type'].'-category-'.$s->getId().'-change',
                );
            }

            // уведомления по бизнес-процессам
            /*$categories = WorkflowService::Get()->getWorkflowsActive();
            while ($s = $categories->getNext()) {
                $a[] = array(
                    'name' => 'Автоматический наблюдатель :: '.$dataType['name'].' :: '.$s->getName(),
                    'key' => 'notify-order-category-'.$s->getId(),
                );
            }*/
        }


        // записываем весь ACL
        foreach ($a as $acl) {
            Shop::Get()->getAclService()->addACLPermission($acl['key'], $acl['name']);
        }

        Shop::Get()->getAclService()->addACLPermission(
            'files',
            Shop::Get()->getTranslateService()->getTranslate('translate_fayli')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'employer',
            Shop::Get()->getTranslateService()->getTranslate('translate_ispolniteli')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'menu_workflow',
            'Список бизнес-процессов в меню'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'menu_create',
            'Пункт "Создать" в меню'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-clientorder',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_clientorder')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-clientbalance',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_clientbalance')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-orderdate',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_orderdate')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-orderstatus',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_orderstatus')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-orderpayment',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_orderpayment')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-sourceorders',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_sourceorders')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-sourceclients',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_sourceclients')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-time-log',
            'Отчет затраченого времени'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-managercompare',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_managercompare')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-compareorderplan',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_compareorderplan')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-eventdate',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_eventdate')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-eventtree',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_eventtree')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-utm',
            Shop::Get()->getTranslateService()->getTranslateSecure('acl_report_utm')
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-comparekpi',
            'Отчеты :: Сравнение KPI план-факт'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'report-projectcheck',
            'Отчеты :: Состояние проектов'
        );
        Shop::Get()->getAclService()->addACLPermission(
            'forms-settings-control',
            Shop::Get()->getTranslateService()->getTranslateSecure('translate_controls_forms')
        );

        Shop::Get()->getAclService()->addACLPermission(
            'control-standard',
            'Настройки :: Управление стандартами'
        );
        
        Shop::Get()->getAclService()->addACLPermission(
            'report-performersorders',
            'Отчеты :: Исполнители заказов'
        );

    }

}