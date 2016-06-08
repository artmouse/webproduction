<?php

class Box_AdminMenu implements Events_IEventObserver {

    public function notify(Events_Event $event) {
        $event;

        // добавляем пункты меню
        /*Shop_ModuleLoader::Get()->registerTopMenuItem(
        'Проекты',
        Engine::GetLinkMaker()->makeURLByContentID('project-index'),
        'issue'
        );

        Shop_ModuleLoader::Get()->registerTopMenuItem(
        'Задачи',
        Engine::GetLinkMaker()->makeURLByContentID('issue-index'),
        'issue'
        );*/

        // отчеты

        /*Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Call-центр',
            Engine::GetLinkMaker()->makeURLByContentID('callcenter-index'),
            'report-callcenter'
        );*/
       
        
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'События по датам',
            Engine::GetLinkMaker()->makeURLByContentID('report-eventdate'),
            'report-eventdate'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Затраченное время',
            Engine::GetLinkMaker()->makeURLByContentID('report-time-log'),
            'report-time-log'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Карта событий',
            Engine::GetLinkMaker()->makeURLByContentID('report-eventtree'),
            'report-eventtree'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Заказы клиентов',
            Engine::GetLinkMaker()->makeURLByContentID('report-clientorders'),
            'report-clientorder'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Заказы по датам',
            Engine::GetLinkMaker()->makeURLByContentID('report-orderdate'),
            'report-orderdate'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Этапы заказов',
            Engine::GetLinkMaker()->makeURLByContentID('report-orderstatus'),
            'report-orderstatus'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Оплаты заказов',
            Engine::GetLinkMaker()->makeURLByContentID('report-orderpayment'),
            'report-orderpayment'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Ожидаемые платежи',
            Engine::GetLinkMaker()->makeURLByContentID('report-probation-order'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Баланс клиентов',
            Engine::GetLinkMaker()->makeURLByContentID('report-clientbalance'),
            'report-clientbalance'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Источники заказов',
            Engine::GetLinkMaker()->makeURLByContentID('report-sourceorders'),
            'report-sourceorders'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Источники контактов',
            Engine::GetLinkMaker()->makeURLByContentID('report-sourceclients'),
            'report-sourceclients'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Карта рекомендаций контактов',
            Engine::GetLinkMaker()->makeURLByContentID('report-contacttree'),
            'report-contacttree'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Сравнение менеджеров',
            Engine::GetLinkMaker()->makeURLByContentID('report-managercompare'),
            'report-managercompare'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Сравнение плана заказов',
            Engine::GetLinkMaker()->makeURLByContentID('report-compareorderplan'),
            'report-compareorderplan'
        );
        
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Исполнители заказов',
            '/admin/shop/report/performersorders/',
            'report-performersorders'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Сравнение KPI план-факт',
            Engine::GetLinkMaker()->makeURLByContentID('report-comparekpi'),
            'report-comparekpi'
        );


        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Уведомления системы',
            Engine::GetLinkMaker()->makeURLByContentID('report-notify'),
            'report-notify'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Состояние проектов',
            Engine::GetLinkMaker()->makeURLByContentID('report-projectcheck'),
            'report-projectcheck'
        );

        // добавляем "отчет по рабочему времени"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Рабочее время сотрудников',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-report-worktime'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Отчет по запланированным и совершенным E-mail рассылкам',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-report-massemailsend'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Отчет по холодным контакткам за период',
            Engine::GetLinkMaker()->makeURLByContentID('report-holdusersperiod'),
            'report'
        );

        // отчет "Анализ рабочего дня"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Анализ рабочего дня',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-report-daycalendar'),
            'report'
        );

        // добавляем "конструктор отчетов"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Конструктор отчетов',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-report-designer'),
            'report'
        );

        $reports = ReportService::Get()->getReportAll();
        while ($report = $reports->getNext()) {
            Shop_ModuleLoader::Get()->registerReportMenuItem(
                $report->getName(),
                Engine::GetLinkMaker()->makeURLByContentIDParam(
                    'shop-admin-report-designer',
                    $report->getId(),
                    'report'
                )
            );
        }
        
        // отчет "Перенаправление звонков"
        Shop_ModuleLoader::Get()->registerReportMenuItem(
            'Перенаправление звонков',
            Engine::GetLinkMaker()->makeURLByContentID('shop-admin-report-callrouting'),
            'report'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Источники заказов и клиентов',
            '/admin/shop/source/',
            'settings'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Ограничения событий',
            '/admin/ignore/',
            'settings'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Настройка парсинга email',
            '/admin/imap/',
            'settings'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Формы',
            '/admin/forms/',
            'forms-settings-control'
        );

        // добавляем в верхнее меню файлы
        Shop_ModuleLoader::Get()->registerTopMenuItem(
            Shop::Get()->getTranslateService()->getTranslate('translate_fayli'),
            Engine::GetLinkMaker()->makeURLByContentID('admin-files'),
            'files',
            'icon-attach'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'KPI',
            Engine::GetLinkMaker()->makeURLByContentID('kpi-index'),
            'settings'
        );

        Shop_ModuleLoader::Get()->registerSettingMenuItem(
            'Дерево ролей',
            '/admin/role/',
            'role'
        );

        // Стандарты
        Shop_ModuleLoader::Get()->registerTopMenuItem(
            'Стандарты',
            Engine::GetLinkMaker()->makeURLByContentID('standard-tpl'),
            '',
            'icon-rule'
        );

        // добавляем пункты на основе типов workflow
        if (!Engine::Get()->getConfigFieldSecure('static-shop-menu')) {
            $workflowType = new XShopWorkflowType();
            while ($x = $workflowType->getNext()) {
                $type = $x->getType();
                if ($type == 'order') {
                    $type = 'orders';
                }
                
                Shop_ModuleLoader::Get()->registerTopMenuItem(
                    $x->getMultiplename() ? $x->getMultiplename() : $x->getName(),
                    Engine::GetLinkMaker()->makeURLByContentIDParam('custom-issue-shop-index', $x->getType(), 'type'),
                    $type,
                    $x->getIcon() ? false : 'icon-'.$x->getType(),
                    false,
                    $x->getIcon()
                );
            }
        }
    }

}